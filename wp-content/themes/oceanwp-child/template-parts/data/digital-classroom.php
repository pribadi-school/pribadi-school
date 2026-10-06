<?php
/**
 * Data for the Digital Classroom page - page-digital-classroom.php,
 * rendered by template-parts/story-page.php. Field reference: the docblocks
 * in story-page.php and data/achievement-stories.php.
 *
 * Content is the Chromebook material from the page's original Elementor
 * version (still dormant in the database), by direction: the
 * assessment-platform paragraphs, the quote and the video were dropped.
 * Indonesian copy is the original, lightly tidied ("Chrome Book" ->
 * "Chromebook"); the English is a translation of it. Four categories so
 * far: Chromebook, then StudyTouch, Edunav and Google Education Plus (all
 * three placeholder copy, see the notes on their stories) - add categories
 * and stories here as the page grows.
 *
 * Images are in assets/img/digital-classroom/, converted from the original
 * uploads (wp-content/uploads/2022/10/) so they travel with the theme; the
 * StudyTouch, Edunav and Google ones come from studytouch.id (a still of
 * its 3D panel model), edunav.net and edu.google.com.
 *
 * @package OceanWP_Child
 */

return array(
	'page'       => array(
		'icon'               => 'fas fa-laptop',
		'title'              => 'Smart <span class="pr-heading-accent">Digital Classroom</span>',
		'title_en'           => 'Smart <span class="pr-heading-accent">Digital Classroom</span>',
		'lede'               => 'Smart Digital Classroom adalah suatu sistem pembelajaran berbasis penggunaan media digital. Para siswa dibekali dengan sebuah perangkat Chromebook yang menggantikan fungsi buku-buku pelajarannya. Perangkat tersebut memuat materi-materi pelajaran para siswa, sehingga siswa tidak lagi membawa buku-buku pelajaran ketika datang ke sekolah.',
		'lede_en'            => 'Smart Digital Classroom is a way of learning built around digital media. Every student is given a Chromebook that takes the place of their textbooks. It holds all of their course material, so students no longer have to carry textbooks to school.',
		// No banner photo, by direction (story-page.php leaves it out when unset).
		// No category label above each story's title either - it only repeated the filter button.
		'show_tags'          => false,
		// Smaller cards with a wider text column: the product pictures left a lot of empty space.
		'compact'            => true,
		// Story paragraphs are justified, by direction.
		'text_align'         => 'justify',
		'stories_heading'    => 'Belajar dengan <span class="pr-heading-accent">Teknologi Digital</span>',
		'stories_heading_en' => 'Learning with <span class="pr-heading-accent">Digital Technology</span>',
		'filter_label'       => 'Saring berdasarkan topik',
		'filter_label_en'    => 'Filter by topic',
	),

	'categories' => array(
		'chromebook' => array(
			'label'    => 'Chromebook',
			'label_en' => 'Chromebook',
		),
		'studytouch' => array(
			'label'    => 'StudyTouch',
			'label_en' => 'StudyTouch',
		),
		'edunav'     => array(
			'label'    => 'Edunav',
			'label_en' => 'Edunav',
		),
		'google'     => array(
			'label'    => 'Google Education Plus',
			'label_en' => 'Google Education Plus',
		),
	),

	'stories'    => array(
		array(
			// The three original Chromebook cards, merged into one paragraph and
			// shown with a rotatable 3D model (Acer C7 Chromebook; its textures were
			// shrunk from 4096px to 1024px so the file is ~0.4 MB instead of 55 MB).
			// 'photo' is the still shown while the model loads, and the fallback.
			'photo'        => 'digital-classroom/chromebook-poster.webp',
			'model'        => 'models/chromebook.glb',
			'model_orbit'  => '-20deg 75deg auto',
			'model_pause_at' => 2.0, // the lid is fully open here; the animation would close it again
			'model_alt'    => 'Model 3D Chromebook yang dapat diputar',
			'model_alt_en' => 'Rotatable 3D model of a Chromebook',
			'fill'         => 'plain',
			'categories'   => array( 'chromebook' ),
			'title'        => 'Chromebook sebagai Sarana Belajar',
			'title_en'     => 'The Chromebook as a Learning Tool',
			'summary'      => 'Selain memuat materi-materi pelajaran, Chromebook juga digunakan untuk mendukung pembelajaran para siswa. Dengan fasilitas sambungan internet, para siswa dapat mencari informasi, pengetahuan dan ilmu yang tersebar luas di internet dengan tetap di dalam pengawasan dan bimbingan para guru, dan sekolah membatasi penggunaan Chromebook hanya untuk keperluan pembelajaran. Penggunaan Chromebook merupakan salah satu usaha Sekolah Pribadi Depok agar para siswa dapat mengikuti perkembangan zaman yang sangat cepat, dan para guru memiliki kesempatan untuk melaksanakan pembelajaran yang kreatif dan inovatif: pembelajaran tidak lagi berpusat pada guru, tetapi melibatkan para siswa dengan Chromebook di tangan mereka. Untuk mendukung Smart Digital Classroom, sekolah bekerja sama dengan Google sehingga dapat menggunakan fasilitas G-Suite, yang memudahkan pengelolaan kelas lewat Google Classroom dan menyediakan media penyimpanan yang tak terbatas melalui Google Drive.',
			'summary_en'   => 'Beyond holding course material, the Chromebook supports students\' learning in class. With an internet connection, students can look up the wide range of information and knowledge available online, always under their teachers\' supervision and guidance, and the school limits the Chromebooks to learning purposes only. Using Chromebooks is one of the ways Sekolah Pribadi Depok helps students keep pace with a fast-changing world, and it gives teachers room to teach creatively and innovatively: lessons are no longer teacher-centred, but involve students with a Chromebook in their hands. To support Smart Digital Classroom, the school works with Google, giving it access to G Suite, which makes classes easy to manage through Google Classroom and provides unlimited storage on Google Drive.',
		),
		/*
		 * PLACEHOLDER content for now, by direction, so the layout can be
		 * reviewed: the picture is a still of the 3D model of the panel on
		 * studytouch.id's home page (captured from their model viewer, from a
		 * similar angle to the hero - so check with them / swap for the
		 * school's own photo before launch), and the copy sticks to features listed on
		 * studytouch.id - writing with stylus or finger, the Whiteboard, screen
		 * casting and file apps, and working with Windows, Mac, Android, Linux
		 * and Chrome devices. Replace with the school's own account of how the
		 * panels are used in lessons.
		 */
		array(
			'photo'      => 'digital-classroom/studytouch-panel.webp',
			// Rotatable 3D model of the panel; 'photo' above is its loading poster.
			'model'      => 'models/studytouch-panel.glb',
			'model_alt'  => 'Model 3D layar sentuh interaktif StudyTouch pada standnya, dapat diputar',
			'model_alt_en' => 'Rotatable 3D model of the StudyTouch interactive display on its stand',
			'fill'       => 'plain',
			'categories' => array( 'studytouch' ),
			'title'      => 'Layar Sentuh Interaktif StudyTouch',
			'title_en'   => 'StudyTouch Interactive Display',
			'summary'    => 'StudyTouch adalah layar sentuh interaktif yang membantu guru mengajar dengan lebih hidup. Guru dapat menulis dan menggambar langsung di layar dengan pena atau jari, menjelaskan materi lewat papan tulis digital, dan menampilkan konten dari Chromebook maupun perangkat lain ke seluruh kelas. Karena siswa ikut menyentuh dan berpartisipasi langsung, pelajaran menjadi lebih interaktif dan kolaboratif.',
			'summary_en' => 'StudyTouch is an interactive touchscreen that helps teachers bring lessons to life. Teachers can write and draw directly on the screen with a stylus or a finger, explain topics on a digital whiteboard, and show content from Chromebooks and other devices to the whole class. With students able to come up and take part hands-on, lessons become more interactive and collaborative.',
		),
		/*
		 * PLACEHOLDER content for now, same as StudyTouch above: the photo is
		 * Edunav's own student-app screenshot (from edunav.net, cut out on a
		 * transparent background - check with them / swap before launch) and
		 * the copy sticks to what edunav.net lists for the platform: a school
		 * information system with an LMS (courses, assignments, grade book),
		 * online exams (CBT) with automatic grading, and chat between parents
		 * and teachers. Edit it down to the modules the school actually uses.
		 */
		array(
			'photo'      => 'digital-classroom/edunav-app.webp',
			'fill'       => 'plain',
			'categories' => array( 'edunav' ),
			'title'      => 'Edunav: Sistem Informasi Sekolah Terpadu',
			'title_en'   => 'Edunav: One Platform for the School',
			'summary'    => 'Edunav adalah sistem informasi sekolah terintegrasi yang menyatukan kegiatan belajar mengajar dalam satu platform. Guru dapat membagikan materi dan tugas lewat LMS, membuat ujian berbasis komputer (CBT) dengan penilaian otomatis, serta mencatat presensi dan nilai. Siswa dapat mengakses pelajaran dan tugas dari aplikasi di ponsel, sementara orang tua dapat berkomunikasi langsung dengan wali kelas lewat Edunav Chat.',
			'summary_en' => 'Edunav is an integrated school information system that brings teaching and learning together on one platform. Teachers can share materials and assignments through the LMS, run computer-based exams (CBT) with automatic grading, and keep attendance and grades. Students reach their lessons and assignments from the app on their phones, and parents can talk directly with their child\'s homeroom teacher through Edunav Chat.',
		),
		/*
		 * PLACEHOLDER content for now, same as StudyTouch and Edunav above: the
		 * picture is Google for Education's own product illustration (from the
		 * Education Plus page on edu.google.com, on a white background - check
		 * Google's brand/usage terms and swap for the school's own image before
		 * launch) and the copy sticks to what that page says: Education Plus is
		 * Google's most comprehensive edition of Workspace for Education,
		 * combining advanced security and insights with tools for teaching and
		 * learning, including Gemini for Education and Gemini Notebook. Edit it
		 * to match what the school actually uses.
		 */
		array(
			'photo'      => 'digital-classroom/google-education-plus.webp',
			'fill'       => 'plain',
			'categories' => array( 'google' ),
			'title'      => 'Google Workspace for Education Plus',
			'title_en'   => 'Google Workspace for Education Plus',
			'summary'    => 'Education Plus adalah edisi Google Workspace for Education yang paling lengkap, menyatukan Google Classroom, Drive, Meet, dan aplikasi Google lainnya dalam satu solusi teknologi pendidikan. Edisi ini menghadirkan keamanan dan wawasan tingkat lanjut serta perangkat yang memperkaya dan mempersonalisasi pembelajaran, termasuk asisten AI Gemini for Education dan Gemini Notebook yang membantu guru merencanakan pelajaran dan menyiapkan materi dengan lebih cepat.',
			'summary_en' => 'Education Plus is the most comprehensive edition of Google Workspace for Education, bringing Google Classroom, Drive, Meet and the other Google apps together in one education technology solution. It adds advanced security and insights along with tools that enrich and personalise learning, including the Gemini for Education and Gemini Notebook AI assistants, which help teachers plan lessons and prepare materials faster.',
		),
	),
);
