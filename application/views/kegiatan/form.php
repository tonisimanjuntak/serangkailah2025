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
          <h1 class="m-0 text-dark">Kegiatan</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="<?php echo(site_url()) ?>">Home</a></li>
            <li class="breadcrumb-item"><a href="<?php echo(site_url('Kegiatan')) ?>">Kegiatan</a></li>
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
          <form action="<?php echo(site_url('Kegiatan/simpan')) ?>" method="post" id="form">                      
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
                      <input type="hidden" name="keykegiatan" value="<?php echo($keykegiatan) ?>">

                      <div class="form-group row required">
                        <label for="" class="col-md-2 col-form-label">Nama Program</label>
                        <div class="col-md-2">
                          <input type="text" name="kdprogram" id="kdprogram" class="form-control" readonly="">
                          <input type="hidden" name="keyprogram" id="keyprogram" class="form-control" readonly="">
                        </div>
                        <div class="col-md-8">
                          <input type="text" name="namaprogram" id="namaprogram" class="form-control" placeholder="Contoh: Program Pelayanan Kantor" autofocus="">
                        </div>
                      </div>

                      <div class="form-group row required">
                        <label for="" class="col-md-2 col-form-label">Kode Kegiatan</label>
                        <div class="col-md-2">
                          <input type="text" name="kdkegiatan" id="kdkegiatan" class="form-control" placeholder="Cth: 10101010101">
                        </div>
                      </div>
                    
                      <div class="form-group row required">
                        <label for="" class="col-md-2 col-form-label">Nama Kegiatan</label>
                        <div class="col-md-10">
                          <input type="text" name="namakegiatan" id="namakegiatan" class="form-control" placeholder="Contoh: Kegiatan Pelayanan Kantor">
                        </div>
                      </div>


                  </div> <!-- ./card-body -->

                  <div class="card-footer">
                    <button type="submit" class="btn btn-info float-right"><i class="fa fa-save"></i> Simpan</button>
                    <a href="<?php echo(site_url('Kegiatan')) ?>" class="btn btn-default float-right mr-1 ml-1"><i class="fa fa-chevron-circle-left"></i> Kembali</a>
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
  
  var keykegiatan = "<?php echo($keykegiatan) ?>";

  $(document).ready(function() {


    //---------------------------------------------------------> JIKA EDIT DATA
    if ( keykegiatan != "" ) { 
          $.ajax({
              type        : 'POST', 
              url         : '<?php echo site_url("Kegiatan/get_edit_data") ?>', 
              data        : {keykegiatan: keykegiatan}, 
              dataType    : 'json', 
              encode      : true
          })      
          .done(function(result) {
            $('#kdkegiatan').val(result.kdkegiatan);
            $('#namakegiatan').val(result.namakegiatan);
            $('#keyprogram').val(result.keyprogram);
            $('#kdprogram').val(result.kdprogram);
            $('#namaprogram').val(result.namaprogram);
          }); 

          $('#kdkegiatan').attr("readonly", true);
          $('#namaprogram').attr("readonly", true);
          $('#lbljudul').html('Edit Data Kegiatan');
          $('#lblactive').html('Edit');

    }else{
          $('#lbljudul').html('Tambah Data Kegiatan');
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
        kdkegiatan: {
          validators:{
            notEmpty: {
                message: 'Kode kegiatan tidak boleh kosong'
            },
            stringLength: {
                min: 11,
                max: 11,
                message: 'Panjang karakter 11 karakter'
            },
          }
        },
        namakegiatan: {
          validators:{
            notEmpty: {
                message: 'Nama kegiatan tidak boleh kosong'
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
    $('#kdkegiatan').mask('00000000000', {reverse: true});
  }); //end (document).ready


  $( "#namaprogram").autocomplete({
      minLength: 0,
      source: function( request, response ){
          $.ajax({
            type: "POST",
            url: "<?php echo site_url('Umum/ajax_getprogram'); ?>",
            dataType: "json",
            data:{term: request.term},
            success: function(data){
              response( data );
            }
          });
      },
      focus: function( event, ui ) {
        $('#kdprogram').val(ui.item.kdprogram);
        $('#keyprogram').val(ui.item.keyprogram);
        $('#namaprogram').val(ui.item.namaprogram);
        return false;
      },
      select: function( event, ui ) {
        $('#kdprogram').val(ui.item.kdprogram);
        $('#keyprogram').val(ui.item.keyprogram);
        $('#namaprogram').val(ui.item.namaprogram);
        $('#kdkegiatan').val(ui.item.kdprogram);
        $('#kdkegiatan').focus();
        return false;
      }
    })
    .autocomplete( "instance" )._renderItem = function( ul, item ) {
      return $( "<li>" )
        .append( "<div><b>"+item.kdprogram +" "+ item.namaprogram + "</b></div>" )
        .appendTo( ul );
    };

</script>

</body>
</html>
