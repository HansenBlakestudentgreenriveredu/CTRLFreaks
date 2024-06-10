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
require_once 'controller/controller.php';

// Instantiate the F3 Base class
$f3 = Base::instance();
$con = new Controller($f3);


// Define a default route
$f3->route('GET /', function() {
    $view = new Template();
    echo $view->render('views/index.html');
});

// Home route
$f3->route('GET /home', function() {
    $GLOBALS['con']->home();
});

// Route to menu page
$f3->route('GET|POST /menu', function($f3) {
    $GLOBALS['con']->menu($f3);
});

// Route to summary page
$f3->route('GET /orderSummary', function($f3) {
    $GLOBALS['con']->orderSummary();
});

// Route to contact page
$f3->route('GET /contact', function() {
    $GLOBALS['con']->contact();
});

// Route to user page
$f3->route('GET /user', function() {
    $GLOBALS['con']->user();
});

$f3->route('GET /removeItem/@id', function($f3, $params) {
    $GLOBALS['con']->removeItem($f3, $params);
});

$f3->route('GET /clearCart', function($f3) {
    $GLOBALS['con']->clearCart($f3);
});

$f3->route('GET|POST /addToCart', function($f3) {
    $GLOBALS['con']->addToCart($f3);
});

// Route to cart page
$f3->route('GET|POST /cart', function($f3) {
    $GLOBALS['con']->cart($f3);
});


// Run the F3 framework
$f3->run();
?>
