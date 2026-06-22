<?php
$logo_url = base_url('assets/dist/img/logo_ww.png');
$format_tanggal_id = function ($date, $with_time = false) {
    if (empty($date)) {
        return '-';
    }

    $timestamp = strtotime($date);
    if (!$timestamp) {
        return '-';
    }

    $bulan = array(
        1 => 'Januari',
        2 => 'Februari',
        3 => 'Maret',
        4 => 'April',
        5 => 'Mei',
        6 => 'Juni',
        7 => 'Juli',
        8 => 'Agustus',
        9 => 'September',
        10 => 'Oktober',
        11 => 'November',
        12 => 'Desember'
    );

    $formatted = date('d', $timestamp).' '.$bulan[(int) date('n', $timestamp)].' '.date('Y', $timestamp);
    if ($with_time) {
        $formatted .= ' '.date('H:i', $timestamp).' WIB';
    }

    return $formatted;
};
$document_number = $valid && !empty($document['document_number']) ? $document['document_number'] : '-';
$issued_date = $valid && !empty($document['document_date']) ? $format_tanggal_id($document['document_date']) : '-';
$requester = $valid && !empty($request['submitted_by_name']) ? $request['submitted_by_name'] : '-';
$subject = $valid && !empty($document['title']) ? $document['title'] : '-';
?>
<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Verifikasi Dokumen Publik</title>
    <link rel="stylesheet" href="<?= base_url('assets/plugins/fontawesome-free/css/all.min.css') ?>">
    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            min-height: 100vh;
            font-family: Arial, Helvetica, sans-serif;
            background: #f4f6f8;
            color: #111827;
        }

        .verification-page {
            width: 100%;
            max-width: 520px;
            margin: 0 auto;
            padding: 40px 16px 28px;
            text-align: center;
        }

        .verification-logo {
            width: 88px;
            height: 88px;
            object-fit: contain;
            background: #f4f6f8;
            margin-bottom: 1px;
        }

        .verification-title {
            font-size: 19px;
            line-height: 1.2;
            font-weight: 800;
            letter-spacing: .02em;
            margin: 0;
        }

        .verification-subtitle {
            color: #6b7280;
            font-size: 12px;
            margin: 4px 0 28px;
        }

        .status-pill {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            border: 1px solid #22c55e;
            background: #ecfdf5;
            color: #15803d;
            border-radius: 9px;
            padding: 12px 18px;
            margin-bottom: 24px;
            min-width: 220px;
            text-align: left;
        }

        .status-pill.invalid {
            border-color: #ef4444;
            background: #fef2f2;
            color: #b91c1c;
        }

        .status-icon {
            width: 28px;
            height: 28px;
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            flex: 0 0 28px;
            background: #22c55e;
            color: #fff;
        }

        .status-pill.invalid .status-icon {
            background: #ef4444;
        }

        .status-small {
            display: block;
            font-size: 10px;
            font-weight: 800;
            letter-spacing: .08em;
            text-transform: uppercase;
        }

        .status-large {
            display: block;
            font-size: 18px;
            font-weight: 800;
            line-height: 1.1;
        }

        .document-card {
            background: #fff;
            border-radius: 16px;
            padding: 28px 24px 22px;
            text-align: left;
            box-shadow: 0 18px 40px rgba(15, 23, 42, .08);
        }

        .detail-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 24px 28px;
            margin-bottom: 22px;
        }

        .detail-item.full {
            grid-column: 1 / -1;
        }

        .detail-label {
            display: block;
            color: #9ca3af;
            font-size: 9px;
            font-weight: 800;
            letter-spacing: .08em;
            text-transform: uppercase;
            margin-bottom: 8px;
        }

        .detail-value {
            display: block;
            color: #111827;
            font-size: 14px;
            font-weight: 700;
            line-height: 1.35;
            overflow-wrap: anywhere;
        }

        .approved-section {
            border-top: 1px solid #eef2f7;
            padding-top: 18px;
        }

        .approved-title {
            font-size: 11px;
            font-weight: 800;
            letter-spacing: .12em;
            text-transform: uppercase;
            margin-bottom: 14px;
        }

        .approver-row {
            display: flex;
            align-items: flex-start;
            gap: 12px;
            margin-bottom: 14px;
        }

        .approver-icon {
            width: 22px;
            height: 22px;
            border-radius: 50%;
            background: #f3e8ff;
            color: #8b008b;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            flex: 0 0 22px;
            font-size: 10px;
        }

        .approver-body {
            flex: 1;
            min-width: 0;
        }

        .approver-name {
            display: block;
            font-size: 13px;
            font-weight: 800;
            line-height: 1.2;
        }

        .approver-note {
            display: block;
            font-size: 11px;
            color: #6b7280;
            line-height: 1.35;
        }

        .approver-time {
            flex: 0 0 auto;
            max-width: 145px;
            text-align: right;
            font-size: 10px;
            color: #64748b;
            line-height: 1.35;
        }

        .pdf-button {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            width: 100%;
            min-height: 44px;
            margin-top: 24px;
            border-radius: 9px;
            background: #8b008b;
            color: #fff;
            text-decoration: none;
            font-size: 13px;
            font-weight: 800;
            box-shadow: 0 12px 22px rgba(139, 0, 139, .25);
        }

        .pdf-button:hover,
        .pdf-button:focus {
            color: #fff;
            background: #760076;
        }

        .verification-footer {
            margin-top: 22px;
            color: #94a3b8;
            font-size: 12px;
            font-weight: 600;
            text-align: center;
        }

        .invalid-message {
            text-align: center;
            color: #6b7280;
            line-height: 1.6;
        }

        @media (max-width: 520px) {
            .detail-grid {
                grid-template-columns: 1fr;
                gap: 18px;
            }

            .approver-row {
                flex-wrap: wrap;
            }

            .approver-time {
                flex-basis: 100%;
                max-width: none;
                text-align: left;
                padding-left: 34px;
            }
        }
    </style>
