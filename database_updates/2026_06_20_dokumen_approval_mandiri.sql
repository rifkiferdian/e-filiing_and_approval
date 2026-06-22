CREATE TABLE IF NOT EXISTS `doc_approval_documents` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(200) NOT NULL,
  `document_number` varchar(150) NOT NULL,
  `document_date` date NOT NULL,
  `category` varchar(120) DEFAULT NULL,
  `summary` text DEFAULT NULL,
  `original_file` varchar(255) NOT NULL,
  `final_file` varchar(255) DEFAULT NULL,
  `status` enum('draft','submitted','in_review','approved','rejected','revision_required','cancelled') NOT NULL DEFAULT 'submitted',
  `flow_id` int(11) NOT NULL,
  `submitted_by` varchar(128) DEFAULT NULL,
  `submitted_by_name` varchar(128) DEFAULT NULL,
  `submitted_at` datetime NOT NULL DEFAULT current_timestamp(),
  `completed_at` datetime DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_doc_approval_documents_number` (`document_number`),
  KEY `idx_doc_approval_documents_status` (`status`),
  KEY `idx_doc_approval_documents_flow` (`flow_id`),
  KEY `idx_doc_approval_documents_submitter` (`submitted_by`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

ALTER TABLE `doc_approval_flows`
  MODIFY `document_type` enum('dokumen','semua') NOT NULL DEFAULT 'dokumen';

ALTER TABLE `doc_approval_requests`
  MODIFY `document_type` enum('dokumen') NOT NULL;

ALTER TABLE `doc_approval_qrcodes`
  MODIFY `document_type` enum('dokumen') NOT NULL;
