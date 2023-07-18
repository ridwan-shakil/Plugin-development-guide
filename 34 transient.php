<?php
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
