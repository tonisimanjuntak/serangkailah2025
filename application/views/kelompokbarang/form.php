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
          <h1 class="m-0 text-dark">Kelompok Barang</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="<?php echo(site_url()) ?>">Home</a></li>
            <li class="breadcrumb-item"><a href="<?php echo(site_url('Kelompokbarang')) ?>">Kelompok Barang</a></li>
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
          <form action="<?php echo(site_url('Kelompokbarang/simpan')) ?>" method="post" id="form">                      
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
                      <input type="hidden" name="ltambah" class="form-control" id="ltambah" value="<?php echo $ltambah ?>">
                      <div class="form-group row">
                        <label for="kdkelompok" class="col-md-2 col-form-label">Kode Kelompok Barang</label>
                        <div class="col-md-3">
                          <input type="text" name="kdkelompok" id="kdkelompok" class="form-control" placeholder="Contoh: A0001">
                        </div>
                      </div>
                    
                      <div class="form-group row">
                        <label for="" class="col-md-2 col-form-label">Nama Kelompok</label>
                        <div class="col-md-10">
                          <input type="text" name="namakelompok" id="namakelompok" class="form-control" placeholder="Contoh: Alat Tulis Kantor">
                        </div>
                      </div>

                      <div class="form-group row">
                        <label for="" class="col-md-2 col-form-label">Status Aktif</label>
                        <div class="col-md-10">
                          <select name="statusaktif" id="statusaktif" class="form-control">
                            <option value="1">Aktif</option>
                            <option value="0">Tidak Aktif</option>
                          </select>
                        </div>
                      </div>
                      
                  </div> <!-- ./card-body -->

                  <div class="card-footer">
                    <button type="submit" class="btn btn-info float-right"><i class="fa fa-save"></i> Simpan</button>
                    <a href="<?php echo(site_url('Kelompokbarang')) ?>" class="btn btn-default float-right mr-1 ml-1"><i class="fa fa-chevron-circle-left"></i> Kembali</a>
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
  
  var kdkelompok = "<?php echo($kdkelompok) ?>";

  $(document).ready(function() {


    //---------------------------------------------------------> JIKA EDIT DATA
    if ( kdkelompok != "" ) { 
        $('#kdkelompok').attr('readonly', true);
        
          $.ajax({
              type        : 'POST', 
              url         : '<?php echo site_url("Kelompokbarang/get_edit_data") ?>', 
              data        : {kdkelompok: kdkelompok}, 
              dataType    : 'json', 
              encode      : true
          })      
          .done(function(result) {
            $('#kdkelompok').val(result.kdkelompok);
            $('#namakelompok').val(result.namakelompok);
            $('#statusaktif').val(result.statusaktif);
            $('#namakelompok').focus();
          }); 

          $('#lbljudul').html('Edit Data Kelompokbarang');
          $('#lblactive').html('Edit');

    }else{
          $('#kdkelompok').attr('readonly', false);
          $('#lbljudul').html('Tambah Data Kelompokbarang');
          $('#lblactive').html('Tambah');
          $('$kdkelompok').focus();
    }     

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
                message: 'Kode Kelompok barang tidak boleh kosong'
            },
            stringLength: {
                max: 5,
                message: 'Panjang karakter maksimal 5 karakter'
            },
          }
        },
        namakelompok: {
          validators:{
            notEmpty: {
                message: 'Nama Kelompok barang tidak boleh kosong'
            },
            stringLength: {
                min: 2,
                max: 100,
                message: 'Panjang karakter maksimal 100 karakter'
            },
          }
        },
      }
    });
  //------------------------------------------------------------------------> END VALIDASI DAN SIMPAN


    $("form").attr('autocomplete', 'off');
    $('#notelp').mask('0000000000000000', {reverse: true});
  }); //end (document).ready
  


</script>

</body>
</html>
