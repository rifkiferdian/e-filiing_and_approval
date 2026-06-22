<style>
    div.dataTables_wrapper div.dataTables_paginate ul.pagination {
        justify-content: center;
    }

    .table thead th {
        border: 0;
    }

    .table td,
    .table th {
        border-top: 1px solid #efefef;
    }

    .text-dark-blue {
        color: #173c5c !important;
    }
</style>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>List Disposisi</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                        <li class="breadcrumb-item active">Disposisi</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card shadow-none" id="list-user">
                        <div class="card-body">
                            <table id="table" class="table table-hover">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th></th>
                                        <th class="text-dark-blue">Asal/No.Surat</th>
                                        <th class="text-dark-blue">Unit Penerima</th>
                                        <th class="text-dark-blue">Nomor Agenda</th>
                                        <th class="text-dark-blue">Tanggal Disposisi</th>
                                        <th class="text-dark-blue">Status</th>
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
    <?php $target = 0; ?>
    var listPenerima = []
    var user = `<?= $this->session->userdata('name') ?>`

    $(function() {
        $("#table").DataTable({
            "lengthChange": false,
            "autoWidth": false,
            'serverSide': true,
            'processing': true,
            "order": [
                [0, "desc"]
            ],
            'ajax': {
                'dataType': 'json',
                'url': '<?= base_url() ?>dashboard/ajax_getdata',
                'type': 'post',
                'data': {
                    select_data: ['id', 'no_surat', 'penerima', 'nomor_agenda', 'is_read', 'date_created'],
                    table: 'tbl_disposisi',
                    where: {
                        pengirim: user
                    }
                }
            },
            'columns': [{
                "target": [<?= $target ?>],
                "className": 'border-bottom-1 text-center py-3 align-middle',
                "visible": false,
                "data": "data.date_created",
            }, {
                "target": [<?= $target++ ?>],
                "className": 'border-bottom-1 text-center py-3 align-middle',
                "orderable": false,
                "data": "data",
                "render": function(data) {
                    var html = `<span><i class="fas fa-envelope text-warning fa-lg"></i></span>`
                    if (data.is_read == 'YES')
                        html = `<span><i class="fas fa-envelope-open-text text-secondary fa-lg"></i></span>`

                    return html
                }
            }, {
                "target": [<?= $target ?>],
                "className": 'border-bottom-1 py-3 align-middle text-secondary',
                "data": "data",
                "render": function(data) {
                    return `<span class="${data.is_read == "NO" ? "font-weight-bold": ""}">${data.no_surat}</span>`
                }
            }, {
                "target": [<?= $target ?>],
                "className": 'border-bottom-1 py-3 align-middle text-uppercase text-secondary',
                "data": "data",
                "render": function(data) {
                    return `<span class="${data.is_read == "NO" ? "font-weight-bold": ""}">${data.penerima}</span>`
                }
            }, {
                "target": [<?= $target ?>],
                "className": 'border-bottom-1 py-3 align-middle text-secondary',
                "data": "data",
                "render": function(data) {
                    return `<span class="${data.is_read == "NO" ? "font-weight-bold": ""}">${data.nomor_agenda}</span>`
                }
            }, {
                "target": [<?= $target ?>],
                "className": 'border-bottom-1 py-3 align-middle text-secondary text-center',
                "data": "data.date_created",
                "render": function(data) {
                    return $.datepicker.formatDate('dd M, yy', new Date(data.substr(0, 10)))
                }
            }, {
                "target": [<?= $target ?>],
                "className": 'border-bottom-1 text-center py-3 align-middle',
                "data": "data",
                "render": function(data) {
                    var html = `<button type="button" class="btn btn-sm rounded-pill font-weight-bold btn-secondary text-white" style="font-size: 11px !important;">Belum Dibaca</button>`
                    if (data.is_read == 'YES')
                        html = `<button type="button" class="btn btn-sm rounded-pill font-weight-bold btn-success text-white" style="font-size: 11px !important;">Telah Dibaca</button>`

                    return html
                }
            }, ],
            "dom": '<"row" <"col-md-6" ><"col-md-6" f>>rt<"row" <"col-md-12 justify-content-center" p>>',
            "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"],
            "language": {
                "paginate": {
                    "previous": `<i class="fas fa-chevron-left"></i>`,
                    "next": `<i class="fas fa-chevron-right"></i>`,
                }
            }
        }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');

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
                var html = '<option value="none">none</option>';
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
        $('#example1').DataTable().ajax.reload(null, false);
    }

    $('#btn-add').on('click', function() {
        global_status = "tambah"
        $('#tambah-user').show(500);
        $('#list-user').hide();
        $('#nomor').val('');
        $('#asal').val('');
        $('#deskripsi').val('');
    });

    function rincian_surat(id, nomor) {
        $('#list-user').hide();
        $('#rincian-surat').show(500);

        $.ajax({
            url: '<?= base_url('dashboard/getrincian') ?>',
            data: {
                id: id,
                table: 'tbl_surat_masuk'
            },
            type: 'post',
            dataType: 'json',
            success: function(result) {
                result.forEach(d => {
                    $('#info_asal').html('<span id="info_asal"><b>' + d.asal + '</b></span><br>')
                    $('#info_no').html('<span id="info_no">Nomor Surat : ' + d.no_surat + '</span>')
                    $('#info_tgl').html('<h6 id="info_tgl">' + d.tanggal_surat + '</h6>')
                    $('#receive_tgl').html('<h6 id="receive_tgl">' + d.tanggal_surat_diterima + '</h6>')
                    $('#info_penerima').html('<h6 id="info_penerima">' + d.unit_penerima + '</h6>')
                    $('#info_indeks').html('<h6 id="info_indeks">' + d.indeks + '</h6>')
                    $('#link').attr("href", `<?= base_url() ?>dashboard/download_surat_masuk?lokasi=${d.nama_file}`)
                    $('#isi').val(d.ringkasan_surat)
                });

            }
        })

        $.ajax({
            url: '<?= base_url('dashboard/getdisposisidata') ?>',
            data: {
                id: id,
                table: 'tbl_disposisi'
            },
            type: 'post',
            dataType: 'json',
            success: function(result) {
                var total = 0
                $(".detail-rincian").html(``)
                result.forEach(e => {
                    $(".detail-rincian").append(`
                      <span>${e.penerima}</span><br>
                      `)
                    total++
                });
                $(".detail-rincian").prepend(`
                    <span><b> Disposisi (${total}) Pengguna</b></span><hr>
                    `)
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
                table: 'tbl_surat_masuk'
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

    function teruskan(id, nomor) {
        global_id = id
        nomor_surat = nomor
        $('#list-user').hide();
        $('#teruskan-surat').show(500);
        listPenerima = []
        render_penerima()
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
        form_data.append('tanggal_surat_diterima', $("#tanggal_surat_diterima").val());
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
                    Swal.fire(
                        'Success!',
                        result.message,
                        'success'
                    )
                    $('#nomor').val('')
                    $('#asal').val('')
                    $('#sifat').val('')
                    $('#indeks').val('')
                    $('#unit').val('')
                    $('#tanggal').val('')
                    $("#tanggal_surat_diterima").val('')
                    $('#isi_surat').val('')
                    reload_table()
                    $('#tambah-user').hide();
                    $('#list-user').show(500)
                } else {
                    Swal.fire(
                        'error!',
                        result.message,
                        'error'
                    )
                }
            },
            error: function(err) {
                Swal.fire(
                    'error!',
                    err.responseText,
                    'error'
                )
            }
        })
    })

    $("#penerima").on("change", function(e) {
        listPenerima.push($(this).val())
        render_penerima()
    })

    $("#form-teruskan").submit(function(e) {
        e.preventDefault()
        var form_data = new FormData(document.getElementById("form-teruskan"));
        //   form_data.append('penerima', $("#penerima").val());
        //   $(".penerima_value").each(function(i, e) {
        //       form_data.append('penerima_value[]', $(e).val())
        //   })
        form_data.append('id_surat', global_id);
        form_data.append('no_surat', nomor_surat);
        //   form_data.append('pesan', $("#pesan_teruskan").val());
        form_data.append('pengirim', '<?= $this->session->userdata("name") ?>');

        var url_ajax = '<?= base_url() ?>dashboard/teruskan_surat'

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
                    Swal.fire(
                        'Success!',
                        result.message,
                        'success'
                    )

                    reload_table()
                    $('#list-user').show(500);
                    $('#teruskan-surat').hide();
                } else {
                    Swal.fire(
                        'error!',
                        result.message,
                        'error'
                    )
                }
            },
            error: function(err) {
                Swal.fire(
                    'error!',
                    err.responseText,
                    'error'
                )
            }
        })
    })


    function delete_data(id, name) {

        Swal.fire({
            title: 'Apakah Anda Yakin ?',
            text: "Data yang dihapus tidak bisa dikembalikan!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, hapus saja!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '<?= base_url() ?>dashboard/delete_data',
                    data: {
                        id: id,
                        name: name,
                        table: "tbl_surat_masuk"
                    },
                    type: 'post',
                    dataType: 'json',
                    success: function(result) {
                        if (result.status == "success") {
                            Swal.fire(
                                'Deleted!',
                                'Data berhasil di hapus.',
                                'success'
                            )
                            reload_table()
                        } else
                            toast('error', result.message)
                    }
                })
            }
        })


    }

    function render_penerima() {
        const tablePenerima = $("#penerima-table")
        tablePenerima.show()
        if (listPenerima.length == 0) {
            tablePenerima.hide()
        }
        var html = ""
        listPenerima.forEach(function(e, i) {
            html += `<tr>`
            html += `<td><input class="form-control penerima_value" readonly value="${e}" name="penerima_value[]"></td>`
            html += `<td><button type="button" class="btn btn-sm btn-danger" onclick="delete_teruskan(${i})"><i class="fa fa-trash"></i></button></td>`
            html += `</tr>`
        })
        tablePenerima.find("tbody").html(html)
    }

    function delete_teruskan(index) {
        listPenerima.splice(index, 1)
        render_penerima()
    }
</script>