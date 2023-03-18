<?php
 just see the wp_query documentation , It has endless possible way to show the posts .
   
//   main documentation :   https://developer.wordpress.org/reference/classes/wp_query/
//   Offline documentation: https://devdocs.io/wordpress/classes/wp_query
//   Code genrator:         https://generatewp.com/wp_query/

// =========================
    example 
// =========================
$paged   = get_query_var("paged") ? get_query_var("paged") : 1;  // For pagination
        $post_ids       = array(449, 454, 455, 456);   // Give post id 
            'numberposts' => 10,
            'post_type'   => 'post',
            'post__in'    => $post_ids,   // Change this key and value to get your desired posts ( see official documentation ) 
            'orderby'     => 'post__in',
            'paged'       => $paged    // For pagination
            // 'meta_key' => 'field_name',
            // 'meta_value' => 'field_value'
        );

        $query = new WP_Query($args);

        ?>

        <?php if ($query->have_posts()) : ?>
            <ul>
                <?php while ($query->have_posts()) : $query->the_post(); ?>
                    <li>
                        <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                    </li>
                <?php endwhile; ?>
            </ul>
        <?php endif; ?>

        <?php wp_reset_query(); ?>


<!-- Navigation  -->
                 <?php
                    echo paginate_links(array(
                        'total' => $query->max_num_pages
                    ));
                 ?>





<?php
// =========================
   Get posts by id  ( different way )
// =========================

        $paged          = get_query_var("paged") ? get_query_var("paged") : 1;  // For navigation
        $posts_per_page = 2;
        $post_ids       = array(472, 449, 454, 455, 456);   // Give post id 
        $_p             = get_posts(array(
            'posts_per_page' => $posts_per_page,
            'post__in'       => $post_ids,
            'orderby'        => 'post__in',
            'paged'          => $paged     // For navigation 
        ));
        foreach ($_p as $post) {
            setup_postdata($post);
        ?>
            <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></h2></a>
        <?php
        }
        wp_reset_postdata();
        ?>

<!-- pagination -->
                  <?php
                    echo paginate_links(array(
                        'total' => ceil(count($post_ids) / $posts_per_page)
                    ));
                    ?>

<?php

// ============================================
// Change any argument of "wp_query" without touching the main code 
// ============================================
function target_main_category_query_with_conditional_tags( $query ) {
	if ( ! is_admin() && $query->is_main_query() ) {
		// Not a query for an admin page.
		// It's the main query for a front end page of your site.

		if ( is_category() ) {
			// It's the main query for a category archive.

			// Let's change the query for category archives.
			$query->set( 'posts_per_page', 15 );
		}
	}
}
add_action( 'pre_get_posts', 'target_main_category_query_with_conditional_tags' );
