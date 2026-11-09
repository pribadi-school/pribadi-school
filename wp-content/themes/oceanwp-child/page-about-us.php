<?php
/**
 * Template Name: About Us (Custom)
 *
 * About Us page, hand-written (not Elementor, see CLAUDE.md): hero, the
 * Vision / Mission band, principles, curricula, learning method and career
 * planning, then the Pribadi Magazine section. The Vision / Mission layout is
 * modelled on rushd.sch.id/what-is-rushd (tinted band, vision and photo on
 * the left, mission checklist on the right), in this site's design system.
 * Styles: assets/css/about-us.css on top of prestasi.css (tokens, container).
 *
 * The WP page (slug: about-us) only needs this template selected; its post
 * content is never rendered. Copy is from the former Elementor page; the
 * English versions are hand-written.
 *
 * @package OceanWP_Child
 */

$au_up = 'https://pribadidepok.sch.id/wp-content/uploads/';

$au_mission = array(
	array(
		'Meningkatkan kualitas kepribadian siswa dari sisi religi dan sosial secara seimbang.',
		'Improve students\' personal character in a balanced way, both religious and social.',
	),
	array(
		'Meningkatkan prestasi akademik pada tingkat sekolah, wilayah, nasional, dan internasional.',
		'Raise academic achievement at school, regional, national and international levels.',
	),
	array(
		'Menyiapkan siswa melanjutkan studi ke jenjang yang lebih tinggi dengan sistem pembelajaran yang berkualitas dan penerapan teknologi terkini.',
		'Prepare students for further study with a high-quality learning system and the latest technology.',
	),
	array(
		'Membekali siswa dengan berbagai keterampilan yang disesuaikan dengan minat dan bakatnya.',
		'Equip students with a range of skills matched to their interests and talents.',
	),
	array(
		'Mengembangkan sikap cinta terhadap sesama, bangsa, dan Negara Indonesia pada diri siswa.',
		'Nurture students\' love for others, for their nation and for Indonesia.',
	),
);

$au_principles = array(
	array(
		'photo'   => '2023/03/360x310-Female-Student.jpg',
		'alt'     => 'Siswa Pribadi School Depok',
		'alt_en'  => 'A Pribadi School Depok student',
		'who'     => 'Untuk Siswa Kami',
		'who_en'  => 'For Our Students',
		'text'    => 'Di Pribadi School Depok, kami percaya bahwa pendidikan tidak hanya sekedar memberikan pengetahuan, tetapi juga menginspirasi dan membimbing setiap potensi siswa untuk menjadi diri terbaik mereka.',
		'text_en' => 'At Pribadi School Depok, we believe education is more than passing on knowledge: it inspires and guides every student\'s potential to become the best version of themselves.',
	),
	array(
		'photo'   => '2023/03/360x310-Male-Teacher.jpg',
		'alt'     => 'Guru Pribadi School Depok',
		'alt_en'  => 'A Pribadi School Depok teacher',
		'who'     => 'Untuk Guru Kami',
		'who_en'  => 'For Our Teachers',
		'text'    => 'Guru-guru kami yang berpengalaman dan berdedikasi melampaui peran tradisional sebagai pengajar, tetapi juga menjadi mentor, pembimbing, dan panutan bagi siswa-siswa kami.',
		'text_en' => 'Our experienced and dedicated teachers go beyond the traditional role of instructor: they are also mentors, guides and role models to our students.',
	),
);

