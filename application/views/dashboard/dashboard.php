<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Dashboard</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Dashboard</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <!-- Small boxes (Stat box) -->
            <div class="row">
                <div class="col-lg-4 col-6">
                    <!-- small box -->
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3 id="suratmasuk">0</h3>

                            <p>Surat Masuk</p>
                        </div>
                        <div class="icon">
                            <i class="nav-icon fas fa-envelope-open-text"></i>
                        </div>
                        <!-- <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a> -->
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-4 col-6">
                    <!-- small box -->
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3 id="suratkeluar">0</h3>

                            <p>Surat Keluar</p>
                        </div>
                        <div class="icon">
                            <i class="nav-icon fas fa-envelope"></i>
                        </div>
                        <!-- <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a> -->
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-4 col-6">
                    <!-- small box -->
                    <div class="small-box bg-warning">
                        <div class="inner">
                            <h3 id="disposisi">0</h3>

                            <p>Total Disposisi</p>
                        </div>
                        <div class="icon">
                            <i class="nav-icon fas fa-mail-bulk"></i>
                        </div>
                        <!-- <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a> -->
                    </div>
                </div>
                <!-- ./col -->
            </div>
            <div class="row">
                <section class="col-lg-6 connectedSortable">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-chart-line mr-1"></i>
                                Grafik Surat Masuk Vs Surat Keluar
                            </h3>
                        </div>
                        <div class="card-body">
                            <div class="tab-content p-0">
                                <!-- Morris chart - Sales -->
                                <div class="chart tab-pane active" style="position: relative; height: 300px;">
                                    <canvas id="chart-masuk-keluar"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <section class="col-lg-6 connectedSortable">
                    <!-- Custom tabs (Charts with tabs)-->
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title d-flex w-100 align-items-center">
                                <i class="fas fa-chart-pie mr-1"></i>
                                Summary Jumlah Surat Tahun <select class="form-control w-25 ml-2" id="filter-tahun">
                                    <?php
                                    $tahun_surat = !empty($tahun_surat) ? $tahun_surat : array(date('Y'));
                                    foreach ($tahun_surat as $tahun) :
                                    ?>
                                        <option value="<?= $tahun ?>"><?= $tahun ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div><!-- /.card-header -->
                        <div class="card-body">
                            <div class="tab-content p-0">
                                <div class="row">
                                    <div class="col-7">
                                        <div class="chart tab-pane active" id="revenue-chart">
                                            <canvas id="chart-prosentase-surat" width="300" height="300"></canvas>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

            </div>
            <div class="row">
                <div class="col-12">
                    <h5 class="mb-3">Rekap Dokumen Approval Saya</h5>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-primary">
                        <div class="inner">
                            <h3 id="doc-approval-pengajuan">0</h3>
                            <p>Pengajuan Saya</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-file-signature"></i>
                        </div>
                        <a href="<?= base_url('dashboard/dokumen_approval_pengajuan') ?>" class="small-box-footer">Lihat detail <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-warning">
                        <div class="inner">
                            <h3 id="doc-approval-review">0</h3>
                            <p>Perlu Saya Review</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-user-check"></i>
                        </div>
                        <a href="<?= base_url('dashboard/dokumen_approval_saya') ?>" class="small-box-footer">Lihat detail <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3 id="doc-approval-disetujui">0</h3>
                            <p>Disetujui</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-check-circle"></i>
                        </div>
                        <a href="<?= base_url('dashboard/dokumen_approval_pengajuan') ?>" class="small-box-footer">Lihat detail <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-danger">
                        <div class="inner">
                            <h3 id="doc-approval-perbaikan">0</h3>
                            <p>Ditolak / Revisi</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-exclamation-circle"></i>
                        </div>
                        <a href="<?= base_url('dashboard/dokumen_approval_pengajuan') ?>" class="small-box-footer">Lihat detail <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
            </div>
            <div class="row">
                <section class="col-lg-8 connectedSortable">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-chart-line mr-1"></i>
                                Tren Pengajuan Dokumen Approval Saya
                            </h3>
                        </div>
                        <div class="card-body">
                            <div class="chart" style="position: relative; height: 300px;">
                                <canvas id="chart-doc-approval-trend"></canvas>
                            </div>
                        </div>
                    </div>
                </section>
                <section class="col-lg-4 connectedSortable">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-chart-pie mr-1"></i>
                                Status Pengajuan Saya
                            </h3>
                        </div>
                        <div class="card-body">
                            <div class="chart" style="position: relative; height: 300px;">
                                <canvas id="chart-doc-approval-status"></canvas>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
            <div class="row">
                <section class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-list mr-1"></i>
                                Dokumen Approval Terbaru Terkait Saya
                            </h3>
                        </div>
                        <div class="card-body table-responsive p-0">
                            <table class="table table-hover table-sm mb-0">
                                <thead>
                                    <tr>
                                        <th>Dokumen</th>
                                        <th>Nomor</th>
                                        <th>Flow</th>
                                        <th>Relasi</th>
                                        <th>Status</th>
                                        <th>Diajukan</th>
                                    </tr>
                                </thead>
                                <tbody id="doc-approval-latest">
                                    <tr>
                                        <td colspan="6" class="text-center text-muted py-3">Memuat data...</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </section>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    var chartMasukKeluar = null;
    var chartProsentaseSurat = null;
    var chartDocApprovalTrend = null;
    var chartDocApprovalStatus = null;

    $(function() {
        chart_masuk_keluar()
        chart_prosentase_surat()
        load_doc_approval_dashboard()

        cal_info_dashboard()

        $("#filter-tahun").on("change", function() {
            chart_masuk_keluar()
            chart_prosentase_surat()
        })


        // $.ajax({
        //     url: '<?= base_url('dashboardAgus/getsaldo') ?>',
        //     type: 'post',
        //     dataType: 'json',
        //     success: function(result) {
        //         console.log(result)
        //         var html = '<h3 id="saldo">Rp. ' + result.saldo + ',-</h3>';
        //         $('#saldo').html(html)
        //         var html2 = '<h3 id="nasabah"> ' + result.jml_nasabah + ' </h3>';
        //         $('#nasabah').html(html2)
        //         var html3 = '<h3 id="jual">Rp.  ' + result.jual + ',- </h3>';
        //         $('#jual').html(html3)
        //         var html4 = '<h3 id="act">' + result.act + '</h3>';
        //         $('#act').html(html4)
        //         var html5 = '<p id="jam">Last ' + result.jam + ' WIB</p>';
        //         $('#jam').html(html5)
        //     }
        // })

    })

    function cal_info_dashboard() {
        $.ajax({
            url: '<?= base_url('dashboard/getsuratmasuk') ?>',
            dataType: 'json',
            success: function(result) {
                $('#suratmasuk').text(result);
            }
        });

        $.ajax({
            url: '<?= base_url('dashboard/getsuratkeluar') ?>',
            dataType: 'json',
            success: function(result) {
                $('#suratkeluar').text(result);
            }
        });

        $.ajax({
            url: '<?= base_url('dashboard/getdisposisi') ?>',
            dataType: 'json',
            success: function(result) {
                $('#disposisi').text(result);
            }
        });
    }

    function load_doc_approval_dashboard() {
        $.ajax({
            url: '<?= base_url('dashboard/get_doc_approval_dashboard') ?>',
            dataType: 'json',
            success: function(result) {
                $('#doc-approval-pengajuan').text(result.summary.pengajuan_saya || 0);
                $('#doc-approval-review').text(result.summary.perlu_review || 0);
                $('#doc-approval-disetujui').text(result.summary.disetujui || 0);
                $('#doc-approval-perbaikan').text(result.summary.perlu_perbaikan || 0);

                render_chart_doc_approval_trend(result.trend);
                render_chart_doc_approval_status(result.status);
                render_doc_approval_latest(result.latest || []);
            },
            error: function() {
                $('#doc-approval-latest').html('<tr><td colspan="6" class="text-center text-danger py-3">Data rekap Dokumen Approval gagal dimuat.</td></tr>');
            }
        });
    }

    function render_chart_doc_approval_trend(data) {
        var ctx = document.getElementById('chart-doc-approval-trend');
        if (chartDocApprovalTrend) {
            chartDocApprovalTrend.destroy();
        }

        chartDocApprovalTrend = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: data.labels,
                datasets: [{
                    label: 'Jumlah Pengajuan',
                    data: data.values,
                    backgroundColor: '#6f42c1',
                    borderColor: '#6f42c1',
                    borderWidth: 1,
                    borderRadius: 4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            precision: 0
                        }
                    }
                }
            }
        });
    }

    function render_chart_doc_approval_status(data) {
        var ctx = document.getElementById('chart-doc-approval-status');
        if (chartDocApprovalStatus) {
            chartDocApprovalStatus.destroy();
        }

        chartDocApprovalStatus = new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: data.labels,
                datasets: [{
                    data: data.values,
                    backgroundColor: [
                        '#6c757d',
                        '#17a2b8',
                        '#ffc107',
                        '#28a745',
                        '#dc3545',
                        '#fd7e14',
                        '#adb5bd'
                    ],
                    borderWidth: 0
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                }
            }
        });
    }

    function render_doc_approval_latest(rows) {
        if (!rows.length) {
            $('#doc-approval-latest').html('<tr><td colspan="6" class="text-center text-muted py-3">Belum ada dokumen approval terkait Anda.</td></tr>');
            return;
        }

        var html = '';
        rows.forEach(function(row) {
            html += '<tr>' +
                '<td><strong>' + escape_html(row.title || '-') + '</strong><br><small class="text-muted">Pemohon: ' + escape_html(row.submitted_by_name || '-') + '</small></td>' +
                '<td>' + escape_html(row.document_number || '-') + '</td>' +
                '<td>' + escape_html(row.flow_name || '-') + '</td>' +
                '<td>' + escape_html(row.relasi || '-') + '</td>' +
                '<td><span class="badge badge-' + escape_html(row.status_class || 'secondary') + '">' + escape_html(row.status_label || '-') + '</span></td>' +
                '<td>' + escape_html(row.submitted_at || '-') + '</td>' +
                '</tr>';
        });

        $('#doc-approval-latest').html(html);
    }

    function escape_html(value) {
        return String(value)
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;')
            .replace(/"/g, '&quot;')
            .replace(/'/g, '&#039;');
    }

    function chart_masuk_keluar() {
        $.ajax({
            url: '<?= base_url() ?>chart/get_data_mutasi_surat',
            data: {
                tahun: $("#filter-tahun").val()
            },
            type: 'post',
            dataType: 'json',
            success: function(result) {
                // console.log(result)
                var ctx = document.getElementById('chart-masuk-keluar');
                if (chartMasukKeluar) {
                    chartMasukKeluar.destroy();
                }
                // ctx.height = 70;
                chartMasukKeluar = new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: result.periode,
                        datasets: [{
                            label: 'Surat Masuk',
                            data: result.surat_masuk,
                            backgroundColor: [
                                '#dc3545',
                            ],
                            borderColor: [
                                '#dc3545',
                            ],
                            borderWidth: 2,
                            tension: 0.2
                        }, {
                            label: 'Surat Keluar',
                            data: result.surat_keluar,
                            backgroundColor: [
                                '#007bff',
                            ],
                            borderColor: [
                                '#007bff',
                            ],
                            borderWidth: 2,
                            tension: 0.2
                        }, ]
                    },
                    options: {
                        // responsive: true,
                        plugins: {
                            legend: {
                                display: true
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true
                            },
                            x: {
                                display: true,
                                title: {
                                    display: true,
                                    text: 'Sejumlah',
                                }
                            }
                        }
                    }
                });
            }
        })
    }

    function chart_prosentase_surat() {
        $.ajax({
            url: '<?= base_url() ?>chart/get_data_prosentase_surat',
            data: {
                tahun: $("#filter-tahun").val()
            },
            type: 'post',
            dataType: 'json',
            success: function(result) {
                console.log(result)
                var ctx = document.getElementById('chart-prosentase-surat');
                if (chartProsentaseSurat) {
                    chartProsentaseSurat.destroy();
                }
                chartProsentaseSurat = new Chart(ctx, {
                    type: 'pie',
                    data: {
                        labels: ['Surat Masuk', 'Surat Keluar'],
                        datasets: [{
                            label: 'Surat Masuk',
                            data: result.jumlah,
                            backgroundColor: [
                                '#dc3545',
                                '#007bff',
                            ],
                            borderColor: [
                                '#dc3545',
                                '#007bff',
                            ],
                            borderWidth: 0,
                            tension: 0.2
                        }, ]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                    }
                });
            },
            error: function(err) {
                console.log(err)
            }
        })
    }
</script>
