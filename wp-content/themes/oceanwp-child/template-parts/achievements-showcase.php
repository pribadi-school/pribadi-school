<?php
/**
 * Achievement stats (count-up on scroll) + auto-scrolling photo strip.
 *
 * $hp_achieve_stats holds real, verified figures. $hp_achievements below it
 * is now all real entries too (the placeholder rows with no photo file
 * were removed rather than left as empty medal-icon tiles). Counters are
 * driven by assets/js/achievements-counter.js
 * (IntersectionObserver-gated, runs once). $hp_achievements is rendered
 * twice into .hp-achieve-track so the
 * CSS-only marquee (assets/css/homepage.css) can loop seamlessly at
 * -50%; only the first pass is real/focusable, the second is
 * aria-hidden. Hovering the strip pauses the scroll; hovering a tile
 * also lifts its photo and slides its title/name reveal up - all
 * CSS-only. assets/js/achievements-tile-tap.js adds a tap-to-reveal
 * fallback for touch, where :hover doesn't apply.
 *
 * Photos: drop real achievement/student photos into
 * assets/img/achievements/ using the filenames below. A portrait-ish crop,
 * roughly 3:4, fills the tile best. Entries whose file doesn't exist yet
 * render a neutral medal placeholder instead of a broken <img>, so a
 * half-populated set still looks deliberate.
 *
 * Save them as WebP around 600x800 and well under ~100KB each. The tile
 * renders at 200x267 (150x200 on mobile), so that is already ~3x oversampled
 * - anything bigger is wasted bytes on a strip that loads eight of them.
 * These started life as 1350x1800 PNGs averaging 2MB each, 16.5MB for the
 * set, which is what made the strip slow to fill in.
 *
 * Each tile is a real link to that student's Instagram post/reel, opened in
 * a new tab - source of truth is whoever asked for this (matched to entries
 * by student name), not anything derivable from the photo or achievement
 * itself. On touch, achievements-tile-tap.js's existing tap-to-reveal
 * already does the right thing for a real href without any change: the
 * first tap reveals the title card and suppresses navigation, a second tap
 * (now that the tile is already active) navigates.
 *
 * @package OceanWP_Child
 */

$hp_achieve_stats = array(
	array(
		'value'    => 681,
		'label'    => 'Total Prestasi',
		'label_en' => 'Total Achievements',
	),
	array(
		'value'    => 129,
		'label'    => 'Internasional',
		'label_en' => 'International',
	),
	array(
		'value'    => 190,
		'label'    => 'Nasional',
		'label_en' => 'National',
	),
	array(
		'value'    => 362,
		'label'    => 'Regional',
		'label_en' => 'Regional',
	),
);

/*
 * 'title_en' is a real English phrasing of the same achievement, not a
 * literal translation - "Juara 1... Tingkat Kota" becomes "1st Place...
 * (City Level)" rather than "Winner 1... City Level". Names are people's
 * names and are never translated.
 */
$hp_achievements = array(
	array(
		'photo'    => 'luvidi-ioai.webp',
		'title'    => 'Medali Emas Olimpiade Internasional Kecerdasan Buatan (IOAI)',
		'title_en' => 'Gold Medal, International Olympiad in Artificial Intelligence (IOAI)',
		'name'     => 'Luvidi',
		'link'     => 'https://www.instagram.com/reel/Db2zYFzNP0P/?stkn=MTFtZzZ5eHh3MzR6Mw==',
	),
	array(
		'photo'    => 'aleksa-horse.webp',
		'title'    => 'Prestasi Berkuda (Equestrian)',
		'title_en' => 'Equestrian Achievement',
		'name'     => 'Aleksa',
		'link'     => 'https://www.instagram.com/p/DcvEAEjkYbp/?stkn=Y3ZhY2wwNmlqNHNk',
	),
	array(
		'photo'    => 'biru-simso.webp',
		'title'    => 'Medali Perunggu, SIMSO 2026',
		'title_en' => 'Bronze Medal, SIMSO 2026',
		'name'     => 'Biru',
		'link'     => 'https://www.instagram.com/p/DcsoZE-kTTJ/?stkn=MTV4eTM4ZmliODVtMA==',
	),
	array(
		'photo'    => 'fayha-sumbawa.webp',
		'title'    => 'Memberikan Dampak Nyata di Sumbawa',
		'title_en' => 'Making an Impact in Sumbawa',
		'name'     => 'Fayha',
		'link'     => 'https://www.instagram.com/p/Dbm_PwKEe6T/?stkn=MWthd3ZmZTFldXRsMA==',
	),
	array(
		'photo'    => 'lala-fashion-week.webp',
		'title'    => 'Desainer Muda di Indonesia Trend Fashion Week 2026 melalui Program Dream Fashion',
		'title_en' => 'Young Designer, Indonesia Trend Fashion Week 2026 (Dream Fashion Program)',
		'name'     => 'Lala',
		'link'     => 'https://www.instagram.com/p/DbZpLopGHG4/?stkn=MWd3bDRhcjcxOTU0cg==',
	),
	array(
		'photo'    => 'musa-jismo-silver-bronze.webp',
		'title'    => 'Jismo Silver Bronze',
		'title_en' => 'Jismo Silver Bronze',
		'name'     => 'Musa',
		'link'     => 'https://www.instagram.com/p/Dcuh6u0mGbn/?stkn=MXJjOHhicjZ0bHFycA==',
	),
	array(
		'photo'    => 'tobias-bronze-science-jismo.webp',
		'title'    => 'Bronze Science Jismo',
		'title_en' => 'Bronze Science Jismo',
		'name'     => 'Tobias',
		'link'     => 'https://www.instagram.com/p/DcsoYUFkX5T/?stkn=MWx1czhrdGt5Z3V2Nw==',
	),
	array(
		'photo'    => 'ayu-swimming-competition.webp',
		'title'    => 'Swimming Competition',
		'title_en' => 'Swimming Competition',
		'name'     => 'Ayu',
		'link'     => 'https://www.instagram.com/p/DcxZ30BkfY6/?stkn=MXB5YWdmaTBuaWo0Zw==',
	),
	/*
	 * Every tile in this strip links to an Instagram post, by direction. The
	 * OMI 2026 tile ('omi-2026.webp', five students advancing to the provincial
	 * round) was taken out because it had no post to link to; it is still on
	 * the Prestasi page. Add it back here once it has a link.
	 */
);