$au_curricula = array(
	array(
		'logo'     => '2023/03/Logo-Kurikulum-Merdeka.png',
		'title'    => 'Kurikulum Merdeka',
		'title_en' => 'Kurikulum Merdeka',
		'text'     => array(
			'Kurikulum Merdeka adalah sebuah konsep kurikulum yang diperkenalkan oleh Kementerian Pendidikan, Kebudayaan, Riset, dan Teknologi (Kemendikbudristek) Indonesia pada tahun 2020.',
			'Kurikulum ini bertujuan untuk memberikan kebebasan dan fleksibilitas bagi sekolah dalam menentukan materi pembelajaran yang sesuai dengan kondisi, potensi, dan kebutuhan siswa di daerah mereka.',
		),
		'text_en'  => array(
			'Kurikulum Merdeka is a curriculum concept introduced in 2020 by Indonesia\'s Ministry of Education, Culture, Research and Technology (Kemendikbudristek).',
			'It gives schools the freedom and flexibility to choose learning material that fits the conditions, potential and needs of the students in their area.',
		),
		'levels'    => 'Diterapkan pada jenjang SD, SMP, dan SMA.',
		'levels_en' => 'Applied at primary, junior high and senior high levels.',
	),
	array(
		'logo'     => '2022/09/Cambridge-_grey_-removebg-preview.png',
		'title'    => 'Kurikulum Cambridge',
		'title_en' => 'Cambridge Curriculum',
		'text'     => array(
			'Kurikulum Cambridge adalah kurikulum yang dikembangkan oleh Cambridge Assessment International Education, bagian dari University of Cambridge di Inggris.',
			'Kurikulum ini dirancang untuk mempersiapkan siswa untuk menjadi warga global yang sukses, dengan menekankan pada pengembangan keterampilan berpikir kritis, kreativitas, kolaborasi, dan komunikasi.',
		),
		'text_en'  => array(
			'The Cambridge curriculum is developed by Cambridge Assessment International Education, part of the University of Cambridge in the UK.',
			'It is designed to prepare students to be successful global citizens, with an emphasis on critical thinking, creativity, collaboration and communication.',
		),
		'levels'    => 'Diterapkan pada jenjang SD dan SMP.',
		'levels_en' => 'Applied at primary and junior high levels.',
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
						'Kami Tidak Hanya Mengajar, <span class="pr-heading-accent">Kami Menginspirasi</span>',
						'We Don\'t Just Teach, <span class="pr-heading-accent">We Inspire</span>'
					); ?></h1>
					<p class="au-lede hp-reveal" style="animation-delay: 160ms;"><?php echo hp_t(
						'Selamat datang di <strong>Pribadi School Depok</strong>, sekolah swasta dengan standar internasional yang terletak di pusat kota Depok, Indonesia. Sekolah kami berdedikasi untuk membentuk generasi muda yang memiliki karakter mulia, kecerdasan, wawasan global, dan budaya yang berkualitas.',
						'Welcome to <strong>Pribadi School Depok</strong>, a private school with international standards in the heart of Depok, Indonesia. We are dedicated to shaping young people of noble character, intelligence, a global outlook and strong culture.'
					); ?></p>
					<a class="au-btn hp-reveal" style="animation-delay: 240ms;" href="#visi"><?php echo esc_html( hp_t( 'Jelajahi', 'Explore' ) ); ?></a>
				</div>
			</div>
		</div>
	</section>

	<!-- Vision & Mission: tinted band, vision + photo left, mission checklist right (rushd.sch.id format) -->
	<section class="au-vm" id="visi">
		<div class="pr-container">
			<div class="au-vm-grid">
				<div class="au-vision hp-reveal">
					<h2 class="au-vm-title"><?php echo hp_t( 'Visi <span class="pr-heading-accent">Kami</span>', 'Our <span class="pr-heading-accent">Vision</span>' ); ?></h2>
					<p class="au-vision-text"><?php echo esc_html( hp_t(
						'Terwujudnya generasi yang berakhlak, berprestasi, bersaing, dan berwawasan global berlandaskan budaya Indonesia.',
						'A generation of good character, achievement and competitiveness, with a global outlook rooted in Indonesian culture.'
					) ); ?></p>
					<figure class="au-vision-photo">
						<img src="<?php echo esc_url( $au_up . '2023/02/Smart-Digital-Classroom.png' ); ?>" alt="<?php echo esc_attr( hp_t( 'Siswa belajar dengan Chromebook', 'Students learning with Chromebooks' ) ); ?>" loading="lazy">
					</figure>
				</div>

				<div class="au-mission hp-reveal" style="animation-delay: 120ms;">
					<h2 class="au-vm-title"><?php echo hp_t( 'Misi <span class="pr-heading-accent">Kami</span>', 'Our <span class="pr-heading-accent">Mission</span>' ); ?></h2>
					<ul class="au-checklist">
						<?php foreach ( $au_mission as $au_item ) : ?>
							<li>
								<span class="au-check" aria-hidden="true"><i class="fas fa-check"></i></span>
								<span><?php echo esc_html( hp_t( $au_item[0], $au_item[1] ) ); ?></span>
							</li>
						<?php endforeach; ?>
					</ul>
				</div>
			</div>
		</div>
	</section>

	<!-- Testimonial-style cards: the school's principles for its students and teachers (no personal quotes) -->
	<section class="pr-section au-section">
		<div class="pr-container">
			<div class="au-head hp-reveal">
				<h2><?php echo hp_t( 'Yang <span class="pr-heading-accent">Kami Yakini</span>', 'What We <span class="pr-heading-accent">Believe</span>' ); ?></h2>
			</div>
			<div class="au-principles">
				<?php foreach ( $au_principles as $au_p ) : ?>
					<figure class="au-testimonial hp-reveal">
						<i class="fas fa-quote-left au-quote-mark" aria-hidden="true"></i>
						<blockquote><?php echo esc_html( hp_t( $au_p['text'], $au_p['text_en'] ) ); ?></blockquote>
						<figcaption>
							<img class="au-testimonial-photo" src="<?php echo esc_url( $au_up . $au_p['photo'] ); ?>" alt="<?php echo esc_attr( hp_t( $au_p['alt'], $au_p['alt_en'] ) ); ?>" width="360" height="310" loading="lazy">
							<span class="au-testimonial-who"><?php echo esc_html( hp_t( $au_p['who'], $au_p['who_en'] ) ); ?></span>
						</figcaption>
					</figure>
				<?php endforeach; ?>
			</div>
		</div>
	</section>

	<!-- Curriculum -->
	<section class="pr-section au-section au-section--tint">
		<div class="pr-container">
			<div class="au-head hp-reveal">
				<h2><?php echo hp_t( '<span class="pr-heading-accent">Kurikulum</span>', 'Our <span class="pr-heading-accent">Curriculum</span>' ); ?></h2>
				<p><?php echo esc_html( hp_t(
					'Kami menawarkan kurikulum komprehensif mulai dari sekolah dasar hingga sekolah menengah atas yang dirancang untuk memenuhi kebutuhan setiap individu siswa.',
					'We offer a comprehensive curriculum from primary to senior high school, designed to meet the needs of each individual student.'
				) ); ?></p>
			</div>
			<div class="au-curricula">
				<?php foreach ( $au_curricula as $au_c ) : ?>
					<article class="au-curriculum hp-reveal">
						<img class="au-curriculum-logo" src="<?php echo esc_url( $au_up . $au_c['logo'] ); ?>" alt="" loading="lazy">
						<h3><?php echo esc_html( hp_t( $au_c['title'], $au_c['title_en'] ) ); ?></h3>
						<?php foreach ( $au_c['text'] as $au_i => $au_para ) : ?>
							<p><?php echo esc_html( hp_t( $au_para, $au_c['text_en'][ $au_i ] ) ); ?></p>
						<?php endforeach; ?>
						<p class="au-levels"><?php echo esc_html( hp_t( $au_c['levels'], $au_c['levels_en'] ) ); ?></p>
					</article>
				<?php endforeach; ?>
			</div>
		</div>
	</section>

	<!-- Learning method -->
	<section class="pr-section au-section">
		<div class="pr-container">
			<div class="au-head hp-reveal">
				<h2><?php echo hp_t( 'Metode <span class="pr-heading-accent">Pembelajaran</span>', 'Learning <span class="pr-heading-accent">Method</span>' ); ?></h2>
			</div>
			<div class="au-feature hp-reveal">
				<div class="au-feature-copy">
					<h3>Smart Digital Classroom</h3>
					<p><?php echo hp_t(
						'Pribadi School Depok telah mengadopsi metode pembelajaran yang modern dengan menggantikan penggunaan buku dengan Chromebook. Metode pembelajaran ini <strong>diimplementasikan pada siswa tingkat SMP dan SMA</strong>, dan telah memberikan banyak manfaat dan keuntungan.',
						'Pribadi School Depok has adopted a modern way of learning that replaces books with Chromebooks. It is <strong>used by junior and senior high students</strong> and has brought many benefits.'
					); ?></p>
					<p><?php echo hp_t(
						'<strong>Chromebook</strong> adalah perangkat laptop yang dirancang khusus untuk digunakan dalam pendidikan. Dibandingkan dengan buku teks, Chromebook memiliki keunggulan yang lebih banyak dalam hal fleksibilitas, aksesibilitas, dan interaktifitas. Siswa dapat dengan mudah mengakses materi pelajaran dan melakukan tugas-tugas melalui platform online, serta melakukan kolaborasi dengan guru dan teman sekelas.',
						'A <strong>Chromebook</strong> is a laptop designed for education. Compared with textbooks it offers more flexibility, accessibility and interactivity. Students can easily reach lesson material and complete tasks on online platforms, and collaborate with teachers and classmates.'
					); ?></p>
					<a class="au-btn" href="<?php echo esc_url( home_url( '/digital-classroom/' ) ); ?>"><?php echo esc_html( hp_t( 'Pelajari lebih lanjut', 'Learn more' ) ); ?></a>
				</div>
				<figure class="au-feature-photo">
					<img src="<?php echo esc_url( $au_up . '2023/02/Smart-Digital-Classroom.png' ); ?>" alt="<?php echo esc_attr( hp_t( 'Smart Digital Classroom', 'Smart Digital Classroom' ) ); ?>" loading="lazy">
				</figure>
			</div>
		</div>
	</section>

	<!-- Career planning -->
	<section class="pr-section au-section">
		<div class="pr-container">
			<div class="au-career hp-reveal">
				<div class="au-career-copy">
					<h2><?php echo hp_t( 'Career <span class="au-career-accent">Planning</span>', 'Career <span class="au-career-accent">Planning</span>' ); ?></h2>
					<p><?php echo esc_html( hp_t(
						'Departemen Career Planning di Pribadi School Depok memberi siswa akses ke konselor karier berkualifikasi yang membantu mereka memilih universitas yang tepat dan mendaftar beasiswa. Departemen ini terutama melayani siswa kelas akhir, namun siswa dari kelas lain juga dipersilakan berkonsultasi.',
						'The Career Planning Department at Pribadi School Depok offers students access to a qualified Career Counselor who can help them navigate the complexities of choosing the right university and applying for scholarships. The department primarily caters to senior students, but students from other grades are also welcome to consult with the Career Counselor.'
					) ); ?></p>
					<a class="au-btn au-btn--light" href="<?php echo esc_url( home_url( '/programs/career_planning/' ) ); ?>"><?php echo esc_html( hp_t( 'Pelajari lebih lanjut', 'Learn more' ) ); ?></a>
				</div>
				<img class="au-career-art" src="<?php echo esc_url( $au_up . '2023/03/Mr-Aji-Trans-Stroke.png' ); ?>" alt="<?php echo esc_attr( hp_t( 'Konselor karier Pribadi School Depok', 'Pribadi School Depok career counselor' ) ); ?>" loading="lazy">
			</div>
		</div>
	</section>

	<?php get_template_part( 'template-parts/magazine' ); ?>

</main>

<?php get_footer(); ?>
