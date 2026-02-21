# 📘 WordPress Cron Jobs — Developer Notes

## 🔹 What is WP-Cron?

- WP-Cron is WordPress’s task scheduling system.
- It lets you schedule tasks to run at specific times or intervals.

### Examples:
- Send reminder emails daily
- Clean up old logs every week
- Run backups every night

⚠️ **Important:** WP-Cron is not a real system cron.
- It only runs when someone visits the site.
- For precise timing, a server cron job can be used to trigger WP-Cron manually.

---

## 🔹 Why Use WP-Cron?

Without cron, you’d need to run tasks manually. Cron makes plugins automated and reliable:

- Backup plugins → Automatic backups
- WooCommerce → Renew subscriptions, clear carts
- SEO plugins → Refresh sitemaps
- Security plugins → Scan for malware

---

## 🔹 Scheduling vs Executing

- **Scheduling:** Telling WordPress when a task should run (e.g., “at 10 AM daily”).
- **Executing:** The actual task running at that time.

### Example:

```php
// Schedule once (promise of future work)
wp_schedule_event( time(), 'daily', 'my_cron_hook' );

// Execute (the real work)
add_action( 'my_cron_hook', 'my_cron_task' );

function my_cron_task() {
    error_log( 'Cron executed at: ' . current_time( 'mysql' ) );
}
```
🔹 Types of Cron Events
## 1️⃣ One-Time Cron (Single Event)

    Runs once in the future, then disappears.
    
    // Schedule to run 1 hour from now
    wp_schedule_single_event( time() + 3600, 'my_one_time_hook' );
    
    // Hook
    add_action( 'my_one_time_hook', 'my_one_time_task' );
    
    function my_one_time_task() {
        error_log( 'One-time cron ran at: ' . current_time( 'mysql' ) );
    }

## 2️⃣ Recurring Cron (Repeating Event)

Runs repeatedly at a set interval.

    // Schedule daily
    wp_schedule_event( time(), 'daily', 'my_recurring_hook' );
    
    // Hook
    add_action( 'my_recurring_hook', 'my_recurring_task' );
    
    function my_recurring_task() {
        error_log( 'Recurring cron ran at: ' . current_time( 'mysql' ) );
    }

👉 Good for maintenance tasks (e.g., clean logs, backups, reports).

### 🔹 Built-in Intervals

    WordPress comes with:
    hourly
    twicedaily
    daily

### 🔹 Custom Intervals

You can add your own schedules:

        // Add custom schedule (every 5 minutes)
        add_filter( 'cron_schedules', 'my_custom_cron_schedule' );
        
        function my_custom_cron_schedule( $schedules ) {
            $schedules['five_minutes'] = array(
                'interval' => 300, // seconds
                'display'  => __( 'Every 5 Minutes' ),
            );
        
            return $schedules;
        }
        
        // Use it when scheduling
        wp_schedule_event( time(), 'five_minutes', 'my_custom_hook' );


### 🔹 Activation & Deactivation

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

---------
🔹 Debugging Cron Jobs 
### 1️⃣ Logging
error_log( 'Cron ran at: ' . current_time( 'mysql' ) );

Check:
wp-content/debug.log

### 2️⃣ WP Crontrol Plugin

    Go to Tools → Cron Events
    
    See all jobs
    
    Run them manually
    
    Debug issues easily

### 3️⃣ WP-CLI
    wp cron event list
    wp cron event run my_task_hook
### 4️⃣ Server Cron (For Reliability)

Add in server (cPanel/SSH):

    */5 * * * * wget -q -O - https://example.com/wp-cron.php?doing_wp_cron >/dev/null 2>&1
🔹 Summary

    WP-Cron = Built-in scheduler for WordPress plugins
    One-time cron → Runs once (good for delays)
    Recurring cron → Runs repeatedly (good for maintenance)
    Always schedule on activation, clear on deactivation
    Use WP Crontrol or WP-CLI for debugging
    Use server cron for better reliability

✅ With this, you can confidently add scheduled tasks to any WordPress plugin.

