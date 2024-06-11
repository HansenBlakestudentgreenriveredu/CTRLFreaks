<?php
/**
 * Tilak, Vlad, Blake
 *
 * This file initiates the session for cart functionality.
 *

 * @package  views
 * @author   Tilak, Vlad, Blake
 */

// Start the session
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add to Cart</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="styles/CSS.css">
    <script src="script/scripts.js"></script>
</head>
<body class="add-to-cart-body">
<div class="cart-container">
    <h1>Item Added to Cart</h1>
    <p>
        <a href="menu" class="btn btn-menu">Continue Shopping</a>
    </p>
    <p>
        <a href="cart" class="btn btn-cart">Go to Cart</a>
    </p>
</div>
</body>
</html>
