<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Pengajuan Dokumen Approval</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Pengajuan Dokumen</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="card card-secondary" id="list-document">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-6">
                            <h3 class="card-title">Daftar Pengajuan Saya</h3>
                        </div>
                        <div class="col-md-6 text-right">
                            <button class="btn btn-success btn-sm" id="btn-add"><i class="fas fa-plus-circle"></i> Tambah</button>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <table id="table-document" class="table table-bordered table-striped w-100 text-nowrap">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nomor Dokumen</th>
                                <th>Judul Dokumen</th>
                                <th>Kategori</th>
                                <th>Flow Approval</th>
                                <th>Status</th>
                                <th>Tanggal Dokumen</th>
                                <th>Tanggal Pengajuan</th>
                                <th>Tanggal Selesai</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>

            <div class="card card-secondary" id="form-document">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-6">
                            <h3 class="card-title">Input Pengajuan Dokumen</h3>
                        </div>
                        <div class="col-md-6 text-right">
                            <button class="btn btn-danger btn-sm" id="btn-hide"><i class="fas fa-minus-circle"></i> Sembunyikan</button>
                        </div>
                    </div>
                </div>
                <form id="form-input" enctype="multipart/form-data">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Judul Dokumen</label>
                                    <input type="text" class="form-control" id="title" name="title" placeholder="Judul dokumen">
                                </div>
                                <div class="form-group">
                                    <label>Nomor Dokumen</label>
                                    <input type="text" class="form-control" id="document_number" name="document_number" placeholder="Nomor dokumen">
                                </div>
                                <div class="form-group">
                                    <label>Tanggal Dokumen</label>
                                    <input type="date" class="form-control" id="document_date" name="document_date">
                                </div>
                                <div class="form-group">
                                    <label>Kategori</label>
                                    <input type="text" class="form-control" id="category" name="category" placeholder="Contoh: Kontrak, SK, Berita Acara">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Flow Approval</label>
                                    <select class="form-control" id="flow_id" name="flow_id">
                                        <option value="">Pilih Flow Approval</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>File PDF</label>
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="file" name="file" accept="application/pdf">
                                        <label class="custom-file-label" for="file">Choose file</label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Ringkasan</label>
                                    <textarea class="form-control" id="summary" name="summary" rows="5"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary"><i class="fas fa-paper-plane"></i> Ajukan Approval</button>
                    </div>
                </form>
            </div>
        </div>
    </section>
</div>

<div class="modal fade" id="modal-detail-document" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detail Pengajuan Dokumen</h5>
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
                                <th>Tanggal</th>
                                <td id="detail-date">-</td>
                            </tr>
                            <tr>
                                <th>Kategori</th>
                                <td id="detail-category">-</td>
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
        $('#form-document').hide();
        load_flows();

        $('#table-document').DataTable({
            responsive: false,
            scrollX: true,
            lengthChange: false,
            autoWidth: false,
            ajax: {
                url: '<?= base_url('dashboard/ajax_table_doc_approval_pengajuan') ?>',
                type: 'post',
                dataType: 'json'
            },
            columns: [{
                data: 'no',
                className: 'text-center'
            }, {
                data: 'document_number'
            }, {
                data: 'title'
            }, {
                data: 'category'
            }, {
                data: 'flow_name'
            }, {
                data: 'status',
                className: 'text-center',
                render: function(data) {
                    return render_status(data);
                }
            }, {
                data: 'document_date'
            }, {
                data: 'submitted_at'
            }, {
                data: 'completed_at'
            }, {
                data: null,
                className: 'text-center',
                render: function() {
                    return '<button type="button" class="btn btn-info btn-xs btn-detail"><i class="fas fa-eye"></i> Detail</button>';
                }
            }],
            dom: '<"row" <"col-md-6" B><"col-md-6" f>>rtip',
            buttons: ['copy', 'csv', 'excel', 'pdf', 'print', 'colvis']
        }).buttons().container().appendTo('#table-document_wrapper .col-md-6:eq(0)');
    });

    function escape_html(value) {
        return $('<div>').text(value || '-').html();
    }

    function reload_table() {
        $('#table-document').DataTable().ajax.reload(null, false);
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
        }
        return '<span class="badge badge-' + color + '">' + escape_html(label) + '</span>';
    }

    function load_flows() {
        $.ajax({
            url: '<?= base_url('dashboard/get_doc_approval_flows') ?>',
            type: 'post',
            dataType: 'json',
            data: {
                document_type: 'dokumen'
            },
            success: function(result) {
                var html = '<option value="">Pilih Flow Approval</option>';
                result.forEach(function(row) {
                    html += '<option value="' + row.id + '">' + row.name + '</option>';
                });
                $('#flow_id').html(html);
            }
        });
    }

    $('#btn-add').on('click', function() {
        $('#list-document').hide();
        $('#form-document').show(500);
    });

    $('#btn-hide').on('click', function() {
        $('#form-document').hide();
        $('#list-document').show(500);
    });

    $('#file').on('change', function() {
        var fileName = $(this).val().split('\\').pop();
        $(this).next('.custom-file-label').html(fileName || 'Choose file');
    });

    $('#form-input').on('submit', function(e) {
        e.preventDefault();

        var formData = new FormData(this);
        $.ajax({
            url: '<?= base_url('dashboard/simpan_doc_approval_pengajuan') ?>',
            type: 'post',
            data: formData,
            dataType: 'json',
            cache: false,
            contentType: false,
            processData: false,
            success: function(response) {
                Swal.fire(response.status === 'success' ? 'Success!' : 'Error!', response.message, response.status);
                if (response.status === 'success') {
                    $('#form-input')[0].reset();
                    $('#file').next('.custom-file-label').html('Choose file');
                    reload_table();
                    $('#form-document').hide();
                    $('#list-document').show(500);
                }
            },
            error: function(err) {
                Swal.fire('Error!', err.responseText, 'error');
            }
        });
    });

    $('#table-document').on('click', '.btn-detail', function() {
        var row = $('#table-document').DataTable().row($(this).closest('tr')).data();
        if (!row) {
            row = $('#table-document').DataTable().row($(this).closest('tr').prev()).data();
        }
        show_detail(row);
    });

    function show_detail(row) {
        $('#detail-title').text(row.title || '-');
        $('#detail-number').text(row.document_number || '-');
        $('#detail-date').text(row.document_date || '-');
        $('#detail-category').text(row.category || '-');
        $('#detail-flow').text(row.flow_name || '-');
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

        $('#modal-detail-document').modal('show');
    }
</script>