</head>

<body>
    <main class="verification-page">
        <img class="verification-logo" src="<?= html_escape($logo_url) ?>" alt="Logo STIE">
        <h1 class="verification-title">Sekolah Tinggi Ilmu Ekonomi Widya Wiwaha</h1> </br>
        <h1 class="verification-title">VERIFIKASI DOKUMEN PUBLIK</h1>
        <div class="verification-subtitle">Sistem Rekam Akademik Resmi STIE</div>

        <div class="status-pill <?= $valid ? '' : 'invalid' ?>">
            <span class="status-icon">
                <i class="fas <?= $valid ? 'fa-check' : 'fa-times' ?>"></i>
            </span>
            <span>
                <span class="status-small">Status Dokumen</span>
                <span class="status-large"><?= $valid ? 'DOKUMEN VALID' : 'DOKUMEN TIDAK VALID' ?></span>
            </span>
        </div>

        <section class="document-card">
            <?php if ($valid): ?>
                <div class="detail-grid">
                    <div class="detail-item">
                        <span class="detail-label">Nomor Dokumen</span>
                        <span class="detail-value"><?= html_escape($document_number) ?></span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-label">Tanggal Terbit</span>
                        <span class="detail-value"><?= html_escape($issued_date) ?></span>
                    </div>
                    <div class="detail-item full">
                        <span class="detail-label">Nama Pemohon</span>
                        <span class="detail-value"><?= html_escape($requester) ?></span>
                    </div>
                    <div class="detail-item full">
                        <span class="detail-label">Perihal Dokumen</span>
                        <span class="detail-value"><?= html_escape($subject) ?></span>
                    </div>
                </div>

                <div class="approved-section">
                    <div class="approved-title">Disetujui Oleh</div>
                    <?php if (!empty($approved_by)): ?>
                        <?php foreach ($approved_by as $approver): ?>
                            <div class="approver-row">
                                <span class="approver-icon"><i class="fas fa-shield-alt"></i></span>
                                <div class="approver-body">
                                    <span class="approver-name"><?= html_escape($approver['approver_name']) ?></span>
                                    <?php if (!empty($approver['note'])): ?>
                                        <span class="approver-note"><?= html_escape($approver['note']) ?></span>
                                    <?php endif; ?>
                                </div>
                                <div class="approver-time">
                                    <?= html_escape($format_tanggal_id($approver['created_at'], true)) ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <span class="approver-note">Riwayat persetujuan tidak tersedia.</span>
                    <?php endif; ?>
                </div>
            <?php else: ?>
                <div class="invalid-message">
                    QR Code tidak terdaftar, tidak aktif, atau dokumen belum berstatus disetujui.
                </div>
            <?php endif; ?>
        </section>

        <?php if ($valid && !empty($final_file_url)): ?>
            <a href="<?= html_escape($final_file_url) ?>" target="_blank" class="pdf-button">
                <i class="fas fa-file-pdf"></i>
                LIHAT DOKUMEN PDF RESMI
            </a>
        <?php endif; ?>

        <footer class="verification-footer"><i class="fas fa-lock"></i> Diamankan oleh Sistem Tanda Tangan Digital STIE</footer>
    </main>
</body>

</html>
