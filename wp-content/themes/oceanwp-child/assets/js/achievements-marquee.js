/**
 * Achievement photo strip: keeps the marquee rolling, and lets it be
 * dragged by hand at the same time (see template-parts/achievements-showcase.php).
 *
 * The strip is a CSS-only marquee by default - the tile list is rendered
 * twice and the track animates to -50% forever. That can't be steered by
 * hand, so this hands the loop over to JS on load (`.is-manual` turns the
 * CSS animation off) and drives the same translateX itself. If this script
 * never runs, the CSS animation is still there and the strip behaves exactly
 * as it did before.
 *
 * Two things worth knowing:
 *
 * - Dragging is pointer-driven rather than native overflow scrolling. Making
 *   the strip a real scroll container would have been less code, but a
 *   horizontally-scrollable box swallows the vertical wheel in Chrome, and
 *   because this loop never reaches an end, the page would stop scrolling
 *   whenever the cursor happened to be over the strip.
 * - `touch-action: pan-y` (homepage.css) is what keeps vertical page
 *   scrolling on touch working: sideways gestures come here, up/down ones
 *   are left to the page.
 */
( function () {
	'use strict';

	var strips = document.querySelectorAll( '.hp-achieve-strip' );

	if ( ! strips.length ) {
		return;
	}

	var prefersReducedMotion = window.matchMedia
		&& window.matchMedia( '(prefers-reduced-motion: reduce)' ).matches;

	// Past this much movement a pointer gesture is a drag, not a tap - used
	// both to start steering and to decide whether to swallow the click that
	// follows (otherwise a drag that ends on a tile also toggles its reveal
	// card, see achievements-tile-tap.js).
	var DRAG_THRESHOLD = 6;

	function setupStrip( strip ) {
		var track = strip.querySelector( '.hp-achieve-track' );

		if ( ! track || track.children.length < 2 ) {
			return;
		}

		strip.classList.add( 'is-manual' );

		var offset = 0;
		var period = 0;
		var speed = 0;

		/**
		 * One full copy of the tile list, measured from where the second copy
		 * starts. Deliberately not `scrollWidth / 2`: the track is a flex row
		 * with a gap, so half its width lands half a gap short of the repeat
		 * and the loop seams by those few pixels every pass.
		 */
		function measure() {
			var first = track.children[ 0 ];
			var secondCopy = track.children[ Math.floor( track.children.length / 2 ) ];

			period = secondCopy.offsetLeft - first.offsetLeft;

			// Seconds per full pass, read from CSS so the duration (including
			// the faster mobile value) has one home and the no-JS fallback
			// animation can't drift from this.
			var duration = parseFloat(
				window.getComputedStyle( strip ).getPropertyValue( '--hp-achieve-duration' )
			) || 42;

			speed = period > 0 ? period / duration : 0;
		}

		function render() {
			// Wrapped into [0, period) in both directions, so dragging
			// backwards past the start is as seamless as running forwards
			// past the end.
			if ( period > 0 ) {
				offset = ( ( offset % period ) + period ) % period;
			}

			track.style.transform = 'translateX(' + ( -offset ) + 'px)';
		}

		measure();
		render();

		window.addEventListener( 'resize', function () {
			measure();
			render();
		} );

		// Images settle their layout after load; the track's width (and so the
		// repeat period) isn't final until they have.
		window.addEventListener( 'load', function () {
			measure();
			render();
		} );

		var dragging = false;
		var pointerId = null;
		var startX = 0;
		var startOffset = 0;
		var moved = 0;

		strip.addEventListener( 'pointerdown', function ( event ) {
			if ( ! event.isPrimary || ( event.pointerType === 'mouse' && 0 !== event.button ) ) {
				return;
			}

			dragging = true;
			pointerId = event.pointerId;
			startX = event.clientX;
			startOffset = offset;
			moved = 0;
			strip.classList.add( 'is-dragging' );
		} );

		strip.addEventListener( 'pointermove', function ( event ) {
			if ( ! dragging || event.pointerId !== pointerId ) {
				return;
			}

			var dx = event.clientX - startX;
			moved = Math.max( moved, Math.abs( dx ) );

			if ( moved < DRAG_THRESHOLD ) {
				return;
			}

			// Claim the gesture once it's clearly a drag, so the pointer can
			// leave the strip mid-drag without the strip losing track of it.
			// Throws if the pointer is already gone (gesture cancelled between
			// events), which is nothing to act on - the drag just ends.
			try {
				if ( ! strip.hasPointerCapture( pointerId ) ) {
					strip.setPointerCapture( pointerId );
				}
			} catch ( e ) {}

			offset = startOffset - dx;
			render();
		} );

		function endDrag( event ) {
			if ( ! dragging || ( null !== pointerId && event.pointerId !== pointerId ) ) {
				return;
			}

			dragging = false;
			pointerId = null;
			strip.classList.remove( 'is-dragging' );
		}

		strip.addEventListener( 'pointerup', endDrag );
		strip.addEventListener( 'pointercancel', endDrag );

		// Capture phase, so a drag that happens to finish on top of a tile is
		// stopped before the tile's own click handler sees it.
		strip.addEventListener( 'click', function ( event ) {
			if ( moved >= DRAG_THRESHOLD ) {
				event.stopPropagation();
				event.preventDefault();
				moved = 0;
			}
		}, true );

		if ( prefersReducedMotion ) {
			// Still fully steerable by hand - it just never moves on its own.
			return;
		}

		var lastFrame = 0;

		function tick( now ) {
			var elapsed = lastFrame ? ( now - lastFrame ) : 0;
			lastFrame = now;

			// A backgrounded tab resumes with a huge gap; capping it stops the
			// strip from leaping forward on return.
			if ( ! dragging && elapsed > 0 ) {
				offset += speed * ( Math.min( elapsed, 100 ) / 1000 );
				render();
			}

			window.requestAnimationFrame( tick );
		}

		window.requestAnimationFrame( tick );
	}

	Array.prototype.forEach.call( strips, setupStrip );
} )();
