<?php

/* Validate data
*/

// return true if meals is valid
function validMeals($meals){
    return strlen(trim($meals)) >= 3;
}
function validMealss($meals){
    return in_array($meals, getMeals());
}

// return true if sides is valid
function validSides($sides){
    return strlen(trim($sides)) >= 3;
}
function validSidess($sides){
    return in_array($sides, getSides());
}

// return true if drinks is valid
function validDrinks($drinks){
    return strlen(trim($drinks)) >= 3;
}
function validDrinkss($drinks){
    return in_array($drinks, getDrinks());
}