<?php
// =========================
   Get posts by id  
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

<?php
// =========================
   Get posts  
// =========================
