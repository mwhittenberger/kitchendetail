<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       http://mikethetechninja.com
 * @since      1.0.0
 *
 * @package    Wordpress_Loves_Constant_Contact
 * @subpackage Wordpress_Loves_Constant_Contact/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Wordpress_Loves_Constant_Contact
 * @subpackage Wordpress_Loves_Constant_Contact/includes
 * @author     Mike the Tech Ninja <mike@panempire.com>
 */
class Wordpress_Loves_Constant_Contact_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'wordpress-loves-constant-contact',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
