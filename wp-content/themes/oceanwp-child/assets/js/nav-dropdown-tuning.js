/**
 * Tunes the header dropdown's open/close timing and animation.
 *
 * The nav-menu widget's own frontend handler initializes SmartMenus with
 * only `subIndicators`/`subMenusMaxWidth` set, so everything else falls
 * back to SmartMenus' defaults: a 250ms delay before opening, a 500ms
 * delay before closing, and no open animation at all (it just snaps
 * visible). That reads as slow and janky, so showFunction/hideFunction
 * below replace it with a quick fade + drop-down-from-above (translateY)
 * using a real CSS transition (GPU-composited, smoother than jQuery's
 * JS-stepped fadeIn/fadeOut) instead of SmartMenus' own animation.
 *
 * SmartMenus (this bundled version) has no public "option" setter, but it
 * keeps its live config on the instance as `.opts` and re-reads it on every
 * show/hide, so mutating it in place after init is enough - no need to
 * destroy/reinit or touch the vendor file.
 */
( function ( $ ) {
	'use strict';

	function tuneDropdown( $scope ) {
		var $menu = $scope.find( '.elementor-nav-menu' );
		var instance = $menu.data( 'smartmenus' );

		if ( ! instance ) {
			return;
		}

		var DURATION = 220;
		var DROP_DISTANCE = '-8px';
		// Standard "material" ease-out: smooth constant deceleration, no snap.
		var EASING = 'cubic-bezier(0.25, 0.1, 0.25, 1)';

		function show( $ul, complete ) {
			$ul.stop( true, true );
			window.clearTimeout( $ul.data( 'owpc-anim-timer' ) );

			$ul.css( {
				transition: 'none',
				willChange: 'opacity, transform',
				display: 'block',
				opacity: 0,
				transform: 'translateY(' + DROP_DISTANCE + ')'
			} );

			// Force a reflow so the transition below animates from the state
			// just set above, instead of the browser coalescing both writes.
			void $ul[ 0 ].offsetHeight;

			$ul.css( {
				transition: 'opacity ' + DURATION + 'ms ' + EASING + ', transform ' + DURATION + 'ms ' + EASING,
				opacity: 1,
				transform: 'translateY(0)'
			} );

			$ul.data( 'owpc-anim-timer', window.setTimeout( complete, DURATION ) );
		}

		function hide( $ul, complete ) {
			$ul.stop( true, true );
			window.clearTimeout( $ul.data( 'owpc-anim-timer' ) );

			$ul.css( {
				transition: 'opacity ' + DURATION + 'ms ' + EASING + ', transform ' + DURATION + 'ms ' + EASING,
				opacity: 0,
				transform: 'translateY(' + DROP_DISTANCE + ')'
			} );

			$ul.data( 'owpc-anim-timer', window.setTimeout( function () {
				$ul.css( { display: 'none', transition: 'none', willChange: 'auto' } );
				complete();
			}, DURATION ) );
		}

		function collapsibleShow( $ul, complete ) {
			$ul.stop( true, true ).css( { opacity: 0 } ).slideDown( DURATION, complete );
			$ul.animate( { opacity: 1 }, DURATION );
		}

		function collapsibleHide( $ul, complete ) {
			$ul.stop( true, true ).animate( { opacity: 0 }, DURATION );
			$ul.slideUp( DURATION, complete );
		}

		$.extend( instance.opts, {
			showTimeout: 0,
			hideTimeout: 120,
			showDuration: DURATION,
			hideDuration: DURATION,
			showFunction: show,
			hideFunction: hide,
			// The mobile/hamburger menu (SmartMenus' "collapsible" mode) only
			// slides by default - no opacity change - so it doesn't get the
			// same fade the desktop dropdown above does. Add it here.
			collapsibleShowDuration: DURATION,
			collapsibleHideDuration: DURATION,
			collapsibleShowFunction: collapsibleShow,
			collapsibleHideFunction: collapsibleHide
		} );
	}

	jQuery( window ).on( 'elementor/frontend/init', function () {
		elementorFrontend.hooks.addAction( 'frontend/element_ready/nav-menu.default', tuneDropdown );
	} );
} )( jQuery );
