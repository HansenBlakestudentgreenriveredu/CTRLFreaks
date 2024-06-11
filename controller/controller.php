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
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }
    }

    public function home()
    {
        $view = new Template();
        echo $view->render('views/index.html');
    }

    public function menu()
    {
        $this->_f3->set('menuItems.breakfast', getBreakfastItems());
        $this->_f3->set('menuItems.lunch', getLunchItems());
        $this->_f3->set('menuItems.dinner', getDinnerItems());
        $this->_f3->set('menuItems.sides', getSides());
        $this->_f3->set('menuItems.beverages', getBeverages());

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
        return $subtotal;
    }

    // Calculate tax based on subtotal
    private function calculateTax($cartItems)
    {
        // Assuming tax rate is 10% (0.10)
        $taxRate = 0.10;
        $subtotal = $this->calculateSubtotal($cartItems);
        $tax = $subtotal * $taxRate;
        return $tax;
    }


        public function cart()
    {
        // Assuming you have already retrieved cart items
        $cartItems = $_SESSION['cart'];

        // Calculate subtotal, tax, and total
        $subtotal = $this->calculateSubtotal($cartItems);
        $tax = $this->calculateTax($cartItems);
        $total = $subtotal + $tax;

        // Pass data to the view
        $this->_f3->set('cartItems', $cartItems);
        $this->_f3->set('subtotal', $subtotal);
        $this->_f3->set('tax', $tax);
        $this->_f3->set('total', $total);

        // Render the cart view
        $view = new Template();
        echo $view->render('views/cart.html');
    }

    public function offers()
    {
        $view = new Template();
        echo $view->render('views/offers.html');
    }


}
