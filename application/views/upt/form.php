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
          <h1 class="m-0 text-dark">UPT</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="<?php echo(site_url()) ?>">Home</a></li>
            <li class="breadcrumb-item"><a href="<?php echo(site_url('upt')) ?>">UPT</a></li>
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
          <form action="<?php echo(site_url('upt/simpan')) ?>" method="post" id="form">                      
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
                      <input type="hidden" name="kdupt" id="kdupt">
                    
                      <div class="form-group row required">
                        <label for="" class="col-md-2 col-form-label">Nama UPT</label>
                        <div class="col-md-10">
                          <input type="text" name="namaupt" id="namaupt" class="form-control" placeholder="Contoh: UPT Timur" <?php echo ($this->session->userdata('akseslevel')=='1') ? 'readonly="readonly"' : ''; ?>>
                        </div>
                      </div>

                      <div class="form-group row">
                        <label for="" class="col-md-2 col-form-label">Alamat</label>
                        <div class="col-md-10">
                          <textarea name="alamat" id="alamat" class="form-control" rows="2" placeholder="Alamat UPT"></textarea>
                        </div>
                      </div>

                      <div class="form-group row">
                        <label for="" class="col-md-2 col-form-label">No Telp</label>
                        <div class="col-md-10">
                          <input type="text" name="notelp" id="notelp" class="form-control" placeholder="Contoh: 061872828">
                        </div>
                      </div>

                      <div class="form-group row" style="display: none;">
                        <label for="" class="col-md-2 col-form-label">SKPD</label>
                        <div class="col-md-10">
                          <select name="kdskpd" id="kdskpd" class="form-control">

                            <?php  
                              $rsskpd = $this->db->query("select * from skpd order by kdskpd");
                              if ($rsskpd->num_rows()>0) {
                                foreach ($rsskpd->result() as $row) {
                                  echo '<option value="'.$row->kdskpd.'">'.$row->namaskpd.'</option>';
                                }
                              }
                            ?>
                          </select>
                        </div>
                      </div>
                      
                  </div> <!-- ./card-body -->

                  <div class="card-footer">
                    <button type="submit" class="btn btn-info float-right"><i class="fa fa-save"></i> Simpan</button>
                    <a href="<?php echo(site_url('upt')) ?>" class="btn btn-default float-right mr-1 ml-1"><i class="fa fa-chevron-circle-left"></i> Kembali</a>
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
  
  var kdupt = "<?php echo($kdupt) ?>";

  $(document).ready(function() {


    //---------------------------------------------------------> JIKA EDIT DATA
    if ( kdupt != "" ) { 
          $.ajax({
              type        : 'POST', 
              url         : '<?php echo site_url("upt/get_edit_data") ?>', 
              data        : {kdupt: kdupt}, 
              dataType    : 'json', 
              encode      : true
          })      
          .done(function(result) {
            $('#kdupt').val(result.kdupt);
            $('#namaupt').val(result.namaupt);
            $('#alamat').val(result.alamat);
            $('#notelp').val(result.notelp);
            $('#kdskpd').val(result.kdskpd);
          }); 

          $('#lbljudul').html('Edit Data UPT');
          $('#lblactive').html('Edit');

    }else{
          $('#lbljudul').html('Tambah Data UPT');
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
        namaupt: {
          validators:{
            notEmpty: {
                message: 'Nama ruangan tidak boleh kosong'
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
    $('#notelp').mask('0000000000000000', {reverse: true});
  }); //end (document).ready
  


</script>

</body>
</html>
