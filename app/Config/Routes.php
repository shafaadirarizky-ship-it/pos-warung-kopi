<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */
$routes->get('/', 'Pos::index');
$routes->post('pos/checkout', 'Pos::checkout');
$routes->get('pos/receipt/(:num)', 'Pos::receipt/$1');
$routes->get('pos/ingredients', 'Pos::getIngredients');
$routes->post('pos/reset-table/(:num)', 'Pos::resetTable/$1');
