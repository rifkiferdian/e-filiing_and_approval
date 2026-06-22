<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1><?= !empty($filter_id_naskah) ? 'Histori Per Naskah' : 'Histori Naskah' ?></h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active"><?= !empty($filter_id_naskah) ? 'Histori Per Naskah' : 'Histori Naskah' ?></li>
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
                            <h3 class="card-title">
                                Timeline Aktivitas Naskah
                                <?php if (!empty($naskah_info)) : ?>
                                    - <?= $naskah_info['no_surat'] ?>
                                <?php endif; ?>
                            </h3>
                        </div>
                        <div class="card-body">
                            <?php if (!empty($filter_id_naskah) && !empty($naskah_info)) : ?>
                                <div class="card border mb-3">
                                    <div class="card-header bg-light text-dark">
                                        <strong>Detail Naskah</strong>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <table class="table table-sm table-borderless mb-0">
                                                    <tr>
                                                        <th style="width: 150px;">Jenis</th>
                                                        <td><span class="badge badge-<?= $filter_jenis_naskah === 'masuk' ? 'info' : 'success' ?>"><?= ucfirst($filter_jenis_naskah) ?></span></td>
                                                    </tr>
                                                    <tr>
                                                        <th>No. Naskah</th>
                                                        <td><?= $naskah_info['no_surat'] ?: '-' ?></td>
                                                    </tr>
                                                    <tr>
                                                        <th>Asal/Tujuan</th>
                                                        <td><?= $naskah_info['pihak'] ?: '-' ?></td>
                                                    </tr>
                                                    <tr>
                                                        <th>Tanggal Surat</th>
                                                        <td><?= !empty($naskah_info['tanggal_surat']) && $naskah_info['tanggal_surat'] !== '0000-00-00' ? date('d-F-Y', strtotime($naskah_info['tanggal_surat'])) : '-' ?></td>
                                                    </tr>
                                                    <?php if ($filter_jenis_naskah === 'masuk') : ?>
                                                        <tr>
                                                            <th>Tanggal Diterima</th>
                                                            <td><?= !empty($naskah_info['tanggal_surat_diterima']) && $naskah_info['tanggal_surat_diterima'] !== '0000-00-00' ? date('d-F-Y', strtotime($naskah_info['tanggal_surat_diterima'])) : '-' ?></td>
                                                        </tr>
                                                    <?php endif; ?>
                                                    <tr>
                                                        <th><?= $filter_jenis_naskah === 'masuk' ? 'Unit Penerima' : 'Unit Pengirim' ?></th>
                                                        <td><?= $naskah_info['unit'] ?: '-' ?></td>
                                                    </tr>
                                                </table>
                                            </div>
                                            <div class="col-md-6">
                                                <table class="table table-sm table-borderless mb-0">
                                                    <tr>
                                                        <th style="width: 150px;">Indeks</th>
                                                        <td><?= $naskah_info['indeks'] ?: '-' ?></td>
                                                    </tr>
                                                    <tr>
                                                        <th>Sifat</th>
                                                        <td><?= $naskah_info['sifat'] ?: '-' ?></td>
                                                    </tr>
                                                    <?php if ($filter_jenis_naskah === 'masuk') : ?>
                                                        <tr>
                                                            <th>No. Agenda</th>
                                                            <td><?= $naskah_info['nomor_agenda'] ?: '-' ?></td>
                                                        </tr>
                                                    <?php endif; ?>
                                                    <tr>
                                                        <th>Status</th>
                                                        <td><?= $naskah_info['status'] ?: '-' ?></td>
                                                    </tr>
                                                    <tr>
                                                        <th>File</th>
                                                        <td>
                                                            <?php if (!empty($naskah_info['nama_file'])) : ?>
                                                                <?php $folder_file = $filter_jenis_naskah === 'masuk' ? 'surat_masuk' : 'surat_keluar'; ?>
                                                                <a href="<?= base_url('assets/' . $folder_file . '/' . $naskah_info['nama_file']) ?>" target="_blank">
                                                                    <i class="fas fa-file-alt"></i> <?= $naskah_info['nama_file'] ?>
                                                                </a>
                                                            <?php else : ?>
                                                                -
                                                            <?php endif; ?>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th>Tanggal Input</th>
                                                        <td><?= !empty($naskah_info['date_created']) ? date('d-F-Y H:i:s', strtotime($naskah_info['date_created'])) : '-' ?></td>
                                                    </tr>
                                                </table>
                                            </div>
                                            <div class="col-md-12 mt-2">
                                                <strong>Ringkasan</strong>
                                                <div class="border rounded p-2 mt-1"><?= nl2br($naskah_info['ringkasan_surat'] ?: '-') ?></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php elseif (!empty($filter_id_naskah)) : ?>
                                <div class="alert alert-warning">Data naskah tidak ditemukan.</div>
                            <?php endif; ?>
                            <table id="table-histori" class="table table-bordered table-striped w-100">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Jenis</th>
                                        <th>No. Naskah</th>
                                        <th>Aksi</th>
                                        <th>Catatan</th>
                                        <th>Dari</th>
                                        <th>Kepada</th>
                                        <th>User</th>
                                        <th>Waktu</th>
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
    var filterJenisNaskah = '<?= isset($filter_jenis_naskah) ? $filter_jenis_naskah : '' ?>';
    var filterIdNaskah = '<?= isset($filter_id_naskah) ? $filter_id_naskah : '' ?>';

    $(function() {
        $('#table-histori').DataTable({
            responsive: true,
            lengthChange: true,
            autoWidth: false,
            order: [
                [8, 'desc']
            ],
            ajax: {
                url: '<?= base_url('dashboard/ajax_table_histori_naskah') ?>',
                type: 'post',
                dataType: 'json',
                data: function(data) {
                    data.jenis_naskah = filterJenisNaskah;
                    data.id_naskah = filterIdNaskah;
                }
            },
            columns: [{
                data: 'no',
                className: 'text-center'
            }, {
                data: 'jenis_naskah',
                className: 'text-center',
                render: function(data) {
                    var color = data === 'Masuk' ? 'badge-info' : 'badge-success';
                    return '<span class="badge ' + color + '">' + data + '</span>';
                }
            }, {
                data: 'no_surat'
            }, {
                data: 'aksi',
                className: 'text-center'
            }, {
                data: 'catatan'
            }, {
                data: 'pengirim'
            }, {
                data: 'penerima'
            }, {
                data: 'user'
            }, {
                data: 'date_created'
            }],
            dom: '<"row" <"col-md-6" B><"col-md-6" f>>rtip',
            buttons: ['copy', 'csv', 'excel', 'pdf', 'print', 'colvis']
        }).buttons().container().appendTo('#table-histori_wrapper .col-md-6:eq(0)');
    });
</script>
