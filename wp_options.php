 <?php
// wp_options table has 4 fields 
// option_id    option_name    option_value  autoplay

// we can save any value to this table & retrive the data from it 

 add_option('dbversion', $db_version);     // Add a value for the first time
 update_option('dbversion', $db_version);  // update the added value 

 get_option('dbversion');  // Show the value



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
    