/*
 * Resolve which photos actually exist once, here, rather than inside the
 * two-pass render loop below - otherwise every file is stat()ed twice.
 */
$hp_achieve_photo_dir = get_stylesheet_directory() . '/assets/img/achievements/';

foreach ( $hp_achievements as $hp_key => $hp_entry ) {
	$hp_achievements[ $hp_key ]['has_photo'] = file_exists( $hp_achieve_photo_dir . $hp_entry['photo'] );
}
unset( $hp_key, $hp_entry );
?>

<div class="hp-achieve-stats">
	<?php foreach ( $hp_achieve_stats as $hp_stat_index => $hp_stat ) : ?>
		<div class="hp-achieve-stat hp-reveal" style="animation-delay: <?php echo (int) ( $hp_stat_index * 80 ); ?>ms;">
			<span class="hp-achieve-stat-number" data-count-to="<?php echo (int) $hp_stat['value']; ?>">0</span>
			<span class="hp-achieve-stat-label"><?php echo esc_html( hp_t( $hp_stat['label'], $hp_stat['label_en'] ) ); ?></span>
		</div>
	<?php endforeach; ?>
</div>

<?php
/*
 * Link through to the full achievements page (page-prestasi.php), the way
 * rushd.sch.id's "Hall of Fame" button sits under its numbers. Resolved by
 * slug so it follows the page if its ID differs between installs; falls
 * back to the same /prestasi/ URL when the page hasn't been created yet on
 * this install (create it in wp-admin with the "Prestasi (Custom)"
 * template, slug "prestasi").
 */
$hp_prestasi_page = get_page_by_path( 'prestasi' );
$hp_prestasi_url  = $hp_prestasi_page ? get_permalink( $hp_prestasi_page ) : home_url( '/prestasi/' );
?>
<div class="hp-achieve-cta hp-reveal">
	<a class="hp-btn" href="<?php echo esc_url( $hp_prestasi_url ); ?>">
		<?php echo esc_html( hp_t( 'Lihat Semua Prestasi', 'See All Achievements' ) ); ?>
		<i class="fas fa-arrow-right" aria-hidden="true"></i>
	</a>
</div>

<?php
/*
 * The strip is a reveal target itself, not just a container: its tiles ride a
 * looping horizontal track inside this overflow:hidden box, so a tile sitting
 * past the clip edge when the strip scrolls into view would never intersect
 * on its own and would stay invisible. scroll-reveal.js reveals descendants
 * along with their container, so this is what guarantees every tile arrives.
 */
?>
<div class="hp-achieve-strip hp-reveal">
	<div class="hp-achieve-track">
		<?php for ( $hp_pass = 0; $hp_pass < 2; $hp_pass++ ) : ?>
			<?php foreach ( $hp_achievements as $hp_item_index => $hp_item ) : ?>
				<?php
				$hp_is_first_pass = 0 === $hp_pass;
				// A handful of entries have no source link yet (e.g. a school-wide
				// announcement with no single Instagram post to point to) - those
				// render as a plain, non-interactive tile instead of a dead link.
				$hp_tag = $hp_item['link'] ? 'a' : 'div';
				?>
				<<?php echo esc_attr( $hp_tag ); ?>
					<?php if ( $hp_item['link'] ) : ?>
						href="<?php echo esc_url( $hp_item['link'] ); ?>"
						target="_blank"
						rel="noopener noreferrer"
					<?php endif; ?>
					class="hp-achieve-tile<?php echo $hp_is_first_pass ? ' hp-reveal' : ''; ?>"
					<?php if ( $hp_is_first_pass ) : ?>
						<?php // Capped at 6 steps: past ~8 staggered children the last ones read as lag, not sequence. ?>
						style="animation-delay: <?php echo (int) ( ( $hp_item_index % 6 ) * 80 ); ?>ms;"
					<?php else : ?>
						aria-hidden="true" tabindex="-1"
					<?php endif; ?>
				>
					<?php if ( $hp_item['has_photo'] ) : ?>
						<img
							class="hp-achieve-tile-photo"
							src="<?php echo esc_url( get_stylesheet_directory_uri() . '/assets/img/achievements/' . $hp_item['photo'] ); ?>"
							alt="<?php echo $hp_is_first_pass ? esc_attr( $hp_item['name'] . ' - ' . hp_t( $hp_item['title'], $hp_item['title_en'] ) ) : ''; ?>"
							loading="lazy"
						>
					<?php else : ?>
						<span class="hp-achieve-tile-photo hp-achieve-tile-placeholder" aria-hidden="true">
							<i class="fas fa-medal"></i>
						</span>
					<?php endif; ?>
					<div class="hp-achieve-tile-reveal">
						<span class="hp-achieve-tile-title"><?php echo esc_html( hp_t( $hp_item['title'], $hp_item['title_en'] ) ); ?></span>
						<span class="hp-achieve-tile-name"><?php echo esc_html( $hp_item['name'] ); ?></span>
					</div>
				</<?php echo esc_attr( $hp_tag ); ?>>
			<?php endforeach; ?>
		<?php endfor; ?>
	</div>
</div>
