<?php
/**
 * Alumni world map - stylised SVG map with interactive location pins.
 *
 * Pin data is real, loaded from data/alumni-map-data.json - one pin per
 * country, positioned from that file's own lat/lng. Student counts in that
 * file (totalStudents, and per-institution students) are intentionally not
 * displayed anywhere in the UI.
 *
 * How it works
 * ------------
 * The map outlines and the pins are projected from the SAME lat/lng source
 * through the hp_alumni_map_* functions below, so a pin can never drift out
 * of alignment with the coastline - the usual failure mode when a map image
 * and its markers are positioned independently.
 *
 * Projection: plate carree (equirectangular). The SVG viewBox is set up so
 * that x = longitude and y = -latitude directly, with no offset maths:
 *
 *   viewBox="-180 -84 360 140"   ->  lng -180..180, lat 84..-56
 *
 * Latitude is clipped at 84N/56S to drop Antarctica and the empty high
 * Arctic, which would otherwise waste a third of the vertical space.
 * .hp-map-canvas carries the matching 360/140 aspect-ratio so the SVG fills
 * it exactly and percentage-positioned pins line up with the drawing.
 *
 * $hp_world_shapes below is real coastline geometry, not a hand-drawn
 * approximation: it's Natural Earth's 1:110m "land" dataset (public domain -
 * "no permission needed", https://www.naturalearthdata.com), reduced to 1
 * decimal degree (~11km) precision and converted through the exact
 * projection below by a one-off build script (not included in the theme;
 * see the git history / ask if it needs regenerating from a newer Natural
 * Earth release). Antarctica is dropped for the same reason the viewBox
 * clips at 56S - it would otherwise waste a third of the vertical space on
 * a continent with no alumni pins.
 *
 * Each shape is a list of one or more rings (a landmass with a lake or
 * other enclosed low-lying area has an outer ring plus inner "hole" rings).
 * hp_alumni_map_shape_path() concatenates a shape's rings into one <path>
 * with fill-rule:evenodd, which is what makes a hole actually render as a
 * hole instead of solid land.
 *
 * @package OceanWP_Child
 */

if ( ! function_exists( 'hp_alumni_map_ring' ) ) {
	/**
	 * One ring of [ longitude, latitude ] points -> one SVG subpath.
	 *
	 * @param array $points List of [ longitude, latitude ] pairs.
	 * @return string SVG path subpath (`M ... Z `), space-terminated so
	 *                multiple rings can be concatenated directly.
	 */
	function hp_alumni_map_ring( array $points ) {
		$d = '';

		foreach ( $points as $index => $point ) {
			$d .= ( 0 === $index ? 'M' : 'L' );
			$d .= $point[0] . ' ' . ( -$point[1] ) . ' ';
		}

		return $d . 'Z ';
	}
}

if ( ! function_exists( 'hp_alumni_map_shape_path' ) ) {
	/**
	 * One shape (outer ring + optional hole rings) -> one <path> `d` value.
	 *
	 * @param array $rings List of rings; each ring a list of [ lng, lat ] pairs.
	 * @return string SVG path `d` attribute.
	 */
	function hp_alumni_map_shape_path( array $rings ) {
		$d = '';

		foreach ( $rings as $ring ) {
			$d .= hp_alumni_map_ring( $ring );
		}

		return trim( $d );
	}
}

if ( ! function_exists( 'hp_alumni_country_name' ) ) {
	/**
	 * Country display name for the current language.
	 *
	 * data/alumni-map-data.json only carries the Indonesian country name
	 * (its "country" field), so English needs a lookup rather than a second
	 * field in the data file. Institution names are never run through this -
	 * "Middle East Technical University" is a proper noun in either
	 * language, but "Turki" is not.
	 *
	 * Falls back to the Indonesian name unchanged if a country isn't in the
	 * table, so a future addition to the JSON degrades to "untranslated"
	 * rather than breaking.
	 *
	 * @param string $id_name Country name as it appears in the JSON data.
	 * @return string
	 */
	function hp_alumni_country_name( $id_name ) {
		static $names = array(
			'Turki'           => 'Turkey',
			'Australia'       => 'Australia',
			'Malaysia'        => 'Malaysia',
			'Singapura'       => 'Singapore',
			'Hong Kong'       => 'Hong Kong',
			'Jepang'          => 'Japan',
			'Jerman'          => 'Germany',
			'Kazakhstan'      => 'Kazakhstan',
			'Kanada'          => 'Canada',
			'Amerika Serikat' => 'United States',
			'Belanda'         => 'Netherlands',
			'Rumania'         => 'Romania',
			'India'           => 'India',
			'Inggris'         => 'United Kingdom',
			'Taiwan'          => 'Taiwan',
			'Rusia'           => 'Russia',
			'Korea Selatan'   => 'South Korea',
			'Prancis'         => 'France',
			'Nigeria'         => 'Nigeria',
			'Moldova'         => 'Moldova',
		);

		$en_name = isset( $names[ $id_name ] ) ? $names[ $id_name ] : $id_name;

		return hp_t( $id_name, $en_name );
	}
}

