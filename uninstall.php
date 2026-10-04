<?php
// Limpieza al desinstalar: borra los metadatos SEO de todas las entradas.
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit;
}

delete_post_meta_by_key( '_anderc_seo_title' );
delete_post_meta_by_key( '_anderc_seo_desc' );
