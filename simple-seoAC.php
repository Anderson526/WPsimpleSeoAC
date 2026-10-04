<?php
/*
Plugin Name:  Simple SEO & Meta Manager - toolkitAC
Plugin URI: https://anderson526.github.io/portfolio-profesional/
Description: SEO On-Page esencial: título SEO, meta descripción y etiquetas Open Graph directamente en el editor de bloques, sin menús sobrecargados. Parte de la suite AC Essential.
Version: 1.0.0
Author: Anderson Chila
Author URI: https://anderson526.github.io/portfolio-profesional/
Text Domain: anderc-simple-seo
Domain Path: /languages
Requires at least: 6.0
Requires PHP: 7.4
License: GPL-2.0-or-later
*/

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'ANDERC_ASEO_VERSION', '1.0.0' );
define( 'ANDERC_ASEO_FILE', __FILE__ );
define( 'ANDERC_ASEO_DIR', plugin_dir_path( __FILE__ ) );
define( 'ANDERC_ASEO_URL', plugin_dir_url( __FILE__ ) );

// Autoloader estilo PSR-4 (compatible con Composer si se añade vendor/).
spl_autoload_register(
	function ( $class ) {
		if ( 0 !== strpos( $class, 'ASEO_' ) ) {
			return;
		}
		$file = ANDERC_ASEO_DIR . 'includes/class-' . str_replace( '_', '-', strtolower( $class ) ) . '.php';
		if ( file_exists( $file ) ) {
			require_once $file;
		}
	}
);

if ( file_exists( ANDERC_ASEO_DIR . 'vendor/autoload.php' ) ) {
	require_once ANDERC_ASEO_DIR . 'vendor/autoload.php';
}

ASEO_Plugin::instance();
