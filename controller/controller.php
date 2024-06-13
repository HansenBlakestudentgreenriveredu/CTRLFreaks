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
    public function contact($f3)
    {
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            $errorAmount = 0;

            // Sanitize and validate form inputs
            $firstName = $_POST['firstName'];
            $lastName = $_POST['firstName'];
            $email = $_POST['email'];
            $phone = $_POST['phoneNumber'];
            $comment = $_POST['comment'];

            $firstName = sanitizeInput($_POST['firstName']);
            $lastName = sanitizeInput($_POST['lastName']);
            $email = sanitizeInput($_POST['email']);
            $phone = sanitizeInput($_POST['phoneNumber']);
            $message = sanitizeInput($_POST['comment']);


            if (empty($firstName)) {
                $f3 -> set('errors["firstName"]', 'Please enter a correct first name');
                $errorAmount++;
            }

            if (empty($lastName)) {
                $f3 -> set('errors["lastName"]', 'Please enter a correct last name');
                $errorAmount++;
            }

            if (empty($email) || !validateEmail($email)) {
                $f3 -> set('errors["email"]', 'Please enter a correct email');
                $errorAmount++;
            }

            if (empty($phone) || !validatePhoneNumber($phone)) {
                $f3 -> set('errors["phone"]', 'Please enter a correct phone number');
                $errorAmount++;
            }

            if (empty($comment)) {
                $f3 -> set('errors["comment"]', 'Please enter a comment');
                $errorAmount++;
            }

            if ($errorAmount == 0) {
                $f3->set('SESSION.email', $email);
                $f3->set('SESSION.firstName', $firstName);
                $f3->set('SESSION.lastName', $lastName);
                $f3->set('SESSION.phone', $phone);
                $f3->set('SESSION.comment', $comment);
                $f3->reroute('contact-summary');
            }



        }

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

        // Validate the discount code
        if (!validDiscountCode($discountCode)) {
            // Handle invalid discount code
            // You can redirect back to the cart page with an error message
            // For simplicity, I'm just redirecting back to the cart page here
            $f3->reroute('/cart');
            return;
        }

        // Get the discount percentage
        $discountPercentage = getDiscountCodes()[$discountCode];

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
        // Remove discount flag from session
        unset($_SESSION['discountApplied']);

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
            $discountPercentage = 10; // Example discount percentage
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
        $this->_f3->set('discount', $discount);
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
                $f3 -> set('errors["offers-email"]', 'Please enter a correct email');
                $f3->reroute('#');
            } else {
                $email = $_POST['email'];
                $f3->set('email', $email);

                $GLOBALS['dataLayer']->saveEmailToDatabase($email);
                $view = new Template();
                echo $view->render('views/offers.html');
                session_destroy();
            }
        }
    }

    public function admin($f3) {
        if (!isset($_SESSION['user'])) {
            $f3->reroute('login');
        } else {
            $emailData = $GLOBALS['dataLayer']->getEmails();
            $f3->set('emailData', $emailData);
            $view = new Template();
            echo $view->render('views/admin.html');
            // Unset the session when leaving the admin page
            unset($_SESSION['user']);
        }
    }

    public function login($f3) {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $username = $_POST['username'];
            $password = $_POST['password'];

            $user = $GLOBALS['dataLayer']->checkUserPass($username, $password);

            if ($user !== null) {
                $_SESSION['user'] = $user;
                $f3->reroute('/admin');
            } else {
                $f3->set('errors["passusererror"]', 'Invalid username or password');
            }
        }
        $view = new Template();
        echo $view->render('views/login.html');
    }

    public function logout($f3) {
        session_destroy();
        $f3->reroute('/');
    }

    public function register($f3) {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $username = $_POST['username'];
            $password = $_POST['password'];

            // Hash the password
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            // Save user to the database
            $success = $GLOBALS['dataLayer']->saveUser($username, $hashedPassword);

            if ($success) {
                // Redirect to login page or any other appropriate page
                $f3->reroute('login');
            } else {
                // Handle error, e.g., username already exists
                $f3->set('errors["registerError"]', 'Failed to register user. Please try again.');
            }
        }
        $view = new Template();
        echo $view->render('views/register.html');
    }

    public function contactSummary() {

        $view = new Template();
        echo $view->render('views/contact-summary.html');
    }
}
