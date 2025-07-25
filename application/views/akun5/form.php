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
          <h1 class="m-0 text-dark">Akun</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="<?php echo(site_url()) ?>">Home</a></li>
            <li class="breadcrumb-item"><a href="<?php echo(site_url('Akun5')) ?>">Akun</a></li>
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
          <form action="<?php echo(site_url('Akun5/simpan')) ?>" method="post" id="form">                      
            <div class="row">
              <div class="col-md-12">
                <div class="card" id="cardcontent">
                  <div class="card-header">
                    <h5 class="card-title" id="lbljudul"></h5>
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
                      <input type="hidden" name="keyakun5" value="<?php echo($keyakun5) ?>">

                      <div class="form-group row required">
                        <label for="" class="col-md-2 col-form-label">Kode Akun</label>
                        <div class="col-md-2">
                          <input type="text" name="kdakun5" id="kdakun5" class="form-control" placeholder="Cth: 5220101" autofocus="">
                        </div>
                      </div>
                    
                      <div class="form-group row required">
                        <label for="" class="col-md-2 col-form-label">Nama Akun</label>
                        <div class="col-md-10">
                          <input type="text" name="namaakun5" id="namaakun5" class="form-control" placeholder="Contoh: Belanja ATK">
                        </div>
                      </div>
                      

                  </div> <!-- ./card-body -->

                  <div class="card-footer">
                    <button type="submit" class="btn btn-info float-right"><i class="fa fa-save"></i> Simpan</button>
                    <a href="<?php echo(site_url('Akun5')) ?>" class="btn btn-default float-right mr-1 ml-1"><i class="fa fa-chevron-circle-left"></i> Kembali</a>
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
  
  var keyakun5 = "<?php echo($keyakun5) ?>";

  $(document).ready(function() {


    //---------------------------------------------------------> JIKA EDIT DATA
    if ( keyakun5 != "" ) { 
          $.ajax({
              type        : 'POST', 
              url         : '<?php echo site_url("Akun5/get_edit_data") ?>', 
              data        : {keyakun5: keyakun5}, 
              dataType    : 'json', 
              encode      : true
          })      
          .done(function(result) {
            $('#kdakun5').val(result.kdakun5);
            $('#namaakun5').val(result.namaakun5);
          }); 
          $('#kdakun5').attr("readonly", true);
          $('#lbljudul').html('Edit Data Akun');
          $('#lblactive').html('Edit');

    }else{
          $('#lbljudul').html('Tambah Data Akun');
          $('#lblactive').html('Tambah');
    }     

    //----------------------------------------------------------------- > validasi
    $('#form').bootstrapValidator({
      feedbackIcons: {
        valid: 'glyphicon glyphicon-ok',
        invalid: 'glyphicon glyphicon-remove',
        validating: 'glyphicon glyphicon-refresh'
      },
      fields: {
        kdakun5: {
          validators:{
            notEmpty: {
                message: 'Kode akun tidak boleh kosong'
            },
            stringLength: {
                min: 7,
                max: 7,
                message: 'Panjang karakter 7 karakter'
            },
          }
        },
        namaakun5: {
          validators:{
            notEmpty: {
                message: 'Nama akun tidak boleh kosong'
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
    $('#keyakun5').mask('0000000', {reverse: true});
  }); //end (document).ready
  

</script>

</body>
</html>
