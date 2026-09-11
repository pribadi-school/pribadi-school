<?php
/**
 * OceanWP Child theme functions.
 *
 * @package OceanWP_Child
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'OCEANWP_CHILD_VERSION', '1.0.0' );

/**
 * ID/EN language switch for the custom homepage template.
 *
 * Scope, deliberately: only the homepage template's own content is
 * server-rendered in both languages (see hp_t() below and its use
 * throughout page-homepage-custom.php / the achievements + alumni map
 * template parts). Every other page - About Us, Schools, Articles, etc. -
 * is separate Elementor-authored content outside this system; translating
 * those would mean either editing Elementor's stored data directly (the
 * exact kind of edit that caused this project's past data-loss incidents,
 * see CLAUDE.md) or a much larger effort. The switch button itself lives in
 * the shared header (added via assets/js/language-switch.js, DOM insertion
 * only - Elementor's own data is never touched), so it appears on every
 * page, but only actually changes content on the homepage; elsewhere it
 * only swaps the nav labels themselves.
 *
 * Language choice is a cookie, not a query string or URL prefix: this is a
 * single-locale site with no i18n plugin, so there is no /en/ URL
 * structure to hang a "real" localization system off. A cookie plus a full
 * page reload keeps the implementation small while still rendering the
 * chosen language server-side (no flash of the wrong language, unlike a
 * client-side-only text swap).
 */
function oceanwp_child_current_lang() {
	if ( ! isset( $_COOKIE['hp_lang'] ) ) {
		return 'id';
	}

	$lang = sanitize_text_field( wp_unslash( $_COOKIE['hp_lang'] ) );

	return ( 'en' === $lang ) ? 'en' : 'id';
}

/**
 * Pick the Indonesian or English string for the current visitor.
 *
 * Both strings are hand-written copy, not a mechanical translation of one
 * another - the English side is meant to read naturally to an English
 * reader, not to mirror the Indonesian sentence structure.
 *
 * @param string $id_text Indonesian copy (the site's default/original).
 * @param string $en_text English copy.
 * @return string
 */
function hp_t( $id_text, $en_text ) {
	return ( 'en' === oceanwp_child_current_lang() ) ? $en_text : $id_text;
}

/**
 * Where the transparent-header treatment should apply.
 *
 * Kept as its own function so the CSS, the JS and the body class can never
 * disagree about which pages get the effect.
 */
function oceanwp_child_has_transparent_header() {
	/**
	 * Filters which views get the transparent-to-solid header.
	 *
	 * @param bool $enabled Whether the treatment is active for this request.
	 */
	return (bool) apply_filters( 'oceanwp_child_has_transparent_header', is_front_page() );
}

/**
 * Cache-bust from file mtime so browsers pick up edits without a manual version bump.
 *
 * @param string $relative_path Path relative to the child theme root, with leading slash.
 * @return string
 */
function oceanwp_child_asset_version( $relative_path ) {
	$file = get_stylesheet_directory() . $relative_path;

	return file_exists( $file ) ? (string) filemtime( $file ) : OCEANWP_CHILD_VERSION;
}

/**
 * Enqueue child theme styles and scripts.
 */
function oceanwp_child_enqueue_assets() {
	wp_enqueue_style(
		'oceanwp-child-google-font-inter',
		'https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap',
		array(),
		null
	);

	wp_enqueue_style(
		'oceanwp-child',
		get_stylesheet_uri(),
		array( 'oceanwp-style', 'oceanwp-child-google-font-inter' ),
		oceanwp_child_asset_version( '/style.css' )
	);

	// Header dropdown timing/animation - same Elementor header on every page, so this isn't gated to the front page.
	wp_enqueue_script(
		'oceanwp-child-nav-dropdown',
		get_stylesheet_directory_uri() . '/assets/js/nav-dropdown-tuning.js',
		array( 'elementor-frontend' ),
		oceanwp_child_asset_version( '/assets/js/nav-dropdown-tuning.js' ),
		true
	);

	// Same shared header, same reasoning - see the docblock in
	// header-logo-tooltip.js.
	wp_enqueue_script(
		'oceanwp-child-header-logo-tooltip',
		get_stylesheet_directory_uri() . '/assets/js/header-logo-tooltip.js',
		array(),
		oceanwp_child_asset_version( '/assets/js/header-logo-tooltip.js' ),
		true
	);

	// Same reasoning: the header (and its Admission button) is shared by
	// every page, so the switch button next to it is too - see the
	// language-switch docblock above oceanwp_child_current_lang().
	wp_enqueue_script(
		'oceanwp-child-language-switch',
		get_stylesheet_directory_uri() . '/assets/js/language-switch.js',
		array(),
		oceanwp_child_asset_version( '/assets/js/language-switch.js' ),
		true
	);

	wp_localize_script(
		'oceanwp-child-language-switch',
		'oceanwpChildLang',
		array( 'current' => oceanwp_child_current_lang() )
	);

	// Builds the mobile header's menu, which the Elementor header template
	// never had a widget for - see the docblock in mobile-nav.js. Depends on
	// the language switch rather than merely being enqueued after it: the
	// menu is cloned from the rendered nav, so it has to run once that script
	// has already translated the nav's labels, or Indonesian visitors would
	// get an English mobile menu. Not gated to the front page - same shared
	// header on every page.
	wp_enqueue_script(
		'oceanwp-child-mobile-nav',
		get_stylesheet_directory_uri() . '/assets/js/mobile-nav.js',
		array( 'oceanwp-child-language-switch' ),
		oceanwp_child_asset_version( '/assets/js/mobile-nav.js' ),
		true
	);

	if ( ! oceanwp_child_has_transparent_header() ) {
		return;
	}

	wp_enqueue_style(
		'oceanwp-child-transparent-header',
		get_stylesheet_directory_uri() . '/assets/css/transparent-header.css',
		array( 'oceanwp-child' ),
		oceanwp_child_asset_version( '/assets/css/transparent-header.css' )
	);

	wp_enqueue_script(
		'oceanwp-child-transparent-header',
		get_stylesheet_directory_uri() . '/assets/js/transparent-header.js',
		array(),
		oceanwp_child_asset_version( '/assets/js/transparent-header.js' ),
		true
	);
}
add_action( 'wp_enqueue_scripts', 'oceanwp_child_enqueue_assets', 20 );

