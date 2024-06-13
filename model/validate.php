<?php

// File: validate.php
// Author: Vlad, Blake, Tilak
// Description: validation php file that includes all validation methods for the CTRLFreaks page

/**
 * Validate data.
 * This file contains functions for validating and sanitizing input data.
 */

/**
 * Validate meals.
 *
 * @param string $meals The meals to validate.
 * @return bool True if meals is valid, false otherwise.
 */
function validMeals($meals)
{
    return strlen(trim($meals)) >= 3 && validMealsInternal($meals);
}

/**
 * Validate meals (internal).
 *
 * @param string $meals The meals to validate.
 * @return bool True if meals is valid, false otherwise.
 */
function validMealsInternal($meals)
{
    return in_array($meals, getMeals());
}

/**
 * Validate sides.
 *
 * @param string $sides The sides to validate.
 * @return bool True if sides is valid, false otherwise.
 */
function validSides($sides)
{
    return strlen(trim($sides)) >= 3 && validSidesInternal($sides);
}

/**
 * Validate sides (internal).
 *
 * @param string $sides The sides to validate.
 * @return bool True if sides is valid, false otherwise.
 */
function validSidesInternal($sides)
{
    return in_array($sides, getSides());
}

/**
 * Validate drinks.
 *
 * @param string $drinks The drinks to validate.
 * @return bool True if drinks is valid, false otherwise.
 */
function validDrinks($drinks)
{
    return strlen(trim($drinks)) >= 3 && validDrinksInternal($drinks);
}

/**
 * Validate drinks (internal).
 *
 * @param string $drinks The drinks to validate.
 * @return bool True if drinks is valid, false otherwise.
 */
function validDrinksInternal($drinks)
{
    return in_array($drinks, getDrinks());
}

/**
 * Validate price.
 *
 * @param float $price The price to validate.
 * @return bool True if price is valid (positive number), false otherwise.
 */
function validPrice($price)
{
    return is_numeric($price) && $price > 0;
}

/**
 * Validate itemId.
 *
 * @param int $itemId The itemId to validate.
 * @return bool True if itemId is valid (positive integer), false otherwise.
 */
function validItemId($itemId)
{
    return is_numeric($itemId) && $itemId > 0 && $itemId == intval($itemId);
}

/**
 * Sanitize input to prevent SQL injection.
 *
 * @param string $input The input to sanitize.
 * @return string The sanitized input.
 */
function sanitizeInput($input)
{
    return htmlspecialchars(strip_tags(trim($input)));
}

/**
 * Validate and sanitize input to prevent SQL injection.
 *
 * @param string $input The input to validate and sanitize.
 * @return string The sanitized input or an error message.
 */
function validateAndSanitize($input)
{
    if (empty($input)) {
        return "Input cannot be empty.";
    }
    $sanitizedInput = sanitizeInput($input);
    if ($input !== $sanitizedInput) {
        return "Invalid characters detected.";
    }
    return $sanitizedInput;
}

/**
 * Get user-friendly error message.
 *
 * @param string $field The field associated with the error.
 * @param string $message The error message.
 * @return string The formatted error message.
 */
function getErrorMessage($field, $message)
{
    return "Error in $field: $message";
}

/**
 * Validate discount promo code.
 *
 * @param string $code Promo code to validate.
 * @return bool True if valid, false otherwise.
 */
function validDiscountCode($code)
{
    $discountCodes = getDiscountCodes();
    return array_key_exists($code, $discountCodes);
}

/**
 * Validate email.
 *
 * @param string $email The email to validate.
 * @return bool True if the email is valid, false otherwise.
 */
function validateEmail($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}

/**
 * Validate phone number.
 *
 * @param string $phone The phone number to validate.
 * @return bool True if the phone number is valid, false otherwise.
 */
function validatePhoneNumber($phone) {
    // Basic validation: must contain only digits and optional plus sign, spaces, dashes
    return preg_match('/^\+?[\d\s\-]+$/', $phone);
}

?>