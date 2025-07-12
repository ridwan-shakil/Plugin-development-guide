<?php
//===========================================
// hasin hayder : https://github.com/LearnWithHasinHayder/plugin-actions/blob/master/plugin-action.php
//===========================================


/**
 * This function redirects to a specific admin menu page when a specific plugin is activated.
 * 
 * @param plugin The parameter "plugin" is a string that represents the name of the plugin that was
 * just activated. It is passed to the "redirect_to_admin_menu_page" function when the
 * "activated_plugin" action is triggered.
 */
function redirect_to_admin_menu_page($plugin) {
    if (plugin_basename(__FILE__) == $plugin) {
        wp_redirect(admin_url('admin.php?page=wpdbmenu'));
        die();
    }
};
add_action('activated_plugin', 'redirect_to_admin_menu_page');



/**
 * The function adds a new link to the WordPress admin menu. ( Settings )
 * 
 * @param links An array of existing links to be displayed in the plugin's settings page.
 * 
 * @return an array of links with an additional link to the settings page for the WPDB Menu plugin.
 */
function rs_new_action_link($links) {
    $link = sprintf('<a href="%s" style="color:red" >%s</a>', admin_url('admin.php?page=wpdbmenu'), __('Settings', 'text_domain'));
    array_push($links, $link);
    return $links;
}
add_filter('plugin_action_links_' . plugin_basename(__FILE__), 'rs_new_action_link');



/* This code adds a link to the plugin's row meta in the WordPress plugin page. */
add_filter('plugin_row_meta', function ($links, $plugin) {
    if (plugin_basename(__FILE__) == $plugin) {
        $link = sprintf("<a href='%s' style='color:#ff3c41;'>%s</a>", esc_url('https://github.com/ridwan-shakil'), __('Fork on Github', 'plac'));
        array_push($links, $link);
    }

    return $links;
}, 10, 2);
