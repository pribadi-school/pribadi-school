/**
 * Transparent-to-solid sticky header.
 *
 * Adds/removes the .is-solid class on #site-header once the hero section
 * (any element with the "hero-video" CSS class) has scrolled up past the
 * header. All appearance lives in assets/css/transparent-header.css.
 */
( function () {
	'use strict';

	var HEADER_SELECTOR = '#site-header';
	var HERO_SELECTOR = '.hero-video';
	// The homepage hero is position:sticky, so it never scrolls out of view
	// and can't signal when to go solid. When this 1px marker at the hero's
	// bottom edge is present, watch it instead.
	var SENTINEL_SELECTOR = '.hp-hero-sentinel';
	var LOGO_SELECTOR = '.elementor-widget-image img';
	var SOLID_CLASS = 'is-solid';
	var LOGO_SWAP_CLASS = 'owpc-logo-swapping';
	var RESIZE_DEBOUNCE = 150;
	// Half of --owpc-header-speed (300ms): the logo dips to 0 opacity, the
	// red/white `content` swap happens invisibly at the midpoint (that part
	// still can't be animated - content: url() has no in-between state),
	// then fades back in. Matches transparent-header.css's own speed.
	var LOGO_SWAP_MS = 150;

	var header = null;
	var hero = null;
	var target = null;
	var logo = null;
	var observer = null;
	var resizeTimer = null;
	var logoSwapTimer = null;

	function headerHeight() {
		return header ? Math.round( header.getBoundingClientRect().height ) : 0;
	}

	function setSolid( isSolid ) {
		if ( header.classList.contains( SOLID_CLASS ) === isSolid ) {
			return;
		}

		header.classList.toggle( SOLID_CLASS, isSolid );

		if ( logo ) {
			window.clearTimeout( logoSwapTimer );
			logo.classList.add( LOGO_SWAP_CLASS );
			logoSwapTimer = window.setTimeout( function () {
				logo.classList.remove( LOGO_SWAP_CLASS );
			}, LOGO_SWAP_MS );
		}
	}

	/**
	 * Preferred path: watch the sentinel (or the hero itself, when there
	 * isn't one), so the switch happens at the hero's real bottom edge no
	 * matter how tall it is.
	 */
	function observeHero() {
		if ( observer ) {
			observer.disconnect();
		}

		// Measure while transparent so the trigger point stays stable.
		var offset = header.classList.contains( SOLID_CLASS ) ? 0 : headerHeight();

		observer = new IntersectionObserver(
			function ( entries ) {
				// Deliberately not isIntersecting: the sentinel is 1px tall,
				// so it reads as "not intersecting" both above the header
				// AND below the fold, which would flip the header solid at
				// the top of the page. Comparing the target's own bottom
				// edge against the header distinguishes the two, and gives
				// the same result as isIntersecting when the target is the
				// full-height hero.
				setSolid( entries[ 0 ].boundingClientRect.bottom <= offset );
			},
			{
				rootMargin: '-' + offset + 'px 0px 0px 0px',
				threshold: 0,
			}
		);

		observer.observe( target );
	}

	/**
	 * Fallback when there is no hero on the page, or no IntersectionObserver.
	 */
	function watchScroll() {
		var ticking = false;

		function threshold() {
			if ( hero ) {
				return hero.offsetTop + hero.offsetHeight - headerHeight();
			}
			return window.innerHeight * 0.8;
		}

		function onScroll() {
			if ( ticking ) {
				return;
			}
			ticking = true;
			window.requestAnimationFrame( function () {
				setSolid( window.pageYOffset >= threshold() );
				ticking = false;
			} );
		}

		window.addEventListener( 'scroll', onScroll, { passive: true } );
		onScroll();
	}

	function onResize() {
		window.clearTimeout( resizeTimer );
		resizeTimer = window.setTimeout( function () {
			if ( observer ) {
				observeHero();
			}
		}, RESIZE_DEBOUNCE );
	}

	function init() {
		header = document.querySelector( HEADER_SELECTOR );

		if ( ! header ) {
			return;
		}

		logo = header.querySelector( LOGO_SELECTOR );
		hero = document.querySelector( HERO_SELECTOR );
		target = document.querySelector( SENTINEL_SELECTOR ) || hero;

		if ( target && 'IntersectionObserver' in window ) {
			observeHero();
			window.addEventListener( 'resize', onResize, { passive: true } );
		} else {
			watchScroll();
		}
	}

	if ( 'loading' === document.readyState ) {
		document.addEventListener( 'DOMContentLoaded', init );
	} else {
		init();
	}
} )();
