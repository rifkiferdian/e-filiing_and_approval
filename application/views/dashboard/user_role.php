  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <section class="content-header">
          <div class="container-fluid">
              <div class="row mb-2">
                  <div class="col-sm-6">
                      <h1>Manajemen User Role</h1>
                  </div>
                  <div class="col-sm-6">
                      <ol class="breadcrumb float-sm-right">
                          <li class="breadcrumb-item"><a href="#">Home</a></li>
                          <li class="breadcrumb-item active">User Role</li>
                      </ol>
                  </div>
              </div>
          </div>
      </section>

      <!-- Main content -->
      <section class="content">
          <div class="container-fluid">
              <div class="row">
                  <div class="col-md-12">
                      <div class="card card-secondary" id="list-role">
                          <div class="card-header">
                              <div class="row">
                                  <div class="col-md-6">
                                      <h3 class="card-title">Daftar User Role</h3>
                                  </div>
                                  <div class="col-md-6" style="text-align: right;">
                                      <button class="btn btn-success btn-sm" id="btn-add"><i class="fas fa-plus-circle"></i> Tambah</button>
                                  </div>
                              </div>
                          </div>
                          <div class="card-body">
                              <table id="table-role" class="table table-bordered table-striped">
                                  <thead>
                                      <tr>
                                          <th>No</th>
                                          <th>Nama Role</th>
                                          <th>Jumlah User</th>
                                          <th>Action</th>
                                      </tr>
                                  </thead>
                              </table>
                          </div>
                      </div>

                      <div class="card card-secondary" id="tambah-role">
                          <div class="card-header">
                              <div class="row">
                                  <div class="col-md-6">
                                      <h3 class="card-title">Tambah User Role</h3>
                                  </div>
                                  <div class="col-md-6" style="text-align: right;">
                                      <button class="btn btn-danger btn-sm" id="btn-hide"><i class="fas fa-minus-circle"></i> Sembunyikan</button>
                                  </div>
                              </div>
                          </div>
                          <form class="form-horizontal" id="form-input">
                              <input type="hidden" id="id" name="id">
                              <div class="card-body">
                                  <div class="row">
                                      <div class="col-md-6">
                                          <div class="form-group">
                                              <label for="role">Nama Role</label>
                                              <input type="text" class="form-control" id="role" name="role" placeholder="Contoh: Kepala Unit">
                                          </div>
                                      </div>
                                  </div>
                              </div>
                              <div class="card-footer">
                                  <button type="submit" id="btn_submit" class="btn btn-primary">Submit</button>
                              </div>
                          </form>
                      </div>
                  </div>
              </div>
          </div>
      </section>
  </div>

  <script>
      $(function() {
          $("#table-role").DataTable({
              "lengthChange": false,
              "autoWidth": false,
              'serverSide': true,
              'processing': true,
              "order": [
                  [0, "asc"]
              ],
              'ajax': {
                  'dataType': 'json',
                  'url': '<?= base_url() ?>dashboard/ajax_table_user_role',
                  'type': 'post',
              },
              'columns': [{
                  "className": 'text-center py-1',
                  "data": "data.no",
              }, {
                  "className": 'py-1',
                  "data": "data.role",
              }, {
                  "className": 'text-center py-1',
                  "data": "data.jumlah_user",
              }, {
                  "className": 'text-center py-1',
                  "data": "data",
                  "orderable": false,
                  "render": function(data) {
                      var role = escape_attr(data.role);
                      return `<button type="button" class="btn btn-warning btn-xs btn-edit-role" data-id="` + data.id + `" data-role="` + role + `"><i class="fas fa-edit"></i> Edit</button> ` +
                          `<button type="button" class="btn btn-danger btn-xs btn-delete-role" data-id="` + data.id + `" data-role="` + role + `"><i class="fas fa-trash"></i> Hapus</button>`;
                  }
              }],
              "dom": '<"row" <"col-md-6" B><"col-md-6" f>>rtip',
              "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
          }).buttons().container().appendTo('#table-role_wrapper .col-md-6:eq(0)');

          $('#tambah-role').hide();
      });

      function escape_attr(value) {
          return String(value || '')
              .replace(/&/g, '&amp;')
              .replace(/"/g, '&quot;')
              .replace(/'/g, '&#39;')
              .replace(/</g, '&lt;')
              .replace(/>/g, '&gt;');
      }

      function reload_table() {
          $('#table-role').DataTable().ajax.reload(null, false);
      }

      $('#btn-add').on('click', function() {
          $('#tambah-role').show(500);
          $('#list-role').hide();
          $('#id').val('');
          $('#role').val('');
      });

      $('#btn-hide').on('click', function() {
          $('#tambah-role').hide();
          $('#list-role').show(500);
      });

      $("#form-input").submit(function(e) {
          e.preventDefault();

          $.ajax({
              url: '<?= base_url() ?>dashboard/adduserrole',
              type: "post",
              data: $(this).serialize(),
              dataType: "json",
              success: function(result) {
                  if (result.status == 200) {
                      Swal.fire({
                          icon: 'success',
                          title: 'Berhasil!',
                          text: result.message,
                      });
                      reload_table();
                      $('#tambah-role').hide();
                      $('#list-role').show(500);
                      $('#id').val('');
                      $('#role').val('');
                  } else {
                      Swal.fire({
                          icon: 'error',
                          title: 'Oops...',
                          text: result.message || 'Something went wrong!'
                      });
                  }
              }
          });
      });

      $(document).on('click', '.btn-edit-role', function() {
          edit_data($(this).data('id'), $(this).data('role'));
      });

      $(document).on('click', '.btn-delete-role', function() {
          delete_data($(this).data('id'), $(this).data('role'));
      });

      function edit_data(id, role) {
          $('#tambah-role').show(500);
          $('#list-role').hide();
          $('#id').val(id);
          $('#role').val(role);
      }

      function delete_data(id, role) {
          Swal.fire({
              title: 'Apakah Anda Yakin ?',
              text: "Role yang dihapus tidak bisa dikembalikan!",
              icon: 'warning',
              showCancelButton: true,
              confirmButtonColor: '#3085d6',
              cancelButtonColor: '#d33',
              confirmButtonText: 'Ya, hapus saja!'
          }).then((result) => {
              if (result.isConfirmed) {
                  $.ajax({
                      url: '<?= base_url() ?>dashboard/delete_user_role',
                      data: {
                          id: id,
                          role: role
                      },
                      type: 'post',
                      dataType: 'json',
                      success: function(result) {
                          if (result.status == "success") {
                              Swal.fire(
                                  'Deleted!',
                                  'Role berhasil di hapus.',
                                  'success'
                              );
                              reload_table();
                          } else {
                              Swal.fire({
                                  icon: 'error',
                                  title: 'Tidak bisa dihapus',
                                  text: result.message
                              });
                          }
                      }
                  });
              }
          });
      }
  </script>
