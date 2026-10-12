<?php
/**
 * Template Name: Character Building (Custom)
 *
 * Character Building program page: a two-column grid of tinted cards, each
 * with a label, title, short text and a photo, alternating text-first and
 * photo-first - the card layout of rushd.sch.id's "Inspiring Minds" section,
 * in this site's design system (shared story-page chrome: tokens, container,
 * magazine; see assets/css/character-building.css), under a small heading
 * and one line of text.
 *
 * Hand-written, not Elementor, for the reason in CLAUDE.md. The WP page only
 * needs to exist with this template selected (slug: character-building,
 * under the Programs parent); its post content is never rendered. Edit the
 * cards in $cb_cards below. Photos are the school's existing uploads.
 *
 * @package OceanWP_Child
 */

$cb_up = 'https://pribadidepok.sch.id/wp-content/uploads/2022/09/';

$cb_cards = array(
	array(
		'photo'    => 'Paskib-1.jpg',
		'tag'      => 'Fondasi',
		'tag_en'   => 'The Foundation',
		'title'    => 'Pendidikan Karakter di Kelas',
		'title_en' => 'Character Education in the Classroom',
		'text'     => 'Pembangunan karakter adalah aspek penting dalam perkembangan pribadi dan akademik siswa. Prosesnya menumbuhkan nilai-nilai yang akan menuntun mereka seumur hidup, seperti kejujuran, integritas, tanggung jawab, rasa hormat, dan disiplin diri. Salah satu caranya adalah program pendidikan karakter di kelas, mulai dari pelajaran tentang nilai tertentu, bermain peran, hingga diskusi kelompok, sehingga siswa berlatih mengambil keputusan etis dalam berbagai situasi.',
		'text_en'  => 'Character building is an important aspect of a student\'s personal and academic development. It grows the virtues and values that guide them throughout their lives: honesty, integrity, responsibility, respect and self-discipline. One way to build it is through character education programs in the classroom, from lessons on specific virtues to role-playing and group discussions, which give students the chance to practise making ethical decisions in different situations.',
	),
	array(
		'photo'    => 'Guidance-Programs-1-min.png',
		'tag'      => 'Program Bimbingan',
		'tag_en'   => 'Guidance Program',
		'title'    => 'Diskusi Kelompok Siswa',
		'title_en' => 'Student Group Discussion',
		'text'     => 'Diskusi kelompok adalah metode belajar di mana siswa bekerja sama dalam kelompok kecil untuk membahas topik atau memecahkan masalah. Tujuannya mendorong pembelajaran aktif, berpikir kritis, dan kolaborasi antarsiswa.',
		'text_en'  => 'Student group discussion is a method of teaching and learning in which students work together in small groups to discuss a topic or solve a problem. The goal is to promote active learning, critical thinking and collaboration among students.',
	),
	array(
		'photo'    => 'Guidance-Programs-2-min.png',
		'tag'      => 'Program Bimbingan',
		'tag_en'   => 'Guidance Program',
		'title'    => 'Tatap Muka (1 on 1)',
		'title_en' => 'Face to Face (1 on 1)',
		'text'     => 'Program tatap muka memberi siswa kesempatan bertemu guru secara pribadi untuk membicarakan masalah atau kekhawatiran mereka. Komunikasi langsung ini membantu membangun kepercayaan dan saling pengertian antara siswa dan guru.',
		'text_en'  => 'The face-to-face program gives students the chance to meet their teachers one-on-one to discuss any problems or concerns. This direct communication helps build trust and understanding between student and teacher.',
	),
	array(
		'photo'    => 'Makan-Maklube-min.jpg',
		'tag'      => 'Kebersamaan',
		'tag_en'   => 'Community',
		'title'    => 'Kegiatan Sosial',
		'title_en' => 'Social Activity',
		'text'     => 'Kegiatan sosial memberi siswa kesempatan berkumpul, bersenang-senang, dan melepas penat dari belajar. Bentuknya beragam, mulai dari olahraga, permainan, seni dan kerajinan, hingga acara budaya atau kemasyarakatan.',
		'text_en'  => 'Social activities give students opportunities to come together, have fun and relieve the stress of studying. They range from sports, games, arts and crafts to cultural and community events.',
	),
	array(
		'photo'    => 'Screenshot-2022-09-17-at-10-13-43-Guidance-Programs.png',
		'tag'      => 'Program Bimbingan',
		'tag_en'   => 'Guidance Program',
		'title'    => 'Laporan Mingguan',
		'title_en' => 'Weekly Report',
		'text'     => 'Laporan mingguan merangkum prestasi, kemajuan, dan perilaku siswa selama satu minggu. Guru dan orang tua memakainya untuk memantau perkembangan akademik dan sosial siswa serta mengenali hal yang perlu diperhatikan.',
		'text_en'  => 'The weekly report summarises a student\'s performance, progress and behaviour over one week. Teachers and parents use it to follow the student\'s academic and social development and spot anything that needs attention.',
	),
	array(
		'photo'    => 'PET-1-min-e1663384992652.png',
		'tag'      => 'Belajar di Luar Kelas',
		'tag_en'   => 'Learning Beyond the Classroom',
		'title'    => 'Pribadi Educational Trip (PET)',
		'title_en' => 'Pribadi Educational Trip (PET)',
		'text'     => 'Tujuan utama kunjungan edukasi adalah melengkapi pelajaran di kelas lewat pengalaman belajar yang langsung, interaktif, dan menarik. Kegiatan ini juga mengasah berpikir kritis, pemecahan masalah, dan kesadaran budaya.',
		'text_en'  => 'The main goal of an educational trip is to complement classroom learning with a hands-on, interactive and engaging experience. These trips also develop critical thinking, problem-solving and cultural awareness.',
	),
	array(
		'photo'    => 'Parents-Home-Visit-1-e1663385088267.png',
		'tag'      => 'Bersama Orang Tua',
		'tag_en'   => 'Together with Parents',
		'title'    => 'Kunjungan ke Rumah Siswa',
		'title_en' => 'Parents Home Visit',
		'text'     => 'Kunjungan guru ke rumah siswa bertujuan mempererat hubungan antara guru dan keluarga. Guru bertemu orang tua dan mengenal lebih jauh kehidupan di rumah serta konteks belajar siswa.',
		'text_en'  => 'A teacher\'s visit to a student\'s home builds a stronger relationship between the teacher and the family. It lets the teacher meet the parents and learn more about the student\'s home life and the setting they learn in.',
	),
);

