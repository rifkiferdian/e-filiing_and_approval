CREATE TABLE IF NOT EXISTS `tbl_histori_naskah` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `jenis_naskah` enum('masuk','keluar') NOT NULL,
  `id_naskah` int(11) NOT NULL,
  `no_surat` varchar(255) NOT NULL,
  `aksi` varchar(80) NOT NULL,
  `catatan` text DEFAULT NULL,
  `pengirim` varchar(128) DEFAULT NULL,
  `penerima` varchar(128) DEFAULT NULL,
  `userid` varchar(128) DEFAULT NULL,
  `nama_user` varchar(128) DEFAULT NULL,
  `role_id` int(11) DEFAULT NULL,
  `date_created` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `idx_histori_naskah` (`jenis_naskah`,`id_naskah`),
  KEY `idx_histori_no_surat` (`no_surat`),
  KEY `idx_histori_aksi` (`aksi`),
  KEY `idx_histori_date` (`date_created`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `tbl_histori_naskah`
  (`jenis_naskah`, `id_naskah`, `no_surat`, `aksi`, `catatan`, `pengirim`, `penerima`, `userid`, `nama_user`, `role_id`, `date_created`)
SELECT
  'masuk', sm.`id`, sm.`no_surat`, 'Data Awal',
  'Histori dibuat dari data naskah masuk yang sudah ada',
  sm.`asal`, sm.`unit_penerima`, 'system', 'System', NULL, sm.`date_created`
FROM `tbl_surat_masuk` sm
WHERE NOT EXISTS (
  SELECT 1 FROM `tbl_histori_naskah` h
  WHERE h.`jenis_naskah` = 'masuk'
    AND h.`id_naskah` = sm.`id`
    AND h.`aksi` = 'Data Awal'
);

INSERT INTO `tbl_histori_naskah`
  (`jenis_naskah`, `id_naskah`, `no_surat`, `aksi`, `catatan`, `pengirim`, `penerima`, `userid`, `nama_user`, `role_id`, `date_created`)
SELECT
  'keluar', sk.`id`, sk.`no_surat`, 'Data Awal',
  'Histori dibuat dari data naskah keluar yang sudah ada',
  sk.`unit_pengirim`, sk.`tujuan`, 'system', 'System', NULL, sk.`date_created`
FROM `tbl_surat_keluar` sk
WHERE NOT EXISTS (
  SELECT 1 FROM `tbl_histori_naskah` h
  WHERE h.`jenis_naskah` = 'keluar'
    AND h.`id_naskah` = sk.`id`
    AND h.`aksi` = 'Data Awal'
);