if ( ! function_exists( 'hp_alumni_map_pin_position' ) ) {
	/**
	 * Longitude/latitude -> percentage offsets for an HTML pin overlaid on
	 * the SVG. Pins are HTML rather than SVG nodes so their tooltips can be
	 * real, styleable, focusable DOM.
	 *
	 * @param float $lng Longitude.
	 * @param float $lat Latitude.
	 * @return array{left: float, top: float}
	 */
	function hp_alumni_map_pin_position( $lng, $lat ) {
		return array(
			'left' => round( ( $lng + 180 ) / 360 * 100, 3 ),
			'top'  => round( ( 84 - $lat ) / 140 * 100, 3 ),
		);
	}
}

/*
 * Real coastline geometry - see the docblock above and the header of the
 * data file itself for provenance. Defines $hp_world_shapes.
 */
require __DIR__ . '/data/alumni-map-world-shapes.php';

/*
 * Real alumni destinations, one entry per country, loaded from
 * data/alumni-map-data.json. Each entry carries country, lat, lng,
 * totalStudents and an institutions[] list of { institution, students }.
 *
 * Guarded rather than assumed: a missing or malformed data file leaves
 * $hp_alumni_countries empty and the map renders with no pins, instead of
 * fatalling the whole homepage on a json_decode() of false.
 *
 * Note on the student counts: totalStudents and institutions[].students are
 * deliberately NOT rendered anywhere. They are read here only so the shape
 * of the file is documented in one place; nothing downstream displays them.
 */
$hp_alumni_data_file = get_stylesheet_directory() . '/data/alumni-map-data.json';
$hp_alumni_countries = array();

if ( is_readable( $hp_alumni_data_file ) ) {
	$hp_alumni_decoded = json_decode( file_get_contents( $hp_alumni_data_file ), true );

	if ( is_array( $hp_alumni_decoded ) ) {
		$hp_alumni_countries = $hp_alumni_decoded;
	}
}

/*
 * University logos for the running strip below the map. Files live in
 * assets/img/university-logos/ - individually cropped (transparent PNG,
 * logo only) from assets/img/logos-universities-world.png, which arrived
 * as one large collage. Four could not be confidently identified from the
 * artwork alone (no readable name in the mark itself); their alt text
 * says so honestly rather than guessing a name that could be wrong.
 */
