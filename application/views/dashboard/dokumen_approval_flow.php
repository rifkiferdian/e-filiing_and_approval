<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Setting Flow Approval</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Setting Flow Approval</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="card card-secondary" id="list-flow">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-6">
                            <h3 class="card-title">Daftar Flow Approval Dokumen</h3>
                        </div>
                        <div class="col-md-6 text-right">
                            <button class="btn btn-success btn-sm" id="btn-add"><i class="fas fa-plus-circle"></i> Tambah</button>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <table id="table-flow" class="table table-bordered table-striped w-100">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Flow</th>
                                <th>Jenis</th>
                                <th>Step</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>

            <div class="card card-secondary" id="form-flow">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-6">
                            <h3 class="card-title" id="form-title">Tambah Flow Approval</h3>
                        </div>
                        <div class="col-md-6 text-right">
                            <button class="btn btn-danger btn-sm" id="btn-hide"><i class="fas fa-minus-circle"></i> Sembunyikan</button>
                        </div>
                    </div>
                </div>
                <form id="form-input">
                    <input type="hidden" id="flow_id" name="flow_id">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-5">
                                <div class="form-group">
                                    <label>Nama Flow</label>
                                    <input type="text" class="form-control" id="name" name="name" placeholder="Contoh: Approval Dokumen Kontrak">
                                </div>
                                <div class="form-group">
                                    <label>Jenis Dokumen</label>
                                    <select class="form-control" id="document_type" name="document_type">
                                        <option value="semua">Semua Dokumen</option>
                                        <option value="dokumen">Dokumen Approval</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Deskripsi</label>
                                    <textarea class="form-control" id="description" name="description" rows="4"></textarea>
                                </div>
                            </div>
                            <div class="col-md-7">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <label class="mb-0">Step Approval</label>
                                    <button type="button" class="btn btn-outline-primary btn-sm" id="btn-add-step"><i class="fas fa-plus"></i> Tambah Step</button>
                                </div>
                                <div id="step-list"></div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary" id="btn-save">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </section>
</div>

