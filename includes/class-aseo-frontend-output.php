<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Inyección en frontend: título, meta descripción y etiquetas Open Graph.
 */
class ASEO_Frontend_Output {

	public function __construct() {
		add_filter( 'document_title_parts', array( $this, 'filter_title' ) );
		add_action( 'wp_head', array( $this, 'print_meta_tags' ), 1 );
	}

	public function filter_title( $parts ) {
		if ( ! is_singular() ) {
			return $parts;
		}

		$custom = get_post_meta( get_queried_object_id(), ASEO_Plugin::META_TITLE, true );
		if ( '' !== (string) $custom ) {
			$parts['title'] = $custom;
		}

		return $parts;
	}

	public function print_meta_tags() {
		if ( ! is_singular() ) {
			return;
		}

		$post_id = get_queried_object_id();
		$post    = get_post( $post_id );
		if ( ! $post ) {
			return;
		}

		$title = get_post_meta( $post_id, ASEO_Plugin::META_TITLE, true );
		$title = '' !== (string) $title ? $title : wp_get_document_title();

		$desc = get_post_meta( $post_id, ASEO_Plugin::META_DESC, true );
		if ( '' === (string) $desc ) {
			// Por defecto, un extracto limpio del contenido.
			$desc = wp_trim_words( wp_strip_all_tags( get_the_excerpt( $post ) ), 30, '…' );
		}

		echo "\n<!-- AC Simple SEO -->\n";

		if ( '' !== (string) $desc ) {
			printf( '<meta name="description" content="%s" />' . "\n", esc_attr( $desc ) );
		}

		printf( '<meta property="og:type" content="%s" />' . "\n", is_front_page() ? 'website' : 'article' );
		printf( '<meta property="og:title" content="%s" />' . "\n", esc_attr( $title ) );
		if ( '' !== (string) $desc ) {
			printf( '<meta property="og:description" content="%s" />' . "\n", esc_attr( $desc ) );
		}
		printf( '<meta property="og:url" content="%s" />' . "\n", esc_url( get_permalink( $post_id ) ) );
		printf( '<meta property="og:site_name" content="%s" />' . "\n", esc_attr( get_bloginfo( 'name' ) ) );
		printf( '<meta property="og:locale" content="%s" />' . "\n", esc_attr( get_locale() ) );

		// Imagen destacada del post como imagen por defecto para compartir.
		$image = get_the_post_thumbnail_url( $post_id, 'large' );
		if ( $image ) {
			printf( '<meta property="og:image" content="%s" />' . "\n", esc_url( $image ) );
			echo '<meta name="twitter:card" content="summary_large_image" />' . "\n";
		} else {
			echo '<meta name="twitter:card" content="summary" />' . "\n";
		}

		printf( '<meta name="twitter:title" content="%s" />' . "\n", esc_attr( $title ) );
		if ( '' !== (string) $desc ) {
			printf( '<meta name="twitter:description" content="%s" />' . "\n", esc_attr( $desc ) );
		}

		echo "<!-- /AC Simple SEO -->\n";
	}
}
