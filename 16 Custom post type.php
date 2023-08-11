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
// call our custom function with the init hook
add_action('init', 'team_register_taxonomy_department');
