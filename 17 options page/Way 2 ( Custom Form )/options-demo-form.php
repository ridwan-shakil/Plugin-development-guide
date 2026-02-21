<?php
class OptionsDemoTwo {
	public function __construct() {
		add_action('admin_menu', array($this, 'optionsdemo_create_admin_page'));
		add_action('admin_post_optionsdemo_admin_page', array($this, 'optionsdemo_save_form')); //action form hidden form field
	}

	public function optionsdemo_create_admin_page() {
		$page_title = __('Options Admin Page', 'optionsdemo');
		$menu_title = __('Options Admin Page', 'optionsdemo');
		$capability = 'manage_options';
		$slug       = 'optionsdemopage';
		$callback   = array($this, 'optionsdemo_page_content');
		// add_options_page($page_title, $menu_title, $capability, $slug, $callback);  // used if you want to create this page as a sub settings page
		add_menu_page($page_title, $menu_title, $capability, $slug, $callback);
	}

	public function optionsdemo_page_content() {
		require_once plugin_dir_path(__FILE__) . "/form.php";
	}


	public function optionsdemo_save_form() {
		check_admin_referer("optionsdemo");

		if (isset($_POST['optionsdemo_longitude2'])) {
			update_option('optionsdemo_longitude2', sanitize_text_field($_POST['optionsdemo_longitude2']));
		}
		if (isset($_POST['optionsdemo_color'])) {
			update_option('optionsdemo_color', sanitize_text_field($_POST['optionsdemo_color']));
		}

		wp_redirect('admin.php?page=optionsdemopage');
		// wp_redirect(admin_url('options-general.php?page=optionsdemopage')); //if used options page
	}
}

new OptionsDemoTwo();
