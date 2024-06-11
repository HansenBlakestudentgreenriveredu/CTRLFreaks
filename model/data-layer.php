<?php

/* Data layer.
 * It belongs to the model.
 */

class DataLayer {
    private $_dbh;

    /**
     * DataLayer constructor connects to PDO Database
     */
    function __construct() {
        // Require my PDO data base connection credentials
        require_once $_SERVER['DOCUMENT_ROOT'].'/../config.php';
        try {
            // Instantiate our PDO database object
            $this->dbh = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD);
        } catch (PDOException $e) {
            die ($e->getMessage());
        }
    }

    /**
     * Save a restaurant order to the database
     * @param Order an Order object
     * @return int the Order ID
     */
    function saveEmailToDatabase($email) {
        // Define query
        $sql = 'INSERT INTO subscribedEmail (email) VALUES (:email)';

        // prepare the statement
        $statement = $this->dbh->prepare($sql);

        // Bind the
        $statement->bindParam(':email', $email);

        // Execute statement
        $statement->execute();
    }

    function getEmails() {
        // Define the query
        $sql = "SELECT * FROM `subscribedEmail`";

        // Prepare the statement
        $statement = $this->dbh->prepare($sql);

        // Bind the parameters (we don't need to for this)

        // Execute the statement
        $statement->execute();

        // Process the results
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $result;


    }
}



// Get breakfast items
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

// Get lunch items
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

// Get dinner items
function getDinnerItems() {
    return [
        [
            'itemId' => 7,
            'title' => 'Grilled Salmon',
            'description' => 'Grilled salmon served with steamed vegetables.',
            'price' => 12.99,
            'img' => 'images/grilled salmon.jpeg'
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

// Get sides
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

// Get beverages
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
            'img' => 'images/ice tea.jpg'
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
?>