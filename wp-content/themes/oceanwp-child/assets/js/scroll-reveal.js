/**
 * Generic scroll-reveal: adds `.is-visible` to any `.hp-reveal` element
 * once it scrolls into view (IntersectionObserver-gated, runs once per
 * element). The actual fade/rise animation is pure CSS
 * (see .hp-reveal / .hp-reveal.is-visible in homepage.css) - this only
 * flips the class at the right moment.
 */
( function () {
	'use strict';

	var els = document.querySelectorAll( '.hp-reveal' );

	if ( ! els.length ) {
		return;
	}

	if ( ! ( 'IntersectionObserver' in window ) ) {
		els.forEach( function ( el ) {
			el.classList.add( 'is-visible' );
		} );
		return;
	}

	var observer = new IntersectionObserver( function ( entries ) {
		entries.forEach( function ( entry ) {
			if ( entry.isIntersecting ) {
				entry.target.classList.add( 'is-visible' );
				observer.unobserve( entry.target );
			}
		} );
	}, {
		// Fire as soon as the element's top edge crosses ~85% of the viewport
		// height, matching the standard scroll-reveal trigger point.
		//
		// The previous config (threshold 0.2 + a fixed -60px) waited until a
		// fifth of the element was already on screen, which on tall elements
		// like the program rows meant a visible beat of empty space before
		// anything moved. Threshold 0 plus a percentage bottom margin scales
		// with the viewport instead of assuming a fixed pixel offset.
		threshold: 0,
		rootMargin: '0px 0px -15% 0px',
	} );

	els.forEach( function ( el ) {
		observer.observe( el );
	} );
} )();
