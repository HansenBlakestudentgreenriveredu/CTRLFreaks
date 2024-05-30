<?php

/* Data layer.
 * It belongs to the model.
 */

// Get breakfast items
function getBreakfastItems() {
    return [
        [
            'title' => 'Omelette',
            'description' => 'A delicious omelette made with fresh eggs and vegetables.',
            'price' => 5.99,
            'img' => 'images/omlette.webp'
        ],
        [
            'title' => 'Oatmeal Pancakes',
            'description' => 'Healthy oatmeal pancakes served with maple syrup.',
            'price' => 6.99,
            'img' => 'images/oatmeal-pancakes.jpg'
        ],
        [
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
            'title' => 'Cheeseburger',
            'description' => 'Juicy cheeseburger with fresh lettuce and tomato.',
            'price' => 8.99,
            'img' => 'images/cheeseburger.webp'
        ],
        [
            'title' => 'Chicken Club Sandwich',
            'description' => 'Grilled chicken club sandwich with bacon and avocado.',
            'price' => 9.99,
            'img' => 'images/chicken-club-sandwich-ft.jpg'
        ],
        [
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
            'title' => 'Grilled Salmon',
            'description' => 'Grilled salmon served with steamed vegetables.',
            'price' => 12.99,
            'img' => 'images/grilled salmon.jpeg'
        ],
        [
            'title' => 'Ribeye Steak',
            'description' => 'Juicy ribeye steak cooked to perfection.',
            'price' => 14.99,
            'img' => 'images/ribeye-steak-recipe-500x500.jpg'
        ],
        [
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
            'title' => 'French Fries',
            'description' => 'Crispy French fries served with ketchup.',
            'price' => 2.99,
            'img' => 'images/Frozen-French-Fries.jpeg'
        ],
        [
            'title' => 'Onion Rings',
            'description' => 'Golden fried onion rings.',
            'price' => 3.99,
            'img' => 'images/onionrings.jpg'
        ],
        [
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
            'title' => 'Coffee',
            'description' => 'Freshly brewed coffee.',
            'price' => 1.99,
            'img' => 'images/coffee.jpg'
        ],
        [
            'title' => 'Iced Tea',
            'description' => 'Refreshing iced tea.',
            'price' => 2.49,
            'img' => 'images/ice tea.jpg'
        ],
        [
            'title' => 'Soda',
            'description' => 'Chilled soda of your choice.',
            'price' => 1.49,
            'img' => 'images/soda.jpg'
        ]
    ];
}
?>
