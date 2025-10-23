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
            <li class="breadcrumb-item active" id="lblactive">Pengaturan Penandatangan</li>
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
                    <h5 class="card-title">Penandatangan Laporan</h5>
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
                                <label for="" class="col-md-3 col-form-label">Kepala Sekolah</label>
                                <div class="col-md-9">

                                  <select name="idpenandatangan_kepsek" id="idpenandatangan_kepsek" class="form-control select2">
                                    <option value="">---Pilih nama kepala sekolah---</option>
                                    <?php
$rsttdkepsek = $this->db->query("select * from penandatangan where idstruktur='01' and kdruangan='" . $this->session->userdata('kdruangan') . "'");
if ($rsttdkepsek->num_rows() > 0) {
    foreach ($rsttdkepsek->result() as $row) {
        $selected = '';
        if ($row->idpenandatangan == $idpenandatangan_kepsek) {
            $selected = ' selected="selected" ';
        }

        echo '
                                            <option value="' . $row->idpenandatangan . '" ' . $selected . '>' . $row->namapenandatangan . '</option>
                                          ';
    }
}
?>
                                  </select>
                                </div>
                              </div>


                              <div class="form-group row">
                                <label for="" class="col-md-3 col-form-label">Pengurus Barang</label>
                                <div class="col-md-9">

                                  <select name="idpenandatangan_pengurusbarang" id="idpenandatangan_pengurusbarang" class="form-control select2">
                                    <option value="">---Pilih nama pengurus barang---</option>
                                    <?php
$rsttdkepsek = $this->db->query("select * from penandatangan where idstruktur='02' and kdruangan='" . $this->session->userdata('kdruangan') . "'");
if ($rsttdkepsek->num_rows() > 0) {
    foreach ($rsttdkepsek->result() as $row) {

        $selected = '';
        if ($row->idpenandatangan == $idpenandatangan_pengurusbarang) {
            $selected = ' selected="selected" ';
        }

        echo '
                                            <option value="' . $row->idpenandatangan . '"' . $selected . '>' . $row->namapenandatangan . '</option>
                                          ';
    }
}
?>
                                  </select>
                                </div>
                              </div>










                            </div>
                          </div>
                        </div>
                      </div>





                  </div> <!-- ./card-body -->

                  <div class="card-footer">
                    <button type="submit" class="btn btn-info float-right" id="btnsimpan"><i class="fa fa-save"></i> Simpan</button>
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

    $('.js-example-basic-single').select2();

    //----------------------------------------------------------------- > validasi
    $('#form').bootstrapValidator({
      feedbackIcons: {
        valid: 'glyphicon glyphicon-ok',
        invalid: 'glyphicon glyphicon-remove',
        validating: 'glyphicon glyphicon-refresh'
      },
      fields: {
        idpenandatangan_kepsek: {
          validators:{
            notEmpty: {
                message: 'Nama kepala sekolah tidak boleh kosong'
            },
          }
        },
        idpenandatangan_pengurusbarang: {
          validators:{
            notEmpty: {
                message: 'Nama pengurus barang sekolah tidak boleh kosong'
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
            url: "<?php echo site_url('pengaturan/simpanttd') ?>",
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
                            window.location.href = "<?php echo site_url('pengaturan/ttd'); ?>";
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
  }); //end (document).ready





</script>

</body>
</html>
