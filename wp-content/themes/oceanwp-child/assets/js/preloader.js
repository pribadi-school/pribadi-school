/**
 * Intro preloader - see assets/css/preloader.css for the look.
 *
 * Printed inline in the document head by functions.php (not enqueued), so it runs before
 * the body is parsed. Two phases:
 *
 *   1. Now, in the document head: decide whether this page view gets the preloader
 *      (first page of the tab's session only), and if so mark the root element with
 *      .owpc-preload and start fetching the logo at high priority.
 *   2. mount(), called by a one-line inline script from the wp_body_open
 *      hook: insert the screen as the first thing in the body, before any page
 *      content can paint.
 *
 * Exit: as soon as the page is actually ready (see whenReady) - but never
 * sooner than MIN_SHOW_MS after the screen appeared, so it can't read as an
 * accidental flash, and never later than MAX_WAIT_MS after navigation
 * started, so a slow asset can't hold visitors hostage. The screen then
 * fades out and is removed from the DOM entirely.
 *
 * Add ?preloader to any URL to force it on, e.g. to preview changes.
 */
( function () {
	'use strict';

	// Shortest time the screen stays up once it has appeared.
	var MIN_SHOW_MS = 800;
	// Longest the page may be held, counted from navigation start.
	var MAX_WAIT_MS = 3500;
	// The hero headline's own entrance (preloader.css): 150ms delay + 900ms.
	var HERO_ENTRANCE_MS = 1050;

	var STORAGE_KEY = 'owpcPreloaderSeen';
	var FORCE_PARAM = 'preloader';

	var root = document.documentElement;
	var config = window.owpcPreloaderConfig || {};

	function shouldShow() {
		if ( ! config.logo ) {
			return false;
		}

		try {
			if ( new URLSearchParams( window.location.search ).has( FORCE_PARAM ) ) {
				return true;
			}
		} catch ( e ) {}

		try {
			if ( window.sessionStorage.getItem( STORAGE_KEY ) ) {
				return false;
			}
			window.sessionStorage.setItem( STORAGE_KEY, '1' );
		} catch ( e ) {
			// Storage blocked (some private modes): show it, just unthrottled.
		}

		return true;
	}

	if ( ! shouldShow() ) {
		window.owpcPreloader = { mount: function () {} };
		return;
	}

	root.classList.add( 'owpc-preload' );

	var preload = document.createElement( 'link' );
	preload.rel = 'preload';
	preload.as = 'image';
	preload.href = config.logo;
	preload.setAttribute( 'fetchpriority', 'high' );
	document.head.appendChild( preload );

	var screen = null;
	var mountedAt = 0;
	var exiting = false;

	function now() {
		return window.performance && performance.now ? performance.now() : Date.now();
	}

	function exitDurationMs() {
		var value = window.getComputedStyle( root ).getPropertyValue( '--owpc-pl-exit-duration' ).trim();
		var n = parseFloat( value );

		if ( isNaN( n ) ) {
			return 600;
		}
		return /ms$/.test( value ) ? n : n * 1000;
	}

	function removeScreen() {
		if ( screen && screen.parentNode ) {
			screen.parentNode.removeChild( screen );
		}
		screen = null;
	}

	function releaseRoot() {
		root.classList.remove( 'owpc-preload', 'owpc-preload-exit' );
	}

	function startExit() {
		if ( exiting ) {
			return;
		}
		exiting = true;

		var exitMs = exitDurationMs();

		root.classList.add( 'owpc-preload-exit' );
		if ( screen ) {
			screen.classList.add( 'is-exiting' );
		}

		window.setTimeout( removeScreen, exitMs + 50 );
		// Keep the root element's classes until the hero headline has finished
		// rising, so its transition isn't swapped for the default one mid-flight.
		window.setTimeout( releaseRoot, Math.max( exitMs, HERO_ENTRANCE_MS ) + 100 );
	}

	function onDomReady( cb ) {
		if ( 'loading' === document.readyState ) {
			document.addEventListener( 'DOMContentLoaded', cb, { once: true } );
		} else {
			cb();
		}
	}

	/**
	 * Ready means whichever comes first:
	 *  - the full window load, or
	 *  - the DOM is parsed, web fonts are in, and the hero video (if the page
	 *    has one) has its first frame - i.e. what's under the screen is
	 *    fully drawn, even if images further down are still loading.
	 */
	function whenReady( cb ) {
		var fired = false;

		function go() {
			if ( ! fired ) {
				fired = true;
				cb();
			}
		}

		if ( 'complete' === document.readyState ) {
			go();
			return;
		}

		window.addEventListener( 'load', go, { once: true } );

		if ( 'function' !== typeof window.Promise ) {
			return;
		}

		onDomReady( function () {
			var waits = [];

			if ( document.fonts && document.fonts.ready ) {
				waits.push( document.fonts.ready );
			}

			var video = document.querySelector( '.hp-hero video' );
			if ( video && video.readyState < 2 ) {
				waits.push(
					new Promise( function ( resolve ) {
						video.addEventListener( 'loadeddata', resolve, { once: true } );
						video.addEventListener( 'error', resolve, { once: true } );
					} )
				);
			}

			Promise.all( waits ).then( go, go );
		} );
	}

	function mount() {
		if ( screen || exiting || ! document.body ) {
			return;
		}

		screen = document.createElement( 'div' );
		screen.className = 'owpc-preloader';
		screen.setAttribute( 'aria-hidden', 'true' );

		var mark = document.createElement( 'div' );
		mark.className = 'owpc-preloader__mark';

		var logo = document.createElement( 'img' );
		logo.className = 'owpc-preloader__logo';
		logo.alt = '';
		if ( config.width && config.height ) {
			logo.width = config.width;
			logo.height = config.height;
		}
		logo.setAttribute( 'fetchpriority', 'high' );

		// Only ever reveal a logo that actually loaded: if the file is missing
		// or blocked, the screen stays a plain background rather than showing
		// a broken-image icon for the second it's up.
		function showLogo() {
			if ( screen && logo.naturalWidth > 0 ) {
				screen.classList.add( 'is-logo-ready' );
			}
		}

		// 'load' rather than img.decode(): decode() on an image this large can
		// stay pending behind a busy main thread until after the screen has
		// already gone, so the logo would never show. load fires as soon as the
		// file is complete; the 400ms fade-in covers the first-paint decode.
		logo.addEventListener( 'load', showLogo, { once: true } );
		logo.src = config.logo;
		if ( logo.complete ) {
			showLogo();
		}

		mark.appendChild( logo );
		screen.appendChild( mark );
		document.body.insertBefore( screen, document.body.firstChild );
		mountedAt = now();

		whenReady( function () {
			window.setTimeout( startExit, Math.max( 0, MIN_SHOW_MS - ( now() - mountedAt ) ) );
		} );
	}

	// Hard cap, independent of everything above - also covers a template
	// that never calls wp_body_open, where mount() would never run.
	window.setTimeout( startExit, Math.max( 0, MAX_WAIT_MS - now() ) );

	// Back/forward cache can restore a snapshot taken mid-exit.
	window.addEventListener( 'pageshow', function ( event ) {
		if ( event.persisted ) {
			exiting = true;
			removeScreen();
			releaseRoot();
		}
	} );

	window.owpcPreloader = { mount: mount };
} )();
