<?php
//Setting options
------------- adding setting field --------------
add_settings_field( $id:string, $title:string, $callback:callable, $page:string, $section:string, $args:array );    // adds a field to the setting $page
register_setting( $option_group:string, $option_name:string, $args:array );     //Registers a setting and its data

---------------- Show data -------------
get_option( $option:string, $default:mixed )    //Retrieves settings fields data.

//===================
//Simple Example 
//===================

function add_pqrc_dimenson() {
    add_settings_field('qrheight', 'QrCode height', 'clbc_pqrc_height', 'general');
    register_setting('general', 'qrheight');
}

function clbc_pqrc_height() {
?>
    <input type="text" name="qrheight" id="" value="<?php echo get_option('qrheight', 150); ?>">
<?php
}

add_action('admin_init', 'add_pqrc_dimenson');

//==================================
//Handle multiple field with one callback function
//==================================

function add_pqrc_dimenson() {
    add_settings_section('pqrc_section', 'Post to QrCode :', '', 'general',);
    add_settings_field('height', 'QrCode height', 'clbc_pqrc_dimension', 'general', 'pqrc_section', ['height']);
    add_settings_field('width', 'QrCode width', 'clbc_pqrc_dimension', 'general', 'pqrc_section', ['width']);
    register_setting('general', 'height', array(' sanitize_callback' => 'esc_attr'));
    register_setting('general', 'width', array(' sanitize_callback' => 'esc_attr'));
}

function clbc_pqrc_dimension($args) {
    $value = get_option($args[0], 150);
    $name = $args[0];
    printf('<input type="text" name="%s" id="" value="%s">', $name, $value);
}

add_action('admin_init', 'add_pqrc_dimenson');



// ===============================================
//  Adding selector in  setting options (general) page
// ===============================================
    
function add_pqrc_dimenson() {

    add_settings_field('pqrc_country', 'Select country', 'clbc_pqrc_country', 'general');
    register_setting('general', 'pqrc_country', array(' sanitize_callback' => 'esc_attr'));
}


// Select country 

function clbc_pqrc_country() {
    $option = get_option('pqrc_country');
    $countries = [
        'None', 'Bangladesh', 'india', 'Nepal', 'Vutan', 'Pakistan'
    ];


    echo '<select name="pqrc_country" id="pqrc_country">';

    foreach ($countries as $country) {
        $selected = '';
        if ($option == $country) {
            $selected = 'selected';
        }
        printf('<option value="%s" %s >%s</option>', $country, $selected, $country);
    }

    echo ' </select>';
}

add_action('admin_init', 'add_pqrc_dimenson');


// =========================================================
//     Checkbox
// =========================================================
function add_pqrc_dimenson() {

    add_settings_field('pqrc_country', 'Select country', 'clbc_pqrc_country', 'general');
    register_setting('general', 'pqrc_country'); // Don't senitize it 
}


// Select country 

function clbc_pqrc_country() {
    $option = get_option('pqrc_country');
    $countries = [
        'Bangladesh', 'india', 'Nepal', 'Vutan', 'Pakistan'
    ];

    foreach ($countries as $country) {
        $selected = '';
        if (is_array($option) && in_array($country, $option)) {
            $selected = 'checked';
        }
        printf('<input type="checkbox" value="%s" name="pqrc_country[]" %s > %s <br>',  $country, $selected, $country);
    }
}

add_action('admin_init', 'add_pqrc_dimenson');
