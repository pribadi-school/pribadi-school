<?php
/**
 * Template Name: School (Custom)
 *
 * Shared layout for the Elementary, Junior High and Senior High pages, in the
 * same format as About Us (page-about-us.php): hero, Vision / Mission band,
 * then content sections, then the Pribadi Magazine. Copy comes from
 * template-parts/data/schools.php, picked by the page's slug (elementary,
 * junior-high-school, senior-high-school). Styles reuse assets/css/about-us.css.
 *
 * The WP page only needs this template selected; its post content is never
 * rendered (see CLAUDE.md).
 *
 * @package OceanWP_Child
 */

$sp_up      = 'https://pribadidepok.sch.id/wp-content/uploads/';
$sp_all     = require get_stylesheet_directory() . '/template-parts/data/schools.php';
$sp_slug    = get_post_field( 'post_name', get_queried_object_id() );
$sp         = isset( $sp_all[ $sp_slug ] ) ? $sp_all[ $sp_slug ] : reset( $sp_all );
$sp_first   = ! empty( $sp['vm'] ) ? 'visi' : 'mulai';
$sp_flip    = false;

/** Pick the Indonesian or English half of an [id, en] pair. */
$sp_pair = static function ( $pair ) {
	return hp_t( $pair[0], $pair[1] );
};

get_header();
?>

