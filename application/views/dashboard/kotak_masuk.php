<style>
    .border-left-danger {
        border-left: 3px solid red !important;
    }

    .card {
        box-shadow: none;
    }
</style>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Kotak Masuk</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Kotak Masuk</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <!-- left column -->
                <div class="col-md-12">
                    <div class="card card-secondary shadow-none" id="list-user">
                        <!-- <div class="card-header">
                            <div class="row">
                                <div class="col-md-6">
                                    <h3 class="card-title">Daftar Kotak Masuk</h3>
                                </div>
                                <div class="col-md-12" style="text-align: right;">
                                    <button class="btn btn-success btn-sm" id="btn-add"><i class="fas fa-plus-circle"></i> Tambah</button>
                                </div>
                            </div>
                        </div> -->
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="data-table" class="table table-bordered table-striped table-hover w-100">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Pengirim</th>
                                        <th>Perihal</th>
                                        <th>Pesan</th>
                                        <th>Tanggal</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                    <!-- general form elements -->
                    <div class="card card-secondary" id="tambah-user">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-md-6">
                                    <h3 class="card-title">Surat Masuk</h3>
                                </div>
                                <div class="col-md-6" style="text-align: right;">
                                    <button class="btn btn-danger btn-sm" id="btn-hide"><i class="fas fa-minus-circle"></i> Back</button>
                                </div>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form class="form-horizontal" id="form-input">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="nomor">No. Surat</label>
                                            <input type="text" class="form-control" id="nomor" name="nomor" placeholder="Nomor Surat">
                                        </div>
                                        <div class="form-group">
                                            <label for="asal">Asal Surat</label>
                                            <input type="text" class="form-control" id="asal" name="asal" placeholder="Asal Surat">
                                        </div>
                                        <div class="form-group">
                                            <label for="sifat">Sifat</label>
                                            <select name="sifat" id="sifat" class="form-control">
                                                <option value="Biasa"> Biasa</option>
                                                <option value="Penting"> Penting</option>
                                                <option value="Rahasia"> Rahasia</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="file">Upload Surat</label>
                                            <div class="custom-file">
                                                <input type="file" class="custom-file-input" id="file" name="file">
                                                <label class="custom-file-label" for="customFile">Choose file</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="indeks">Indeks</label>
                                            <select name="indeks" id="indeks" class="form-control">
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="unit">Unit Penerima</label>
                                            <select name="unit" id="unit" class="form-control">
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="tanggal">Tanggal Surat</label>
                                            <input type="date" class="form-control" id="tanggal" name="tanggal" placeholder="Asal Surat">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12" style="text-align: center;margin-top: 30px;">
                                        <h3> Ringkasan Surat</h3>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="nomor">Isi Surat</label>
                                            <textarea name="isi_surat" id="isi_surat" cols="30" rows="5" class="form-control"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <button type="submit" id="btn_submit" class="btn btn-primary">Submit</button>
                            </div>
                        </form>
                    </div>


                    <div class="card" id="teruskan-surat">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-md-6">
                                    <h3 class="card-title">Teruskan Surat Masuk</h3>
                                </div>
                                <div class="col-md-6" style="text-align: right;">
                                    <button class="btn btn-danger btn-sm" id="btn-hide-teruskan"><i class="fas fa-minus-circle"></i> Back</button>
                                </div>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form class="form-horizontal" id="form-teruskan">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="penerima">Pilih Penerima</label>
                                            <select name="penerima" id="penerima" class="form-control w-25">
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="pesan_teruskan">Pesan</label>
                                            <input name="pesan_teruskan" id="pesan_teruskan" class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <button type="submit" id="btn_submit" class="btn btn-primary"><i class="fas fa-paper-plane"></i> Kirim</button>
                            </div>
                        </form>
                    </div>



                    <div class="card" id="rincian-surat">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-md-6">
                                    <h3 class="card-title">Rincian Surat Masuk</h3>
                                </div>
                                <div class="col-md-6" style="text-align: right;">
                                    <button class="btn btn-danger btn-sm" id="btn-hide-rincian"><i class="fas fa-minus-circle"></i> Back</button>
                                </div>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form class="form-horizontal" id="form-input">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-8">
                                        <div class="row" style="margin-bottom: 30px;">
                                            <div class="col-md-1">
                                                <img src="<?= base_url('assets/dist/img/' . $apps["logo"]) ?>" width="48" height="48" />
                                            </div>
                                            <div class="col-md-11">
                                                <span id="info_asal"><b></b></span>
                                                <span id="info_no">Nomor Surat :</span>
                                            </div>
                                        </div>
                                        <span><b>Ringkasan Surat</b></span><br>

                                        <textarea class="form-control bg-white border-0" name="isi" id="isi" cols="30" rows="5" style="text-align: left;" readonly></textarea>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="card shadow">
                                            <div class="card-body detail-rincian">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row" style="margin-top: 20px;">
                                    <div class="col-md-2">
                                        <h6 class="text-secondary"><i class="fas fa-calendar-check"></i><span> Tanggal Surat</span></h6>
                                        <h6 id="info_tgl"></h6>
                                    </div>
                                    <div class="col-md-2">
                                        <h6 class="text-secondary"><i class="fas fa-briefcase"></i><span> Unit Penerima</span></h6>
                                        <h6 id="info_penerima"></h6>
                                    </div>
                                    <div class="col-md-2">
                                        <h6 class="text-secondary"><i class="fas fa-layer-group"></i><span> Indeks</span></h6>
                                        <h6 id="info_indeks"></h6>
                                    </div>
                                    <div class="col-md-2">
                                        <a href="<?= base_url('assets/surat_masuk/') ?>" class="btn btn-sm btn-danger" id="link"></a>
                                    </div>
                                </div>
                            </div>
                            <!-- <div class="card-footer">
                                  <button type="submit" id="btn_submit" class="btn btn-primary">Submit</button>
                              </div> -->
                        </form>
                    </div>



                    <!-- /.card -->

                </div>
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<script>
    <?php $target = 0; ?>
    const base_url = "<?php base_url() ?>"
    var global_status
    var global_id
    var global_id_surat_masuk
    const database_table = `tbl_pesan`
    $(function() {

        var table = $('#data-table').DataTable({
            'paging': true,
            'lengthChange': false,
            'searching': true,
            'ordering': true,
            'info': false,
            'autoWidth': true,
            'processing': true,
            'serverSide': true,
            'dom': '<"row" <"col-md-6 toolbar" > <"col-md-6" f>>rt<"row" <"col-md-12 d-flex justify-content-center" p>>',
            'language': {
                'paginate': {
                    'previous': "<i class='fas fa-arrow-left'></i>",
                    'next': "<i class='fas fa-arrow-right'></i>"
                }
            },
            "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"],
            'ajax': {
                'url': '<?= base_url('dashboard/ajax_getdata') ?>',
                'type': 'post',
                'data': {
                    table: database_table,
                    select_data: ['id', 'pengirim', 'penerima', 'perihal', 'pesan', 'nama_file', 'date_created', 'is_read', 'id_surat_masuk'],
                    where: {
                        penerima: "<?= $this->session->userdata("name") ?>"
                    },
                },
            },
            "order": [
                [0, 'desc']
            ],
            'columns': [{
                'target': [<?= $target ?>],
                'data': 'data.id',
                'visible': false,
                'orderable': true
            }, {
                'target': [<?= $target++ ?>],
                'data': 'data.pengirim',
                'className': 'align-middle',
                'render': function(data) {
                    return '<b>' + data + '</b>';
                }
            }, {
                'target': [<?= $target++ ?>],
                'data': 'data.perihal',
                'className': 'align-middle'
            }, {
                'target': [<?= $target++ ?>],
                'data': 'data.pesan',
                'className': 'align-middle',
                'render': function(data) {
                    return data && data !== '' ? data : '<span class="text-muted">Tidak ada pesan</span>';
                }
            }, {
                'target': [<?= $target++ ?>],
                'data': 'data.date_created',
                'className': 'align-middle text-center'
            }, {
                'target': [<?= $target++ ?>],
                'data': 'data.is_read',
                'className': 'align-middle text-center',
                'render': function(data) {
                    return data == 'NO' ?
                        '<span class="badge badge-danger">Belum Dibaca</span>' :
                        '<span class="badge badge-success">Sudah Dibaca</span>';
                }
            }, {
                'target': [<?= $target++ ?>],
                'data': 'data',
                'className': 'align-middle text-center',
                'sortable': false,
                'render': function(data) {
                    var html = `<div class="btn-group btn-group-sm" role="group">
                        <a class="btn btn-outline-secondary" href="javascript:void(0)" onclick="rincian_surat('${data.id}', '${data.id_surat_masuk}', '${data.pengirim}', '${data.penerima}')"><i class="far fa-eye"></i> Buka</a>
                        <a class="btn btn-outline-info" href="javascript:void(0)" onclick="teruskan('${data.id}', '${data.id_surat_masuk}')"><i class="fas fa-location-arrow"></i> Teruskan</a>
                        <a class="btn btn-outline-danger" href="javascript:void(0)" onclick="delete_data('${data.id}')"><i class="far fa-trash-alt"></i> Hapus</a>
                    </div>`
                    return html
                }
            }],
        }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');

        $("div.toolbar").html(`
        <button class="btn btn-outline-success btn-sm d-none" id="btn-add"><i class="fas fa-plus-circle"></i> Tambah Pesan</button>
        `)

        $('body').tooltip({
            selector: '[data-toggle="tooltip"]'
        });

        $('#tambah-user').hide();
        $('#ubah-surat').hide();
        $('#rincian-surat').hide();
        $('#teruskan-surat').hide();

        $.ajax({
            url: '<?= base_url('dashboard/getunit') ?>',
            dataType: 'json',
            success: function(result) {
                var html
                result.forEach(d => {
                    html += '<option value="' + d.nama + '">' + d.nama + '</option>';
                });
                $('#unit').html(html)
            }
        });

        $.ajax({
            url: '<?= base_url('dashboard/getindeks') ?>',
            dataType: 'json',
            success: function(result) {
                var html
                result.forEach(d => {
                    html += '<option value="' + d.nama + '">' + d.nama + '</option>';
                });
                $('#indeks').html(html)
            }
        });

        $.ajax({
            url: '<?= base_url('dashboard/getuser') ?>',
            dataType: 'json',
            success: function(result) {
                var html
                result.forEach(d => {
                    html += '<option value="' + d.name + '">' + d.userid + ' - ' + d.name + '</option>';
                });
                $('#penerima').html(html)
            }
        });


    });

    function reload_table() {
        $('#data-table').DataTable().ajax.reload(null, false);
    }

    $('#btn-add').on('click', function() {
        global_status = "tambah"
        $('#tambah-user').show(500);
        $('#list-user').hide();
        $('#nomor').val('');
        $('#asal').val('');
        $('#deskripsi').val('');
    });

    function rincian_surat(id, id_surat, pengirim, penerima) {
        $('#list-user').hide();
        $('#rincian-surat').show(500);

        $.ajax({
            url: '<?= base_url('dashboard/getrincian') ?>',
            data: {
                id: id_surat,
                table: "tbl_surat_masuk"
            },
            type: 'post',
            dataType: 'json',
            success: function(result) {
                update_is_read(id)
                update_disposisi_is_read(id_surat, pengirim, penerima)
                reload_table()
                var html
                var html2
                var html3
                var html4
                var html5
                var html6
                result.forEach(d => {
                    html = '<span id="info_asal"><b>' + d.asal + '</b></span><br>';
                    html2 = '<span id="info_no">Nomor Surat : ' + d.no_surat + '</span>';
                    html3 = '<h6 id="info_tgl">' + d.date_created.substr(0, 10) + '</h6>';
                    html4 = '<h6 id="info_penerima">' + d.unit_penerima + '</h6>';
                    html5 = '<h6 id="info_indeks">' + d.indeks + '</h6>';
                    html6 = '<a href="<?= base_url() ?>dashboard/download_surat_masuk?lokasi=' + d.nama_file + '" class="btn btn-xs btn-danger"><i class="fas fa-download"></i> Download Surat</a>';
                    $('#isi').val(d.ringkasan_surat)
                });
                $('#info_asal').html(html)
                $('#info_no').html(html2)
                $('#info_tgl').html(html3)
                $('#info_penerima').html(html4)
                $('#info_indeks').html(html5)
                $('#link').html(html6)

            }
        })

        $.ajax({
            url: '<?= base_url('dashboard/getdisposisidata') ?>',
            data: {
                id: id_surat
            },
            type: 'post',
            dataType: 'json',
            success: function(result) {
                var total = 0
                $(".detail-rincian").html(``)
                result.forEach(e => {
                    $(".detail-rincian").append(`
                      <span>- ${e.penerima}</span><br>
                      `)
                    total++
                });
                $(".detail-rincian").prepend(`
                    <span><b> Disposisi (${total}) Pengguna</b></span><hr>
                    `)
            }
        })
    }

    function update_is_read(id) {
        $.ajax({
            url: '<?= base_url('dashboard/update_is_read') ?>',
            data: {
                id: id,
                table: database_table
            },
            type: 'post',
            dataType: 'json',
            success: function(result) {
                if (result.status == "success") {
                    console.log('success', result.message)
                    reload_table()
                }
            },
            error: function(err) {
                toast('error', err.responseText)
            }
        })
    }

    function update_disposisi_is_read(id_surat, pengirim, penerima) {
        $.ajax({
            url: '<?= base_url('dashboard/update_disposisi_is_read') ?>',
            data: {
                id_surat: id_surat,
                table: "tbl_disposisi",
                pengirim: pengirim,
                penerima: penerima
            },
            type: 'post',
            dataType: 'json',
            success: function(result) {
                if (result.status == "success") {
                    console.log('success', result.message)
                }
            },
            error: function(err) {
                toast('error', err.responseText)
            }
        })
    }

    function ubah_surat(id) {
        global_status = 'edit'
        global_id = id
        $('#list-user').hide();
        $('#tambah-user').show(500);

        $.ajax({
            url: '<?= base_url('dashboard/edituser') ?>',
            data: {
                id: id,
                table: database_table
            },
            type: 'post',
            dataType: 'json',
            success: function(result) {
                result.forEach(d => {
                    $('#list-user').hide();
                    $('#tambah-user').show(500);

                    $('#nomor').val(d.no_surat)
                    $('#asal').val(d.asal)
                    $('#sifat').val(d.sifat)
                    $('#indeks').val(d.indeks)
                    $('#unit').val(d.unit_penerima)
                    $('#tanggal').val(d.tanggal_surat)
                    $('#isi_surat').val(d.ringkasan_surat)
                });
            }
        })
    }

    function teruskan(id, id_surat) {
        global_id = id
        global_id_surat_masuk = id_surat
        $('#list-user').hide();
        $('#teruskan-surat').show(500);
    }

    $('#btn-hide-teruskan').on('click', function() {
        $('#teruskan-surat').hide();
        $('#list-user').show(500);
    });

    $('#btn-hide-rincian').on('click', function() {
        $('#rincian-surat').hide();
        $('#list-user').show(500);
    });

    $('#btn-hide').on('click', function() {
        $('#tambah-user').hide();
        $('#list-user').show(500);
    });

    $('#btn-hide-ubah').on('click', function() {
        $('#ubah-surat').hide();
        $('#list-user').show(500);
    });

    $("#form-input").submit(function(e) {
        e.preventDefault()

        var form_data = new FormData();
        form_data.append('table', 'tbl_surat_masuk');
        form_data.append('no_surat', $("#nomor").val());
        form_data.append('asal', $("#asal").val());
        form_data.append('sifat', $("#sifat").val());
        form_data.append('indeks', $("#indeks").val());
        form_data.append('unit_penerima', $("#unit").val());
        form_data.append('tanggal_surat', $("#tanggal").val());
        form_data.append('ringkasan_surat', $("#isi_surat").val());
        if ($('#file').val() !== "") {
            var file_data = $('#file').prop('files')[0];
            form_data.append('file', file_data);
        }

        var url_ajax = '<?= base_url() ?>dashboard/insert_surat_masuk'
        if (global_status == "edit") {
            url_ajax = '<?= base_url() ?>dashboard/update_data_surat'
            form_data.append('id', global_id);
        }

        $.ajax({
            url: url_ajax,
            type: "post",
            cache: false,
            contentType: false,
            processData: false,
            data: form_data,
            dataType: "json",
            success: function(result) {
                if (result.status == "success") {
                    toast(result.status, result.message)
                    $('#nomor').val('')
                    $('#asal').val('')
                    $('#sifat').val('')
                    $('#indeks').val('')
                    $('#unit').val('')
                    $('#tanggal').val('')
                    $('#isi_surat').val('')
                    reload_table()
                    $('#tambah-user').hide();
                    $('#list-user').show(500)
                } else {
                    toast(result.status, result.message)
                }
            },
            error: function(err) {
                toast('error', err.responseText)
            }
        })
    })

    $("#form-teruskan").submit(function(e) {
        e.preventDefault()

        var form_data = new FormData();
        form_data.append('penerima', $("#penerima").val());
        form_data.append('id_surat', global_id_surat_masuk);
        form_data.append('pesan', $("#pesan_teruskan").val());
        form_data.append('pengirim', '<?= $this->session->userdata("name") ?>');

        var url_ajax = '<?= base_url() ?>dashboard/teruskan_pesan'

        $.ajax({
            url: url_ajax,
            type: "post",
            cache: false,
            contentType: false,
            processData: false,
            data: form_data,
            dataType: "json",
            success: function(result) {
                if (result.status == "success") {
                    toast(result.status, result.message)
                    reload_table()
                    $('#list-user').show(500);
                    $('#teruskan-surat').hide();
                } else
                    toast(result.status, result.message)

            },
            error: function(err) {
                toast('error', err.responseText)
            }
        })
    })


    function delete_data(id, name) {
        Swal.fire({
            title: 'Apakah Anda Yakin ?',
            text: "Data yang dihapus tidak bisa dikembalikan!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: 'rgb(176, 176, 176)',
            confirmButtonText: 'Ya, hapus saja!',
            reverseButtons: true,
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '<?= base_url() ?>dashboard/delete_data',
                    data: {
                        id: id,
                        name: name,
                        table: database_table
                    },
                    type: 'post',
                    dataType: 'json',
                    success: function(result) {
                        if (result.status == "success") {
                            toast('success', result.message)
                            reload_table()
                        } else
                            toast('error', result.message)
                    }
                })
            }
        })
    }
</script>
