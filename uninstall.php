<?php

// If uninstall not called from WordPress, then exit.
if (!defined('WP_UNINSTALL_PLUGIN')) {
	exit;
}
  
// ==========================
//  Clear database 
// ==========================
  
 // Clear CPT data
$teams = get_posts(array(
	'post_type' => 'team_member_showcase',
	'numberposts' => -1,
	'post_status' => array('publish', 'draft', 'auto-draft', 'trash'),
));
foreach ($teams as $team) {
	wp_delete_post($team->ID, true);  // everything that is tied to the CPT is deleted also. This includes comments, post meta fields, and terms associated with the post.
}

// alternative way of clearing CPT data  -> Access the database via SQL
global $wpdb;
$wpdb->query( "DELETE FROM wp_posts WHERE post_type = 'team_member_showcase'" );
$wpdb->query( "DELETE FROM wp_postmeta WHERE post_id NOT IN (SELECT id FROM wp_posts)" );
$wpdb->query( "DELETE FROM wp_term_relationships WHERE object_id NOT IN (SELECT id FROM wp_posts)" );

// -------------------------
