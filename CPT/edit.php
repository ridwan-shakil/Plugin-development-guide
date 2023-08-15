<?php 
//============================================
// Add new row in the table of edit.php  page 
//============================================
1) Change the hook names "manage_{post_type}_posts_columns" and "manage_{post_type}_posts_custom_column"

  // that filter add a key name and set the title of the column 
add_filter('manage_post_posts_columns', function ($columns) {
    return array_merge($columns, ['verified' => __('Verified Title', 'textdomain')]);
});

// that action hook adds value to the new column 
add_action('manage_post_posts_custom_column', function ($column_key, $post_id) {
    if ($column_key == 'verified') {
        $verified = get_post_meta($post_id, 'verified', true);
        if ($verified) {
            echo '<span style="color:green;">';
            _e('Yes', 'textdomain');
            echo '</span>';
        } else {
            echo '<span style="color:red;">';
            _e('No', 'textdomain');
            echo '</span>';
        }
    }
}, 10, 2);

// add new column in a certain position 
add_action('manage_post_posts_columns', function ($columns) {
    $new_columns = array();
    foreach ($columns as $column => $val) {
        $new_columns[$column] = $val;
        if ($column == 'title') {
            $new_columns['eventdate'] = __('Event Date', 'textdomain');
        }
    }
    return $new_columns;
});

// Removing any column 
add_filter('manage_post_posts_columns', function ($columns) {
    unset($columns['date']);
    return $columns;
});

// Change a column Title 
add_filter('manage_post_posts_columns', function ($columns) {
    $columns['author'] = __('Publisher', 'textdomain');
    $columns['tags'] = __('Post Tages :) ', 'textdomain');
    return $columns;
});
// Change the position of a column 
add_filter('manage_post_posts_columns', function ($columns) {
    $author = $columns['author'];
    unset($columns['author']);
    $columns['author'] = $author;
    return $columns;
});
