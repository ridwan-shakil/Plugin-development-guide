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
2) 
3)
4)
 
-------------------------------
There are 2 ways to create "CPT" 
  1) Use " cpt ui " plugin > creat CPT > copy the code > pest inside the plugin 
  2) Write the code from scratch 
 

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

