<?php
/**
 * Main Loader class for Admin Notes.
 *
 * This file handles the loading and initialization of all core components
 * of the Admin Notes plugin, following the dependency injection pattern
 * by initializing various functional classes.
 *
 * @package draggable-notes
 * @since 1.0.0
 * @author MD.Ridwan <ridwansweb@email.com>
 */

namespace Draggable_Notes\Admin;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


/**
 * The main entry point and loader class for the Admin Notes plugin.
 *
 * This class instantiates and manages the core functional classes
 * responsible for activation, custom post types, admin interface,
 * assets, and AJAX handling.
 */
class Loader {

	/**
	 * Holds the Admin_Notes_Activation instance.
	 *
	 * Handles plugin activation and deactivation hooks.
	 *
	 * @var Admin_Notes_Activation
	 */
	protected $activation;

	/**
	 * Holds the Admin_Notes_CPT instance.
	 *
	 * Manages the registration of the 'admin_note' Custom Post Type.
	 *
	 * @var Admin_Notes_CPT
	 */
	protected $cpt;

	/**
	 * Holds the Admin_Notes_Admin instance.
	 *
	 * Manages admin-side interfaces, menus, and hooks.
	 *
	 * @var Admin_Notes_Admin
	 */
	protected $admin;

	/**
	 * Holds the Admin_Notes_Assets instance.
	 *
	 * Manages the enqueuing of scripts and styles (CSS/JS).
	 *
	 * @var Admin_Notes_Assets
	 */
	protected $assets;

	/**
	 * Holds the Admin_Notes_Ajax instance.
	 *
	 * Handles all AJAX-related operations and endpoints.
	 *
	 * @var Admin_Notes_Ajax
	 */
	protected $ajax;

	/**
	 * Initializes all core component classes.
	 *
	 * The constructor instantiates all dependent functional classes
	 * and assigns them to their respective properties.
	 * * @return void
	 */
	public function __construct() {
		$this->activation = new Admin_Notes_Activation();
		$this->cpt        = new Admin_Notes_CPT();
		$this->admin      = new Admin_Notes_Admin();
		$this->assets     = new Admin_Notes_Assets();
		$this->ajax       = new Admin_Notes_Ajax();
	}


	/**
	 * Executes the core initialization routine for the plugin.
	 *
	 * This method calls the primary setup/init methods on each
	 * instantiated component class to register hooks and functionality.
	 * * @return void
	 */
	public function run() {
		$this->activation->init();
		$this->cpt->register(); // Changed from init() to register() for clarity.
		$this->admin->init();
		$this->assets->init();
		$this->ajax->init();
	}
}
