<?php
$this->load->view('template/header');
$this->load->view('template/topmenu');
$this->load->view('template/sidemenu');
?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0 text-dark">Pengaturan</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="<?php echo (site_url()) ?>">Home</a></li>
            <li class="breadcrumb-item active" id="lblactive">Pengaturan Batas Waktu Penginputan</li>
          </ol>
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>
  <!-- /.content-header -->

  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
          

            <div class="row">
              <div class="col-md-12">

                <div class="card" id="cardcontent">
                  <div class="card-header">
                    <h5 class="card-title">Batas Waktu Penginputan Data</h5>
                  </div>
                  <div class="card-body">

                      <div class="col-md-12">
                        <?php
                        $pesan = $this->session->flashdata('pesan');
                        if (!empty($pesan)) {
                            echo $pesan;
                        }
                        ?>
                      </div>



 
                      <div class="row">
                        <div class="col-12">
                          <form action="<?php echo (site_url('pengaturan/simpanbataswaktupenginputan')) ?>" method="post" id="form">
                            <div class="card">
                              <div class="card-body">


                                <div class="form-group row">
                                  <?php
                                    $checked = "";
                                    if ($rowpengaturan->aktifbataspenginputan) {
                                        $checked = " checked ";
                                    }
                                    ?>
                                  <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="1" id="aktifbataspenginputan" name="aktifbataspenginputan" <?php echo $checked ?> >
                                    <label class="form-check-label" for="aktifbataspenginputan">
                                      Aktifkan batas waktu penginputan
                                    </label>
                                  </div>
                                </div>

                                <div class="form-group row" style="display: none;">
                                  <?php
                                  $checked = "";
                                  if ($rowpengaturan->sekolahbisalogin) {
                                      $checked = " checked ";
                                  }
                                  ?>
                                  <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="1" id="sekolahbisalogin" name="sekolahbisalogin" <?php echo $checked ?> >
                                    <label class="form-check-label" for="sekolahbisalogin">
                                      Sekolah Tidak Boleh Input Data Lagi
                                    </label>
                                  </div>
                                </div>

                                <div class="form-group row" style="display: none;">
                                  <?php
                                  $checked = "";
                                  if ($rowpengaturan->uptbisalogin) {
                                      $checked = " checked ";
                                  }
                                  ?>
                                  <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="1" id="uptbisalogin" name="uptbisalogin" <?php echo $checked ?> >
                                    <label class="form-check-label" for="uptbisalogin">
                                      UPT Tidak Boleh Input Data Lagi
                                    </label>
                                  </div>
                                </div>

                                <div class="form-group row">
                                  <label for="" class="col-md-4 col-form-label">Tanggal Batas Akhir penginputan</label>
                                  <div class="col-md-3">
                                    <input type="date" name="tglbataspenginputan" id="tglbataspenginputan" class="" value="<?php echo date('Y-m-d', strtotime($rowpengaturan->tglbataspenginputan)) ?>">
                                    <input type="time" name="timebataspenginputan" id="timebataspenginputan" class="" value="<?php echo date('H:i', strtotime($rowpengaturan->tglbataspenginputan)) ?>">
                                  </div>

                                  <div class="col-md-3">
                                  </div>
                                </div>



                              </div>
                              <div class="card-footer">
                                <button type="submit" class="btn btn-info float-right" id="btnSimpan"><i class="fa fa-save"></i> Simpan</button>
                              </div>
                            </div>

                          </form>

                        </div>

                        <div class="col-12">
                          <form action="<?php echo site_url('pengaturan/simpanbataswaktuperruangan') ?>" method="post" id="formPerruangan">                          
                            <div class="card">
                              <div class="card-header">
                                <h3 class="card-title">Pengecualian Batas Waktu Penginputan Untuk Sekolah Terpilih</h3>
                              </div>
                              <div class="card-body">
                                <div class="row">
                                  <div class="col-md-6">
                                    <div class="form-group">
                                      <label for="">Nama Sekolah</label>
                                      <select name="kdruangan" id="kdruangan" class="form-control js-example-basic-single">
                                        <option value="">Pilih Sekolah</option>
                                        <?php  
                                          if ($rsRuangan->num_rows()>0) {
                                            foreach ($rsRuangan->result() as $row) {
                                              echo "<option value='".$row->kdruangan."'>".$row->namaruangan."</option>";
                                            }
                                          }
                                        ?>
                                      </select>
                                    </div>
                                  </div>

                                  <div class="col-sm-8 col-md-5">
                                    <div class="row">
                                      <div class="col-12">
                                        <label for="">Tanggal Batas Akhir</label>
                                      </div>
                                      <div class="col-md-8">
                                        <input type="text" name="tglruangan" id="tglruangan" class="form-control" value="<?php echo date('Y-m-d') ?>">
                                      </div>
                                      <div class="col-md-4">
                                        <input type="time" name="timeruangan" id="timeruangan" class="form-control" value="<?php echo date('H:i') ?>">
                                      </div>
                                    </div>

                                  </div>
                                  <div class="col-sm-4 col-md-1">
                                    <button type="submit" class="btn btn-md btn-primary mt-3" id="btnSimpanPerruangan"><i class="fa fa-plus-circle"></i></button>

                                  </div>

                                  <div class="col-12 mt-3">
                                    <div class="table-responsive">
                                      <table class="table table-bordered table-striped table-condesed" id="table">
                                        <thead>
                                          <tr class="bg-info" style="">
                                            <th style="width: 5%; text-align: center;">No</th>
                                            <th style="text-align: center;">Nama Sekolah</th>
                                            <th style="width: 15%; text-align: center;">Batas Waktu</th>
                                            <th style="width: 25%; text-align: center;">Admin</th>
                                            <th style="text-align: center; width: 10%;">Aksi</th>
                                          </tr>
                                        </thead>
                                        <tbody>
                                          <?php  
                                            if ($rsPerruangan->num_rows()>0) {
                                              $no = 1;
                                              foreach ($rsPerruangan->result() as $row) {
                                                echo "<tr>
                                                      <td style='text-align: center;'>".$no++."</td>
                                                      <td style='text-align: left;'>".$row->namaruangan."</td>
                                                      <td style='text-align: center;'>".date('d-m-Y', strtotime($row->tglruangan)) . " Jam: ". date('H:i', strtotime($row->tglruangan)) ."</td>
                                                      <td style='text-align: center;'>".$row->namapengguna."</td>
                                                      <td style='text-align: center;'>
                                                        <a href='".site_url('pengaturan/hapusbataswaktuperruangan/'.$this->encrypt->encode($row->kdruangan))."' class='btn btn-xs btn-danger' id='btnHapusPerruangan'><i class='fa fa-trash'></i></a>
                                                      </td>
                                                    </tr>";
                                              }
                                            }
                                          ?>
                                          
                                        </tbody>              
                                      </table>
                                    </div>
                                  </div>
                                </div>

                              </div>
                            </div>

                          </form>
                        </div>

                      </div>





                  </div> <!-- ./card-body -->

                  <div class="card-footer">
                    
                    <a href="<?php echo (site_url()) ?>" class="btn btn-default float-right mr-1 ml-1"><i class="fa fa-chevron-circle-left"></i> Kembali</a>
                  </div>
                </div> <!-- /.card -->


              </div> <!-- /.col -->
            </div>
        </div>
      </div> <!-- /.row -->
      <!-- Main row -->
    </div> <!--/. container-fluid -->
  </section> <!-- /.content -->
