<?php
/**
 * Shared "story page" layout: intro (badge, H1, lede, wide banner), a
 * category-filtered story carousel (one story at a time, photo left and
 * write-up right, arrow buttons to step through), and the Pribadi Magazine
 * section.
 *
 * Used by page-prestasi.php and page-digital-classroom.php, which only pick
 * a data file and pass it in as $args['data']. Styles are
 * assets/css/prestasi.css (+ magazine.css), filtering is
 * assets/js/prestasi-filter.js - both enqueued for every template listed in
 * oceanwp_child_story_page_templates() in functions.php. The file names
 * predate the layout being shared; the Prestasi page came first.
 *
 * Data shape (see template-parts/data/achievement-stories.php for a fully
 * commented example):
 *   page        icon (Font Awesome classes), title/_en (HTML allowed, for
 *               the .pr-heading-accent span), lede/_en, banner (optional;
 *               path in assets/img/ - leave it out for no banner),
 *               banner_width/_height, banner_alt/_en,
 *               banner_focus (optional CSS object-position),
 *               compact (optional, default false; true gives the text
 *               column more of the card and shortens the card, for
 *               pages whose pictures are small product shots),
 *               text_align (optional; 'justify' justifies the story
 *               paragraphs, otherwise they stay left-aligned),
 *               show_tags (optional, default true; false hides the
 *               category label above each story's title),
 *               stories_heading/_en (HTML allowed), filter_label/_en
 *   categories  key => label/_en. One filter button per category that has
 *               a story; the first is selected on load (no "All" button).
 *   stories     see the data files. A story may carry 'model' (path in
 *               assets/, a .glb) and 'model_alt'/'_en': the picture area
 *               then holds a rotatable 3D model, with 'photo' as its poster.
 *               'model_orbit' (optional) sets its starting camera angle,
 *               "<theta> <phi> <radius>" as in model-viewer's camera-orbit.
 *               'model_pause_at' (optional, seconds) plays the model's
 *               built-in animation once and holds it at that time - the
 *               Chromebook's lid opens, then stays open.
 *
 * Every string goes through hp_t() so the page follows the ID/EN switch.
 *
 * @package OceanWP_Child
 */

$sp_data       = $args['data'];
$sp_page       = $sp_data['page'];
$sp_categories = $sp_data['categories'];
$sp_stories    = $sp_data['stories'];
$sp_img_uri    = get_stylesheet_directory_uri() . '/assets/img/';
// Category labels above each story's title; on by default, 'show_tags' => false hides them.
$sp_show_tags  = ! isset( $sp_page['show_tags'] ) || $sp_page['show_tags'];

// Only offer filters that would actually show something, in the order the
// data file lists them.
$sp_used_categories = array();
foreach ( $sp_stories as $sp_story ) {
	foreach ( $sp_story['categories'] as $sp_cat ) {
		$sp_used_categories[ $sp_cat ] = true;
	}
}
$sp_filters = array_intersect_key( $sp_categories, $sp_used_categories );

/**
 * Indonesian/English pair from a data array, falling back to the
 * Indonesian value when no '_en' twin is given.
 */
$sp_t = static function ( $item, $key ) {
	if ( empty( $item[ $key ] ) ) {
		return '';
	}

	return hp_t( $item[ $key ], isset( $item[ $key . '_en' ] ) ? $item[ $key . '_en' ] : $item[ $key ] );
};
?>

<?php
$sp_main_classes = array();

if ( isset( $sp_page['text_align'] ) && 'justify' === $sp_page['text_align'] ) {
	$sp_main_classes[] = 'pr-justify';
}

