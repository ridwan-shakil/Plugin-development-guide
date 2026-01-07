
✅ When It's Perfectly Fine:
Transients are excellent for non-critical, regenerable data, like:
    1. Cached API responses
    2. Cached query results
    3. Reusable computations
    4. Expensive HTML markup (e.g., output of a heavy shortcode)


<?php

// Functions :
set_transient($key, $data, $expiry);
get_transient("rs_posts_title");
delete_transient('rs_country');




//=============================
// Set transient if already does't exists ( set_transient )
//=============================
// Get any existing copy of our transient data

                if (false === ($special_query_results = get_transient('rs_posts_title'))) {
                    // It wasn't there, so regenerate the data and save the transient
                    $prepared_query = $wpdb->prepare("SELECT post_title FROM {$table} limit 6");
                    $result = $wpdb->get_results($prepared_query, ARRAY_A);
                    $key = 'rs_posts_title';
                    $expiry = 2 * MINUTE_IN_SECONDS; // expires in 2 minuts
                    $transient = set_transient($key, $result, $expiry);
                };
                // Use the data like you would have normally...
                $result2 = get_transient("rs_posts_title");
                print_r($result2);

//=============================
// Delete transient on any action ( delete_transient )
//=============================
// Create a simple function to delete our transient
function rs_edit_term_delete_transient() {
    delete_transient('rs_country');
}
// Add the function to the edit_term hook so it runs when categories/tags are edited
add_action('edit_term', 'rs_edit_term_delete_transient');



//=============================
// another example of transient
//=============================
// see if the data is available on transient or not 
$cache_key = 'admin_notes_max_order';
$max_order = get_transient( $cache_key );

if ( false === $max_order ) {
	$max_order = (int) $wpdb->get_var( /* query */ );
	set_transient( $cache_key, $max_order, MINUTE_IN_SECONDS * 5 );
}

$new_order = $max_order + 1;
update_post_meta( $post_id, '_admin_notes_order', $new_order );

// update transient
set_transient( $cache_key, $new_order, MINUTE_IN_SECONDS * 5 );
