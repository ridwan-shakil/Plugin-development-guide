<?php
//=================================================
// Cookie in php
//=================================================

/*Setting a cookie named "catagory" with a
value of "Books" that will expire in 30 seconds and will be available to all paths on the website. */
    setcookie('catagory', 'Books', time() + 30, "/");


// Using the cookie 
$catagory = '';
    if (isset($_COOKIE['catagory'])) {
        $catagory = $_COOKIE['catagory'];
    }

echo $catagory;



