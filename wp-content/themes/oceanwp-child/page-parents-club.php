<?php
/**
 * Template Name: Parents Club (Custom)
 *
 * Parents Club page, hand-written (not Elementor, see CLAUDE.md) in the same
 * format as the About Us page: hero, a tinted band (why involvement matters on
 * the left, benefits checklist on the right), then the Fathers / Mothers club
 * cards and the Pribadi Magazine section. Styles: assets/css/about-us.css on
 * top of prestasi.css.
 *
 * The WP page (slug: parents-club) only needs this template selected; its post
 * content is never rendered. Copy is from the former Elementor page; the
 * Indonesian versions are hand-written.
 *
 * @package OceanWP_Child
 */

$pc_up = 'https://pribadidepok.sch.id/wp-content/uploads/';

$pc_benefits = array(
	array( 'Nilai dan hasil ujian yang lebih baik.', 'Earn better grades and higher test scores.' ),
	array( 'Lulus dan melanjutkan ke pendidikan yang lebih tinggi.', 'Graduate and pursue further education.' ),
	array( 'Kemampuan literasi yang lebih kuat.', 'Have stronger literacy skills.' ),
	array( 'Keterampilan sosial yang lebih baik.', 'Have better social skills.' ),
);

$pc_clubs = array(
	array(
		'heading'    => '<span class="pr-heading-accent">Fathers</span> Club',
		'heading_en' => '<span class="pr-heading-accent">Fathers</span> Club',
		'text'       => 'Grup Parents Club Pribadi School Depok menjadi forum untuk berbagi informasi dan bertanya seputar sekolah serta kegiatan orang tua. Kegiatan Fathers Club antara lain:',
		'text_en'    => 'The Parents\' Club group is a forum to share information and ask questions about the school and parent activities. Fathers Club activities include:',
		'photo'      => '2022/10/Screenshot-2022-10-07-at-08-21-16-Fathers-Google-Drive.png',
		'alt'        => 'Anggota Fathers Club bermain tenis meja dan bulu tangkis',
		'alt_en'     => 'Fathers Club members with table tennis and badminton rackets',
		'items'      => array(
			array( 'Tahsin Club', 'Tahsin Club' ),
			array( 'Badminton Club', 'Badminton Club' ),
			array( 'Jogging Club', 'Jogging Club' ),
			array( 'Cycling Club', 'Cycling Club' ),
			array( 'Table Tennis Club', 'Table Tennis Club' ),
			array( 'Futsal Club', 'Futsal Club' ),
			array( 'Tea Time/Sharing Club', 'Tea Time/Sharing Club' ),
		),
	),
	array(
		'heading'    => '<span class="pr-heading-accent">Mothers</span> Club',
		'heading_en' => '<span class="pr-heading-accent">Mothers</span> Club',
		'text'       => 'Para ibu juga memiliki wadah untuk saling berbagi dan mempererat pertemanan. Kegiatan Mothers Club antara lain:',
		'text_en'    => 'Mothers have their own space to share and build friendships. Mothers Club activities include:',
		'photo'      => '2022/10/Screenshot-2022-10-07-at-09-19-20-Moms-Club-Google-Drive1.png',
		'alt'        => 'Anggota Mothers Club berkumpul di kantin sekolah',
		'alt_en'     => 'Mothers Club members gathered in the school canteen',
		'items'      => array(
			array( 'Tahsin Club', 'Tahsin Club' ),
			array( 'Klub Bahasa Asing', 'Foreign Languages Club' ),
			array( 'Fun Cooking Club', 'Fun Cooking Club' ),
			array( 'Art & Craft Club', 'Art & Craft Club' ),
			array( 'Yoga Club', 'Yoga Club' ),
			array( 'Tea Time/Parenting Club', 'Tea Time/Parenting Club' ),
		),
	),
);

get_header();
?>

