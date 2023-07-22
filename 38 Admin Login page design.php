<?php
/* 
* Plugin Name:       Customeze WP Login Form 
* Plugin URI:        
* Description:       This plugin will customize the login form of WordPress
* Version:  1.0.0
* Requires at least: 5.2
* Requires PHP: 7.2
* Author:            MD.Ridwan
* Author URI:        
* License:           GPL v2 or later
* License URI:       https: //www.gnu.org/licenses/gpl-2.0.html
* Update URI:        
* Text Domain:       wp-lfrm
* Domain Path:       /languages
*/
defined('ABSPATH') or die('Cannot access pages directly.');

// ======================================================
// Take referance from here 
// https://codex.wordpress.org/Customizing_the_Login_Form
// ======================================================

// Set login logo 
function my_login_logo() { ?>
    <style type="text/css">
        #login h1 a,
        .login h1 a {
            background-image: url(<?php echo plugin_dir_url(__FILE__) . 'assets/images/ridwan.png'; ?>);
            /* background-size: 320px 65px; */
            height: 56px;
            width: 80px;
            background-repeat: no-repeat;
            padding-bottom: 33px;
            border-radius: 50%;
        }
    </style>
<?php }
add_action('login_enqueue_scripts', 'my_login_logo');


function my_login_logo_url() {
    return home_url();
}
add_filter('login_headerurl', 'my_login_logo_url');

function my_login_logo_url_title() {
    return  get_bloginfo('name');
}
add_filter('login_headertext', 'my_login_logo_url_title');



// Changing text of login form
add_action('login_head', function () {
    add_filter('gettext', function ($translated_text, $text_to_translate, $text_domain) {
        if ('Username or Email Address' == $text_to_translate) {
            $translated_text = __('Your login key', 'wp-lfrm');
        } elseif ('Password' == $text_to_translate) {
            $translated_text = __('Your password', 'wp-lfrm');
        } elseif ('log in' == $text_to_translate) {
            $translated_text = __('Sign in', 'wp-lfrm');
        } elseif ('Lost your password?' == $text_to_translate) {
            $translated_text = __('Reset password', 'wp-lfrm');
        }
        // elseif ('Go to' == $text_to_translate) {
        //     $translated_text = __('Go to Home page', 'wp-lfrm');
        // }
        return $translated_text;
    }, 10, 3);
});


function rs_login_stylesheet() {
    wp_enqueue_style('rs-custom-login', plugin_dir_url(__FILE__) . 'assets/css/style-login.css');
    // wp_enqueue_script( 'custom-login', get_stylesheet_directory_uri() . '/style-login.js' );
}
add_action('login_enqueue_scripts', 'rs_login_stylesheet');

