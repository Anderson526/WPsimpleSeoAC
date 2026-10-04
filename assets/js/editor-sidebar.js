/**
 * AC Simple SEO: panel en la barra lateral del editor de bloques.
 * Sin paso de compilación: usa los paquetes globales de wp.*.
 */
( function ( wp ) {
	'use strict';

	if ( ! wp || ! wp.plugins ) {
		return;
	}

	var registerPlugin = wp.plugins.registerPlugin;
	// WP 6.6+ lo expone en wp.editor; versiones anteriores en wp.editPost.
	var PluginDocumentSettingPanel =
		( wp.editor && wp.editor.PluginDocumentSettingPanel ) ||
		( wp.editPost && wp.editPost.PluginDocumentSettingPanel );

	if ( ! PluginDocumentSettingPanel ) {
		return;
	}

	var el = wp.element.createElement;
	var useSelect = wp.data.useSelect;
	var useDispatch = wp.data.useDispatch;
	var TextControl = wp.components.TextControl;
	var TextareaControl = wp.components.TextareaControl;
	var __ = wp.i18n.__;
	var sprintf = wp.i18n.sprintf;

	var META_TITLE = '_anderc_seo_title';
	var META_DESC = '_anderc_seo_desc';
	var TITLE_MAX = 60;
	var DESC_MAX = 160;

	/**
	 * Contador de caracteres estilo semáforo.
	 */
	function Counter( props ) {
		var length = ( props.value || '' ).length;
		var state = 'empty';

		if ( length > 0 ) {
			if ( length > props.max ) {
				state = 'over';
			} else if ( props.min && length < props.min ) {
				state = 'short';
			} else {
				state = 'ok';
			}
		}

		var labels = {
			empty: __( 'Sin contenido: se usará el valor por defecto.', 'anderc-simple-seo' ),
			short: __( 'Un poco corto, puedes añadir más detalle.', 'anderc-simple-seo' ),
			ok: __( 'Longitud óptima.', 'anderc-simple-seo' ),
			over: __( 'Demasiado largo: se recortará en los resultados.', 'anderc-simple-seo' )
		};

		return el(
			'p',
			{ className: 'anderc-seo-counter anderc-seo-counter--' + state },
			el( 'span', { className: 'anderc-seo-counter__dot' } ),
			sprintf( '%1$d / %2$d — ', length, props.max ) + labels[ state ]
		);
	}

	function SeoPanel() {
		var meta = useSelect( function ( select ) {
			return select( 'core/editor' ).getEditedPostAttribute( 'meta' ) || {};
		}, [] );

		var editPost = useDispatch( 'core/editor' ).editPost;

		function updateMeta( key, value ) {
			var changes = {};
			changes[ key ] = value;
			editPost( { meta: changes } );
		}

		return el(
			PluginDocumentSettingPanel,
			{
				name: 'anderc-seo-panel',
				title: __( 'AC SEO', 'anderc-simple-seo' ),
				className: 'anderc-seo-panel'
			},
			el( TextControl, {
				label: __( 'Título SEO', 'anderc-simple-seo' ),
				help: __( 'Sustituye al título de la entrada en buscadores.', 'anderc-simple-seo' ),
				value: meta[ META_TITLE ] || '',
				onChange: function ( value ) {
					updateMeta( META_TITLE, value );
				}
			} ),
			el( Counter, { value: meta[ META_TITLE ], max: TITLE_MAX } ),
			el( TextareaControl, {
				label: __( 'Meta descripción', 'anderc-simple-seo' ),
				help: __( 'Resumen que aparece bajo el título en los resultados de búsqueda.', 'anderc-simple-seo' ),
				rows: 4,
				value: meta[ META_DESC ] || '',
				onChange: function ( value ) {
					updateMeta( META_DESC, value );
				}
			} ),
			el( Counter, { value: meta[ META_DESC ], max: DESC_MAX, min: 80 } )
		);
	}

	registerPlugin( 'anderc-simple-seo', {
		render: SeoPanel,
		icon: 'search'
	} );
} )( window.wp );
