<?php
// Turn on error reporting
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Require the autoload file
require_once('vendor/autoload.php');
require_once('model/data-layer.php');
require_once('model/validate.php');

// Instantiate the F3 Base class
$f3 = Base::instance();

// Define a default route
$f3->route('GET /', function() {
    // Render a view page
    $view = new Template();
    echo $view->render('views/index.html');
});

// Home route
$f3->route('GET /home', function() {
    // Render a view page
    $view = new Template();
    echo $view->render('views/index.html');
});

// Route to menu page
$f3->route('GET /menu', function($f3) {
    $menuItems = getMenuItems(); // Assuming getMenuItems() is a function in data-layer.php
    $f3->set('menuItems', $menuItems);

    // Render a view page
    $view = new Template();
    echo $view->render('views/menu.html');
});

// Route to summary page
$f3->route('GET /orderSummary', function() {
    // Render a view page
    $view = new Template();
    echo $view->render('views/orderSummary.html');
});

$f3->run();
