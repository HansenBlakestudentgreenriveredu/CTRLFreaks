<?php

// Turn on error reporting
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Require the autoload file
require_once ('vendor/autoload.php');
require_once ('model/data-layer.php');
require_once ('model/validate.php');

// Instantiate the F3 Base class
$f3 = Base::instance();

// Define a default route
$f3->route('GET /', function() {
    // Render a view page
    $view = new Template();
    echo $view->render('views/index.html');
});
// home route
$f3->route('GET /home', function() {
    // Render a view page
    $view = new Template();
    echo $view->render('views/index.html');
});

// route to menu page
$f3->route('GET /menu', function() {
    // Render a view page
    $view = new Template();
    echo $view->render('views/menu.html');
});

// route to summary page
$f3->route('GET /orderSummary', function() {
    // Render a view page
    $view = new Template();
    echo $view->render('views/orderSummary.html');
});

$f3->run();