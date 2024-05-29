<?php

// Turn on error reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Autoload dependencies
require_once 'vendor/autoload.php';

// Include data layer and validation files if needed
require_once 'model/data-layer.php';
require_once 'model/validate.php';

// Instantiate the F3 Base class
$f3 = Base::instance();

// Define a default route
$f3->route('GET /', function() {
    $view = new Template();
    echo $view->render('views/index.html');
});

// Home route
$f3->route('GET /home', function() {
    $view = new Template();
    echo $view->render('views/index.html');
});

// Route to menu page
$f3->route('GET /menu', function() {
    $view = new Template();
    echo $view->render('views/menu.html');
});

// Route to summary page
$f3->route('GET /orderSummary', function() {
    $view = new Template();
    echo $view->render('views/orderSummary.html');
});

// Route to contact page
$f3->route('GET /contact', function() {
    $view = new Template();
    echo $view->render('views/contact.html');
});


// route to user page
$f3->route('GET /user', function() {
    // Render a view page
    $view = new Template();
    echo $view->render('views/user.html');
});

// route to user page
$f3->route('GET /cart', function() {
    // Render a view page
    $view = new Template();
    echo $view->render('views/cart.html');
});

$f3->run();

// Run the F3 framework
$f3->run();

