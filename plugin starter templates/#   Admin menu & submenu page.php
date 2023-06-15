<?php
add_action('admin_menu', 'register_my_custom_menu_page');
function register_my_custom_menu_page() {
    // add_menu_page( $page_title, $menu_title, $capability, $menu_slug, $function, $icon_url, $position );
    add_menu_page("wpdb menu page", 'Wpdb menu', 'manage_options', 'wpdbmenu.php', 'clbc_wpdb_page', '', null);

    // add_submenu_page( $parent_slug, $page_title, $menu_title, $capability,   $menu_slug, $callback, $position );
    add_submenu_page('wpdbmenu.php', 'wpdb insert', 'wpdb insert', 'manage_options', 'wpdb_insert.php', 'clbc_wpdb_insert');
}
