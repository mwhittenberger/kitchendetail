<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       http://lamarkmedia.com
 * @since      1.0.0
 *
 * @package    Lm_pixel_placer
 * @subpackage Lm_pixel_placer/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Lm_pixel_placer
 * @subpackage Lm_pixel_placer/includes
 * @author     Lamark Media <webadmin@lamarkmedia.com>
 */
class Lm_pixel_placer_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'lm_pixel_placer',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
