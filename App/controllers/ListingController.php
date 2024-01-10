<?php

namespace App\Controllers;

use Error;
use Framework\Database;
use Framework\Session;
use Framework\Validation;


class ListingController
{
    protected $db;

    public function __construct()
    {

        $config = require basePath('config/db.php');
        $this->db = new Database($config);
    }
    public function index()
    {
        $listings = $this->db->query('SELECT * FROM listings ORDER BY created_at DESC')->fetchAll();


        loadView('listings/index', [
            'listings' => $listings
        ]);
    }

    public function create()
    {
        loadView('listings/create');
    }

    public function show($params)
    {
        $id = $params['id'] ?? '';

        $params = [
            'id' => $id
        ];
        $listing = $this->db->query('SELECT * FROM listings WHERE id = :id', $params)->fetch();

        if (!$listing) {
            ErrorController::notFound('Listing not found');
            return;
        }

        loadView('listings/show', [
            'listing' => $listing
        ]);
    }

    public function store()
    {
        $allowedFields = [
            'title',
            'description',
            'salary',
            'requirements',
            'benefits',
            'company',
            'address',
            'city',
            'state',
            'phone',
            'email'
        ];

        $newListingData = array_intersect_key($_POST, array_flip($allowedFields));

        $newListingData['user_id'] = Session::get('user')['id'];

        $newListingData = array_map('sanitize', $newListingData);


        $requiredFields = [
            'title',
            'description',
            'city',
            'state',
            'email'
        ];

        $errors = [];

        if (!empty($newListingData['salary']) && !Validation::validateNumber($newListingData['salary'])) {
            $errors['salary'] = 'Salary must be a number';
        }

        if (!empty($newListingData['phone']) && !Validation::validatePhoneNumber($newListingData['phone'])) {
            $errors['phone'] = 'Phone number is invalid';
        }

        if (!empty($newListingData['email']) && !Validation::validateEmail($newListingData['email'])) {
            $errors['email'] = 'Email is invalid';
        }

        foreach ($requiredFields as $field) {
            if (empty($newListingData[$field]) || !Validation::validateString($newListingData[$field])) {
                $errors[$field] = ucfirst($field) . ' is required';
            }
        }

        if (!empty($errors)) {
            loadView('listings/create', [
                'errors' => $errors,
                'listing' => $newListingData
            ]);
            return;
        } else {

            $fields = [];
            $placeHolders = [];
            foreach ($newListingData as $key => $value) {
                if ($value === '') {
                    $newListingData[$key] = null;
                }
                $fields[] = $key;
                $placeHolders[] = ':' . $key;
            }

            $placeHolders = implode(', ', $placeHolders);
            $fields = implode(', ', $fields);

            $query = "INSERT INTO listings ({$fields}) VALUES ({$placeHolders})";

            $this->db->query($query, $newListingData);

            redirect('/listings');
        }
    }

    function destroy($params)
    {
        $id = $params['id'] ?? '';

        $params = [
            'id' => $id
        ];

        $listing = $this->db->query('SELECT * FROM listings WHERE id = :id', $params)->fetch();

        if (!$listing) {
            ErrorController::notFound('Listing not found');
            return;
        }

        if ($listing['user_id'] !== Session::get('user')['id']) {
            ErrorController::unauthorized('You are not authorized to delete this listing');
            return;
        }

        $this->db->query('DELETE FROM listings WHERE id = :id', $params);

        // Set flash message
        $_SESSION['success_message'] = 'Listing deleted successfully';

        redirect('/listings');
    }

    public function edit($params)
    {
        $id = $params['id'] ?? '';

        $params = [
            'id' => $id
        ];
        $listing = $this->db->query('SELECT * FROM listings WHERE id = :id', $params)->fetch();

        if (!$listing) {
            ErrorController::notFound('Listing not found');
            return;
        }

        if ($listing['user_id'] !== Session::get('user')['id']) {
            ErrorController::unauthorized('You are not authorized to edit this listing');
            return;
        }

        loadView('listings/edit', [
            'listing' => $listing
        ]);
    }

    public function update($params)
    {
        $id = $params['id'] ?? '';

        $params = [
            'id' => $id
        ];
        $listing = $this->db->query('SELECT * FROM listings WHERE id = :id', $params)->fetch();

        if (!$listing) {
            ErrorController::notFound('Listing not found');
            return;
        }

        if ($listing['user_id'] !== Session::get('user')['id']) {
            ErrorController::unauthorized('You are not authorized to edit this listing');
            return;
        }

        $allowedFields = [
            'title',
            'description',
            'salary',
            'requirements',
            'benefits',
            'company',
            'address',
            'city',
            'state',
            'phone',
            'email'
        ];

        $updatedValues = array_intersect_key($_POST, array_flip($allowedFields));

        $updatedValues['user_id'] = Session::get('user')['id'];
        $updatedValues['id'] = $id;

        $updatedValues = array_map('sanitize', $updatedValues);

        $requiredFields = [
            'title',
            'description',
            'city',
            'state',
            'email'
        ];

        $errors = [];

        foreach ($requiredFields as $field) {
            if (empty($updatedValues[$field]) || !Validation::validateString($updatedValues[$field])) {
                $errors[$field] = ucfirst($field) . ' is required';
            }
        }

        if (!empty($updatedValues['salary']) && !Validation::validateNumber($updatedValues['salary'])) {
            $errors['salary'] = 'Salary must be a number';
        }

        if (!empty($updatedValues['phone']) && !Validation::validatePhoneNumber($updatedValues['phone'])) {
            $errors['phone'] = 'Phone number is invalid';
        }

        if (!empty($errors)) {
            loadView('listings/edit', [
                'errors' => $errors,
                'listing' => $updatedValues
            ]);
            return;
        } else {

            $fields = [];
            foreach ($updatedValues as $key => $value) {
                $fields[] = "" . $key . " = :" . $key;
            }

            $fields = implode(', ', $fields);

            $query = "UPDATE listings SET $fields WHERE id = :id";


            $this->db->query($query, $updatedValues);

            // Set flash message
            $_SESSION['success_message'] = 'Listing updated successfully';

            redirect('/listings/' . $id);
        }
    }

    public function search()
    {
        $keywords = $_GET['keywords'] ?? '';
        $location = $_GET['location'] ?? '';

        $keywords = sanitize($keywords);
        $location = sanitize($location);

        $params = [
            'keywords' => '%' . $keywords . '%',
            'location' => '%' . $location . '%'
        ];

        $queryBase = 'SELECT * FROM listings WHERE ';
        $queryKeywords = '(title LIKE :keywords OR description LIKE :keywords OR requirements LIKE :keywords OR benefits LIKE :keywords OR company LIKE :keywords OR tags LIKE :keywords)';
        $queryLocation = '(city LIKE :location OR state LIKE :location)';

        if ($keywords && $location) {
            $query = $queryBase . $queryKeywords . ' AND ' . $queryLocation;
        } else if ($keywords) {
            $query = $queryBase . $queryKeywords;
        } else if ($location) {
            $query = $queryBase . $queryLocation;
        } else {
            redirect('/');
            return;
        }

        $listings = $this->db->query($query, $params)->fetchAll();

        // inspectAndDie($listings);
        loadView('listings/index', [
            'listings' => $listings,
            'keywords' => $keywords,
            'location' => $location
        ]);
    }
}
