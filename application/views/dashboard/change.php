  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <section class="content-header">
          <div class="container-fluid">
              <div class="row mb-2">
                  <div class="col-sm-6">
                      <h1>Manajemen User</h1>
                  </div>
                  <div class="col-sm-6">
                      <ol class="breadcrumb float-sm-right">
                          <li class="breadcrumb-item"><a href="#">Home</a></li>
                          <li class="breadcrumb-item active">Ubah Password</li>
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
                      <!-- general form elements -->
                      <div class="card card-secondary">
                          <div class="card-header">
                              <div class="row">
                                  <div class="col-md-6">
                                      <h3 class="card-title">Ubah Password</h3>
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
                                              <label for="nama">Password Baru</label>
                                              <input type="password" class="form-control" id="password" name="password">
                                          </div>
                                          <div class="form-group">
                                              <label for="alamat">Konfirmasi Password Baru</label>
                                              <input type="password" class="form-control" id="konfirmasi_password" name="konfirmasi_password">
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
      $("#form-input").submit(function(e) {
          e.preventDefault()

          var form_data = $(this).serialize();
          var url_ajax = '<?= base_url() ?>dashboard/ubahpassword'

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
                          text: 'Berhasil ubah Password!',
                      })
                      $('#password').val('');
                      $('#konfirmasi_password').val('');
                      //   $('#modaltask2').modal('hide')
                  } else if (result.status == 400) {
                      Swal.fire({
                          icon: 'error',
                          title: 'Oops...',
                          text: 'Gagal ubah password!'
                      })
                  } else if (result.status == 500) {
                      Swal.fire({
                          icon: 'error',
                          title: 'Oops...',
                          text: 'Password tidak sama!'
                      })
                  }
              }
          })

      })
  </script>