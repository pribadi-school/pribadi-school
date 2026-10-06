<?php
/**
 * Template Name: Digital Classroom (Custom)
 *
 * The Digital Classroom program page, in the same layout as the Prestasi
 * page (shared template-parts/story-page.php). Content is in
 * template-parts/data/digital-classroom.php.
 *
 * Replaces the page's Elementor-built version, whose _elementor_data is left
 * in the database untouched: switching the page's template back to the
 * default brings it back. Same reasoning as the homepage - see CLAUDE.md.
 *
 * @package OceanWP_Child
 */

get_header();

get_template_part(
	'template-parts/story-page',
	null,
	array( 'data' => require get_stylesheet_directory() . '/template-parts/data/digital-classroom.php' )
);

get_footer();
