<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */
$routes->get('/', 'Books::index_redirect');
$routes->get('/books', 'Books::index');

$routes->get('/books/add/', 'Books::addBook');
$routes->post('/books/add/', 'Books::add');

$routes->get('/books/edit/(:num)', 'Books::editBook/$1');
$routes->post('/books/edit/(:num)', 'Books::edit/$1');

$routes->post('/books/delete/(:num)', 'Books::delete/$1');
