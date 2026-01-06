<?php
/**
 * Plugin Name:       Plugmint Draggable Notes For Admin
 * Description:       Create draggable admin notes with checklist tasks in the WP admin.
 * Version:           1.0.0
 * Author:            MD.Ridwan
 * Author URI:        https://github.com/ridwan-shakil
 * Text Domain:       draggable-notes
 * Domain Path:       /languages
 * License:           GPLv2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 *
 * @package draggable-notes
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Plugin constants.
define( 'PLUGMINT_NOTES_VERSION', '1.0.0' );
define( 'PLUGMINT_NOTES_PATH', plugin_dir_path( __FILE__ ) );
define( 'PLUGMINT_NOTES_URL', plugin_dir_url( __FILE__ ) );
define( 'PLUGMINT_NOTES_FILE', __FILE__ );

// Include required core files.
require_once PLUGMINT_NOTES_PATH . 'includes/class-plugin.php';
require_once PLUGMINT_NOTES_PATH . 'includes/class-loader.php';
// require_once PLUGMINT_NOTES_PATH . 'includes/class-admin-notes-activation.php';
// require_once PLUGMINT_NOTES_PATH . 'includes/class-admin-notes-cpt.php';
// require_once PLUGMINT_NOTES_PATH . 'includes/class-admin-notes-admin.php';
// require_once PLUGMINT_NOTES_PATH . 'includes/class-admin-notes-assets.php';
// require_once PLUGMINT_NOTES_PATH . 'includes/class-admin-notes-ajax.php';

/**
 * Runs on plugin activation.
 *
 * @return void
 */
function plugmint_notes_on_activate() {
	$activation = new Draggable_Notes\Admin\Admin_Notes_Activation();
	$activation->run_activation();
}
register_activation_hook( __FILE__, 'plugmint_notes_on_activate' );

/**
 * Initialize the plugin.
 *
 * @return void
 */
function plugmint_notes_run() {
	Draggable_Notes\Admin\Plugin::instance();
}
add_action( 'plugins_loaded', 'plugmint_notes_run' );
