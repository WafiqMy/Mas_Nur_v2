-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 28 Apr 2026 pada 15.28
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `u137138991_masnur`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `akun`
--

CREATE TABLE `akun` (
  `username` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `email` varchar(50) NOT NULL,
  `no_telpon` varchar(15) NOT NULL,
  `gambar` varchar(50) DEFAULT NULL,
  `nama` varchar(50) NOT NULL,
  `otp` varchar(10) DEFAULT NULL,
  `otp_expired` datetime DEFAULT NULL,
  `role` varchar(10) NOT NULL DEFAULT 'user',
  `status` enum('pending','aktif') DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `akun`
--

INSERT INTO `akun` (`username`, `password`, `email`, `no_telpon`, `gambar`, `nama`, `otp`, `otp_expired`, `role`, `status`) VALUES
('Admin', '$2y$10$1OGsriRpzGvdH45vHJhCf.beCMGTRGyAkIaFpCzMw4Hg.yXecetzS', 'wafiqmarzuq@gmail.com', '08551549616', '1764727399_BRT_1763013585_9995.png', 'Wafiq Marzuq', NULL, NULL, 'admin', 'aktif'),
('Yo', '$2y$10$21f7ypdkt7tYD7rKZaZIy.de3dZ87ppJWm54eXhe89x97uPQblGtK', 'vanilanabati70@gmail.com', 'abcd1234', NULL, 'Yo', '921469', '2026-01-31 15:02:57', 'user', 'aktif'),
('bilqis_', '$2y$10$vTkylIzyGHJ0Md7lJtn.ieB.1kjG6Qw714NpeO.3VLMwOWX7PZwM2', 'ervaniawahyuu@gmail.com', '0895366436487', NULL, 'Bilqis Azzahra', NULL, NULL, 'user', 'aktif'),
('julaikha', '$2y$10$ilCc2AKMgzWcZ/D4rrioCOuOMC8b0j9mRzX/QJ05rwk6.E5H0u1Dy', 'nonapeach127@gmail.com', '089853234567', NULL, 'julaikha', NULL, NULL, 'user', 'aktif'),
('laras', 'dorr12345', 'laras@gmali.com', '098789765', NULL, 'laras', NULL, NULL, 'user', 'pending'),
('mandiana321', '$2y$10$.xUaRL8CwOFemQvcVZpn4u/IkckYFnO02LdQSef3juz5RE0lCyCaS', 'rebdi@sekolah', '08782641244', NULL, 'Fiqr', '499906', '2025-12-07 05:07:34', 'user', 'pending'),
('masjay', '$2y$10$5tYn.UJstOK2iEKU3TSnLO0zCJjl.20hvwr2XcLEpA7eAWkbWIWFO', 'masjay2022@gmail.com', '085730938086', '1766753756_cmd.shtml', 'masjay', NULL, NULL, 'user', 'aktif'),
('nabil12', '$2y$10$0WbHlDSdCCYve24WgO.9J.v7GStccffQK1qX1ffuiq/iBhjJSg2l6', 'yayiy2186@gmail.com', '098765764354', NULL, 'nabilaya', NULL, NULL, 'user', 'aktif'),
('nurman', '$2y$10$wo7ZLPkzh3p0OF5.V44WNOHfbCQXnwbbz/bCV20k/FjaZ7iAFpJtm', 'elsaare14@gmail.com', '0898532345', '1764766209_BRT_1763026357_7094 (1).png', 'nurman1', NULL, NULL, 'user', 'aktif'),
('shilsyy', '$2y$10$z7MFIholDqTNYD1r2/xcfOpMb4Xbv1OCc1irIuF3LN6NxndMIeoum', 'trsnarasika@gmail.com', '987653267819038', NULL, 'shilsy', NULL, NULL, 'user', 'aktif'),
('sindyasik', '$2y$10$g9uc0vVfrUPnOkC24yRiBuSu15gmnlmTzJ5a8mSJplKqgMiLbez.2', 'elsaar46@gmail.com', '089853234567', '1764724533_download.jpeg', 'sindy', '285581', '2025-12-03 05:25:32', 'user', 'aktif'),
('yogys', '$2y$10$z2V2JnH9IcwioGgVdIyN6eLWpWqA6E8dcaXx8Sk.qeXs3xBEU22NS', 'elsaaja694@gmail.com', '08985323456', '1764782070_BRT_1763026357_7094.png', 'yogy surya', NULL, NULL, 'user', 'aktif');

-- --------------------------------------------------------

--
-- Struktur dari tabel `berita`
--

CREATE TABLE `berita` (
  `id_berita` int(11) NOT NULL,
  `judul_berita` varchar(50) NOT NULL,
  `isi_berita` varchar(12000) NOT NULL,
  `tanggal_berita` datetime NOT NULL DEFAULT current_timestamp(),
  `foto_berita` varchar(50) DEFAULT NULL,
  `username` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT 'Admin'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `berita`
--

INSERT INTO `berita` (`id_berita`, `judul_berita`, `isi_berita`, `tanggal_berita`, `foto_berita`, `username`) VALUES
(17, 'Kegiatan Jumat Berkah di Masjid Nurul Huda', 'Masjid Nurul Huda kembali mengadakan program rutin Jumat Berkah dengan membagikan 100 paket nasi kotak kepada jamaah dan warga sekitar.', '2025-11-07 00:00:00', 'jumat_berkah.jpg', 'Admin'),
(19, 'Kerja Bakti: Persiapan Musim Hujan', 'Seluruh jamaah diundang untuk berpartisipasi dalam kerja bakti membersihkan saluran air dan area masjid pada hari Minggu pagi, 12 November 2025.', '2025-11-09 00:00:00', 'kerja_bakti.jpg', 'Admin'),
(184, 'kajian rutin senin', '<p>bis</p>', '2025-11-16 13:05:10', 'BRT_1763283821_2872.png', 'Admin'),
(190, 'kajian rutin 1', '<p>Ribuan warga antusias menyambut peresmian Masjid Raya Nurul Iman yang megah diresmikan hari&nbsp;<br>ini, Kamis (13/11). Masjid yang berdiri di atas lahan seluas 5.000 meter persegi di kawasan Pusat Kota&nbsp;<br>Jakarta ini diharapkan tidak hanya menjadi tempat ibadah, tetapi juga Pusat kegiatan sosial dan&nbsp;<br>pembinaan keumatan.&nbsp;<br>Peresmian dilakukan secara langsung oleh Penjabat (Pj) Gubernur DKI Jakarta, Dr. Ir. H. Ahmad Fauzi,&nbsp;<br>M.Si„ yang didampingi oleh Ketua Dewan Kemakmuran Masjid (DKM) Nurul Iman, Bapak Rahmat&nbsp;<br>Hidayat.&nbsp;<br>Desain Modern dengan Sentuhan Tradisional&nbsp;<br>Masjid Raya Nurul Iman menampilkan arsitektur modern minimalis dengan kubah utama berwarna&nbsp;<br>biru safir, namun tetap memasukkan unsur ukiran tradisional khas Nusantara pada bagian mihrab&nbsp;<br>dan menara setinggi 45 meter. Bangunan ini mampu menampung hingga 4.000 jemaah di dalam dan&nbsp;<br>luar ruangan.&nbsp;<br>\"Pembangunan masjid ini telah direncanakan sejak lima tahun lalu dan murni didanai dari&nbsp;<br>sumbangan swadaya masyarakat dan donatur. Ini adalah bukti nyata persatuan dan gotong royong&nbsp;<br>warga, \' ujar Rahmat Hidayat dalam sambutannya.&nbsp;<br>Fokus pada Pendidikan dan Sosial&nbsp;<br>Dalam sambutannya, Pj Gubernur Ahmad Fauzi menyampaikan apresiasi tinggi terhadap komitmen&nbsp;<br>warga dan DKM. Beliau berharap Masjid Nurul Iman dapat menjalankan fungsi integral bagi&nbsp;<br>masyarakat.&nbsp;<br>\"Masjid ini harus menjadi lebih dari sekadar tempat salat. Saya berharap Nurul Iman menjadi \'Pusat&nbsp;<br>Peradaban\' yang aktif menyelenggarakan program pendidikan A1-Qur\'an, pelathan keterampilan bagi&nbsp;<br>pemuda, serta menjadi posko bantuan sosial bagi warga kurang mampu di sekitarnya, \' tegas Pj&nbsp;<br>Gubernur Fauzi.&nbsp;<br>Sebagai kegiatan awal, DKM Nurul Iman akan segera meluncurkan program \'Sekolah Subuh\', yaitu&nbsp;<br>kelas kajian rut-in setiap Sabtu pagi yang terbuka untuk umum dan menghadirkan ulama-ulama&nbsp;<br>terkemuka.&nbsp;</p><p><br>&nbsp;</p><p>o&nbsp;<br>Notifikasi&nbsp;<br>Notifikasi&nbsp;<br>Permintaan Pemesanan Gedung&nbsp;<br>Lihat&nbsp;<br>Atas Nama: Racka Bintang&nbsp;<br>Permintaan Alat&nbsp;<br>Lihat&nbsp;<br>Atas Nama: Yogi Surya Wijaya&nbsp;<br>Permintaan Alat&nbsp;<br>Lihat&nbsp;<br>Atas Nama: Larasati Safana&nbsp;<br>Acara&nbsp;<br>Informasi Masjid&nbsp;<br>Eerita&nbsp;<br>&nbsp;</p>', '2025-11-24 03:41:55', 'BRT_1763955672_7852.png', 'Admin'),
(221, 'kajian rutin', 'g7cv8g8g', '2025-12-01 00:00:00', 'berita_1764594651_6e105488.jpg', 'Admin'),
(224, 'Kegiatan Jumat Berkah di Masjid Nurul Huda Tanjung', '<p><strong>Tanjunganom, Nganjuk – Jumat, 3 Desember 2025</strong><br>Suasana penuh kebersamaan dan kepedulian tampak di Masjid Nurul Huda, Tanjunganom, Nganjuk, saat jamaah dan warga sekitar melaksanakan kegiatan Jumat Berkah. Program ini menjadi agenda rutin yang bertujuan menumbuhkan semangat berbagi dan mempererat tali silaturahmi antarwarga.<br>&nbsp;<strong>Rangkaian Kegiatan:</strong><br>• &nbsp;&nbsp;&nbsp;&nbsp;Setelah salat Jumat, panitia masjid bersama para relawan membagikan paket nasi kotak dan minuman kepada jamaah serta masyarakat sekitar.<br>• &nbsp;&nbsp;&nbsp;&nbsp;Anak-anak, pedagang kecil, hingga pengguna jalan yang melintas turut menerima manfaat dari kegiatan ini.<br>• &nbsp;&nbsp;&nbsp;&nbsp;Selain pembagian makanan, ada juga penggalangan dana sukarela yang digunakan untuk mendukung kegiatan sosial masjid, seperti santunan anak yatim dan bantuan warga kurang mampu.<br><strong>Pesan Kebersamaan:</strong><br>Takmir Masjid Nurul Huda menyampaikan bahwa kegiatan ini bukan sekadar berbagi makanan, tetapi juga menanamkan nilai kepedulian sosial. “Semoga kegiatan Jumat Berkah ini menjadi ladang amal dan memperkuat ukhuwah Islamiyah di lingkungan kita,” ujar salah satu pengurus masjid.</p><p><strong>Antusiasme Warga:</strong><br>Warga sekitar menyambut kegiatan ini dengan penuh syukur. Banyak yang berharap program semacam ini terus berlanjut dan semakin berkembang, sehingga manfaatnya bisa dirasakan lebih luas.</p>', '2025-12-03 10:56:26', 'BRT_1764734186_5255.jpg', 'Admin'),
(225, 'kajian rutin', '<p><br><strong>Ribuan</strong> warga antusias menyambut peresmian Masjid Raya Nurul Iman yang megah diresmikan hari ini, Kamis (13/11). Masjid yang berdiri di atas lahan seluas 5.000 meter persegi di kawasan Pusat Kota Jakarta ini diharapkan tidak hanya menjadi tempat ibadah, tetapi juga pusat kegiatan sosial dan pembinaan keumatan.<br>Peresmian dilakukan secara langsung oleh Penjabat (Pj) Gubernur DKI Jakarta, Dr. Ir. H. Ahmad Fauzi, M.Si., yang didampingi oleh Ketua Dewan Kemakmuran Masjid (DKM) Nurul Iman, Bapak Rahmat Hidayat.<br>Desain Modern dengan Sentuhan Tradisional<br>Masjid Raya Nurul Iman menampilkan arsitektur modern minimalis dengan kubah utama berwarna biru safir, namun tetap memasukkan unsur ukiran tradisional khas Nusantara pada bagian mihrab dan menara setinggi 45 meter. Bangunan ini mampu menampung hingga 4.000 jemaah di dalam dan luar ruangan.<br>\"Pembangunan masjid ini telah direncanakan sejak lima tahun lalu dan murni didanai dari sumbangan swadaya masyarakat dan donatur. Ini adalah bukti nyata persatuan dan gotong royong warga,\" ujar Rahmat Hidayat dalam sambutannya.<br>Fokus pada Pendidikan dan Sosial<br>Dalam sambutannya, Pj Gubernur Ahmad Fauzi menyampaikan apresiasi tinggi terhadap komitmen warga dan DKM. Beliau berharap Masjid Nurul Iman dapat menjalankan fungsi integral bagi masyarakat.<br>\"Masjid ini harus menjadi lebih dari sekadar tempat salat. Saya berharap Nurul Iman menjadi \'Pusat Peradaban\' yang aktif menyelenggarakan program pendidikan Al-Qur\'an, pelatihan keterampilan bagi pemuda, serta menjadi posko bantuan sosial bagi warga kurang mampu di sekitarnya,\" tegas Pj Gubernur Fauzi.<br>Sebagai kegiatan awal, DKM Nurul Iman akan segera meluncurkan program \'Sekolah Subuh\', yaitu kelas kajian rutin setiap Sabtu pagi yang terbuka untuk umum dan menghadirkan ulama-ulama terkemuka.<br>&nbsp;</p>', '2026-04-24 08:42:13', 'BRT_1764757737_9232.jpg', 'Admin'),
(226, 'Gelar seni budaya', '<p><br>Ribuan warga antusias menyambut peresmian <strong>Masjid Raya Nurul Huda</strong> yang megah diresmikan hari ini, Kamis (13/11). Masjid yang berdiri di atas lahan seluas 5.000 meter persegi di kawasan Pusat Kota Jakarta ini diharapkan tidak hanya menjadi tempat ibadah, tetapi juga pusat kegiatan sosial dan pembinaan keumatan.<br>Peresmian dilakukan secara langsung oleh Penjabat (Pj) Gubernur DKI Jakarta, Dr. Ir. H. Ahmad Fauzi, M.Si., yang didampingi oleh Ketua Dewan Kemakmuran Masjid (DKM) Nurul Iman, Bapak Rahmat Hidayat.<br>Desain Modern dengan Sentuhan Tradisional<br>Masjid Raya Nurul Iman menampilkan arsitektur modern minimalis dengan kubah utama berwarna biru safir, namun tetap memasukkan unsur ukiran tradisional khas Nusantara pada bagian mihrab dan menara setinggi 45 meter. Bangunan ini mampu menampung hingga 4.000 jemaah di dalam dan luar ruangan.<br>\"Pembangunan masjid ini telah direncanakan sejak lima tahun lalu dan murni didanai dari sumbangan swadaya masyarakat dan donatur. Ini adalah bukti nyata persatuan dan gotong royong warga,\" ujar Rahmat Hidayat dalam sambutannya.<br>Fokus pada Pendidikan dan Sosial<br>Dalam sambutannya, Pj Gubernur Ahmad Fauzi menyampaikan apresiasi tinggi terhadap komitmen warga dan DKM. Beliau berharap Masjid Nurul Iman dapat menjalankan fungsi integral bagi masyarakat.<br>\"Masjid ini harus menjadi lebih dari sekadar tempat salat. Saya berharap Nurul Iman menjadi \'Pusat Peradaban\' yang aktif menyelenggarakan program pendidikan Al-Qur\'an, pelatihan keterampilan bagi pemuda, serta menjadi posko bantuan sosial bagi warga kurang mampu di sekitarnya,\" tegas Pj Gubernur Fauzi.<br>Sebagai kegiatan awal, DKM Nurul Iman akan segera meluncurkan program \'Sekolah Subuh\', yaitu kelas kajian rutin setiap Sabtu pagi yang terbuka untuk umum dan menghadirkan ulama-ulama terkemuka.<br>&nbsp;</p>', '2025-12-04 00:19:57', 'berita_1764782356_9505.png', 'Admin'),
(228, 'Buka Bersama', 'Buka Bersama Di Halaman Masjid', '2026-04-27 00:00:00', 'berita_1777253068_4261.png', 'Admin');

-- --------------------------------------------------------

--
-- Struktur dari tabel `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `event`
--

CREATE TABLE `event` (
  `id_event` int(11) NOT NULL,
  `nama_event` varchar(50) NOT NULL,
  `tanggal_event` datetime NOT NULL,
  `deskripsi_event` varchar(1000) NOT NULL,
  `lokasi_event` varchar(50) NOT NULL,
  `gambar_event` varchar(50) NOT NULL,
  `dokumentasi` text DEFAULT NULL,
  `video_urls` text DEFAULT NULL,
  `username` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL DEFAULT 'Admin'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `event`
--

INSERT INTO `event` (`id_event`, `nama_event`, `tanggal_event`, `deskripsi_event`, `lokasi_event`, `gambar_event`, `dokumentasi`, `video_urls`, `username`) VALUES
(3, 'Rutinan Ngaji Ahad Wage', '2025-11-16 00:00:00', '', '', '', NULL, NULL, 'Admin'),
(6, 'Idul Adha', '2025-06-07 00:00:00', '', '', '', NULL, NULL, 'Admin'),
(10, 'Ngaji Online', '2025-09-15 00:00:00', '', '', '', NULL, NULL, 'Admin'),
(18, 'buka bersama', '2025-11-26 00:00:00', 'ayo mokel', 'serambi masjid', 'main_1764029667_822.png', 'https://masnurhudanganjuk.pbltifnganjuk.com/API/uploads/kegiatan/doc_edit_0_1764403673_766.jpg,doc_edit_0_1769608359_830.png', 'https://www.youtube.com/live/C9Ml9JxX69g?si=w6TeKRRgvW9S2lJY', 'Admin'),
(26, 'bukber (buka bersama)', '2025-11-26 00:00:00', 'buka bersama', 'Tanjunganom', 'main_edit_1764184976_143.jpg', 'doc_edit_0_1764184976_170.png,doc_edit_1_1764184976_121.png,doc_edit_2_1764184976_705.png', 'https://www.youtube.com/live/o4-cQTYRKo0?si=l7WsEvEWBGd_Bjkg', 'Admin'),
(47, '7ff', '2025-09-12 00:00:00', 'f', 'c7', 'default.jpg', '', '', 'Admin'),
(49, 'pengajian rutin', '2025-12-04 00:00:00', 'pengajian rutin hari ahad pagi', 'serambi masjid', 'main_1764782528_799.png', 'doc_edit_0_1764785414_815.jpg', 'https://youtu.be/nloHncpSBRs?si=ZzE6c_3gST-QlBHL', 'Admin');

-- --------------------------------------------------------

--
-- Struktur dari tabel `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `infaq_dana`
--

CREATE TABLE `infaq_dana` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `judul` varchar(255) NOT NULL,
  `jumlah` decimal(15,2) NOT NULL,
  `keterangan` text DEFAULT NULL,
  `tanggal` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `infaq_rekening`
--

CREATE TABLE `infaq_rekening` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama_bank` varchar(255) NOT NULL,
  `nomor_rekening` varchar(255) NOT NULL,
  `nama_pemilik` varchar(255) NOT NULL,
  `qris_image` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `persewaan`
--

CREATE TABLE `persewaan` (
  `id_persewaan` int(11) NOT NULL,
  `Jenis` varchar(50) NOT NULL,
  `nama_barang` varchar(50) NOT NULL,
  `gambar` varchar(50) DEFAULT NULL,
  `harga` int(11) NOT NULL,
  `jumlah` int(11) NOT NULL,
  `deskripsi` varchar(500) DEFAULT NULL,
  `spesifikasi` varchar(100) DEFAULT NULL,
  `fasilitas` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `persewaan`
--

INSERT INTO `persewaan` (`id_persewaan`, `Jenis`, `nama_barang`, `gambar`, `harga`, `jumlah`, `deskripsi`, `spesifikasi`, `fasilitas`) VALUES
(16, 'Alat Musik', 'Mic', 'barang_1764723070_1613.jpg', 45000, 8, '', '', ''),
(23, 'Gedung', 'paket C+', 'barang_1764722815_3710.jpg', 20000000, 1, '', '', ''),
(30, 'Alat Musik', 'paket sound', 'barang_1764723086_9193.jpg', 12000000, 1, '', '', ''),
(39, 'Alat Musik', 'Banjari', 'barang_1764728575_9825.jpg', 50000, 5, '', '', ''),
(46, 'gedung', 'paket a+', 'barang_1764763935_1362.jpg', 1000000, 1, 'paket akad', 'luas 12x12\r\nkapasitas 20 orang', 'ac 2 unit\r\nmeja akad\r\npulpen\r\n'),
(47, 'alat multimedia', 'camera', 'barang_1764764491_6034.jpg', 100000, 2, 'Nikon D750 adalah kamera DSLR full-frame (FX-format) yang dirancang untuk fotografer dan videografer yang menginginkan kualitas tinggi dalam bodi yang tangguh dan fleksibel.\r\nLensa AF-S NIKKOR 24-120mm f/4G ED VR adalah lensa zoom serbaguna, ideal untuk berbagai situasi mulai dari landscape hingga potret, dengan stabilisasi gambar (VR) untuk hasil tajam.', 'Video: Full HD 1080p hingga 60 fps', 'baterai cadangan\r\nlensa tambahan');

-- --------------------------------------------------------

--
-- Struktur dari tabel `profil_masjid`
--

CREATE TABLE `profil_masjid` (
  `Id_profil_masjid` int(11) NOT NULL,
  `gambar_sejarah_masjid` varchar(50) DEFAULT NULL,
  `gambar_struktur_organisasi` varchar(50) DEFAULT NULL,
  `gambar_struktur_remas` varchar(50) DEFAULT NULL,
  `judul_sejarah` varchar(50) DEFAULT NULL,
  `deskripsi_sejarah` varchar(13000) DEFAULT NULL,
  `username` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL DEFAULT 'Admin'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `profil_masjid`
--

INSERT INTO `profil_masjid` (`Id_profil_masjid`, `gambar_sejarah_masjid`, `gambar_struktur_organisasi`, `gambar_struktur_remas`, `judul_sejarah`, `deskripsi_sejarah`, `username`) VALUES
(1, 'sejarah_masjid_1764764628_9294.jpg', 'struk_pengurus_1764688921_4077.jpg', 'struk_remas_1764782285_2915.png', 'Profil Masjid Nurul Huda Tanjunganom', 'Di sebuah kota yang tidak tercantum pada peta, berdirilah sebuah kawasan yang tampak biasa di mata pertama, namun menyimpan cerita yang merambat di antara dinding-dinding bangunannya. Kota itu selalu diselimuti aroma kayu basah setiap pagi, seolah hujan semalam meninggalkan pesan yang belum selesai dituturkan. Orang-orang di sana menjalani hari dengan langkah teratur, namun tiap langkah mengandung kisah yang berbeda, kisah yang merentang jauh dari apa yang tampak di permukaan.</p><p>Di tengah kota terdapat sebuah taman luas dengan pepohonan tinggi yang seakan menyentuh langit. Daun-daunnya berwarna hijau tua di bagian atas dan kekuningan di bagian bawah, menciptakan ilusi gradasi lembut ketika sinar matahari pagi menyelusup di antara celah ranting. Bangku-bangku taman terbuat dari kayu cokelat kemerahan, sebagian sudah mulai memudar, tetapi tetap kokoh melayani siapa saja yang membutuhkan waktu untuk berhenti sejenak. Di sanalah banyak orang berkumpul, entah untuk berbincang, membaca buku, atau sekadar membiarkan pikiran mereka mengembara.</p><p>Di ujung jalan yang membentang dari sisi taman, terdapat sebuah bangunan tua dengan cat krem yang mulai mengelupas. Bangunan itu dulunya merupakan perpustakaan yang terkenal karena koleksi buku langkanya. Meski kini tidak lagi seramai dulu, aroma khas kertas tua masih memenuhi ruangannya. Bau itu bercampur dengan wangi teh dari sebuah sudut kecil yang dijadikan tempat membaca. Meja-meja kayu di ruangan tersebut masih mempertahankan ukiran halus di setiap sudutnya, sementara jendela-jendela besar mempersilakan cahaya masuk dengan cara yang sangat elegan.</p><p>Setiap sore, angin berembus membawa suara langkah-langkah pejalan kaki yang melintasi trotoar batu. Suara itu bergema samar, berpadu dengan suara gesekan dedaunan yang menari di udara. Pedagang kecil mulai membuka lapak, menata barang-barang mereka dengan ketelitian yang menunjukkan kebiasaan bertahun-tahun. Ada yang menjual kerajinan tangan dari serat alam, ada yang menawarkan makanan ringan yang aromanya menggoda siapa pun yang lewat.</p><p>Mengabaikan hiruk pikuk kota, sungai kecil di bagian selatan mengalir dengan tenang. Airnya jernih, memantulkan warna langit yang berubah setiap jam. Pada waktu-waktu tertentu, permukaan air memantulkan warna keemasan, sehingga terlihat seperti hamparan kain sutra yang dijahit dengan benang cahaya. Di tepi sungai terdapat jalan setapak kecil yang selalu dipenuhi orang-orang yang ingin menikmati ketenangan, entah sambil berjalan sendirian atau berbincang pelan dengan teman seperjalanan.</p><p>Pada malam hari, suasana kota berubah drastis. Lampu-lampu jalan menyala lembut, tidak terlalu terang namun cukup untuk menuntun langkah siapa saja. Bangunan-bangunan tampak menjulang sebagai siluet gelap yang berdiri kontras dengan cahaya kuning hangat dari jendela rumah penduduk. Dari kejauhan terdengar suara musik lembut dari sebuah kafe yang tetap buka hingga larut malam. Musik itu tidak pernah keras, hanya cukup untuk menciptakan atmosfer hangat bagi para pengunjung.</p><p>Di dalam kafe tersebut, barista mengenakan celemek hitam dan kemeja panjang berwarna abu-abu. Ia menyapa setiap pelanggan dengan senyum ramah yang menenangkan. Aroma kopi yang baru digiling menyebar memenuhi ruangan, berpadu dengan wangi roti panggang yang baru keluar dari oven. Dinding kafe dipenuhi lukisan-lukisan kecil bergaya minimalis, sebagian menggambarkan perbukitan, sebagian lainnya hanya pola abstrak yang menghadirkan nuansa tenang. Di salah satu sudut terdapat rak kecil berisi buku-buku, majalah tua, dan beberapa catatan perjalanan yang ditinggalkan pengunjung.</p><p>Sementara itu, di wilayah utara kota, terdapat sebuah jalan yang dipenuhi bangunan modern dengan kaca besar yang memantulkan cahaya. Malam membuat semuanya tampak seperti potongan kristal yang dipajang rapi. Orang-orang yang melintas terlihat dari balik kaca sebagai siluet yang bergerak perlahan. Meskipun kawasan ini lebih ramai dan lebih bising, tetap ada kehangatan yang tidak dapat dijelaskan. Suara deru kendaraan berpadu harmonis dengan tawa orang-orang yang sedang menikmati waktu mereka.</p><p>Beberapa langkah dari sana, terdapat sebuah ladang kecil milik seorang pria tua yang memiliki hobi bercocok tanam. Tidak banyak yang tahu bahwa ladang itu menghasilkan sayuran segar yang menjadi bahan utama beberapa restoran di kota. Pria tua itu merawat ladangnya dengan penuh perhatian, berbicara kepada tanaman seolah-olah mereka teman lamanya. Tanaman-tanaman itu tumbuh subur, seakan memahami bahwa mereka dijaga dengan cinta.</p><p>Setiap hari, saat matahari terbenam, cahaya jingga menyapu ladang dan memantulkan warna hangat pada permukaan tanah yang lembut. Pada momen itu, kota terasa berhenti sejenak. Semua orang memperlambat langkah mereka, menikmati pemandangan langit yang berubah dari oranye menjadi ungu kemudian biru gelap. Angin membawa hawa sejuk dan aroma tanah basah, menciptakan suasana damai yang tidak bisa ditemukan di tempat lain.</p><p>Waktu terus berjalan, tetapi kota itu tetap hidup dengan ritme yang sama. Ia tumbuh perlahan, berubah sedikit demi sedikit, namun selalu mempertahankan karakter uniknya. Setiap sudut kota memiliki cerita yang menunggu untuk ditemukan. Setiap orang yang datang membawa kisah baru dan pulang dengan pengalaman yang melekat di ingatan mereka. Kota itu, meskipun sederhana, memiliki cara untuk membuat siapa pun merasa diterima dan diingat. Masjid Nurul Huda</p>', 'Admin');

-- --------------------------------------------------------

--
-- Struktur dari tabel `reservasi`
--

CREATE TABLE `reservasi` (
  `id_reservasi` int(11) NOT NULL,
  `id_persewaan` int(11) NOT NULL,
  `nama_pengguna` varchar(50) NOT NULL,
  `no_tlp_pengguna` varchar(50) NOT NULL,
  `email_pengguna` varchar(50) NOT NULL,
  `nama_barang` varchar(50) NOT NULL,
  `jenis` varchar(50) NOT NULL,
  `total_peminjaman` int(11) NOT NULL,
  `total_harga` int(11) NOT NULL,
  `status_reservasi` varchar(50) NOT NULL DEFAULT 'Menunggu',
  `tanggal_mulai_reservasi` date NOT NULL,
  `tanggal_selesai_reservasi` date NOT NULL,
  `keperluan` varchar(50) NOT NULL,
  `username` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL DEFAULT 'Admin',
  `notes` text DEFAULT NULL,
  `tanggal_pengajuan` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `reservasi`
--

INSERT INTO `reservasi` (`id_reservasi`, `id_persewaan`, `nama_pengguna`, `no_tlp_pengguna`, `email_pengguna`, `nama_barang`, `jenis`, `total_peminjaman`, `total_harga`, `status_reservasi`, `tanggal_mulai_reservasi`, `tanggal_selesai_reservasi`, `keperluan`, `username`, `notes`, `tanggal_pengajuan`) VALUES
(21, 23, 'jerry', '081234567890', 'jerrytom@gmail.com', 'paket C+', 'Gedung', 1, 20000000, 'Disetujui', '2025-11-30', '2025-11-30', 'ngaji', 'guest', NULL, '2025-11-30 22:46:56'),
(22, 23, 'jerry', '081234567890', 'jerrytom@gmail.com', 'paket C+', 'Gedung', 1, 20000000, 'Ditolak', '2025-11-30', '2025-11-30', 'ngaji', 'guest', 'halah', '2025-11-30 22:46:56'),
(23, 23, 'nurman', '08976543', '', 'paket C+', 'Gedung', 1, 20000000, 'Ditolak', '2025-12-02', '2025-12-02', 'PENGAJIAN', 'nurman', 'yyy', '2025-11-30 22:46:56'),
(26, 23, 'nurman', '085678902', '-', 'paket C+', 'Gedung', 1, 20000000, 'Disetujui', '2025-12-02', '2025-12-02', 'ppp', 'nurman', '', '2025-12-01 09:02:48'),
(27, 23, 'nurman', '089765678', '-', 'paket C+', 'Gedung', 1, 20000000, 'Ditolak', '2025-12-02', '2025-12-02', 'akad', 'nurman', 'yyy', '2025-12-01 11:04:53'),
(35, 23, 'nurman1', '081222555', '-', 'paket C+', 'Gedung', 1, 40000000, 'Disetujui', '2025-12-05', '2025-12-06', 'akad', 'nurman', 'Gedung tersedia', '2025-12-03 11:21:49'),
(36, 23, 'yogy surya', '09812563436', '-', 'paket C+', 'Gedung', 1, 20000000, 'Ditolak', '2025-12-05', '2025-12-05', 'akad', 'yogys', 'tidak ada konfirmasi', '2025-12-04 00:13:01'),
(37, 46, 'nurman1', '0867273788', '-', 'paket a+', 'gedung', 1, 1000000, 'Ditolak', '2025-12-05', '2025-12-05', 'akad', 'nurman', 'bukti tidak di terima', '2025-12-04 07:59:26'),
(38, 47, 'yogy surya', '089876542', '-', 'camera', 'alat multimedia', 1, 200000, 'Disetujui', '2025-12-04', '2025-12-05', 'live dokumentasi', 'yogys', NULL, '2025-12-04 08:25:32'),
(39, 46, 'nurman1', '089654467', '-', 'paket a+', 'gedung', 1, 3000000, 'Disetujui', '2026-01-29', '2026-01-31', 'ppp', 'nurman', NULL, '2026-01-28 21:15:05'),
(40, 46, 'julaikha', '087326787890', '-', 'paket a+', 'gedung', 1, 2000000, 'Disetujui', '2026-02-12', '2026-02-13', 'sholawat', 'julaikha', NULL, '2026-02-12 08:52:06'),
(41, 46, 'shilsy', '8765678657555556', '-', 'paket a+', 'gedung', 1, 4000000, 'Menunggu', '2026-04-02', '2026-04-05', 'penj', 'shilsyy', NULL, '2026-03-31 15:21:30'),
(42, 23, 'Wafiq Marzuq', '08551549616', 'wafiqmarzuq@gmail.com', 'paket C+', 'Gedung', 1, 40000000, 'Menunggu', '2026-04-29', '2026-04-30', 'Akad Nikah', 'Admin', NULL, '2026-04-27 08:40:25');

-- --------------------------------------------------------

--
-- Struktur dari tabel `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `akun`
--
ALTER TABLE `akun`
  ADD PRIMARY KEY (`username`);

--
-- Indeks untuk tabel `berita`
--
ALTER TABLE `berita`
  ADD PRIMARY KEY (`id_berita`),
  ADD KEY `username` (`username`);

--
-- Indeks untuk tabel `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_expiration_index` (`expiration`);

--
-- Indeks untuk tabel `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_locks_expiration_index` (`expiration`);

--
-- Indeks untuk tabel `event`
--
ALTER TABLE `event`
  ADD PRIMARY KEY (`id_event`),
  ADD KEY `username` (`username`);

--
-- Indeks untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indeks untuk tabel `infaq_dana`
--
ALTER TABLE `infaq_dana`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `infaq_rekening`
--
ALTER TABLE `infaq_rekening`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indeks untuk tabel `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `persewaan`
--
ALTER TABLE `persewaan`
  ADD PRIMARY KEY (`id_persewaan`);

--
-- Indeks untuk tabel `profil_masjid`
--
ALTER TABLE `profil_masjid`
  ADD PRIMARY KEY (`Id_profil_masjid`),
  ADD KEY `username` (`username`);

--
-- Indeks untuk tabel `reservasi`
--
ALTER TABLE `reservasi`
  ADD PRIMARY KEY (`id_reservasi`),
  ADD KEY `username` (`username`),
  ADD KEY `pinjam` (`id_persewaan`);

--
-- Indeks untuk tabel `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `berita`
--
ALTER TABLE `berita`
  MODIFY `id_berita` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=229;

--
-- AUTO_INCREMENT untuk tabel `event`
--
ALTER TABLE `event`
  MODIFY `id_event` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `infaq_dana`
--
ALTER TABLE `infaq_dana`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `infaq_rekening`
--
ALTER TABLE `infaq_rekening`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `persewaan`
--
ALTER TABLE `persewaan`
  MODIFY `id_persewaan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT untuk tabel `profil_masjid`
--
ALTER TABLE `profil_masjid`
  MODIFY `Id_profil_masjid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `reservasi`
--
ALTER TABLE `reservasi`
  MODIFY `id_reservasi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `berita`
--
ALTER TABLE `berita`
  ADD CONSTRAINT `berita_ibfk_1` FOREIGN KEY (`username`) REFERENCES `akun` (`username`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `event`
--
ALTER TABLE `event`
  ADD CONSTRAINT `event_ibfk_1` FOREIGN KEY (`username`) REFERENCES `akun` (`username`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `profil_masjid`
--
ALTER TABLE `profil_masjid`
  ADD CONSTRAINT `fk_admin` FOREIGN KEY (`username`) REFERENCES `akun` (`username`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `reservasi`
--
ALTER TABLE `reservasi`
  ADD CONSTRAINT `pinjam` FOREIGN KEY (`id_persewaan`) REFERENCES `persewaan` (`id_persewaan`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
