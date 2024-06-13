<?php

// File: datalayer.php
// Author: Vlad, Blake, Tilak
// Description: datalayer file for the CTRLFreaks page

/**
 * Data layer.
 * It belongs to the model.
 */
class DataLayer {
    private $_dbh;

    /**
     * DataLayer constructor connects to the PDO Database.
     */
    function __construct() {
        // Require my PDO database connection credentials
        require_once $_SERVER['DOCUMENT_ROOT'].'/../config.php';
        try {
            // Instantiate our PDO database object
            $this->dbh = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD);
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    /**
     * Save an email to the database.
     *
     * @param string $email The email to save.
     * @return void
     */
    function saveEmailToDatabase($email) {
        // Define query
        $sql = 'INSERT INTO subscribedEmail (email) VALUES (:email)';

        // Prepare the statement
        $statement = $this->dbh->prepare($sql);

        // Bind the email parameter
        $statement->bindParam(':email', $email);

        // Execute statement
        $statement->execute();
    }

    /**
     * Get all subscribed emails from the database.
     *
     * @return array The list of subscribed emails.
     */
    function getEmails() {
        // Define the query
        $sql = "SELECT * FROM `subscribedEmail`";

        // Prepare the statement
        $statement = $this->dbh->prepare($sql);

        // Execute the statement
        $statement->execute();

        // Fetch all results
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    /**
     * Check if the username and password are correct.
     *
     * @param string $username The username to check.
     * @param string $password The password to check.
     * @return array|null The user data if the credentials are correct, null otherwise.
     */
    function checkUserPass($username, $password) {
        // Define the query
        $sql = "SELECT * FROM `users` WHERE `username` = :username";

        // Prepare the statement
        $statement = $this->dbh->prepare($sql);

        // Bind the username parameter
        $statement->bindParam(':username', $username);

        // Execute the statement
        $statement->execute();

        // Fetch the user data
        $user = $statement->fetch(PDO::FETCH_ASSOC);

        // Check if user exists and verify password
        if ($user && password_verify($password, $user['password'])) {
            return $user;
        } else {
            return null;
        }
    }

    /**
     * Save a new user to the database.
     *
     * @param string $username The username of the new user.
     * @param string $password The password of the new user.
     * @return bool True on success, false otherwise.
     */
    function saveUser($username, $password) {
        // Define the query
        $sql = "INSERT INTO `users` (`username`, `password`) VALUES (:username, :password)";

        // Prepare the statement
        $statement = $this->dbh->prepare($sql);

        // Bind the username and password parameters
        $statement->bindParam(':username', $username);
        $statement->bindParam(':password', $password);

        // Execute the statement
        return $statement->execute();
    }
}

/**
 * Get breakfast items.
 *
 * @return array The list of breakfast items.
 */
function getBreakfastItems() {
    return [
        [
            'itemId' => 1,
            'title' => 'Omelette',
            'description' => 'A delicious omelette made with fresh eggs and vegetables.',
            'price' => 5.99,
            'img' => 'images/omlette.webp'
        ],
        [
            'itemId' => 2,
            'title' => 'Oatmeal Pancakes',
            'description' => 'Healthy oatmeal pancakes served with maple syrup.',
            'price' => 6.99,
            'img' => 'images/oatmeal-pancakes.jpg'
        ],
        [
            'itemId' => 3,
            'title' => 'Eggs Benedict',
            'description' => 'Classic eggs benedict with hollandaise sauce.',
            'price' => 7.99,
            'img' => 'images/eggs-benedict.jpg'
        ]
    ];
}

/**
 * Get lunch items.
 *
 * @return array The list of lunch items.
 */
function getLunchItems() {
    return [
        [
            'itemId' => 4,
            'title' => 'Cheeseburger',
            'description' => 'Juicy cheeseburger with fresh lettuce and tomato.',
            'price' => 8.99,
            'img' => 'images/cheeseburger.webp'
        ],
        [
            'itemId' => 5,
            'title' => 'Chicken Club Sandwich',
            'description' => 'Grilled chicken club sandwich with bacon and avocado.',
            'price' => 9.99,
            'img' => 'images/chicken-club-sandwich-ft.jpg'
        ],
        [
            'itemId' => 6,
            'title' => 'Caesar Salad',
            'description' => 'Classic Caesar salad with crispy croutons.',
            'price' => 7.49,
            'img' => 'images/caesar-salad-1-12.jpg'
        ]
    ];
}

/**
 * Get dinner items.
 *
 * @return array The list of dinner items.
 */
function getDinnerItems() {
    return [
        [
            'itemId' => 7,
            'title' => 'Grilled Salmon',
            'description' => 'Grilled salmon served with steamed vegetables.',
            'price' => 12.99,
            'img' => 'images/grilled-salmon.jpeg'
        ],
        [
            'itemId' => 8,
            'title' => 'Ribeye Steak',
            'description' => 'Juicy ribeye steak cooked to perfection.',
            'price' => 14.99,
            'img' => 'images/ribeye-steak-recipe-500x500.jpg'
        ],
        [
            'itemId' => 9,
            'title' => 'Mashed Potatoes',
            'description' => 'Creamy mashed potatoes with butter.',
            'price' => 4.99,
            'img' => 'images/mashed-potatoes.jpg'
        ]
    ];
}

/**
 * Get side items.
 *
 * @return array The list of side items.
 */
function getSides() {
    return [
        [
            'itemId' => 10,
            'title' => 'French Fries',
            'description' => 'Crispy French fries served with ketchup.',
            'price' => 2.99,
            'img' => 'images/Frozen-French-Fries.jpeg'
        ],
        [
            'itemId' => 11,
            'title' => 'Onion Rings',
            'description' => 'Golden fried onion rings.',
            'price' => 3.99,
            'img' => 'images/onionrings.jpg'
        ],
        [
            'itemId' => 12,
            'title' => 'Fruit Salad',
            'description' => 'Fresh fruit salad with a variety of seasonal fruits.',
            'price' => 4.49,
            'img' => 'images/fruits.jpg'
        ]
    ];
}

/**
 * Get beverages.
 *
 * @return array The list of beverages.
 */
function getBeverages() {
    return [
        [
            'itemId' => 13,
            'title' => 'Coffee',
            'description' => 'Freshly brewed coffee.',
            'price' => 1.99,
            'img' => 'images/coffee.jpg'
        ],
        [
            'itemId' => 14,
            'title' => 'Iced Tea',
            'description' => 'Refreshing iced tea.',
            'price' => 2.49,
            'img' => 'images/ice-tea.jpg'
        ],
        [
            'itemId' => 15,
            'title' => 'Soda',
            'description' => 'Chilled soda of your choice.',
            'price' => 1.49,
            'img' => 'images/soda.jpg'
        ]
    ];
}

/**
 * Get discount promo codes and their corresponding discount percentages.
 *
 * @return array The list of discount codes with their discount percentages.
 */
function getDiscountCodes() {
    return [
        'SUMMER20' => 20,  // 20% discount for SUMMER20 code
        'SAVE10' => 10,    // 10% discount for SAVE10 code
        'FREESHIP' => 0,   // Free shipping for FREESHIP code (0% discount)
        'FAMILY25' => 25,  // 25% discount for FAMILY25 code
        'HAPPYHOUR15' => 15,  // 15% discount for HAPPYHOUR15 code
        'WELCOME20' => 20, // 20% discount for WELCOME20 code
        'FALLSALE30' => 30, // 30% discount for FALLSALE30 code
    ];
}
?>