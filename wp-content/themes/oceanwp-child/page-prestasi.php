<?php
/**
 * Template Name: Prestasi (Custom)
 *
 * Student achievements page: an intro banner, a filterable list of
 * achievement stories (wide photo on top, write-up underneath), and a
 * closing call-to-action for Pribadi Magazine INSPIRE. Layout modelled on
 * rushd.sch.id/achievements, rebuilt in this site's own design system
 * (design-system/sekolah-pribadi-depok/MASTER.md).
 *
 * Hand-written for the same reason as the homepage template: page content
 * lives in this file and template-parts/data/achievement-stories.php, never
 * in Elementor data, so nothing here can be overwritten by an editor
 * "Update" (see CLAUDE.md). The page itself only needs to exist in WP with
 * this template selected - its post content is never rendered.
 *
 * Bilingual through hp_t(), like the homepage. Filtering is
 * assets/js/prestasi-filter.js; with no JS every story simply shows.
 *
 * @package OceanWP_Child
 */

$pr_data       = require get_stylesheet_directory() . '/template-parts/data/achievement-stories.php';
$pr_categories = $pr_data['categories'];
$pr_stories    = $pr_data['stories'];
$pr_img_uri    = get_stylesheet_directory_uri() . '/assets/img/';

// Only offer filters that would actually show something, in the order the
// data file lists them.
$pr_used_categories = array();
foreach ( $pr_stories as $pr_story ) {
	foreach ( $pr_story['categories'] as $pr_cat ) {
		$pr_used_categories[ $pr_cat ] = true;
	}
}
$pr_filters = array_intersect_key( $pr_categories, $pr_used_categories );

get_header();
?>

