/*
 * Vlad O, Tilak C, Blake H
 * JavaScript script file for the CTRLFreaks webpage
 * File: script.js
 */

// Get the "Go to Top" button element
var goToTopBtn = document.getElementById("goToTopBtn");

// Show the "Go to Top" button when the user scrolls down 20px from the top of the document
window.onscroll = function() { scrollFunction() };

function scrollFunction() {
    if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
        goToTopBtn.style.display = "block";
    } else {
        goToTopBtn.style.display = "none";
    }
}

// Scroll to the top of the document when the "Go to Top" button is clicked
function topFunction() {
    document.body.scrollTop = 0; // For Safari
    document.documentElement.scrollTop = 0; // For Chrome, Firefox, IE, and Opera
}

// Get the elements for active and non-active user notification status
let activeUserNotificationStatus = document.querySelector('.active-choice');
let nonActiveStatus = document.querySelector(".not-active");

console.log(nonActiveStatus);
console.log(activeUserNotificationStatus);

// Add event listener to non-active status element to handle the user confirmation
nonActiveStatus.addEventListener("mousedown", function() {
    if (confirm("Are you sure you want to change your notification status?")) {
        nonActiveStatus.className = "active-choice";
        activeUserNotificationStatus.className = "not-active";
    }
});

document.addEventListener("DOMContentLoaded", function() {
    // Add event listeners to all forms with class 'add-to-cart-form'
    const addToCartForms = document.querySelectorAll('.add-to-cart-form');
    addToCartForms.forEach(form => {
        form.addEventListener('submit', function(event) {
            event.preventDefault(); // Prevent default form submission
            alert('Item added to cart!'); // Display alert message
            form.submit(); // Submit the form
        });
    });
});