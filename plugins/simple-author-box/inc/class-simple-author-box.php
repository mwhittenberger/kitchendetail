<?php

/**
*
*/
class Simple_Author_Box {

	private static $instance = null;
	private $options;

	function __construct() {

		$this->options = get_option( 'saboxplugin_options', array() );

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();

	}

	public static function get_instance() {
		if ( is_null( self::$instance ) ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	private function load_dependencies() {

		require_once SIMPLE_AUTHOR_BOX_PATH . 'inc/class-simple-author-box-helper.php';
		require_once SIMPLE_AUTHOR_BOX_PATH . 'inc/functions.php';

		if ( is_admin() ) {
			require_once SIMPLE_AUTHOR_BOX_PATH . 'inc/class-simple-author-box-admin-page.php';
			require_once SIMPLE_AUTHOR_BOX_PATH . 'inc/class-simple-author-box-user-profile.php';
		}
	}

	private function set_locale() {
		load_plugin_textdomain( 'saboxplugin', false, SIMPLE_AUTHOR_BOX_PATH . 'lang/' );
	}

	private function define_admin_hooks() {

		if ( ! is_admin() ) {
			return;
		}

		add_action( 'admin_enqueue_scripts', array( $this, 'admin_style_and_scripts' ) );
		add_filter( 'user_contactmethods', array( $this, 'add_extra_fields' ) );
		add_filter( 'plugin_action_links_' . SIMPLE_AUTHOR_BOX_SLUG, array( $this, 'settings_link' ) );

	}

	private function define_public_hooks() {

		if ( ! isset( $this->options['sab_autoinsert'] ) ) {
			add_filter( 'the_content', 'wpsabox_author_box' );
		}

		add_action( 'wp_enqueue_scripts', array( $this, 'saboxplugin_author_box_style' ), 10 );

		if ( isset( $this->options['sab_footer_inline_style'] ) ) {
			add_action(
				'wp_footer', array(
					$this,
					'inline_style',
				), 13
			);
		} else {
			add_action( 'wp_head', array( $this, 'inline_style' ), 15 );
		}

		add_shortcode( 'simple-author-box', array( $this, 'shortcode' ) );
		add_filter( 'sabox_hide_social_icons', array( $this, 'show_social_media_icons' ), 10, 2 );

	}

	public function settings_link( $links ) {
		$settings_link = '<a href="' . admin_url( 'admin.php?page=simple-author-box-options' ) . '">' . __( 'Settings', 'saboxplugin' ) . '</a>';
		array_unshift( $links, $settings_link );
		return $links;
	}

	public function admin_style_and_scripts( $hook ) {

		$suffix = '.min';
		if ( SIMPLE_AUTHOR_SCRIPT_DEBUG ) {
			$suffix = '';
		}

		wp_enqueue_style( 'sabox-css', SIMPLE_AUTHOR_BOX_ASSETS . 'css/sabox.css' );

		if ( 'toplevel_page_simple-author-box-options' == $hook ) {

			// Styles
			wp_enqueue_style( 'wp-color-picker' );
			wp_enqueue_style( 'jquery-ui', SIMPLE_AUTHOR_BOX_ASSETS . 'css/jquery-ui.min.css' );
			wp_enqueue_style( 'saboxplugin-admin-style', SIMPLE_AUTHOR_BOX_ASSETS . 'css/sabox-admin-style' . $suffix . '.css' );

			// Scripts
			wp_enqueue_script( 'sabox-admin-js', SIMPLE_AUTHOR_BOX_ASSETS . 'js/sabox-admin.js', array( 'jquery-ui-slider', 'wp-color-picker' ), false, true );
			wp_enqueue_script( 'sabox-plugin-install', SIMPLE_AUTHOR_BOX_ASSETS . 'js/plugin-install.js', array( 'jquery', 'updates' ), '1.0.0', 'all' );

		} elseif ( 'profile.php' == $hook || 'user-edit.php' == $hook ) {

			wp_enqueue_style( 'saboxplugin-admin-style', SIMPLE_AUTHOR_BOX_ASSETS . 'css/sabox-admin-style' . $suffix . '.css' );

			wp_enqueue_media();
			wp_enqueue_editor();
			wp_enqueue_script( 'sabox-admin-editor-js', SIMPLE_AUTHOR_BOX_ASSETS . 'js/sabox-editor.js', array(), false, true );
			$sabox_js_helper = array();
			$social_icons    = apply_filters( 'sabox_social_icons', Simple_Author_Box_Helper::$social_icons );
			unset( $social_icons['user_email'] );
			$sabox_js_helper['socialIcons'] = $social_icons;

			wp_localize_script( 'sabox-admin-editor-js', 'SABHerlper', $sabox_js_helper );

		}

	}

	public function add_extra_fields( $extra_fields ) {

		unset( $extra_fields['aim'] );
		unset( $extra_fields['jabber'] );
		unset( $extra_fields['yim'] );

		return $extra_fields;

	}

	/*----------------------------------------------------------------------------------------------------------
		Adding the author box main CSS
	-----------------------------------------------------------------------------------------------------------*/
	public function saboxplugin_author_box_style() {

		$suffix = '.min';
		if ( SIMPLE_AUTHOR_SCRIPT_DEBUG ) {
			$suffix = '';
		}

		$sab_protocol   = is_ssl() ? 'https' : 'http';
		$sab_box_subset = get_option( 'sab_box_subset' );
		if ( 'none' != $sab_box_subset ) {
			$sab_subset = '&amp;subset=' . $sab_box_subset;
		} else {
			$sab_subset = '&amp;subset=latin';
		}

		$sab_author_font = get_option( 'sab_box_name_font', 'None' );
		$sab_desc_font   = get_option( 'sab_box_desc_font', 'None' );
		$sab_web_font    = get_option( 'sab_box_web_font', 'None' );

		$google_fonts = array();

		if ( $sab_author_font && 'None' != $sab_author_font && 'none' != $sab_author_font ) {
			$google_fonts[] = str_replace( ' ', '+', esc_attr( $sab_author_font ) ) . ':400,700,400italic,700italic';
		}

		if ( $sab_desc_font && 'None' != $sab_desc_font && 'none' != $sab_desc_font ) {
			$google_fonts[] = str_replace( ' ', '+', esc_attr( $sab_desc_font ) ) . ':400,700,400italic,700italic';
		}

		if ( isset( $this->options['sab_web'] ) && $sab_web_font && 'None' != $sab_web_font && 'none' != $sab_web_font ) {
			$google_fonts[] = str_replace( ' ', '+', esc_attr( $sab_web_font ) ) . ':400,700,400italic,700italic';
		}

		$google_fonts = apply_filters( 'sabox_google_fonts', $google_fonts );

		if ( ! empty( $google_fonts ) ) {
			wp_register_style( 'sab-font', $sab_protocol . '://fonts.googleapis.com/css?family=' . implode( '|', $google_fonts ) . $sab_subset, array(), null );
		}

		if ( ! isset( $this->options['sab_load_fa'] ) ) {
			wp_register_style( 'font-awesome', '//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css' );
		}

		wp_register_style( 'sab-plugin', SIMPLE_AUTHOR_BOX_ASSETS . 'css/simple-author-box' . $suffix . '.css', false, SIMPLE_AUTHOR_BOX_VERSION );

		if ( ! is_single() and ! is_page() and ! is_author() and ! is_archive() ) {
			return;
		}

		if ( ! empty( $google_fonts ) ) {
			wp_enqueue_style( 'sab-font' );
		}

		if ( ! isset( $this->options['sab_load_fa'] ) ) {
			wp_enqueue_style( 'font-awesome' );
		}

		wp_enqueue_style( 'sab-plugin' );

	}

	public function inline_style() {

		if ( ! is_single() and ! is_page() and ! is_author() and ! is_archive() ) {
			return;
		}

		$style  = '<style type="text/css">';
		$style .= Simple_Author_Box_Helper::generate_inline_css();
		$style .= '</style>';

		echo $style;
	}

	public function shortcode( $atts ) {
		$html = wpsabox_author_box();
		return $html;
	}



	public function show_social_media_icons( $return, $user ) {
		if ( in_array( 'sab-guest-author', (array) $user->roles ) ) {
			return false;
		}

		return true;
	}

}
