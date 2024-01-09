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
    }

    public function authenticate()
    {
    }
}
