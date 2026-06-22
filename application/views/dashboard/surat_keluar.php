  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <section class="content-header">
          <div class="container-fluid">
              <div class="row mb-2">
                  <div class="col-sm-6">
                      <h1>Manajemen Naskah Keluar</h1>
                  </div>
                  <div class="col-sm-6">
                      <ol class="breadcrumb float-sm-right">
                          <li class="breadcrumb-item"><a href="#">Home</a></li>
                          <li class="breadcrumb-item active">Manajemen Naskah Keluar</li>
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
                                      <h3 class="card-title">Daftar Naskah Keluar</h3>
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
                                          <th>Tujuan/No.Naskah</th>
                                          <th>Tanggal Naskah</th>
                                          <th>Unit Pengirim</th>
                                          <th>Indeks/Sifat</th>
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
                                      <h3 class="card-title">Naskah Keluar</h3>
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
                                              <label for="nomor">No. Naskah</label>
                                              <input type="text" class="form-control" id="nomor" name="nomor" placeholder="Nomor Naskah">
                                          </div>
                                          <div class="form-group">
                                              <label for="asal">Tujuan Naskah</label>
                                              <input type="text" class="form-control" id="tujuan" name="tujuan" placeholder="Tujuan Naskah">
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
                                              <label for="customFile">Upload Naskah</label>
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
                                              <label for="unit">Unit Pengirim</label>
                                              <select name="unit" id="unit" class="form-control">
                                              </select>
                                          </div>
                                          <div class="form-group">
                                              <label for="tanggal">Tanggal Naskah</label>
                                              <input type="date" class="form-control" id="tanggal" name="tanggal" placeholder="Asal Naskah">
                                          </div>
                                          <div class="form-group">
                                              <label for="template_approval">Template Approval</label>
                                              <select name="template_approval" id="template_approval" class="form-control">
                                                  <option value="">Tanpa Approval</option>
                                              </select>
                                          </div>
                                      </div>
                                  </div>
                                  <div class="row">
                                      <div class="col-md-12" style="text-align: center;margin-top: 30px;">
                                          <h3> Ringkasan Naskah</h3>
                                      </div>
                                      <div class="col-md-12">
                                          <div class="form-group">
                                              <label for="nomor">Isi Naskah</label>
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

                      <div class="card card-secondary" id="rincian-surat">
                          <div class="card-header">
                              <div class="row">
                                  <div class="col-md-6">
                                      <h3 class="card-title">Rincian Naskah Keluar</h3>
                                  </div>
                                  <div class="col-md-6" style="text-align: right;">
                                      <button class="btn btn-danger btn-sm" id="btn-hide-rincian"><i class="fas fa-minus-circle"></i> Sembunyikan</button>
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
                                                  <span id="info_asal"><b>DINAS KOMINFO</b></span>
                                                  <span id="info_no">Nomor Naskah : 001/PRES/X/2021</span>
                                              </div>
                                          </div>
                                          <span><b>Ringkasan Naskah</b></span><br>

                                          <textarea class="form-control" name="isi" id="isi" cols="30" rows="5" style="text-align: left;" readonly>Ini adalah contoh isi ringkasan surat masuk. terima kasih</textarea>
                                      </div>
                                      <div class="col-md-4 detail-rincian">
                                          <!-- <span><b> Disposisi (4) Pengguna</b></span>
                                          <hr>
                                          <span>Agus Salim</span><br>
                                          <span>Arthur Julio Risa</span><br>
                                          <span>Gilang</span><br>
                                          <span>Diana</span><br> -->
                                      </div>
                                  </div>
                                  <div class="row" style="margin-top: 20px;">
                                      <div class="col-md-2">
                                          <h6><i class="fas fa-calendar-check"></i><span> Tanggal Naskah :</span></h6>
                                          <h6 id="info_tgl">26-Oct-2021 15:56:34</h6>
                                      </div>
                                      <div class="col-md-2">
                                          <h6><i class="fas fa-briefcase"></i><span> Unit Penerima :</span></h6>
                                          <h6 id="info_penerima">Marketing</h6>
                                      </div>
                                      <div class="col-md-2">
                                          <h6><i class="fas fa-layer-group"></i><span> Indeks :</span></h6>
                                          <h6 id="info_indeks">Naskah Penting</h6>
                                      </div>
                                      <div class="col-md-2">
                                          <h6><i class="fas fa-download"></i><span> Download Lampiran :</span></h6>
                                          <a href="<?= base_url('assets/surat_masuk/') ?>" class="btn btn-sm btn-danger" id="link"> Download Naskah</a>
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
                  'url': '<?= base_url() ?>dashboard/ajax_table_surat_keluar',
                  'type': 'post',
              },
              'columns': [{
                  "target": [<?= $target ?>],
                  "className": 'align-middle text-center py-1',
                  "data": "data.no",
              }, {
                  "target": [<?= $target ?>],
                  "className": 'align-middle text-center py-1',
                  "data": "data",
                  "render": function(data) {
                      return `<span><b>` + data.tujuan + `</b></span><br>
                      <span>` + data.no_surat + `</span>`
                  }
              }, {
                  "target": [<?= $target ?>],
                  "className": 'align-middle text-center py-1',
                  "data": "data.tanggal_surat",
              }, {
                  "target": [<?= $target ?>],
                  "className": 'align-middle text-center py-1',
                  "data": "data",
                  "render": function(data) {
                      return `<span><b>` + data.unit_pengirim + `</b></span>`
                  }
              }, {
                  "target": [<?= $target ?>],
                  "className": 'align-middle text-center py-1',
                  "data": "data",
                  "render": function(data) {
                      if (data.sifat == 'Biasa') {
                          return `<span>` + data.indeks + `</span><br>
                      <span class="badge badge-success">` + data.sifat + `</span>`
                      } else if (data.sifat == 'Penting') {
                          return `<span>` + data.indeks + `</span><br>
                      <span class="badge badge-warning">` + data.sifat + `</span>`
                      } else if (data.sifat == 'Rahasia') {
                          return `<span>` + data.indeks + `</span><br>
                      <span class="badge badge-danger">` + data.sifat + `</span>`
                      }
                  }
              }, {
                  "target": [<?= $target ?>],
                  "className": 'align-middle text-center py-1',
                  "data": "data.status_approval",
                  "render": function(data) {
                      var color = 'secondary';
                      if (data == 'Disetujui') {
                          color = 'success';
                      } else if (data == 'Menunggu Approval' || data == 'Draft') {
                          color = 'warning';
                      } else if (data == 'Ditolak') {
                          color = 'danger';
                      }

                      return `<span class="badge badge-` + color + `">` + data + `</span>`;
                  }
              }, {
                  "target": [<?= $target ?>],
                  "className": 'align-middle text-center py-1',
                  "data": "data",
                  "render": function(data) {
                      return `<button type="button" class="btn btn-info btn-xs" onclick="rincian_surat('` + data.id + `', '` + data.no_surat + `')"><i class="fas fa-eye"></i> Rincian</button>&nbsp;<button type="button" class="btn btn-success btn-xs" onclick="ubah_surat('` + data.id + `', '` + data.no_surat + `')"><i class="fas fa-edit"></i> Ubah</button>&nbsp;<button type="button" class="btn btn-danger btn-xs" onclick="delete_data('` + data.id + `', '` + data.no_surat + `')"><i class="fas fa-trash"></i> Hapus</button>`
                  }
              }, ],
              "dom": '<"row" <"col-md-6" B><"col-md-6" f>>rtip',
              "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
          }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');

          $('#tambah-user').hide();
          $('#ubah-surat').hide();
          $('#rincian-surat').hide();

          $.ajax({
              url: '<?= base_url('dashboard/getunit') ?>',
              dataType: 'json',
              success: function(result) {
                  var html
                  result.forEach(d => {
                      html += '<option value=' + d.nama + '>' + d.nama + '</option>';
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
              url: '<?= base_url('dashboard/get_template_approval') ?>',
              dataType: 'json',
              success: function(result) {
                  var html = '<option value="">Tanpa Approval</option>';
                  result.forEach(d => {
                      html += '<option value="' + d.id + '">' + d.nama_template + '</option>';
                  });
                  $('#template_approval').html(html)
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
          $('#nama').val('');
          $('#kode').val('');
          $('#deskripsi').val('');
      });

      function rincian_surat(id, nomor) {
          $('#list-user').hide();
          $('#rincian-surat').show(500);

          $.ajax({
              url: '<?= base_url('dashboard/getrincian') ?>',
              data: {
                  id: id,
                  table: 'tbl_surat_keluar'
              },
              type: 'post',
              dataType: 'json',
              success: function(result) {
                  console.log(result)

                  //   $('#list-user').hide();
                  //   $('#tambah-user').show(500);

                  var html
                  var html2
                  var html3
                  var html4
                  var html5
                  var html6
                  result.forEach(d => {
                      html = '<span id="info_asal"><b>' + d.tujuan + '</b></span><br>';
                      html2 = '<span id="info_no">Nomor Naskah : ' + d.no_surat + '</span>';
                      html3 = '<h6 id="info_tgl">' + d.date_created + '</h6>';
                      html4 = '<h6 id="info_penerima">' + d.unit_pengirim + '</h6>';
                      html5 = '<h6 id="info_indeks">' + d.indeks + '</h6>';
                      html6 = '<a href="<?= base_url() ?>dashboard/download_surat_keluar?lokasi=' + d.nama_file + '" class="btn btn-sm btn-danger"> Download Naskah</a>';
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
                  table: 'tbl_surat_keluar'
              },
              type: 'post',
              dataType: 'json',
              success: function(result) {
                  result.forEach(d => {
                      $('#list-user').hide();
                      $('#tambah-user').show(500);

                      $('#nomor').val(d.no_surat)
                      $('#tujuan').val(d.tujuan)
                      $('#sifat').val(d.sifat)
                      $('#indeks').val(d.indeks)
                      $('#unit').val(d.unit_pengirim)
                      $('#tanggal').val(d.tanggal_surat)
                      $('#isi_surat').val(d.ringkasan_surat)
                      $('#template_approval').val(d.template_approval_id)
                  });
              }
          })
      }

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

          if (global_status != "edit" && $('#file').val() === "") {
              Swal.fire(
                  'error!',
                  'File Upload Wajib Ditambahkan!',
                  'error'
              )
              return
          }
          var form_data = new FormData();
          form_data.append('table', 'tbl_surat_keluar');
          form_data.append('no_surat', $("#nomor").val());
          form_data.append('tujuan', $("#tujuan").val());
          form_data.append('sifat', $("#sifat").val());
          form_data.append('indeks', $("#indeks").val());
          form_data.append('unit_pengirim', $("#unit").val());
          form_data.append('tanggal_surat', $("#tanggal").val());
          form_data.append('ringkasan_surat', $("#isi_surat").val());
          form_data.append('template_approval_id', $("#template_approval").val());
          var file_data = $('#file').prop('files')[0];
          form_data.append('file', file_data);

          var url_ajax = '<?= base_url() ?>dashboard/insert_surat_keluar'
          if (global_status == "edit") {
              url_ajax = '<?= base_url() ?>dashboard/update_surat_keluar'
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
                      $('#tujuan').val('')
                      $('#sifat').val('')
                      $('#indeks').val('')
                      $('#unit').val('')
                      $('#tanggal').val('')
                      $('#isi_surat').val('')
                      $('#template_approval').val('')
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
                          table: "tbl_surat_keluar"
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
