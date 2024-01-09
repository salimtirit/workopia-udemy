<?php

namespace App\Controllers;

use Framework\Database;
use Framework\Validation;


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

        // TODO: check if email already exists
    }

    public function authenticate()
    {
    }
}
