<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add to Cart</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .cart-container {
            text-align: center;
            background: white;
            border-radius: 10px;
            padding: 30px;
            box-shadow: 0px 0px 10px 0px rgba(0,0,0,0.1);
        }
        .cart-container h1 {
            margin-bottom: 20px;
            color: #343a40;
        }
        .cart-container p {
            margin: 20px 0;
        }
        .cart-container a {
            text-decoration: none;
        }
        .cart-container .btn {
            margin: 5px;
            padding: 10px 20px;
            border-radius: 5px;
            transition: background-color 0.3s;
        }
        .cart-container .btn-menu {
            background-color: #007bff;
            color: white;
        }
        .cart-container .btn-cart {
            background-color: #28a745;
            color: white;
        }
        .cart-container .btn-menu:hover {
            background-color: #0056b3;
        }
        .cart-container .btn-cart:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>
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
