<?php
/**
 * Data for the Prestasi (achievements) page - page-prestasi.php.
 *
 * Returns array( 'categories' => ..., 'stories' => ... ). Plain PHP data on
 * purpose, the same way the homepage's achievement strip and news carousel
 * keep theirs: it travels with the theme through git and the cPanel deploy,
 * instead of living in a database that has to be re-entered on every
 * install.
 *
 * Every story below uses only facts the school has already published
 * elsewhere on the site (the homepage achievement strip and the Kabar
 * Terkini carousel) - no invented narrative about real students. 'story'
 * is the long-form write-up (the "who is this student, what did it take"
 * paragraphs) and is empty for all of them until the school supplies that
 * copy; the card renders cleanly without it. Paragraphs are separated by a
 * blank line.
 *
 * Fields per story:
 *   photo       File in assets/img/ (relative to it). Any aspect works -
 *               the card crops with object-fit - but put the subject near
 *               the centre, or set 'focus' (CSS object-position).
 *   categories  One or more keys from 'categories'. A story with two keys
 *               shows under both filter buttons.
 *   title/_en   Headline. Hand-written English, not a literal translation.
 *   name        Student name(s). Names are never translated; 'name_en' is
 *               only for a descriptive line like "5 siswa-siswi ...".
 *   date/_en    Optional, free text ("Agustus 2026"). Omitted when unknown.
 *   summary/_en One or two sentences, always shown.
 *   story/_en   Optional long-form copy, see above.
 *   link        Optional source post (Instagram), opens in a new tab.
 *
 * A filter button only appears for categories that have at least one
 * story, so adding a category here without any stories is harmless.
 *
 * @package OceanWP_Child
 */

