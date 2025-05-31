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
