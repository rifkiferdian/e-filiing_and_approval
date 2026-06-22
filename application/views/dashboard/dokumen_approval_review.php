<?php
$doc = $review['document'];
$number = !empty($doc['document_number']) ? $doc['document_number'] : '-';
$title = !empty($doc['title']) ? $doc['title'] : '-';
$category = !empty($doc['category']) ? $doc['category'] : '-';
$summary = !empty($doc['summary']) ? $doc['summary'] : '-';
$can_process = empty($review['my_action']) && !empty($review['is_current_approver']) && in_array($review['request_status'], array('submitted', 'in_review'), true);
?>

<style>
    .approval-review-page {
        min-height: calc(100vh - 145px);
    }

    .approval-review-shell {
        display: grid;
        grid-template-columns: minmax(0, 1fr) 360px;
        min-height: calc(100vh - 230px);
        border: 1px solid #d9e0ea;
        background: #fff;
    }

    .approval-pdf-pane {
        min-height: 620px;
        padding: 18px;
        background: #dfe5ee;
    }

    .approval-pdf-frame {
        width: 100%;
        height: 100%;
        min-height: 620px;
        border: 0;
        background: #fff;
        box-shadow: 0 2px 10px rgba(15, 23, 42, .12);
    }

    .approval-empty-preview {
        min-height: 620px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #fff;
        color: #6b7280;
    }

    .approval-side-pane {
        border-left: 1px solid #e5e7eb;
        padding: 18px;
        background: #fff;
    }

    .approval-side-title {
        font-size: 12px;
        font-weight: 700;
        color: #475569;
        letter-spacing: .04em;
        text-transform: uppercase;
        margin-bottom: 12px;
    }

    .approval-info-box {
        border: 1px solid #e5e7eb;
        border-radius: 8px;
        background: #f8fafc;
        padding: 14px;
        margin-bottom: 18px;
    }

    .approval-info-item {
        display: flex;
        gap: 10px;
        margin-bottom: 14px;
    }

    .approval-info-item:last-child {
        margin-bottom: 0;
    }

    .approval-info-icon {
        width: 18px;
        flex: 0 0 18px;
        color: #f59e0b;
        text-align: center;
        padding-top: 2px;
    }

    .approval-info-label {
        display: block;
        font-size: 11px;
        color: #64748b;
        line-height: 1.2;
    }

    .approval-info-value {
        display: block;
        font-weight: 600;
        color: #0f172a;
        line-height: 1.3;
        overflow-wrap: anywhere;
    }

    .approval-history-item {
        position: relative;
        display: flex;
        gap: 10px;
        padding-bottom: 16px;
    }

    .approval-history-item:before {
        content: "";
        position: absolute;
        left: 9px;
        top: 22px;
        bottom: 0;
        width: 2px;
        background: #e5e7eb;
    }

    .approval-history-item:last-child:before {
        display: none;
    }

    .approval-history-dot {
        width: 20px;
        height: 20px;
        border-radius: 50%;
        flex: 0 0 20px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        color: #fff;
        font-size: 10px;
        margin-top: 1px;
        z-index: 1;
    }

    .approval-history-dot.success {
        background: #22c55e;
    }

    .approval-history-dot.warning {
        background: #f59e0b;
    }

    .approval-history-dot.danger {
        background: #ef4444;
    }

    .approval-history-dot.secondary {
        background: #8b5cf6;
    }

    .approval-history-title {
        font-weight: 700;
        color: #111827;
        line-height: 1.25;
    }

    .approval-history-meta {
        font-size: 12px;
        color: #64748b;
        line-height: 1.35;
    }

    .approval-action-bar {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        padding: 12px 16px;
        border: 1px solid #d9e0ea;
        border-top: 0;
        background: #fff;
    }

    .approval-action-buttons {
        display: flex;
        flex-wrap: wrap;
        justify-content: flex-end;
        gap: 8px;
    }

    @media (max-width: 991.98px) {
        .approval-review-shell {
            grid-template-columns: 1fr;
        }

        .approval-side-pane {
            border-left: 0;
            border-top: 1px solid #e5e7eb;
        }

        .approval-action-bar {
            align-items: stretch;
            flex-direction: column;
        }
    }
