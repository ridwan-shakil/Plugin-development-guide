<?php

add_action('admin_menu', 'register_my_custom_menu_page');
function register_my_custom_menu_page() {
    add_menu_page("wpdb menu page", 'Wpdb menu', 'manage_options', 'wpdbmenu.php', 'clbc_wpdb_insert');

    // add_submenu_page( $parent_slug, $page_title, $menu_title, $capability,   $menu_slug, $callback, $position );
  
}


function clbc_wpdb_insert() {

?>
    <!--   =============================================================== -->
    <!-- Creating form  -->
    <!--   =============================================================== -->

    <form action="" method="post">
        <?php
        wp_nonce_field('dbdemo', 'nonce');  // adding nonce field
        ?>
        <br>
        Name: <input type="text" name="name" id="">
        Email: <input type="email" name="email" id="">
        <?php submit_button(); ?>
    </form>

<?php
  
   // =============================================================== 
    //Handaling form data 
   // =============================================================== 
  
    if (isset($_POST['submit'])) {
        $name  = sanitize_text_field($_POST['name']);
        $email = sanitize_text_field($_POST['email']);
        $nonce = sanitize_text_field($_POST['nonce']);
        if (wp_verify_nonce($nonce, 'dbdemo')) {        // verify nonce 

            global $wpdb;
            $table_name = $wpdb->prefix . 'persons';
            $result = $wpdb->insert(
                $table_name,
                [
                    'name' => $name,
                    'email' => $email
                ],
                ['%s', '%s']
            );
        } else {
            echo 'Nonce can not verify';
        };
    };
}
