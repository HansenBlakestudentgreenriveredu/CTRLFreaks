/*Vlad O, Tilak C, Blake H*/
/*Javascript script file for the CTRLFreaks webpage*/
// File: script.js


    // Get the button
    var goToTopBtn = document.getElementById("goToTopBtn");

    // When the user scrolls down 20px from the top of the document, show the button
    window.onscroll = function() {scrollFunction()};

    function scrollFunction() {
        if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
            goToTopBtn.style.display = "block";
        } else {
            goToTopBtn.style.display = "none";
        }
    }

    // When the user clicks on the button, scroll to the top of the document
    function topFunction() {
        document.body.scrollTop = 0; // For Safari
        document.documentElement.scrollTop = 0; // For Chrome, Firefox, IE and Opera
    }

    let activeUserNotificationStatus = document.querySelector('.active-choice');
    let nonActiveStatus = document.querySelector(".not-active");

    console.log(nonActiveStatus);
    console.log(activeUserNotificationStatus);

    nonActiveStatus.addEventListener("mousedown", function() {
        confirm("Are you sure you want to change your notification status?");
        nonActiveStatus.className = "active-choice";
        activeUserNotificationStatus.className = "not-active";
    });



