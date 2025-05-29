<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('position-categories', 'Service\PositionCategory::index');
$routes->post('position-categories/add', 'Service\PositionCategory::add');
$routes->post('position-categories/update-order', 'Service\PositionCategory::updateOrder');
$routes->post('position-categories/inline-edit', 'Service\PositionCategory::inlineEdit');

$routes->get('create-member', 'Service\Members::showUpdateMemberForm');
$routes->get('update-member/(:num)', 'Service\Members::showUpdateMemberForm/$1');

$routes->post('api/create-member', 'Api::createMember');
$routes->post('api/upload-image', 'Api::uploadImage');
$routes->get('api/members/(:num)', 'Api::membersListApi/$1');
$routes->get('api/positions', 'Api::getPositions');
$routes->get('api/position-categories', 'Api::getPositionCategories');