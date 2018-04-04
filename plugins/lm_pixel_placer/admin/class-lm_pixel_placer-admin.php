<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://lamarkmedia.com
 * @since      1.0.0
 *
 * @package    Lm_pixel_placer
 * @subpackage Lm_pixel_placer/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Lm_pixel_placer
 * @subpackage Lm_pixel_placer/admin
 * @author     Lamark Media <webadmin@lamarkmedia.com>
 */
class Lm_pixel_placer_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Lm_pixel_placer_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Lm_pixel_placer_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */
		if ( 'settings_page_lm_pixel_placer' == get_current_screen() -> id ) {
			wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/lm_pixel_placer-admin.css', array(), $this->version, 'all' );
		}


	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Lm_pixel_placer_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Lm_pixel_placer_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/lm_pixel_placer-admin.js', array( 'jquery' ), $this->version, false );

	}

	/**
	 * Register the administration menu for this plugin into the WordPress Dashboard menu.
	 *
	 * @since    1.0.0
	 */

	public function add_plugin_admin_menu() {

		/*
		 * Add a settings page for this plugin to the Settings menu.
		 *
		 * NOTE:  Alternative menu locations are available via WordPress administration menu functions.
		 *
		 *        Administration Menus: http://codex.wordpress.org/Administration_Menus
		 *
		 */
		add_options_page( 'Lamark Media Pixel Placer Settings', 'LM Pixel Placer', 'manage_options', $this->plugin_name, array($this, 'display_plugin_setup_page')
		);
	}

	/**
	 * Add settings action link to the plugins page.
	 *
	 * @since    1.0.0
	 */

	public function add_action_links( $links ) {
		/*
		*  Documentation : https://codex.wordpress.org/Plugin_API/Filter_Reference/plugin_action_links_(plugin_file_name)
		*/
		$settings_link = array(
			'<a href="' . admin_url( 'options-general.php?page=' . $this->plugin_name ) . '">' . __('Settings', $this->plugin_name) . '</a>',
		);
		return array_merge(  $settings_link, $links );

	}

	/**
	 * Render the settings page for this plugin.
	 *
	 * @since    1.0.0
	 */

	public function display_plugin_setup_page() {
		include_once( 'partials/lm_pixel_placer-admin-display.php' );
	}

	public function options_update() {
		register_setting($this->plugin_name, $this->plugin_name, array($this, 'validate'));
	}

	public function validate($input) {
		// All inputs
		$valid = array();

		//Cleanup
		$valid['google_analytics'] = (isset($input['google_analytics']) && !empty($input['google_analytics'])) ? 1 : 0;
		$valid['google_analytics_id'] = $input['google_analytics_id'];
		$valid['gtm_id'] = $input['gtm_id'];
		$valid['gtm_datalayer'] = (isset($input['gtm_datalayer']) && !empty($input['gtm_datalayer'])) ? 1 : 0;
		$valid['ga_ecommerce'] = (isset($input['ga_ecommerce']) && !empty($input['ga_ecommerce'])) ? 1 : 0;
		$valid['google_conversion'] = (isset($input['google_conversion']) && !empty($input['google_conversion'])) ? 1 : 0;
		$valid['adwords_conversion_id'] = $input['adwords_conversion_id'];
		$valid['adwords_converison_label'] = $input['adwords_converison_label'];
		$valid['google_remarketing'] = (isset($input['google_remarketing']) && !empty($input['google_remarketing'])) ? 1 : 0;
		$valid['remarketing_conversion_id'] = $input['remarketing_conversion_id'];
		$valid['facebook_pixel'] = (isset($input['facebook_pixel']) && !empty($input['facebook_pixel'])) ? 1 : 0;
		$valid['facebook_id'] = $input['facebook_id'];
		$valid['bing_pixel'] = (isset($input['bing_pixel']) && !empty($input['bing_pixel'])) ? 1 : 0;
		$valid['bing_id'] = $input['bing_id'];
		$valid['metatags'] = $input['metatags'];
		$valid['additional_ecommerce_conversion_pixels'] = $input['additional_ecommerce_conversion_pixels'];
		$valid['additional_pixels_each_page'] = $input['additional_pixels_each_page'];
		$valid['specific_pixels_for_page1'] = $input['specific_pixels_for_page1'];
		$valid['specific_page1'] = $input['specific_page1'];
		$valid['specific_pixels_for_page2'] = $input['specific_pixels_for_page2'];
		$valid['specific_page2'] = $input['specific_page2'];
		$valid['specific_pixels_for_page3'] = $input['specific_pixels_for_page3'];
		$valid['specific_page3'] = $input['specific_page3'];
		$valid['specific_pixels_for_page4'] = $input['specific_pixels_for_page4'];
		$valid['specific_page4'] = $input['specific_page4'];

		return $valid;
	}

}
