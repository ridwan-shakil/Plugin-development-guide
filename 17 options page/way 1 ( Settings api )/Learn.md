
# Settings api work flow 
    register_setting()  -->  WP registers option + sanitize rules
    add_settings_field() -->  WP registers UI field definitions
    ↓
    <form action="options.php"> -->  User submits form
    ↓
    options.php  -->  validates nonce + group
    ↓
    update_option()  -->  data saved in wp_options
    ↓
    get_option()  -->  show saved value next time


===================================================

## 📘 WordPress Settings API – Quick Revision
    🛠 Purpose
    •	Create custom settings pages in WP Admin.
    •	Save plugin options safely in wp_options.
    •	Provide sections, fields, and built-in sanitization.
________________________________________
## 🔄 Basic Workflow
    1.	Register page
    2.	add_options_page( $page_title, $menu_title, $capability, $slug, $callback );
    → Creates menu under Settings.
    3.	Add sections
    4.	add_settings_section( $id, $title, $callback, $page_slug );
    5.	Add fields
    6.	add_settings_field( $id, $label, $render_callback, $page_slug, $section_id, $args );
    7.	Register settings (storage)
    8.	register_setting( $option_group, $option_name, $sanitize_callback );
    → Saves data into wp_options as $option_name.
    9.	Render page HTML
    10.	<form method="POST" action="options.php">
    11.	    <?php
    12.	    settings_fields( $option_group );
    13.	    do_settings_sections( $page_slug );
    14.	    submit_button();
    15.	    ?>
    16.	</form>

## 📦 Data Flow
    •	User submits form →
    •	options.php handles request →
    •	register_setting() updates DB (update_option) →
    •	Retrieve with get_option( $option_name ).

## ⚡ Key Functions
    •	settings_fields( $group ) → outputs nonce + hidden fields.
    •	do_settings_sections( $page ) → renders all registered sections & fields.
    •	get_option( $id ) → fetch option value.
    •	update_option( $id, $value ) → manually save if needed.

## ⚠️ Tips
    •	Always use a sanitize callback in register_setting.
    •	For multiple values (checkbox groups, multiselect), use array names:
    •	name="my_option[]"
    •	Options are stored serialized automatically.
    •	Use settings_errors() to display validation messages.
    •	Keep fields in an array config → loop them → DRY code.

## ✅ That’s the core of the Settings API.
    Use this flow, and your plugin options will always integrate properly with WP Admin.

