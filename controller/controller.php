<?php

require_once 'model/data-layer.php';
require_once 'model/validate.php';
require_once 'classes/pricing.php';
require_once 'classes/lookupItems.php';

// Define constants


/**
 * Class Controller
 *
 * This class handles the control flow of the application.
 */
class Controller
{
    private $_f3;

    /**
     * Controller constructor.
     *
     * @param \Base $f3 Fat-Free Framework instance
     */
    public function __construct($f3)
    {
        $this->_f3 = $f3;
        session_start();

        // Initialize cart in session if not already set
        if (!isset($_SESSION['cartItem'])) {
            $_SESSION['cartItem'] = [];
        }
    }

    /**
     * Display the home page.
     */
    public function home()
    {

        $view = new Template();
        echo $view->render('views/index.html');
    }

    /**
     * Display the menu page.
     */
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

    /**
     * Display the order summary page.
     */
    public function orderSummary()
    {
        $view = new Template();
        echo $view->render('views/orderSummary.html');
    }

    /**
     * Display the contact page.
     */
    public function contact()
    {
        $view = new Template();
        echo $view->render('views/contact.html');
    }

    /**
     * Display the user page.
     */
    public function user()
    {
        $view = new Template();
        echo $view->render('views/user.html');
    }

    /**
     * Remove an item from the cart.
     *
     * @param \Base $f3 Fat-Free Framework instance
     * @param array $params Route parameters
     */
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

    /**
     * Clear the cart.
     *
     * @param \Base $f3 Fat-Free Framework instance
     */
    public function clearCart($f3)
    {
        unset($_SESSION['cartItem']);
        $f3->reroute('/cart');
    }

    /**
     * Add an item to the cart.
     *
     * @param \Base $f3 Fat-Free Framework instance
     */
    public function addToCart($f3)
    {
        // Check if 'id' parameter is present in the GET request and is not empty
        if (isset($_GET['id']) && !empty($_GET['id'])) {
            $itemId = $_GET['id'];

            // Sanitize and validate the itemId
            $sanitizedItemId = validateAndSanitize($itemId);

            // Validate the itemId
            if (!validItemId($sanitizedItemId)) {
                echo getErrorMessage('Product ID', 'Invalid product ID.');
                return;
            }

            // Get item details by ID
            $item = getItemDetailsById($sanitizedItemId);
            if ($item) {
                // Validate the item's price
                if (!validPrice($item['price'])) {
                    echo getErrorMessage('Price', 'Invalid price.');
                    return;
                }

                // Add the item to the cart
                $_SESSION['cartItem'][] = $item;

                $f3->reroute('/menu');
            } else {
                echo getErrorMessage('Product', 'Product not found.');
            }
        } else {
            // Handle the case where 'id' is not present in the GET request or is empty
            echo getErrorMessage('Product ID', 'Product ID is missing or empty. Unable to add to the cart.');
        }

        // Render the add to cart view (if needed)
        $view = new Template();
        echo $view->render('views/addToCart.php');
    }

    /**
     * Apply discount to the cart.
     *
     * @param \Base $f3 Fat-Free Framework instance
     */
    public function applyDiscount($f3)
    {
        $discountCode = $_POST['discount'] ?? '';
        $_SESSION['discountCode'] = $discountCode;


        // Validate the discount code
        if (!validDiscountCode($discountCode)) {
            // Handle incorrect discount code
            $this->_f3->set('discountError', 'Invalid discount code.');
            $f3->reroute('/cart');
            return;

        }

        // Get the discount percentage
        $discountPercentage = getDiscountCodes()[$discountCode];
        $_SESSION['DISCOUNTPERCENTNUMBER'] = $discountPercentage;


        // Retrieve cart items from session
        $cartItems = isset($_SESSION['cartItem']) ? $_SESSION['cartItem'] : [];

        // Calculate subtotal, tax, and total
        $subtotal = calculateSubtotal($cartItems);
        $tax = calculateTax($cartItems);

        // Apply discount
        $discount = ($subtotal * $discountPercentage) / 100;
        $total = round(($subtotal + $tax) - $discount, 2);

        // Store the total and discount applied flag in session
        $_SESSION['total'] = $total;
        $_SESSION['discountApplied'] = true;

        // Redirect back to the cart page
        $f3->reroute('/cart');
    }

    /**
     * Remove discount from the cart.
     *
     * @param \Base $f3 Fat-Free Framework instance
     */
    public function removeDiscount($f3)
    {
        // Remove discount related session data
        unset($_SESSION['discountApplied']);
        unset($_SESSION['discountCode']);
        unset($_SESSION['discountPercentage']);

        // Retrieve cart items from session
        $cartItems = isset($_SESSION['cartItem']) ? $_SESSION['cartItem'] : [];

        // Calculate subtotal, tax, and total without discount
        $subtotal = calculateSubtotal($cartItems);
        $tax = calculateTax($cartItems);
        $total = round($subtotal + $tax, 2);

        // Pass data to the view
        $this->_f3->set('cartItems', $cartItems);
        $this->_f3->set('subtotal', $subtotal);
        $this->_f3->set('tax', $tax);
        $this->_f3->set('total', $total);
        $this->_f3->set('discountApplied', false);
        $this->_f3->set('discount', 0);
        $this->_f3->set('totalAfterDiscount', $total); // Total remains the same without discount

        // Redirect back to the cart page
        $f3->reroute('/cart');
    }




    /**
     * Display the cart page.
     */
    public function cart()
    {
        $discountError = isset($_SESSION['discountError']) ? $_SESSION['discountError'] : '';
        $discountCode = isset($_SESSION['discountCode']) ? $_SESSION['discountCode'] : '';
        $discountPercentage = $_SESSION['DISCOUNTPERCENTNUMBER']; // Example discount percentage
        // Retrieve cart items from session
        $cartItems = isset($_SESSION['cartItem']) ? $_SESSION['cartItem'] : [];

        // Calculate subtotal, tax, and total
        $subtotal = calculateSubtotal($cartItems);
        $tax = calculateTax($cartItems);
        $total = round($subtotal + $tax, 2);

        // Check if a discount has been applied
        $discountApplied = isset($_SESSION['discountApplied']) ? $_SESSION['discountApplied'] : false;

        // If a discount has been applied, calculate the discount and update the total
        if ($discountApplied) {
            // Calculate discount (e.g., 10% of subtotal)
            $discountPercentage = $_SESSION['DISCOUNTPERCENTNUMBER']; // Example discount percentage
            $discount = ($subtotal * $discountPercentage) / 100;

            // Update total with discount
            $totalAfterDiscount = $total - $discount;
        } else {
            // If no discount applied, total remains the same
            $discount = 0;
            $totalAfterDiscount = $total;
        }

        // Pass data to the view
        $this->_f3->set('cartItems', $cartItems);
        $this->_f3->set('subtotal', $subtotal);
        $this->_f3->set('tax', $tax);
        $this->_f3->set('total', $total);
        $this->_f3->set('discountApplied', $discountApplied);
        $this->_f3->set('discountPercentage', $discountPercentage);
        $this->_f3->set('discount', $discount);
        $this->_f3->set('discountCode', $discountCode);
        $this->_f3->set('discountError', $discountError);
        $this->_f3->set('totalAfterDiscount', $totalAfterDiscount);

        // Render the cart view
        $view = new Template();
        echo $view->render('views/cart.html');
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
