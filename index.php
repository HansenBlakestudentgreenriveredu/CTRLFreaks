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
$dataLayer = new DataLayer();


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
    $GLOBALS['con']->menu();
});

// Route to summary page
$f3->route('GET /orderSummary', function() {
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

// Route to cart page
$f3->route('GET|POST /cart', function() {
    $GLOBALS['con']->cart();
});

$f3->route('GET|POST /offers', function($f3) {
    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        $email = "";
        if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            $f3 -> set('errors["email"]', 'Please enter a correct email');
        } else {
            $email = $_POST['email'];
            $f3->set('SESSION.email', $email);

            $GLOBALS['dataLayer']->saveEmailToDatabase($email);
        }

        $GLOBALS['con']->offers();
        session_destroy();
    }
});

// Run the F3 framework
$f3->run();
?>
