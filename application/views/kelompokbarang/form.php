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
          <form action="#" method="post" id="form">                      
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
                    <button type="submit" class="btn btn-info float-right" id="btnSimpan"><i class="fa fa-save"></i> Simpan</button>
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
          $('#kdkelompok').focus();
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
                min: 17,
                max: 17,
                message: 'Panjang karakter harus 17 karakter'
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
    })
    .on('success.form.bv', function(e) {
        e.preventDefault();

        const $form = $(e.target);
        const formData = new FormData($form[0]);

        $('#btnSimpan').prop('disabled', true).html('<i class="fa fa-spin fa-spinner"></i> Menyimpan...');

        $.ajax({
            url: "<?php echo site_url('kelompokbarang/simpan') ?>",
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            dataType: 'json',
            success: function(response) {
                $('#btnSimpan').prop('disabled', false).html('<i class="fa fa-save mr-1"></i>Simpan');

                if (response.success) {
                    swal('Berhasil!', 'Data berhasil disimpan.', 'success')
                        .then(() => {
                            window.location.href = "<?php echo site_url('kelompokbarang'); ?>";
                        });
                } else {
                    swal('Gagal!', response.message, 'error');
                }
            },
            error: function(xhr) {
              console.log("XHR Response:", xhr); // Tampilkan detail XHR di console
              console.log("Response Text:", xhr.responseText); // Tampilkan response text
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
    $('#notelp').mask('0000000000000000', {reverse: true});
  }); //end (document).ready
  


</script>

</body>
</html>
