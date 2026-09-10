/**
 * Fades the hero's overlaid text out as soon as the visitor starts
 * scrolling, so it doesn't linger and clash with the header going solid.
 * The fade itself is pure CSS (see .hp-hero-content--hidden in
 * homepage.css) - this just toggles the class.
 */
( function () {
	'use strict';

	var content = document.querySelector( '.hp-hero-content' );

	if ( ! content ) {
		return;
	}

	var SCROLL_THRESHOLD = 10;
	var isHidden = false;
	var ticking = false;

	function update() {
		var shouldHide = window.pageYOffset > SCROLL_THRESHOLD;

		if ( shouldHide !== isHidden ) {
			isHidden = shouldHide;
			content.classList.toggle( 'hp-hero-content--hidden', isHidden );
		}

		ticking = false;
	}

	function onScroll() {
		if ( ticking ) {
			return;
		}
		ticking = true;
		window.requestAnimationFrame( update );
	}

	window.addEventListener( 'scroll', onScroll, { passive: true } );
	update();
} )();
