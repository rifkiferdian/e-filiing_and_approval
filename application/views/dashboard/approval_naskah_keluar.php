<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Approval Naskah Keluar</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Approval Naskah Keluar</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="card card-secondary">
                <div class="card-header">
                    <h3 class="card-title">Daftar Approval Saya</h3>
                </div>
                <div class="card-body">
                    <table id="table-approval" class="table table-bordered table-striped w-100">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>No. Naskah</th>
                                <th>Tujuan</th>
                                <th>Unit</th>
                                <th>Indeks/Sifat</th>
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

<div class="modal fade" id="modal-detail-approval" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detail Naskah Keluar</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <table class="table table-sm table-borderless mb-0">
                            <tr>
                                <th style="width: 145px;">No. Naskah</th>
                                <td id="detail-no-surat">-</td>
                            </tr>
                            <tr>
                                <th>Tujuan</th>
                                <td id="detail-tujuan">-</td>
                            </tr>
                            <tr>
                                <th>Tanggal Surat</th>
                                <td id="detail-tanggal-surat">-</td>
                            </tr>
                            <tr>
                                <th>Unit Pengirim</th>
                                <td id="detail-unit-pengirim">-</td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <table class="table table-sm table-borderless mb-0">
                            <tr>
                                <th style="width: 145px;">Indeks</th>
                                <td id="detail-indeks">-</td>
                            </tr>
                            <tr>
                                <th>Sifat</th>
                                <td id="detail-sifat">-</td>
                            </tr>
                            <tr>
                                <th>Status</th>
                                <td id="detail-status">-</td>
                            </tr>
                            <tr>
                                <th>File</th>
                                <td id="detail-file">-</td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-12 mt-2">
                        <strong>Ringkasan</strong>
                        <div class="border rounded p-2 mt-1" id="detail-ringkasan">-</div>
                    </div>
                    <div class="col-md-12 mt-3">
                        <strong>Alur Approval</strong>
                        <div id="detail-approval-list" class="mt-2">-</div>
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
                url: '<?= base_url('dashboard/ajax_table_approval_naskah_keluar') ?>',
                type: 'post',
                dataType: 'json'
            },
            columns: [{
                data: 'no',
                className: 'text-center'
            }, {
                data: 'no_surat'
            }, {
                data: 'tujuan'
            }, {
                data: 'unit_pengirim'
            }, {
                data: null,
                render: function(data, type, row) {
                    return row.indeks + '<br><span class="badge badge-info">' + row.sifat + '</span>';
                }
            }, {
                data: 'status_approval_detail',
                className: 'text-center',
                render: function(data) {
                    var color = data === 'Disetujui' ? 'success' : (data === 'Ditolak' ? 'danger' : 'warning');
                    return '<span class="badge badge-' + color + '">' + data + '</span>';
                }
            }, {
                data: null,
                className: 'text-center',
                render: function(data, type, row) {
                    var detailButton = '<button class="btn btn-info btn-xs mr-1 btn-detail-approval"><i class="fas fa-eye"></i> Detail</button>';
                    if (row.status_approval_detail !== 'Menunggu') {
                        return detailButton;
                    }
                    return detailButton +
                        '<button class="btn btn-success btn-xs mr-1 btn-approval" data-id="' + row.approval_id + '" data-status="Disetujui"><i class="fas fa-check"></i> Setujui</button>' +
                        '<button class="btn btn-danger btn-xs btn-approval" data-id="' + row.approval_id + '" data-status="Ditolak"><i class="fas fa-times"></i> Tolak</button>';
                }
            }],
            dom: '<"row" <"col-md-6" B><"col-md-6" f>>rtip',
            buttons: ['copy', 'csv', 'excel', 'pdf', 'print', 'colvis']
        }).buttons().container().appendTo('#table-approval_wrapper .col-md-6:eq(0)');
    });

    function reload_table() {
        $('#table-approval').DataTable().ajax.reload(null, false);
    }

    $('#table-approval').on('click', '.btn-detail-approval', function() {
        var row = $('#table-approval').DataTable().row($(this).closest('tr')).data();
        if (!row) {
            row = $('#table-approval').DataTable().row($(this).closest('tr').prev()).data();
        }

        show_detail_approval(row);
    });

    $(document).on('click', '.btn-approval', function() {
        proses_approval($(this).data('id'), $(this).data('status'));
    });

    function escape_html(value) {
        return $('<div>').text(value || '-').html();
    }

    function show_detail_approval(row) {
        $('#detail-no-surat').text(row.no_surat || '-');
        $('#detail-tujuan').text(row.tujuan || '-');
        $('#detail-tanggal-surat').text(row.tanggal_surat || '-');
        $('#detail-unit-pengirim').text(row.unit_pengirim || '-');
        $('#detail-indeks').text(row.indeks || '-');
        $('#detail-sifat').html('<span class="badge badge-info">' + escape_html(row.sifat) + '</span>');
        $('#detail-status').html('<span class="badge badge-primary">' + escape_html(row.status_approval) + '</span>');
        $('#detail-ringkasan').html(escape_html(row.ringkasan_surat).replace(/\n/g, '<br>'));

        if (row.nama_file) {
            $('#detail-file').html('<a href="<?= base_url('assets/surat_keluar/') ?>' + encodeURIComponent(row.nama_file) + '" target="_blank"><i class="fas fa-file-alt"></i> ' + escape_html(row.nama_file) + '</a>');
        } else {
            $('#detail-file').text('-');
        }

        if (row.approval_detail && row.approval_detail.length > 0) {
            var html = '<ol class="mb-0 pl-3">';
            row.approval_detail.forEach(function(item) {
                var color = item.status === 'Disetujui' ? 'success' : (item.status === 'Ditolak' ? 'danger' : 'warning');
                var catatan = item.catatan ? '<br><small>Catatan: ' + escape_html(item.catatan) + '</small>' : '';
                var approvedAt = item.approved_at ? '<br><small>Waktu: ' + escape_html(item.approved_at) + '</small>' : '';
                html += '<li><b>' + escape_html(item.approver_name) + '</b> <span class="badge badge-' + color + '">' + escape_html(item.status) + '</span>' + catatan + approvedAt + '</li>';
            });
            html += '</ol>';
            $('#detail-approval-list').html(html);
        } else {
            $('#detail-approval-list').html('<span class="text-muted">Tidak ada alur approval.</span>');
        }

        $('#modal-detail-approval').modal('show');
    }

    function proses_approval(id, status) {
        Swal.fire({
            title: status + ' naskah?',
            input: 'textarea',
            inputPlaceholder: 'Catatan approval (opsional)',
            showCancelButton: true,
            confirmButtonText: status
        }).then(function(result) {
            if (result.isConfirmed) {
                $.ajax({
                    url: '<?= base_url('dashboard/proses_approval_naskah_keluar') ?>',
                    type: 'post',
                    dataType: 'json',
                    data: {
                        approval_id: id,
                        status: status,
                        catatan: result.value
                    },
                    success: function(response) {
                        Swal.fire(response.status === 'success' ? 'Success!' : 'Error!', response.message, response.status);
                        reload_table();
                    },
                    error: function(err) {
                        Swal.fire('Error!', err.responseText, 'error');
                    }
                });
            }
        });
    }
</script>
