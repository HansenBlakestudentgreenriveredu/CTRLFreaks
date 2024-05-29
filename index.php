<?php

// Turn on error reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Autoload dependencies
require_once 'vendor/autoload.php';

// Include data layer and validation files
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
$f3->route('GET /menu', function($f3) {
    $f3->set('menuItems.breakfast', getBreakfastItems());
    $f3->set('menuItems.lunch', getLunchItems());
    $f3->set('menuItems.dinner', getDinnerItems());
    $f3->set('menuItems.sides', getSides());
    $f3->set('menuItems.beverages', getBeverages());

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

// Route to user page
$f3->route('GET /user', function() {
    $view = new Template();
    echo $view->render('views/user.html');
});

// Route to cart page
$f3->route('GET /cart', function() {
    $view = new Template();
    echo $view->render('views/cart.html');
});

// Run the F3 framework
$f3->run();
?>
