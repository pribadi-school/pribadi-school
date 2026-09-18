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
 *
 * Default (no cookie yet, i.e. a first-time visitor) is English, by
 * direction. language-switch.js's ID translation of the Elementor nav
 * already only runs when the active language is Indonesian, so this default
 * needed no change there - an unset cookie now just resolves to the branch
 * that leaves the nav's own English labels alone.
 */
function oceanwp_child_current_lang() {
	if ( ! isset( $_COOKIE['hp_lang'] ) ) {
		return 'en';
	}

	$lang = sanitize_text_field( wp_unslash( $_COOKIE['hp_lang'] ) );

	return ( 'id' === $lang ) ? 'id' : 'en';
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
 * OceanWP's built-in page header ("Home" title above the content) has no
 * business showing on the custom homepage template - the hero already
 * carries its own heading. Hiding it here, in code, means it stays hidden
 * regardless of the sitewide Customizer setting on whatever install this
 * theme is running on (this was missed the first time the theme was moved
 * to a new site, since the Customizer setting doesn't travel with it).
 */
function oceanwp_child_hide_page_header_on_homepage( $display ) {
	if ( is_page_template( 'page-homepage-custom.php' ) ) {
		return false;
	}

	return $display;
}
add_filter( 'ocean_display_page_header', 'oceanwp_child_hide_page_header_on_homepage' );

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

/**
 * Where the intro preloader may appear. It still only actually shows on the
 * first page of a visit - assets/js/preloader.js decides that client-side,
 * per browser-tab session - this just rules out views where it would get in
 * the way: the Customizer, the Elementor editor's preview frame, feeds and
 * embeds.
 */
function oceanwp_child_has_preloader() {
	$enabled = ! is_customize_preview()
		&& ! is_feed()
		&& ! is_embed()
		&& ! isset( $_GET['elementor-preview'] ); // phpcs:ignore WordPress.Security.NonceVerification.Recommended -- read-only check, no action taken.

	if ( $enabled && class_exists( '\Elementor\Plugin' ) && isset( \Elementor\Plugin::$instance->preview ) ) {
		$enabled = ! \Elementor\Plugin::$instance->preview->is_preview_mode();
	}

	/**
	 * Filters whether the intro preloader can appear on this request.
	 *
	 * @param bool $enabled Whether the preloader is allowed here.
	 */
	return (bool) apply_filters( 'oceanwp_child_has_preloader', $enabled );
}

/**
 * Preloader CSS + JS, printed inline at the very top of <head>.
 *
 * Inline rather than enqueued on purpose: the screen has to be styled on the
 * first paint, and a caching/optimisation plugin (LiteSpeed on production)
 * that defers or combines CSS/JS would otherwise let the page flash before
 * the loader. The data-no-* attributes ask those plugins to leave these two
 * tags alone. The source still lives in assets/css/preloader.css and
 * assets/js/preloader.js, like every other asset in this theme.
 */
function oceanwp_child_print_preloader_head() {
	if ( ! oceanwp_child_has_preloader() ) {
		return;
	}

	$dir = get_stylesheet_directory();
	$css = file_get_contents( $dir . '/assets/css/preloader.css' ); // phpcs:ignore WordPress.WP.AlternativeFunctions.file_get_contents_file_get_contents -- local theme file.
	$js  = file_get_contents( $dir . '/assets/js/preloader.js' ); // phpcs:ignore WordPress.WP.AlternativeFunctions.file_get_contents_file_get_contents -- local theme file.

	if ( false === $css || false === $js ) {
		return;
	}

	$logo_rel  = '/assets/img/logo-red.png';
	$logo_size = @getimagesize( $dir . $logo_rel ); // phpcs:ignore WordPress.PHP.NoSilencedErrors.Discouraged -- missing file just means no intrinsic size.

	$config = array(
		'logo'   => add_query_arg( 'ver', oceanwp_child_asset_version( $logo_rel ), get_stylesheet_directory_uri() . $logo_rel ),
		'width'  => $logo_size ? (int) $logo_size[0] : 0,
		'height' => $logo_size ? (int) $logo_size[1] : 0,
	);

	echo '<style id="owpc-preloader-css" data-no-optimize="1">' . $css . '</style>' . "\n"; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- static theme file.
	echo '<script id="owpc-preloader-js" data-no-optimize="1" data-no-defer="1" data-cfasync="false">'
		. 'window.owpcPreloaderConfig=' . wp_json_encode( $config ) . ';'
		. $js // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- static theme file.
		. '</script>' . "\n";
}
add_action( 'wp_head', 'oceanwp_child_print_preloader_head', 1 );

/**
 * Mount the preloader screen as the first thing inside <body>, before any
 * page content can paint. A no-op unless preloader.js decided, in <head>,
 * that this page view gets it - so repeat navigations carry no extra markup.
 */
function oceanwp_child_mount_preloader() {
	if ( ! oceanwp_child_has_preloader() ) {
		return;
	}

	echo '<script data-no-optimize="1" data-no-defer="1" data-cfasync="false">window.owpcPreloader&&window.owpcPreloader.mount();</script>' . "\n";
}
add_action( 'wp_body_open', 'oceanwp_child_mount_preloader', 1 );
