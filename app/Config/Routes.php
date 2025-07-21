<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
// position categories routes
$routes->get('/', 'Home::index');
$routes->get('position-categories', 'Service\PositionCategory::index');
$routes->post('position-categories/add', 'Service\PositionCategory::add');
$routes->post('position-categories/update-order', 'Service\PositionCategory::updateOrder');
$routes->post('position-categories/inline-edit', 'Service\PositionCategory::inlineEdit');

//Member update and creation routes
$routes->get('create-member', 'Service\Members::showUpdateMemberForm');
$routes->get('update-member/(:num)', 'Service\Members::showUpdateMemberForm/$1');


// Member management routes
$routes->get('list-post', 'Service\DailyPost::listPosts');
$routes->get('create-post', 'Service\DailyPost::showUpdatePostForm');
$routes->get('update-post/(:num)', 'Service\DailyPost::showUpdatePostForm/$1');
$routes->get('upload-bill-doc', 'Service\DailyPost::showUploadBillDocForm');
$routes->get('list-docs', 'Service\DailyPost::listDocs');

//API routes
$routes->get('api/members/(:num)', 'Api::membersListApi/$1');
$routes->get('api/positions', 'Api::getPositions');
$routes->get('api/position-categories', 'Api::getPositionCategories');
$routes->get('api/list-daily-posts', 'Api::listDailyPosts');
$routes->get('api/list-documents', 'Api::listDocuments');
$routes->post('api/create-member', 'Api::createMember');
$routes->post('api/upload-image', 'Api::uploadImage');
$routes->post('api/create-daily-post', 'Api::createDailyPost');
$routes->post('api/delete-member', 'Api::deleteMember');
$routes->post('api/upload-bill-doc', 'Api::uploadBillDoc');

//Authentication routes
$routes->get('login', 'Auth::login');
$routes->match(['get', 'post'], 'login', 'Auth::login');
$routes->get('logout', 'Auth::logout');