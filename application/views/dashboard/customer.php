  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <section class="content-header">
          <div class="container-fluid">
              <div class="row mb-2">
                  <div class="col-sm-6">
                      <h1>Manajemen Customer</h1>
                  </div>
                  <div class="col-sm-6">
                      <ol class="breadcrumb float-sm-right">
                          <li class="breadcrumb-item"><a href="#">Home</a></li>
                          <li class="breadcrumb-item active">Manajemen Customer</li>
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
                                      <h3 class="card-title">Master Customer</h3>
                                  </div>
                                  <div class="col-md-6" style="text-align: right;">
                                      <button class="btn btn-success btn-sm" id="btn-add"><i class="fas fa-plus-circle"></i> Tambah</button>
                                  </div>
                              </div>
                          </div>
                          <!-- /.card-header -->
                          <div class="card-body">
                              <table id="table_data" class="table table-bordered table-striped">
                                  <thead>
                                      <tr>
                                          <th>No</th>
                                          <th>Kode</th>
                                          <th>Nama Customer</th>
                                          <th>Alamat</th>
                                          <th>RT</th>
                                          <th>RW</th>
                                          <th>Contact Person</th>
                                          <th>No. HP</th>
                                          <th>Registered Date</th>
                                          <th>Action</th>
                                      </tr>
                                  </thead>
                                  <tbody></tbody>
                              </table>
                          </div>
                          <!-- /.card-body -->
                      </div>
                      <!-- /.card -->
                      <!-- general form elements -->
                      <div class="card card-secondary" id="card-tambah">
                          <div class="card-header">
                              <div class="row">
                                  <div class="col-md-6">
                                      <h3 class="card-title">Tambah Customer</h3>
                                  </div>
                                  <div class="col-md-6" style="text-align: right;">
                                      <button class="btn btn-danger btn-sm" id="btn-hide"><i class="fas fa-minus-circle"></i> Sembunyikan</button>
                                  </div>
                              </div>
                          </div>
                          <!-- /.card-header -->
                          <!-- form start -->
                          <form id="form-input">
                              <div class="card-body">
                                  <div class="row">
                                      <div class="col-md-6">
                                          <div class="form-group">
                                              <label for="kode_customer">Kode Customer</label>
                                              <input type="text" class="form-control" id="kode_customer" name="kode_customer" readonly>
                                          </div>
                                          <div class="form-group">
                                              <label for="nama_customer">Nama Customer</label>
                                              <input type="text" class="form-control" id="nama_customer" name="nama_customer" placeholder="Nama Customer" require>
                                          </div>
                                          <div class="form-group">
                                              <label for="alamat">Alamat</label>
                                              <input type="text" class="form-control" id="alamat" name="alamat" placeholder="Alamat" require>
                                          </div>
                                          <div class="form-group">
                                              <label for="rt">RT</label>
                                              <input type="text" class="form-control" id="rt" name="rt" placeholder="RT" require>
                                          </div>
                                      </div>
                                      <div class="col-md-6">

                                          <div class="form-group">
                                              <label for="contact_person">Contact Person</label>
                                              <input type="text" class="form-control" id="contact_person" name="contact_person" placeholder="Contact Person" require>
                                          </div>
                                          <div class="form-group">
                                              <label for="hp">No. HP</label>
                                              <input type="text" class="form-control" id="hp" name="hp" placeholder="No. HP" require>
                                          </div>
                                          <div class="form-group">
                                              <label for="rw">RW</label>
                                              <input type="text" class="form-control" id="rw" name="rw" placeholder="RW" require>
                                          </div>
                                      </div>
                                  </div>
                              </div>
                              <!-- /.card-body -->

                              <div class="card-footer">
                                  <button type="submit" class="btn btn-primary">Submit</button>
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

  <script>
      <?php $target = 0; ?>
      var global_id
      var action
      $(function() {
          $("#table_data").DataTable({
              //   "responsive": true,
              "lengthChange": false,
              "autoWidth": false,
              'serverSide': true,
              'processing': true,
              "order": [
                  [0, "desc"]
              ],
              'ajax': {
                  'dataType': 'json',
                  'url': '<?= base_url() ?>dashboard/ajax_table_customer',
                  'type': 'post',
              },
              'columns': [{
                  "target": [<?= $target ?>],
                  "className": 'text-center py-1',
                  "data": "data.no",
              }, {
                  "target": [<?= $target ?>],
                  "className": 'text-center py-1',
                  "data": "data.kode_customer",
              }, {
                  "target": [<?= $target ?>],
                  "className": 'text-center py-1',
                  "data": "data.nama_customer",
              }, {
                  "target": [<?= $target ?>],
                  "className": 'text-center py-1',
                  "data": "data.alamat",
              }, {
                  "target": [<?= $target ?>],
                  "className": 'text-center py-1',
                  "data": "data.rt",
              }, {
                  "target": [<?= $target ?>],
                  "className": 'text-center py-1',
                  "data": "data.rw",
              }, {
                  "target": [<?= $target ?>],
                  "className": 'text-center py-1',
                  "data": "data.contact_person",
              }, {
                  "target": [<?= $target ?>],
                  "className": 'text-center py-1',
                  "data": "data.hp",
              }, {
                  "target": [<?= $target ?>],
                  "className": 'text-center py-1',
                  "data": "data.tgl_record",
              }, {
                  "target": [<?= $target ?>],
                  "className": 'text-center py-1',
                  "data": "data",
                  "render": function(data) {
                      return `<button type="button" class="btn btn-danger btn-xs" onclick="delete_data('` + data.id + `', '` + data.nama_customer + `')"><i class="fas fa-trash"></i> Hapus</button>&nbsp;<button class="btn btn-primary btn-xs" onclick="get_detil_data('` + data.id + `')"><i class="fas fa-edit"></i> Edit</button>`
                  }
              }, ],
              "dom": '<"row" <"col-md-6" B><"col-md-6" f>>rtip',
              "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
          });

          $('#card-tambah').hide();
      });

      function reload_table() {
          $('#table_data').DataTable().ajax.reload(null, false);
      }

      function clear_table() {
          $("#nama_customer").val("")
          $("#alamat").val("")
          $("#rt").val("")
          $("#contact_person").val("")
          $("#hp").val("")
          $("#rw").val("")
      }

      $('#btn-add').on('click', function() {
          $('#card-tambah').show(500);
          $('#list-user').hide();
          clear_table()
          get_kode_sampah()
          action = "tambah"
      });

      $('#btn-hide').on('click', function() {
          $('#card-tambah').hide();
          $('#list-user').show(500);
      });

      $("#form-input").submit(function(e) {
          e.preventDefault()

          var form_data = $(this).serialize();
          var url_ajax = '<?= base_url() ?>dashboard/add_data?table=mst_customer'

          if (action == "edit") {
              url_ajax = '<?= base_url() ?>dashboard/edit_data?table=mst_customer'
              form_data = $(this).serialize() + "&id=" + global_id
          }

          $.ajax({
              url: url_ajax,
              type: "post",
              data: form_data,
              dataType: "json",
              success: function(result) {
                  if (result.status == "success") {
                      toast('success', result.message)
                      $('#card-tambah').hide();
                      $('#list-user').show(500);
                      reload_table()
                  } else
                      toast('error', result.message)
              },
              error: function(err) {
                  //   console.log(err)
                  toast('error', err.responseText)
              }
          })

      })

      function delete_data(id, name) {
          $.ajax({
              url: '<?= base_url() ?>dashboard/delete_data',
              data: {
                  id: id,
                  name: name,
                  table: "mst_customer"
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

      function get_detil_data(id) {
          action = "edit"
          global_id = id
          $.ajax({
              url: '<?= base_url() ?>dashboard/get_detail_data',
              data: {
                  id: id,
                  table: "mst_customer"
              },
              type: 'post',
              dataType: 'json',
              success: function(result) {
                  result.forEach(d => {
                      $("#kode_customer").val(d.kode_customer)
                      $("#nama_customer").val(d.nama_customer)
                      $("#alamat").val(d.alamat)
                      $("#rt").val(d.rt)
                      $("#contact_person").val(d.contact_person)
                      $("#hp").val(d.hp)
                      $("#rw").val(d.rw)
                  });
                  $('#card-tambah').show(500);
                  $('#list-user').hide();
              }
          })
      }

      function get_kode_sampah() {
          $.ajax({
              url: '<?= base_url() ?>dashboard/get_kode_master',
              type: 'post',
              data: {
                  table: "mst_customer",
                  select: "kode_customer"
              },
              dataType: 'json',
              success: function(result) {
                  $("#kode_customer").val(result)
              }
          })
      }
  </script>