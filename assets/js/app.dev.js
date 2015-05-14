/*!
 * @author: Pojo Team
 */
/* global jQuery, PojoLightboxOptions */

( function( $, window, document, PhotoSwipeUI_Default, undefined ) {
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
				
				case 'photoswipe' :
					this._bindEventsPhotoSwipe();
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

		// Bind for Photo Swipe
		_bindEventsPhotoSwipe: function() {
			var $photosWipeTemplate = $('.pswp')[0],
				globalOptions = PojoLightboxOptions.lightbox_args;
			
			var _parseItemOptionsFromSelector = function( $this ) {
					var image_size = $this.data( 'size' ),
						image_width = 0,
						image_height = 0;

					if ( undefined !== image_size ) {
						image_size = image_size.split( 'x' );
						image_width = image_size[0];
						image_height = image_size[1];
					}

					return {
						src: $this.attr( 'href' ),
						w: image_width,
						h: image_height,
						title: $this.find( 'img' ).attr( 'alt' ),
						el: $this[0]
					};
				},

				_getThumbBoundsFn = function( index, items ) {
					var thumbnail = items[index].el.children[0];
					if ( undefined === thumbnail ) {
						return null;
					}
					
					var pageYScroll = window.pageYOffset || document.documentElement.scrollTop,
						rect = thumbnail.getBoundingClientRect();

					return {x: rect.left, y: rect.top + pageYScroll, w: rect.width};
				};
			
			// Single Images
			var $body;

			if ( 'disable' === PojoLightboxOptions.woocommerce ) {
				$body = $( 'body:not(.woocommerce)' );
			} else {
				$body = $( 'body' );
			}

			var $singleImages = $( 'a', $body )
				.filter( function() {
					return ( /\.(jpg|jpeg|gif|png)$/i.test( $( this ).attr( 'href' ) ) );
				} )
				.filter( function() {
					// Is in WordPress Gallery?
					return ( 0 === $( this ).closest( 'div.gallery' ).length );
				} )
				.has( 'img' );

			$singleImages.on( 'click', function( event ) {
				event.preventDefault();

				var items = [ _parseItemOptionsFromSelector( $( this ) ) ];
				var options = {
					getThumbBoundsFn: function( index ) {
						return _getThumbBoundsFn( index, items );
					}
				};
				options = $.extend( {}, globalOptions, options );
				var gallery = new PhotoSwipe( $photosWipeTemplate, PhotoSwipeUI_Default, items, options );
				gallery.listen( 'gettingData', function( index, item ) {
					if ( item.w < 1 || item.h < 1 ) { // unknown size
						var img = new Image();
						img.onload = function() { // will get size after load
							item.w = this.width; // set image width
							item.h = this.height; // set image height
							gallery.invalidateCurrItems(); // reinit Items
							gallery.updateSize( true ); // reinit Items
						};
						img.src = item.src; // let's download image
					}
				} );
				gallery.init();
			} );
			
			// WordPress Gallery
			$( 'div.gallery, div.pojo-gallery' ).each( function() {
				var $thisGallery = $( this ),
					
					_getItems = function() {
						var items = [];
						
						$thisGallery.find( 'a' ).each( function() {
							items.push( _parseItemOptionsFromSelector( $( this )) );
						} );
						
						return items;
					};

				var items = _getItems();

				$thisGallery.on( 'click', 'a', function( event ) {
					event.preventDefault();
					
					var options = {
						index: $thisGallery.find( 'a' ).index( this ),

						getThumbBoundsFn: function( index ) {
							return _getThumbBoundsFn( index, items );
						}
					};
					options = $.extend( {}, globalOptions, options );
					var gallery = new PhotoSwipe( $photosWipeTemplate, PhotoSwipeUI_Default, items, options );
					gallery.listen( 'gettingData', function( index, item ) {
						if ( item.w < 1 || item.h < 1 ) {
							var img = new Image();
							img.onload = function() {
								item.w = this.width;
								item.h = this.height;
								gallery.invalidateCurrItems();
								gallery.updateSize( true );
							};
							img.src = item.src;
						}
					} );
					gallery.init();
				} );
				
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

}( jQuery, window, document, PhotoSwipeUI_Default ) );
