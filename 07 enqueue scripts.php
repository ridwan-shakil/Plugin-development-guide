<?php

admin_enqueue_scripts  // it's for adding css or js into admin pannle ( we can enque for only current screen  )
wp_enqueue_scripts    // it's for adding css of js into frontend of website

// ====================================
// adding scripts for admin panel 
// ====================================
function pqrc_enque_admin_scripts($screen) {
// For top level menu 
 if ('toplevel_page_{your-menu-slug}' == $screen) {
        wp_enqueue_style('team_members_admin', plugin_dir_url(__FILE__) . '/admin/css/team_members_admin.css');
    }
   
// for complex page url
//     $current_screen = get_current_screen();
//     if ('edit.php' == $screen && 'page' == $current_screen->post_type) {
        // }

    
}
add_action('admin_enqueue_scripts', 'pqrc_enque_admin_scripts');

// ====================================
// adding scripts for frontend of website
// ====================================

function posts_qrcode_enque_style() {
    wp_enqueue_style('posts_to_qrcode_style', plugin_dir_url(__FILE__) . "style.css");
}

add_action('wp_enqueue_scripts', 'posts_qrcode_enque_style');



// ====================================
// deregister and register again scripts
// ====================================

function clbc_asn_plugin_init(){
    wp_deregister_style( 'name_of_stylesheet' );
    wp_register_style( 'name_of_stylesheet', $src:string|false, $deps:array, $ver:string|boolean|null, $media:string );

    wp_deregister_script( 'name_of_script' );
    wp_register_script( 'name_of_script', $src:string|false, $deps:array, $ver:string|boolean|null, $in_footer:boolean );
}

add_action('init', 'clbc_asn_plugin_init');
