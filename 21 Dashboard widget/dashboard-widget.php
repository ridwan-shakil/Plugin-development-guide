<?php
/*
 * Plugin Name:       Dashboard widget
 * Plugin URI:        
 * Description:       Show didget in wordpress dashboard. 
 * Version:           1.0.0
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            MD.Ridwan
 * Author URI:        https://github.com/ridwan-shakil/
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Update URI:        
 * Text Domain:       dbw
 * Domain Path:       /languages
 */
if (!defined('ABSPATH')) {
    exit; // exits if try to access directly
}

function dashboard_widget_load_textdomain() {
    load_plugin_textdomain('dbw', false, dirname(__FILE__) . '/languages');
}
add_action('plugins_loaded', 'dashboard_widget_load_textdomain');


// Show widget in wordpress dashboard 

function dbw_first_widget() {
    if (current_user_can('edit_dashboard')) {
        wp_add_dashboard_widget('dbwshowinfo', __('Show information', 'dbw'), 'clbc_dbwshowinfo', 'clbc_dbshowinfo_input');
    } else {
        wp_add_dashboard_widget('dbwshowinfo', __('Show information', 'dbw'), 'clbc_dbwshowinfo');
    }
}
add_action('wp_dashboard_setup', 'dbw_first_widget');

// widget UI
function clbc_dbwshowinfo() {
    $num_of_post = get_option('dbw_posttoshow');
    echo '<h3>Dashboard widget heading </h3>';
    echo 'Input : ' . $num_of_post;
?>
    <hr>
    <p>here you can show your desired information </p>
    <hr>
<?php
}
// widget configaration (getting input from admin)
function clbc_dbshowinfo_input() {
    $num_of_post = get_option('dbw_posttoshow', 5);
    if (isset($_POST['dashboard-widget-nonce']) && wp_verify_nonce($_POST['dashboard-widget-nonce'], 'edit-dashboard-widget_dbwshowinfo')) {    //nonce verification 

        if (isset($_POST['dbw_numofpost']) && $_POST['dbw_numofpost'] > 0) {
            $num_of_post = sanitize_text_field($_POST['dbw_numofpost']);
            update_option('dbw_posttoshow', $num_of_post);
        }
    }
?>
    <div>
        <label for=""><?php __('Number of posts', 'dbw') ?></label>
        <input type="number" name="dbw_numofpost" id="dbw_numofpost" value="<?php echo $num_of_post ?>">
    </div>
<?php
}
