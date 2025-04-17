/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

# ------------------------------------------------------------
# SCHEMA DUMP FOR TABLE: tb_detail_transaksi
# ------------------------------------------------------------

CREATE TABLE IF NOT EXISTS `tb_detail_transaksi` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_transaksi` int DEFAULT NULL,
  `id_paket` int DEFAULT NULL,
  `qty` int DEFAULT NULL,
  `keterangan` text COLLATE utf8mb4_general_ci,
  PRIMARY KEY (`id`),
  KEY `id_transaksi` (`id_transaksi`),
  KEY `id_paket` (`id_paket`),
  CONSTRAINT `tb_detail_transaksi_ibfk_1` FOREIGN KEY (`id_transaksi`) REFERENCES `tb_transaksi` (`id`) ON DELETE CASCADE,
  CONSTRAINT `tb_detail_transaksi_ibfk_2` FOREIGN KEY (`id_paket`) REFERENCES `tb_paket` (`id`) ON DELETE CASCADE
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci;

# ------------------------------------------------------------
# SCHEMA DUMP FOR TABLE: tb_jenis_cuci
# ------------------------------------------------------------

CREATE TABLE IF NOT EXISTS `tb_jenis_cuci` (
  `id` int NOT NULL AUTO_INCREMENT,
  `jenis_cuci` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `harga_cuci` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE = InnoDB AUTO_INCREMENT = 3 DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci;

# ------------------------------------------------------------
# SCHEMA DUMP FOR TABLE: tb_karyawan
# ------------------------------------------------------------

CREATE TABLE IF NOT EXISTS `tb_karyawan` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nama` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `alamat` text COLLATE utf8mb4_general_ci NOT NULL,
  `no_telp` varchar(20) COLLATE utf8mb4_general_ci NOT NULL,
  `posisi` enum('kasir', 'admin', 'owner') COLLATE utf8mb4_general_ci NOT NULL,
  `id_user` int NOT NULL,
  `gaji` decimal(10, 2) DEFAULT NULL,
  `shift_kerja` enum('pagi', 'malam') COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_user` (`id_user`),
  CONSTRAINT `tb_karyawan_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `tb_user` (`id`)
) ENGINE = InnoDB AUTO_INCREMENT = 3 DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci;

# ------------------------------------------------------------
# SCHEMA DUMP FOR TABLE: tb_member
# ------------------------------------------------------------

CREATE TABLE IF NOT EXISTS `tb_member` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nama` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `alamat` text COLLATE utf8mb4_general_ci NOT NULL,
  `jenis_kelamin` enum('L', 'P') COLLATE utf8mb4_general_ci NOT NULL,
  `tlp` varchar(15) COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci;

# ------------------------------------------------------------
# SCHEMA DUMP FOR TABLE: tb_outlet
# ------------------------------------------------------------

CREATE TABLE IF NOT EXISTS `tb_outlet` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nama` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `alamat` text COLLATE utf8mb4_general_ci NOT NULL,
  `tlp` varchar(15) COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE = InnoDB AUTO_INCREMENT = 2 DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci;

# ------------------------------------------------------------
# SCHEMA DUMP FOR TABLE: tb_paket
# ------------------------------------------------------------

