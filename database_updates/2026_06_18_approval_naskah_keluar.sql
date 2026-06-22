CREATE TABLE IF NOT EXISTS `mst_template_approval` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama_template` varchar(128) NOT NULL,
  `deskripsi` text DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `date_created` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `mst_template_approval_detail` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `template_id` int(11) NOT NULL,
  `urutan` int(11) NOT NULL,
  `approver_userid` varchar(128) NOT NULL,
  `approver_name` varchar(128) NOT NULL,
  `role_label` varchar(128) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_template_id` (`template_id`),
  KEY `idx_approver_userid` (`approver_userid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `tbl_approval_naskah_keluar` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_surat_keluar` int(11) NOT NULL,
  `template_id` int(11) DEFAULT NULL,
  `urutan` int(11) NOT NULL,
  `approver_userid` varchar(128) NOT NULL,
  `approver_name` varchar(128) NOT NULL,
  `status` enum('Menunggu','Disetujui','Ditolak') NOT NULL DEFAULT 'Menunggu',
  `catatan` text DEFAULT NULL,
  `approved_at` datetime DEFAULT NULL,
  `date_created` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `idx_surat_keluar` (`id_surat_keluar`),
  KEY `idx_approver` (`approver_userid`),
  KEY `idx_status` (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

ALTER TABLE `tbl_surat_keluar`
  ADD COLUMN IF NOT EXISTS `template_approval_id` int(11) DEFAULT NULL AFTER `nama_file`,
  ADD COLUMN IF NOT EXISTS `status_approval` varchar(50) NOT NULL DEFAULT 'Draft' AFTER `template_approval_id`;
