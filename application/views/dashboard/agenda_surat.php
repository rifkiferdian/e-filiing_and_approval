  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <section class="content-header">
          <div class="container-fluid">
              <div class="row mb-2">
                  <div class="col-sm-6">
                      <h1>Agenda Naskah Masuk</h1>
                  </div>
                  <div class="col-sm-6">
                      <ol class="breadcrumb float-sm-right">
                          <li class="breadcrumb-item"><a href="#">Home</a></li>
                          <li class="breadcrumb-item active">Agenda Naskah Masuk</li>
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
                                      <h3 class="card-title">Daftar Disposisi Naskah</h3>
                                  </div>
                                  <!-- <div class="col-md-6" style="text-align: right;">
                                      <button class="btn btn-success btn-sm" id="btn-add"><i class="fas fa-plus-circle"></i> Tambah</button>
                                  </div> -->
                              </div>
                          </div>
                          <!-- /.card-header -->
                          <div class="card-body">
                              <table id="example1" class="table table-bordered table-striped">
                                  <thead>
                                      <tr>
                                          <th>No</th>
                                          <th>No.Naskah</th>
                                          <th>Nomor Agenda</th>
                                          <th>Tanggal Naskah</th>
                                          <th>Pengirim</th>
                                          <th>Penerima</th>
                                          <th>Action</th>
                                      </tr>
                                  </thead>
                              </table>
                          </div>
                          <!-- /.card-body -->
                      </div>
                      <!-- /.card -->




                      <!-- /.card -->

                  </div>
              </div>
              <!-- /.row -->
          </div><!-- /.container-fluid -->
      </section>
      <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <!-- Modal -->
  <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
          <div class="modal-content">
              <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">Agenda Naskah</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                  </button>
              </div>
              <form class="form-horizontal" id="form-input">
                  <div class="modal-body">
                      <div class="card-body" style="padding: 0px;">
                          <div class="row">
                              <div class="col-md-12">
                                  <div class="form-group">
                                      <label for="nomor">Nomor Agenda</label>
                                      <input type="text" class="form-control" id="nomor_agenda" name="nomor_agenda">
                                      <input type="hidden" class="form-control" id="id_surat" name="id_surat">
                                  </div>

                              </div>
                          </div>
                      </div>
                  </div>
                  <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                      <button type="submit" id="btn_submit" class="btn btn-primary">Submit</button>
                  </div>
              </form>
          </div>
      </div>
  </div>


  <div class="modal fade" id="modalDetailNaskah" tabindex="-1" role="dialog" aria-labelledby="modalDetailNaskahLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content">
              <div class="modal-header">
                  <h5 class="modal-title" id="modalDetailNaskahLabel">Detail Naskah Masuk</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                  </button>
              </div>
              <div class="modal-body">
                  <div class="row">
                      <div class="col-md-6">
                          <dl>
                              <dt>No. Naskah</dt>
                              <dd id="detail_no_surat">-</dd>
                              <dt>Asal Naskah</dt>
                              <dd id="detail_asal">-</dd>
                              <dt>Tanggal Naskah</dt>
                              <dd id="detail_tanggal_surat">-</dd>
                              <dt>Tanggal Diterima</dt>
                              <dd id="detail_tanggal_diterima">-</dd>
                          </dl>
                      </div>
                      <div class="col-md-6">
                          <dl>
                              <dt>Unit Penerima</dt>
                              <dd id="detail_unit">-</dd>
                              <dt>Indeks</dt>
                              <dd id="detail_indeks">-</dd>
                              <dt>Sifat</dt>
                              <dd id="detail_sifat">-</dd>
                              <dt>Status</dt>
                              <dd id="detail_status">-</dd>
                          </dl>
                      </div>
                      <div class="col-md-12">
                          <dt>Ringkasan Naskah</dt>
                          <textarea class="form-control bg-white" id="detail_ringkasan" rows="5" readonly></textarea>
                      </div>
                  </div>
              </div>
              <div class="modal-footer">
                  <a href="#" class="btn btn-danger" id="detail_download" target="_blank"><i class="fas fa-download"></i> Download Naskah</a>
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
              </div>
          </div>
      </div>
  </div>


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
                  'url': '<?= base_url() ?>dashboard/ajax_table_agenda_surat',
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
                      return `<span><b>` + data.no_surat + `</b></span>`
                  }
              }, {
                  "target": [<?= $target ?>],
                  "className": 'text-center py-1',
                  "data": "data.nomor_agenda",
                  "render": function(data) {
                      if (data && data !== '') {
                          return `<span class="badge badge-success">` + data + `</span>`
                      }

                      return `<span class="badge badge-warning">Belum ada</span>`
                  }
              }, {
                  "target": [<?= $target ?>],
                  "className": 'text-center py-1',
                  "data": "data.date_created",
              }, {
                  "target": [<?= $target ?>],
                  "className": 'text-center py-1',
                  "data": "data.pengirim",
              }, {
                  "target": [<?= $target ?>],
                  "className": 'text-center py-1',
                  "data": "data.penerima",
                  "render": function(data) {
                      if (!data || data === '') {
                          return '-'
                      }

                      var penerima = data.split(', ')
                      var html = '<ol class="mb-0 pl-3 text-left">'
                      penerima.forEach(function(item) {
                          html += '<li>' + item + '</li>'
                      })
                      html += '</ol>'
                      return html
                  }
              }, {
                  "target": [<?= $target ?>],
                  "className": 'text-center py-1',
                  "data": "data",
                  "render": function(data) {
                      return `<button type="button" class="btn btn-info btn-xs mr-1" onclick="detail_naskah('` + data.id_surat + `')"><i class="fas fa-eye"></i> Detail Naskah</button><button type="button" class="btn btn-secondary btn-xs" onclick="agenda_surat('` + data.id_surat + `')"><i class="fas fa-edit"></i> Nomor Agenda</button>`
                  }
              }, ],
              "dom": '<"row" <"col-md-6" B><"col-md-6" f>>rtip',
              "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
          }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');

      });

      function reload_table() {
          $('#example1').DataTable().ajax.reload(null, false);
      }

      function reload_notifikasi() {
          $.ajax({
              url: '<?= base_url('dashboard/getcountagenda') ?>',
              dataType: 'json',
              success: function(result) {
                  console.log(result)
                  html = result;
                  $('.angka_agenda').html(html)
              }
          });
      }

      $("#form-input").submit(function(e) {
          e.preventDefault()

          var form_data = new FormData();
          form_data.append('table', 'tbl_disposisi');
          form_data.append('table2', 'tbl_surat_masuk');
          form_data.append('nomor_agenda', $("#nomor_agenda").val());
          form_data.append('id_surat', $("#id_surat").val());


          var url_ajax = '<?= base_url() ?>dashboard/update_agenda'


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
                      $('#nomor_agenda').val('')
                      reload_table()
                      reload_notifikasi()
                      $('#list-user').show(500)
                      $('#myModal').modal('hide')
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

      function agenda_surat(id) {
          $('#myModal').modal('show')
          $('#id_surat').val(id)
      }

      function detail_naskah(id) {
          $.ajax({
              url: '<?= base_url('dashboard/getrincian') ?>',
              data: {
                  id: id,
                  table: 'tbl_surat_masuk'
              },
              type: 'post',
              dataType: 'json',
              success: function(result) {
                  if (!result || result.length === 0) {
                      Swal.fire('Error!', 'Detail naskah tidak ditemukan.', 'error')
                      return
                  }

                  var d = result[0]
                  $('#detail_no_surat').text(d.no_surat || '-')
                  $('#detail_asal').text(d.asal || '-')
                  $('#detail_tanggal_surat').text(d.tanggal_surat || '-')
                  $('#detail_tanggal_diterima').text(d.tanggal_surat_diterima || '-')
                  $('#detail_unit').text(d.unit_penerima || '-')
                  $('#detail_indeks').text(d.indeks || '-')
                  $('#detail_sifat').html('<span class="badge badge-info">' + (d.sifat || '-') + '</span>')
                  $('#detail_status').html('<span class="badge badge-warning">' + (d.status_surat || '-') + '</span>')
                  $('#detail_ringkasan').val(d.ringkasan_surat || '')

                  if (d.nama_file && d.nama_file !== '') {
                      $('#detail_download')
                          .attr('href', '<?= base_url() ?>dashboard/download_surat_masuk?lokasi=' + d.nama_file)
                          .show()
                  } else {
                      $('#detail_download').hide()
                  }

                  $('#modalDetailNaskah').modal('show')
              },
              error: function(err) {
                  Swal.fire('Error!', err.responseText, 'error')
              }
          })
      }
  </script>
