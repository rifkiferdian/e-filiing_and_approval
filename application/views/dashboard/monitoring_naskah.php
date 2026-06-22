<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Monitoring Naskah</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Monitoring Naskah</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-secondary">
                        <div class="card-header">
                            <h3 class="card-title">Daftar Naskah Masuk dan Keluar</h3>
                        </div>
                        <div class="card-body">
                            <table id="table-monitoring" class="table table-bordered table-striped w-100">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Jenis</th>
                                        <th>No. Naskah</th>
                                        <th>Asal/Tujuan</th>
                                        <th>Indeks</th>
                                        <th>Sifat</th>
                                        <th>No. Agenda</th>
                                        <th>Status</th>
                                        <th>Posisi / Approval</th>
                                        <th>Disposisi</th>
                                        <th>Tanggal Input</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<script>
    $(function() {
        $('#table-monitoring').DataTable({
            responsive: true,
            lengthChange: true,
            autoWidth: false,
            createdRow: function(row, data) {
                var url = '<?= base_url('dashboard/histori_naskah') ?>/' + data.jenis_naskah + '/' + data.id_naskah;
                $(row).attr('data-href', url).css('cursor', 'pointer').attr('title', 'Klik untuk melihat histori naskah');
            },
            order: [
                [10, 'desc']
            ],
            ajax: {
                url: '<?= base_url('dashboard/ajax_table_monitoring_naskah') ?>',
                type: 'post',
                dataType: 'json'
            },
            columns: [{
                data: 'no',
                className: 'text-center'
            }, {
                data: 'jenis',
                className: 'text-center',
                render: function(data) {
                    var color = data === 'Masuk' ? 'badge-info' : 'badge-success';
                    return '<span class="badge ' + color + '">' + data + '</span>';
                }
            }, {
                data: 'no_surat',
                render: function(data, type, row) {
                    var url = '<?= base_url('dashboard/histori_naskah') ?>/' + row.jenis_naskah + '/' + row.id_naskah;
                    return '<a href="' + url + '" target="_blank" class="font-weight-bold" title="Lihat histori naskah">' + data + '</a>';
                }
            }, {
                data: 'pihak'
            }, {
                data: 'indeks'
            }, {
                data: 'sifat',
                className: 'text-center'
            }, {
                data: 'nomor_agenda',
                className: 'text-center',
                render: function(data) {
                    return data && data !== '' ? data : '<span class="badge badge-warning">Belum</span>';
                }
            }, {
                data: 'status',
                className: 'text-center',
                render: function(data) {
                    var color = 'secondary';
                    if (data === 'Disetujui' || data === 'Didisposisikan') {
                        color = 'success';
                    } else if (data === 'Menunggu Approval' || data === 'Belum diteruskan' || data === 'Draft') {
                        color = 'warning';
                    } else if (data === 'Ditolak') {
                        color = 'danger';
                    }

                    return '<span class="badge badge-' + color + '">' + data + '</span>';
                }
            }, {
                data: null,
                render: function(data, type, row) {
                    if (row.jenis !== 'Keluar') {
                        return '<span class="text-muted">Tidak memakai approval</span>';
                    }

                    var html = '<div><b>' + row.posisi_sekarang + '</b></div>';
                    if (!row.approval_detail || row.approval_detail.length === 0) {
                        return html;
                    }

                    html += '<ol class="mb-0 pl-3">';
                    row.approval_detail.forEach(function(item) {
                        var color = item.status === 'Disetujui' ? 'success' : (item.status === 'Ditolak' ? 'danger' : 'warning');
                        var approvedAt = item.approved_at ? '<br><small>' + item.approved_at + '</small>' : '';
                        html += '<li><span>' + item.approver_name + '</span> <span class="badge badge-' + color + '">' + item.status + '</span>' + approvedAt + '</li>';
                    });
                    html += '</ol>';
                    return html;
                }
            }, {
                data: 'daftar_disposisi',
                render: function(data, type, row) {
                    if (row.jenis !== 'Masuk') {
                        return '<span class="text-muted">-</span>';
                    }

                    if (!data || data === '') {
                        return '<span class="badge badge-warning">Belum didisposisikan</span>';
                    }

                    var names = data.split(', ');
                    var html = '<ol class="mb-0 pl-3">';
                    names.forEach(function(name) {
                        html += '<li>' + name + '</li>';
                    });
                    html += '</ol>';
                    return html;
                }
            }, {
                data: 'date_created'
            }],
            dom: '<"row" <"col-md-6" B><"col-md-6" f>>rtip',
            buttons: ['copy', 'csv', 'excel', 'pdf', 'print', 'colvis']
        }).buttons().container().appendTo('#table-monitoring_wrapper .col-md-6:eq(0)');

        $('#table-monitoring tbody').on('click', 'tr', function(e) {
            if ($(e.target).closest('a, button').length) {
                return;
            }

            var url = $(this).attr('data-href');
            if (url) {
                window.open(url, '_blank');
            }
        });
    });
</script>