</div> <!-- /.content-wrapper -->



<?php $this->load->view('template/footer')?>



<script type="text/javascript">

  

  $(document).ready(function() {

    $('.js-example-basic-single').select2();

    $('#aktifbataspenginputan').change();

    table = $('#table').DataTable();
    
    //----------------------------------------------------------------- > validasi
    $('#form').bootstrapValidator({
      feedbackIcons: {
        valid: 'glyphicon glyphicon-ok',
        invalid: 'glyphicon glyphicon-remove',
        validating: 'glyphicon glyphicon-refresh'
      },
      fields: {
        kdkelompok: {
          validators:{
            notEmpty: {
                message: 'Nama kelompok tidak boleh kosong'
            },
          }
        },
        namabarang: {
          validators:{
            notEmpty: {
                message: 'Nama barang tidak boleh kosong'
            },
            stringLength: {
                max: 100,
                message: 'Panjang karakter maksimal 100 karakter'
            },
          }
        },
      }
    })
    .on('success.form.bv', function(e) {
      $('#btnSimpan').prop('disabled', true).html('<i class="fa fa-spin fa-spinner"></i> Menyimpan...');
    });;

    $('#formPerruangan').bootstrapValidator({
      feedbackIcons: {
        valid: 'glyphicon glyphicon-ok',
        invalid: 'glyphicon glyphicon-remove',
        validating: 'glyphicon glyphicon-refresh'
      },
      fields: {
        kdruangan: {
          validators:{
            notEmpty: {
                message: 'Nama ruangan tidak boleh kosong'
            },
          }
        },
        tglruangan: {
          validators:{
            notEmpty: {
                message: 'Tanggal tidak boleh kosong'
            },
          }
        },
        timeruangan: {
          validators:{
            notEmpty: {
                message: 'Jam tidak boleh kosong'
            },
          }
        },
        
      }
    })
    .on('success.form.bv', function(e) {
      $('#btnSimpanPerruangan').prop('disabled', true).html('<i class="fa fa-spin fa-spinner"></i> Menyimpan...');
    });
  //------------------------------------------------------------------------> END VALIDASI DAN SIMPAN


    $("form").attr('autocomplete', 'off');
    $('#keybarang').mask('0000000000', {reverse: true});
  }); //end (document).ready


  $('#aktifbataspenginputan').change(function() {

    if ( $(this).prop('checked') ) {
      $('#sekolahbisalogin').attr('disabled', false);
      $('#uptbisalogin').attr('disabled', false);
      $('#tglbataspenginputan').attr('disabled', false);
      $('#timebataspenginputan').attr('disabled', false);
    }else{
      $('#sekolahbisalogin').attr('disabled', true);
      $('#uptbisalogin').attr('disabled', true);
      $('#tglbataspenginputan').attr('disabled', true);
      $('#timebataspenginputan').attr('disabled', true);
    }

  });

  $(document).on('click', '#btnHapusPerruangan', function(e) {

    e.preventDefault();

    var href = $(this).attr('href');
    swal({
            title: "Hapus?",
            text: "Apakah anda yakin akan menghapus data ini!",
            icon: "warning",
            buttons: ["Batal", "Ya"],
            dangerMode: true,
        })
        .then((willDelete) => {
            if (willDelete) {
                window.location.href = href;                    
            }
        });

  });



</script>

</body>
</html>
