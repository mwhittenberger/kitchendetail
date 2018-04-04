<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       http://mikethetechninja.com
 * @since      1.0.0
 *
 * @package    Wordpress_Loves_Constant_Contact
 * @subpackage Wordpress_Loves_Constant_Contact/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Wordpress_Loves_Constant_Contact
 * @subpackage Wordpress_Loves_Constant_Contact/public
 * @author     Mike the Tech Ninja <mike@panempire.com>
 */
class Wordpress_Loves_Constant_Contact_Public {

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
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Wordpress_Loves_Constant_Contact_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Wordpress_Loves_Constant_Contact_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		//wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/wordpress-loves-constant-contact-public.css', array(), $this->version, 'all' );
		

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Wordpress_Loves_Constant_Contact_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Wordpress_Loves_Constant_Contact_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

	}

	public function my_custom_field_checkboxes() {
		if($_GET['post'] && $_GET['action'] == 'edit') {
			add_meta_box(
				'wplcc',          // this is HTML id of the box on edit screen
				'Email Blast a Blog Post Promo with Constant Contact',    // title of the box
				'my_customfield_box_content',   // function to be called to display the checkboxes, see the function below
				'post',        // on which edit screen the box should appear
				'normal',      // part of page where the box should appear
				'default'      // priority of the box
			);
		}
	}

	

	

}
