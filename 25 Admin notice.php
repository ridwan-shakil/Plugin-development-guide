

 Notes :
1) inside notice first div add class names according to your need such as :
      * class= "notice"                  // normal notice
      * class= "notice notice-success"
      * class= "notice notice-warning"                
      * class= "notice notice-error"
      * class= "is-dismissible"          // close button (X)

2) Use cookie to show notice after a certain period of times (showing notices all the time is annoying)


<?php

// =======================================================
//  The function displays a notice to the user
// =======================================================
 
function aicrud_admine_notice() {
?>
<!-- Notice information -->
    <div id="ai-curd-notice" class="notice notice-success is-dismissible">
        <h2>Welcome to AI Crud app :)</h2>
        <p>You can add users name and email in this crud app and see the data in ai crud admin menu page</p>
    </div>

<?php
}

add_action('admin_notices', 'aicrud_admine_notice');

// =======================================================
// Write the notice inside this function to show the notice in only selected pages 
// =======================================================
 global $pagenow;
    if (in_array($pagenow, ['index.php', 'admin.php'])) {
     //   Notice information goes here
};
// =======================================================
// if the user click on notice-dismiss button then set a cookie and don't show the notice for a time period 
// =======================================================
if (!isset($_COOKIE['notice_closed'])) {
     //   Notice information goes here
    };
// ------------------------ jQuery code to make a cookie on a button click --------------------------
   $('body').on('click', "#ai-curd-notice .notice-dismiss", function () {
            createCookie('notice_closed', 'true', 20); // The cookie will expire after 20 days

        });


        // Function to create a cookie
        function createCookie(name, value, days) {
            var expires;

            if (days) {
                var date = new Date();
                date.setTime(date.getTime() + (days * 1000));   // seconds 
                // date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000)); // days
                expires = "; expires=" + date.toGMTString();
            } else {
                expires = "";
            }

            document.cookie = name + "=" + value + expires + "; path=/";
        };

// ===============================================================================
