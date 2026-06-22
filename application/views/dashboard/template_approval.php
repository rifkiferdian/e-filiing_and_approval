<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Template Approval</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Template Approval</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-secondary" id="list-template">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-md-6">
                                    <h3 class="card-title">Daftar Template Approval</h3>
                                </div>
                                <div class="col-md-6 text-right">
                                    <button class="btn btn-success btn-sm" id="btn-add"><i class="fas fa-plus-circle"></i> Tambah</button>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <table id="table-template" class="table table-bordered table-striped w-100">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Template</th>
                <th>Approver</th>
                                        <th>Status</th>
                                        <th>Tanggal</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>

                    <div class="card card-secondary" id="form-template">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-md-6">
                                    <h3 class="card-title" id="form-title">Tambah Template Approval</h3>
                                </div>
                                <div class="col-md-6 text-right">
                                    <button class="btn btn-danger btn-sm" id="btn-hide"><i class="fas fa-minus-circle"></i> Sembunyikan</button>
                                </div>
                            </div>
                        </div>
                        <form id="form-input">
                            <input type="hidden" id="template_id" name="template_id">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Nama Template</label>
                                            <input type="text" class="form-control" id="nama_template" name="nama_template" placeholder="Contoh: Surat Universitas">
                                        </div>
                                        <div class="form-group">
                                            <label>Deskripsi</label>
                                            <textarea class="form-control" id="deskripsi" name="deskripsi" rows="4" placeholder="Keterangan penggunaan template"></textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Urutan Approver</label>
                                            <div id="approver-list"></div>
                                            <button type="button" class="btn btn-outline-primary btn-sm mt-2" id="btn-add-approver"><i class="fas fa-plus"></i> Tambah Approver</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary" id="btn-save">Simpan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<script>
    var users = [];

    $(function() {
        $('#form-template').hide();

        $('#table-template').DataTable({
            responsive: true,
            lengthChange: false,
            autoWidth: false,
            ajax: {
                url: '<?= base_url('dashboard/ajax_table_template_approval') ?>',
                type: 'post',
                dataType: 'json'
            },
            columns: [{
                data: 'no',
                className: 'text-center'
            }, {
                data: null,
                render: function(data, type, row) {
                    return '<b>' + row.nama_template + '</b><br><small>' + (row.deskripsi || '-') + '</small>';
                }
            }, {
                data: 'approvers',
                render: function(data) {
                    if (!data || data.length === 0) {
                        return '<span class="badge badge-warning">Belum ada approver</span>';
                    }

                    var html = '<ol class="mb-0 pl-3">';
                    data.forEach(function(row) {
                        html += '<li><b>' + row.approver_name + '</b><br><small>' + row.approver_userid + '</small></li>';
                    });
                    html += '</ol>';
                    return html;
                }
            }, {
                data: 'is_active',
                className: 'text-center',
                render: function(data) {
                    return data == 1 ? '<span class="badge badge-success">Aktif</span>' : '<span class="badge badge-secondary">Nonaktif</span>';
                }
            }, {
                data: 'date_created'
            }, {
                data: null,
                className: 'text-center',
                render: function(data, type, row) {
                    return '<button type="button" class="btn btn-warning btn-xs mr-1 btn-edit-template"><i class="fas fa-edit"></i> Edit</button>' +
                        '<button type="button" class="btn btn-danger btn-xs" onclick="hapus_template(' + row.id + ')"><i class="fas fa-trash"></i> Hapus</button>';
                }
            }],
            dom: '<"row" <"col-md-6" B><"col-md-6" f>>rtip',
            buttons: ['copy', 'csv', 'excel', 'pdf', 'print', 'colvis']
        }).buttons().container().appendTo('#table-template_wrapper .col-md-6:eq(0)');

        $.ajax({
            url: '<?= base_url('dashboard/getuser') ?>',
            dataType: 'json',
            success: function(result) {
                users = result;
                tambah_approver();
            }
        });
    });

    function reload_table() {
        $('#table-template').DataTable().ajax.reload(null, false);
    }

    $('#btn-add').on('click', function() {
        reset_form_template();
        $('#list-template').hide();
        $('#form-template').show(500);
    });

    $('#btn-hide').on('click', function() {
        reset_form_template();
        $('#form-template').hide();
        $('#list-template').show(500);
    });

    $('#btn-add-approver').on('click', function() {
        tambah_approver();
    });

    function tambah_approver(selected) {
        var index = $('#approver-list .approver-row').length + 1;
        var options = '<option value="">Pilih Approver</option>';
        users.forEach(function(user) {
            var isSelected = selected == user.userid ? 'selected' : '';
            options += '<option value="' + user.userid + '" ' + isSelected + '>' + user.userid + ' - ' + user.name + '</option>';
        });

        $('#approver-list').append(
            '<div class="input-group mb-2 approver-row">' +
            '<div class="input-group-prepend"><span class="input-group-text">' + index + '</span></div>' +
            '<select name="approver_userid[]" class="form-control">' + options + '</select>' +
            '<div class="input-group-append"><button type="button" class="btn btn-outline-danger btn-remove-approver"><i class="fas fa-times"></i></button></div>' +
            '</div>'
        );
    }

    function reset_form_template() {
        $('#template_id').val('');
        $('#nama_template').val('');
        $('#deskripsi').val('');
        $('#approver-list').html('');
        $('#form-title').text('Tambah Template Approval');
        $('#btn-save').text('Simpan');
        tambah_approver();
    }

    function show_form_template() {
        $('#list-template').hide();
        $('#form-template').show(500);
    }

    $('#table-template').on('click', '.btn-edit-template', function() {
        var row = $('#table-template').DataTable().row($(this).closest('tr')).data();
        if (!row) {
            row = $('#table-template').DataTable().row($(this).closest('tr').prev()).data();
        }

        $('#template_id').val(row.id);
        $('#nama_template').val(row.nama_template);
        $('#deskripsi').val(row.deskripsi);
        $('#approver-list').html('');

        if (row.approvers && row.approvers.length > 0) {
            row.approvers.forEach(function(approver) {
                tambah_approver(approver.approver_userid);
            });
        } else {
            tambah_approver();
        }

        $('#form-title').text('Edit Template Approval');
        $('#btn-save').text('Update');
        show_form_template();
    });

    $(document).on('click', '.btn-remove-approver', function() {
        $(this).closest('.approver-row').remove();
    });

    $('#form-input').on('submit', function(e) {
        e.preventDefault();

        $.ajax({
            url: $('#template_id').val() ? '<?= base_url('dashboard/update_template_approval') ?>' : '<?= base_url('dashboard/simpan_template_approval') ?>',
            type: 'post',
            data: $(this).serialize(),
            dataType: 'json',
            success: function(result) {
                if (result.status === 'success') {
                    Swal.fire('Success!', result.message, 'success');
                    reset_form_template();
                    reload_table();
                    $('#form-template').hide();
                    $('#list-template').show(500);
                } else {
                    Swal.fire('Error!', result.message, 'error');
                }
            },
            error: function(err) {
                Swal.fire('Error!', err.responseText, 'error');
            }
        });
    });

    function hapus_template(id) {
        Swal.fire({
            title: 'Hapus template?',
            text: 'Template approval yang dihapus tidak bisa dikembalikan.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya, hapus'
        }).then(function(result) {
            if (result.isConfirmed) {
                $.ajax({
                    url: '<?= base_url('dashboard/delete_template_approval') ?>',
                    type: 'post',
                    dataType: 'json',
                    data: {
                        id: id
                    },
                    success: function(response) {
                        Swal.fire(response.status === 'success' ? 'Success!' : 'Error!', response.message, response.status);
                        reload_table();
                    }
                });
            }
        });
    }
</script>