$hp_university_logos = array(
	array( 'file' => 'logo-01.png', 'name' => 'The University of Queensland' ),
	array( 'file' => 'logo-02.png', 'name' => 'The Hong Kong Polytechnic University' ),
	array( 'file' => 'logo-03.png', 'name' => 'Logo mitra universitas (belum teridentifikasi)', 'name_en' => 'Partner university logo (not yet identified)' ),
	array( 'file' => 'logo-04.png', 'name' => 'Australian National University' ),
	array( 'file' => 'logo-05.png', 'name' => 'The University of Sydney' ),
	array( 'file' => 'logo-06.png', 'name' => 'Universitas Indonesia' ),
	array( 'file' => 'logo-07.png', 'name' => 'Monash University' ),
	array( 'file' => 'logo-08.png', 'name' => 'Wageningen University & Research' ),
	array( 'file' => 'logo-09.png', 'name' => 'The Chinese University of Hong Kong' ),
	array( 'file' => 'logo-10.png', 'name' => 'Kyoto University' ),
	array( 'file' => 'logo-11.png', 'name' => 'Institut Teknologi Bandung' ),
	array( 'file' => 'logo-12.png', 'name' => 'STEI Institute' ),
	array( 'file' => 'logo-13.png', 'name' => 'The University of British Columbia' ),
	array( 'file' => 'logo-14.png', 'name' => 'Singapore University of Technology and Design' ),
	array( 'file' => 'logo-15.png', 'name' => "Taylor's University" ),
	array( 'file' => 'logo-16.png', 'name' => 'National University of Singapore' ),
	array( 'file' => 'logo-17.png', 'name' => 'Universitas Padjadjaran' ),
	array( 'file' => 'logo-18.png', 'name' => 'Asia Pacific University of Technology & Innovation' ),
	array( 'file' => 'logo-19.png', 'name' => 'SDU University' ),
	array( 'file' => 'logo-20.png', 'name' => 'Ritsumeikan Asia Pacific University' ),
	array( 'file' => 'logo-21.png', 'name' => 'Universiti Kebangsaan Malaysia' ),
	array( 'file' => 'logo-22.png', 'name' => 'City University of Hong Kong' ),
	array( 'file' => 'logo-23.png', 'name' => 'The University of Western Australia' ),
	array( 'file' => 'logo-24.png', 'name' => 'The University of Auckland' ),
	array( 'file' => 'logo-25.png', 'name' => 'INSA Lyon' ),
	array( 'file' => 'logo-26.png', 'name' => 'Logo mitra universitas (belum teridentifikasi)', 'name_en' => 'Partner university logo (not yet identified)' ),
	array( 'file' => 'logo-27.png', 'name' => 'Telkom University' ),
	array( 'file' => 'logo-28.png', 'name' => 'Logo mitra universitas (belum teridentifikasi)', 'name_en' => 'Partner university logo (not yet identified)' ),
	array( 'file' => 'logo-29.png', 'name' => 'University of Toronto' ),
	array( 'file' => 'logo-30.png', 'name' => 'University of Malaya' ),
	array( 'file' => 'logo-31.png', 'name' => 'Tokyo International University' ),
	array( 'file' => 'logo-32.png', 'name' => 'Singapore Management University' ),
	array( 'file' => 'logo-33.png', 'name' => 'RMIT University' ),
	array( 'file' => 'logo-34.png', 'name' => 'Curtin University' ),
	array( 'file' => 'logo-35.png', 'name' => 'Politeknik Negeri Subang' ),
	array( 'file' => 'logo-36.png', 'name' => 'UIN Syarif Hidayatullah Jakarta' ),
	array( 'file' => 'logo-37.png', 'name' => 'IPB University' ),
	array( 'file' => 'logo-38.png', 'name' => 'Universitas Negeri Semarang' ),
	array( 'file' => 'logo-39.png', 'name' => 'BINUS University' ),
	array( 'file' => 'logo-40.png', 'name' => 'Universitas Diponegoro' ),
	array( 'file' => 'logo-41.png', 'name' => 'Institut Teknologi Sepuluh Nopember' ),
	array( 'file' => 'logo-42.png', 'name' => 'Universiti Teknologi PETRONAS' ),
	array( 'file' => 'logo-43.png', 'name' => 'Universitas Pembangunan Nasional Veteran Jakarta' ),
	array( 'file' => 'logo-44.png', 'name' => 'President University' ),
	array( 'file' => 'logo-45.png', 'name' => 'Universitas Brawijaya' ),
	array( 'file' => 'logo-46.png', 'name' => 'Logo mitra universitas (belum teridentifikasi)', 'name_en' => 'Partner university logo (not yet identified)' ),
	array( 'file' => 'logo-47.png', 'name' => 'Sampoerna University' ),
	array( 'file' => 'logo-48.png', 'name' => 'Universitas Katolik Indonesia Atma Jaya' ),
	array( 'file' => 'logo-49.png', 'name' => 'Universitas YARSI' ),
	array( 'file' => 'logo-50.png', 'name' => 'Media Kreatif' ),
);

$hp_map_instance = wp_unique_id( 'hp-map-' );
?>

