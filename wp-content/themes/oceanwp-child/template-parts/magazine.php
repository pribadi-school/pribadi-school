<?php
/**
 * "Pribadi Magazine INSPIRE" section: heading, intro and the issue covers,
 * each with its own download button.
 *
 * Shared by the homepage (page-homepage-custom.php) and the story pages
 * (template-parts/story-page.php: Prestasi, Digital Classroom) so they
 * always match - add a new issue here once and it appears everywhere.
 * Styles: assets/css/magazine.css, enqueued for all of them in
 * functions.php.
 *
 * @package OceanWP_Child
 */

$hp_magazine_issues = array(
	array(
		'read'     => 'https://heyzine.com/flip-book/679f8cf2ce.html',
		'download' => 'https://drive.google.com/file/d/1mqHglr9u5mccZ6WNLoSHHhTSiSn3_WuJ/view?usp=sharing',
		'cover'    => 'https://pribadidepok.sch.id/wp-content/uploads/2025/01/Inspire-Pribadi-Magazine.png',
		'number'   => 1,
	),
	array(
		'read'     => 'https://heyzine.com/flip-book/abfbd761f0.html',
		'download' => 'https://drive.google.com/file/d/1SreW7ERCFK6r9OovgD90wmb2F20t54qq/view?usp=sharing',
		'cover'    => 'https://pribadidepok.sch.id/wp-content/uploads/2025/01/Inspire-Pribadi-Magazine-Edisi-2-20242025.png',
		'number'   => 2,
	),
	array(
		'read'     => 'https://heyzine.com/flip-book/7346a6ab6a.html',
		'download' => 'https://drive.google.com/file/d/1mzMAHMVhHEUqQSm6NkdAXzxEea3JSk0D/view?usp=drive_link',
		'cover'    => 'https://pribadidepok.sch.id/wp-content/uploads/2025/08/Inspire-Pribadi-Magazine-Edisi-3-20242025.png',
		'number'   => 3,
	),
);
?>

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
			<?php foreach ( $hp_magazine_issues as $hp_issue_index => $hp_issue ) : ?>
				<article class="hp-magazine-item hp-reveal"<?php echo $hp_issue_index ? ' style="animation-delay: ' . (int) ( $hp_issue_index * 80 ) . 'ms;"' : ''; ?>>
					<a class="hp-magazine-cover" href="<?php echo esc_url( $hp_issue['read'] ); ?>" target="_blank" rel="noopener">
						<img src="<?php echo esc_url( $hp_issue['cover'] ); ?>" alt="<?php echo esc_attr( 'Pribadi Magazine Inspire Edisi ' . $hp_issue['number'] ); ?>" loading="lazy">
					</a>
					<a class="hp-btn hp-magazine-download" href="<?php echo esc_url( $hp_issue['download'] ); ?>" target="_blank" rel="noopener"><?php echo esc_html( hp_t( 'Unduh Edisi ' . $hp_issue['number'], 'Download Issue ' . $hp_issue['number'] ) ); ?></a>
				</article>
			<?php endforeach; ?>
		</div>
	</div>
</section>
