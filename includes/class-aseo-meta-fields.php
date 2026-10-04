<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Registra los post meta con soporte REST para que Gutenberg los guarde automáticamente.
 */
class ASEO_Meta_Fields {

	public function __construct() {
		add_action( 'init', array( $this, 'register_meta' ), 20 );
	}

	public function register_meta() {
		foreach ( ASEO_Plugin::supported_post_types() as $post_type ) {
			register_post_meta(
				$post_type,
				ASEO_Plugin::META_TITLE,
				array(
					'show_in_rest'      => true,
					'single'            => true,
					'type'              => 'string',
					'default'           => '',
					'sanitize_callback' => 'sanitize_text_field',
					'auth_callback'     => array( $this, 'can_edit' ),
				)
			);

			register_post_meta(
				$post_type,
				ASEO_Plugin::META_DESC,
				array(
					'show_in_rest'      => true,
					'single'            => true,
					'type'              => 'string',
					'default'           => '',
					'sanitize_callback' => 'sanitize_textarea_field',
					'auth_callback'     => array( $this, 'can_edit' ),
				)
			);
		}
	}

	public function can_edit( $allowed, $meta_key, $post_id ) {
		return current_user_can( 'edit_post', $post_id );
	}
}
