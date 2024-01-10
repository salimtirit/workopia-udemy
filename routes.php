<?php

$router->get('/', 'HomeController@index');
$router->get('/listings', 'ListingController@index');
$router->get('/listings/create', 'ListingController@create', ['user']);
$router->get('/listings/edit/{id}', 'ListingController@edit', ['user']);
$router->get('/listings/search', 'ListingController@search');
$router->get('/listings/{id}', 'ListingController@show');
$router->post('/listings', 'ListingController@store', ['user']);
$router->put('/listings/{id}', 'ListingController@update', ['user']);
$router->delete('/listings/{id}', 'ListingController@destroy', ['user']);
$router->get('/auth/register', 'AuthController@register', ['guest']);
$router->post('/auth/register', 'AuthController@store', ['guest']);
$router->get('/auth/login', 'AuthController@login', ['guest']);
$router->post('/auth/login', 'AuthController@authenticate', ['guest']);
$router->post('/auth/logout', 'AuthController@logout', ['user']);
