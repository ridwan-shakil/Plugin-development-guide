<?php
class RS_Post_Page_ID_Column {

    public function __construct() {
        // Columns for Posts
        add_filter('manage_posts_columns', [$this, 'add_id_column']);
        add_action('manage_posts_custom_column', [$this, 'render_id_column'], 10, 2);
        add_filter('manage_edit-post_sortable_columns', [$this, 'make_id_column_sortable']);

        // Add new Columns for all Pages table
        add_filter('manage_pages_columns', [$this, 'add_id_column']);
        add_action('manage_pages_custom_column', [$this, 'render_id_column'], 10, 2);
        add_filter('manage_edit-page_sortable_columns', [$this, 'make_id_column_sortable']);

        // Add filter by tag for Posts only
        add_action('restrict_manage_posts', [$this, 'add_tag_filter_dropdown']);
        add_filter('parse_query', [$this, 'filter_posts_by_tag']);
    }

    public function add_id_column($columns) {
        $new_columns = [];
        foreach ($columns as $key => $value) {
            $new_columns[$key] = $value;
            if ($key === 'cb') {
                $new_columns['rs_post_id'] = 'Post ID';
            }
        }
        return $new_columns;
    }

    public function render_id_column($column, $post_id) {
        if ($column === 'rs_post_id') {
            echo $post_id;
        }
    }

    public function make_id_column_sortable($columns) {
        $columns['rs_post_id'] = 'ID';
        return $columns;
    }


    // ================= Tag Filter Dropdown Starts ================
    // Show tag filter dropdown in Posts list only
    public function add_tag_filter_dropdown() {
        global $typenow;
        if ($typenow !== 'post') {
            return;
        }

        $selected = isset($_GET['filter_by_tag']) ? intval($_GET['filter_by_tag']) : '';

        wp_dropdown_categories([
            'show_option_all' => 'Filter by Tag',
            'taxonomy'        => 'post_tag',
            'name'            => 'filter_by_tag', // ✅ Use a custom name
            'orderby'         => 'name',
            'selected'        => $selected,
            'hierarchical'    => false,
            'depth'           => 1,
            'show_count'      => true,
            'hide_empty'      => false,
        ]);
    }

    // Modify query to filter posts by selected tag
    public function filter_posts_by_tag($query) {
        global $pagenow;

        // Only apply for admin -> posts listing page
        if (
            is_admin() &&
            $pagenow === 'edit.php' &&
            isset($_GET['filter_by_tag']) &&
            intval($_GET['filter_by_tag']) > 0
        ) {
            $tag_id = intval($_GET['filter_by_tag']);
            $tag = get_term($tag_id, 'post_tag');

            if ($tag && !is_wp_error($tag)) {
                $query->query_vars['tag'] = $tag->slug;
            }
        }
    }
    // ================= Tag Filter Dropdown Ends ================



}

// Initialize the class
new RS_Post_Page_ID_Column();