return array(
	'categories' => array(
		'olimpiade' => array(
			'label'    => 'Olimpiade Sains & Matematika',
			'label_en' => 'Science & Math Olympiads',
		),
		'teknologi' => array(
			'label'    => 'Teknologi & AI',
			'label_en' => 'Technology & AI',
		),
		'beasiswa'  => array(
			'label'    => 'Beasiswa',
			'label_en' => 'Scholarships',
		),
		'olahraga'  => array(
			'label'    => 'Olahraga',
			'label_en' => 'Sports',
		),
		'seni'      => array(
			'label'    => 'Seni & Budaya',
			'label_en' => 'Arts & Culture',
		),
		'sosial'    => array(
			'label'    => 'Sosial & Kepemimpinan',
			'label_en' => 'Community & Leadership',
		),
	),

	'stories'    => array(
		array(
			'photo'      => 'wisangluv-osn.webp',
			'categories' => array( 'olimpiade' ),
			'title'      => 'Dua Medali Perunggu di OSN 2026',
			'title_en'   => 'Two Bronze Medals at OSN 2026',
			'name'       => 'Wisanggeni & Luvidi',
			'summary'    => 'Wisanggeni dan Luvidi meraih medali perunggu di Olimpiade Sains Nasional (OSN) 2026, masing-masing di bidang Astronomi dan Matematika.',
			'summary_en' => 'Wisanggeni and Luvidi each won bronze at the 2026 National Science Olympiad (OSN), in Astronomy and Mathematics.',
		),
		array(
			'photo'      => 'luvidi-ioai-hotnews.webp',
			'categories' => array( 'teknologi', 'olimpiade' ),
			'title'      => 'Medali Emas Olimpiade Internasional Kecerdasan Buatan',
			'title_en'   => 'Gold at the International Olympiad in Artificial Intelligence',
			'name'       => 'Luvidi',
			'summary'    => 'Luvidi membawa pulang medali emas dari International Olympiad in Artificial Intelligence (IOAI).',
			'summary_en' => 'Luvidi brought home a gold medal from the International Olympiad in Artificial Intelligence (IOAI).',
			'link'       => 'https://www.instagram.com/reel/Db2zYFzNP0P/?stkn=MTFtZzZ5eHh3MzR6Mw==',
		),
		array(
			'photo'      => 'beasiswa-garuda.webp',
			'categories' => array( 'beasiswa' ),
			'title'      => 'Lima Siswa Meraih Beasiswa Garuda',
			'title_en'   => 'Five Students Awarded the Garuda Scholarship',
			'name'       => '5 siswa-siswi Pribadi Depok',
			'name_en'    => '5 Pribadi Depok students',
			'summary'    => 'Lima siswa-siswi Sekolah Pribadi Depok terpilih sebagai penerima Beasiswa Garuda.',
			'summary_en' => 'Five Sekolah Pribadi Depok students were selected as Garuda Scholarship recipients.',
		),
		array(
			'photo'      => 'achievements/omi-2026.webp',
			'categories' => array( 'olimpiade' ),
			'title'      => 'Lima Siswa Lolos ke Tingkat Provinsi OMI 2026',
			'title_en'   => 'Five Students Advance to the Provincial Round of OMI 2026',
			'name'       => 'Viko, Maria, Harun, Badzil & Arfa',
			'summary'    => 'Viko, Maria, Harun, Badzil, dan Arfa berhasil melaju ke tingkat provinsi Olimpiade Madrasah Indonesia (OMI) 2026.',
			'summary_en' => 'Viko, Maria, Harun, Badzil and Arfa made it through to the provincial round of Olimpiade Madrasah Indonesia (OMI) 2026.',
		),
		array(
			'photo'      => 'achievements/biru-simso.webp',
			'categories' => array( 'olimpiade' ),
			'title'      => 'Medali Perunggu SIMSO 2026',
			'title_en'   => 'Bronze Medal at SIMSO 2026',
			'name'       => 'Biru',
			'summary'    => 'Biru meraih medali perunggu di Siam International Math and Science Olympics (SIMSO) 2026.',
			'summary_en' => 'Biru won a bronze medal at the 2026 Siam International Math and Science Olympics (SIMSO).',
			'link'       => 'https://www.instagram.com/p/DcsoZE-kTTJ/?stkn=MTV4eTM4ZmliODVtMA==',
		),
		array(
			'photo'      => 'achievements/musa-jismo-silver-bronze.webp',
			'categories' => array( 'olimpiade' ),
			'title'      => 'Medali Perak dan Perunggu JISMO',
			'title_en'   => 'Silver and Bronze at JISMO',
			'name'       => 'Musa',
			'summary'    => 'Musa membawa pulang medali perak dan perunggu dari Japan International Science and Mathematics Olympiads (JISMO).',
			'summary_en' => 'Musa came home from the Japan International Science and Mathematics Olympiads (JISMO) with both a silver and a bronze medal.',
			'link'       => 'https://www.instagram.com/p/Dcuh6u0mGbn/?stkn=MXJjOHhicjZ0bHFycA==',
		),
		array(
			'photo'      => 'achievements/tobias-bronze-science-jismo.webp',
			'categories' => array( 'olimpiade' ),
			'title'      => 'Medali Perunggu Sains JISMO',
			'title_en'   => 'Bronze in Science at JISMO',
			'name'       => 'Tobias',
			'summary'    => 'Tobias meraih medali perunggu bidang Sains di Japan International Science and Mathematics Olympiads (JISMO).',
			'summary_en' => 'Tobias won a bronze medal in Science at the Japan International Science and Mathematics Olympiads (JISMO).',
			'link'       => 'https://www.instagram.com/p/DcsoYUFkX5T/?stkn=MWx1czhrdGt5Z3V2Nw==',
		),
		array(
			'photo'      => 'achievements/aleksa-horse.webp',
			'categories' => array( 'olahraga' ),
			'title'      => 'Prestasi di Arena Berkuda',
			'title_en'   => 'Success in the Equestrian Arena',
			'name'       => 'Aleksa',
			'summary'    => 'Aleksa mengharumkan nama sekolah lewat prestasinya di cabang olahraga berkuda (equestrian).',
			'summary_en' => 'Aleksa has been making the school proud with results in equestrian sport.',
			'link'       => 'https://www.instagram.com/p/DcvEAEjkYbp/?stkn=Y3ZhY2wwNmlqNHNk',
		),
		array(
			'photo'      => 'achievements/ayu-swimming-competition.webp',
			'categories' => array( 'olahraga' ),
			'title'      => 'Prestasi di Kompetisi Renang',
			'title_en'   => 'Results in the Pool',
			'name'       => 'Ayu',
			'summary'    => 'Ayu berlaga dan berprestasi di kompetisi renang.',
			'summary_en' => 'Ayu competed and placed in a swimming competition.',
			'link'       => 'https://www.instagram.com/p/DcxZ30BkfY6/?stkn=MXB5YWdmaTBuaWo0Zw==',
		),
		array(
			'photo'      => 'achievements/lala-fashion-week.webp',
			'categories' => array( 'seni' ),
			'title'      => 'Desainer Muda di Indonesia Trend Fashion Week 2026',
			'title_en'   => 'Young Designer at Indonesia Trend Fashion Week 2026',
			'name'       => 'Lala',
			'summary'    => 'Melalui program Dream Fashion, Lala tampil sebagai desainer muda di Indonesia Trend Fashion Week 2026.',
			'summary_en' => 'Through the Dream Fashion program, Lala showed her work as a young designer at Indonesia Trend Fashion Week 2026.',
			'link'       => 'https://www.instagram.com/p/DbZpLopGHG4/?stkn=MWd3bDRhcjcxOTU0cg==',
		),
		array(
			'photo'      => 'achievements/fayha-sumbawa.webp',
			'categories' => array( 'sosial' ),
			'title'      => 'Memberikan Dampak Nyata di Sumbawa',
			'title_en'   => 'Making a Real Difference in Sumbawa',
			'name'       => 'Fayha',
			'summary'    => 'Fayha turun langsung memberikan dampak nyata bagi masyarakat di Sumbawa.',
			'summary_en' => 'Fayha went out to Sumbawa to make a real difference for the community there.',
			'link'       => 'https://www.instagram.com/p/Dbm_PwKEe6T/?stkn=MWthd3ZmZTFldXRsMA==',
		),
	),
);
