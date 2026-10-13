<?php
/**
 * Copy for the three school pages (page-school.php), keyed by page slug.
 * Every user-facing string is an [Indonesian, English] pair; the English is
 * hand-written from the former Elementor pages. Image paths are relative to
 * https://pribadidepok.sch.id/wp-content/uploads/.
 *
 * Section types rendered by page-school.php:
 *   feature  heading, paras[], list[], photo, alt, button => [label, url]
 *   cards    heading, lede, cols (2|3), items[] => [title, text, button?]
 *   tiles    heading, lede, items[] (short labels), paras[]
 *   cta      heading, text, button => [label, url]
 *
 * @package OceanWP_Child
 */

$wa = 'https://wa.me/6281292900095';

return array(

	'elementary'         => array(
		'eyebrow' => array( 'SEKOLAH DASAR', 'ELEMENTARY SCHOOL' ),
		'title'   => array(
			'SD Pribadi: <span class="pr-heading-accent">Menemukan Minat</span>, Menata Masa Depan',
			'Pribadi Elementary: <span class="pr-heading-accent">Finding Interests</span>, Shaping the Future',
		),
		'lede'    => array(
			'Inilah saatnya siswa menemukan minat, hubungan pertemanan yang beragam, mempunyai pelajaran kesukaan serta berinteraksi lebih lanjut tentang masa depan.',
			'This is the time for students to find their interests, build varied friendships, discover favourite subjects and start thinking about the future.',
		),
		'hero'    => array( '2023/01/Portrait-Elementary-2-min.jpg', array( 'Siswa SD Pribadi Depok', 'Pribadi Elementary students' ) ),
		'vm'      => array(
			'vision'  => array(
				'Terwujudnya generasi yang berakhlak, berprestasi, bersaing, dan berwawasan global berlandaskan budaya Indonesia.',
				'A generation of good character, achievement and competitiveness, with a global outlook rooted in Indonesian culture.',
			),
			'photo'   => array( '2023/01/Protrait-Mr-Tommy-2-min.jpg', array( 'Guru SD Pribadi Depok', 'A Pribadi Elementary teacher' ) ),
			'mission' => array(
				array( 'Meningkatkan kualitas kepribadian siswa dari sisi religi dan sosial secara seimbang.', 'Improve students\' personal character in a balanced way, both religious and social.' ),
				array( 'Meningkatkan prestasi akademik pada tingkat sekolah, wilayah, nasional, dan internasional.', 'Raise academic achievement at school, regional, national and international levels.' ),
				array( 'Menyiapkan siswa melanjutkan studi ke jenjang yang lebih tinggi dengan sistem pembelajaran yang berkualitas dan penerapan teknologi terkini.', 'Prepare students for further study with a high-quality learning system and the latest technology.' ),
				array( 'Membekali siswa dengan berbagai keterampilan yang disesuaikan dengan minat dan bakatnya.', 'Equip students with a range of skills matched to their interests and talents.' ),
				array( 'Mengembangkan sikap cinta terhadap sesama, bangsa, dan Negara Indonesia pada diri siswa.', 'Nurture students\' love for others, for their nation and for Indonesia.' ),
			),
		),
		'sections' => array(
			array(
				'type'    => 'tiles',
				'heading' => array( 'Mengenal <span class="pr-heading-accent">SD Pribadi</span>', 'Getting to Know <span class="pr-heading-accent">Pribadi Elementary</span>' ),
				'items'   => array( 'Learning to know', 'Learning to do', 'Learning to be', 'Learning to live together' ),
				'paras'   => array(
					array( 'Kami merangsang siswa untuk belajar mengetahui, melakukan sesuatu, menjadi sesuatu untuk membangun kebersamaan setelah melalui tiga konsep sebelumnya. Membangun kebersamaan membutuhkan saling pengertian, komunikasi dan koordinasi.', 'We encourage students to learn to know, to do and to be, and then to build togetherness on those three foundations. Living together takes mutual understanding, communication and coordination.' ),
					array( 'Pribadi Bilingual Boarding School membantu siswa untuk belajar dan melewati keempatnya untuk menyambut masa depan mereka.', 'Pribadi Bilingual Boarding School helps students move through all four as they prepare for their future.' ),
				),
			),
			array(
				'type'    => 'feature',
				'tint'    => true,
				'heading' => array( 'Kurikulum <span class="pr-heading-accent">SD Pribadi</span>', 'Our <span class="pr-heading-accent">Curriculum</span>' ),
				'title'   => array( 'Kurikulum Nasional plus Kurikulum Cambridge', 'National Curriculum plus Cambridge Curriculum' ),
				'paras'   => array(
					array( 'Sebagai salah satu yang teregistrasi pada Cambridge International School, SD Pribadi Depok menjadi bagian dari komunitas global yang berupaya untuk mempersiapkan siswa mencapai kesuksesan di dunia yang penuh dengan tantangan.', 'As a registered Cambridge International School, SD Pribadi Depok is part of a global community that prepares students to succeed in a challenging world.' ),
					array( 'Sebagai sekolah yang terdaftar sebagai sekolah Cambridge, SD Pribadi mendapatkan akses ke berbagai sumber pengajaran dan pembelajaran yang unik, pengembangan profesional guru, kurikulum kelas dunia, serta berbagai kualifikasi untuk mendidik dan membimbing peserta didik usia 6 sampai 12 tahun.', 'As a Cambridge school, SD Pribadi has access to unique teaching and learning resources, teacher professional development, a world-class curriculum and qualifications for learners aged 6 to 12.' ),
				),
				'photo'   => array( '2022/09/julius-dudenas-Jrq8ONPnrIU-unsplash1-min.jpg', array( 'Kurikulum SD Pribadi', 'The Pribadi Elementary curriculum' ) ),
			),
			array(
				'type'    => 'feature',
				'heading' => array( 'Metode <span class="pr-heading-accent">Pembelajaran</span>', 'Learning <span class="pr-heading-accent">Method</span>' ),
				'title'   => array( 'Blended Learning & Student Centered Learning', 'Blended Learning & Student Centered Learning' ),
				'paras'   => array(
					array( 'Blended learning menggabungkan berbagai cara penyampaian, model pengajaran, dan gaya pembelajaran: kombinasi pengajaran langsung (face-to-face) dan online, serta elemen interaksi sosial di dalamnya.', 'Blended learning combines different ways of delivery, teaching models and learning styles: face-to-face and online teaching together, with social interaction at its heart.' ),
					array( 'Student Centered Learning adalah pembelajaran transformatif dengan beragam cara belajar yang dapat dipilih sesuai materi atau kondisi, namun tetap berpusat pada siswa dan memberdayakan mereka untuk mengembangkan kemampuan berpikir kritis.', 'Student Centered Learning is transformative learning with varied approaches chosen to suit the material or situation, always centred on the student and building their critical thinking.' ),
				),
				'list'    => array(
					array( 'Outing Program', 'Outing Program' ),
					array( 'Belajar Mandiri', 'Independent Learning' ),
					array( 'Live Teaching', 'Live Teaching' ),
					array( 'Online Support', 'Online Support' ),
					array( 'Inquiry-Based Learning', 'Inquiry-Based Learning' ),
					array( 'Leadership Camp', 'Leadership Camp' ),
				),
				'photo'   => array( '2022/09/Student-3-e1664501564349.png', array( 'Siswa SD Pribadi belajar', 'Pribadi Elementary students learning' ) ),
				'contain' => true,
			),
			array(
				'type'    => 'cards',
				'tint'    => true,
				'cols'    => 3,
				'heading' => array( 'Pembelajaran <span class="pr-heading-accent">Karakter</span>', 'Character <span class="pr-heading-accent">Education</span>' ),
				'lede'    => array( 'SD Pribadi berupaya dengan berbagai kegiatan untuk selalu mengutamakan pendidikan karakter siswanya.', 'SD Pribadi puts students\' character first through a range of activities.' ),
				'items'   => array(
					array( 'Social-Emotional Learning', 'Social-Emotional Learning', 'Program penguatan skill sosial-emosional melalui berbagai aktivitas serta pembelajaran, mulai dari mengenal diri sendiri hingga membangun hubungan sosial yang baik dengan sekitar.', 'A programme that strengthens social-emotional skills through activities and lessons, from knowing oneself to building healthy relationships with others.' ),
					array( 'Character Education', 'Character Education', 'Pembentukan karakter yang tidak hanya diajarkan melalui jam pelajaran khusus, tetapi juga diselipkan pada nilai-nilai akademik untuk menunjang visi sekolah membangun generasi emas.', 'Character building taught not only in dedicated lessons but woven into academic values, supporting the school\'s vision of a golden generation.' ),
					array( 'Student\'s One on One', 'Student\'s One on One', 'Komunikasi tatap muka perorangan yang memungkinkan siswa dan guru mendiskusikan masalah, umpan balik, dan tujuan mereka.', 'One-to-one conversations where students and teachers talk through problems, feedback and goals.' ),
					array( 'Leadership Camp', 'Leadership Camp', 'Dilaksanakan setelah ujian akhir semester sebagai wadah siswa mengembangkan potensi diri dan mengasah skill literasi melalui berbagai jenis bacaan.', 'Held after the end-of-semester exams so students can develop their potential and sharpen literacy skills through a variety of reading.' ),
					array( 'Pre-teen Seminar', 'Pre-teen Seminar', 'Webinar rutin setiap minggu untuk siswa kelas 5 dan 6, dirancang untuk membantu masa transisi menuju remaja yang tidak selalu mudah.', 'A weekly webinar for Grade 5 and 6 students, designed to support the sometimes confusing transition into the teenage years.' ),
					array( 'Career Exploration', 'Career Exploration', 'Lewat program \'Guest Teacher\', setiap semester SD Pribadi mengundang orang tua, alumni, atau narasumber lain untuk menginspirasi siswa tentang dunia profesional.', 'Through the \'Guest Teacher\' programme, each semester parents, alumni and other speakers visit to inspire students about the working world.' ),
				),
			),
			array(
				'type'    => 'feature',
				'heading' => array( 'Aplikasi <span class="pr-heading-accent">Pembelajaran</span>', 'Learning <span class="pr-heading-accent">Applications</span>' ),
				'title'   => array( 'Edunav Learning Process Management System', 'Edunav Learning Process Management System' ),
				'paras'   => array(
					array( 'Guru-guru SD Pribadi dibekali kecakapan mengimplementasikan berbagai aplikasi dalam kegiatan belajar agar suasana kelas lebih hidup. Metode kami terfokus pada students-centered dan inquiry based learning yang mengedepankan kemandirian siswa dalam memahami dan memecahkan masalah.', 'SD Pribadi teachers are trained to use a range of apps in lessons to bring the classroom to life. Our methods centre on student-centred and inquiry-based learning, building students\' independence in understanding and solving problems.' ),
					array( 'Untuk menunjang proses dan melaporkan hasil belajar, SD Pribadi memiliki Learning Process Management System (Edunav). Sesuai prinsip segitiga pendidikan, platform ini dapat diakses dari mana saja oleh guru, orang tua dan siswa.', 'To support learning and report results, SD Pribadi has a Learning Process Management System (Edunav). Following the education triangle, teachers, parents and students can all use it from anywhere.' ),
				),
				'photo'   => array( '2022/09/Edunav-Mobile-small-min.png', array( 'Aplikasi Edunav', 'The Edunav app' ) ),
				'contain' => true,
			),
			array(
				'type'    => 'cta',
				'heading' => array( 'Tertarik <span class="au-career-accent">Bergabung?</span>', 'Interested in <span class="au-career-accent">Joining?</span>' ),
				'text'    => array( 'Hubungi kami untuk informasi pendaftaran dan kunjungan sekolah.', 'Contact us for admissions information and school visits.' ),
				'button'  => array( array( 'Hubungi via WhatsApp', 'Contact us on WhatsApp' ), $wa ),
			),
		),
	),

	'junior-high-school' => array(
		'eyebrow' => array( 'SEKOLAH MENENGAH PERTAMA', 'JUNIOR HIGH SCHOOL' ),
		'title'   => array(
			'SMP Pribadi: <span class="pr-heading-accent">Menemukan Minat</span>, Menata Masa Depan',
			'Pribadi Junior High: <span class="pr-heading-accent">Finding Interests</span>, Shaping the Future',
		),
		'lede'    => array(
			'Inilah saatnya siswa menemukan minat, hubungan pertemanan yang beragam, mempunyai pelajaran kesukaan serta berinteraksi lebih lanjut tentang masa depan.',
			'This is the time for students to find their interests, build varied friendships, discover favourite subjects and start thinking about the future.',
		),
		'hero'    => array( '2023/02/Dinda.jpg', array( 'Siswa SMP Pribadi Depok', 'A Pribadi Junior High student' ) ),
		'vm'      => array(
			'vision'  => array(
				'Menjadi sekolah mandiri bagi terwujudnya generasi emas berakhlak mulia, cerdas, berwawasan global dan berbudaya.',
				'To be an independent school that produces a golden generation of noble character, intelligence, global outlook and culture.',
			),
			'photo'   => array( '2022/11/Reading-Camp-Malang-scaled.jpg', array( 'Reading Camp siswa SMP', 'Junior high Reading Camp' ) ),
			'mission' => array(
				array( 'Mengembangkan etos kerja yang penuh kemandirian dalam merancang dan mengelola sumber daya yang dimiliki.', 'Develop an independent work ethic in planning and managing the resources available.' ),
				array( 'Menghasilkan generasi emas yang memiliki akhlak mulia dan memegang teguh norma-norma yang dapat diaktualisasikan dalam kehidupan bermasyarakat.', 'Produce a golden generation of noble character who hold firmly to norms they can apply in community life.' ),
				array( 'Mengembangkan kapasitas dan kualitas warga sekolah di bidang ilmu pengetahuan dan teknologi.', 'Build the capacity and quality of the school community in science and technology.' ),
				array( 'Meningkatkan standard mutu pendidikan yang unggul dalam menghadapi persaingan global.', 'Raise educational standards so students excel in global competition.' ),
				array( 'Menumbuhkembangkan sikap cinta tanah air dan budaya bangsa kepada segenap warga sekolah.', 'Grow love for the homeland and national culture across the whole school community.' ),
			),
		),
		'sections' => array(
			array(
				'type'    => 'cards',
				'tint'    => true,
				'cols'    => 3,
				'heading' => array( 'Program <span class="pr-heading-accent">Unggulan</span>', 'Signature <span class="pr-heading-accent">Programmes</span>' ),
				'items'   => array(
					array( 'Digital Classroom', 'Digital Classroom', 'Smart Digital Classroom adalah sistem pembelajaran berbasis media digital. Siswa dibekali Chromebook yang menggantikan buku pelajaran dan memuat seluruh materi, sehingga tidak lagi membawa buku ke sekolah.', 'Smart Digital Classroom is a learning system built on digital media. Students get a Chromebook that replaces textbooks and holds all their material, so they no longer carry books to school.', '/digital-classroom/' ),
					array( 'Career Planning', 'Career Planning', 'Perencanaan karir membimbing siswa menemukan, memilih, menetapkan dan mencapai tujuan pendidikan mereka melalui berbagai program, seminar dan lokakarya.', 'Career planning guides students to discover, choose, set and reach their educational goals through programmes, seminars and workshops.', '/programs/career_planning/' ),
					array( 'Character Building', 'Character Building', 'Program pengembangan karakter membantu siswa menemukan jati diri dalam kehidupan sosial: jasmani, rohani, mental, emosional, intelektual, dan keterampilan, sehingga menjadi Generasi Emas.', 'The character programme helps students find who they are in social life, growing physically, spiritually, mentally, emotionally, intellectually and in skills to become a Golden Generation.', '/programs/character-building/' ),
				),
			),
			array(
				'type'    => 'cta',
				'heading' => array( 'Tertarik <span class="au-career-accent">Bergabung?</span>', 'Interested in <span class="au-career-accent">Joining?</span>' ),
				'text'    => array( 'Hubungi kami untuk informasi pendaftaran dan kunjungan sekolah.', 'Contact us for admissions information and school visits.' ),
				'button'  => array( array( 'Hubungi via WhatsApp', 'Contact us on WhatsApp' ), $wa ),
			),
		),
	),

	'senior-high-school' => array(
		'eyebrow' => array( 'SEKOLAH MENENGAH ATAS', 'SENIOR HIGH SCHOOL' ),
		'title'   => array(
			'SMA Pribadi: <span class="pr-heading-accent">Berkarakter</span>, Siap Bersaing Global',
			'Pribadi Senior High: <span class="pr-heading-accent">Character-Driven</span>, Ready for the World',
		),
		'lede'    => array(
			'<strong>SMA Pribadi Depok</strong>, dengan sejarah panjang sejak 1995, telah menghasilkan ratusan alumni terbaik yang mampu bersaing di tingkat nasional dan internasional.',
			'<strong>SMA Pribadi Depok</strong> has a long history dating back to 1995 and has produced hundreds of outstanding alumni who compete nationally and internationally.',
		),
		'hero'    => array( '2023/08/Mr-Maksat-Box.jpg', array( 'Guru SMA Pribadi Depok', 'A Pribadi Senior High teacher' ) ),
		'sections' => array(
			array(
				'type'    => 'feature',
				'tint'    => true,
				'heading' => array( 'Sekilas <span class="pr-heading-accent">Tentang Kami</span>', 'About <span class="pr-heading-accent">Us</span>' ),
				'title'   => array( 'Pendidikan Akademik dan Karakter', 'Academics and Character' ),
				'paras'   => array(
					array( 'Kami meyakini bahwa pendidikan bukan hanya tentang pembentukan kapasitas akademik, tetapi juga pembangunan karakter dan moral yang kokoh. Kami membekali siswa dengan landasan moral yang tinggi, nilai-nilai etika, dan kemampuan berpikir kritis untuk menghadapi tantangan dunia modern.', 'We believe education is about more than academic capacity: it is also about building strong character and morals. We equip students with a firm moral foundation, ethical values and the critical thinking to meet the challenges of the modern world.' ),
					array( 'Guru-guru kami adalah tenaga pengajar berkualitas yang tidak hanya menguasai mata pelajaran, tetapi juga mendukung perkembangan karakter siswa dan mendorong mereka berkomunikasi dalam bahasa Inggris, kecakapan yang sangat penting di lingkungan global saat ini.', 'Our teachers are qualified educators who master their subjects, support students\' character development and encourage them to communicate in English, a vital skill in today\'s global environment.' ),
					array( 'Setiap siswa dilengkapi dengan Chromebook, dan kami menggunakan Google for Education untuk mendukung kegiatan belajar: mengakses informasi dengan cepat, berkolaborasi dengan rekan sekelas, dan mengembangkan keterampilan teknologi.', 'Every student has a Chromebook, and we use Google for Education to support learning: students reach information quickly, collaborate with classmates and build technology skills.' ),
				),
				'photo'   => array( '2023/08/Box-student-with-chromebook-1.jpg', array( 'Siswa SMA dengan Chromebook', 'Senior high student with a Chromebook' ) ),
			),
			array(
				'type'    => 'feature',
				'heading' => array( 'Integrasi <span class="pr-heading-accent">Teknologi</span>', 'Technology <span class="pr-heading-accent">Integration</span>' ),
				'title'   => array( 'Digital Classroom', 'Digital Classroom' ),
				'paras'   => array(
					array( 'Untuk mempersiapkan siswa menjadi pemimpin masa depan, SMA Pribadi Depok bergerak seiring perubahan zaman dengan mengadopsi konsep digital classroom. Siswa mengakses sumber belajar daring, pembelajaran berbasis web, dan diskusi daring yang merangsang pemikiran kritis.', 'To prepare students as future leaders, SMA Pribadi Depok moves with the times by adopting the digital classroom. Students use online resources, web-based learning and online discussions that stimulate critical thinking.' ),
					array( 'Selain Chromebook, kami menyediakan VR headset, 3D printer, dan Arduino: VR membawa siswa menjelajahi tempat jauh dan struktur kompleks, 3D printer mengubah gagasan menjadi objek nyata, dan Arduino membuka dunia pemrograman dan elektronik untuk proyek-proyek inovatif.', 'Beyond Chromebooks we provide VR headsets, 3D printers and Arduino: VR takes students to faraway places and complex structures, 3D printing turns ideas into real objects, and Arduino opens up programming and electronics for innovative projects.' ),
				),
				'photo'   => array( '2023/10/Digital-Classroom-4.jpg', array( 'Digital Classroom SMA Pribadi', 'Senior high Digital Classroom' ) ),
				'button'  => array( array( 'Pelajari lebih lanjut', 'Learn more' ), '/digital-classroom/' ),
			),
			array(
				'type'    => 'feature',
				'tint'    => true,
				'heading' => array( 'Pendidikan <span class="pr-heading-accent">Karakter</span>', 'Character <span class="pr-heading-accent">Education</span>' ),
				'title'   => array( 'Nilai yang Dihidupi, Bukan Sekadar Diajarkan', 'Values Lived, Not Just Taught' ),
				'paras'   => array(
					array( 'Di sekolah kami, pendidikan karakter menjadi inti setiap langkah pembelajaran. Siswa memahami nilai moral seperti kejujuran, integritas, kerja sama, dan tanggung jawab, yang diterapkan dalam setiap aspek kehidupan sekolah, misalnya dalam proyek berbasis proyek: berkolaborasi, menghormati pendapat orang lain, dan bekerja dengan integritas.', 'Character education is at the core of every step of learning here. Students come to understand moral values such as honesty, integrity, cooperation and responsibility, applied across school life, for example in project-based learning: collaborating, respecting others\' views and working with integrity.' ),
					array( 'Guru adalah teladan hidup nilai-nilai ini. Siswa juga didorong aktif dalam kegiatan sosial dan pelayanan masyarakat, salah satunya melalui program "Pribadi Berbagi".', 'Teachers are living examples of these values. Students are also encouraged to take part in social and community service, including through the "Pribadi Berbagi" programme.' ),
				),
				'photo'   => array( '2023/10/Character-Building-1.jpg', array( 'Pendidikan karakter SMA Pribadi', 'Senior high character education' ) ),
				'button'  => array( array( 'Pelajari lebih lanjut', 'Learn more' ), '/programs/character-building/' ),
			),
		),
	),
);
