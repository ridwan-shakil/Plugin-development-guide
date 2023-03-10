<?php

admin_enqueue_scripts  // it's for adding css or js into admin pannle ( we can enque for only current screen  )
wp_enqueue_scripts    // it's for adding css of js into frontend of website

// ====================================
// adding scripts for admin panel 
// ====================================
function pqrc_enque_admin_scripts($screen) {
    
// for complex page url
//     $current_screen = get_current_screen();
//     if ('edit.php' == $screen && 'page' == $current_screen->post_type) {
        // }

    
    if ('options-general.php' == $screen) {
        // css
        wp_enqueue_style('pqrc_minitoggle_css', plugin_dir_url(__FILE__) . "assets/css/minitoggle.css");


        // js 
        wp_enqueue_script('pqrc_minitoggle_js', plugin_dir_url(__FILE__) . "/assets/js/minitoggle.js", ['jquery'], '1.0', true);

        wp_enqueue_script('pqrc_main_js', plugin_dir_url(__FILE__) . '/assets/js/pqrc_main.js', ['jquery'], time(), true);
    }
}
add_action('admin_enqueue_scripts', 'pqrc_enque_admin_scripts');

// ====================================
// adding scripts for frontend of website
// ====================================

function posts_qrcode_enque_style() {
    wp_enqueue_style('posts_to_qrcode_style', plugin_dir_url(__FILE__) . "style.css");
}

add_action('wp_enqueue_scripts', 'posts_qrcode_enque_style');