<div class="hp-map-wrap hp-reveal">

	<div class="hp-map-canvas">
		<?php /* Decorative: the same information is in the text list below. */ ?>
		<svg class="hp-map-svg" viewBox="-180 -84 360 140" preserveAspectRatio="xMidYMid meet" aria-hidden="true" focusable="false">
			<?php foreach ( $hp_world_shapes as $hp_shape ) : ?>
				<?php /* evenodd: a shape's ring(s) after the first are holes (lakes, enclosed low-lying areas), not extra landmass. */ ?>
				<path fill-rule="evenodd" d="<?php echo esc_attr( hp_alumni_map_shape_path( $hp_shape ) ); ?>" />
			<?php endforeach; ?>
		</svg>

		<?php foreach ( $hp_alumni_countries as $hp_index => $hp_place ) : ?>
			<?php
			$hp_pos    = hp_alumni_map_pin_position( $hp_place['lng'], $hp_place['lat'] );
			$hp_tip_id = $hp_map_instance . '-tip-' . $hp_index;

			/*
			 * Flip the popup below the pin in the map's upper half. A popup
			 * for a northern-latitude pin (Russia sits at ~16% from the top)
			 * would otherwise open upwards and spill out over the section
			 * heading. Decided from the projected position rather than
			 * measured in JS, so it is correct on first paint with no
			 * repositioning flash.
			 */
			$hp_tip_below = $hp_pos['top'] < 50;

			$hp_institutions = isset( $hp_place['institutions'] ) && is_array( $hp_place['institutions'] )
				? $hp_place['institutions']
				: array();
			?>
			<div
				class="hp-map-point<?php echo $hp_tip_below ? ' hp-map-point--below' : ''; ?>"
				style="left: <?php echo esc_attr( $hp_pos['left'] ); ?>%; top: <?php echo esc_attr( $hp_pos['top'] ); ?>%;"
			>
				<?php
				/*
				 * Disclosure, not role="tooltip": this popup is click/tap
				 * toggleable and its list scrolls, which a tooltip is not
				 * supposed to be. aria-expanded + aria-controls on the
				 * trigger is the pattern that actually matches the behaviour.
				 */
				?>
				<button
					type="button"
					class="hp-map-pin"
					aria-expanded="false"
					aria-controls="<?php echo esc_attr( $hp_tip_id ); ?>"
				>
					<span class="screen-reader-text"><?php echo esc_html( hp_alumni_country_name( $hp_place['country'] ) ); ?></span>
				</button>
				<span class="hp-map-tip" id="<?php echo esc_attr( $hp_tip_id ); ?>" hidden>
					<span class="hp-map-tip-country"><?php echo esc_html( hp_alumni_country_name( $hp_place['country'] ) ); ?></span>
					<?php if ( $hp_institutions ) : ?>
						<span class="hp-map-tip-list">
							<?php foreach ( $hp_institutions as $hp_inst ) : ?>
								<span class="hp-map-tip-item"><?php echo esc_html( $hp_inst['institution'] ); ?></span>
							<?php endforeach; ?>
						</span>
					<?php endif; ?>
				</span>
			</div>
		<?php endforeach; ?>
	</div>

	<?php
	/*
	 * Text equivalent of the map. A pin-only map is unusable with a screen
	 * reader, so the same array is rendered as a plain list - one source, so
	 * it cannot fall out of sync with the pins above.
	 */
	?>
	<h3 class="screen-reader-text"><?php echo hp_t( 'Daftar universitas tujuan alumni', 'List of universities attended by alumni' ); ?></h3>
	<ul class="screen-reader-text">
		<?php foreach ( $hp_alumni_countries as $hp_place ) : ?>
			<li>
				<?php echo esc_html( hp_alumni_country_name( $hp_place['country'] ) ); ?>
				<?php if ( ! empty( $hp_place['institutions'] ) && is_array( $hp_place['institutions'] ) ) : ?>
					<ul>
						<?php foreach ( $hp_place['institutions'] as $hp_inst ) : ?>
							<li><?php echo esc_html( $hp_inst['institution'] ); ?></li>
						<?php endforeach; ?>
					</ul>
				<?php endif; ?>
			</li>
		<?php endforeach; ?>
	</ul>

	<div class="hp-map-cta">
		<a class="hp-btn" href="https://www.instagram.com/p/Dck0Q71kYlE/?img_index=1" target="_blank" rel="noopener"><?php echo hp_t( 'Lihat Keseruan Perjalanan Angkatan 2026', 'See the Class of 2026&#8217;s Journey' ); ?></a>
	</div>
</div>

<?php
/*
 * Continuously-running logo strip, right to left, looping. Same doubled-
 * list technique as the achievements marquee elsewhere on this page: the
 * list is rendered twice back to back and the track animates to -50%,
 * which repeats seamlessly because both halves are identical. Only the
 * first pass is real/focusable; the second is aria-hidden so a screen
 * reader doesn't announce every logo twice.
 *
 * Deliberately no hover-pause and no per-logo hover effect - continuous
 * motion is the point here, unlike the achievement tiles' hover reveal.
 */
?>
<div class="hp-map-logos-wrap hp-reveal" style="animation-delay: 80ms;">
	<div class="hp-map-logos-track">
		<?php for ( $hp_pass = 0; $hp_pass < 2; $hp_pass++ ) : ?>
			<?php foreach ( $hp_university_logos as $hp_logo ) : ?>
				<div class="hp-map-logo"<?php echo ( 0 === $hp_pass ) ? '' : ' aria-hidden="true"'; ?>>
					<img
						src="<?php echo esc_url( get_stylesheet_directory_uri() . '/assets/img/university-logos/' . $hp_logo['file'] ); ?>"
						alt="<?php echo ( 0 === $hp_pass ) ? esc_attr( hp_t( $hp_logo['name'], isset( $hp_logo['name_en'] ) ? $hp_logo['name_en'] : $hp_logo['name'] ) ) : ''; ?>"
						<?php echo ( 0 === $hp_pass ) ? '' : 'aria-hidden="true"'; ?>
					>
				</div>
			<?php endforeach; ?>
		<?php endfor; ?>
	</div>
</div>
