<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Approval Saya</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Approval Saya</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="card card-secondary">
                <div class="card-header">
                    <h3 class="card-title">Daftar Dokumen Menunggu Approval</h3>
                </div>
                <div class="card-body">
                    <table id="table-approval" class="table table-bordered table-striped w-100">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Dokumen</th>
                                <th>Flow</th>
                                <th>Kategori</th>
                                <th>Pengaju</th>
                                <th>Waktu Pengajuan</th>
                                <th>Selesai Approval</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </section>
</div>

<div class="modal fade" id="modal-detail-approval-report" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detail Report Dokumen Approval</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <table class="table table-sm table-borderless mb-0">
                            <tr>
                                <th style="width: 145px;">Judul</th>
                                <td id="detail-title">-</td>
                            </tr>
                            <tr>
                                <th>Nomor</th>
                                <td id="detail-number">-</td>
                            </tr>
                            <tr>
                                <th>Tanggal Dokumen</th>
                                <td id="detail-date">-</td>
                            </tr>
                            <tr>
                                <th>Kategori</th>
                                <td id="detail-category">-</td>
                            </tr>
                            <tr>
                                <th>Pengaju</th>
                                <td id="detail-submitter">-</td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <table class="table table-sm table-borderless mb-0">
                            <tr>
                                <th style="width: 145px;">Flow</th>
                                <td id="detail-flow">-</td>
                            </tr>
                            <tr>
                                <th>Step</th>
                                <td id="detail-step">-</td>
                            </tr>
                            <tr>
                                <th>Status</th>
                                <td id="detail-status">-</td>
                            </tr>
                            <tr>
                                <th>File</th>
                                <td id="detail-file">-</td>
                            </tr>
                            <tr>
                                <th>PDF Final</th>
                                <td id="detail-final-file">-</td>
                            </tr>
                            <tr>
                                <th>Selesai</th>
                                <td id="detail-completed">-</td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-12 mt-2">
                        <strong>Ringkasan</strong>
                        <div class="border rounded p-2 mt-1" id="detail-summary">-</div>
                    </div>
                    <div class="col-md-12 mt-3">
                        <strong>Riwayat Approval</strong>
                        <div id="detail-history" class="mt-2">-</div>
                    </div>
                    <div class="col-md-12 mt-3" id="detail-qrcode-section" style="display: none;">
                        <strong>QR Code Verifikasi</strong>
                        <div class="border rounded p-3 mt-2 text-center">
                            <img id="detail-qrcode-image" src="" alt="QR Code Verifikasi" width="130" height="130">
                            <div class="mt-2">
                                <a href="#" target="_blank" id="detail-qrcode-link">Buka Link Verifikasi</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<script>
    $(function() {
        $('#table-approval').DataTable({
            responsive: true,
            lengthChange: false,
            autoWidth: false,
            ajax: {
                url: '<?= base_url('dashboard/ajax_table_doc_approval_saya') ?>',
                type: 'post',
                dataType: 'json'
            },
            columns: [{
                data: 'no',
                className: 'text-center'
            }, {
                data: null,
                render: function(data, type, row) {
                    var doc = row.document || {};
                    var number = doc.document_number || doc.no_surat || '-';
                    var title = doc.title || doc.pihak || '-';
                    var category = doc.category || doc.unit || '-';
                    return '<b>' + escape_html(number) + '</b><br><small>' + escape_html(title) + '</small>';
                }
            }, {
                data: 'flow_name'
            }, {
                data: null,
                render: function(data, type, row) {
                    var doc = row.document || {};
                    return escape_html(doc.category || doc.unit || '-');
                }
            }, {
                data: null,
                render: function(data, type, row) {
                    return escape_html(row.submitted_by_name || '-');
                }
            }, {
                data: 'submitted_at'
            }, {
                data: 'completed_at'
            }, {
                data: null,
                className: 'text-center',
                render: function(data, type, row) {
                    if (row.my_action) {
                        return '<span class="badge badge-success">Sudah Diproses</span>';
                    }
                    return '<span class="badge badge-warning">Menunggu</span>';
                }
            }, {
                data: null,
                className: 'text-center',
                render: function(data, type, row) {
                    return '<button type="button" class="btn btn-secondary btn-xs mr-1 btn-detail"><i class="fas fa-info-circle"></i> Detail</button>' +
                        '<a class="btn btn-info btn-xs" href="<?= base_url('dashboard/dokumen_approval_review/') ?>' + encodeURIComponent(row.request_id) + '"><i class="fas fa-eye"></i> Review</a>';
                }
            }],
            dom: '<"row" <"col-md-6" B><"col-md-6" f>>rtip',
            buttons: ['copy', 'csv', 'excel', 'pdf', 'print', 'colvis']
        }).buttons().container().appendTo('#table-approval_wrapper .col-md-6:eq(0)');
    });

    function escape_html(value) {
        return $('<div>').text(value || '-').html();
    }

    $('#table-approval').on('click', '.btn-detail', function() {
        var table = $('#table-approval').DataTable();
        var row = table.row($(this).closest('tr')).data();
        if (!row) {
            row = table.row($(this).closest('tr').prev()).data();
        }
        show_detail(row);
    });

    function render_status(status) {
        var color = 'secondary';
        var label = status || '-';

        if (status === 'submitted') {
            color = 'info';
            label = 'Diajukan';
        } else if (status === 'in_review') {
            color = 'warning';
            label = 'Review';
        } else if (status === 'approved') {
            color = 'success';
            label = 'Disetujui';
        } else if (status === 'rejected') {
            color = 'danger';
            label = 'Ditolak';
        } else if (status === 'revision_required') {
            color = 'warning';
            label = 'Perlu Revisi';
        }

        return '<span class="badge badge-' + color + '">' + escape_html(label) + '</span>';
    }

    function show_detail(row) {
        var doc = row.document || {};
        var status = doc.status || row.request_status || '-';
        var originalFile = doc.original_file || doc.nama_file || '';
        var finalFile = doc.final_file || '';

        $('#detail-title').text(doc.title || doc.pihak || '-');
        $('#detail-number').text(doc.document_number || doc.no_surat || '-');
        $('#detail-date').text(doc.document_date || doc.tanggal_surat || '-');
        $('#detail-category').text(doc.category || doc.unit || '-');
        $('#detail-submitter').text(row.submitted_by_name || '-');
        $('#detail-flow').text(row.flow_name || '-');
        $('#detail-step').text(row.step_name ? row.step_name + ' / ' + row.approval_mode : '-');
        $('#detail-status').html(render_status(status));
        $('#detail-completed').text(row.completed_at || '-');
        $('#detail-summary').html(escape_html(doc.summary || doc.ringkasan_surat || '-').replace(/\n/g, '<br>'));

        if (originalFile) {
            $('#detail-file').html('<a href="<?= base_url('assets/dokumen_approval/') ?>' + encodeURIComponent(originalFile) + '" target="_blank"><i class="fas fa-file-pdf"></i> ' + escape_html(originalFile) + '</a>');
        } else {
            $('#detail-file').text('-');
        }

        if (status === 'approved' && row.qrcode && row.qrcode.final_file_url) {
            $('#detail-final-file').html('<a href="' + row.qrcode.final_file_url + '" target="_blank"><i class="fas fa-file-pdf"></i> Buka PDF Final QR</a>');
        } else if (status === 'approved' && finalFile) {
            $('#detail-final-file').html('<a href="<?= base_url('assets/dokumen_approval/final/') ?>' + encodeURIComponent(finalFile) + '" target="_blank"><i class="fas fa-file-pdf"></i> Buka PDF Final QR</a>');
        } else {
            $('#detail-final-file').text('-');
        }

        if (row.history && row.history.length > 0) {
            var html = '<ol class="mb-0 pl-3">';
            row.history.forEach(function(item) {
                var color = item.action === 'approved' ? 'success' : (item.action === 'rejected' ? 'danger' : (item.action === 'revision_required' ? 'warning' : 'secondary'));
                var actionLabel = item.action === 'approved' ? 'Disetujui' : (item.action === 'rejected' ? 'Ditolak' : (item.action === 'revision_required' ? 'Revisi Diminta' : 'Menunggu'));
                html += '<li><b>' + escape_html(item.step_name) + '</b> <span class="badge badge-' + color + '">' + escape_html(actionLabel) + '</span>';
                html += '<br><small>Nama User: <b>' + escape_html(item.approver_name) + '</b></small>';
                if (item.note) {
                    html += '<br><small>Catatan: ' + escape_html(item.note) + '</small>';
                }
                if (item.created_at) {
                    html += '<br><small>Waktu: ' + escape_html(item.created_at) + '</small>';
                }
                html += '</li>';
            });
            html += '</ol>';
            $('#detail-history').html(html);
        } else {
            $('#detail-history').html('<span class="text-muted">Belum ada riwayat approval.</span>');
        }

        if (status === 'approved' && row.qrcode && row.qrcode.qr_image_url) {
            $('#detail-qrcode-image').attr('src', row.qrcode.qr_image_url);
            $('#detail-qrcode-link').attr('href', row.qrcode.verification_url).text(row.qrcode.verification_url);
            $('#detail-qrcode-section').show();
        } else {
            $('#detail-qrcode-image').attr('src', '');
            $('#detail-qrcode-link').attr('href', '#').text('Buka Link Verifikasi');
            $('#detail-qrcode-section').hide();
        }

        $('#modal-detail-approval-report').modal('show');
    }
</script>