if ( ! empty( $sp_page['compact'] ) ) {
	$sp_main_classes[] = 'pr-compact';
}
?>
<main id="story-page"<?php echo $sp_main_classes ? ' class="' . esc_attr( implode( ' ', $sp_main_classes ) ) . '"' : ''; ?>>

	<!-- Intro: badge, heading, lede, wide banner photo -->
	<section class="pr-section pr-intro">
		<div class="pr-container">
			<div class="pr-intro-head">
				<span class="pr-intro-badge hp-reveal" aria-hidden="true"><i class="<?php echo esc_attr( $sp_page['icon'] ); ?>"></i></span>
				<h1 class="pr-intro-title hp-reveal" style="animation-delay: 80ms;"><?php echo wp_kses( $sp_t( $sp_page, 'title' ), array( 'span' => array( 'class' => true ) ) ); ?></h1>
				<p class="pr-intro-lede hp-reveal" style="animation-delay: 160ms;"><?php echo esc_html( $sp_t( $sp_page, 'lede' ) ); ?></p>
			</div>

			<?php // The banner is optional: a page without one (Digital Classroom) just goes from the intro text to the stories. ?>
			<?php if ( ! empty( $sp_page['banner'] ) ) : ?>
				<figure class="pr-intro-banner hp-reveal hp-reveal--up">
					<img
						src="<?php echo esc_url( $sp_img_uri . $sp_page['banner'] ); ?>"
						width="<?php echo (int) $sp_page['banner_width']; ?>"
						height="<?php echo (int) $sp_page['banner_height']; ?>"
						alt="<?php echo esc_attr( $sp_t( $sp_page, 'banner_alt' ) ); ?>"
						fetchpriority="high"
						<?php if ( ! empty( $sp_page['banner_focus'] ) ) : ?>
							style="object-position: <?php echo esc_attr( $sp_page['banner_focus'] ); ?>;"
						<?php endif; ?>
					>
				</figure>
			<?php endif; ?>
		</div>
	</section>

	<!-- Stories: category filter + cards (wide photo on top, write-up below) -->
	<section class="pr-section pr-stories" id="kisah">
		<div class="pr-container">
			<div class="pr-section-head hp-reveal">
				<h2><?php echo wp_kses( $sp_t( $sp_page, 'stories_heading' ), array( 'span' => array( 'class' => true ) ) ); ?></h2>
			</div>

			<div class="pr-filters hp-reveal" role="toolbar" aria-label="<?php echo esc_attr( $sp_t( $sp_page, 'filter_label' ) ); ?>" data-pr-filters hidden>
				<?php // No "All" button, by direction (less clutter): the first category is selected on load instead. ?>
				<?php $sp_first = true; ?>
				<?php foreach ( $sp_filters as $sp_key => $sp_cat ) : ?>
					<button type="button" class="pr-filter<?php echo $sp_first ? ' is-active' : ''; ?>" data-pr-filter="<?php echo esc_attr( $sp_key ); ?>" aria-pressed="<?php echo $sp_first ? 'true' : 'false'; ?>"><?php echo esc_html( $sp_t( $sp_cat, 'label' ) ); ?></button>
					<?php $sp_first = false; ?>
				<?php endforeach; ?>
			</div>

			<p class="screen-reader-text" aria-live="polite" data-pr-status></p>

			<?php
			/*
			 * One story at a time, photo left / write-up right, stepped through
			 * with the arrow buttons at the card's sides - the rushd.sch.id
			 * achievements format. prestasi-filter.js does the stepping; without
			 * JS the arrows stay hidden and every story simply stacks.
			 */
			?>
			<div class="pr-carousel" data-pr-carousel>
			<button type="button" class="pr-nav pr-nav--prev" data-pr-nav="-1" aria-label="<?php echo esc_attr( hp_t( 'Cerita sebelumnya', 'Previous story' ) ); ?>" hidden>
				<i class="fas fa-arrow-left" aria-hidden="true"></i>
			</button>
			<button type="button" class="pr-nav pr-nav--next" data-pr-nav="1" aria-label="<?php echo esc_attr( hp_t( 'Cerita berikutnya', 'Next story' ) ); ?>" hidden>
				<i class="fas fa-arrow-right" aria-hidden="true"></i>
			</button>

			<div class="pr-story-list">
				<?php foreach ( $sp_stories as $sp_index => $sp_story ) : ?>
					<?php
					$sp_title = $sp_t( $sp_story, 'title' );
					$sp_name  = $sp_t( $sp_story, 'name' );
					$sp_date  = $sp_t( $sp_story, 'date' );
					$sp_long  = $sp_t( $sp_story, 'story' );
					$sp_link  = isset( $sp_story['link'] ) ? $sp_story['link'] : '';
					$sp_photo = $sp_img_uri . $sp_story['photo'];
					// 'plain' for cut-out product shots on a transparent background,
					// where the blurred photo fill would just smear the object.
					$sp_plain = isset( $sp_story['fill'] ) && 'plain' === $sp_story['fill'];
					?>
					<article
						class="pr-story hp-reveal"
						data-pr-categories="<?php echo esc_attr( implode( ' ', $sp_story['categories'] ) ); ?>"
					>
						<?php // --pr-photo feeds the blurred fill behind the uncropped photo (see .pr-story-media::before). ?>
						<div class="pr-story-media<?php echo $sp_plain ? ' pr-story-media--plain' : ''; ?>" style="--pr-photo: url('<?php echo esc_url( $sp_photo ); ?>');">
							<?php if ( ! empty( $sp_story['model'] ) ) : ?>
								<?php
								/*
								 * Interactive 3D model (glTF binary): drag to rotate, slow auto-spin
								 * until touched. 'photo' doubles as the poster shown while the model
								 * downloads, and as the picture where <model-viewer> can't run.
								 * touch-action pan-y keeps vertical swipes scrolling the page on
								 * phones; zoom is off so scrolling over it never gets hijacked.
								 */
								oceanwp_child_enqueue_model_viewer();
								?>
								<model-viewer
									class="pr-story-model"
									src="<?php echo esc_url( get_stylesheet_directory_uri() . '/assets/' . $sp_story['model'] ); ?>"
									poster="<?php echo esc_url( $sp_photo ); ?>"
									alt="<?php echo esc_attr( $sp_t( $sp_story, 'model_alt' ) ?: $sp_title ); ?>"
									camera-controls
									touch-action="pan-y"
									disable-zoom
									auto-rotate
									auto-rotate-delay="1500"
									rotation-per-second="7deg"
									interaction-prompt="none"
									orbit-sensitivity="0.6"
									shadow-intensity="0.7"
									shadow-softness="1"
									exposure="0.8"
									environment-image="neutral"
									camera-orbit="<?php echo esc_attr( ! empty( $sp_story['model_orbit'] ) ? $sp_story['model_orbit'] : '-28deg 84deg auto' ); ?>"
									min-polar-angle="60deg"
									max-polar-angle="95deg"
									loading="lazy"
									reveal="auto"
									<?php if ( isset( $sp_story['model_pause_at'] ) ) : ?>
										data-pause-at="<?php echo esc_attr( (float) $sp_story['model_pause_at'] ); ?>"
									<?php endif; ?>
								>
									<?php // Only ever seen if <model-viewer> never loads (no JS, offline CDN): once it upgrades, unslotted children aren't rendered. ?>
									<img src="<?php echo esc_url( $sp_photo ); ?>" alt="<?php echo esc_attr( $sp_t( $sp_story, 'model_alt' ) ?: $sp_title ); ?>">
								</model-viewer>
							<?php else : ?>
								<img
									src="<?php echo esc_url( $sp_photo ); ?>"
									alt="<?php echo esc_attr( $sp_name ? $sp_name . ' - ' . $sp_title : $sp_title ); ?>"
									loading="<?php echo $sp_index < 1 ? 'eager' : 'lazy'; ?>"
								>
							<?php endif; ?>
						</div>

						<div class="pr-story-body">
							<?php if ( $sp_show_tags ) : ?>
								<ul class="pr-story-tags">
									<?php foreach ( $sp_story['categories'] as $sp_cat ) : ?>
										<?php if ( isset( $sp_categories[ $sp_cat ] ) ) : ?>
											<li><?php echo esc_html( $sp_t( $sp_categories[ $sp_cat ], 'label' ) ); ?></li>
										<?php endif; ?>
									<?php endforeach; ?>
								</ul>
							<?php endif; ?>

							<h3 class="pr-story-title"><?php echo esc_html( $sp_title ); ?></h3>

							<?php if ( $sp_name || $sp_date ) : ?>
								<p class="pr-story-meta">
									<?php if ( $sp_name ) : ?>
										<span class="pr-story-name"><?php echo esc_html( $sp_name ); ?></span>
									<?php endif; ?>
									<?php if ( $sp_date ) : ?>
										<span class="pr-story-date"><?php echo esc_html( $sp_date ); ?></span>
									<?php endif; ?>
								</p>
							<?php endif; ?>

							<div class="pr-story-text">
								<p><?php echo esc_html( $sp_t( $sp_story, 'summary' ) ); ?></p>
								<?php if ( $sp_long ) : ?>
									<?php echo wpautop( esc_html( $sp_long ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- escaped before wpautop. ?>
								<?php endif; ?>
							</div>

							<?php if ( $sp_link ) : ?>
								<a class="pr-story-link" href="<?php echo esc_url( $sp_link ); ?>" target="_blank" rel="noopener noreferrer">
									<i class="fab fa-instagram" aria-hidden="true"></i>
									<?php echo esc_html( hp_t( 'Lihat di Instagram', 'View on Instagram' ) ); ?>
									<span class="screen-reader-text"><?php echo esc_html( hp_t( '(membuka tab baru)', '(opens in a new tab)' ) ); ?></span>
								</a>
							<?php endif; ?>
						</div>
					</article>
				<?php endforeach; ?>
			</div>
			</div><!-- .pr-carousel -->
		</div>
	</section>

	<!-- Pribadi Magazine: the same section the homepage closes with, for consistency -->
	<?php get_template_part( 'template-parts/magazine' ); ?>

</main>
