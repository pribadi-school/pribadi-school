<?php
/**
 * Plugin Name: Session path fix
 * Description: Points PHP sessions at a folder that exists when the server's own session folder is missing.
 *
 * Why: on production the server's session.save_path is
 * /var/cpanel/php/sessions/ea-php56, which no longer exists (the site runs
 * PHP 8.1). Any plugin that calls session_start() - PixelYourSite does, in
 * includes/class-pys.php - then prints "Failed to read session data" on every
 * page. Setting session.save_path in cPanel didn't take effect.
 *
 * Loaded two ways: functions.php requires it (that runs before the 'init'
 * hook, early enough for most plugins), and installed as a MUST-USE plugin it
 * runs before every normal plugin, which covers a plugin that opens its session
 * even earlier. Install the must-use copy on the server with:
 *
 *   mkdir -p ~/public_html/wp-content/mu-plugins ~/tmp && cp ~/repositories/oceanwp-child/wp-content/themes/oceanwp-child/mu-plugins/session-path-fix.php ~/public_html/wp-content/mu-plugins/
 *
 * It only acts when the configured folder is missing or not writable, so it
 * steps aside by itself once the host fixes their setting.
 */

defined( 'ABSPATH' ) || exit;

( function () {
	// Too late to change once a session is open (PHP warns), and nothing to do.
	if ( PHP_SESSION_ACTIVE === session_status() ) {
		return;
	}

	$current = session_save_path();

	// "N;/path" and "N;MODE;/path" forms: the folder is the last part.
	$parts  = explode( ';', (string) $current );
	$folder = end( $parts );

	// @: under open_basedir, probing a folder outside it warns instead of returning false.
	if ( $folder && @is_dir( $folder ) && @is_writable( $folder ) ) { // phpcs:ignore WordPress.PHP.NoSilencedErrors
		return;
	}

	// The account's own tmp folder (/home/<user>/tmp, next to public_html),
	// then the system temp folder as a last resort.
	$candidates = array( dirname( rtrim( ABSPATH, '/\\' ) ) . '/tmp', sys_get_temp_dir() );

	foreach ( $candidates as $dir ) {
		if ( ! @is_dir( $dir ) ) { // phpcs:ignore WordPress.PHP.NoSilencedErrors
			@mkdir( $dir, 0700, true ); // phpcs:ignore WordPress.PHP.NoSilencedErrors
		}

		if ( @is_dir( $dir ) && @is_writable( $dir ) ) { // phpcs:ignore WordPress.PHP.NoSilencedErrors
			session_save_path( $dir );
			return;
		}
	}
} )();
