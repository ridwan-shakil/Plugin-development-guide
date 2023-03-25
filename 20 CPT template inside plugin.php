<?php
// ========================================================
// display cpt on a template from plugin (place the code below cpt code)
// ========================================================

function halim_cpt_portfolio_template($file) {
    global $post;
    if ('post' == $post->post_type) {
        $file = plugin_dir_path(__FILE__) . 'cpt-templates/single-portfolio.php'; //give your file url
    }
    return $file;
}


add_filter('single_template', 'halim_cpt_portfolio_template');
