<?php

// File: index.php
// Author: Vlad, Blake, Tilak
// Description: index.php file for the CTRL freaks page

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
$dataLayer = new DataLayer();

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
$f3->route('GET|POST /contact', function($f3) {
    $GLOBALS['con']->contact($f3);
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

$f3->route('GET|POST /applyDiscount', function($f3) {
    $GLOBALS['con']->applyDiscount($f3);
});

$f3->route('GET|POST /removeDiscount', function($f3) {
    $GLOBALS['con']->removeDiscount($f3);
});

$f3->route('GET|POST /addToCart', function($f3) {
    $GLOBALS['con']->addToCart($f3);
});

// Route to cart page
$f3->route('GET|POST /cart', function($f3) {
    $GLOBALS['con']->cart($f3);
});

// Route to offers receipt page
$f3->route('GET|POST /offers', function($f3) {
    $GLOBALS['con']->offers($f3);
});

// Route to admin page
$f3->route('GET|POST /admin', function($f3) {
    $GLOBALS['con']->admin($f3);
});


// Route to the email receipt page
$f3->route('POST /send-email', function($f3) {
    $subject = $f3->get('POST.subject');
    $message = $f3->get('POST.message');

    $emails = $GLOBALS['dataLayer']->getEmails();

    foreach ($emails as $email) {
        mail($email['email'], $subject, $message, 'From: admin@example.com');
    }


    $GLOBALS['con']->admin($f3);
});


// Route to contact-summary
$f3->route('GET|POST /contact-summary', function($f3) {
    $GLOBALS['con']->contactSummary($f3);
});

// Route to login page
$f3->route('GET|POST /login', function($f3) {
    $GLOBALS['con']->login($f3);
});

// Route to logout
$f3->route('GET /logout', function($f3) {
    $GLOBALS['con']->logout($f3);
});

$f3->route('GET|POST /register', function($f3) {
    $GLOBALS['con']->register($f3);
});

// Run the F3 framework
$f3->run();
?>