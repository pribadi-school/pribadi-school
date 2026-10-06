/**
 * Category filter + story stepping for the story pages
 * (template-parts/story-page.php: Prestasi, Digital Classroom). Named for
 * the Prestasi page, which came first.
 *
 * Progressive enhancement: the filter bar and arrow buttons ship with
 * `hidden` and every story is visible, so without JS the page is simply the
 * full stacked list. This script reveals the controls and shows exactly one
 * story at a time - the active category's current one - in the
 * rushd.sch.id format: the right arrow steps to the next story in that
 * category, the left arrow back. Each arrow only shows when there is a
 * story on that side; a category with a single story shows neither.
 *
 * There is no "All" filter, by direction (it was removed to declutter the
 * bar): one category is always active, the first one by default. Picking a
 * category starts at its first story.
 *
 * The active filter is mirrored into the URL hash (#olahraga etc.) with
 * replaceState, so a filtered view can be linked to and survives a reload,
 * without stacking history entries for every click. The default category
 * keeps the bare URL.
 */
( function () {
	'use strict';

	var bar = document.querySelector( '[data-pr-filters]' );
	var carousel = document.querySelector( '[data-pr-carousel]' );

	if ( ! bar || ! carousel ) {
		return;
	}

	var buttons = Array.prototype.slice.call( bar.querySelectorAll( '[data-pr-filter]' ) );

	if ( ! buttons.length ) {
		return;
	}

	var defaultKey = buttons[ 0 ].getAttribute( 'data-pr-filter' );
	var stories = Array.prototype.slice.call( carousel.querySelectorAll( '[data-pr-categories]' ) );
	var prev = carousel.querySelector( '[data-pr-nav="-1"]' );
	var next = carousel.querySelector( '[data-pr-nav="1"]' );
	var status = document.querySelector( '[data-pr-status]' );
	var reduceMotion = window.matchMedia && window.matchMedia( '(prefers-reduced-motion: reduce)' ).matches;
	// Same source of truth as language-switch.js: the language PHP rendered.
	var isId = ! ( window.oceanwpChildLang && 'en' === window.oceanwpChildLang.current );

	var currentKey = defaultKey;
	var currentIndex = 0;

	function storiesFor( key ) {
		return stories.filter( function ( story ) {
			return -1 !== story.getAttribute( 'data-pr-categories' ).split( ' ' ).indexOf( key );
		} );
	}

	function render( announce ) {
		var matching = storiesFor( currentKey );
		var active = matching[ currentIndex ];

		buttons.forEach( function ( btn ) {
			var on = btn.getAttribute( 'data-pr-filter' ) === currentKey;

			btn.classList.toggle( 'is-active', on );
			btn.setAttribute( 'aria-pressed', on ? 'true' : 'false' );
		} );

		stories.forEach( function ( story ) {
			var show = story === active;
			var wasHidden = story.hidden;

			story.hidden = ! show;

			// Web Animations rather than a CSS class: the card's reveal is
			// itself a CSS animation, and swapping the animation property
			// would restart that reveal from opacity 0.
			if ( show && wasHidden && ! reduceMotion && story.animate ) {
				story.animate( [ { opacity: 0 }, { opacity: 1 } ], { duration: 250, easing: 'ease' } );
			}
		} );

		// A story with a 3D model: start loading it now. Its own lazy-loading
		// waits for the browser to report it on screen, which a story that was
		// hidden a moment ago doesn't always do promptly; until it arrives the
		// still poster stands in, so a late or failed load looks like a picture.
		var viewer = active && active.querySelector( 'model-viewer' );

		if ( viewer ) {
			window.customElements.whenDefined( 'model-viewer' ).then( function () {
				if ( ! viewer.loaded && viewer.dismissPoster ) {
					viewer.dismissPoster();
				}
			} );
		}

		prev.hidden = currentIndex <= 0;
		next.hidden = currentIndex >= matching.length - 1;
		carousel.classList.toggle( 'has-nav', matching.length > 1 );

		if ( announce && status && active ) {
			var title = active.querySelector( '.pr-story-title' );

			status.textContent = ( currentIndex + 1 ) + ' / ' + matching.length + ( isId ? ' - ' : ': ' ) + ( title ? title.textContent : '' );
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

		currentKey = btn.getAttribute( 'data-pr-filter' );
		currentIndex = 0;
		render( true );

		if ( window.history && window.history.replaceState ) {
			window.history.replaceState( null, '', defaultKey === currentKey ? window.location.pathname + window.location.search : '#' + currentKey );
		}
	} );

	[ prev, next ].forEach( function ( arrow ) {
		arrow.addEventListener( 'click', function () {
			var count = storiesFor( currentKey ).length;

			currentIndex = Math.min( count - 1, Math.max( 0, currentIndex + parseInt( arrow.getAttribute( 'data-pr-nav' ), 10 ) ) );
			render( true );

			// The arrow that was clicked can disappear at either end of the
			// list; keep keyboard focus on a control that still exists.
			if ( arrow.hidden ) {
				( arrow === next ? prev : next ).focus();
			}
		} );
	} );

	currentKey = keyFromHash();
	render( false );
} )();

/*
 * 3D models with a built-in animation worth showing once (the Chromebook's
 * lid opening): a <model-viewer data-pause-at="2"> plays its animation the
 * first time it scrolls into view and holds it at that many seconds, so the
 * laptop ends up open instead of looping open-and-shut. Under
 * prefers-reduced-motion it starts at that pose with no animation.
 * Separate from the filter above so it still runs on a page without one.
 */
( function () {
	'use strict';

	var reduceMotion = window.matchMedia && window.matchMedia( '(prefers-reduced-motion: reduce)' ).matches;

	Array.prototype.forEach.call( document.querySelectorAll( 'model-viewer[data-pause-at]' ), function ( viewer ) {
		var pauseAt = parseFloat( viewer.getAttribute( 'data-pause-at' ) );
		var played = false;

		function hold() {
			viewer.pause();
			viewer.currentTime = pauseAt;

			// The viewer framed the shot for the model as first loaded (lid
			// shut), so an opened lid would poke out of the top of the picture.
			// Re-frame now that the model has reached its final shape.
			if ( viewer.updateFraming ) {
				viewer.updateFraming();
			}
		}

		if ( reduceMotion ) {
			viewer.addEventListener( 'load', hold );
			return;
		}

		viewer.addEventListener( 'model-visibility', function ( event ) {
			if ( played || ! event.detail.visible ) {
				return;
			}

			played = true;
			viewer.play();

			( function watch() {
				if ( viewer.currentTime >= pauseAt ) {
					hold();
				} else {
					window.requestAnimationFrame( watch );
				}
			}() );
		} );
	} );
} )();
