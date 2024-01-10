<?php

namespace App\Controllers;

use Framework\Database;
use Framework\Validation;
use Framework\Session;


class AuthController
{
    protected $db;

    public function __construct()
    {

        $config = require basePath('config/db.php');
        $this->db = new Database($config);
    }

    public function register()
    {
        loadView('auth/register');
    }

    public function login()
    {
        loadView('auth/login');
    }

    public function store()
    {
        $errors = [];
        if (!Validation::validateEmail($_POST['email'])) {
            $errors['email'] = 'Email is invalid';
        }

        $passwordValidationMessage = Validation::validatePassword($_POST['password']);
        if ($passwordValidationMessage !== true) {
            $errors['password'] = $passwordValidationMessage;
        }

        if (!Validation::validateMatch($_POST['password'], $_POST['password_confirmation'])) {
            $errors['password_confirmation'] = 'Passwords do not match';
        }

        foreach ($_POST as $key => $value) {
            if (empty($value) || !Validation::validateString($_POST[$key])) {
                if ($key === 'city' || $key === 'state') {
                    continue;
                }
                $errors[$key] = ucfirst(str_replace('_', ' ', $key)) . ' is required';
            }
        }

        if (!empty($errors)) {
            loadView('auth/register', [
                'errors' => $errors,
                'user' => $_POST
            ]);
            return;
        }

        $params = [
            'email' => $_POST['email'],
        ];

        $user = $this->db->query('SELECT * FROM users WHERE email = :email', $params)->fetch();

        if ($user) {
            $errors['email'] = 'Email already exists';
            loadView('auth/register', [
                'errors' => $errors,
                'user' => $_POST
            ]);
            return;
        }

        $params = [
            'name' => $_POST['name'],
            'email' => $_POST['email'],
            'city' => $_POST['city'] === '' ? NULL : $_POST['city'],
            'state' => $_POST['state'] === '' ?  NULL : $_POST['state'],
            'password' => password_hash($_POST['password'], PASSWORD_DEFAULT)
        ];
        $query = 'INSERT INTO users (name, city, state, email, password) VALUES (:name, :city, :state, :email, :password)';
        $this->db->query($query, $params);

        // Get the new user id
        $userId = $this->db->conn->lastInsertId();

        Session::set('user', [
            'id' =>   $userId,
            'name' => $_POST['name'],
            'email' => $_POST['email'],
            'city' => $_POST['city'],
            'state' => $_POST['state']
        ]);

        redirect('/');
    }

    public function authenticate()
    {
        $errors = [];

        $email = $_POST['email'];
        $password = $_POST['password'];

        if (!Validation::validateString($email)) {
            $errors['email'] = 'Email is required';
        }

        if (!empty($errors)) {
            loadView('auth/login', [
                'errors' => $errors,
                'user' => $_POST
            ]);
            return;
        }

        if (!Validation::validateEmail($email)) {
            $errors['email'] = 'Email is invalid';
        }

        if (!Validation::validateString($password)) {
            $errors['password'] = 'Password is required';
        }

        if (!empty($errors)) {
            loadView('auth/login', [
                'errors' => $errors,
                'user' => $_POST
            ]);
            return;
        }

        $params = [
            'email' => $email
        ];

        $user = $this->db->query('SELECT * FROM users WHERE email = :email', $params)->fetch();
        if (!$user) {
            $errors['email'] = 'Email does not exist';
            loadView('auth/login', [
                'errors' => $errors,
                'user' => $_POST
            ]);
            return;
        }

        if (!password_verify($password, $user['password'])) {
            $errors['password'] = 'Password is incorrect';
            loadView('auth/login', [
                'errors' => $errors,
                'user' => $_POST
            ]);
            return;
        }

        Session::set('user', [
            'id' =>   $user['id'],
            'name' => $user['name'],
            'email' => $user['email'],
            'city' => $user['city'],
            'state' => $user['state']
        ]);

        redirect('/');
    }

    public function logout()
    {
        Session::destroy();

        $params = session_get_cookie_params();

        setcookie(
            'PHPSESSID',
            '',
            time() - 86400,
            $params['path'],
            $params['domain']
        );

        redirect('/');
    }
}