<main id="prestasi-custom">

	<!-- Intro: heading, lede, wide photo of the school's medal cabinet -->
	<section class="pr-section pr-intro">
		<div class="pr-container">
			<div class="pr-intro-head">
				<span class="pr-intro-badge hp-reveal" aria-hidden="true"><i class="fas fa-medal"></i></span>
				<h1 class="pr-intro-title hp-reveal" style="animation-delay: 80ms;"><?php echo hp_t(
					'Kisah <span class="pr-heading-accent">Prestasi</span> Siswa Pribadi',
					'Stories of Pribadi <span class="pr-heading-accent">Achievers</span>'
				); ?></h1>
				<p class="pr-intro-lede hp-reveal" style="animation-delay: 160ms;"><?php echo esc_html( hp_t(
					'Di Sekolah Pribadi Depok, setiap pencapaian siswa layak dirayakan - besar maupun kecil, di olimpiade sains, teknologi, olahraga, seni, hingga kegiatan sosial. Lewat halaman ini kami merangkum perjalanan mereka: tantangan yang dihadapi, tonggak yang diraih, dan pelajaran di baliknya. Bukan hanya hasilnya yang kami hargai, tetapi juga usaha dan pertumbuhan di balik setiap keberhasilan.',
					'At Sekolah Pribadi Depok, every student achievement is worth celebrating - big or small, in science olympiads, technology, sports, the arts and community work. This page gathers their journeys: the challenges they took on, the milestones they reached and what they learned along the way. We honour not just the results, but the effort and growth behind every success.'
				) ); ?></p>
			</div>

			<figure class="pr-intro-banner hp-reveal hp-reveal--up">
				<img
					src="<?php echo esc_url( $pr_img_uri . 'prestasi-banner.webp' ); ?>"
					width="2000"
					height="1125"
					alt="<?php echo esc_attr( hp_t( 'Lemari medali Sekolah Pribadi Depok', 'The Sekolah Pribadi Depok medal cabinet' ) ); ?>"
					fetchpriority="high"
				>
			</figure>
		</div>
	</section>

	<!-- Stories: category filter + cards (wide photo on top, write-up below) -->
	<section class="pr-section pr-stories" id="kisah">
		<div class="pr-container">
			<div class="pr-section-head hp-reveal">
				<h2><?php echo hp_t(
					'Cerita di Balik <span class="pr-heading-accent">Setiap Pencapaian</span>',
					'The Stories Behind <span class="pr-heading-accent">Every Achievement</span>'
				); ?></h2>
			</div>

			<div class="pr-filters hp-reveal" role="toolbar" aria-label="<?php echo esc_attr( hp_t( 'Saring berdasarkan bidang', 'Filter by field' ) ); ?>" data-pr-filters hidden>
				<?php // No "All" button, by direction (less clutter): the first category is selected on load instead. ?>
				<?php $pr_first = true; ?>
				<?php foreach ( $pr_filters as $pr_key => $pr_cat ) : ?>
					<button type="button" class="pr-filter<?php echo $pr_first ? ' is-active' : ''; ?>" data-pr-filter="<?php echo esc_attr( $pr_key ); ?>" aria-pressed="<?php echo $pr_first ? 'true' : 'false'; ?>"><?php echo esc_html( hp_t( $pr_cat['label'], $pr_cat['label_en'] ) ); ?></button>
					<?php $pr_first = false; ?>
				<?php endforeach; ?>
			</div>

			<p class="screen-reader-text" aria-live="polite" data-pr-status></p>

			<div class="pr-story-list">
				<?php foreach ( $pr_stories as $pr_index => $pr_story ) : ?>
					<?php
					$pr_title   = hp_t( $pr_story['title'], $pr_story['title_en'] );
					$pr_name    = isset( $pr_story['name_en'] ) ? hp_t( $pr_story['name'], $pr_story['name_en'] ) : $pr_story['name'];
					$pr_date    = isset( $pr_story['date'] ) ? hp_t( $pr_story['date'], isset( $pr_story['date_en'] ) ? $pr_story['date_en'] : $pr_story['date'] ) : '';
					$pr_long    = isset( $pr_story['story'] ) ? hp_t( $pr_story['story'], isset( $pr_story['story_en'] ) ? $pr_story['story_en'] : $pr_story['story'] ) : '';
					$pr_link    = isset( $pr_story['link'] ) ? $pr_story['link'] : '';
					$pr_focus   = isset( $pr_story['focus'] ) ? $pr_story['focus'] : '';
					?>
					<article
						class="pr-story hp-reveal"
						data-pr-categories="<?php echo esc_attr( implode( ' ', $pr_story['categories'] ) ); ?>"
					>
						<div class="pr-story-media">
							<img
								src="<?php echo esc_url( $pr_img_uri . $pr_story['photo'] ); ?>"
								alt="<?php echo esc_attr( $pr_name . ' - ' . $pr_title ); ?>"
								loading="<?php echo $pr_index < 1 ? 'eager' : 'lazy'; ?>"
								<?php if ( $pr_focus ) : ?>
									style="object-position: <?php echo esc_attr( $pr_focus ); ?>;"
								<?php endif; ?>
							>
						</div>

						<div class="pr-story-body">
							<ul class="pr-story-tags">
								<?php foreach ( $pr_story['categories'] as $pr_cat ) : ?>
									<?php if ( isset( $pr_categories[ $pr_cat ] ) ) : ?>
										<li><?php echo esc_html( hp_t( $pr_categories[ $pr_cat ]['label'], $pr_categories[ $pr_cat ]['label_en'] ) ); ?></li>
									<?php endif; ?>
								<?php endforeach; ?>
							</ul>

							<h3 class="pr-story-title"><?php echo esc_html( $pr_title ); ?></h3>

							<p class="pr-story-meta">
								<span class="pr-story-name"><?php echo esc_html( $pr_name ); ?></span>
								<?php if ( $pr_date ) : ?>
									<span class="pr-story-date"><?php echo esc_html( $pr_date ); ?></span>
								<?php endif; ?>
							</p>

							<div class="pr-story-text">
								<p><?php echo esc_html( hp_t( $pr_story['summary'], $pr_story['summary_en'] ) ); ?></p>
								<?php if ( $pr_long ) : ?>
									<?php echo wpautop( esc_html( $pr_long ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- escaped before wpautop. ?>
								<?php endif; ?>
							</div>

							<?php if ( $pr_link ) : ?>
								<a class="pr-story-link" href="<?php echo esc_url( $pr_link ); ?>" target="_blank" rel="noopener noreferrer">
									<i class="fab fa-instagram" aria-hidden="true"></i>
									<?php echo esc_html( hp_t( 'Lihat di Instagram', 'View on Instagram' ) ); ?>
									<span class="screen-reader-text"><?php echo esc_html( hp_t( '(membuka tab baru)', '(opens in a new tab)' ) ); ?></span>
								</a>
							<?php endif; ?>
						</div>
					</article>
				<?php endforeach; ?>
			</div>
		</div>
	</section>

	<!-- Closing CTA: Pribadi Magazine INSPIRE (latest issue) -->
	<section class="pr-section pr-magazine">
		<div class="pr-container">
			<div class="pr-magazine-card hp-reveal">
				<a class="pr-magazine-cover" href="https://heyzine.com/flip-book/7346a6ab6a.html" target="_blank" rel="noopener">
					<img
						src="https://pribadidepok.sch.id/wp-content/uploads/2025/08/Inspire-Pribadi-Magazine-Edisi-3-20242025.png"
						alt="<?php echo esc_attr( hp_t( 'Sampul Pribadi Magazine Inspire Edisi 3', 'Pribadi Magazine Inspire, Issue 3 cover' ) ); ?>"
						loading="lazy"
					>
				</a>
				<div class="pr-magazine-copy">
					<h2>Pribadi Magazine <span class="pr-magazine-accent">INSPIRE</span></h2>
					<p><?php echo esc_html( hp_t(
						'Kenali Sekolah Pribadi Depok lebih dekat. Kisah, prestasi, dan cerita dari komunitas kami terangkum di setiap edisi Pribadi Magazine Inspire.',
						'Get to know Sekolah Pribadi Depok a little better. Our stories, achievements and community life, gathered in every issue of Pribadi Magazine Inspire.'
					) ); ?></p>
					<div class="pr-magazine-actions">
						<a class="pr-btn" href="https://heyzine.com/flip-book/7346a6ab6a.html" target="_blank" rel="noopener"><?php echo esc_html( hp_t( 'Baca Edisi Terbaru', 'Read the Latest Issue' ) ); ?></a>
						<a class="pr-btn pr-btn-outline" href="https://drive.google.com/file/d/1mzMAHMVhHEUqQSm6NkdAXzxEea3JSk0D/view?usp=drive_link" target="_blank" rel="noopener"><?php echo esc_html( hp_t( 'Unduh PDF', 'Download PDF' ) ); ?></a>
					</div>
				</div>
			</div>
		</div>
	</section>

</main>

<?php get_footer(); ?>
