<?php

// Define constants
const TAX_RATE = 0.10;
const ROUND_PRECISION_SUBTOTAL = 2;
const ROUND_PRECISION_TAX = 3;

/**
* Calculate the subtotal of the cart items.
*
* @param array $cartItems The array of items in the cart.
*
* @return float The subtotal of the cart items rounded to 2 decimal places.
*/
function calculateSubtotal($cartItems)
{
$subtotal = 0;
foreach ($cartItems as $item) {
$subtotal += $item['price'];
}
return round($subtotal, ROUND_PRECISION_SUBTOTAL);
}

/**
* Calculate the tax for the cart items.
*
* @param array $cartItems The array of items in the cart.
*
* @return float The tax amount for the cart items rounded to 3 decimal places.
*/
function calculateTax($cartItems)
{
$subtotal = calculateSubtotal($cartItems);
$tax = $subtotal * TAX_RATE;
return round($tax, ROUND_PRECISION_TAX);
}
