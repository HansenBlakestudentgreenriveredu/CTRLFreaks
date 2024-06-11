<?php

require_once 'model/data-layer.php';
require_once 'model/validate.php';

/**
 * Class Controller
 *
 * This class handles the control flow of the application.
 */
class Controller
{
    private $_f3;

    public function __construct($f3)
    {
        $this->_f3 = $f3;
        session_start();

        // Initialize cart in session if not already set
        if (!isset($_SESSION['cartItem'])) {
            $_SESSION['cartItem'] = [];
        }
    }

    public function home()
    {
        $view = new Template();
        echo $view->render('views/index.html');
    }

    public function menu()
    {
        // Count the number of items in the cart
        $cartCount = count($_SESSION['cartItem']);

        // Pass the cart count to the view
        $this->_f3->set('cartCount', $cartCount);

        $this->_f3->set('menuItems.breakfast', getBreakfastItems());
        $this->_f3->set('menuItems.lunch', getLunchItems());
        $this->_f3->set('menuItems.dinner', getDinnerItems());
        $this->_f3->set('menuItems.sides', getSides());
        $this->_f3->set('menuItems.beverages', getBeverages());

        // Render the menu view
        $view = new Template();
        echo $view->render('views/menu.html');

    }

    public function orderSummary()
    {
        $view = new Template();
        echo $view->render('views/orderSummary.html');
    }

    public function contact()
    {
        $view = new Template();
        echo $view->render('views/contact.html');
    }

    public function user()
    {
        $view = new Template();
        echo $view->render('views/user.html');
    }

    private function calculateSubtotal($cartItems)
    {
        $subtotal = 0;
        foreach ($cartItems as $item) {
            $subtotal += $item['price'];
        }
        return round($subtotal, 2);
    }

    // Calculate tax based on subtotal
    private function calculateTax($cartItems)
    {
        // Assuming tax rate is 10% (0.10)
        $taxRate = 0.10;
        $subtotal = $this->calculateSubtotal($cartItems);
        $tax = $subtotal * $taxRate;
        return round($tax, 3);
    }
    public function removeItem($f3, $params)
    {
        $itemId = $params['id'];
        if (isset($_SESSION['cartItem'])) {
            foreach ($_SESSION['cartItem'] as $key => $item) {
                if ($item['itemId'] == $itemId) {
                    unset($_SESSION['cartItem'][$key]);
                    break;
                }
            }
            $_SESSION['cartItem'] = array_values($_SESSION['cartItem']); // Re-index array
        }
        $f3->reroute('/cart');
    }

    public function clearCart($f3)
    {
        unset($_SESSION['cartItem']);
        $f3->reroute('/cart');
    }


    public function addToCart($f3)
    {
        // Check if 'id' parameter is present in the GET request and is not empty
        if (isset($_GET['id']) && !empty($_GET['id'])) {
            $itemId = $_GET['id'];

            // Get item details by ID
            $item = $this->getItemDetailsById($itemId);
            if ($item) {
                // Add the item to the cart
                $_SESSION['cartItem'][] = $item;

                $f3->reroute('/menu');

            } else {
                echo '<p>Product not found.</p>';
            }

        } else {
            // Handle the case where 'id' is not present in the GET request or is empty
            echo '<p>Product ID is missing or empty. Unable to add to the cart.</p>';
        }

        // Render the add to cart view (if needed)
        $view = new Template();
        echo $view->render('views/addToCart.php');
    }

    public function cart()
    {
        // Retrieve cart items from session
        $cartItems = isset($_SESSION['cartItem']) ? $_SESSION['cartItem'] : [];

        // Calculate subtotal, tax, and total
        $subtotal = $this->calculateSubtotal($cartItems);
        $tax = $this->calculateTax($cartItems);
        $total = round($subtotal + $tax, 2);

        // Pass data to the view
        $this->_f3->set('cartItems', $cartItems);
        $this->_f3->set('subtotal', $subtotal);
        $this->_f3->set('tax', $tax);
        $this->_f3->set('total', $total);

//        var_dump($_SESSION); // Debugging line to print the session array

        // Render the cart view
        $view = new Template();
        echo $view->render('views/cart.html');
    }

    function getItemDetailsById($itemId)
    {
        // First, check breakfast items
        $breakfastItems = getBreakfastItems();
        foreach ($breakfastItems as $item) {
            if ($item['itemId'] == $itemId) {
                return $item;
            }
        }

        // Then, check lunch items
        $lunchItems = getLunchItems();
        foreach ($lunchItems as $item) {
            if ($item['itemId'] == $itemId) {
                return $item;
            }
        }

        // Then, check dinner items
        $dinnerItems = getDinnerItems();
        foreach ($dinnerItems as $item) {
            if ($item['itemId'] == $itemId) {
                return $item;
            }
        }

        // Then, check sides
        $sides = getSides();
        foreach ($sides as $item) {
            if ($item['itemId'] == $itemId) {
                return $item;
            }
        }

        // Finally, check beverages
        $beverages = getBeverages();
        foreach ($beverages as $item) {
            if ($item['itemId'] == $itemId) {
                return $item;
            }
        }

        // If item not found, return null
        return null;
    }


    public function offers($f3)
    {
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            $email = "";
            if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
                $f3 -> set('errors["email"]', 'Please enter a correct email');
            } else {
                $email = $_POST['email'];
                $f3->set('email', $email);

                $GLOBALS['dataLayer']->saveEmailToDatabase($email);
                session_destroy();
            }
        }

        $view = new Template();
        echo $view->render('views/offers.html');
    }

    public function admin() {
        $view = new Template();
        echo $view->render('views/admin.html');
    }

    public function contactSummary() {
        $view = new Template();
        echo $view->render('views/contact-summary.html');
    }
}