get_header();
?>

<main id="story-page" class="cb-page">

	<section class="pr-section cb-section">
		<div class="pr-container">
			<header class="cb-head hp-reveal">
				<h1 class="cb-head-title"><?php echo hp_t(
					'Membangun <span class="pr-heading-accent">Karakter</span> Siswa',
					'Building Students\' <span class="pr-heading-accent">Character</span>'
				); ?></h1>
				<p class="cb-head-sub"><?php echo esc_html( hp_t(
					'Kejujuran, integritas, tanggung jawab, rasa hormat, dan disiplin diri tumbuh lewat program bimbingan kami.',
					'Honesty, integrity, responsibility, respect and self-discipline, grown through our guidance programs.'
				) ); ?></p>
			</header>

			<div class="cb-grid">
				<?php foreach ( $cb_cards as $cb_i => $cb_card ) : ?>
					<?php $cb_title = hp_t( $cb_card['title'], $cb_card['title_en'] ); ?>
					<article class="cb-card hp-reveal">
						<div class="cb-card-text">
							<p class="cb-card-tag"><?php echo esc_html( hp_t( $cb_card['tag'], $cb_card['tag_en'] ) ); ?></p>
							<h2 class="cb-card-title"><?php echo esc_html( $cb_title ); ?></h2>
							<p class="cb-card-body"><?php echo esc_html( hp_t( $cb_card['text'], $cb_card['text_en'] ) ); ?></p>
						</div>
						<figure class="cb-card-photo">
							<img
								src="<?php echo esc_url( $cb_up . $cb_card['photo'] ); ?>"
								alt="<?php echo esc_attr( $cb_title ); ?>"
								loading="<?php echo $cb_i < 2 ? 'eager' : 'lazy'; ?>"
							>
						</figure>
					</article>
				<?php endforeach; ?>
			</div>
		</div>
	</section>

	<?php get_template_part( 'template-parts/magazine' ); ?>

</main>

<?php get_footer(); ?>
