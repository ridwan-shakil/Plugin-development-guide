<?php 
// add custom column to all posts table 
class Rs_Custom_Columns {
    public function __construct() {
        add_filter('manage_posts_columns', array($this, 'add_post_id_column'));
        add_action('manage_posts_custom_column', array($this, 'show_post_id_column_content'), 10, 2);
        add_filter('manage_edit-post_sortable_columns', array($this, 'make_post_id_column_sortable'));
    }


    // Add a new column to the posts list

    function add_post_id_column($columns) {
        // Place Post ID after the checkbox
        $new_columns = array();
        foreach ($columns as $key => $value) {
            $new_columns[$key] = $value;
            if ($key === 'cb') {
                $new_columns['post_id'] = 'Post ID';
            }
        }
        return $new_columns;
    }

    // Display the Post ID in the custom column
    function show_post_id_column_content($column_name, $post_id) {
        if ($column_name === 'post_id') {
            echo $post_id;
        }
    }

    // Make the column sortable (optional)
    function make_post_id_column_sortable($columns) {
        $columns['post_id'] = 'ID';
        return $columns;
    }
}
// Initialize the plugin
new Rs_Custom_Columns();



