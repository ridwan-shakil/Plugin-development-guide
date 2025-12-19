<?php

defined( 'ABSPATH' ) || exit;

final class My_Plugin {

    /**
     * Single instance
     *
     * @var My_Plugin
     */
    private static $instance = null;

    /**
     * Get instance
     */
    public static function get_instance() {
        if ( null === self::$instance ) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    /**
     * Constructor
     */
    private function __construct() {
        $this->define_constants();
        $this->init_hooks();
    }

    /**
     * Define constants
     */
    private function define_constants() {
        define( 'MY_PLUGIN_PATH', plugin_dir_path( __FILE__ ) );
        define( 'MY_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
    }

    /**
     * Register hooks
     */
    private function init_hooks() {
        add_action( 'init', [ $this, 'init' ] );
        add_action( 'plugins_loaded', [ $this, 'load_textdomain' ] );
    }

    public function init() {
        // Init logic
    }

    public function load_textdomain() {
        load_plugin_textdomain(
            'my-plugin',
            false,
            dirname( plugin_basename( __FILE__ ) ) . '/languages'
        );
    }

    private function __clone() {}

    public function __wakeup() {
        throw new \Exception( 'Cannot unserialize singleton' );
    }
}
