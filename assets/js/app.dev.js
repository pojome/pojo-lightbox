/*!
 * @author: Pojo Team
 */
/* global jQuery, PojoLightboxOptions */

( function( $, window, document, undefined ) {
	'use strict';

	var Pojo_LightBox_App = {
		cache: {
			$document: $( document ),
			$window: $( window )
		},

		cacheElements: function() {},

		buildElements: function() {},

		bindEvents: function() {
			switch ( PojoLightboxOptions.script_type ) {
				case 'prettyPhoto' :
					this._bindEventsPrettyPhoto();
					break;
				
				case 'magnific' :
					this._bindEventsMagnificPopup();
					break;
			}
		},

		// Bind for prettyPhoto
		_bindEventsPrettyPhoto: function() {
			var isMobile = Modernizr.mq( 'only screen and (max-width: 600px)' );
			
			if ( 'disable' !== PojoLightboxOptions.smartphone || ! isMobile ) {
				if ( isMobile ) {
					PojoLightboxOptions.lightbox_args.allow_expand = false;
				}
				var lightbox_single_args = PojoLightboxOptions.lightbox_args,
					$body;
				
				if ( 'disable' === PojoLightboxOptions.woocommerce ) {
					$body = $( 'body:not(.woocommerce)' );
				} else {
					$body = $( 'body' );
				}

				$( 'a', $body )
					.filter( function() {
						return ( /\.(jpg|jpeg|gif|png)$/i.test( $( this ).attr( 'href' ) ) );
					} )
					.has( 'img' )
					.prettyPhoto( lightbox_single_args );

				$( 'a[rel^="lightbox"]', $body )
					.prettyPhoto( PojoLightboxOptions.lightbox_args );
			}
		},

		// Bind for Magnific Popup
		_bindEventsMagnificPopup: function() {
			var $body;
			
			if ( 'disable' === PojoLightboxOptions.woocommerce ) {
				$body = $( 'body:not(.woocommerce)' );
			} else {
				$body = $( 'body' );
			}

			$( 'a', $body )
				.filter( function() {
					return ( /\.(jpg|jpeg|gif|png)$/i.test( $( this ).attr( 'href' ) ) );
				} )
				.filter( function() {
					// Is in WordPress Gallery?
					return ( 0 === $( this ).closest( 'div.gallery' ).length );
				} )
				.has( 'img' )
				.magnificPopup( {
					type: 'image'
				} );
			
			// WordPress Gallery
			$( 'div.gallery' ).magnificPopup( {
				delegate: 'a',
				type: 'image',
				gallery: {
					enabled: true,
					navigateByImgClick: true,
					preload: [0, 1]
				}
			} );
		},

		init: function() {
			this.cacheElements();
			this.buildElements();
			this.bindEvents();
		}
	};

	$( document ).ready( function( $ ) {
		Pojo_LightBox_App.init();
	} );

}( jQuery, window, document ) );
