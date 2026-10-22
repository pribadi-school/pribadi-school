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
 * It also runs the map's zoom (+ / - / reset buttons, drag to pan, scale bar,
 * distance from the school on each pin's label); see the "Zoom" block below.
 *
 * Without JS the first country's card simply stays visible and the map stays
 * at its full-world view.
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

		// Zoomed in: bring the chosen country into view (Zoom block below).
		if ( window.hpAlumniMapFocus ) {
			window.hpAlumniMapFocus( key );
		}

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

	/**
	 * Zoom
	 * ----
	 * The map is not scaled with CSS (that would blow the pins up too). Instead
	 * the SVG's viewBox is narrowed onto the part of the world being looked at,
	 * and every pin (plain HTML, positioned in percent) is re-placed from its
	 * data-lng / data-lat inside that window - the same plate carree maths as
	 * hp_alumni_map_pin_position() in alumni-map.php, so pins stay on their exact
	 * spot at every zoom and keep their size.
	 *
	 * Map units are degrees: x = longitude, y = -latitude, viewBox "-180 -84 360 140".
	 * Scale 1 is the whole map; MAX_ZOOM shows 1/8 of its width. The scale bar uses
	 * 111.2 km per degree, which is exact north-south and at the equator east-west
	 * (the bar's tooltip says so).
	 */
	( function () {
		var canvas = root.querySelector( '.hp-map-canvas' );
		var svg = root.querySelector( '.hp-map-svg' );
		var controls = root.querySelector( '.hp-map-zoom' );
		var scaleBox = root.querySelector( '.hp-map-scale' );

		if ( ! canvas || ! svg || ! controls ) {
			return;
		}

		var BASE = { x: -180, y: -84, w: 360, h: 140 };
		var MAX_ZOOM = 8;
		var KM_PER_DEG = 111.2;
		var lang = document.documentElement.lang || 'en';

		var btnIn = controls.querySelector( '[data-hp-zoom="in"]' );
		var btnOut = controls.querySelector( '[data-hp-zoom="out"]' );
		var btnReset = controls.querySelector( '[data-hp-zoom="reset"]' );
		var scaleBar = scaleBox ? scaleBox.querySelector( '.hp-map-scale-bar' ) : null;
		var scaleText = scaleBox ? scaleBox.querySelector( '.hp-map-scale-text' ) : null;

		// Every element placed by coordinates: the school and the country pins.
		var placed = [];
		var homeEntry = null;

		root.querySelectorAll( '.hp-map-home, .hp-map-point' ).forEach( function ( el ) {
			var lng = parseFloat( el.getAttribute( 'data-lng' ) );
			var lat = parseFloat( el.getAttribute( 'data-lat' ) );

			if ( isNaN( lng ) || isNaN( lat ) ) {
				return;
			}

			var entry = { el: el, lng: lng, lat: lat, key: el.getAttribute( 'data-country' ) };

			placed.push( entry );

			if ( el.classList.contains( 'hp-map-home' ) ) {
				homeEntry = entry;
			}
		} );

		// Great-circle distance in km (haversine).
		function distanceKm( a, b ) {
			var rad = Math.PI / 180;
			var dLat = ( b.lat - a.lat ) * rad;
			var dLng = ( b.lng - a.lng ) * rad;
			var h = Math.sin( dLat / 2 ) * Math.sin( dLat / 2 ) +
				Math.cos( a.lat * rad ) * Math.cos( b.lat * rad ) * Math.sin( dLng / 2 ) * Math.sin( dLng / 2 );

			return 2 * 6371 * Math.asin( Math.min( 1, Math.sqrt( h ) ) );
		}

		function formatKm( km ) {
			var n = km >= 100 ? Math.round( km / 10 ) * 10 : Math.round( km );

			try {
				return n.toLocaleString( lang ) + ' km';
			} catch ( e ) {
				return n + ' km';
			}
		}

		// "Turkey" becomes "Turkey · 8,330 km": straight-line distance from the school.
		if ( homeEntry ) {
			placed.forEach( function ( p ) {
				var label = p.el.querySelector( '.hp-map-label' );

				if ( label && p !== homeEntry ) {
					label.textContent = label.textContent + ' · ' + formatKm( distanceKm( homeEntry, p ) );
				}
			} );
		}

		var view = { cx: BASE.x + BASE.w / 2, cy: BASE.y + BASE.h / 2, s: 1 };
		// Where the view is heading: a second click while the first is still animating
		// builds on this, not on the half-way frame.
		var target = fullView();
		var raf = 0;

		function fullView() {
			return { cx: BASE.x + BASE.w / 2, cy: BASE.y + BASE.h / 2, s: 1 };
		}

		// Keeps the window inside the world map and the zoom inside 1..MAX_ZOOM.
		function clampView( v ) {
			var s = Math.min( MAX_ZOOM, Math.max( 1, v.s ) );
			var w = BASE.w / s;
			var h = BASE.h / s;

			return {
				s: s,
				cx: Math.min( BASE.x + BASE.w - w / 2, Math.max( BASE.x + w / 2, v.cx ) ),
				cy: Math.min( BASE.y + BASE.h - h / 2, Math.max( BASE.y + h / 2, v.cy ) )
			};
		}

		// Largest 1-2-5 round number of km that is not above maxKm.
		function niceKm( maxKm ) {
			var best = 1;

			for ( var mag = 1; mag <= 100000; mag *= 10 ) {
				[ 1, 2, 5 ].forEach( function ( step ) {
					if ( step * mag <= maxKm ) {
						best = step * mag;
					}
				} );
			}

			return best;
		}

		function updateScale() {
			if ( ! scaleBar || ! scaleText || ! canvas.clientWidth ) {
				return;
			}

			var pxPerDeg = canvas.clientWidth / ( BASE.w / view.s );
			var km = niceKm( 110 / pxPerDeg * KM_PER_DEG );

			scaleBar.style.width = ( km / KM_PER_DEG * pxPerDeg ) + 'px';
			scaleText.textContent = formatKm( km );
		}

		function render() {
			var w = BASE.w / view.s;
			var h = BASE.h / view.s;
			var vx = view.cx - w / 2;
			var vy = view.cy - h / 2;

			svg.setAttribute( 'viewBox', vx + ' ' + vy + ' ' + w + ' ' + h );

			placed.forEach( function ( p ) {
				var left = ( p.lng - vx ) / w * 100;
				var top = ( -p.lat - vy ) / h * 100;

				p.el.style.left = left + '%';
				p.el.style.top = top + '%';
				// Off the edge of the zoomed window: out of sight and out of the tab order.
				p.el.style.visibility = ( left < -2 || left > 102 || top < -2 || top > 102 ) ? 'hidden' : '';
			} );

			var zoomed = view.s > 1.001;

			canvas.classList.toggle( 'is-zoomed', zoomed );
			btnIn.disabled = view.s >= MAX_ZOOM - 0.001;
			btnOut.disabled = ! zoomed;

			if ( btnReset ) {
				btnReset.hidden = ! zoomed;
			}

			updateScale();
		}

		function goTo( want, instant ) {
			var to = clampView( want );

			target = to;
			window.cancelAnimationFrame( raf );

			if ( instant || reduceMotion || ! window.requestAnimationFrame ) {
				view = to;
				render();
				return;
			}

			var from = { cx: view.cx, cy: view.cy, s: view.s };
			var start = null;
			var DURATION = 280;

			function step( now ) {
				if ( null === start ) {
					start = now;
				}

				var t = Math.min( 1, ( now - start ) / DURATION );
				var e = 1 - Math.pow( 1 - t, 3 );

				view = {
					cx: from.cx + ( to.cx - from.cx ) * e,
					cy: from.cy + ( to.cy - from.cy ) * e,
					// Scale is interpolated in log space so 1x to 8x feels even.
					s: Math.exp( Math.log( from.s ) + ( Math.log( to.s ) - Math.log( from.s ) ) * e )
				};
				render();

				if ( t < 1 ) {
					raf = window.requestAnimationFrame( step );
				} else {
					view = to;
					render();
				}
			}

			raf = window.requestAnimationFrame( step );
		}

		function selectedEntry() {
			var found = null;

			placed.forEach( function ( p ) {
				if ( p.el.classList.contains( 'is-selected' ) ) {
					found = p;
				}
			} );

			return found;
		}

		function zoomBy( factor ) {
			var s = Math.min( MAX_ZOOM, Math.max( 1, target.s * factor ) );

			if ( s === target.s ) {
				return;
			}

			if ( 1 === s ) {
				goTo( fullView() );
				return;
			}

			// The first zoom in from the full map goes to the chosen country, so the
			// button shows what the visitor just picked; after that it zooms about
			// the middle of the current window.
			var focus = target.s <= 1.001 ? selectedEntry() : null;

			goTo( focus ? { cx: focus.lng, cy: -focus.lat, s: s } : { cx: target.cx, cy: target.cy, s: s } );
		}

		btnIn.addEventListener( 'click', function () {
			zoomBy( 2 );
		} );

		btnOut.addEventListener( 'click', function () {
			zoomBy( 0.5 );
		} );

		if ( btnReset ) {
			btnReset.addEventListener( 'click', function () {
				goTo( fullView() );
			} );
		}

		// Choosing a country while zoomed in slides the map to it.
		window.hpAlumniMapFocus = function ( key ) {
			if ( target.s <= 1.001 ) {
				return;
			}

			placed.forEach( function ( p ) {
				if ( p.key === key ) {
					goTo( { cx: p.lng, cy: -p.lat, s: target.s } );
				}
			} );
		};

		/**
		 * Drag to pan (mouse, touch, pen) while zoomed in. Pointer capture only
		 * starts once the pointer has really moved, so a plain tap on a pin is
		 * still a click; a drag that ends over a pin swallows its click.
		 */
		var drag = null;
		var dragged = false;

		canvas.addEventListener( 'pointerdown', function ( event ) {
			if ( view.s <= 1.001 || ( 'mouse' === event.pointerType && 0 !== event.button ) || event.target.closest( '.hp-map-zoom' ) ) {
				return;
			}

			window.cancelAnimationFrame( raf );
			target = { cx: view.cx, cy: view.cy, s: view.s };
			drag = { id: event.pointerId, x: event.clientX, y: event.clientY, cx: view.cx, cy: view.cy, moved: false };
			dragged = false;
		} );

		canvas.addEventListener( 'pointermove', function ( event ) {
			if ( ! drag || event.pointerId !== drag.id ) {
				return;
			}

			var dx = event.clientX - drag.x;
			var dy = event.clientY - drag.y;

			if ( ! drag.moved ) {
				if ( Math.abs( dx ) + Math.abs( dy ) < 5 ) {
					return;
				}

				drag.moved = true;
				dragged = true;
				canvas.classList.add( 'is-dragging' );

				try {
					canvas.setPointerCapture( event.pointerId );
				} catch ( err ) {
					// Capture is a nicety; panning still works without it.
				}
			}

			var unitsPerPx = ( BASE.w / view.s ) / canvas.clientWidth;

			view = clampView( { s: view.s, cx: drag.cx - dx * unitsPerPx, cy: drag.cy - dy * unitsPerPx } );
			target = view;
			render();
		} );

		function endDrag( event ) {
			if ( drag && event.pointerId === drag.id ) {
				drag = null;
				canvas.classList.remove( 'is-dragging' );
			}
		}

		canvas.addEventListener( 'pointerup', endDrag );
		canvas.addEventListener( 'pointercancel', endDrag );

		canvas.addEventListener( 'click', function ( event ) {
			if ( dragged ) {
				event.stopPropagation();
				event.preventDefault();
				dragged = false;
			}
		}, true );

		if ( window.ResizeObserver ) {
			new window.ResizeObserver( updateScale ).observe( canvas );
		} else {
			window.addEventListener( 'resize', updateScale );
		}

		controls.hidden = false;

		if ( scaleBox ) {
			scaleBox.hidden = false;
		}

		render();
	}() );

	select( ( function () {
		var checked = root.querySelector( '.hp-alumni-chip input:checked' );

		return checked ? checked.value : 0;
	}() ) );
} )();
