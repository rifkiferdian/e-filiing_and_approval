  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <section class="content-header">
          <div class="container-fluid">
              <div class="row mb-2">
                  <div class="col-sm-6">
                      <h1>Manajemen Naskah Masuk</h1>
                  </div>
                  <div class="col-sm-6">
                      <ol class="breadcrumb float-sm-right">
                          <li class="breadcrumb-item"><a href="#">Home</a></li>
                          <li class="breadcrumb-item active">Manajemen Naskah Masuk</li>
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
                                      <h3 class="card-title">Daftar Naskah Masuk</h3>
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
                                          <th>Asal/No.Naskah</th>
                                          <th>Tanggal Naskah</th>
                                          <th>Unit Penerima</th>
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
                                      <h3 class="card-title">Naskah Masuk</h3>
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
                                              <label for="asal">Asal Naskah</label>
                                              <input type="text" class="form-control" id="asal" name="asal" placeholder="Asal Naskah">
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
                                              <label for="file">Upload Naskah</label>
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
                                              <label for="tanggal">Tanggal Naskah Diterima</label>
                                              <input type="date" class="form-control" id="tanggal_surat_diterima" name="tanggal_surat_diterima" placeholder="Asal Naskah">
                                          </div>
                                          <div class="form-group">
                                              <label for="tanggal">Tanggal Naskah</label>
                                              <input type="date" class="form-control" id="tanggal" name="tanggal" placeholder="Asal Naskah">
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


                      <div class="card card-secondary" id="teruskan-surat">
                          <div class="card-header">
                              <div class="row">
                                  <div class="col-md-6">
                                      <h3 class="card-title">Teruskan Naskah Masuk</h3>
                                  </div>
                                  <div class="col-md-6" style="text-align: right;">
                                      <button class="btn btn-danger btn-sm" id="btn-hide-teruskan"><i class="fas fa-minus-circle"></i> Sembunyikan</button>
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
                                              <select name="penerima" id="penerima" class="form-control w-25"></select>
                                          </div>
                                          <div>
                                              <table class="table" id="penerima-table">
                                                  <thead>
                                                      <tr>
                                                          <th>Penerima</th>
                                                          <th>#</th>
                                                      </tr>
                                                  </thead>
                                                  <tbody></tbody>
                                              </table>
                                          </div>
                                          <div class="form-group">
                                              <label for="pesan_teruskan">Pesan</label>
                                              <input name="pesan_teruskan" id="pesan_teruskan" class="form-control">
                                          </div>
                                      </div>
                                  </div>
                              </div>
                              <div class="card-footer">
                                  <button type="submit" id="btn_submit" class="btn btn-primary">Kirim</button>
                              </div>
                          </form>
                      </div>



                      <div class="card card-secondary" id="rincian-surat">
                          <div class="card-header">
                              <div class="row">
                                  <div class="col-md-6">
                                      <h3 class="card-title">Rincian Naskah Masuk</h3>
                                  </div>
                                  <div class="col-md-6" style="text-align: right;">
                                      <button class="btn btn-danger btn-sm" id="btn-hide-rincian"><i class="fas fa-minus-circle"></i> Sembunyikan</button>
                                  </div>
                              </div>
                          </div>
                          <!-- /.card-header -->
                          <!-- form start -->
                          <form class="form-horizontal">
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

                                          <textarea class="form-control" name="isi" id="isi" cols="30" rows="5" style="text-align: left;background: white; border:0" readonly>Ini adalah contoh isi ringkasan surat masuk. terima kasih</textarea>
                                      </div>
                                      <div class="col-md-4 detail-rincian"></div>
                                  </div>
                                  <div class="row" style="margin-top: 20px;">
                                      <div class="col-md-2">
                                          <h6><i class="fas fa-calendar-check"></i><span> Tanggal Naskah :</span></h6>
                                          <h6 id="info_tgl">26-Oct-2021 15:56:34</h6>
                                      </div>
                                      <div class="col-md-2">
                                          <h6><i class="fas fa-calendar-alt"></i><span> Tanggal Diterima :</span></h6>
                                          <h6 id="receive_tgl">26-Oct-2021 15:56:34</h6>
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
                                          <a href="<?= base_url('assets/surat_masuk/') ?>" class="btn btn-sm btn-primary" id="link"><i class="fas fa-download"></i> Download Naskah</a>
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
      var listPenerima = []

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
                  'url': '<?= base_url() ?>dashboard/ajax_table_surat_masuk',
                  'type': 'post',
              },
              'columns': [{
                  "target": [<?= $target ?>],
                  "className": 'text-center py-1',
                  "data": "data.no",
              }, {
                  "target": [<?= $target ?>],
                  "className": 'text-center py-1',
                  "data": "data",
                  "render": function(data) {
                      return `<span><b>` + data.asal + `</b></span><br>
                      <span>` + data.no_surat + `</span>`
                  }
              }, {
                  "target": [<?= $target ?>],
                  "className": 'text-center py-1',
                  "data": "data.tanggal_surat",
              }, {
                  "target": [<?= $target ?>],
                  "className": 'text-center py-1',
                  "data": "data",
                  "render": function(data) {
                      return `<span><b>` + data.unit_penerima + `</b></span>`
                  }
              }, {
                  "target": [<?= $target ?>],
                  "className": 'text-center py-1',
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
                  "className": 'text-center py-1',
                  "data": "data",
                  "render": function(data) {
                      if (data.status_surat == 'Didisposisikan') {
                          return `<span class="badge badge-info">` + data.status_surat + `</span>`
                      } else if (data.status_surat == 'Belum diteruskan') {
                          return `<span class="badge badge-warning">` + data.status_surat + `</span>`
                      }
                  }
              }, {
                  "target": [<?= $target ?>],
                  "className": 'text-center py-1',
                  "data": "data",
                  "render": function(data) {
                      return `<button type="button" class="btn btn-info btn-xs" onclick="rincian_surat('` + data.id + `', '` + data.no_surat + `')"><i class="fas fa-eye"></i> Rincian</button>&nbsp;<button type="button" class="btn btn-success btn-xs" onclick="ubah_surat('` + data.id + `')"><i class="fas fa-edit"></i> Ubah</button>&nbsp;<button type="button" class="btn btn-secondary btn-xs" onclick="teruskan('` + data.id + `', '` + data.no_surat + `')"><i class="fas fa-share-square"></i> Teruskan</button>&nbsp;<button type="button" class="btn btn-danger btn-xs" onclick="delete_data('` + data.id + `', '` + data.no_surat + `')"><i class="fas fa-trash"></i> Hapus</button>`
                  }
              }, ],
              "dom": '<"row" <"col-md-6" B><"col-md-6" f>>rtip',
              "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
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
                      $('#info_no').html('<span id="info_no">Nomor Naskah : ' + d.no_surat + '</span>')
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

          if ($('#file').val() === "") {
              Swal.fire(
                  'error!',
                  'File Upload Wajib Ditambahkan!',
                  'error'
              )
              return
          }
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
          var file_data = $('#file').prop('files')[0];
          form_data.append('file', file_data);

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