/**
 * Enqueue styles for the custom (non-Elementor) homepage template.
 */
function oceanwp_child_enqueue_homepage_template_assets() {
	if ( ! is_page_template( 'page-homepage-custom.php' ) ) {
		return;
	}

	wp_enqueue_style(
		'oceanwp-child-homepage',
		get_stylesheet_directory_uri() . '/assets/css/homepage.css',
		array( 'oceanwp-child' ),
		oceanwp_child_asset_version( '/assets/css/homepage.css' )
	);

	wp_enqueue_script(
		'oceanwp-child-hero-text-scroll',
		get_stylesheet_directory_uri() . '/assets/js/hero-text-scroll.js',
		array(),
		oceanwp_child_asset_version( '/assets/js/hero-text-scroll.js' ),
		true
	);

	wp_enqueue_script(
		'oceanwp-child-achievements-counter',
		get_stylesheet_directory_uri() . '/assets/js/achievements-counter.js',
		array(),
		oceanwp_child_asset_version( '/assets/js/achievements-counter.js' ),
		true
	);

	wp_enqueue_script(
		'oceanwp-child-achievements-tile-tap',
		get_stylesheet_directory_uri() . '/assets/js/achievements-tile-tap.js',
		array(),
		oceanwp_child_asset_version( '/assets/js/achievements-tile-tap.js' ),
		true
	);

	wp_enqueue_script(
		'oceanwp-child-achievements-marquee',
		get_stylesheet_directory_uri() . '/assets/js/achievements-marquee.js',
		array(),
		oceanwp_child_asset_version( '/assets/js/achievements-marquee.js' ),
		true
	);

	wp_enqueue_script(
		'oceanwp-child-scroll-reveal',
		get_stylesheet_directory_uri() . '/assets/js/scroll-reveal.js',
		array(),
		oceanwp_child_asset_version( '/assets/js/scroll-reveal.js' ),
		true
	);

	wp_enqueue_script(
		'oceanwp-child-alumni-map',
		get_stylesheet_directory_uri() . '/assets/js/alumni-map.js',
		array(),
		oceanwp_child_asset_version( '/assets/js/alumni-map.js' ),
		true
	);

	// Depends on the language switch for the same reason the mobile nav does:
	// it builds a couple of control labels itself and needs to know which
	// language the page actually rendered in.
	wp_enqueue_script(
		'oceanwp-child-hot-news',
		get_stylesheet_directory_uri() . '/assets/js/hot-news.js',
		array( 'oceanwp-child-language-switch' ),
		oceanwp_child_asset_version( '/assets/js/hot-news.js' ),
		true
	);
}
add_action( 'wp_enqueue_scripts', 'oceanwp_child_enqueue_homepage_template_assets', 20 );

/**
 * Body class the stylesheet keys off, so the effect can never leak onto other pages.
 *
 * Namespaced deliberately: OceanWP already emits its own `has-transparent-header`
 * body class from inc/helpers.php, so reusing that name would make the two
 * systems indistinguishable.
 *
 * @param string[] $classes Body classes.
 * @return string[]
 */
function oceanwp_child_body_class( $classes ) {
	if ( oceanwp_child_has_transparent_header() ) {
		$classes[] = 'owpc-transparent-header';
	}

	return $classes;
}
add_filter( 'body_class', 'oceanwp_child_body_class' );