</style>

<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-8">
                    <h1>Review Dokumen Approval</h1>
                </div>
                <div class="col-sm-4">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?= base_url('dashboard/dokumen_approval_saya') ?>">Approval Saya</a></li>
                        <li class="breadcrumb-item active">Review</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content approval-review-page">
        <div class="container-fluid">
            <div id="approval-message"></div>
            <div class="approval-review-shell">
                <div class="approval-pdf-pane">
                    <?php if (!empty($review['file_url'])): ?>
                        <iframe class="approval-pdf-frame" src="<?= html_escape($review['file_url']) ?>#toolbar=1&navpanes=0&zoom=100" title="Preview Dokumen Approval"></iframe>
                    <?php else: ?>
                        <div class="approval-empty-preview">Preview PDF tidak tersedia.</div>
                    <?php endif; ?>
                </div>

                <aside class="approval-side-pane">
                    <div class="approval-side-title">Document Details</div>
                    <div class="approval-info-box">
                        <div class="approval-info-item">
                            <div class="approval-info-icon"><i class="fas fa-user"></i></div>
                            <div>
                                <span class="approval-info-label">Pengaju</span>
                                <span class="approval-info-value"><?= html_escape($review['submitted_by_name']) ?></span>
                            </div>
                        </div>
                        <div class="approval-info-item">
                            <div class="approval-info-icon"><i class="fas fa-calendar-alt"></i></div>
                            <div>
                                <span class="approval-info-label">Tanggal Pengajuan</span>
                                <span class="approval-info-value"><?= html_escape($review['submitted_at_label']) ?></span>
                            </div>
                        </div>
                        <div class="approval-info-item">
                            <div class="approval-info-icon"><i class="fas fa-file-alt"></i></div>
                            <div>
                                <span class="approval-info-label">Nomor Dokumen</span>
                                <span class="approval-info-value"><?= html_escape($number) ?></span>
                            </div>
                        </div>
                        <div class="approval-info-item">
                            <div class="approval-info-icon"><i class="fas fa-heading"></i></div>
                            <div>
                                <span class="approval-info-label">Judul Dokumen</span>
                                <span class="approval-info-value"><?= html_escape($title) ?></span>
                            </div>
                        </div>
                        <div class="approval-info-item">
                            <div class="approval-info-icon"><i class="fas fa-folder-open"></i></div>
                            <div>
                                <span class="approval-info-label">Kategori</span>
                                <span class="approval-info-value"><?= html_escape($category) ?></span>
                            </div>
                        </div>
                        <div class="approval-info-item">
                            <div class="approval-info-icon"><i class="fas fa-route"></i></div>
                            <div>
                                <span class="approval-info-label">Flow / Step</span>
                                <span class="approval-info-value"><?= html_escape($review['flow_name'].' / '.$review['step_name'].' ('.$review['approval_mode'].')') ?></span>
                            </div>
                        </div>
                    </div>

                    <div class="approval-side-title">Ringkasan</div>
                    <div class="approval-info-box text-muted">
                        <?= nl2br(html_escape($summary)) ?>
                    </div>

                    <div class="approval-side-title">Approval History</div>
                    <div class="approval-info-box">
                        <?php if (!empty($review['history'])): ?>
                            <?php foreach ($review['history'] as $history): ?>
                                <?php
                                $action = !empty($history['action']) ? $history['action'] : '';
                                $color = $action === 'approved' ? 'success' : ($action === 'rejected' ? 'danger' : ($action === 'revision_required' ? 'warning' : 'secondary'));
                                $icon = $action === 'approved' ? 'fa-check' : ($action === 'rejected' ? 'fa-times' : ($action === 'revision_required' ? 'fa-edit' : 'fa-hourglass-half'));
                                $label = $action === 'approved' ? 'Disetujui' : ($action === 'rejected' ? 'Ditolak' : ($action === 'revision_required' ? 'Revisi Diminta' : 'Menunggu Approval'));
                                ?>
                                <div class="approval-history-item">
                                    <span class="approval-history-dot <?= $color ?>"><i class="fas <?= $icon ?>"></i></span>
                                    <div>
                                        <div class="approval-history-title"><?= html_escape($label) ?></div>
                                        <div class="approval-history-meta"><b><?= html_escape($history['approver_name']) ?></b><?= !empty($history['created_at']) ? ' - '.html_escape($history['created_at']) : '' ?></div>
                                        <div class="approval-history-meta"><?= html_escape($history['step_name']) ?></div>
                                        <?php if (!empty($history['note'])): ?>
                                            <div class="approval-history-meta"><i>"<?= html_escape($history['note']) ?>"</i></div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <span class="text-muted">Belum ada riwayat approval.</span>
                        <?php endif; ?>
                    </div>

                    <?php if ($can_process): ?>
                        <div class="approval-side-title">Catatan / Alasan</div>
                        <textarea id="approval-note" class="form-control" rows="4" placeholder="Tulis catatan approval"></textarea>
                        <small class="text-muted">Catatan wajib untuk aksi Tolak atau Minta Revisi.</small>
                    <?php else: ?>
                        <div class="alert alert-info mb-0">Approval ini sudah diproses atau tidak lagi berada pada step aktif.</div>
                    <?php endif; ?>
                </aside>
            </div>

            <div class="approval-action-bar">
                <small class="text-muted">Reviewing: <?= html_escape($number) ?></small>
                <div class="approval-action-buttons">
                    <a href="<?= base_url('dashboard/dokumen_approval_saya') ?>" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left mr-1"></i> Kembali
                    </a>
                    <?php if ($can_process): ?>
                        <button type="button" class="btn btn-outline-danger btn-approval-action" data-action="rejected">
                            <i class="fas fa-times mr-1"></i> Tolak
                        </button>
                        <button type="button" class="btn btn-outline-warning btn-approval-action" data-action="revision_required">
                            <i class="fas fa-edit mr-1"></i> Minta Revisi
                        </button>
                        <button type="button" class="btn btn-success btn-approval-action" data-action="approved">
                            <i class="fas fa-check mr-1"></i> Approve
                        </button>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>
