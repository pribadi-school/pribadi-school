/**
 * Mobile header navigation.
 *
 * The header's mobile Elementor section (.elementor-hidden-desktop) ships
 * with an empty menu column - Elementor never marks it
 * `elementor-element-populated`, because no widget was ever placed in it -
 * so mobile visitors got a logo and nothing else. The desktop nav row does
 * have a menu widget (with its own burger mode), but that whole section is
 * set to elementor-hidden-tablet/-mobile, so its burger can never surface
 * either. Both the live subdomain and the main production site have the
 * same gap, so this predates the custom homepage work.
 *
 * The fix is built here rather than by adding a widget in Elementor for two
 * reasons: the header template lives in the database, so an Elementor-side
 * fix would not travel with this theme through git (it would have to be
 * redone per environment and would drift), and Elementor rewrites its
 * stored document wholesale on every save - the exact class of edit that
 * caused this project's past data-loss incidents (see CLAUDE.md). Inserting
 * into the rendered DOM instead touches none of that, the same approach
 * assets/js/language-switch.js already uses for the ID/EN switch.
 *
 * Items are read from the desktop nav widget's own rendered markup rather
 * than hardcoded here, so this can never drift from whatever WordPress menu
 * the header is set to. That also means the labels arrive already
 * translated: language-switch.js is a declared dependency, so by the time
 * this runs it has swapped the nav's English defaults to Indonesian when
 * that's the active language.
 */
