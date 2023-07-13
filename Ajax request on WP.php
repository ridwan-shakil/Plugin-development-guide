// Step 1 ------------------------- Set deta thet will be get by jquery 
input fields 
or
<button class="action-btn" data-task="add-option">Add option</button>

// Step ------------------------- 
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
// Step -------------------------
// Step -------------------------
// Step -------------------------
