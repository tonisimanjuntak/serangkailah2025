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
          <h1 class="m-0 text-dark">Barang</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="<?php echo(site_url()) ?>">Home</a></li>
            <li class="breadcrumb-item"><a href="<?php echo(site_url('Barang')) ?>">Barang</a></li>
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
          <form action="<?php echo(site_url('Barang/simpan')) ?>" method="post" id="form">                      
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
                      <input type="hidden" name="keybarang" id="keybarang" value="<?php echo($keybarang) ?>">
                    
                      <div class="form-group row required">
                        <label for="kdbarang" class="col-md-2 col-form-label">Kode Barang</label>
                        <div class="col-md-3">
                          <input type="text" name="kdbarang" id="kdbarang" class="form-control">
                        </div>
                      </div>

                      <div class="form-group row required">
                        <label for="" class="col-md-2 col-form-label">Nama Barang</label>
                        <div class="col-md-10">
                          <input type="text" name="namabarang" id="namabarang" class="form-control" placeholder="Contoh: Kertas HVS 30 Gr">
                        </div>
                      </div>

                      
                      <div class="form-group row required">
                        <label for="" class="col-md-2 col-form-label">Kelompok</label>
                        <div class="col-md-10">
                          <select name="kdkelompok" id="kdkelompok" class="form-control js-example-basic-single">
                            <option value="">Pilih kelompok barang</option>
                            <?php  
                              $rskelompok = $this->db->query("select * from kelompokbarang where statusaktif='1' order by namakelompok");
                              foreach ($rskelompok->result() as $rowkelompok) {
                                echo '<option value="'.$rowkelompok->kdkelompok.'">'.$rowkelompok->namakelompok.'</option>';
                              }
                            ?>
                          </select>
                        </div>
                      </div>

                      <div class="form-group row">
                        <label for="" class="col-md-2 col-form-label">Merk</label>
                        <div class="col-md-10">
                          <input type="text" name="merk" id="merk" class="form-control" placeholder="Contoh: Sinar Dunia">
                        </div>
                      </div>

                      <div class="form-group row">
                        <label for="" class="col-md-2 col-form-label">Type</label>
                        <div class="col-md-10">
                          <input type="text" name="type" id="type" class="form-control" placeholder="Contoh: 30 Gr">
                        </div>
                      </div>

                      <div class="form-group row">
                        <label for="" class="col-md-2 col-form-label">Satuan</label>
                        <div class="col-md-10">
                          <input type="text" name="satuan" id="satuan" class="form-control" placeholder="Contoh: Rim">
                        </div>
                      </div>
                      

                  </div> <!-- ./card-body -->

                  <div class="card-footer">
                    <button type="submit" class="btn btn-info float-right" id="btnSimpan"><i class="fa fa-save"></i> Simpan</button>
                    <a href="<?php echo(site_url('Barang')) ?>" class="btn btn-default float-right mr-1 ml-1"><i class="fa fa-chevron-circle-left"></i> Kembali</a>
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

    //---------------------------------------------------------> JIKA EDIT DATA
    if ( keybarang != "" ) { 
          
          $.ajax({
              type        : 'POST', 
              url         : '<?php echo site_url("Barang/get_edit_data") ?>', 
              data        : {keybarang: keybarang}, 
              dataType    : 'json', 
              encode      : true
          })      
          .done(function(result) {
            $('#keybarang').val(result.keybarang);
            $('#kdbarang').val(result.kdbarang);
            $('#namabarang').val(result.namabarang);
            $('#kdkelompok').val(result.kdkelompok).trigger('change');
            $('#merk').val(result.merk);
            $('#type').val(result.type);
            $('#satuan').val(result.satuan);
          }); 
          $('#namabarang').focus();
          $('#lbljudul').html('Edit Data Barang');
          $('#lblactive').html('Edit');

    }else{
          $('#kdbarang').focus();
          $('#kdbarang').attr('readonly', false);
          $('#lbljudul').html('Tambah Data Barang');
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
        kdbarang: {
          validators:{
            notEmpty: {
                message: 'Kode barang tidak boleh kosong'
            },
            stringLength: {
                min: 22,
                max: 22,
                message: 'Panjang karakter harus 22 karakter'
            },
          }
        },
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
        e.preventDefault();

        const $form = $(e.target);
        const formData = new FormData($form[0]);

        $('#btnSimpan').prop('disabled', true).html('<i class="fa fa-spin fa-spinner"></i> Menyimpan...');

        $.ajax({
            url: "<?php echo site_url('barang/simpan') ?>",
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            dataType: 'json',
            success: function(response) {
              console.log(response);
                $('#btnSimpan').prop('disabled', false).html('<i class="fa fa-save mr-1"></i>Simpan');

                if (response.success) {
                    swal('Berhasil!', 'Data berhasil disimpan.', 'success')
                        .then(() => {
                            window.location.href = "<?php echo site_url('barang'); ?>";
                        });
                } else {
                    swal('Gagal!', response.message, 'error');
                }
            },
            error: function(xhr) {
                $('#btnSimpan').prop('disabled', false).html('<i class="fa fa-save mr-1"></i>Simpan');

                let message = 'Terjadi kesalahan.';
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    message = xhr.responseJSON.message;
                } else if (xhr.status === 422) {
                    const errors = xhr.responseJSON.errors;
                    message = Object.values(errors).flat().join('<br>');
                } else if (xhr.responseText) {
                    try {
                        const parsedResponse = JSON.parse(xhr.responseText);
                        if (parsedResponse.message) {
                            message = parsedResponse.message;
                        }
                    } catch (e) {
                        message = xhr.responseText;
                    }
                }

                swal('Error!', message, 'error');
            }
        });

    });
  //------------------------------------------------------------------------> END VALIDASI DAN SIMPAN


    $("form").attr('autocomplete', 'off');
    $('#keybarang').mask('0000000000', {reverse: true});
  }); //end (document).ready
  


  $( "#namaakun5").autocomplete({
      minLength: 0,
      source: function( request, response ){
          $.ajax({
            type: "POST",
            url: "<?php echo site_url('Umum/ajax_getakun'); ?>",
            dataType: "json",
            data:{term: request.term},
            success: function(data){
              response( data );
            }
          });
      },
      focus: function( event, ui ) {
        $('#keyakun5').val(ui.item.keyakun5);
        $('#namaakun5').val(ui.item.namaakun5);
        return false;
      },
      select: function( event, ui ) {
        $('#keyakun5').val(ui.item.keyakun5);
        $('#namaakun5').val(ui.item.namaakun5);
        $('#merk').focus();
        return false;
      }
    })
    .autocomplete( "instance" )._renderItem = function( ul, item ) {
      return $( "<li>" )
        .append( "<div><b>"+item.keyakun5 +" "+ item.namaakun5 + "</b></div>" )
        .appendTo( ul );
    };

</script>

</body>
</html>
