<?php

/**
* Get item details by item ID.
*
* @param int $itemId The ID of the item to retrieve.
*
* @return array|null The item details if found, or null if not found.
*/
function getItemDetailsById($itemId)
{
// Check breakfast items
$breakfastItems = getBreakfastItems();
foreach ($breakfastItems as $item) {
if ($item['itemId'] == $itemId) {
return $item;
}
}

// Check lunch items
$lunchItems = getLunchItems();
foreach ($lunchItems as $item) {
if ($item['itemId'] == $itemId) {
return $item;
}
}

// Check dinner items
$dinnerItems = getDinnerItems();
foreach ($dinnerItems as $item) {
if ($item['itemId'] == $itemId) {
return $item;
}
}

// Check sides
$sides = getSides();
foreach ($sides as $item) {
if ($item['itemId'] == $itemId) {
return $item;
}
}

// Check beverages
$beverages = getBeverages();
foreach ($beverages as $item) {
if ($item['itemId'] == $itemId) {
return $item;
}
}

// Item not found
return null;
}