<?php

namespace App\Controllers;

use Error;
use Framework\Database;
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
        $listings = $this->db->query('SELECT * FROM listings')->fetchAll();


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

        $newListingData['user_id'] = 1;

        $newListingData = array_map('sanitize', $newListingData);

        inspectAndDie($newListingData);
    }
}
