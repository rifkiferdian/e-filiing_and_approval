CREATE TABLE IF NOT EXISTS `doc_approval_flows` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(150) NOT NULL,
  `document_type` enum('dokumen','semua') NOT NULL DEFAULT 'dokumen',
  `description` text DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_by` varchar(128) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_doc_approval_flows_type` (`document_type`),
  KEY `idx_doc_approval_flows_active` (`is_active`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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

CREATE TABLE IF NOT EXISTS `doc_approval_steps` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `flow_id` int(11) NOT NULL,
  `step_order` int(11) NOT NULL,
  `step_name` varchar(150) NOT NULL,
  `approval_mode` enum('ANY','ALL') NOT NULL DEFAULT 'ANY',
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `idx_doc_approval_steps_flow` (`flow_id`),
  KEY `idx_doc_approval_steps_order` (`flow_id`,`step_order`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `doc_approval_step_approvers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `step_id` int(11) NOT NULL,
  `approver_userid` varchar(128) NOT NULL,
  `approver_name` varchar(128) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_doc_approval_step_approvers_step` (`step_id`),
  KEY `idx_doc_approval_step_approvers_user` (`approver_userid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `doc_approval_requests` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `document_type` enum('dokumen') NOT NULL,
  `document_id` int(11) NOT NULL,
  `flow_id` int(11) NOT NULL,
  `current_step_order` int(11) NOT NULL DEFAULT 1,
  `status` enum('draft','submitted','in_review','approved','rejected','revision_required','cancelled') NOT NULL DEFAULT 'submitted',
  `submitted_by` varchar(128) DEFAULT NULL,
  `submitted_by_name` varchar(128) DEFAULT NULL,
  `submitted_at` datetime NOT NULL DEFAULT current_timestamp(),
  `completed_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_doc_approval_requests_document` (`document_type`,`document_id`),
  KEY `idx_doc_approval_requests_flow` (`flow_id`),
  KEY `idx_doc_approval_requests_status` (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `doc_approval_actions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `request_id` int(11) NOT NULL,
  `step_id` int(11) NOT NULL,
  `approver_userid` varchar(128) NOT NULL,
  `approver_name` varchar(128) NOT NULL,
  `action` enum('approved','rejected','revision_required') NOT NULL,
  `note` text DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `idx_doc_approval_actions_request` (`request_id`),
  KEY `idx_doc_approval_actions_step` (`step_id`),
  KEY `idx_doc_approval_actions_user` (`approver_userid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `doc_approval_qrcodes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `request_id` int(11) NOT NULL,
  `document_type` enum('dokumen') NOT NULL,
  `document_id` int(11) NOT NULL,
  `verification_token` varchar(128) NOT NULL,
  `qr_path` varchar(255) DEFAULT NULL,
  `final_file` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `generated_by` varchar(128) DEFAULT NULL,
  `generated_at` datetime NOT NULL DEFAULT current_timestamp(),
  `revoked_by` varchar(128) DEFAULT NULL,
  `revoked_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uniq_doc_approval_qrcodes_token` (`verification_token`),
  KEY `idx_doc_approval_qrcodes_request` (`request_id`),
  KEY `idx_doc_approval_qrcodes_document` (`document_type`,`document_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
