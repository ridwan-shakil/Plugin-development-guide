<?php

  wp_localize_script( 'destination', 'give a name', 'data in array format' );

// Note 
// this work must be done right after enquing the js file ( where the data is going )


// Example
  wp_enqueue_script('pqrc_minitoggle_js', plugin_dir_url(__FILE__) . "/assets/js/minitoggle.js", ['jquery'], '1.0', true);

        $data  = [
            'name' => "Ridwan",
            'designation' => 'WordPress developer'
        ];
        wp_localize_script('pqrc_main_js', 'sitedata', $data);


  // =============== enque admin scripts ================
    function load_admin_scripts($screen) {
        $_screen = get_current_screen();
        if ('edit.php' == $screen && 'post' == $_screen->post_type) { // -----Load on specific page----
            wp_enqueue_style('assetninja_admin_css', ASN_ASSETS_DIR . '/admin/css/main.css', '', VERSION);

            wp_enqueue_script('assetninja_admin_js', ASN_ASSETS_DIR . '/admin/js/main.js', ['jquery'], VERSION, true);
        }
    }

   //========= Deregister and register scripts ==========
    add_action( 'init', 'deregister_scripts' );
    function deregister_scripts() {
        wp_deregister_style( '$handle:string' );
        wp_register_style( '$handle:string', '$src:string|false');

        wp_deregister_script( '$handle:string' );
        wp_register_script( '$handle:string', '$src:string|false');
    }




// ================================
// Injecting css or js into a file 
// ================================
$data = <<<EOD
      #div1{
          background: red;
          }
EOD
wp_add_inline_style('name where to inject' , $data );
  
  
//   inject inline js 
$data = <<<EOD
      alert('hello from inline script');
EOD

 wp_add_inline_script('where to inject', $data );
