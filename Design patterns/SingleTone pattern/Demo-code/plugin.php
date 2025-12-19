<?php
/**
 * Plugin Name: My Singleton Plugin
 */

defined( 'ABSPATH' ) || exit;

require_once __DIR__ . '/includes/class-plugin.php';

My_Plugin::get_instance();
