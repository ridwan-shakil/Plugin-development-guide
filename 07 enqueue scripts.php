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
             // ---------- Adding inline css from user input ---------------       
             // Users custom css from the settings page
           		$custom_css = get_option('custom_css');
           		if (!empty($custom_css)) {
           			wp_add_inline_style($this->plugin_name, $custom_css);  // It's naem must be same as the main css file 
           		}
             // end of inline css 
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

// ====================================
// Register scripts only for specific page 
// ====================================
// For top level menu 
	 if ('toplevel_page_{your-menu-slug}' == $screen) { 

// For submenu // echo $screen ; and use it 
	if ('team_member_showcase_page_team-member-showcase-settings' == $screen) { 
	
// For the CPT page 
		global $post;
		if ('post-new.php' == $screen || 'post.php' == $screen) {   // add new post & edit post  page
			if ('team_member_showcase' === $post->post_type)
				// enqueue scripts here 
		}


		// -------------- For frontend -------------
// only for the page where the "TEAM_MEMBERS" shortcode is being used 
	global $post;
	if (is_a($post, 'WP_Post') && has_shortcode($post->post_content, 'TEAM_MEMBERS')) { 