CREATE TABLE IF NOT EXISTS `tb_paket` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_outlet` int DEFAULT NULL,
  `jenis` enum('kiloan', 'selimut', 'bed_cover', 'kaos', 'lain') COLLATE utf8mb4_general_ci NOT NULL,
  `jumlah` int DEFAULT '1',
  `nama_paket` int DEFAULT NULL,
  `harga` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_outlet` (`id_outlet`),
  KEY `nama_paket` (`nama_paket`),
  CONSTRAINT `tb_paket_ibfk_1` FOREIGN KEY (`id_outlet`) REFERENCES `tb_outlet` (`id`) ON DELETE CASCADE,
  CONSTRAINT `tb_paket_ibfk_2` FOREIGN KEY (`nama_paket`) REFERENCES `tb_paket_cuci` (`id`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci;

# ------------------------------------------------------------
# SCHEMA DUMP FOR TABLE: tb_paket_cuci
# ------------------------------------------------------------

CREATE TABLE IF NOT EXISTS `tb_paket_cuci` (
  `id` int NOT NULL AUTO_INCREMENT,
  `paket_cuci` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `harga_paket` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE = InnoDB AUTO_INCREMENT = 3 DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci;

# ------------------------------------------------------------
# SCHEMA DUMP FOR TABLE: tb_transaksi
# ------------------------------------------------------------

CREATE TABLE IF NOT EXISTS `tb_transaksi` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_outlet` int DEFAULT NULL,
  `kode_invoice` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `id_member` int DEFAULT NULL,
  `tgl` datetime NOT NULL,
  `batas_waktu` datetime NOT NULL,
  `tgl_bayar` datetime DEFAULT NULL,
  `id_jenis_paket` int DEFAULT NULL,
  `id_jenis_cuci` int DEFAULT NULL,
  `diskon` double DEFAULT NULL,
  `pajak` int DEFAULT NULL,
  `status` enum('baru', 'proses', 'selesai', 'diambil') COLLATE utf8mb4_general_ci NOT NULL,
  `dibayar` enum('dibayar', 'belum_dibayar') COLLATE utf8mb4_general_ci NOT NULL,
  `id_user` int DEFAULT NULL,
  `deleted_at` date DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_outlet` (`id_outlet`),
  KEY `id_member` (`id_member`),
  KEY `id_user` (`id_user`),
  KEY `id_jenis_paket` (`id_jenis_paket`, `id_jenis_cuci`),
  KEY `id_jenis_cuci` (`id_jenis_cuci`),
  CONSTRAINT `tb_transaksi_ibfk_1` FOREIGN KEY (`id_outlet`) REFERENCES `tb_outlet` (`id`) ON DELETE CASCADE,
  CONSTRAINT `tb_transaksi_ibfk_2` FOREIGN KEY (`id_member`) REFERENCES `tb_member` (`id`) ON DELETE CASCADE,
  CONSTRAINT `tb_transaksi_ibfk_3` FOREIGN KEY (`id_user`) REFERENCES `tb_user` (`id`) ON DELETE CASCADE,
  CONSTRAINT `tb_transaksi_ibfk_4` FOREIGN KEY (`id_jenis_cuci`) REFERENCES `tb_jenis_cuci` (`id`),
  CONSTRAINT `tb_transaksi_ibfk_5` FOREIGN KEY (`id_jenis_paket`) REFERENCES `tb_paket_cuci` (`id`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci;

# ------------------------------------------------------------
# SCHEMA DUMP FOR TABLE: tb_user
# ------------------------------------------------------------

CREATE TABLE IF NOT EXISTS `tb_user` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nama` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `foto` varchar(250) COLLATE utf8mb4_general_ci NOT NULL,
  `username` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `password` text COLLATE utf8mb4_general_ci NOT NULL,
  `id_outlet` int DEFAULT NULL,
  `role` enum('admin', 'kasir', 'owner') COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_outlet` (`id_outlet`),
  CONSTRAINT `tb_user_ibfk_1` FOREIGN KEY (`id_outlet`) REFERENCES `tb_outlet` (`id`) ON DELETE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 3 DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci;

# ------------------------------------------------------------
# DATA DUMP FOR TABLE: tb_detail_transaksi
# ------------------------------------------------------------


# ------------------------------------------------------------
# DATA DUMP FOR TABLE: tb_jenis_cuci
# ------------------------------------------------------------

INSERT INTO
  `tb_jenis_cuci` (`id`, `jenis_cuci`, `harga_cuci`)
VALUES
  (1, 'Celana', 10000);
INSERT INTO
  `tb_jenis_cuci` (`id`, `jenis_cuci`, `harga_cuci`)
VALUES
  (2, 'boxer', 50000);

# ------------------------------------------------------------
# DATA DUMP FOR TABLE: tb_karyawan
# ------------------------------------------------------------

INSERT INTO
  `tb_karyawan` (
    `id`,
    `nama`,
    `alamat`,
    `no_telp`,
    `posisi`,
    `id_user`,
    `gaji`,
    `shift_kerja`
  )
VALUES
  (
    1,
    'Miftahur Rahman',
    'Dsn Pajaten Mas, Ds Bantarjati, Kec Kertajati',
    '081234567890',
    'admin',
    1,
    NULL,
    'pagi'
  );
INSERT INTO
  `tb_karyawan` (
    `id`,
    `nama`,
    `alamat`,
    `no_telp`,
    `posisi`,
    `id_user`,
    `gaji`,
    `shift_kerja`
  )
VALUES
  (
    2,
    'akbar',
    'akbar',
    '086352535233',
    'kasir',
    2,
    2500000.00,
    'pagi'
  );

# ------------------------------------------------------------
# DATA DUMP FOR TABLE: tb_member
# ------------------------------------------------------------


# ------------------------------------------------------------
# DATA DUMP FOR TABLE: tb_outlet
# ------------------------------------------------------------

INSERT INTO
  `tb_outlet` (`id`, `nama`, `alamat`, `tlp`)
VALUES
  (
    1,
    'Cab Pajaten',
    'DSN Pajaten Mas, DS Bantarjati, KEC Kertajati',
    '081234567890'
  );

# ------------------------------------------------------------
# DATA DUMP FOR TABLE: tb_paket
# ------------------------------------------------------------


# ------------------------------------------------------------
# DATA DUMP FOR TABLE: tb_paket_cuci
# ------------------------------------------------------------

INSERT INTO
  `tb_paket_cuci` (`id`, `paket_cuci`, `harga_paket`)
VALUES
  (1, 'premium', 10000);
INSERT INTO
  `tb_paket_cuci` (`id`, `paket_cuci`, `harga_paket`)
VALUES
  (2, 'Antar Premium', 5000);

# ------------------------------------------------------------
# DATA DUMP FOR TABLE: tb_transaksi
# ------------------------------------------------------------


# ------------------------------------------------------------
# DATA DUMP FOR TABLE: tb_user
# ------------------------------------------------------------

INSERT INTO
  `tb_user` (
    `id`,
    `nama`,
    `foto`,
    `username`,
    `password`,
    `id_outlet`,
    `role`
  )
VALUES
  (
    1,
    'Miftahur Rahman',
    '',
    'miftahur',
    '$2a$10$SsfvYib4yKtcBtNBPpNucO77FRsxXpuibhHGTNXfBJ4xwnFAmqFcm',
    1,
    'admin'
  );
INSERT INTO
  `tb_user` (
    `id`,
    `nama`,
    `foto`,
    `username`,
    `password`,
    `id_outlet`,
    `role`
  )
VALUES
  (
    2,
    'akbar',
    'default.png',
    'akbar',
    '$2y$10$mCeZ8Xe1W5sgU6LsJPSjReAAqqJ.LArzw20Nju0ugXbLIOClbPnTq',
    1,
    'kasir'
  );

/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
