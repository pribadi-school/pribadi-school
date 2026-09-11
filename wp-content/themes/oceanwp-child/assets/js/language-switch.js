/**
 * ID/EN language switch, inserted next to the header's Admission button.
 *
 * The header is Elementor Theme Builder content shared by every page, so
 * this never edits Elementor's stored data - it only inserts a small DOM
 * node into the rendered page and reads/writes a cookie. See the docblock
 * above oceanwp_child_current_lang() in functions.php for the full scope
 * decision (homepage content is bilingual; other pages are not, yet).
 *
 * `oceanwpChildLang.current` is localized from PHP (wp_localize_script),
 * not re-derived from document.cookie here - PHP already parsed the same
 * cookie to decide which language to render, so that is the single source
 * of truth for "what language is this page actually showing right now".
 */
( function () {
	'use strict';

	var current = ( window.oceanwpChildLang && oceanwpChildLang.current === 'en' ) ? 'en' : 'id';

	/*
	 * The header's nav is Elementor content, authored in English by
	 * default (that's what ships when hp_lang is unset/'id'). So the
	 * translation direction here is backwards from hp_t() in PHP: when
	 * the visitor's choice is Indonesian, this swaps the English labels
	 * to Indonesian client-side; in English mode there is nothing to do,
	 * the nav already reads correctly as authored.
	 */
	var NAV_ID_TEXT = {
		'About Us': 'Tentang Kami',
		'Schools': 'Sekolah',
		'Elementary': 'SD',
		'Junior High School': 'SMP',
		'Senior High School': 'SMA',
		'Community': 'Komunitas',
		'Parents Club': 'Klub Orang Tua',
		'Articles': 'Artikel',
		'Careers': 'Karier',
	};

	var ADMISSION_ID_TEXT = 'DAFTAR';

	/**
	 * Replace only the first non-whitespace text node inside `el`, leaving
	 * any child elements (icons, the dropdown-caret span) untouched. A
	 * plain `el.textContent = ...` would delete that markup along with
	 * the text - "Schools" and "Community" both carry a `.sub-arrow` icon
	 * span right after their label text.
	 */
	function swapLeadingText( el, newText ) {
		for ( var i = 0; i < el.childNodes.length; i++ ) {
			var node = el.childNodes[ i ];

			if ( 3 === node.nodeType && node.textContent.trim() !== '' ) {
				node.textContent = newText;
				return;
			}
		}
	}

	function translateNavToIndonesian() {
		var header = document.getElementById( 'site-header' );

		if ( ! header ) {
			return;
		}

		// querySelectorAll, not querySelector: the same Elementor nav
		// widget renders twice (desktop row + the mobile dropdown
		// fallback), and both need the swap.
		header.querySelectorAll( '.elementor-nav-menu a.elementor-item, .elementor-nav-menu a.elementor-sub-item' ).forEach( function ( link ) {
			var label = link.textContent.trim();

			if ( Object.prototype.hasOwnProperty.call( NAV_ID_TEXT, label ) ) {
				swapLeadingText( link, NAV_ID_TEXT[ label ] );
			}
		} );

		header.querySelectorAll( '.elementor-button-text' ).forEach( function ( span ) {
			if ( 'ADMISSION' === span.textContent.trim() ) {
				span.textContent = ADMISSION_ID_TEXT;
			}
		} );
	}

	// Full client-side re-render was ruled out (see the conversation this
	// shipped from): several translated strings are used inside esc_attr()
	// - alt text, screen-reader-only spans - not just inline HTML, so a
	// JS text-swap can't reach all of them without a much larger rework of
	// hp_t() and every call site. This fades the page out before the
	// server round-trip instead, so the switch still reloads (new
	// language is genuinely server-rendered, nothing stays stale) but
	// doesn't read as an abrupt flash-to-blank.
	var FADE_MS = 180;

	function setLanguage( lang ) {
		if ( lang === current ) {
			return;
		}

		// max-age in seconds (1 year); path=/ so it applies to every page,
		// since the switch button itself is shown on every page.
		document.cookie = 'hp_lang=' + lang + '; path=/; max-age=31536000; SameSite=Lax';

		document.documentElement.style.transition = 'opacity ' + FADE_MS + 'ms ease';
		document.documentElement.style.opacity = '0';

		window.setTimeout( function () {
			window.location.reload();
		}, FADE_MS );
	}

	function buildSwitcher() {
		var wrap = document.createElement( 'div' );
		wrap.className = 'hp-lang-switch';
		wrap.setAttribute( 'role', 'group' );
		wrap.setAttribute( 'aria-label', 'Bahasa / Language' );

		[ 'id', 'en' ].forEach( function ( lang ) {
			var btn = document.createElement( 'button' );
			btn.type = 'button';
			btn.className = 'hp-lang-btn';
			btn.textContent = lang.toUpperCase();
			btn.setAttribute( 'aria-pressed', String( lang === current ) );

			if ( lang === current ) {
				btn.classList.add( 'is-active' );
			}

			btn.addEventListener( 'click', function () {
				setLanguage( lang );
			} );

			wrap.appendChild( btn );
		} );

		return wrap;
	}

	function insertSwitcher() {
		var column = document.querySelector( '.elementor-column.btn-admission .elementor-widget-wrap' );

		if ( ! column || column.querySelector( '.hp-lang-switch' ) ) {
			return;
		}

		column.insertBefore( buildSwitcher(), column.firstChild );
	}

	// mobile-nav.js has no slot of its own for this - the desktop switch this
	// file builds lives in a column that's hidden below tablet width (see
	// style.css) - so it reuses this same builder to put a second instance
	// inside the mobile menu panel. Declared as a dependency in functions.php
	// so this assignment always runs first.
	window.oceanwpChildLangSwitch = {
		current: current,
		buildSwitcher: buildSwitcher,
	};

	function init() {
		insertSwitcher();

		if ( 'id' === current ) {
			translateNavToIndonesian();
		}
	}

	if ( 'loading' === document.readyState ) {
		document.addEventListener( 'DOMContentLoaded', init );
	} else {
		init();
	}

	// If this page is restored from bfcache (browser back/forward) after
	// having been faded out for a language switch, event.persisted is true
	// and none of the JS above re-runs - the inline opacity:0 from
	// setLanguage() would otherwise be the last thing left on it.
	window.addEventListener( 'pageshow', function ( event ) {
		if ( event.persisted ) {
			document.documentElement.style.transition = '';
			document.documentElement.style.opacity = '';
		}
	} );
} )();