<main id="story-page" class="au-page">

	<!-- Hero -->
	<section class="pr-section au-hero">
		<div class="pr-container">
			<div class="au-hero-grid">
				<div class="au-hero-copy">
					<p class="au-eyebrow hp-reveal">PRIBADI SCHOOL DEPOK</p>
					<h1 class="au-title hp-reveal" style="animation-delay: 80ms;"><?php echo hp_t(
						'Parents <span class="pr-heading-accent">Club</span>',
						'Parents <span class="pr-heading-accent">Club</span>'
					); ?></h1>
					<p class="au-lede hp-reveal" style="animation-delay: 160ms;"><?php echo hp_t(
						'Penelitian selama puluhan tahun menunjukkan bahwa ketika orang tua terlibat di sekolah, anak-anak mereka cenderung lebih berhasil. Parents Club adalah wadah bagi orang tua Pribadi School Depok untuk saling terhubung dan mendukung sekolah.',
						'Research over decades has shown that when parents are involved at school, their children are more likely to succeed. The Parents Club is where Pribadi School Depok parents connect with one another and support the school.'
					); ?></p>
					<a class="au-btn hp-reveal" style="animation-delay: 240ms;" href="#manfaat"><?php echo esc_html( hp_t( 'Jelajahi', 'Explore' ) ); ?></a>
				</div>
				<figure class="au-hero-art au-hero-art--photo au-hero-art--poster hp-reveal hp-reveal--up">
					<img src="<?php echo esc_url( $pc_up . '2022/10/Parents-Club-Poster-min.png' ); ?>" alt="<?php echo esc_attr( hp_t( 'Poster Parents Club Pribadi School Depok', 'Pribadi School Depok Parents Club poster' ) ); ?>" fetchpriority="high">
				</figure>
			</div>
		</div>
	</section>

	<!-- Tinted band: why involvement matters (left), benefits checklist (right) -->
	<section class="au-vm" id="manfaat">
		<div class="pr-container">
			<div class="au-vm-grid">
				<div class="au-vision hp-reveal">
					<h2 class="au-vm-title"><?php echo hp_t( 'Mengapa <span class="pr-heading-accent">Terlibat</span>', 'Why <span class="pr-heading-accent">Get Involved</span>' ); ?></h2>
					<p class="au-vision-text"><?php echo esc_html( hp_t(
						'Sekadar membuat anak tahu bahwa orang tuanya peduli dan ikut terlibat dalam keseharian sekolahnya sudah menyampaikan pesan kuat tentang nilai pendidikan. Orang tua yang terlibat juga lebih mudah mendapat informasi tentang peluang bagi siswa, sehingga dapat menjadi pendukung yang lebih kuat bagi anak.',
						'Simply letting a child know you care, and are invested enough to be involved in their day-to-day school, sends a clear message about the value of education. Involved parents also have better access to information about opportunities for students, so they can be stronger advocates for their children.'
					) ); ?></p>
				</div>

				<div class="au-mission hp-reveal" style="animation-delay: 120ms;">
					<h2 class="au-vm-title"><?php echo hp_t( 'Anak Cenderung <span class="pr-heading-accent">Lebih Baik</span>', 'Children Are More <span class="pr-heading-accent">Likely To</span>' ); ?></h2>
					<ul class="au-checklist">
						<?php foreach ( $pc_benefits as $pc_item ) : ?>
							<li>
								<span class="au-check" aria-hidden="true"><i class="fas fa-check"></i></span>
								<span><?php echo esc_html( hp_t( $pc_item[0], $pc_item[1] ) ); ?></span>
							</li>
						<?php endforeach; ?>
					</ul>
				</div>
			</div>
		</div>
	</section>

	<!-- Community -->
	<section class="pr-section au-section">
		<div class="pr-container">
			<div class="au-head hp-reveal">
				<h2><?php echo hp_t( '<span class="pr-heading-accent">Komunitas</span> Orang Tua', 'Our <span class="pr-heading-accent">Community</span>' ); ?></h2>
				<p><?php echo esc_html( hp_t(
					'Parents Club tidak hanya bermanfaat bagi siswa, tetapi juga memperkaya kesejahteraan seluruh komunitas sekolah. Orang tua yang ikut serta memahami langsung informasi umum sekolah, memanfaatkan dan mengembangkan keahlian yang ada, menjalin pertemanan, serta bekerja sama dengan orang tua lain yang peduli pada sekolah dan anak-anak.',
					'A parents\' club benefits not only students but the whole school community through positive interaction and support. Parents who take part gain a first-hand understanding of the school, use and build on their existing skills, make friends and work together with other parents who care about the school and its children.'
				) ); ?></p>
			</div>
		</div>
	</section>

	<!-- Both clubs side by side: one card each, photo on top, then intro and activity list -->
	<section class="pr-section au-section au-section--tint">
		<div class="pr-container">
			<div class="au-head hp-reveal">
				<h2><?php echo hp_t( '<span class="pr-heading-accent">Klub</span> Kami', 'Our <span class="pr-heading-accent">Clubs</span>' ); ?></h2>
			</div>
			<div class="au-curricula">
				<?php foreach ( $pc_clubs as $pc_club ) : ?>
					<article class="au-curriculum au-club hp-reveal">
						<figure class="au-club-photo">
							<img src="<?php echo esc_url( $pc_up . $pc_club['photo'] ); ?>" alt="<?php echo esc_attr( hp_t( $pc_club['alt'], $pc_club['alt_en'] ) ); ?>" width="961" height="641" loading="lazy">
						</figure>
						<h3><?php echo hp_t( $pc_club['heading'], $pc_club['heading_en'] ); ?></h3>
						<p><?php echo esc_html( hp_t( $pc_club['text'], $pc_club['text_en'] ) ); ?></p>
						<ul class="au-arrowlist">
							<?php foreach ( $pc_club['items'] as $pc_item ) : ?>
								<li><?php echo esc_html( hp_t( $pc_item[0], $pc_item[1] ) ); ?></li>
							<?php endforeach; ?>
						</ul>
					</article>
				<?php endforeach; ?>
			</div>
		</div>
	</section>

	<?php get_template_part( 'template-parts/magazine' ); ?>

</main>

<?php get_footer(); ?>
