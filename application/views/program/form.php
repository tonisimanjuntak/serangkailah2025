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
          <h1 class="m-0 text-dark">Program</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="<?php echo(site_url()) ?>">Home</a></li>
            <li class="breadcrumb-item"><a href="<?php echo(site_url('Program')) ?>">Program</a></li>
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
          <form action="<?php echo(site_url('Program/simpan')) ?>" method="post" id="form">                      
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
                      <input type="hidden" name="keyprogram" value="<?php echo($keyprogram) ?>">

                      <div class="form-group row required">
                        <label for="" class="col-md-2 col-form-label">Kode Program</label>
                        <div class="col-md-2">
                          <input type="text" name="kdprogram" id="kdprogram" class="form-control" placeholder="Cth: 101010101" autofocus="">
                        </div>
                      </div>
                    
                      <div class="form-group row required">
                        <label for="" class="col-md-2 col-form-label">Nama Program</label>
                        <div class="col-md-10">
                          <input type="text" name="namaprogram" id="namaprogram" class="form-control" placeholder="Contoh: Program Pelayanan Kantor">
                        </div>
                      </div>

                  </div> <!-- ./card-body -->

                  <div class="card-footer">
                    <button type="submit" class="btn btn-info float-right"><i class="fa fa-save"></i> Simpan</button>
                    <a href="<?php echo(site_url('Program')) ?>" class="btn btn-default float-right mr-1 ml-1"><i class="fa fa-chevron-circle-left"></i> Kembali</a>
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
  
  var keyprogram = "<?php echo($keyprogram) ?>";

  $(document).ready(function() {


    //---------------------------------------------------------> JIKA EDIT DATA
    if ( keyprogram != "" ) { 
          $.ajax({
              type        : 'POST', 
              url         : '<?php echo site_url("Program/get_edit_data") ?>', 
              data        : {keyprogram: keyprogram}, 
              dataType    : 'json', 
              encode      : true
          })      
          .done(function(result) {
            $('#kdprogram').val(result.kdprogram);
            $('#namaprogram').val(result.namaprogram);
          }); 

          $('#kdprogram').attr("readonly", true);
          $('#lbljudul').html('Edit Data Program');
          $('#lblactive').html('Edit');

    }else{
          $('#lbljudul').html('Tambah Data Program');
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
        kdprogram: {
          validators:{
            notEmpty: {
                message: 'Kode program tidak boleh kosong'
            },
            stringLength: {
                min: 9,
                max: 9,
                message: 'Panjang karakter 9 karakter'
            },
          }
        },
        namaprogram: {
          validators:{
            notEmpty: {
                message: 'Nama program tidak boleh kosong'
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
    $('#keyprogram').mask('000000000', {reverse: true});
  }); //end (document).ready

</script>

</body>
</html>
