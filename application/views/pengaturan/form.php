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
            <li class="breadcrumb-item"><a href="<?php echo(site_url()) ?>">Home</a></li>
            <li class="breadcrumb-item"><a href="<?php echo(site_url('pengaturan')) ?>">Pengaturan</a></li>
            <li class="breadcrumb-item active" id="lblactive"></li>
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
          <form action="<?php echo(site_url('pengaturan/simpan')) ?>" method="post" id="form">                      
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
                          </div>    
                        </div>
                      </div>

                      



                  </div> <!-- ./card-body -->

                  <div class="card-footer">
                    <button type="submit" class="btn btn-info float-right"><i class="fa fa-save"></i> Simpan</button>
                    <a href="<?php echo(site_url('pengaturan')) ?>" class="btn btn-default float-right mr-1 ml-1"><i class="fa fa-chevron-circle-left"></i> Kembali</a>
                  </div>
                </div> <!-- /.card -->
              </div> <!-- /.col -->
            </div>
          </form>
        </div>
      </div> <!-- /.row -->
      <!-- Main row -->
    </div> <!--/. container-fluid -->
  </section> <!-- /.content -->
</div> <!-- /.content-wrapper -->
  


<?php $this->load->view('template/footer') ?>



<script type="text/javascript">
  
  var keybarang = "<?php echo($keybarang) ?>";

  $(document).ready(function() {

    $('.js-example-basic-single').select2();
 
    $('#aktifbataspenginputan').change();

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



</script>

</body>
</html>
