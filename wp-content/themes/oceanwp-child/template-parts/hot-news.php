<?php
/**
 * "Kabar Terkini" - the headline news carousel that opens the page body.
 *
 * A centred cinema-wide photo on a full-bleed brand-gradient band, its
 * headline hanging off the top-left edge, with the previous and next photos
 * peeking in at the sides. No arrow buttons, by direction. Advances on its
 * own every 3 seconds and can be driven by hand at any time (dots, swipe,
 * clicking a peeking photo, arrow keys); the
 * timer stops for good the moment a visitor takes control, and never starts
 * at all under prefers-reduced-motion. Behaviour lives in
 * assets/js/hot-news.js, which also does the bilingual control labels.
 *
 * $hp_hot_news is PLACEHOLDER content: the photos are existing library
 * images and the headlines describe achievements already listed further
 * down the page. Swap in real news before launch - each entry needs a
 * landscape image (roughly 16:9 fills the frame best) and a headline. No
 * eyebrow label or "read more" link, by direction - the headline is the
 * whole of the copy.
 *
 * @package OceanWP_Child
 */

$hp_hot_news = array(
	array(
		'image'    => 'https://pribadidepok.sch.id/wp-content/uploads/2023/10/Digital-Classroom-6-1.jpg',
		'title'    => 'Luvidi meraih medali emas di Olimpiade Internasional Kecerdasan Buatan',
		'title_en' => 'Luvidi takes gold at the International Olympiad in Artificial Intelligence',
	),
	array(
		'image'    => 'https://pribadidepok.sch.id/wp-content/uploads/2025/09/16.jpg',
		'title'    => 'Pribadi Mengajar kembali hadir bersama relawan penutur asing dari Australia',
		'title_en' => 'Pribadi Mengajar returns with native-speaker volunteers from Australia',
	),
	array(
		'image'    => 'https://pribadidepok.sch.id/wp-content/uploads/2023/10/Character-Building-2.jpg',
		'title'    => 'Biru membawa pulang medali perunggu dari SIMSO 2026',
		'title_en' => 'Biru brings home a bronze medal from SIMSO 2026',
	),
);

$hp_hot_news_count = count( $hp_hot_news );
?>

<section class="hp-section hp-hotnews">
	<?php /* Ornament layers: see the .hp-hotnews::before / ::after pair in homepage.css. */ ?>

	<?php
	/*
	 * No visible heading, by direction - the photos carry the section on
	 * their own. The stage's aria-label is what names it for screen readers.
	 */
	?>
	<div
		class="hp-hotnews-stage hp-reveal hp-reveal--up"
		data-hp-hotnews
		data-interval="3000"
		role="group"
		aria-roledescription="<?php echo esc_attr( hp_t( 'karosel', 'carousel' ) ); ?>"
		aria-label="<?php echo esc_attr( hp_t( 'Kabar terkini', 'Latest news' ) ); ?>"
	>
		<div class="hp-hotnews-viewport">
			<ul class="hp-hotnews-track">
				<?php foreach ( $hp_hot_news as $hp_news_index => $hp_news ) : ?>
					<?php
					// Slot offset from the active (first) slide, wrapped so the last
					// item sits to the left: 0, 1, ..., -1. Same formula hot-news.js
					// uses, so the peeks are in place before the script runs.
					$hp_news_half = (int) floor( $hp_hot_news_count / 2 );
					$hp_news_slot = ( ( $hp_news_index + $hp_news_half ) % $hp_hot_news_count ) - $hp_news_half;
					?>
					<li
						class="hp-hotnews-slide<?php echo 0 === $hp_news_index ? ' is-active' : ''; ?>"
						style="--k: <?php echo (int) $hp_news_slot; ?>;"
						role="group"
						aria-roledescription="<?php echo esc_attr( hp_t( 'slide', 'slide' ) ); ?>"
						aria-label="<?php echo esc_attr( sprintf( '%d / %d', $hp_news_index + 1, $hp_hot_news_count ) ); ?>"
						<?php echo 0 === $hp_news_index ? '' : 'aria-hidden="true"'; ?>
					>
						<?php // The frame clips the photo; the copy is its sibling so it can hang outside it. ?>
						<div class="hp-hotnews-frame">
							<img
								class="hp-hotnews-photo"
								src="<?php echo esc_url( $hp_news['image'] ); ?>"
								alt=""
								<?php // The first slide is above the fold on tall screens, so it is not deferred. ?>
								loading="<?php echo 0 === $hp_news_index ? 'eager' : 'lazy'; ?>"
							>
						</div>

						<div class="hp-hotnews-copy">
							<h3 class="hp-hotnews-title"><?php echo esc_html( hp_t( $hp_news['title'], $hp_news['title_en'] ) ); ?></h3>
						</div>
					</li>
				<?php endforeach; ?>
			</ul>
		</div>

		<div class="hp-hotnews-dots" role="tablist" aria-label="<?php echo esc_attr( hp_t( 'Pilih berita', 'Choose an item' ) ); ?>">
			<?php foreach ( $hp_hot_news as $hp_dot_index => $hp_dot ) : ?>
				<button
					class="hp-hotnews-dot<?php echo 0 === $hp_dot_index ? ' is-active' : ''; ?>"
					type="button"
					role="tab"
					data-hp-hotnews-dot="<?php echo (int) $hp_dot_index; ?>"
					aria-selected="<?php echo 0 === $hp_dot_index ? 'true' : 'false'; ?>"
				>
					<span class="screen-reader-text"><?php echo esc_html( hp_t( $hp_dot['title'], $hp_dot['title_en'] ) ); ?></span>
				</button>
			<?php endforeach; ?>
		</div>
	</div>
</section>
