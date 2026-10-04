<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Inyecta el panel "AC SEO" en la barra lateral del editor de bloques.
 */
class ASEO_Editor {

	public function __construct() {
		add_action( 'enqueue_block_editor_assets', array( $this, 'enqueue' ) );
	}

	public function enqueue() {
		$screen = function_exists( 'get_current_screen' ) ? get_current_screen() : null;
		if ( $screen && ! in_array( $screen->post_type, ASEO_Plugin::supported_post_types(), true ) ) {
			return;
		}

		wp_enqueue_script(
			'anderc-aseo-editor',
			ANDERC_ASEO_URL . 'assets/js/editor-sidebar.js',
			array( 'wp-plugins', 'wp-edit-post', 'wp-element', 'wp-components', 'wp-data', 'wp-i18n' ),
			ANDERC_ASEO_VERSION,
			true
		);

		wp_enqueue_style(
			'anderc-aseo-editor',
			ANDERC_ASEO_URL . 'assets/css/editor.css',
			array(),
			ANDERC_ASEO_VERSION
		);

		wp_set_script_translations( 'anderc-aseo-editor', 'anderc-simple-seo' );
	}
}
