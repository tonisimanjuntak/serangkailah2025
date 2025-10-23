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
          <form action="#" method="post" id="form">
            <div class="row">
              <div class="col-md-12">
                <div class="card" id="cardcontent">
                  <div class="card-header">
                    <h5 class="card-title">Batas Waktu Penginputan Data</h5>
                  </div>
                  <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group row">
                                <label for="" class="col-md-4 col-form-label">Default Sekolah</label>
                                <div class="col-md-8">
                                    <select name="defaultsekolah" id="defaultsekolah" class="form-control">
                                        <option value="">-- Pilih Sekolah --</option>
                                        <?php
                                        foreach ($listsekolah as $rowsekolah) {
                                            $selected = "";
                                            if ($rowsekolah->kdruangan == $this->session->userdata('kdruangan')) {
                                                $selected = " selected ";
                                            }
                                            echo "<option value='" . $rowsekolah->kdruangan . "' " . $selected . ">" . $rowsekolah->namaruangan . "</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>




                      





                  </div> <!-- ./card-body -->

                  <div class="card-footer">
                    <button type="submit" class="btn btn-info float-right" id="btnSimpan"><i class="fa fa-save"></i> Simpan</button>
                    <a href="<?php echo (site_url()) ?>" class="btn btn-default float-right mr-1 ml-1"><i class="fa fa-chevron-circle-left"></i> Kembali</a>
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



<?php $this->load->view('template/footer')?>



<script type="text/javascript">

  $(document).ready(function() {

    $('#form').submit(function (e) { 
        e.preventDefault();
        const $form = $(e.target);
        const formData = new FormData($form[0]);

        $('#btnSimpan').prop('disabled', true).html('<i class="fa fa-spin fa-spinner"></i> Menyimpan...');

        $.ajax({
            url: "<?php echo site_url('pengaturan/simpandefaultsekolah') ?>",
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
                            window.location.href = "<?php echo site_url('pengaturan/defaultsekolah'); ?>";
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

    $('.js-example-basic-single').select2();

    $("form").attr('autocomplete', 'off');
  }); //end (document).ready



</script>

</body>
</html>
