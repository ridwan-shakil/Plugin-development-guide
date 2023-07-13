// Step 1 ------------------------- Set deta thet will be get by jquery 
input fields 
or
<button class="action-btn" data-task="add-option">Add option</button>

// Step 2 ------------------------- Sent ajax url & nonce to jquery file 
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
// Step 3 ------------------------- Ajax request in wordpress
//jqajaxwp
 $.post(my_ajax_obj.ajax_url, {      //POST request
                _ajax_nonce: my_ajax_obj.nonce, //nonce
                action: "rs_actions",           //action
                data: task                      //data
            }, function (data) {                //callback
                $('.result').text(data);
            }
            );
// Step 4 -------------------------
add_action('wp_ajax_rs_actions', 'clbc_function_to_perform_oprations');
// add_action('wp_ajax_{action name of ajax request }', 'functionName');
// Here the callback function will perform oprations & handover the result to that ajax request , from wher that request came from 

// Step -------------------------
