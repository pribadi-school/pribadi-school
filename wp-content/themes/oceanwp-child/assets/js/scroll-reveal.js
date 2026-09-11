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

	/**
	 * Reveal an element, and any .hp-reveal descendants along with it.
	 *
	 * The cascade exists for the achievement strip: its tiles sit on a track
	 * that scrolls horizontally forever inside an overflow:hidden parent, so
	 * whether a given tile intersects depends on where that 42s animation
	 * happens to be when the strip scrolls into view, not on the reader's
	 * position. A tile that is off the clip edge at that moment never
	 * intersects and stays at opacity 0 - a permanent hole in the strip.
	 * Revealing descendants with their container takes the animation's phase
	 * out of it; each tile still stages itself with its own animation-delay.
	 */
	function reveal( el ) {
		el.classList.add( 'is-visible' );
		observer.unobserve( el );

		el.querySelectorAll( '.hp-reveal' ).forEach( function ( child ) {
			child.classList.add( 'is-visible' );
			observer.unobserve( child );
		} );
	}

	var observer = new IntersectionObserver( function ( entries ) {
		entries.forEach( function ( entry ) {
			if ( entry.isIntersecting ) {
				reveal( entry.target );
			}
		} );
	}, {
		// Small positive bottom margin, so the root extends slightly past the
		// fold and an element starts revealing just before its top edge
		// appears. Without that head start the very top of the element is
		// briefly on screen at opacity 0; with too much of one the animation
		// finishes before anything is visible and the reveal is wasted. At 5%
		// most of the fade still plays in view.
		//
		// Both previous configs triggered well after the element was already
		// on screen (threshold 0.2 + -60px, then threshold 0 + -15%), so the
		// reader scrolled past a blank gap before anything moved.
		threshold: 0,
		rootMargin: '0px 0px 5% 0px',
	} );

	els.forEach( function ( el ) {
		observer.observe( el );
	} );
} )();
