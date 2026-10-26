<?php
/**
 * Which alumni universities have a logo, for the country cards in
 * template-parts/alumni-map.php: institution name (exactly as it is spelled in
 * data/alumni-map-data.json) => logo file, as a path under assets/img/:
 *   - university-logos/...  the files behind the homepage's scrolling logo strip.
 *                           Only read from here - that folder is edited by hand.
 *   - alumni-logos/...      logos added for the cards, downloaded from Wikimedia
 *                           Commons (via each university's Wikidata logo or a Commons
 *                           file search) and checked by eye; resized to 160px WebP.
 *
 * Hand-checked, not fuzzy-matched; several were also rejected by eye after download (a campus photo, a faculty's logo, the wrong university). A name-similarity pass proposed two wrong
 * pairs ("Institut Teknologi Indonesia" -> Universitas Indonesia, "Universiti
 * Teknologi Malaya" -> University of Malaya), which is the failure that matters
 * here: a wrong logo next to a university's name is worse than none. Only clear
 * matches and plain spelling variants are listed; every institution not listed
 * here is shown with an initials badge instead.
 *
 * Add a line here when a logo file is added to either folder.
 *
 * @package OceanWP_Child
 */

return array(
	// Indonesia.
	'Universitas Indonesia'               => 'university-logos/logo-06.png',
	'Institut Teknologi Bandung'          => 'university-logos/logo-11.png',
	'Universitas Diponegoro'              => 'university-logos/logo-40.png',
	'Universitas Brawijaya'               => 'university-logos/logo-45.png',
	'Universitas Telkom'                  => 'university-logos/logo-27.png',
	'Institut Teknologi Sepuluh Nopember' => 'university-logos/logo-41.png',
	'Universitas YARSI'                   => 'university-logos/logo-49.png',
	'Universitas Negeri Semarang'         => 'university-logos/logo-38.png',
	'Universitas Sampoerna'               => 'university-logos/logo-47.png',
	'Universitas Padjajaran'              => 'university-logos/logo-17.png', // Spelled "Padjadjaran" on the logo.
	'Institut Pertanian Bogor'            => 'university-logos/logo-37.png', // IPB University.
	'Universitas Bina Nusantara'          => 'university-logos/logo-39.png', // BINUS University.
	'Universitas Atmajaya'                => 'university-logos/logo-48.png',
	'Universitas Presiden'                => 'university-logos/logo-44.png', // President University.
	'Universitas Islam Negeri Jakarta'    => 'university-logos/logo-36.png', // UIN Syarif Hidayatullah Jakarta.

	// Australia (the data file also files The University of Auckland here).
	'Monash University'                   => 'university-logos/logo-07.png',
	'The University of Sydney'            => 'university-logos/logo-05.png',
	'The University of Western Australia' => 'university-logos/logo-23.png',
	'The University of Queensland'        => 'university-logos/logo-01.png',
	'University of Auckland'              => 'university-logos/logo-24.png',
	'Australian National University'      => 'university-logos/logo-04.png',
	'RMIT University'                     => 'university-logos/logo-33.png',
	'Curtin University'                   => 'university-logos/logo-34.png',

	// Malaysia.
	'Universiti Malaya'                   => 'university-logos/logo-30.png',
	'Universiti Kebangsaan Malaysia'      => 'university-logos/logo-21.png',
	'Asia Pacific University of Technology & Innovation' => 'university-logos/logo-18.png',
	"Taylor's University"                 => 'university-logos/logo-15.png',
	'Universiti Teknologi PETRONAS'       => 'university-logos/logo-42.png',

	// Singapore.
	'National University of Singapore'    => 'university-logos/logo-16.png',
	'Singapore Management University'     => 'university-logos/logo-32.png',

	// Hong Kong.
	'The Hong Kong Polytechnic University' => 'university-logos/logo-02.png',
	'City University of Hong Kong'        => 'university-logos/logo-22.png',
	'Chinese University of Hong Kong'     => 'university-logos/logo-09.png',

	// Japan.
	'Tokyo International University'      => 'university-logos/logo-31.png',
	'Kyoto University'                    => 'university-logos/logo-10.png',

	// Kazakhstan.
	'SDU University'                      => 'university-logos/logo-19.png',

	// Canada.
	'The University of British Columbia'  => 'university-logos/logo-13.png',
	'University of Toronto'               => 'university-logos/logo-29.png',

	// Same logo as an existing strip file, under the spelling used in the data.
	'Wageningen University'                 => 'university-logos/logo-08.png',
	'Singapore University of Design & Technology (SUTD)' => 'university-logos/logo-14.png',
	'Monash University Malaysia'            => 'university-logos/logo-07.png',
	'APU Malaysia'                          => 'university-logos/logo-18.png',

	// Downloaded from Wikimedia Commons into assets/img/alumni-logos/ (file named in each comment).
	'Universitas Al-Azhar' => 'alumni-logos/universitas-al-azhar.webp', // Commons: Al-Azhar University logo.svg
	'Swiss German University' => 'alumni-logos/swiss-german-university.webp', // Commons: The New SGU's Logo.jpg
	'Universitas Budi Luhur' => 'alumni-logos/universitas-budi-luhur.webp', // Commons: Budi Luhur University textlogo.svg
	'Universitas Andalas' => 'alumni-logos/universitas-andalas.webp', // Commons: Lambang Unand.jpg
	'Universitas Muhammadiyah Jakarta' => 'alumni-logos/universitas-muhammadiyah-jakarta.webp', // Commons: Lambang Resmi UMJ.png
	'Universitas Hasanuddin' => 'alumni-logos/universitas-hasanuddin.webp', // Commons: Lambang Resmi Universitas Hasanuddin.jpg
	'Universitas Udayana' => 'alumni-logos/universitas-udayana.webp', // Commons: Logo Universitas Udayana.png
	'Universitas Airlangga' => 'alumni-logos/universitas-airlangga.webp', // Commons: Logo-Branding-UNAIR-biru.png
	'Marmara University' => 'alumni-logos/marmara-university.webp', // Commons: Marmara University logo.svg
	'Erciyes University' => 'alumni-logos/erciyes-university.webp', // Commons: Erciyes University logo.svg
	'Ankara University' => 'alumni-logos/ankara-university.webp', // Commons: Ankara universitesi.png
	'Gaziantep University' => 'alumni-logos/gaziantep-university.webp', // Commons: Gaziantep University logo.svg
	'Gazi University' => 'alumni-logos/gazi-university.webp', // Commons: Logo Universidad Gazi.png
	'Koc University' => 'alumni-logos/koc-university.webp', // Commons: Koç University logo.svg
	'Anadolu University' => 'alumni-logos/anadolu-university.webp', // Commons: Anadolu University Logo.png
	'Akdeniz University' => 'alumni-logos/akdeniz-university.webp', // Commons: Akdeniz University logo in Turkish.png
	'Çukurova University' => 'alumni-logos/cukurova-university.webp', // Commons: Çukurova University logo.svg
	'Hacettepe University' => 'alumni-logos/hacettepe-university.webp', // Commons: Hacettepe Üniversitesi logo.svg
	'Ege University' => 'alumni-logos/ege-university.webp', // Commons: Ege University logo.svg
	'Ankara Yildirim Beyazit University' => 'alumni-logos/ankara-yildirim-beyazit-university.webp', // Commons: Ankara Yıldırım Beyazıt University logo.svg
	'Deakin University' => 'alumni-logos/deakin-university.webp', // Commons: Deakin Worldly Strip Logo.jpg
	'International Islamic University' => 'alumni-logos/international-islamic-university.webp', // Commons: Logo International Islamic University Malaysia (IIUM) New.png
	'Kyoto University of Advanced Science' => 'alumni-logos/kyoto-university-of-advanced-science.webp', // Commons: KUAS logo vector.svg
	'Martin Luther Universitat Halle-Wittenberg' => 'alumni-logos/martin-luther-universitat-halle-wittenberg.webp', // Commons: Logo MLU Halle-Wittenberg.svg
	'Karlsruhe Institute of Technology' => 'alumni-logos/karlsruhe-institute-of-technology.webp', // Commons: Logo KIT.svg
	'FH Aachen' => 'alumni-logos/fh-aachen.webp', // Commons: FHAachen-logo2010.svg
	'University of Colorado' => 'alumni-logos/university-of-colorado.webp', // Commons: Colorado univ system logo.png
	'University of California, Davis' => 'alumni-logos/university-of-california-davis.webp', // Commons: The University of California Davis.svg
	'University of Illinois' => 'alumni-logos/university-of-illinois.webp', // Commons: Uillinois wordmark.svg
	'University of Arizona' => 'alumni-logos/university-of-arizona.webp', // Commons: University of Arizona logo.svg
	'University of Texas at Austin' => 'alumni-logos/university-of-texas-at-austin.webp', // Commons: University of Texas at Austin logo.svg
	'Babes-Bolyai University' => 'alumni-logos/babes-bolyai-university.webp', // Commons: Logo Universitatea Babes-Bolyai UBB 2021.svg
	'Yonsei University' => 'alumni-logos/yonsei-university.webp', // Commons: Yonsei University logotype(ko).png
	'Universitas Trisakti' => 'alumni-logos/universitas-trisakti.webp', // Commons: Trisakti Logo.svg
	'Universitas Paramadina' => 'alumni-logos/universitas-paramadina.webp', // Commons: Logo Universitas Paramadna.png
	'Universitas Muhammadiyah Yogyakarta' => 'alumni-logos/universitas-muhammadiyah-yogyakarta.webp', // Commons: Universitas Muhammadiyah Yogyakarta Logo.png
	'Politeknik Universitas Indonesia' => 'alumni-logos/politeknik-universitas-indonesia.webp', // Commons: Logo politeknik universitas indonesia.png
	'Universitas Nasional' => 'alumni-logos/universitas-nasional.webp', // Commons: Universitas Nasional Logo.png
	'Universitas Mercu Buana' => 'alumni-logos/universitas-mercu-buana.webp', // Commons: Logo Universitas Mercu Buana.jpg
	'Universitas Tadulako' => 'alumni-logos/universitas-tadulako.webp', // Commons: Logo Universitas Tadulako Palu.png
	'Universitas Sriwijaya' => 'alumni-logos/universitas-sriwijaya.webp', // Commons: Logo Universitas Sriwijaya.png
	'Universitas Sumatera Utara' => 'alumni-logos/universitas-sumatera-utara.webp', // Commons: Logo Universitas Sumatera Utara.svg
	'Istanbul University' => 'alumni-logos/istanbul-university.webp', // Commons: Logo of Istanbul University (1933).png
	'The University of Melbourne' => 'alumni-logos/the-university-of-melbourne.webp', // Commons: MelbourneLogo.png
	'Universitas Jenderal Soedirman' => 'alumni-logos/universitas-jenderal-soedirman.webp', // Commons: Logo-UNSOED.png
	'Universitas Multimedia Nusantara' => 'alumni-logos/universitas-multimedia-nusantara.webp', // Commons: Logo UMN LowRes.jpg
	'Universiti Teknologi Malaysia' => 'alumni-logos/universiti-teknologi-malaysia.webp', // Commons: UTM-LOGO-FULL.png
	'Universitas Sultan Ageng Tirtayasa' => 'alumni-logos/universitas-sultan-ageng-tirtayasa.webp', // Commons: Logountirta.jpg
	'Universitas Negeri Jakarta' => 'alumni-logos/universitas-negeri-jakarta.webp', // Commons: Logo dan Moto baru UNJ-PTNBH.png
	'Universitas Lampung' => 'alumni-logos/universitas-lampung.webp', // Commons: Logo-unila-2018-300x300.png
	'Universitas Jember' => 'alumni-logos/universitas-jember.webp', // Commons: Logo-unej.png
	'Universitas Bakrie' => 'alumni-logos/universitas-bakrie.webp', // Commons: UB-logo.jpg
	'Universitas Islam Negeri Bandung' => 'alumni-logos/universitas-islam-negeri-bandung.webp', // Commons: Logo UIN SGD.jpg
	'University of Glasgow' => 'alumni-logos/university-of-glasgow.webp', // Commons: University of Glasgow Coat of Arms.png
	'Middle East Technical University (ODTÜ)' => 'alumni-logos/middle-east-technical-university-odt-u.webp', // Commons: Logo ODTÜ.svg

	'Sekolah Tinggi Ilmu Statistik' => 'alumni-logos/sekolah-tinggi-ilmu-statistik.webp', // Politeknik Statistika STIS, its current name.
	'Sekolah Tinggi Teknik PLN' => 'alumni-logos/sekolah-tinggi-teknik-pln.webp', // Now Institut Teknologi PLN.
	'Karadeniz University' => 'alumni-logos/karadeniz-university.webp', // Karadeniz Technical University.
	'Yildiz Teknik University' => 'alumni-logos/yildiz-teknik-university.webp',
	'Uludag University' => 'alumni-logos/uludag-university.webp',
	'Sutcu Imam University' => 'alumni-logos/sutcu-imam-university.webp',
	'Saxion Hogeschool Deventer' => 'alumni-logos/saxion-hogeschool-deventer.webp',
	'National Institute of Applied Sciences' => 'alumni-logos/national-institute-of-applied-sciences.webp',
	'Universitas Kristen Maranatha' => 'alumni-logos/universitas-kristen-maranatha.webp',
	'University of Munich' => 'alumni-logos/university-of-munich.webp',
	'Universitas Gadjah Mada' => 'alumni-logos/universitas-gadjah-mada.webp',
	'Universitas Pancasila' => 'alumni-logos/universitas-pancasila.webp',
	'Universitas Pendidikan Indonesia' => 'alumni-logos/universitas-pendidikan-indonesia.webp',
	'Universitas Mulawarman' => 'alumni-logos/universitas-mulawarman.webp',
	'Universitas Islam Indonesia' => 'alumni-logos/universitas-islam-indonesia.webp',
	'Universitas Parahyangan' => 'alumni-logos/universitas-parahyangan.webp',
	'Universitas Gunadarma' => 'alumni-logos/universitas-gunadarma.webp',
	'Sekolah Tinggi Akuntansi Negara' => 'alumni-logos/sekolah-tinggi-akuntansi-negara.webp', // STAN.
	'Izmir Institute of Technology' => 'alumni-logos/izmir-institute-of-technology.webp',
	'Bogazici University' => 'alumni-logos/bogazici-university.webp',
	'Istanbul Technical University' => 'alumni-logos/istanbul-technical-university.webp',
	'Bahcesehir University' => 'alumni-logos/bahcesehir-university.webp',
	'Victoria University' => 'alumni-logos/victoria-university.webp',
	'Universiti Utara Malaysia' => 'alumni-logos/universiti-utara-malaysia.webp',
	'Help University' => 'alumni-logos/help-university.webp', // HELP University.
	'Nanyang Technological University' => 'alumni-logos/nanyang-technological-university.webp',
	'The University of Hong Kong' => 'alumni-logos/the-university-of-hong-kong.webp',
	'Nile University of Nigeria' => 'alumni-logos/nile-university-of-nigeria.webp',
	'Uttarakhand Ayurved University' => 'alumni-logos/uttarakhand-ayurved-university.webp',
	'Universiti Teknologi Malaya' => 'alumni-logos/universiti-teknologi-malaysia.webp', // Spelled "Malaya" in the alumni data; this is UTM (Malaysia).
	'Politeknik Negeri Jakarta' => 'alumni-logos/politeknik-negeri-jakarta.webp',
	'Institut Ilmu Sosial dan Politik' => 'alumni-logos/iisip-jakarta.webp', // supplied by the school (not from Wikimedia)
	'Institut Kesenian Jakarta' => 'alumni-logos/institut-kesenian-jakarta.webp',
	'ESQ Business School' => 'alumni-logos/esq-business-school.webp',
	'Institut Teknologi Indonesia' => 'alumni-logos/institut-teknologi-indonesia.webp', // supplied by the school (not from Wikimedia)
	'LP3I' => 'alumni-logos/lp3i.webp',
	'Politeknik Negeri Semarang' => 'alumni-logos/politeknik-negeri-semarang.webp',
	'Universitas Bina Sarana Informatika' => 'alumni-logos/universitas-bina-sarana-informatika.webp',
	'Institut Teknologi Nasional' => 'alumni-logos/itenas.webp', // supplied by the school (not from Wikimedia)
	'Universitas Pertahanan Jakarta' => 'alumni-logos/universitas-pertahanan.webp', // supplied by the school (not from Wikimedia)
	'Sekolah Tinggi Teknologi Informasi I-Tech' => 'alumni-logos/stti-niit-i-tech.webp', // same school as NIIT above; supplied by the school
	'Universitas Komputer' => 'alumni-logos/universitas-komputer.webp',
	'Universitas Nurtanio' => 'alumni-logos/universitas-nurtanio.webp',
	'Universitas Jenderal Achmad Yani' => 'alumni-logos/universitas-jenderal-achmad-yani.webp',
	'Universitas Wijaya Kusuma Purwokerto' => 'alumni-logos/universitas-wijaya-kusuma-purwokerto.webp',
	'Universitas Pertamina' => 'alumni-logos/universitas-pertamina.webp',
	'Selcuk University' => 'alumni-logos/selcuk-university.webp',
	'Suleyman Demirel University' => 'alumni-logos/suleyman-demirel-university.webp',
	'Hong Kong University of Science and Technology' => 'alumni-logos/hong-kong-university-of-science-and-technology.webp',
	'University of Constanta' => 'alumni-logos/university-of-constanta.webp',
	'Tamkang University' => 'alumni-logos/tamkang-university.webp',
	'Gubkin Russian State University of Oil and Gas' => 'alumni-logos/gubkin-russian-state-university-of-oil-and-gas.webp',
	'Sekolah Tinggi Teknologi Informasi NIIT' => 'alumni-logos/stti-niit-i-tech.webp', // supplied by the school (not from Wikimedia)
	'Universitas Muhammadiyah Lampung' => 'alumni-logos/universitas-muhammadiyah-lampung.webp', // from the university's own site (uml.ac.id), via Google Images
	'Bali International Flight Academy' => 'alumni-logos/bali-international-flight-academy.webp', // from the academy's own site (baliflightacademy.com)
	'Sekolah Tinggi Pertanahan Nasional (STPN)' => 'alumni-logos/stpn.webp', // Wikipedia (id, logo file on the wiki itself): Logo STPN.png
	'Sampurna School of Business' => 'alumni-logos/sampoerna-university.webp', // Sampoerna University logo (the business school is part of it), Wikipedia (id): Logo USBI.jpg
	'Indonesian Banking School' => 'alumni-logos/indonesia-banking-school.webp', // supplied by the school (not from Wikimedia)
	'London School of Public Relations' => 'alumni-logos/london-school-of-public-relations.webp', // supplied by the school (not from Wikimedia)
	'Sekolah Tinggi Ekonomi, Keuangan & Perbankan Indonesia' => 'alumni-logos/stie-perbanas-indonesia.webp', // supplied by the school (not from Wikimedia)
	'National Hotel Institute' => 'alumni-logos/national-hotel-institute.webp', // supplied by the school (not from Wikimedia)
	'Universitas Pembangunan Nasional' => 'alumni-logos/universitas-pembangunan-nasional.webp', // Commons: Logo UPNVJ.png
	'Universitas Prasetya Mulya' => 'alumni-logos/universitas-prasetya-mulya.webp', // Wikipedia (id, logo file on the wiki itself): Logo_Universitas Prasetiya Mulya.png
	'Universitas Tama Jagakarsa' => 'alumni-logos/universitas-tama-jagakarsa.webp', // Wikipedia (id, logo file on the wiki itself): Logo Universitas Tama Jagakarsa.png
	'STIE Perbanas' => 'alumni-logos/stie-perbanas.webp', // Wikipedia (id, logo file on the wiki itself): Logo Perbanas Institute horizontal.png
	'Sekolah Tinggi Ilmu Ekonomi Perbanas' => 'alumni-logos/stie-perbanas.webp', // same school as STIE Perbanas
	'Sekolah Tinggi Transportasi Darat' => 'alumni-logos/sekolah-tinggi-transportasi-darat.webp', // Wikipedia (id, logo file on the wiki itself): Logo PTDI-STTD.png
	'Universitas 17 Agustus' => 'alumni-logos/universitas-17-agustus.webp', // Wikipedia (id, logo file on the wiki itself): Logo Untag Jakarta.jpg
	'Universitas Sebelas Maret' => 'alumni-logos/universitas-sebelas-maret.webp', // Wikipedia (id, logo file on the wiki itself): UNS LOGO.png
	'Fatih University' => 'alumni-logos/fatih-university.webp', // Wikipedia (en, logo file on the wiki itself): Fatih universitesi.png
	'Moldova State University' => 'alumni-logos/moldova-state-university.webp', // Commons: Stema USM.svg
);
