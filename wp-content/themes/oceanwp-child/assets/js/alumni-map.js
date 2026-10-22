/**
 * Alumni section: country picker + detail card, tied to the map's pins
 * (template-parts/alumni-map.php).
 *
 * The chips are a real radio group, so the keyboard (arrow keys), screen
 * readers and form semantics all come from the browser. This script only
 * does three things:
 *
 * - shows the card of the selected country and hides the rest;
 * - marks the matching map pin and the route line from the school to it as
 *   selected (`.is-selected`);
 * - makes a pin click select its country in the picker - the pins are a
 *   shortcut into the picker, not a second place to read the lists.
 *
 * Without JS the first country's card simply stays visible.
 */
( function () {
	'use strict';

	var root = document.querySelector( '[data-hp-alumni]' );

	if ( ! root ) {
		return;
	}

	var radios = root.querySelectorAll( '.hp-alumni-chip input[type="radio"]' );
	var cards = root.querySelectorAll( '.hp-alumni-card' );
	var points = root.querySelectorAll( '.hp-map-point' );
	var arcs = root.querySelectorAll( '.hp-map-arc' );
	var panel = root.querySelector( '.hp-alumni-panel' );

	if ( ! radios.length ) {
		return;
	}

	var reduceMotion = window.matchMedia && window.matchMedia( '(prefers-reduced-motion: reduce)' ).matches;

	function select( index ) {
		var key = String( index );

		cards.forEach( function ( card ) {
			var match = card.getAttribute( 'data-country' ) === key;

			card.hidden = ! match;

			// A card revealed from a long list opens at the top, not wherever the
			// previous country's list happened to be scrolled to.
			if ( match ) {
				var list = card.querySelector( '.hp-alumni-unis' );

				if ( list ) {
					list.scrollTop = 0;
				}
			}
		} );

		points.forEach( function ( point ) {
			point.classList.toggle( 'is-selected', point.getAttribute( 'data-country' ) === key );
		} );

		// The selected country's route lights up and is moved to the end of its
		// group, because SVG paints in document order - otherwise the other
		// routes would cross over it.
		arcs.forEach( function ( arc ) {
			var match = arc.getAttribute( 'data-country' ) === key;

			arc.classList.toggle( 'is-selected', match );

			if ( match ) {
				arc.parentNode.appendChild( arc );
			}
		} );
	}

	/**
	 * The university card may never be taller than the country list beside it
	 * (or above it, when stacked). CSS can't read a sibling's height, so this
	 * writes the list's height - label and chips - to a custom property the card
	 * caps itself at (--hp-alumni-index-h, homepage.css); inside the card the
	 * university list is what scrolls. Kept current as the layout changes.
	 */
	var index = root.querySelector( '.hp-alumni-index' );

	function syncCardHeight() {
		if ( index && index.offsetHeight ) {
			root.style.setProperty( '--hp-alumni-index-h', index.offsetHeight + 'px' );
		}
	}

	syncCardHeight();

	if ( window.ResizeObserver && index ) {
		new window.ResizeObserver( syncCardHeight ).observe( index );
	} else {
		window.addEventListener( 'resize', syncCardHeight );
	}

	/**
	 * Hovering (or keyboard-focusing) a country - its chip or its pin - lights
	 * its route up in red as well, the same as selecting it, and puts it on top
	 * of the other routes. Letting go puts the selected country's route back on
	 * top. Pointers that can't hover (touch) skip the hover half: a tap selects
	 * anyway, and a hover that never ends would leave a route stuck lit.
	 */
	var canHover = window.matchMedia && window.matchMedia( '(hover: hover)' ).matches;

	function keyFor( node ) {
		if ( ! node || ! node.closest ) {
			return null;
		}

		var chip = node.closest( '.hp-alumni-chip' );

		if ( chip ) {
			var radio = chip.querySelector( 'input' );

			return radio ? radio.value : null;
		}

		var point = node.closest( '.hp-map-point' );

		return point ? point.getAttribute( 'data-country' ) : null;
	}

	function setHover( key ) {
		arcs.forEach( function ( arc ) {
			var match = null !== key && arc.getAttribute( 'data-country' ) === key;

			arc.classList.toggle( 'is-hover', match );

			if ( match ) {
				arc.parentNode.appendChild( arc );
			}
		} );

		if ( null === key ) {
			var selected = root.querySelector( '.hp-map-arc.is-selected' );

			if ( selected ) {
				selected.parentNode.appendChild( selected );
			}
		}
	}

	function watch( inEvent, outEvent, needsHover ) {
		root.addEventListener( inEvent, function ( event ) {
			var key = keyFor( event.target );

			if ( null !== key && ( ! needsHover || canHover ) ) {
				setHover( key );
			}
		} );

		root.addEventListener( outEvent, function ( event ) {
			if ( needsHover && ! canHover ) {
				return;
			}

			var from = keyFor( event.target );

			// Moving between two parts of the same country (chip flag -> chip
			// name) is not leaving it.
			if ( null === from || from === keyFor( event.relatedTarget ) ) {
				return;
			}

			setHover( keyFor( event.relatedTarget ) );
		} );
	}

	watch( 'mouseover', 'mouseout', true );
	watch( 'focusin', 'focusout', false );

	/**
	 * Stacked layout (phones, tablets): the card sits below the chips - or, for
	 * a pin, below the whole map - so after a choice it can be well out of view.
	 * Bring it up if it is; on desktop it is already beside the picker and
	 * nothing moves. Only for user-initiated choices, never on first paint.
	 */
	function revealCard() {
		if ( ! panel || ! window.matchMedia || ! window.matchMedia( '(max-width: 900px)' ).matches ) {
			return;
		}

		var box = panel.getBoundingClientRect();

		if ( box.top > window.innerHeight * 0.8 || box.bottom < 0 ) {
			panel.scrollIntoView( { behavior: reduceMotion ? 'auto' : 'smooth', block: 'start' } );
		}
	}

	radios.forEach( function ( radio ) {
		radio.addEventListener( 'change', function () {
			if ( radio.checked ) {
				select( radio.value );
				revealCard();
			}
		} );
	} );

	points.forEach( function ( point ) {
		var pin = point.querySelector( '.hp-map-pin' );

		if ( ! pin ) {
			return;
		}

		pin.addEventListener( 'click', function () {
			var key = point.getAttribute( 'data-country' );

			radios.forEach( function ( radio ) {
				radio.checked = radio.value === key;
			} );

			select( key );
			revealCard();
		} );
	} );

	select( ( function () {
		var checked = root.querySelector( '.hp-alumni-chip input:checked' );

		return checked ? checked.value : 0;
	}() ) );
} )();
