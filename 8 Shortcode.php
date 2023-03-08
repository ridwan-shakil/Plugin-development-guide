<?php 

add_shortcode() //to creat shortcode
do_shortcode()  //to display shortcode

// =====================================
// Shortcode Type 1 
// =====================================
//the shortcode will be like:  [pqrc_button url='https://google.com' title='Button]  

function pqrc_shortcode_button($attributes) {

    return sprintf('<a target="_blank" href="%s">%s Button</a>', $attributes['url'], $attributes['title']);
}

add_shortcode('pqrc_button', 'pqrc_shortcode_button');



// =====================================
// Shortcode type 2
// =====================================
//the shortcode will be like:  [pqrc_button2 url='https://google.com'] Click me [/pqrc_button2]

function pqrc_shortcode_button2($attr, $content) {

    return sprintf('<a target="_blank" href="%s">%s</a>', $attr['url'], $content);
}

add_shortcode('pqrc_button2', 'pqrc_shortcode_button2');



// =====================================
// Shortcode with default value  ***
// =====================================
function pqrc_btn_with_default($attr, $content) {
    $default = [
        'url' => '',
        'class' => 'btn-primary'
    ];
    $new_attr = shortcode_atts($default, $attr);
    $content = $content ? $content : 'Click here';
    return sprintf('<a href="%s" class="%s  btn ">%s</a>', $new_attr['url'], $new_attr['class'], $content);
}
add_shortcode('btn_with_default', 'pqrc_btn_with_default');
