/**
 * Alumni map pin tooltips.
 *
 * Three ways in, deliberately: hover (pointer), click/tap (touch), and
 * focus (keyboard). Hover alone would strand touch users, and a tooltip
 * that only opens on hover is unreachable by keyboard - so focus reveals
 * exactly what hover reveals, and Escape closes.
 *
 * Only one tooltip is open at a time; on a crowded map (Europe especially)
 * several open at once overlap into an unreadable pile.
 */
( function () {
	'use strict';

	var points = document.querySelectorAll( '.hp-map-point' );

	if ( ! points.length ) {
		return;
	}

	var open = null;

	// Escape closes the tooltip and returns focus to its pin - but the pin's
	// focus handler reopens whatever is focused, so without this guard the
	// two cancel out and Escape does nothing at all.
	var suppressFocusShow = false;

	function close( point ) {
		if ( ! point ) {
			return;
		}

		point.classList.remove( 'is-open' );
		point.querySelector( '.hp-map-pin' ).setAttribute( 'aria-expanded', 'false' );
		point.querySelector( '.hp-map-tip' ).hidden = true;

		if ( open === point ) {
			open = null;
		}
	}

	function show( point ) {
		if ( open === point ) {
			return;
		}

		close( open );

		point.classList.add( 'is-open' );
		point.querySelector( '.hp-map-pin' ).setAttribute( 'aria-expanded', 'true' );
		point.querySelector( '.hp-map-tip' ).hidden = false;
		open = point;
	}

	points.forEach( function ( point ) {
		var pin = point.querySelector( '.hp-map-pin' );

		if ( ! pin ) {
			return;
		}

		pin.addEventListener( 'click', function ( event ) {
			event.stopPropagation();

			if ( open === point ) {
				close( point );
			} else {
				show( point );
			}
		} );

		// Keyboard parity with hover: tabbing to a pin reveals its tooltip.
		pin.addEventListener( 'focus', function () {
			if ( suppressFocusShow ) {
				return;
			}

			show( point );
		} );

		// Pointer hover, but only where hovering is actually a thing. On
		// touch, a tap fires a synthetic mouseenter too, which would open
		// the tooltip and immediately have the click handler close it again.
		if ( window.matchMedia && window.matchMedia( '(hover: hover)' ).matches ) {
			point.addEventListener( 'mouseenter', function () {
				show( point );
			} );

			point.addEventListener( 'mouseleave', function () {
				// Leave it open if focus is still inside, or keyboard users
				// lose the tooltip the moment the mouse drifts past.
				if ( ! point.contains( document.activeElement ) ) {
					close( point );
				}
			} );
		}
	} );

	document.addEventListener( 'keydown', function ( event ) {
		if ( 'Escape' === event.key && open ) {
			var pin = open.querySelector( '.hp-map-pin' );
			close( open );

			if ( pin ) {
				// focus() fires its handler synchronously, so the flag only
				// needs to span this one call.
				suppressFocusShow = true;
				pin.focus();
				suppressFocusShow = false;
			}
		}
	} );

	// Tapping anywhere else dismisses - without this there is no way to
	// close a tooltip on touch except finding the same pin again.
	document.addEventListener( 'click', function ( event ) {
		if ( open && ! open.contains( event.target ) ) {
			close( open );
		}
	} );
} )();
