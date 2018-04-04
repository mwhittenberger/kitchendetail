<?php

$plugins = array(
	'kiwi-social-share'        => array(
		'title'       => esc_html__( 'Kiwi Social Share – Social Media Share Buttons & Icons', 'saboxplugin' ),
		'description' => esc_html__( 'This is by far the best & easiest to use WordPress social media share plugin. A WordPress share plugin with custom icons built-in.', 'saboxplugin' ),
		'more'        => 'https://wordpress.org/plugins/kiwi-social-share/',
		'image'       => 'kiwi.png',
	),
	'speed-booster-pack'       => array(
		'title'       => esc_html__( 'Speed Booster Pack', 'saboxplugin' ),
		'description' => esc_html__( 'Speed Booster Pack is a lightweight, frequently updated, easy to use and well supported plugin which allows you to improve your website’s loading speed.', 'saboxplugin' ),
		'more'        => 'https://wordpress.org/plugins/speed-booster-pack/',
		'image'       => 'speed.png',
	),
	'modula-best-grid-gallery' => array(
		'title'       => esc_html__( 'Modula - A WordPress Gallery Plugin', 'saboxplugin' ),
		'description' => esc_html__( 'Modula is currently the easiest and fastest photo gallery plugin for WordPress. With its wizard you are able to build an image gallery in a few seconds, unlike many other WordPress gallery plugins.', 'saboxplugin' ),
		'more'        => 'https://wordpress.org/plugins/modula-best-grid-gallery/',
		'image'       => 'modula.jpg',
	),
);

if ( ! function_exists( 'get_plugins' ) || ! function_exists( 'is_plugin_active' ) ) {
	require_once ABSPATH . 'wp-admin/includes/plugin.php';
}

$installed_plugins = get_plugins();

function sab_get_plugin_basename_from_slug( $slug, $installed_plugins ) {
	$keys = array_keys( $installed_plugins );
	foreach ( $keys as $key ) {
		if ( preg_match( '|^' . $slug . '/|', $key ) ) {
			return $key;
		}
	}
	return $slug;
}

?>

<div class="sab-recomended-plugins">
	<?php
	foreach ( $plugins as $slug => $plugin ) {

		$label       = __( 'Install & Activate', 'saboxplugin' );
		$action      = 'install';
		$plugin_path = sab_get_plugin_basename_from_slug( $slug, $installed_plugins );
		$url         = '#';
		$class       = '';

		if ( file_exists( ABSPATH . 'wp-content/plugins/' . $plugin_path ) ) {

			if ( is_plugin_active( $plugin_path ) ) {
				$label  = __( 'Activated', 'saboxplugin' );
				$action = 'disable';
				$class  = 'disabled';
			} else {
				$label  = __( 'Activate', 'saboxplugin' );
				$action = 'activate';
				$url    = wp_nonce_url(
					add_query_arg(
						array(
							'action' => 'activate',
							'plugin' => $plugin_path,
						), admin_url( 'plugins.php' )
					), 'activate-plugin_' . $plugin_path
				);
			}
		}

	?>
		<div class="sab-recomended-plugin">
			<div class="plugin-image">
				<img src="<?php echo esc_url( SIMPLE_AUTHOR_BOX_ASSETS . 'img/' . $plugin['image'] ); ?>">
			</div>
			<div class="plugin-information">
				<p class="plugin-name"><strong><?php echo esc_html( $plugin['title'] ); ?></strong></p>
				<p class="plugin-description"><?php echo esc_html( $plugin['description'] ); ?></p>
				<a href="<?php echo esc_url( $url ); ?>" data-action="<?php echo esc_attr( $action ); ?>" data-slug="<?php echo esc_attr( $plugin_path ); ?>" data-message="<?php esc_html_e( 'Activated', 'saboxplugin' ); ?>" class="button-primary sab-plugin-button <?php echo esc_attr( $class ); ?>" ><?php echo esc_html( $label ); ?></a>
				<?php if ( isset( $plugin['more'] ) ) : ?>
					<a href="<?php echo esc_url( $plugin['more'] ); ?>" class="button-secondary" target="_blank"><?php esc_html_e( 'Find out more', 'saboxplugin' ); ?></a>
				<?php endif ?>
			</div>
		</div>
	<?php } ?>
</div>
