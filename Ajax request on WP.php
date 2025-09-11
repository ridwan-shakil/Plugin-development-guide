// Documentation: https://awhitepixel.com/blog/wordpress-use-ajax/

NOTES: 
    wp_localize_script() //it's not a part of ajax , it's used to send data from php to jQuery


ajax call are 2 types :
    1) privileged ajax call     = only loged in users can do that 
    2) unprivileged ajax call


add_action( wp_ajax_{action_name},"")        = privileged ajax call (loged in users can do)
..........( wp_ajax_nopriv_{action_name),"") = unpreviliged ajax call (non logedin users can do)







// ================================================== 
// Step 1 : Set deta thet will be get by jquery 
// ================================================== 
input fields 
or
<button class="action-btn" data-task="add-option">Add option</button>
// ================================================== 
// Step 2 : Sent ajax url & nonce to jquery file 
// ================================================== 
<?php
wp_enqueue_script('ajax-script', plugins_url('options_api.js', __FILE__), array('jquery'), '1.0.0', true);

    wp_localize_script(
        'ajax-script',
        'my_ajax_obj',
        array(
            'ajax_url' => admin_url('admin-ajax.php'),
            'nonce'    => wp_create_nonce('title_example'),
        )
    );
// ================================================== 
// Step 3 : Ajax request in wordpress
// ================================================== 
// 3 ways of ajax request:
//     $.ajax() = Mostly used, full control, advanced features.
//     $.post() = Shortcut for $.ajax() with method = POST.
//     $.get()  = Shortcut for $.ajax() with method = GET.

//jqAjaxWp
 $.post(my_ajax_obj.ajax_url, {      //POST request
                _ajax_nonce: my_ajax_obj.nonce, //nonce
                action: "rs_actions",           //action
                data: task                      //data
            }, function (data) {                //callback
                $('.result').text(data);
            }
            );
// ================================================== 
// Step 4 : Here the callback function will perform operations & handover the result to that ajax request , from wher that request came from 
// ================================================== 

function clbc_function_to_perform_oprations() {
    $nonce_verified = wp_verify_nonce($_POST['_ajax_nonce'], 'title_example');

    if ($nonce_verified) {
        $task = $_POST['data'];
       // get the data that has been passed from ajax & perform oprations here 
    } else {
        echo 'Nonce is not varified';
    }

    wp_die(); // All ajax handlers die when finished
}

add_action('wp_ajax_rs_actions', 'clbc_function_to_perform_oprations');        //for logged in users
add_action('wp_ajax_noprev_rs_actions', 'clbc_function_to_perform_oprations'); //for non logged in users 
// add_action('wp_ajax_{action name of ajax request }', 'functionName');

// ================================================== 
// Step 5 : This is wher ajax is showing the result
// ================================================== 
<div class="result">
    <!-- Result will be displayed here through Ajax -->
</div>


// ================================================== 
// Ajax request can be tested via Postmen is nonce is not userd,  "always use nonce"
// ================================================== 
//it works for nonprev/ non logged in users only and this is how hackers can trigger your ajax request if "nonce" is not used
    
POST/GET
http://yoursite.com/wp-admin/admin-ajax.php
action   action_name    