<main id="story-page" class="au-page">

	<!-- Hero -->
	<section class="pr-section au-hero">
		<div class="pr-container">
			<div class="au-hero-grid">
				<div class="au-hero-copy">
					<p class="au-eyebrow hp-reveal"><?php echo esc_html( $sp_pair( $sp['eyebrow'] ) ); ?></p>
					<h1 class="au-title hp-reveal" style="animation-delay: 80ms;"><?php echo $sp_pair( $sp['title'] ); ?></h1>
					<p class="au-lede hp-reveal" style="animation-delay: 160ms;"><?php echo $sp_pair( $sp['lede'] ); ?></p>
					<a class="au-btn hp-reveal" style="animation-delay: 240ms;" href="#<?php echo esc_attr( $sp_first ); ?>"><?php echo esc_html( hp_t( 'Jelajahi', 'Explore' ) ); ?></a>
				</div>
				<figure class="au-hero-art au-hero-art--photo hp-reveal hp-reveal--up">
					<img src="<?php echo esc_url( $sp_up . $sp['hero'][0] ); ?>" alt="<?php echo esc_attr( $sp_pair( $sp['hero'][1] ) ); ?>" fetchpriority="high">
				</figure>
			</div>
		</div>
	</section>

	<?php if ( ! empty( $sp['vm'] ) ) : ?>
		<!-- Vision & Mission band -->
		<section class="au-vm" id="visi">
			<div class="pr-container">
				<div class="au-vm-grid">
					<div class="au-vision hp-reveal">
						<h2 class="au-vm-title"><?php echo hp_t( 'Visi <span class="pr-heading-accent">Kami</span>', 'Our <span class="pr-heading-accent">Vision</span>' ); ?></h2>
						<p class="au-vision-text"><?php echo esc_html( $sp_pair( $sp['vm']['vision'] ) ); ?></p>
						<figure class="au-vision-photo">
							<img src="<?php echo esc_url( $sp_up . $sp['vm']['photo'][0] ); ?>" alt="<?php echo esc_attr( $sp_pair( $sp['vm']['photo'][1] ) ); ?>" loading="lazy">
						</figure>
					</div>

					<div class="au-mission hp-reveal" style="animation-delay: 120ms;">
						<h2 class="au-vm-title"><?php echo hp_t( 'Misi <span class="pr-heading-accent">Kami</span>', 'Our <span class="pr-heading-accent">Mission</span>' ); ?></h2>
						<ul class="au-checklist">
							<?php foreach ( $sp['vm']['mission'] as $sp_item ) : ?>
								<li>
									<span class="au-check" aria-hidden="true"><i class="fas fa-check"></i></span>
									<span><?php echo esc_html( $sp_pair( $sp_item ) ); ?></span>
								</li>
							<?php endforeach; ?>
						</ul>
					</div>
				</div>
			</div>
		</section>
	<?php endif; ?>

	<?php foreach ( $sp['sections'] as $sp_i => $sp_s ) : ?>
		<?php
		$sp_id   = ( 0 === $sp_i && empty( $sp['vm'] ) ) ? ' id="mulai"' : '';
		$sp_tint = ! empty( $sp_s['tint'] ) ? ' au-section--tint' : '';
		?>

		<?php if ( 'cta' === $sp_s['type'] ) : ?>
			<section class="pr-section au-section"<?php echo $sp_id; ?>>
				<div class="pr-container">
					<div class="au-career au-career--text hp-reveal">
						<div class="au-career-copy">
							<h2><?php echo $sp_pair( $sp_s['heading'] ); ?></h2>
							<p><?php echo esc_html( $sp_pair( $sp_s['text'] ) ); ?></p>
							<a class="au-btn au-btn--light" href="<?php echo esc_url( $sp_s['button'][1] ); ?>" target="_blank" rel="noopener"><?php echo esc_html( $sp_pair( $sp_s['button'][0] ) ); ?></a>
						</div>
					</div>
				</div>
			</section>

		<?php else : ?>
			<section class="pr-section au-section<?php echo esc_attr( $sp_tint ); ?>"<?php echo $sp_id; ?>>
				<div class="pr-container">
					<div class="au-head hp-reveal">
						<h2><?php echo $sp_pair( $sp_s['heading'] ); ?></h2>
						<?php if ( ! empty( $sp_s['lede'] ) ) : ?>
							<p><?php echo esc_html( $sp_pair( $sp_s['lede'] ) ); ?></p>
						<?php endif; ?>
					</div>

					<?php if ( 'cards' === $sp_s['type'] ) : ?>
						<div class="au-curricula au-curricula--<?php echo (int) $sp_s['cols']; ?>">
							<?php foreach ( $sp_s['items'] as $sp_c ) : ?>
								<article class="au-curriculum hp-reveal">
									<h3><?php echo esc_html( $sp_pair( array( $sp_c[0], $sp_c[1] ) ) ); ?></h3>
									<p><?php echo esc_html( $sp_pair( array( $sp_c[2], $sp_c[3] ) ) ); ?></p>
									<?php if ( ! empty( $sp_c[4] ) ) : ?>
										<p class="au-levels"><a href="<?php echo esc_url( home_url( $sp_c[4] ) ); ?>"><?php echo esc_html( hp_t( 'Pelajari lebih lanjut', 'Learn more' ) ); ?> &rarr;</a></p>
									<?php endif; ?>
								</article>
							<?php endforeach; ?>
						</div>

					<?php elseif ( 'tiles' === $sp_s['type'] ) : ?>
						<div class="au-tiles">
							<?php foreach ( $sp_s['items'] as $sp_t ) : ?>
								<div class="au-tile hp-reveal"><?php echo esc_html( $sp_t ); ?></div>
							<?php endforeach; ?>
						</div>
						<div class="au-head au-head--after hp-reveal">
							<?php foreach ( $sp_s['paras'] as $sp_para ) : ?>
								<p><?php echo esc_html( $sp_pair( $sp_para ) ); ?></p>
							<?php endforeach; ?>
						</div>

					<?php else : // feature ?>
						<?php $sp_flip = ! $sp_flip; ?>
						<div class="au-feature<?php echo $sp_flip ? '' : ' au-feature--flip'; ?> hp-reveal">
							<div class="au-feature-copy">
								<h3><?php echo esc_html( $sp_pair( $sp_s['title'] ) ); ?></h3>
								<?php foreach ( $sp_s['paras'] as $sp_para ) : ?>
									<p><?php echo esc_html( $sp_pair( $sp_para ) ); ?></p>
								<?php endforeach; ?>
								<?php if ( ! empty( $sp_s['list'] ) ) : ?>
									<ul class="au-bullets">
										<?php foreach ( $sp_s['list'] as $sp_li ) : ?>
											<li><?php echo esc_html( $sp_pair( $sp_li ) ); ?></li>
										<?php endforeach; ?>
									</ul>
								<?php endif; ?>
								<?php if ( ! empty( $sp_s['button'] ) ) : ?>
									<a class="au-btn" href="<?php echo esc_url( home_url( $sp_s['button'][1] ) ); ?>"><?php echo esc_html( $sp_pair( $sp_s['button'][0] ) ); ?></a>
								<?php endif; ?>
							</div>
							<figure class="au-feature-photo<?php echo ! empty( $sp_s['contain'] ) ? ' au-feature-photo--contain' : ''; ?>">
								<img src="<?php echo esc_url( $sp_up . $sp_s['photo'][0] ); ?>" alt="<?php echo esc_attr( $sp_pair( $sp_s['photo'][1] ) ); ?>" loading="lazy">
							</figure>
						</div>
					<?php endif; ?>
				</div>
			</section>
		<?php endif; ?>
	<?php endforeach; ?>

	<?php get_template_part( 'template-parts/magazine' ); ?>

</main>

<?php get_footer(); ?>
