 <?php
// wp_options table has 4 fields 
// option_id    option_name    option_value  autoplay

// we can save any value to this table & retrive the data from it 
// Direct access to options table data from admin pannel => http://your_website.com/wp-admin/options.php

 add_option('dbversion', $db_version);     // Add option if if doesn't exist already
 replace_option($key , $value );  // Replace the value if the $key  already exists 
 update_option('dbversion', $db_version);  // update if exists or create  ( Most usefull )
 delete_option( $option_key );    // delete option

 get_option($key);  // Show the value

//add filter into option key 'option_{key name}'
add_filter('option_rs_country', function ($data) {
    return  strtoupper($data);
});

?>
NOTES:
 1) do json_encode before saving arrays to the DB , if you want redability / than do json_decode before showing / json_encode ("",true) = if want as Array
 2) if don't do json_encode array will saved in the DB as serialized "String" / when get , it will come as Array
 3) update_option replaces entire old data with new one / or creates new , if doesn't exists
 4) Must to : prefix options key to avoid conflicts



<?php
// ====================== Export data =====================
// First get exported data 
$exported_data = '{"rs_country":"INDIA IS A OVER POPULATED COUNTRY","rs_countries":["Nepal","Vutan","Nagaland"],"rs_json_countries":["India","South Africa","America","Soudiarab","Albania","Naizaria","Bangladesh"]}';
                $array_data = json_decode($exported_data, true);
                // print_r($array_data);
                foreach ($array_data as $key => $value) {
                    if ($key == 'rs_json_countries') {  // Json data must have to encode before saving, because where geting the deta is decoding it 
                        $key = json_encode($key);
                    }
                    update_option($key, $value);
                }


// input fields 
<div>
        <label for=""><?php __('Number of posts', 'dbw') ?></label>
        <input type="number" name="dbw_numofpost" id="dbw_numofpost" value="<?php echo $num_of_post ?>">
</div>
 

<?php
//  updation the option value into wp_option table  
    
   $num_of_post = get_option('dbw_posttoshow', 5);
    if (isset($_POST['dashboard-widget-nonce']) && wp_verify_nonce($_POST['dashboard-widget-nonce'], 'edit-dashboard-widget_dbwshowinfo')) {    //nonce verification 

        if (isset($_POST['dbw_numofpost']) && $_POST['dbw_numofpost'] > 0) {
            $num_of_post = sanitize_text_field($_POST['dbw_numofpost']);
            update_option('dbw_posttoshow', $num_of_post);    //update option
        }
    }


//  Show the option value  
echo get_option('dbw_posttoshow', 5);

?>
    
