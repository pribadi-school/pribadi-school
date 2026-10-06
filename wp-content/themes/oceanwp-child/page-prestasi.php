<?php
/**
 * Template Name: Prestasi (Custom)
 *
 * Student achievements page. Layout modelled on
 * rushd.sch.id/achievements, rebuilt in this site's own design system
 * (design-system/sekolah-pribadi-depok/MASTER.md); the markup itself is the
 * shared template-parts/story-page.php, and all content - intro copy,
 * categories, stories - is in template-parts/data/achievement-stories.php.
 *
 * Hand-written for the same reason as the homepage template: content lives
 * in theme files, never in Elementor data, so nothing here can be
 * overwritten by an editor "Update" (see CLAUDE.md). The page itself only
 * needs to exist in WP with this template selected - its post content is
 * never rendered.
 *
 * @package OceanWP_Child
 */

get_header();

get_template_part(
	'template-parts/story-page',
	null,
	array( 'data' => require get_stylesheet_directory() . '/template-parts/data/achievement-stories.php' )
);

get_footer();
