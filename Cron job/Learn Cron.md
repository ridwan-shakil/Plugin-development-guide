## 📘 WordPress Cron Jobs — Developer Notes
🔹 What is WP-Cron?
•	WP-Cron is WordPress’s task scheduling system.
•	It lets you schedule tasks to run at specific times or intervals.
•	Examples:
o	Send reminder emails daily
o	Clean up old logs every week
o	Run backups every night
⚠️ Important: WP-Cron is not a real system cron.
•	It only runs when someone visits the site.
•	For precise timing, server cron can be used to trigger WP-Cron manually.
________________________________________
## 🔹 Why Use WP-Cron?
Without cron, you’d need to run tasks manually. Cron makes plugins automated and reliable:
•	Backup plugins → automatic backups
•	WooCommerce → renew subscriptions, clear carts
•	SEO plugins → refresh sitemaps
•	Security plugins → scan for malware
________________________________________
## 🔹 Scheduling vs Executing
•	Scheduling: Telling WordPress when a task should run. (e.g., “at 10 AM daily”)
•	Executing: The actual task running at that time.
Example:
// Schedule once (promise of future work)
wp_schedule_event( time(), 'daily', 'my_cron_hook' );

// Execute (the real work)
add_action( 'my_cron_hook', 'my_cron_task' );
function my_cron_task() {
    error_log( 'Cron executed at: ' . current_time( 'mysql' ) );
}
________________________________________
## 🔹 Types of Cron Events
1. One-Time Cron (Single Event)
Runs once in the future, then disappears.
// Schedule to run 1 hour from now
wp_schedule_single_event( time() + 3600, 'my_one_time_hook' );

// Hook
add_action( 'my_one_time_hook', 'my_one_time_task' );
function my_one_time_task() {
    error_log( 'One-time cron ran at: ' . current_time( 'mysql' ) );
}
👉 Good for delayed actions (e.g., send email 1 hour after signup).
________________________________________
2. Recurring Cron (Repeating Event)
Runs repeatedly at a set interval.
// Schedule daily
wp_schedule_event( time(), 'daily', 'my_recurring_hook' );

// Hook
add_action( 'my_recurring_hook', 'my_recurring_task' );
function my_recurring_task() {
    error_log( 'Recurring cron ran at: ' . current_time( 'mysql' ) );
}
👉 Good for maintenance tasks (e.g., clean logs, backups, reports).
________________________________________
## 🔹 Built-in Intervals
WordPress comes with:
•	hourly
•	twicedaily
•	daily
________________________________________
## 🔹 Custom Intervals
You can add your own schedules:
// Add custom schedule (every 5 minutes)
add_filter( 'cron_schedules', 'my_custom_cron_schedule' );
function my_custom_cron_schedule( $schedules ) {
    $schedules['five_minutes'] = array(
        'interval' => 300, // seconds
        'display'  => __( 'Every 5 Minutes' )
    );
    return $schedules;
}

// Use it when scheduling
wp_schedule_event( time(), 'five_minutes', 'my_custom_hook' );
________________________________________
## 🔹 Activation & Deactivation
Always schedule on activation and clear on deactivation:
// Activation
register_activation_hook( __FILE__, 'my_plugin_activate' );
function my_plugin_activate() {
    if ( ! wp_next_scheduled( 'my_task_hook' ) ) {
        wp_schedule_event( time(), 'daily', 'my_task_hook' );
    }
}

// Deactivation
register_deactivation_hook( __FILE__, 'my_plugin_deactivate' );
function my_plugin_deactivate() {
    $timestamp = wp_next_scheduled( 'my_task_hook' );
    if ( $timestamp ) {
        wp_unschedule_event( $timestamp, 'my_task_hook' );
    }
}
________________________________________
## 🔹 Debugging Cron Jobs
1. Logging
    error_log( 'Cron ran at: ' . current_time( 'mysql' ) );
    Check wp-content/debug.log.
2. WP Crontrol Plugin
    •	Tools → Cron Events
    •	See all jobs, run them manually, debug.
3. WP-CLI
    wp cron event list
    wp cron event run my_task_hook
4. Server Cron (for reliability)
    Add in server (cPanel/SSH):
    */5 * * * * wget -q -O - https://example.com/wp-cron.php?doing_wp_cron >/dev/null 2>&1
________________________________________
## 🔹 Summary
•	WP-Cron = built-in scheduler for WordPress plugins.
•	One-time cron → runs once (good for delays).
•	Recurring cron → runs repeatedly (good for maintenance).
•	Always schedule on activation, clear on deactivation.
•	Use WP Crontrol or WP-CLI for debugging.
•	Use server cron for more reliability.
________________________________________
✅ With this, you can confidently add scheduled tasks to any WordPress plugin.