</div>

<script>
    $('.btn-approval-action').on('click', function() {
        var action = $(this).data('action');
        var note = $('#approval-note').val() || '';

        if ((action === 'rejected' || action === 'revision_required') && $.trim(note) === '') {
            show_message('warning', 'Catatan wajib diisi untuk aksi Tolak atau Minta Revisi.');
            return;
        }

        $('.btn-approval-action').prop('disabled', true);
        $.ajax({
            url: '<?= base_url('dashboard/proses_doc_approval') ?>',
            type: 'post',
            dataType: 'json',
            data: {
                request_id: '<?= (int) $review['request_id'] ?>',
                step_id: '<?= (int) $review['step_id'] ?>',
                action: action,
                note: note
            },
            success: function(response) {
                show_message(response.status === 'success' ? 'success' : 'danger', response.message);
                if (response.status === 'success') {
                    setTimeout(function() {
                        window.location.href = '<?= base_url('dashboard/dokumen_approval_saya') ?>';
                    }, 900);
                } else {
                    $('.btn-approval-action').prop('disabled', false);
                }
            },
            error: function(err) {
                show_message('danger', err.responseText || 'Approval gagal diproses.');
                $('.btn-approval-action').prop('disabled', false);
            }
        });
    });

    function show_message(type, message) {
        $('#approval-message').html('<div class="alert alert-' + type + ' alert-dismissible fade show">' +
            $('<div>').text(message || '-').html() +
            '<button type="button" class="close" data-dismiss="alert">&times;</button></div>');
        $('html, body').animate({ scrollTop: $('#approval-message').offset().top - 80 }, 200);
    }
</script>