( function () {
	'use strict';

	var PANEL_ID = 'hp-mobile-nav-panel';

	var isIndonesian = ! ( window.oceanwpChildLang && 'en' === oceanwpChildLang.current );

	var LABELS = {
		open: isIndonesian ? 'Buka menu' : 'Open menu',
		close: isIndonesian ? 'Tutup menu' : 'Close menu',
		nav: isIndonesian ? 'Menu utama' : 'Main menu',
	};

	/**
	 * First non-whitespace text node inside `el`, so an item's label doesn't
	 * pick up the `.sub-arrow` caret span Elementor's menu injects after it.
	 */
	function leadingText( el ) {
		for ( var i = 0; i < el.childNodes.length; i++ ) {
			var node = el.childNodes[ i ];

			if ( 3 === node.nodeType && '' !== node.textContent.trim() ) {
				return node.textContent.trim();
			}
		}

		return el.textContent.trim();
	}

	function makeLink( href, label, className ) {
		var link = document.createElement( 'a' );
		link.className = className;
		link.href = href;
		link.textContent = label;
		return link;
	}

	function directChildren( parent, tagName ) {
		return Array.prototype.filter.call( parent.children, function ( child ) {
			return child.tagName === tagName;
		} );
	}

	/**
	 * Rebuild the menu as plain markup instead of cloning the source nodes.
	 * The source is managed at runtime by SmartMenus (the library Elementor's
	 * nav widget uses), which writes generated ids, aria-* attributes wired to
	 * those ids, tabindex="-1" on every link and inline display:none on every
	 * submenu. Cloning that wholesale would duplicate ids and carry over
	 * permanently-hidden submenus; reading just the label and href avoids all
	 * of it.
	 */
	function buildList( sourceList ) {
		var list = document.createElement( 'ul' );
		list.className = 'hp-mnav-list';

		directChildren( sourceList, 'LI' ).forEach( function ( sourceItem ) {
			var sourceLink = directChildren( sourceItem, 'A' )[ 0 ];

			if ( ! sourceLink ) {
				return;
			}

			var sourceSubList = directChildren( sourceItem, 'UL' )[ 0 ];
			var href = sourceLink.getAttribute( 'href' ) || '';
			var item = document.createElement( 'li' );
			item.className = 'hp-mnav-item';

			if ( sourceSubList && ( '' === href || '#' === href ) ) {
				/*
				 * A parent linking to "#" exists only to open a submenu on
				 * desktop hover. As a row in a tap-driven list it would be a
				 * link that goes nowhere, so it becomes a group heading and
				 * its children carry the actual destinations.
				 */
				var heading = document.createElement( 'span' );
				heading.className = 'hp-mnav-group';
				heading.textContent = leadingText( sourceLink );
				item.appendChild( heading );
			} else {
				item.appendChild( makeLink( href, leadingText( sourceLink ), 'hp-mnav-link' ) );
			}

			if ( sourceSubList ) {
				var subList = document.createElement( 'ul' );
				subList.className = 'hp-mnav-sublist';

				directChildren( sourceSubList, 'LI' ).forEach( function ( sourceSubItem ) {
					var sourceSubLink = directChildren( sourceSubItem, 'A' )[ 0 ];

					if ( ! sourceSubLink ) {
						return;
					}

					var subItem = document.createElement( 'li' );
					subItem.className = 'hp-mnav-item';
					subItem.appendChild( makeLink(
						sourceSubLink.getAttribute( 'href' ) || '',
						leadingText( sourceSubLink ),
						'hp-mnav-link hp-mnav-link--sub'
					) );
					subList.appendChild( subItem );
				} );

				/*
				 * Submenus render expanded and indented rather than as
				 * accordions: the whole menu is nine rows, so an extra
				 * tap-to-expand interaction would hide destinations behind a
				 * gesture without saving any meaningful scrolling.
				 */
				if ( subList.children.length ) {
					item.appendChild( subList );
				}
			}

			list.appendChild( item );
		} );

		return list;
	}

	function init() {
		var header = document.getElementById( 'site-header' );

		if ( ! header ) {
			return;
		}

		// The mobile header is its own Elementor section, hidden on desktop -
		// so no media query is needed here, the slot simply doesn't render
		// above tablet width.
		var section = header.querySelector( '.elementor-hidden-desktop' );

		if ( ! section ) {
			return;
		}

		var slot = section.querySelector( '.header-menu .elementor-widget-wrap' );

		if ( ! slot || slot.querySelector( '.hp-mnav-toggle' ) ) {
			return;
		}

		var sourceList = header.querySelector( '.elementor-nav-menu--main ul.elementor-nav-menu' );

		if ( ! sourceList ) {
			return;
		}

		var list = buildList( sourceList );

		// Nothing usable in the source menu - leave the header exactly as it
		// was rather than inserting an empty panel behind a burger button.
		if ( ! list.children.length ) {
			return;
		}

		var panel = document.createElement( 'nav' );
		panel.className = 'hp-mnav-panel';
		panel.id = PANEL_ID;
		panel.setAttribute( 'aria-label', LABELS.nav );
		panel.hidden = true;
		panel.appendChild( list );

		// The ID/EN switch (language-switch.js) only has a slot in the
		// desktop header row, which is hidden below tablet width - so mobile
		// visitors had no way to change language at all. Reuses that file's
		// own builder rather than duplicating the markup/click handling.
		if ( window.oceanwpChildLangSwitch ) {
			var langWrap = document.createElement( 'div' );
			langWrap.className = 'hp-mnav-lang';
			langWrap.appendChild( window.oceanwpChildLangSwitch.buildSwitcher() );
			panel.appendChild( langWrap );
		}

		var toggle = document.createElement( 'button' );
		toggle.type = 'button';
		toggle.className = 'hp-mnav-toggle';
		toggle.setAttribute( 'aria-expanded', 'false' );
		toggle.setAttribute( 'aria-controls', PANEL_ID );
		toggle.setAttribute( 'aria-label', LABELS.open );
		toggle.innerHTML = '<span class="hp-mnav-bars" aria-hidden="true"></span>';

		slot.appendChild( toggle );

		/*
		 * The panel is appended to the section rather than the menu column:
		 * that column is only ~156px wide, and the panel needs to span the
		 * full header width beneath it. The class is what gives the section
		 * the positioning context for that.
		 */
		section.classList.add( 'hp-mnav-host' );
		section.appendChild( panel );

		function setOpen( open ) {
			toggle.setAttribute( 'aria-expanded', String( open ) );
			toggle.setAttribute( 'aria-label', open ? LABELS.close : LABELS.open );
			toggle.classList.toggle( 'is-open', open );
			panel.hidden = ! open;
		}

		function isOpen() {
			return 'true' === toggle.getAttribute( 'aria-expanded' );
		}

		toggle.addEventListener( 'click', function () {
			setOpen( ! isOpen() );
		} );

		// Tapping a destination closes the panel behind the navigation, so it
		// isn't still hanging open if the browser restores this page later.
		panel.addEventListener( 'click', function ( event ) {
			if ( event.target.closest( '.hp-mnav-link' ) ) {
				setOpen( false );
			}
		} );

		document.addEventListener( 'click', function ( event ) {
			if ( isOpen() && ! event.target.closest( '.hp-mnav-panel, .hp-mnav-toggle' ) ) {
				setOpen( false );
			}
		} );

		document.addEventListener( 'keydown', function ( event ) {
			if ( 'Escape' === event.key && isOpen() ) {
				setOpen( false );
				toggle.focus();
			}
		} );
	}

	if ( 'loading' === document.readyState ) {
		document.addEventListener( 'DOMContentLoaded', init );
	} else {
		init();
	}
} )();
