<?php
/**
 * Template Name: Career Planning (Custom)
 *
 * Career Planning program page. Layout modelled on the hero of
 * rushd.sch.id: heading, a short write-up and pill buttons on the left, a
 * photo collage on the right; picking a pill swaps the write-up and the
 * photos (assets/js/career-planning.js). Rendered in this site's own design
 * system, on the shared story-page chrome (tokens, container, magazine).
 *
 * Hand-written, not Elementor, for the reason in CLAUDE.md: content lives in
 * theme files so an editor "Update" can't overwrite it. The WP page only
 * needs to exist with this template selected (slug: career_planning, under
 * the Programs parent) - its post content is never rendered.
 *
 * Topics: edit $cp_topics below. Per topic: label, text (each with an _en
 * twin) and 4 photos - the first is the large one. Photos are the school's
 * existing uploads on the live site.
 *
 * @package OceanWP_Child
 */

$cp_up = 'https://pribadidepok.sch.id/wp-content/uploads/';

$cp_topics = array(
	'personality' => array(
		'label'    => 'Tes Kepribadian',
		'label_en' => 'Personality Test',
		'text'     => 'Mengenal siswa lebih dekat lewat tes kepribadian untuk mengetahui bakat dan gaya belajar mereka.',
		'text_en'  => 'Getting to know the students by giving them a personality test to find out their talents and learning styles.',
		'photos'   => array( '2024/07/IMG_6453-scaled.jpg', '2023/03/nguyen-dang-hoang-nhu-cbEvoHbJnIE-unsplash1.jpg', '2024/02/IMG_4187-scaled.jpg', '2024/07/IMG_7681-scaled.jpg' ),
	),
	'portfolio'   => array(
		'label'    => 'Portofolio',
		'label_en' => 'Portfolios',
		'text'     => 'Membantu siswa menyusun portofolio pribadi untuk mempersiapkan tujuan pendidikan mereka.',
		'text_en'  => 'Helping the students build up their personal portfolios to prepare for their educational goals.',
		'photos'   => array( '2024/07/IMG_7681-scaled.jpg', '2024/07/IMG_6453-scaled.jpg', '2023/03/nguyen-dang-hoang-nhu-cbEvoHbJnIE-unsplash1.jpg', '2024/02/IMG_4187-scaled.jpg' ),
	),
	'seminar'     => array(
		'label'    => 'Seminar & Workshop',
		'label_en' => 'Seminars & Workshops',
		'text'     => 'Seminar dan workshop memberi siswa pengetahuan dan wawasan baru untuk karier mereka di masa depan.',
		'text_en'  => 'Seminars and workshops give the students new knowledge and insights for their future careers.',
		'photos'   => array( '2023/03/IMG_9325-scaled.jpg', '2023/02/Career-Planning-Talk-2.png', '2024/02/IMG_4187-scaled.jpg', '2023/03/IMG_9102-scaled.jpg' ),
	),
	'expo'        => array(
		'label'    => 'Edu Expo',
		'label_en' => 'Edu Expo',
		'text'     => 'Bertemu langsung dengan perwakilan universitas membantu siswa dalam proses pendaftaran kuliah. Edu Expo diadakan rutin setiap semester.',
		'text_en'  => 'Meeting university representatives in person helps the students through the admission process. The Edu Expo is held every semester.',
		'photos'   => array( '2023/03/IMG_9102-scaled.jpg', '2023/02/IMG_4087-1-scaled.jpg', '2023/03/IMG_9325-scaled.jpg', '2023/02/Career-Planning-Talk-2.png' ),
	),
	'one-on-one'  => array(
		'label'    => 'Konsultasi 1 on 1',
		'label_en' => '1 on 1',
		'text'     => 'Sesi konsultasi pribadi membantu siswa merencanakan tujuan pendidikan mereka.',
		'text_en'  => 'A personal consultation session helps the students plan their educational goals.',
		'photos'   => array( '2024/02/IMG_4187-scaled.jpg', '2024/07/IMG_6453-scaled.jpg', '2023/03/nguyen-dang-hoang-nhu-cbEvoHbJnIE-unsplash1.jpg', '2024/07/IMG_7681-scaled.jpg' ),
	),
);

get_header();
?>

<main id="story-page" class="cp-page">

	<section class="pr-section cp-hero">
		<div class="pr-container">
			<div class="cp-hero-grid" data-cp>
				<div class="cp-hero-copy">
					<h1 class="cp-title hp-reveal"><?php echo hp_t(
						'Membimbing Siswa <span class="pr-heading-accent">Menemukan</span> Arah Masa Depan',
						'Guiding Students to <span class="pr-heading-accent">Find</span> Their Path'
					); ?></h1>
					<p class="cp-lede hp-reveal" style="animation-delay: 80ms;"><?php echo esc_html( hp_t(
						'Career Planning membantu siswa menemukan, memilih, menetapkan, dan meraih tujuan pendidikan mereka lewat berbagai program, seminar, dan workshop.',
						'Career Planning guides the students to find, choose, set and reach their educational goals by means of various programs, seminars and workshops.'
					) ); ?></p>

					<?php // One write-up per topic; with JS only the active one shows, without it only the first does. ?>
					<div class="cp-texts">
						<?php $cp_first = true; ?>
						<?php foreach ( $cp_topics as $cp_key => $cp_topic ) : ?>
							<p class="cp-text" data-cp-text="<?php echo esc_attr( $cp_key ); ?>"<?php echo $cp_first ? '' : ' hidden'; ?>><?php echo esc_html( hp_t( $cp_topic['text'], $cp_topic['text_en'] ) ); ?></p>
							<?php $cp_first = false; ?>
						<?php endforeach; ?>
					</div>

					<div class="cp-pills" role="toolbar" aria-label="<?php echo esc_attr( hp_t( 'Pilih program', 'Choose a program' ) ); ?>" data-cp-pills hidden>
						<?php $cp_first = true; ?>
						<?php foreach ( $cp_topics as $cp_key => $cp_topic ) : ?>
							<button type="button" class="cp-pill<?php echo $cp_first ? ' is-active' : ''; ?>" data-cp-pill="<?php echo esc_attr( $cp_key ); ?>" aria-pressed="<?php echo $cp_first ? 'true' : 'false'; ?>"><?php echo esc_html( hp_t( $cp_topic['label'], $cp_topic['label_en'] ) ); ?></button>
							<?php $cp_first = false; ?>
						<?php endforeach; ?>
					</div>
				</div>

				<div class="cp-collage">
					<?php $cp_first = true; ?>
					<?php foreach ( $cp_topics as $cp_key => $cp_topic ) : ?>
						<div class="cp-photos" data-cp-photos="<?php echo esc_attr( $cp_key ); ?>"<?php echo $cp_first ? '' : ' hidden'; ?>>
							<?php foreach ( array_slice( $cp_topic['photos'], 0, 4 ) as $cp_i => $cp_photo ) : ?>
								<figure class="cp-photo cp-photo--<?php echo (int) $cp_i; ?>">
									<img
										src="<?php echo esc_url( $cp_up . $cp_photo ); ?>"
										alt="<?php echo esc_attr( hp_t( $cp_topic['label'], $cp_topic['label_en'] ) ); ?>"
										loading="<?php echo $cp_first ? 'eager' : 'lazy'; ?>"
									>
								</figure>
							<?php endforeach; ?>
						</div>
						<?php $cp_first = false; ?>
					<?php endforeach; ?>
				</div>
			</div>
		</div>
	</section>

	<?php get_template_part( 'template-parts/magazine' ); ?>

</main>

<?php get_footer(); ?>
