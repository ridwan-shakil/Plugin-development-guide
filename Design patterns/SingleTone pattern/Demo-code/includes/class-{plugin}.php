<?php
/**
 * Main Plugin Singleton.
 *
 * @since 1.0.0
 * @package draggable-notes
 */

namespace Draggable_Notes\Admin;

defined( 'ABSPATH' ) || exit;

/**
 * Main Plugin class to create singleton instance.
 */
final class Plugin {

	/**
	 * The single instance of the plugin.
	 *
	 * @var Plugin|null
	 */
	private static $instance = null;

	/**
	 * Get the plugin instance.
	 *
	 * @return Plugin
	 */
	public static function instance() {
		if ( null === self::$instance ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	/**
	 * Plugin constructor.
	 *
	 * @return void
	 */
	private function __construct() {
		$this->register_hooks();
	}

	/**
	 * Register core hooks.
	 *
	 * @return void
	 */
	private function register_hooks() {
		add_action( 'init', array( $this, 'init' ) );
	}

	/**
	 * Initialize plugin components.
	 *
	 * @return void
	 */
	public function init() {
		$loader = new Loader();
		$loader->run();
	}

	/**
	 * Prevent cloning.
	 *
	 * @return void
	 */
	private function __clone() {}

	/**
	 * Prevent unserialization.
	 *
	 * @return void
	 */
	public function __wakeup() {}
}
