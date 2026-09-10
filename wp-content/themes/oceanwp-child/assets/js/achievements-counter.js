/**
 * Counts each `.hp-achieve-stat-number` up from 0 to its `data-count-to`
 * once the stats row scrolls into view. IntersectionObserver-gated so it
 * doesn't fire on page load, requestAnimationFrame-driven so it doesn't
 * block the main thread the way a setInterval loop would. Runs once per
 * element, then stops observing it.
 */
( function () {
	'use strict';

	var numbers = document.querySelectorAll( '.hp-achieve-stat-number' );

	if ( ! numbers.length ) {
		return;
	}

	var DURATION = 1400;
	var prefersReducedMotion = window.matchMedia && window.matchMedia( '(prefers-reduced-motion: reduce)' ).matches;

	function easeOutQuad( t ) {
		return 1 - ( 1 - t ) * ( 1 - t );
	}

	function countUp( el ) {
		var target = parseInt( el.getAttribute( 'data-count-to' ), 10 ) || 0;

		if ( prefersReducedMotion ) {
			el.textContent = target;
			return;
		}

		var start = null;

		function step( timestamp ) {
			if ( null === start ) {
				start = timestamp;
			}

			var progress = Math.min( ( timestamp - start ) / DURATION, 1 );
			el.textContent = Math.round( easeOutQuad( progress ) * target );

			if ( progress < 1 ) {
				window.requestAnimationFrame( step );
			}
		}

		window.requestAnimationFrame( step );
	}

	if ( ! ( 'IntersectionObserver' in window ) ) {
		Array.prototype.forEach.call( numbers, countUp );
		return;
	}

	var observer = new IntersectionObserver( function ( entries ) {
		entries.forEach( function ( entry ) {
			if ( entry.isIntersecting ) {
				countUp( entry.target );
				observer.unobserve( entry.target );
			}
		} );
	}, { threshold: 0.4 } );

	Array.prototype.forEach.call( numbers, function ( el ) {
		observer.observe( el );
	} );
} )();
