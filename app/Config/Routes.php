<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */
$routes->get('/', 'Home::index');
$routes->post('login', 'UsersController::loginUser');
// $routes->get('login', 'UsersController::loginView');
$routes->get('logout', 'UsersController::logoutSession');
$routes->group('', ['filter' => 'auth'], function($routes) {
	$routes->get('admin/dashboard', 'Home::Admin');
    $routes->get('admin/index', 'UsersController::index');

    // products

	$routes->get('admin/products', 'Products::Product_page');
	$routes->get('admin/products/fetch', 'Products::fetchProducts');
	$routes->get('admin/category/fetch', 'Products::fetchProductCat');
	$routes->post('admin/products/create', 'Products::CreateNewProduct');
	$routes->post('admin/delete/product', 'Products::deleteProduct');
	$routes->get('admin/product/edit/(:num)', 'Products::editProdView/$1');
	$routes->get('admin/product/update/(:num)', 'Products::updateProdView/$1');
	$routes->post('upload/upload', 'Products::upload'); // Add this line.
	$routes->post('admin/product/update', 'Products::updateProductsinfo');
	$routes->post('admin/products/get-product-barcode', 'Products::GetProductBarcode');

	// products end

	$routes->get('admin/users', 'UsersController::index');
	$routes->get('admin/users/fetch', 'UsersController::UsersFetch');
	$routes->post('admin/users/create', 'UsersController::CreateNewUsers');

	// end of users

	// category
	$routes->get('admin/category', 'CategoryController::index');
	$routes->get('admin/category/fetch', 'CategoryController::fetchCategory');
	$routes->post('admin/category/create', 'CategoryController::createNewCategory');
	$routes->post('admin/category/update', 'CategoryController::updateCategory');

	// pos terminal
	$routes->get('admin/pos_terminal', 'CashierScreenController::index');
	$routes->get('admin/pos/fetch', 'CashierScreenController::getProductItems');
	$routes->get('admin/pos/cart', 'CashierScreenController::fetchCartItems');
	$routes->post('admin/post/getbarcodeItem', 'CashierScreenController::getBarcode');
	$routes->get('admin/pos/totalamount', 'CashierScreenController::TotalCartAMount');
	$routes->post('admin/pos/deleteCartitem', 'CashierScreenController::removeItemfromCart');
	$routes->post('admin/pos/clickadd', 'CashierScreenController::addtocartClick');
	$routes->post('admin/pos/updateqty', 'CashierScreenController::updateQuantity');
	$routes->post('admin/pos/inserOrderItems', 'CashierScreenController::checkout');

});