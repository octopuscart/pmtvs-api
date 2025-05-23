<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->post('api/create-member', 'Api::createMember');
$routes->get('create-member', 'Api::showCreateMemberForm');