<script>
    var users = [];

    $(function() {
        $('#form-flow').hide();

        $('#table-flow').DataTable({
            responsive: true,
            lengthChange: false,
            autoWidth: false,
            ajax: {
                url: '<?= base_url('dashboard/ajax_table_doc_approval_flows') ?>',
                type: 'post',
                dataType: 'json'
            },
            columns: [{
                data: 'no',
                className: 'text-center'
            }, {
                data: null,
                render: function(data, type, row) {
                    return '<b>' + escape_html(row.name) + '</b><br><small>' + escape_html(row.description || '-') + '</small>';
                }
            }, {
                data: 'document_type',
                className: 'text-center',
                render: function(data) {
                    return '<span class="badge badge-info">' + escape_html(data) + '</span>';
                }
            }, {
                data: 'steps',
                render: function(steps) {
                    if (!steps || steps.length === 0) {
                        return '<span class="badge badge-warning">Belum ada step</span>';
                    }

                    var html = '<ol class="mb-0 pl-3">';
                    steps.forEach(function(step) {
                        html += '<li><b>' + escape_html(step.step_name) + '</b> <span class="badge badge-warning">' + escape_html(step.approval_mode) + '</span><br>';
                        html += '<small>';
                        (step.approvers || []).forEach(function(user, index) {
                            html += (index > 0 ? ', ' : '') + escape_html(user.approver_name);
                        });
                        html += '</small></li>';
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
                data: null,
                className: 'text-center',
                render: function() {
                    return '<button type="button" class="btn btn-warning btn-xs mr-1 btn-edit"><i class="fas fa-edit"></i> Edit</button>' +
                        '<button type="button" class="btn btn-danger btn-xs btn-delete"><i class="fas fa-trash"></i> Hapus</button>';
                }
            }],
            dom: '<"row" <"col-md-6" B><"col-md-6" f>>rtip',
            buttons: ['copy', 'csv', 'excel', 'pdf', 'print', 'colvis']
        }).buttons().container().appendTo('#table-flow_wrapper .col-md-6:eq(0)');

        $.ajax({
            url: '<?= base_url('dashboard/getuser') ?>',
            dataType: 'json',
            success: function(result) {
                users = result;
                reset_form();
            }
        });
    });

    function escape_html(value) {
        return $('<div>').text(value || '').html();
    }

    function reload_table() {
        $('#table-flow').DataTable().ajax.reload(null, false);
    }

    $('#btn-add').on('click', function() {
        reset_form();
        $('#list-flow').hide();
        $('#form-flow').show(500);
    });

    $('#btn-hide').on('click', function() {
        $('#form-flow').hide();
        $('#list-flow').show(500);
    });

    $('#btn-add-step').on('click', function() {
        add_step();
    });

    function reset_form() {
        $('#flow_id').val('');
        $('#name').val('');
        $('#document_type').val('semua');
        $('#description').val('');
        $('#step-list').html('');
        $('#form-title').text('Tambah Flow Approval');
        $('#btn-save').text('Simpan');
        add_step();
    }

    function user_options(selected) {
        var html = '<option value="">Pilih Approver</option>';
        users.forEach(function(user) {
            html += '<option value="' + user.userid + '" ' + (selected == user.userid ? 'selected' : '') + '>' + user.userid + ' - ' + user.name + '</option>';
        });
        return html;
    }

    function reindex_steps() {
        $('#step-list .approval-step').each(function(stepIndex) {
            $(this).find('.step-number').text(stepIndex + 1);
            $(this).find('.step-name').attr('name', 'steps[' + stepIndex + '][name]');
            $(this).find('.step-mode').attr('name', 'steps[' + stepIndex + '][mode]');
            $(this).find('.step-approver').attr('name', 'steps[' + stepIndex + '][approvers][]');
        });
    }

    function add_step(step) {
        var stepIndex = $('#step-list .approval-step').length;
        var stepName = step ? step.step_name : '';
        var mode = step ? step.approval_mode : 'ANY';

        var html = '<div class="border rounded p-3 mb-3 approval-step">' +
            '<div class="row">' +
            '<div class="col-md-1"><span class="badge badge-primary step-number">' + (stepIndex + 1) + '</span></div>' +
            '<div class="col-md-5"><input type="text" class="form-control step-name" name="steps[' + stepIndex + '][name]" placeholder="Nama step" value="' + escape_html(stepName) + '"></div>' +
            '<div class="col-md-3"><select class="form-control step-mode" name="steps[' + stepIndex + '][mode]"><option value="ANY" ' + (mode == 'ANY' ? 'selected' : '') + '>ANY</option><option value="ALL" ' + (mode == 'ALL' ? 'selected' : '') + '>ALL</option></select></div>' +
            '<div class="col-md-3 text-right"><button type="button" class="btn btn-outline-danger btn-sm btn-remove-step"><i class="fas fa-trash"></i></button></div>' +
            '</div>' +
            '<div class="approver-list mt-2"></div>' +
            '<button type="button" class="btn btn-outline-primary btn-xs btn-add-approver mt-2"><i class="fas fa-user-plus"></i> Tambah Approver</button>' +
            '</div>';

        $('#step-list').append(html);
        var current = $('#step-list .approval-step').last();
        if (step && step.approvers && step.approvers.length > 0) {
            step.approvers.forEach(function(approver) {
                add_approver(current, approver.approver_userid);
            });
        } else {
            add_approver(current);
        }
        reindex_steps();
    }

    function add_approver(stepEl, selected) {
        var stepIndex = $('#step-list .approval-step').index(stepEl);
        stepEl.find('.approver-list').append(
            '<div class="input-group mb-2 approver-row">' +
            '<select class="form-control step-approver" name="steps[' + stepIndex + '][approvers][]">' + user_options(selected) + '</select>' +
            '<div class="input-group-append"><button type="button" class="btn btn-outline-danger btn-remove-approver"><i class="fas fa-times"></i></button></div>' +
            '</div>'
        );
    }

    $(document).on('click', '.btn-add-approver', function() {
        add_approver($(this).closest('.approval-step'));
        reindex_steps();
    });

    $(document).on('click', '.btn-remove-approver', function() {
        $(this).closest('.approver-row').remove();
    });

    $(document).on('click', '.btn-remove-step', function() {
        $(this).closest('.approval-step').remove();
        reindex_steps();
    });

    $('#table-flow').on('click', '.btn-edit', function() {
        var row = $('#table-flow').DataTable().row($(this).closest('tr')).data();
        if (!row) {
            row = $('#table-flow').DataTable().row($(this).closest('tr').prev()).data();
        }

        $('#flow_id').val(row.id);
        $('#name').val(row.name);
        $('#document_type').val(row.document_type);
        $('#description').val(row.description);
        $('#step-list').html('');
        (row.steps || []).forEach(function(step) {
            add_step(step);
        });
        $('#form-title').text('Edit Flow Approval');
        $('#btn-save').text('Update');
        $('#list-flow').hide();
        $('#form-flow').show(500);
    });

    $('#table-flow').on('click', '.btn-delete', function() {
        var row = $('#table-flow').DataTable().row($(this).closest('tr')).data();
        if (!row) {
            row = $('#table-flow').DataTable().row($(this).closest('tr').prev()).data();
        }

        Swal.fire({
            title: 'Hapus flow approval?',
            text: 'Flow yang sudah dipakai tidak bisa dihapus.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya, hapus'
        }).then(function(result) {
            if (result.isConfirmed) {
                $.ajax({
                    url: '<?= base_url('dashboard/delete_doc_approval_flow') ?>',
                    type: 'post',
                    dataType: 'json',
                    data: {
                        id: row.id
                    },
                    success: function(response) {
                        Swal.fire(response.status === 'success' ? 'Success!' : 'Error!', response.message, response.status);
                        reload_table();
                    }
                });
            }
        });
    });

    $('#form-input').on('submit', function(e) {
        e.preventDefault();

        $.ajax({
            url: $('#flow_id').val() ? '<?= base_url('dashboard/update_doc_approval_flow') ?>' : '<?= base_url('dashboard/simpan_doc_approval_flow') ?>',
            type: 'post',
            data: $(this).serialize(),
            dataType: 'json',
            success: function(result) {
                Swal.fire(result.status === 'success' ? 'Success!' : 'Error!', result.message, result.status);
                if (result.status === 'success') {
                    reset_form();
                    reload_table();
                    $('#form-flow').hide();
                    $('#list-flow').show(500);
                }
            },
            error: function(err) {
                Swal.fire('Error!', err.responseText, 'error');
            }
        });
    });
</script>
