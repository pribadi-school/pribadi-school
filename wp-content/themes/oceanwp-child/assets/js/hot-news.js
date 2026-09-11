/**
 * Kabar Terkini / Latest News carousel (see template-parts/hot-news.php).
 *
 * A centred slide with its neighbours peeking in at either side, advancing
 * on a timer and steerable by hand - the progress bar, swipe, the mouse
 * wheel, clicking a peeking photo, or the left/right keys once the carousel
 * has focus. Positioning is
 * by slot (the --k custom property, see homepage.css); this script only
 * decides which slide is in which slot.
 *
 * Two deliberate behaviours:
 *
 * - Taking control stops the timer permanently, rather than pausing it for a
 *   beat and resuming. Something that starts moving again under a reader who
 *   has just chosen a slide is the thing that makes auto-advancing carousels
 *   frustrating; once intent is shown, intent wins.
 * - Nothing auto-advances under prefers-reduced-motion. The carousel is still
 *   fully usable there, it just waits to be driven.
 *
 * Markup for the controls and the initial slots is rendered server-side, so
 * this only wires up what already exists - if it never runs, the first item
 * still shows centred with its neighbours either side.
 */
( function () {
	'use strict';

	var roots = document.querySelectorAll( '[data-hp-hotnews]' );

	if ( ! roots.length ) {
		return;
	}

	var prefersReducedMotion = window.matchMedia
		&& window.matchMedia( '(prefers-reduced-motion: reduce)' ).matches;

	var isIndonesian = ! ( window.oceanwpChildLang && 'en' === oceanwpChildLang.current );

	// Swipes shorter than this are treated as taps, not gestures.
	var SWIPE_THRESHOLD = 40;

	function setupCarousel( root ) {
		var track = root.querySelector( '.hp-hotnews-track' );
		var slides = Array.prototype.slice.call( root.querySelectorAll( '.hp-hotnews-slide' ) );
		var dots = Array.prototype.slice.call( root.querySelectorAll( '[data-hp-hotnews-dot]' ) );

		if ( ! track || slides.length < 2 ) {
			return;
		}

		var interval = parseInt( root.getAttribute( 'data-interval' ), 10 ) || 3000;

		// Number of real items; dots and labels count in these.
		var count = slides.length;

		// The layout needs at least five slides to loop seamlessly: one each
		// side of the active slide is on screen, and the slide that wraps from
		// one end of the loop to the other has to make that jump from an
		// off-screen slot to an off-screen slot. With fewer real items, the
		// set is repeated with copies - hidden from assistive tech, since
		// they only exist to fill the picture.
		var copies = [];
		while ( slides.length + copies.length < 5 ) {
			slides.forEach( function ( slide ) {
				var copy = slide.cloneNode( true );
				copy.classList.remove( 'is-active' );
				copy.setAttribute( 'aria-hidden', 'true' );
				copy.setAttribute( 'data-hp-hotnews-copy', '' );
				track.appendChild( copy );
				copies.push( copy );
			} );
		}
		slides = slides.concat( copies );

		var total = slides.length;
		var half = Math.floor( total / 2 );
		var current = 0;

		// Autoplay is a countdown that can pause and resume where it left
		// off, rather than a setInterval that restarts from zero - so a
		// hover part-way through an item doesn't earn it a full extra turn.
		var timer = null;
		var remaining = interval;
		var countdownStartedAt = 0;

		// Latched once the reader drives the carousel themselves, and never
		// cleared - it's what makes startTimer() a no-op from then on, so
		// hovering away or tabbing out can't quietly restart the cycling.
		var handedOver = false;

		// Only cycle while the carousel is actually on screen - otherwise a
		// visitor who scrolls down slowly arrives partway through the list,
		// having missed the first (most important) item entirely.
		var inView = false;

		function countdown( ms ) {
			remaining = ms;
			countdownStartedAt = Date.now();
			timer = window.setTimeout( function () {
				timer = null;
				step( 1 );
				countdown( interval );
			}, ms );
		}

		/** Pause: freeze the countdown. */
		function stopTimer() {
			if ( timer ) {
				window.clearTimeout( timer );
				timer = null;
				remaining = Math.max( 0, remaining - ( Date.now() - countdownStartedAt ) );
			}
		}

		/** Resume (or begin): pick the countdown back up where it stopped. */
		function startTimer() {
			if ( prefersReducedMotion || handedOver || timer || ! inView ) {
				return;
			}

			countdown( remaining );
		}

		/** For good: once someone takes over, autoplay never comes back. */
		function retireTimer() {
			handedOver = true;
			stopTimer();
		}

		/**
		 * Slot of slide i relative to the active one: 0 is centre, 1 the next
		 * peek, -1 the previous, and the rest wait off-screen.
		 */
		function slotOf( i ) {
			return ( ( ( i - current ) % total ) + total + half ) % total - half;
		}

		/**
		 * Move by `delta` slides (negative is backwards). The loop never ends,
		 * so moving by hand never dead-ends.
		 */
		function step( delta ) {
			current = ( ( current + delta ) % total + total ) % total;
			layout( delta );
		}

		function layout( delta ) {
			var wrapping = [];

			slides.forEach( function ( slide, i ) {
				var before = parseInt( slide.style.getPropertyValue( '--k' ), 10 );
				var after = slotOf( i );

				// A slide whose slot changed by more than the move itself went
				// round the back of the loop; place it without animating.
				if ( delta && ! isNaN( before ) && Math.abs( after - before ) !== Math.abs( delta ) ) {
					slide.classList.add( 'is-wrapping' );
					wrapping.push( slide );
				}

				slide.style.setProperty( '--k', after );
			} );

			if ( wrapping.length ) {
				// Commit the jump with transitions off, then hand them back.
				void track.offsetWidth;
				wrapping.forEach( function ( slide ) {
					slide.classList.remove( 'is-wrapping' );
				} );
			}

			var real = current % count;

			slides.forEach( function ( slide, i ) {
				var isCurrent = i === current;
				slide.classList.toggle( 'is-active', isCurrent );

				// Off-screen slides are hidden from assistive tech and taken
				// out of the tab order, so a keyboard user isn't walked
				// through links they cannot see.
				if ( isCurrent ) {
					slide.removeAttribute( 'aria-hidden' );
				} else {
					slide.setAttribute( 'aria-hidden', 'true' );
				}

				slide.querySelectorAll( 'a' ).forEach( function ( link ) {
					if ( isCurrent ) {
						link.removeAttribute( 'tabindex' );
					} else {
						link.setAttribute( 'tabindex', '-1' );
					}
				} );
			} );

			dots.forEach( function ( dot, i ) {
				dot.classList.toggle( 'is-active', i === real );
				dot.setAttribute( 'aria-selected', i === real ? 'true' : 'false' );
			} );
		}

		/**
		 * Any hand-driven move: change slide and retire the timer for good.
		 */
		function takeControl( delta ) {
			retireTimer();
			if ( delta ) {
				step( delta );
			}
		}

		/**
		 * Shortest way round the loop from the active slide to real item
		 * `target`, so picking a dot never sends the carousel the long way.
		 */
		function deltaToItem( target ) {
			var d = ( ( target - ( current % count ) ) % count + count ) % count;
			return d > count / 2 ? d - count : d;
		}

		dots.forEach( function ( dot ) {
			dot.addEventListener( 'click', function () {
				takeControl( deltaToItem( parseInt( dot.getAttribute( 'data-hp-hotnews-dot' ), 10 ) || 0 ) );
			} );
		} );

		// The peeking photos are shortcuts: clicking one brings it to the
		// centre instead of following its link.
		slides.forEach( function ( slide, i ) {
			slide.addEventListener( 'click', function ( event ) {
				if ( i === current ) {
					return;
				}
				event.preventDefault();
				takeControl( slotOf( i ) );
			} );
		} );

		root.addEventListener( 'keydown', function ( event ) {
			if ( 'ArrowLeft' === event.key ) {
				event.preventDefault();
				takeControl( -1 );
			} else if ( 'ArrowRight' === event.key ) {
				event.preventDefault();
				takeControl( 1 );
			}
		} );

		// Touch: horizontal drags move the carousel, vertical ones are left
		// alone so the gesture never fights page scrolling.
		var touchStartX = 0;
		var touchStartY = 0;

		root.addEventListener( 'touchstart', function ( event ) {
			touchStartX = event.changedTouches[ 0 ].clientX;
			touchStartY = event.changedTouches[ 0 ].clientY;
		}, { passive: true } );

		root.addEventListener( 'touchend', function ( event ) {
			var dx = event.changedTouches[ 0 ].clientX - touchStartX;
			var dy = event.changedTouches[ 0 ].clientY - touchStartY;

			if ( Math.abs( dx ) < SWIPE_THRESHOLD || Math.abs( dx ) < Math.abs( dy ) ) {
				return;
			}

			takeControl( dx < 0 ? 1 : -1 );
		}, { passive: true } );

		/*
		 * Mouse wheel / trackpad.
		 *
		 * Sideways scrolling (trackpad swipes, Shift+wheel) always moves the
		 * carousel. The ordinary vertical wheel is the page's own scroll, so
		 * it is borrowed carefully: only while the carousel is fully on
		 * screen. Scrolling past the last item wraps back to the first (and
		 * vice versa), by direction - matching autoplay/dots/swipe, which
		 * already loop.
		 *
		 * One step per gesture: a wheel spin or trackpad fling fires dozens
		 * of events, so after a step the rest of that gesture is swallowed
		 * until the wheel has been still for WHEEL_QUIET_MS (and at least
		 * WHEEL_MIN_GAP_MS has passed, so a long inertial tail can't fire a
		 * second step on its own).
		 */
		var WHEEL_QUIET_MS = 180;
		var WHEEL_MIN_GAP_MS = 700;
		var wheelLockedUntil = 0;
		var viewport = root.querySelector( '.hp-hotnews-viewport' );

		function fullyInView() {
			var rect = ( viewport || root ).getBoundingClientRect();
			return rect.top >= 0 && rect.bottom <= window.innerHeight;
		}

		root.addEventListener( 'wheel', function ( event ) {
			var horizontal = Math.abs( event.deltaX ) > Math.abs( event.deltaY );
			var delta = horizontal ? event.deltaX : event.deltaY;
			var now = Date.now();

			if ( ! delta || ( event.ctrlKey && ! horizontal ) ) {
				// ctrl+wheel is browser zoom (and trackpad pinch); leave it be.
				return;
			}

			if ( now < wheelLockedUntil ) {
				// Still the gesture that just caused a step.
				event.preventDefault();
				wheelLockedUntil = Math.max( wheelLockedUntil, now + WHEEL_QUIET_MS );
				return;
			}

			var direction = delta > 0 ? 1 : -1;

			if ( ! horizontal && ! fullyInView() ) {
				return;
			}

			event.preventDefault();
			wheelLockedUntil = now + WHEEL_MIN_GAP_MS;
			takeControl( direction );
		}, { passive: false } );

		// Hovering or focusing holds the current slide; leaving resumes, but
		// only while the timer is still alive (i.e. nobody has taken over).
		root.addEventListener( 'mouseenter', stopTimer );
		root.addEventListener( 'focusin', stopTimer );

		root.addEventListener( 'mouseleave', startTimer );
		root.addEventListener( 'focusout', function ( event ) {
			if ( ! root.contains( event.relatedTarget ) ) {
				startTimer();
			}
		} );

		// Don't cycle through slides nobody is looking at.
		document.addEventListener( 'visibilitychange', function () {
			if ( document.hidden ) {
				stopTimer();
			} else {
				startTimer();
			}
		} );

		root.setAttribute( 'tabindex', '0' );
		root.setAttribute(
			'aria-label',
			root.getAttribute( 'aria-label' ) + ( isIndonesian
				? ' (gunakan tombol panah untuk berpindah)'
				: ' (use arrow keys to move between items)' )
		);

		layout( 0 );

		if ( 'IntersectionObserver' in window ) {
			new IntersectionObserver( function ( entries ) {
				inView = entries[ 0 ].isIntersecting;
				if ( inView ) {
					startTimer();
				} else {
					stopTimer();
				}
			}, { threshold: 0.5 } ).observe( root );
		} else {
			inView = true;
			startTimer();
		}
	}

	roots.forEach( setupCarousel );
} )();
