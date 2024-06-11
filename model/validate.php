<?php

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
    return strlen(trim($meals)) >= 3 && validMealss($meals);
}

/**
 * Validate meals (internal).
 *
 * @param string $meals The meals to validate.
 * @return bool True if meals is valid, false otherwise.
 */
function validMealss($meals)
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
    return strlen(trim($sides)) >= 3 && validSidess($sides);
}

/**
 * Validate sides (internal).
 *
 * @param string $sides The sides to validate.
 * @return bool True if sides is valid, false otherwise.
 */
function validSidess($sides)
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
    return strlen(trim($drinks)) >= 3 && validDrinkss($drinks);
}

/**
 * Validate drinks (internal).
 *
 * @param string $drinks The drinks to validate.
 * @return bool True if drinks is valid, false otherwise.
 */
function validDrinkss($drinks)
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
 * @param string $code Promo code to validate
 * @return bool True if valid, false otherwise
 */
function validDiscountCode($code)
{
    $discountCodes = getDiscountCodes();
    return array_key_exists($code, $discountCodes);
}


?>