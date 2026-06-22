  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <section class="content-header">
          <div class="container-fluid">
              <div class="row mb-2">
                  <div class="col-sm-6">
                      <h1>Manajemen Indeks</h1>
                  </div>
                  <div class="col-sm-6">
                      <ol class="breadcrumb float-sm-right">
                          <li class="breadcrumb-item"><a href="#">Home</a></li>
                          <li class="breadcrumb-item active">Manajemen Indeks</li>
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
                      <div class="card card-secondary" id="list-user">
                          <div class="card-header">
                              <div class="row">
                                  <div class="col-md-6">
                                      <h3 class="card-title">Daftar Indeks</h3>
                                  </div>
                                  <div class="col-md-6" style="text-align: right;">
                                      <button class="btn btn-success btn-sm" id="btn-add"><i class="fas fa-plus-circle"></i> Tambah</button>
                                  </div>
                              </div>
                          </div>
                          <!-- /.card-header -->
                          <div class="card-body">
                              <table id="example1" class="table table-bordered table-striped">
                                  <thead>
                                      <tr>
                                          <th>No</th>
                                          <th>Nama Indeks</th>
                                          <th>Kode</th>
                                          <th>Deskripsi</th>
                                          <th>Registration Date</th>
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
                                      <h3 class="card-title">Tambah Indeks</h3>
                                  </div>
                                  <div class="col-md-6" style="text-align: right;">
                                      <button class="btn btn-danger btn-sm" id="btn-hide"><i class="fas fa-minus-circle"></i> Sembunyikan</button>
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
                                              <label for="nama">Kode Indeks</label>
                                              <input type="text" class="form-control" id="kode" name="kode" placeholder="Kode Indeks">
                                          </div>
                                          <div class="form-group">
                                              <label for="alamat">Nama Indeks</label>
                                              <input type="text" class="form-control" id="nama" name="nama" placeholder="Nama Indeks">
                                          </div>
                                          <div class="form-group">
                                              <label for="hp">Deskripsi</label>
                                              <input type="text" class="form-control" id="deskripsi" name="deskripsi" placeholder="Deskripsi">
                                          </div>
                                      </div>
                                      <div class="col-md-6">
                                          <div style="margin-top: 30px;margin-left: 20px;">
                                              <div class="callout callout-info">
                                                  <h5>Info!</h5>

                                                  <p>Kode Indeks bisa menggunakan Nomor, Inisial atau Singkatan.</p>
                                              </div>
                                          </div>

                                      </div>
                                  </div>
                              </div>
                              <div class="card-footer">
                                  <button type="submit" id="btn_submit" class="btn btn-primary">Submit</button>
                              </div>
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
      $(function() {
          $("#example1").DataTable({
              "lengthChange": false,
              "autoWidth": false,
              'serverSide': true,
              'processing': true,
              "order": [
                  [0, "desc"]
              ],
              'ajax': {
                  'dataType': 'json',
                  'url': '<?= base_url() ?>dashboard/ajax_table_indeks',
                  'type': 'post',
              },
              'columns': [{
                  "target": [<?= $target ?>],
                  "className": 'text-center py-1',
                  "data": "data.no",
              }, {
                  "target": [<?= $target ?>],
                  "className": 'text-center py-1',
                  "data": "data.nama",
              }, {
                  "target": [<?= $target ?>],
                  "className": 'text-center py-1',
                  "data": "data.kode",
              }, {
                  "target": [<?= $target ?>],
                  "className": 'text-center py-1',
                  "data": "data.deskripsi",
              }, {
                  "target": [<?= $target ?>],
                  "className": 'text-center py-1',
                  "data": "data.date_created",
              }, {
                  "target": [<?= $target ?>],
                  "className": 'text-center py-1',
                  "data": "data",
                  "render": function(data) {
                      return `<button type="button" class="btn btn-danger btn-xs" onclick="delete_data('` + data.id + `', '` + data.nama + `')"><i class="fas fa-trash"></i> Hapus</button> `
                  }
              }, ],
              "dom": '<"row" <"col-md-6" B><"col-md-6" f>>rtip',
              "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
          }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');

          $('#tambah-user').hide();
      });

      function reload_table() {
          $('#example1').DataTable().ajax.reload(null, false);
      }

      $('#btn-add').on('click', function() {
          $('#tambah-user').show(500);
          $('#list-user').hide();
          $('#nama').val('');
          $('#kode').val('');
          $('#deskripsi').val('');
      });

      $('#btn-hide').on('click', function() {
          $('#tambah-user').hide();
          $('#list-user').show(500);
      });

      $("#form-input").submit(function(e) {
          e.preventDefault()

          var form_data = $(this).serialize();
          var url_ajax = '<?= base_url() ?>dashboard/addindeks'

          $.ajax({
              url: url_ajax,
              type: "post",
              data: form_data,
              dataType: "json",
              success: function(result) {
                  if (result.status == 200) {
                      Swal.fire({
                          icon: 'success',
                          title: 'Berhasil!',
                          text: 'Indeks baru berhasil dibuat!',
                      })
                      reload_table()
                      $('#tambah-user').hide();
                      $('#list-user').show(500);
                      $('#nama').val('');
                      $('#kode').val('');
                      $('#deskripsi').val('');
                      //   $('#modaltask2').modal('hide')
                  } else {
                      Swal.fire({
                          icon: 'error',
                          title: 'Oops...',
                          text: 'Something went wrong!'
                      })
                  }
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
                          table: "mst_indeks"
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
  </script>