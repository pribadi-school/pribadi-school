/**
 * Tap-to-reveal fallback for the achievement photo strip on touch devices,
 * where CSS :hover never fires. Toggles the same `.is-active` class the
 * CSS already keys off of (see .hp-achieve-tile:hover / .is-active in
 * homepage.css) - one tap opens a tile's reveal card, tapping elsewhere
 * (another tile, or outside the strip) closes it.
 *
 * Skipped entirely on a device that actually has hover (mouse/trackpad),
 * not just "added as a harmless redundant click" the way this used to be
 * commented - it wasn't harmless. Clicking a tile added .is-active on top
 * of the CSS :hover lift; moving the pointer away then ended :hover but
 * left .is-active in place (nothing removes it except a click outside the
 * strip), so the tile stayed stuck lifted/open until the visitor clicked
 * something else - read as "hover then click freezes it open".
 */
( function () {
	'use strict';

	if ( window.matchMedia && window.matchMedia( '(hover: hover) and (pointer: fine)' ).matches ) {
		return;
	}

	var tiles = document.querySelectorAll( '.hp-achieve-tile' );

	if ( ! tiles.length ) {
		return;
	}

	function closeAll( except ) {
		tiles.forEach( function ( tile ) {
			if ( tile !== except ) {
				tile.classList.remove( 'is-active' );
			}
		} );
	}

	tiles.forEach( function ( tile ) {
		tile.addEventListener( 'click', function ( event ) {
			var isActive = tile.classList.contains( 'is-active' );
			closeAll( tile );
			tile.classList.toggle( 'is-active', ! isActive );

			// The tile itself has no link/action yet - suppress the
			// default so a stray tap doesn't do something unexpected
			// once these become real links to student/achievement pages.
			if ( ! isActive ) {
				event.preventDefault();
			}
		} );
	} );

	document.addEventListener( 'click', function ( event ) {
		if ( ! event.target.closest( '.hp-achieve-tile' ) ) {
			closeAll( null );
		}
	} );
} )();
