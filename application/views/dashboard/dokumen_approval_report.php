<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Report Dokumen Approval</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Report Approval</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="card card-secondary">
                <div class="card-header">
                    <h3 class="card-title">Filter Report</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Status</label>
                                <select class="form-control" id="filter-status">
                                    <option value="">Semua Status</option>
                                    <option value="submitted">Diajukan</option>
                                    <option value="in_review">Review</option>
                                    <option value="approved">Disetujui</option>
                                    <option value="rejected">Ditolak</option>
                                    <option value="revision_required">Perlu Revisi</option>
                                    <option value="cancelled">Dibatalkan</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Tanggal Mulai</label>
                                <input type="date" class="form-control" id="filter-date-start">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Tanggal Selesai</label>
                                <input type="date" class="form-control" id="filter-date-end">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>&nbsp;</label>
                                <div>
                                    <button type="button" class="btn btn-primary" id="btn-filter"><i class="fas fa-search"></i> Filter</button>
                                    <button type="button" class="btn btn-secondary" id="btn-reset"><i class="fas fa-sync"></i> Reset</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card card-secondary">
                <div class="card-header">
                    <h3 class="card-title">Semua Dokumen Approval</h3>
                </div>
                <div class="card-body">
                    <table id="table-report" class="table table-bordered table-striped w-100">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Dokumen</th>
                                <th>Kategori</th>
                                <th>Pengaju</th>
                                <th>Flow/Step</th>
                                <th>Status</th>
                                <th>Tanggal</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </section>
</div>

<div class="modal fade" id="modal-detail-report" tabindex="-1" role="dialog" aria-hidden="true">
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
                                <th>Step Aktif</th>
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
    var tableReport;

    $(function() {
        tableReport = $('#table-report').DataTable({
            responsive: true,
            lengthChange: false,
            autoWidth: false,
            ajax: {
                url: '<?= base_url('dashboard/ajax_table_doc_approval_report') ?>',
                type: 'post',
                dataType: 'json',
                data: function(d) {
                    d.status = $('#filter-status').val();
                    d.date_start = $('#filter-date-start').val();
                    d.date_end = $('#filter-date-end').val();
                }
            },
            columns: [{
                data: 'no',
                className: 'text-center'
            }, {
                data: null,
                render: function(data, type, row) {
                    return '<b>' + escape_html(row.title) + '</b><br><small>' + escape_html(row.document_number) + '</small>';
                }
            }, {
                data: 'category'
            }, {
                data: null,
                render: function(data, type, row) {
                    return escape_html(row.submitted_by_name || '-') + '<br><small>' + escape_html(row.submitted_at || '-') + '</small>';
                }
            }, {
                data: null,
                render: function(data, type, row) {
                    var step = row.step_name ? '<br><small>' + escape_html(row.step_name) + ' / ' + escape_html(row.approval_mode) + '</small>' : '';
                    return escape_html(row.flow_name || '-') + step;
                }
            }, {
                data: 'status',
                className: 'text-center',
                render: function(data) {
                    return render_status(data);
                }
            }, {
                data: null,
                render: function(data, type, row) {
                    return 'Dokumen: ' + escape_html(row.document_date || '-') + '<br><small>Selesai: ' + escape_html(row.completed_at || '-') + '</small>';
                }
            }, {
                data: null,
                className: 'text-center',
                render: function() {
                    return '<button type="button" class="btn btn-info btn-xs btn-detail"><i class="fas fa-eye"></i> Detail</button>';
                }
            }],
            dom: '<"row" <"col-md-6" B><"col-md-6" f>>rtip',
            buttons: ['copy', 'csv', 'excel', 'pdf', 'print', 'colvis']
        });

        tableReport.buttons().container().appendTo('#table-report_wrapper .col-md-6:eq(0)');
    });

    $('#btn-filter').on('click', function() {
        tableReport.ajax.reload();
    });

    $('#btn-reset').on('click', function() {
        $('#filter-status').val('');
        $('#filter-date-start').val('');
        $('#filter-date-end').val('');
        tableReport.ajax.reload();
    });

    function escape_html(value) {
        return $('<div>').text(value || '-').html();
    }

    function render_status(status) {
        var color = 'secondary';
        var label = status;
        if (status === 'submitted') {
            color = 'warning';
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
            color = 'info';
            label = 'Perlu Revisi';
        } else if (status === 'cancelled') {
            color = 'secondary';
            label = 'Dibatalkan';
        }
        return '<span class="badge badge-' + color + '">' + escape_html(label) + '</span>';
    }

    $('#table-report').on('click', '.btn-detail', function() {
        var row = tableReport.row($(this).closest('tr')).data();
        if (!row) {
            row = tableReport.row($(this).closest('tr').prev()).data();
        }
        show_detail(row);
    });

    function show_detail(row) {
        $('#detail-title').text(row.title || '-');
        $('#detail-number').text(row.document_number || '-');
        $('#detail-date').text(row.document_date || '-');
        $('#detail-category').text(row.category || '-');
        $('#detail-submitter').text(row.submitted_by_name || '-');
        $('#detail-flow').text(row.flow_name || '-');
        $('#detail-step').text(row.step_name ? row.step_name + ' / ' + row.approval_mode : '-');
        $('#detail-status').html(render_status(row.status));
        $('#detail-completed').text(row.completed_at || '-');
        $('#detail-summary').html(escape_html(row.summary).replace(/\n/g, '<br>'));

        if (row.original_file) {
            $('#detail-file').html('<a href="<?= base_url('assets/dokumen_approval/') ?>' + encodeURIComponent(row.original_file) + '" target="_blank"><i class="fas fa-file-pdf"></i> ' + escape_html(row.original_file) + '</a>');
        } else {
            $('#detail-file').text('-');
        }

        if (row.status === 'approved' && row.qrcode && row.qrcode.final_file_url) {
            $('#detail-final-file').html('<a href="' + row.qrcode.final_file_url + '" target="_blank"><i class="fas fa-file-pdf"></i> Buka PDF Final QR</a>');
        } else if (row.status === 'approved' && row.final_file) {
            $('#detail-final-file').html('<a href="<?= base_url('assets/dokumen_approval/final/') ?>' + encodeURIComponent(row.final_file) + '" target="_blank"><i class="fas fa-file-pdf"></i> Buka PDF Final QR</a>');
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

        if (row.status === 'approved' && row.qrcode && row.qrcode.qr_image_url) {
            $('#detail-qrcode-image').attr('src', row.qrcode.qr_image_url);
            $('#detail-qrcode-link').attr('href', row.qrcode.verification_url).text(row.qrcode.verification_url);
            $('#detail-qrcode-section').show();
        } else {
            $('#detail-qrcode-image').attr('src', '');
            $('#detail-qrcode-link').attr('href', '#').text('Buka Link Verifikasi');
            $('#detail-qrcode-section').hide();
        }

        $('#modal-detail-report').modal('show');
    }
</script>
