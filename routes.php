<?php

$router->get('/', 'HomeController@index');
$router->get('/listings', 'ListingController@index');
$router->get('/listings/create', 'ListingController@create');
$router->get('/listings/edit/{id}', 'ListingController@edit');
$router->get('/listings/{id}', 'ListingController@show');
$router->post('/listings', 'ListingController@store');
$router->put('/listings/{id}', 'ListingController@update');
$router->delete('/listings/{id}', 'ListingController@destroy');
$router->get('/auth/register', 'AuthController@register');
$router->post('/auth/register', 'AuthController@store');
$router->get('/auth/login', 'AuthController@login');
$router->post('/auth/login', 'AuthController@authenticate');
