/**
 * Category filter for the Prestasi page (page-prestasi.php).
 *
 * Progressive enhancement: the filter bar ships with `hidden` and every
 * story is visible, so without JS the page is simply the full list. This
 * script reveals the bar and shows/hides stories by their
 * data-pr-categories.
 *
 * There is no "All" filter, by direction (it was removed to declutter the
 * bar): one category is always active, the first one by default.
 *
 * The active filter is mirrored into the URL hash (#olahraga etc.) with
 * replaceState, so a filtered view can be linked to and survives a reload,
 * without stacking history entries for every click. The default category
 * keeps the bare URL.
 */
( function () {
	'use strict';

	var bar = document.querySelector( '[data-pr-filters]' );

	if ( ! bar ) {
		return;
	}

	var buttons = Array.prototype.slice.call( bar.querySelectorAll( '[data-pr-filter]' ) );

	if ( ! buttons.length ) {
		return;
	}

	var defaultKey = buttons[ 0 ].getAttribute( 'data-pr-filter' );
	var stories = Array.prototype.slice.call( document.querySelectorAll( '[data-pr-categories]' ) );
	var status = document.querySelector( '[data-pr-status]' );
	var reduceMotion = window.matchMedia && window.matchMedia( '(prefers-reduced-motion: reduce)' ).matches;
	// Same source of truth as language-switch.js: the language PHP rendered.
	var isId = ! ( window.oceanwpChildLang && 'en' === window.oceanwpChildLang.current );

	function apply( key, announce ) {
		var shown = 0;

		buttons.forEach( function ( btn ) {
			var active = btn.getAttribute( 'data-pr-filter' ) === key;

			btn.classList.toggle( 'is-active', active );
			btn.setAttribute( 'aria-pressed', active ? 'true' : 'false' );
		} );

		stories.forEach( function ( story ) {
			var cats = story.getAttribute( 'data-pr-categories' ).split( ' ' );
			var match = -1 !== cats.indexOf( key );
			var wasHidden = story.hidden;

			story.hidden = ! match;

			if ( match ) {
				shown++;

				// Web Animations rather than a CSS class: the card's reveal is
				// itself a CSS animation, and swapping the animation property
				// would restart that reveal from opacity 0.
				if ( wasHidden && ! reduceMotion && story.animate ) {
					story.animate( [ { opacity: 0 }, { opacity: 1 } ], { duration: 250, easing: 'ease' } );
				}
			}
		} );

		if ( announce && status ) {
			status.textContent = isId ? shown + ' kisah ditampilkan' : shown + ( 1 === shown ? ' story shown' : ' stories shown' );
		}
	}

	function keyFromHash() {
		var hash = window.location.hash.replace( '#', '' );

		return buttons.some( function ( btn ) {
			return btn.getAttribute( 'data-pr-filter' ) === hash;
		} ) ? hash : defaultKey;
	}

	bar.hidden = false;

	bar.addEventListener( 'click', function ( event ) {
		var btn = event.target.closest( '[data-pr-filter]' );

		if ( ! btn ) {
			return;
		}

		var key = btn.getAttribute( 'data-pr-filter' );

		apply( key, true );

		if ( window.history && window.history.replaceState ) {
			window.history.replaceState( null, '', defaultKey === key ? window.location.pathname + window.location.search : '#' + key );
		}
	} );

	apply( keyFromHash(), false );
} )();
