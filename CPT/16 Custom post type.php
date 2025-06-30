<?php 

Default post types are :
1) Post
2) Page
3) Navigation menu
4) Attachments
5) Revisions

// =============================
  Notes
// =============================
1) Alloways write "CPT" inside a plugin 
2) CPT has 2 parts : labels & enable/disable functionalaties 
3) pages for CPT : archive = archive-{books}.php , single = single-{book}.php , 
4)
 
-------------------------------
There are different ways to create "CPT" 
  1) Generate code from "Generate WP" or from any other website 
  2) Use " cpt ui " plugin > creat CPT > copy the code > pest inside the plugin 
  3) Write the code from scratch 
 

<?php
// Change the cpt 'add title' text 
function custom_change_title_text($title, $post) {
    if ('team_members' === $post->post_type) {
        $title = 'Member Name';
    }
    return $title;
}
add_filter('enter_title_here', 'custom_change_title_text', 10, 2);


// custom function to register the "subject" taxonomy
function team_register_taxonomy_department() {
    register_taxonomy(
        'department',
        'team_members',
        array(
            'label' => __('Department'),
            'rewrite' => array('slug' => 'department'),
            'hierarchical' => true
        )
    );
}
add_action('init', 'team_register_taxonomy_department');



// =========================================================

//  Add new columns to our CPT all posts page  
	 function book_display_columns( $columns ) {
		$columns = array(
			'cb'        => '<input type="checkbox" />',
			'title'     => __( 'Books' ),
		  'count'     => __( 'Total Members' ),
			'book_language' => __( 'Book Language' ),
			'date'      => __( 'Date' ),
		);
		return $columns;
	}
	add_filter( 'manage_book_posts_columns', 'book_display_columns' );


//  add value to our newly added columns in our CPT all posts page 
	 function book_manage_columns( $column, $post_id ) {
		global $post;
		/**
		 * If $total_count dowsn't exist in cache then run the query and add it to the cache.
		 */
		$total_count = wp_cache_get( 'cached-total-members-' . $post_id, 'team_members_display' );
		if ( false === $total_count ) {
			$total_count = get_post_meta( $post_id, 'rs_total_members', true );
			wp_cache_add( 'cached-total-members-' . $post_id, $total_count, 'team_members_display' );
		}

		if ( ! $total_count || -1 === $total_count ) {
			$total_count = 0;
		}
		
		switch ( $column ) {
			// case 'count':
			// 	echo esc_html( $total_count );
			// 	break;
			case 'book_language':
				echo  esc_html( get_post_meta( $post_id, 'book_language', true ) ) ;
				break;
			default:
				break;
		}
	}
add_action( 'manage_book_posts_custom_column', 'book_manage_columns', 10, 2 );


<!-- ===================== Example Books CPT ==================== -->
// Register Custom Post Type
function RSM_custom_post_type() {

	$labels = array(
		'name'                  => _x( 'Books', 'Post Type General Name', 'RSM' ),
		'singular_name'         => _x( 'Book', 'Post Type Singular Name', 'RSM' ),
		'menu_name'             => __( 'Books', 'RSM' ),
		'name_admin_bar'        => __( 'Book', 'RSM' ),
		'archives'              => __( 'Book Archives', 'RSM' ),
		'attributes'            => __( 'Book Attributes', 'RSM' ),
		'parent_item_colon'     => __( 'Parent Book:', 'RSM' ),
		'all_items'             => __( 'All Books', 'RSM' ),
		'add_new_item'          => __( 'Add New Book', 'RSM' ),
		'add_new'               => __( 'Add New', 'RSM' ),
		'new_item'              => __( 'New Book', 'RSM' ),
		'edit_item'             => __( 'Edit Book', 'RSM' ),
		'update_item'           => __( 'Update Book', 'RSM' ),
		'view_item'             => __( 'View Book', 'RSM' ),
		'view_items'            => __( 'View Book', 'RSM' ),
		'search_items'          => __( 'Search Book', 'RSM' ),
		'not_found'             => __( 'Not found', 'RSM' ),
		'not_found_in_trash'    => __( 'Not found in Trash', 'RSM' ),
		'featured_image'        => __( 'Book Caver', 'RSM' ),
		'set_featured_image'    => __( 'Set Book Caver Image', 'RSM' ),
		'remove_featured_image' => __( 'Remove Book Caver Image', 'RSM' ),
		'use_featured_image'    => __( 'Use as Book Caver Image', 'RSM' ),
		'insert_into_item'      => __( 'Insert into Book', 'RSM' ),
		'uploaded_to_this_item' => __( 'Uploaded to this Book', 'RSM' ),
		'items_list'            => __( 'Books list', 'RSM' ),
		'items_list_navigation' => __( 'Books list navigation', 'RSM' ),
		'filter_items_list'     => __( 'Filter Books list', 'RSM' ),
	);
	$args = array(
		'label'                 => __( 'Book', 'RSM' ),
		'description'           => __( 'Books post type descriptoin', 'RSM' ),
		'labels'                => $labels,
		'supports'              => array( 'title', 'editor', 'thumbnail', 'comments', 'trackbacks', 'revisions', 'custom-fields', 'page-attributes', 'post-formats' ),
		'taxonomies'            => array( 'category', 'post_tag' ),
		'hierarchical'          => false,
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_position'         => 5,
		'menu_icon'             => 'dashicons-book',
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => true,
		'can_export'            => true,
		'has_archive'           => true,
		'exclude_from_search'   => false,
		'publicly_queryable'    => true,
		'capability_type'       => 'post',
		'show_in_rest'          => true,
	);
	register_post_type( 'post_type', $args );

}
add_action( 'init', 'RSM_custom_post_type', 0 );

