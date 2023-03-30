<?php
/*
* Plugin Name: Popup with pikly
* Plugin URI:
* Description: create popups with this plugin.
* Version: 1.0.0
* Requires at least: 5.2
* Requires PHP: 7.2
* Author: MD.Ridwan
* Author URI:
* License: GPL v2 or later
* License URI: https://www.gnu.org/licenses/gpl-2.0.html
* Update URI: https://example.com/my-plugin/
* Text Domain: pikly-popups
* Domain Path: /languages
*
*/
if (!defined('ABSPATH')) {
    exit; // exits if try to access directly
}

class main {
    function __construct() {
        add_action('plugins_loaded', array($this, 'load_textdomain'));
        add_action('admin_enqueue_scripts', array($this, 'enque_admin_scripts'));
        add_action('wp_enqueue_scripts', array($this, 'qrcode_enque_style'));
    }

    // Load textdomain 
    function load_textdomain() {
        load_plugin_textdomain('posts-toQr', false, dirname(__FILE__) . '/languages');
    }

    // adding scripts for admin panel 
    function enque_admin_scripts($screen) {
        if ($screen == 'options-general.php') {
            // css
            wp_enqueue_style('pqrc_minitoggle_css', plugin_dir_url(__FILE__) . "assets/css/minitoggle.css");


            // js 
            wp_enqueue_script('pqrc_main_js', plugin_dir_url(__FILE__) . '/assets/js/pqrc_main.js', ['jquery'], time(), true);
        }
    }

    // adding stylesheet for frontend
    function qrcode_enque_style() {
        wp_enqueue_style('posts_to_qrcode_style', plugin_dir_url(__FILE__) . "style.css");
    }
}
new main;
