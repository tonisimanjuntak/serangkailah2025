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
          <h1 class="m-0 text-dark">Penandatangan</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="<?php echo (site_url()) ?>">Home</a></li>
            <li class="breadcrumb-item"><a href="<?php echo (site_url('penandatangan')) ?>">Penandatangan</a></li>
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
          <form action="<?php echo (site_url('penandatangan/simpan')) ?>" method="post" id="form">
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
                      <input type="hidden" name="idpenandatangan" id="idpenandatangan">

                      <div class="form-group row required">
                        <label for="" class="col-md-2 col-form-label">NIP</label>
                        <div class="col-md-4">
                          <input type="text" name="nip" id="nip" class="form-control" placeholder="Contoh: xxxxxxxxxxxxxx">
                        </div>
                      </div>

                      <div class="form-group row required">
                        <label for="" class="col-md-2 col-form-label">Nama Pegawai</label>
                        <div class="col-md-10">
                          <input type="text" name="namapenandatangan" id="namapenandatangan" class="form-control" placeholder="Contoh: Bambang, SE">
                        </div>
                      </div>

                      <div class="form-group row required">
                        <label for="" class="col-md-2 col-form-label">Struktur</label>
                        <div class="col-md-10">
                          <select name="idstruktur" id="idstruktur" class="form-control">
                            <option value="">Pilih struktur...</option>
                            <?php
$rsstruktur = $this->App->query('struktur', '', 'order by idstruktur');
foreach ($rsstruktur->result() as $row) {
    echo '<option value="' . $row->idstruktur . '">' . $row->namastruktur . '</option>';
}
?>
                          </select>
                        </div>
                      </div>

                      <div class="form-group row required">
                        <label for="" class="col-md-2 col-form-label">Jabatan</label>
                        <div class="col-md-10">
                          <input type="text" name="jabatan" id="jabatan" class="form-control" placeholder="Contoh: Kepala Sekolah SD Negeri 02">
                        </div>
                      </div>


                      <div class="form-group row required">
                        <label for="" class="col-md-2 col-form-label">Golongan</label>
                        <div class="col-md-10">
                          <input type="text" name="golongan" id="golongan" class="form-control" placeholder="Contoh: Pembina Utama Muda">
                        </div>
                      </div>

                      <div class="form-group row required">
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
                    <button type="submit" class="btn btn-info float-right" id="btnsimpan"><i class="fa fa-save"></i> Simpan</button>
                    <a href="<?php echo (site_url('penandatangan')) ?>" class="btn btn-default float-right mr-1 ml-1"><i class="fa fa-chevron-circle-left"></i> Kembali</a>
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

  var idpenandatangan = "<?php echo ($idpenandatangan) ?>";

  $(document).ready(function() {


    //---------------------------------------------------------> JIKA EDIT DATA
    if ( idpenandatangan != "" ) {
          $.ajax({
              type        : 'POST',
              url         : '<?php echo site_url("penandatangan/get_edit_data") ?>',
              data        : {idpenandatangan: idpenandatangan},
              dataType    : 'json',
              encode      : true
          })
          .done(function(result) {
            $('#idpenandatangan').val(result.idpenandatangan);
            $('#nip').val(result.nip);
            $('#namapenandatangan').val(result.namapenandatangan);
            $('#idstruktur').val(result.idstruktur);
            $('#jabatan').val(result.jabatan);
            $('#golongan').val(result.golongan);
            $('#statusaktif').val(result.statusaktif);
          });

          $('#lbljudul').html('Edit Data Penandatangan');
          $('#lblactive').html('Edit');

    }else{
          $('#lbljudul').html('Tambah Data Penandatangan');
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
        namapenandatangan: {
          validators:{
            notEmpty: {
                message: 'Nama pegawai tidak boleh kosong'
            },
            stringLength: {
                max: 100,
                message: 'Panjang karakter maksimal 100 karakter'
            },
          }
        },
        nip: {
          validators:{
            notEmpty: {
                message: 'NIP tidak boleh kosong'
            },
            stringLength: {
                max: 20,
                message: 'Panjang karakter maksimal 20 karakter'
            },
          }
        },
        idstruktur: {
          validators:{
            notEmpty: {
                message: 'Sturktur belum dipilih'
            },
          }
        },
        jabatan: {
          validators:{
            notEmpty: {
                message: 'jabatan tidak boleh kosong'
            },
            stringLength: {
                max: 100,
                message: 'Panjang karakter maksimal 100 karakter'
            },
          }
        },
        statusaktif: {
          validators:{
            notEmpty: {
                message: 'Status aktif belum dipilih'
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
            url: "<?php echo site_url('penandatangan/simpan') ?>",
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
                            window.location.href = "<?php echo site_url('penandatangan'); ?>";
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
    $('#notelp').mask('0000000000000000', {reverse: true});
  }); //end (document).ready



</script>

</body>
</html>
