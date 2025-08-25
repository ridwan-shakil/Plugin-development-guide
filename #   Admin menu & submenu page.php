<?php
// Notes:
// 1. (Give the same slug to the top menu & first submenu ) To open the first submenu on the top menu click 
// 2. add_options_page() is used to show the submenu under "Settings" menu, here menu slug is predefined { Basically it's a wrapper of add_submenu_page() }



add_action('admin_menu', 'register_my_custom_menu_page');
function register_my_custom_menu_page() {
    // add_menu_page( $page_title, $menu_title, $capability, $menu_slug, $function, $icon_url, $position );
    add_menu_page("wpdb menu page", 'Wpdb menu', 'manage_options', 'wpdbmenu', 'clbc_wpdb_page', '', null);

    // add_submenu_page( $parent_slug, $page_title, $menu_title, $capability,   $menu_slug, $callback, $position );
    add_submenu_page('wpdbmenu', 'wpdb insert', 'wpdb insert', 'manage_options', 'wpdbmenu', 'clbc_wpdb_insert');  // it has given the same slug as the top menu ( so it opens on both top menu & sub-menu click)
    add_submenu_page('wpdbmenu', 'wpdb update', 'wpdb update', 'manage_options', 'wpdb-update', 'clbc_wpdb_update');
}
