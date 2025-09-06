<?php
/*
Plugin Name: My Cron Plugin
Description: Example plugin that runs a task every 5 minutes using WP-Cron.
Version: 1.0
Author: Your Name
*/

// 1. Add custom schedule (every 5 minutes)
add_filter( 'cron_schedules', 'my_cron_custom_schedule' );
function my_cron_custom_schedule( $schedules ) {
    $schedules['five_minutes'] = array(
        'interval' => 300, // 300 seconds = 5 minutes
        'display'  => __( 'Every 5 Minutes' ),
    );
    return $schedules;
}

// 2. Schedule event on plugin activation
register_activation_hook( __FILE__, 'my_cron_activate' );
function my_cron_activate() {
    if ( ! wp_next_scheduled( 'my_cron_task_hook' ) ) {
        wp_schedule_event( time(), 'five_minutes', 'my_cron_task_hook' );
    }
}

// 3. Unschedule event on plugin deactivation
register_deactivation_hook( __FILE__, 'my_cron_deactivate' );
function my_cron_deactivate() {
    $timestamp = wp_next_scheduled( 'my_cron_task_hook' );
    if ( $timestamp ) {
        wp_unschedule_event( $timestamp, 'my_cron_task_hook' );
    }
}

// 4. Hook your task to the cron event
add_action( 'my_cron_task_hook', 'my_cron_task_function' );
function my_cron_task_function() {
    // Example: write to debug.log
    if ( defined( 'WP_DEBUG_LOG' ) && WP_DEBUG_LOG ) {
        error_log( 'My Cron task ran at: ' . current_time( 'mysql' ) );
    }
}
