<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Núcleo del plugin: carga los módulos de metadatos, editor y frontend.
 */
final class ASEO_Plugin {

	const META_TITLE = '_anderc_seo_title';
	const META_DESC  = '_anderc_seo_desc';

	private static $instance = null;

	public static function instance() {
		if ( null === self::$instance ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	private function __construct() {
		add_action( 'init', array( $this, 'load_textdomain' ) );

		new ASEO_Meta_Fields();
		new ASEO_Editor();
		new ASEO_Frontend_Output();
	}

	public function load_textdomain() {
		load_plugin_textdomain( 'anderc-simple-seo', false, dirname( plugin_basename( ANDERC_ASEO_FILE ) ) . '/languages' );
	}

	/**
	 * Tipos de contenido públicos donde se habilita el SEO (excluye adjuntos).
	 */
	public static function supported_post_types() {
		$types = get_post_types( array( 'public' => true ), 'names' );
		unset( $types['attachment'] );
		return array_values( $types );
	}
}
