<?php
/*
Plugin Name: Options Demo
Plugin URI:
Description: Demo of Plugin Options Page
Version: 1.0
Author: LWHH
Author URI: https://hasin.me
License: GPLv2 or later
Text Domain: optionsdemo
Domain Path: /languages/
*/

require_once plugin_dir_path(__FILE__) . "/options-demo-form.php";

class OptionsDemo_Settings_Page {
	public function __construct() {
		add_action('admin_menu', array($this, 'optionsdemo_create_settings'));
		add_action('admin_init', array($this, 'optionsdemo_setup_sections'));
		add_action('admin_init', array($this, 'optionsdemo_setup_fields'));
		add_action('plugins_loaded', array($this, 'optionsdemo_bootstrap'));
		add_filter('plugin_action_links_' . plugin_basename(__FILE__), array($this, 'optionsdemo_settings_link'));
	}

	public function optionsdemo_settings_link($links) {
		$newlink = sprintf("<a href='%s'>%s</a>", 'options-general.php?page=optionsdemo', __('Settings', 'optionsdemo'));
		$links[] = $newlink;
		return $links;
	}


	public function optionsdemo_bootstrap() {
		load_plugin_textdomain('optionsdemo', false, plugin_dir_path(__FILE__) . "/languages");
	}

	public function optionsdemo_create_settings() {
		$page_title = __('Options Demo', 'optionsdemo');
		$menu_title = __('Options Demo', 'optionsdemo');
		$capability = 'manage_options';
		$slug       = 'optionsdemo';
		$callback   = array($this, 'optionsdemo_settings_content');
		add_options_page($page_title, $menu_title, $capability, $slug, $callback);
	}

	public function optionsdemo_settings_content() { ?>
		<div class="wrap">
			<h1><?php _e('Options Demo', 'optionsdemo'); ?></h1>
			<form method="POST" action="options.php">
				<?php
				settings_fields('optionsdemo');
				do_settings_sections('optionsdemo');
				submit_button();
				?>
			</form>
		</div> <?php
			}

			public function optionsdemo_setup_sections() {
				add_settings_section('optionsdemo_section', __('Demonstration of plugin settings page', 'optionsdemo'), array(), 'optionsdemo');
			}

			public function optionsdemo_setup_fields() {
				$fields = array(
					array(
						'label'       => __('Latitude', 'optionsdemo'),
						'id'          => 'optionsdemo_latitude',
						'type'        => 'text',
						'section'     => 'optionsdemo_section',
						'placeholder' => __('Latitude', 'optionsdemo'),
					),
					array(
						'label'       => __('Longitude', 'optionsdemo'),
						'id'          => 'optionsdemo_longitude',
						'type'        => 'text',
						'section'     => 'optionsdemo_section',
						'placeholder' => __('Longitude', 'optionsdemo'),
					),
					array(
						'label'   => __('Zoom Level', 'optionsdemo'),
						'id'      => 'optionsdemo_zoomlevel',
						'type'    => 'text',
						'section' => 'optionsdemo_section',
					),
					array(
						'label'   => __('API Key', 'optionsdemo'),
						'id'      => 'optionsdemo_apikey',
						'type'    => 'text',
						'section' => 'optionsdemo_section',
					),
					array(
						'label'   => __('External CSS', 'optionsdemo'),
						'id'      => 'optionsdemo_externalcss',
						'type'    => 'textarea',
						'section' => 'optionsdemo_section',
					),
					array(
						'label'   => __('Expiry Date', 'optionsdemo'),
						'id'      => 'optionsdemo_expirydate',
						'type'    => 'date',
						'section' => 'optionsdemo_section',
					),
				);
				foreach ($fields as $field) {
					add_settings_field(
						$field['id'],
						$field['label'],
						array($this,'optionsdemo_field_callback'),
						'optionsdemo',
						$field['section'],
						$field);
					register_setting('optionsdemo', $field['id']);
				}
			}

			public function optionsdemo_field_callback($field) {
				$value = get_option($field['id']);
				switch ($field['type']) {
					case 'textarea':
						printf(
							'<textarea name="%1$s" id="%1$s" placeholder="%2$s" rows="5" cols="50">%3$s</textarea>',
							$field['id'],
							isset($field['placeholder']) ? $field['placeholder'] : '',
							$value
						);
						break;
					default:
						printf(
							'<input name="%1$s" id="%1$s" type="%2$s" placeholder="%3$s" value="%4$s" />',
							$field['id'],
							$field['type'],
							isset($field['placeholder']) ? $field['placeholder'] : '',
							$value
						);
				}
				if (isset($field['desc'])) {
					if ($desc = $field['desc']) {
						printf('<p class="description">%s </p>', $desc);
					}
				}
			}
		}

// new Optionsdemo_Settings_Page();
