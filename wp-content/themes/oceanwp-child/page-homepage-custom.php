<?php
/**
 * Template Name: Homepage (Custom)
 *
 * Static, hand-built replacement for the Elementor-authored homepage.
 * Content mirrors what was in Elementor's _elementor_data for this page
 * as of 2026-09-04. Header and footer keep coming from the Elementor
 * Theme Builder site-wide locations (unaffected by this template) plus
 * the transparent-to-solid header CSS/JS already wired up in
 * functions.php for is_front_page().
 *
 * @package OceanWP_Child
 */

get_header();
?>

<main id="homepage-custom">

	<!-- Hero: full-bleed looping video background under the transparent header -->
	<section class="hp-hero hero-video">
		<video autoplay muted loop playsinline
			poster="<?php echo esc_url( 'http://sekolahpribadi.local/wp-content/uploads/2026/09/Untitled-design-1-scaled.png' ); ?>">
			<source src="<?php echo esc_url( get_stylesheet_directory_uri() . '/assets/video/shortprofiles.mp4' ); ?>" type="video/mp4">
		</video>
		<div class="hp-hero-overlay"></div>
		<div class="hp-hero-content">
			<p class="hp-hero-eyebrow"><?php echo hp_t( 'Selamat Datang di Sekolah Pribadi Depok', 'Welcome to Pribadi School Depok' ); ?></p>
			<?php /* Not run through hp_t() - kept as the original English wording in both languages, per explicit direction not to translate this line. */ ?>
			<h1 class="hp-hero-headline">We Don&#8217;t Just <em>Teach</em>, We <em>Inspire!</em></h1>
		</div>
	</section>

	<?php
	/*
	 * The hero is position:sticky, so it never scrolls out of view and can't
	 * be used to trigger the header's transparent -> solid swap. This 1px
	 * marker sits at the hero's bottom edge in normal flow and scrolls
	 * normally, giving assets/js/transparent-header.js the same trigger
	 * point it had before. Needs real height: zero-area targets are
	 * unreliable with IntersectionObserver.
	 */
	?>
	<div class="hp-hero-sentinel" aria-hidden="true"></div>

	<?php
	/*
	 * Everything below the hero rides on one opaque sheet that scrolls up
	 * over the pinned video. Wrapping instead of styling each section keeps
	 * the stacking context and the opaque background in a single place -
	 * any section left transparent would show the video through it.
	 */
	?>
	<div class="hp-below-hero">

	<!-- Intro / mission quote -->
	<section class="hp-section hp-intro">
		<div class="hp-container">
			<div class="hp-intro-statement">
				<span class="hp-quote-icon hp-reveal"><i class="fas fa-quote-left" aria-hidden="true"></i></span>
				<p class="hp-intro-text hp-reveal" style="animation-delay: 80ms;"><?php echo hp_t(
					'Sekolah Pribadi Depok berkomitmen mewujudkan <strong class="hp-mark">generasi emas</strong> yang <strong>berakhlak mulia, cerdas, dan berwawasan global</strong>. Guru-guru kami tak sekadar mengajar, tapi menginspirasi setiap siswa menjadi versi terbaik dari diri mereka.',
					'Sekolah Pribadi Depok is committed to shaping a <strong class="hp-mark">golden generation</strong> &mdash; <strong>principled, sharp-minded, and globally aware</strong>. Our teachers don&#8217;t just teach; they inspire every student to become the best version of themselves.'
				); ?></p>
				<span class="hp-intro-rule hp-reveal" style="animation-delay: 160ms;" aria-hidden="true"></span>
			</div>
		</div>
	</section>

	<!-- Headline news carousel -->
	<?php get_template_part( 'template-parts/hot-news' ); ?>

	<!-- Program cards -->
	<section class="hp-section hp-cards-section">
		<div class="hp-container">

			<div class="hp-section-head hp-reveal">
				<h2><?php echo hp_t( 'Tiga Pilar <span class="hp-heading-accent">Pendidikan</span> Kami', 'Our Three Pillars of <span class="hp-heading-accent">Education</span>' ); ?></h2>
				<p><?php echo hp_t(
					'Memadukan teknologi pembelajaran, perencanaan masa depan, dan pembentukan karakter &mdash; agar setiap siswa tumbuh utuh, tidak sekadar unggul secara akademik.',
					'Bringing together learning technology, future planning, and character development &mdash; so every student grows as a whole person, not just an academic achiever.'
				); ?></p>
			</div>

			<div class="hp-cards">

				<article class="hp-card hp-reveal">
					<div class="hp-card-media">
						<img src="https://pribadidepok.sch.id/wp-content/uploads/2023/10/Digital-Classroom-6-1.jpg" alt="Digital Classroom">
					</div>
					<div class="hp-card-body">
						<h3>Digital Classroom</h3>
						<p><?php echo hp_t(
							'Suatu sistem pembelajaran berbasis penggunaan media digital. Para siswa dibekali dengan sebuah perangkat <em>Chromebook</em> yang menggantikan fungsi buku-buku pelajarannya.',
							'A learning system built around digital media, where every student is equipped with a <em>Chromebook</em> that takes the place of traditional textbooks.'
						); ?></p>
						<a class="hp-btn" href="https://pribadidepok.sch.id/digital-classroom/"><?php echo hp_t( 'Lebih lanjut', 'Learn more' ); ?> &raquo;</a>
					</div>
				</article>

				<article class="hp-card hp-reveal" style="animation-delay: 80ms;">
					<div class="hp-card-media">
						<img src="https://pribadidepok.sch.id/wp-content/uploads/2025/09/16.jpg" alt="Career Planning">
					</div>
					<div class="hp-card-body">
						<h3>Career Planning</h3>
						<p><?php echo hp_t(
							'Program pembimbingan siswa untuk menemukan, memilih, menetapkan dan mencapai tujuan pendidikan mereka melalui berbagai program, seminar dan lokakarya.',
							'A guidance program that helps students discover, choose, set, and reach their education and career goals through a range of programs, seminars, and workshops.'
						); ?></p>
						<a class="hp-btn" href="/programs/career_planning"><?php echo hp_t( 'Lebih lanjut', 'Learn more' ); ?> &raquo;</a>
					</div>
				</article>

				<article class="hp-card hp-reveal" style="animation-delay: 160ms;">
					<div class="hp-card-media">
						<img src="https://pribadidepok.sch.id/wp-content/uploads/2023/10/Character-Building-2.jpg" alt="Character Building">
					</div>
					<div class="hp-card-body">
						<h3>Character Building</h3>
						<p><?php echo hp_t(
							'Pengembangan kebajikan dan nilai-nilai yang akan membimbing mereka sepanjang hidup mereka. Kebajikan dan nilai-nilai ini termasuk kejujuran, integritas, tanggung jawab, rasa hormat, dan disiplin diri.',
							'Building the virtues and values that will guide students for life &mdash; honesty, integrity, responsibility, respect, and self-discipline among them.'
						); ?></p>
						<a class="hp-btn" href="/programs/character-building/"><?php echo hp_t( 'Lebih lanjut', 'Learn more' ); ?> &raquo;</a>
					</div>
				</article>

			</div>
		</div>
	</section>

	<!-- Pribadi Berbagi / Pribadi Mengajar -->
	<section class="hp-section hp-programs-section">
		<div class="hp-container">

			<div class="hp-section-head hp-reveal">
				<h2><?php echo hp_t( 'Berbagi dan <span class="hp-heading-accent">Menginspirasi</span> Lebih Luas', 'Sharing and <span class="hp-heading-accent">Inspiring</span> Beyond the Classroom' ); ?></h2>
				<p><?php echo hp_t(
					'Dua inisiatif yang membawa semangat Pribadi Depok keluar dari ruang kelas &mdash; berbagi kebaikan dengan sesama, dan berbagi ilmu dengan komunitas.',
					'Two initiatives that carry the Pribadi Depok spirit beyond the classroom &mdash; sharing kindness with others, and sharing knowledge with the community.'
				); ?></p>
			</div>

			<div class="hp-program-row">
				<div class="hp-program-video hp-reveal">
					<iframe src="https://www.youtube.com/embed/EpzFrHNMIiw" title="Pribadi Berbagi" loading="lazy" allowfullscreen></iframe>
				</div>
				<div class="hp-program-text hp-reveal" style="animation-delay: 80ms;">
					<img class="hp-program-logo" src="https://pribadidepok.sch.id/wp-content/uploads/2023/02/Pribadi-Berbagi.png" alt="Pribadi Berbagi">
					<h3 class="screen-reader-text">Pribadi Berbagi</h3>
					<p><?php echo hp_t(
						'Pribadi Berbagi adalah semangat kebaikan dalam tindakan nyata di Sekolah Pribadi Depok. Program ini memberikan modal usaha kepada panti asuhan, bukan sekadar hadiah, tapi peluang untuk berkembang. Dana untuk program ini berasal dari orangtua siswa, partisipasi siswa melalui program market day, dan kolaborasi dengan berbagai pihak. Ini adalah bagian dari upaya komunitas sekolah kami untuk menciptakan dampak positif yang nyata dalam kehidupan yang kami dukung, membuktikan bahwa tindakan kebaikan, sekecil apapun, memiliki dampak besar dalam membangun masa depan yang lebih cerah dan bermakna.',
						'Pribadi Berbagi turns kindness into real action at Sekolah Pribadi Depok. The program provides seed funding to orphanages &mdash; not a one-off gift, but a genuine opportunity to grow. Funding comes from parents, from students themselves through market day events, and from partnerships with other organizations. It&#8217;s part of our school community&#8217;s effort to make a real, positive difference in the lives we support, proving that even a small act of kindness can have a lasting impact on a brighter, more meaningful future.'
					); ?></p>
					<a class="hp-btn" href="/post/pribadi-berbagi-santunan-yatim-dan-dhuafa-2022/"><?php echo hp_t( 'Baca selengkapnya', 'Read more' ); ?> &raquo;</a>
				</div>
			</div>

			<div class="hp-program-row">
				<div class="hp-program-video hp-reveal">
					<iframe src="https://www.youtube.com/embed/M2x96TTh1tI" title="Pribadi Mengajar" loading="lazy" allowfullscreen></iframe>
				</div>
				<div class="hp-program-text hp-reveal" style="animation-delay: 80ms;">
					<img class="hp-program-logo" src="https://pribadidepok.sch.id/wp-content/uploads/2023/02/Logo-Pribadi-Mengajar.png" alt="Pribadi Mengajar">
					<h3 class="screen-reader-text">Pribadi Mengajar</h3>
					<p><?php echo hp_t(
						'Pribadi Mengajar merupakan suatu program pengabdian masyarakat Sekolah Pribadi Depok bekerja sama dengan Dinas Pendidikan Kota Depok dan beberapa SMP Negeri di Kota Depok untuk memberi kesempatan para siswa/i di kota Depok meningkatkan kemampuan bahasa inggris dengan mendatangkan relawan penutur asing dari Australia dengan didampingi oleh siswa SMP dan SMA Pribadi Depok.',
						'Pribadi Mengajar is a community service program run by Sekolah Pribadi Depok in partnership with the Depok City Education Office and several public junior high schools in Depok. It gives local students the chance to improve their English by learning directly from visiting native-speaker volunteers from Australia, accompanied by our own SMP and SMA Pribadi Depok students.'
					); ?></p>
					<a class="hp-btn" href="/post/pribadi-mengajar-2023/"><?php echo hp_t( 'Baca selengkapnya', 'Read more' ); ?> &raquo;</a>
				</div>
			</div>

		</div>
	</section>

	<!-- Achievements showcase: count-up stats + auto-scrolling card marquee -->
	<section class="hp-section hp-achieve-showcase">
		<div class="hp-container">
			<div class="hp-section-head hp-reveal">
				<h2><?php echo hp_t( '<span class="hp-heading-accent">Prestasi</span> Terbaru Siswa Kami', 'Our Students&#8217; Latest <span class="hp-heading-accent">Achievements</span>' ); ?></h2>
				<p><?php echo hp_t(
					'Cuplikan prestasi yang baru saja diraih siswa-siswi Pribadi Depok di berbagai ajang kompetisi tingkat kota, provinsi, nasional, hingga internasional.',
					'A look at the recent wins our students have brought home from competitions at the city, provincial, national, and international level.'
				); ?></p>
			</div>
		</div>

		<?php get_template_part( 'template-parts/achievements-showcase' ); ?>
	</section>

	<!-- Alumni world map: interactive pins + university logo strip -->
	<section class="hp-section hp-alumni-map">
		<div class="hp-container">

			<div class="hp-section-head hp-reveal">
				<h2><?php echo hp_t( 'Alumni Kami <span class="hp-heading-accent">di Seluruh Dunia</span>', 'Our Alumni <span class="hp-heading-accent">Around the World</span>' ); ?></h2>
				<p><?php echo hp_t(
					'Lulusan Sekolah Pribadi Depok melanjutkan studi ke berbagai universitas terkemuka, dari Asia hingga Eropa, Amerika, dan Australia.',
					'Graduates of Sekolah Pribadi Depok go on to study at leading universities across Asia, Europe, the Americas, and Australia.'
				); ?></p>
			</div>

			<?php get_template_part( 'template-parts/alumni-map' ); ?>

		</div>
	</section>

	<!-- Pribadi Magazine -->
	<section class="hp-section hp-magazine">
		<div class="hp-container">
			<h2 class="hp-reveal">Pribadi Magazine <span class="hp-heading-accent">INSPIRE</span></h2>
			<p class="hp-reveal" style="animation-delay: 80ms;"><?php echo hp_t(
				'<strong>Jangan lewatkan edisi terbaru <em>Pribadi Magazine Inspire</em>!</strong> Temukan highlight seru dari berbagai kegiatan sekolah, berita informatif terkini, hingga deretan prestasi membanggakan siswa kami. Semua kisah inspiratif dan pencapaian luar biasa terangkum di sini, siap memberikan wawasan dan motivasi untuk Anda. Klik dan baca sekarang untuk merasakan semangat dan kebanggaan menjadi bagian dari komunitas Pribadi!',
				'<strong>Don&#8217;t miss the latest issue of <em>Pribadi Magazine Inspire</em>!</strong> Discover the highlights from our school activities, the latest news, and a lineup of achievements we&#8217;re proud of. All our inspiring stories and outstanding accomplishments are gathered here, ready to inform and motivate you. Click through and read now to feel the pride and spirit of being part of the Pribadi community!'
			); ?></p>

			<?php
			/*
			 * Cover and its download button live in the same grid cell on
			 * purpose. They used to be two separate 3-column grids that only
			 * lined up by position, which broke as soon as the grid went
			 * full-bleed (the buttons stretched to ~580px each).
			 */
			?>
			<div class="hp-magazine-grid">

				<article class="hp-magazine-item hp-reveal">
					<a class="hp-magazine-cover" href="https://heyzine.com/flip-book/679f8cf2ce.html" target="_blank" rel="noopener">
						<img src="https://pribadidepok.sch.id/wp-content/uploads/2025/01/Inspire-Pribadi-Magazine.png" alt="Pribadi Magazine Inspire Edisi 1">
					</a>
					<a class="hp-btn hp-magazine-download" href="https://drive.google.com/file/d/1mqHglr9u5mccZ6WNLoSHHhTSiSn3_WuJ/view?usp=sharing" target="_blank" rel="noopener"><?php echo hp_t( 'Unduh Edisi 1', 'Download Issue 1' ); ?></a>
				</article>

				<article class="hp-magazine-item hp-reveal" style="animation-delay: 80ms;">
					<a class="hp-magazine-cover" href="https://heyzine.com/flip-book/abfbd761f0.html" target="_blank" rel="noopener">
						<img src="https://pribadidepok.sch.id/wp-content/uploads/2025/01/Inspire-Pribadi-Magazine-Edisi-2-20242025.png" alt="Pribadi Magazine Inspire Edisi 2">
					</a>
					<a class="hp-btn hp-magazine-download" href="https://drive.google.com/file/d/1SreW7ERCFK6r9OovgD90wmb2F20t54qq/view?usp=sharing" target="_blank" rel="noopener"><?php echo hp_t( 'Unduh Edisi 2', 'Download Issue 2' ); ?></a>
				</article>

				<article class="hp-magazine-item hp-reveal" style="animation-delay: 160ms;">
					<a class="hp-magazine-cover" href="https://heyzine.com/flip-book/7346a6ab6a.html" target="_blank" rel="noopener">
						<img src="https://pribadidepok.sch.id/wp-content/uploads/2025/08/Inspire-Pribadi-Magazine-Edisi-3-20242025.png" alt="Pribadi Magazine Inspire Edisi 3">
					</a>
					<a class="hp-btn hp-magazine-download" href="https://drive.google.com/file/d/1mzMAHMVhHEUqQSm6NkdAXzxEea3JSk0D/view?usp=drive_link" target="_blank" rel="noopener"><?php echo hp_t( 'Unduh Edisi 3', 'Download Issue 3' ); ?></a>
				</article>

			</div>
		</div>
	</section>

	</div><!-- .hp-below-hero -->

</main>

<?php get_footer(); ?>
