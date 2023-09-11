<?php
When the post and page is permanently deleted, everything that is tied to it is deleted also. 
This includes comments, post meta fields, and terms associated with the post.

The post or page is moved to Trash instead of permanently deleted unless Trash is disabled, 
item is already in the Trash, or $force_delete is true.




// If uninstall not called from WordPress, then exit.
if (!defined('WP_UNINSTALL_PLUGIN')) {
	exit;
}
  
// ==========================
//  Clear database 
// ==========================
  
 // Clear database 
$teams = get_posts(array(
	'post_type' => 'team_member_showcase',
	'numberposts' => -1,
	'post_status' => array('publish', 'draft', 'auto-draft', 'trash'),
));
foreach ($teams as $team) {
	wp_delete_post($team->ID, true);
}

