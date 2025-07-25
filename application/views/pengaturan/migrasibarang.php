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
          <h1 class="m-0 text-dark">Pengaturan | Migrasi Kode Barang</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="<?php echo (site_url()) ?>">Home</a></li>
            <li class="breadcrumb-item active" id="lblactive">Migrasi Kode Barang</li>
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
            <div class="row">
              <div class="col-md-12">
                <div class="card" id="cardcontent">
                  <div class="card-header">
                    <h5 class="card-title">Migrasi Kode Barang</h5>
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


                              <div class="row">



                                <div class="col-md-12 text-lg" id="divjenisprogres">
                                  <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="inlineRadioOptions" id="optpersekolah" value="option1" checked="">
                                    <label class="form-check-label" for="optpersekolah">Per Sekolah</label>
                                  </div>
                                  <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="inlineRadioOptions" id="optkeseluruhan" value="option2">
                                    <label class="form-check-label" for="optkeseluruhan">Semua Sekolah</label>
                                  </div>
                                </div>



                                <div class="col-md-12 mt-3 mb-3">
                                    <div class="form-group">
                                      <label for="">Nama Sekolah</label>
                                      <select name="kdruangan" id="kdruangan" class="form-control js-example-basic-single">
                                        <option value="">Semua sekolah...</option>


<?php
$kdruangan  = $this->session->userdata('kdruangan');
$kdupt      = $this->session->userdata('kdupt');
$akseslevel = $this->session->userdata('akseslevel');

switch ($akseslevel) {
    case '1':
        $rsruangan = $this->db->query(" select * from ruangan where kdruangan='$kdruangan'");
        break;
    case '2':
        $rsruangan = $this->db->query(" select * from ruangan where statusaktif='1' and kdupt='$kdupt' order by namaruangan");
        break;
    default:
        $rsruangan = $this->db->query(" select * from ruangan where statusaktif='1' order by namaruangan");
        break;
}

foreach ($rsruangan->result() as $rowruangan) {
    $selected = '';
    if ($this->session->userdata('akseslevel') == '1') {
        if ($this->session->userdata('kdruangan') == $rowruangan->kdruangan) {
            $selected = 'selected="selected"';
        }
    }
    echo '<option value="' . $rowruangan->kdruangan . '" ' . $selected . '>' . $rowruangan->namaruangan . '</option>';
}
?>
                                      </select>
                                    </div>
                                  </div>


                                  <div class="col-md-6">
                                    <div class="card">
                                      <div class="card-body bg-warning">
                                        <h3 class="">Asal Kode Barang</h3>

                                        <div class="form-group">
                                          <label for="">Kelompok Barang</label>
                                          <select name="kdkelompokasal" id="kdkelompokasal" class="form-control js-example-basic-single">
                                            <option value="">Pilih Kelompok Barang...</option>


    <?php
$kdruangan  = $this->session->userdata('kdruangan');
$kdupt      = $this->session->userdata('kdupt');
$akseslevel = $this->session->userdata('akseslevel');

$rskelompok = $this->db->query("select * from kelompokbarang where statusaktif='1' order by kdkelompok");

foreach ($rskelompok->result() as $rowkelompok) {
    echo '<option value="' . $rowkelompok->kdkelompok . '">' . $rowkelompok->kdkelompok . ' | ' . $rowkelompok->namakelompok . '</option>';
}
?>
                                          </select>
                                        </div>


                                        <div class="form-group">
                                          <label for="">Kode/ Nama Barang</label>
                                          <select name="keybarangasal" id="keybarangasal" class="form-control js-example-basic-single">
                                            <option value="">Pilih Nama Barang...</option>
                                          </select>
                                        </div>


                                      </div>
                                    </div>
                                  </div>


                                  <div class="col-md-6">
                                    <div class="card">
                                      <div class="card-body bg-success">
                                        <h3 class="">Tujuan Kode Barang</h3>

                                        <div class="form-group">
                                          <label for="">Kelompok Barang</label>
                                          <select name="kdkelompoktujuan" id="kdkelompoktujuan" class="form-control js-example-basic-single">
                                            <option value="">Pilih Kelompok Barang...</option>


    <?php
$kdruangan  = $this->session->userdata('kdruangan');
$kdupt      = $this->session->userdata('kdupt');
$akseslevel = $this->session->userdata('akseslevel');

$rskelompok = $this->db->query("select * from kelompokbarang where statusaktif='1' order by kdkelompok");

foreach ($rskelompok->result() as $rowkelompok) {
    echo '<option value="' . $rowkelompok->kdkelompok . '">' . $rowkelompok->kdkelompok . ' | ' . $rowkelompok->namakelompok . '</option>';
}
?>
                                          </select>
                                        </div>


                                        <div class="form-group">
                                          <label for="">Kode/ Nama Barang</label>
                                          <select name="keybarangtujuan" id="keybarangtujuan" class="form-control js-example-basic-single">
                                            <option value="">Pilih Nama Barang...</option>
                                          </select>
                                        </div>


                                      </div>
                                    </div>
                                  </div>

                                  <div class="col-md-12 mt-5">
                                      <button id="progress" class="btn btn-info float-right"><i class="fa fa-sync"></i> Proses</button>
                                  </div>

                              </div>


                            </div>
                          </div>
                        </div>
                      </div>





                  </div> <!-- ./card-body -->

                </div> <!-- /.card -->
              </div> <!-- /.col -->
            </div>
        </div>
      </div> <!-- /.row -->
      <!-- Main row -->
    </div> <!--/. container-fluid -->
  </section> <!-- /.content -->
</div> <!-- /.content-wrapper -->



<?php $this->load->view('template/footer')?>



<script type="text/javascript">

  var akseslevel_session = "<?php echo $this->session->userdata('akseslevel') ?>";
  var kdruangan_session = "<?php echo $this->session->userdata('kdruangan') ?>";
  var kdupt_session = "<?php echo $this->session->userdata('kdupt') ?>";

  $(document).ready(function() {

    $('.js-example-basic-single').select2();

    if (akseslevel_session=='1') {
      $('#divjenisprogres').hide();
      $('#kdruangan').prop("disabled", true);
      $('#kdruangan').val(kdruangan_session).trigger('change');
    }


    $("form").attr('autocomplete', 'off');
  }); //end (document).ready


  $('#kdkelompokasal').change(function() {

    var kdkelompok = $(this).val();

    $("#keybarangasal").empty();
    $("#keybarangasal").append( new Option('Pilih Nama Barang...', '') );

    if (kdkelompok!='') {

          $.ajax({
            url: '<?php echo (site_url('Pengaturan/get_data_barang')) ?>',
            type: 'GET',
            dataType: 'json',
            data: {'kdkelompok': kdkelompok},
          })
          .done(function(resultbarang) {

            if (resultbarang.length>0 ) {

              $.each(resultbarang, function(index, val) {
                 $("#keybarangasal").append( new Option(resultbarang[index]['kdbarang']+' | '+resultbarang[index]['namabarang'], resultbarang[index]['keybarang']) );
              });
            }

          })
          .fail(function() {
            console.log("error get data barang");
          });

        }

  });



  $('#kdkelompoktujuan').change(function() {

    var kdkelompok = $(this).val();

    $("#keybarangtujuan").empty();
    $("#keybarangtujuan").append( new Option('Pilih Nama Barang...', '') );

    if (kdkelompok!='') {

          $.ajax({
            url: '<?php echo (site_url('Pengaturan/get_data_barang')) ?>',
            type: 'GET',
            dataType: 'json',
            data: {'kdkelompok': kdkelompok},
          })
          .done(function(resultbarang) {

            if (resultbarang.length>0 ) {

              $.each(resultbarang, function(index, val) {
                 $("#keybarangtujuan").append( new Option(resultbarang[index]['kdbarang']+' | '+resultbarang[index]['namabarang'], resultbarang[index]['keybarang']) );
              });
            }

          })
          .fail(function() {
            console.log("error get data barang");
          });

        }

  });



  $('#optpersekolah').click(function() {
    jenis_progres();
  });

  $('#optkeseluruhan').click(function() {
    jenis_progres();
  });


  function jenis_progres()
  {
    if ( $('#optpersekolah').prop("checked") ) {
        $('#kdruangan').prop("disabled", false);
    }
    if ( $('#optkeseluruhan').prop("checked") ) {
        $('#kdruangan').val("").trigger('change');
        $('#kdruangan').prop("disabled", true);
    }
  }



  $('#progress').click(function(e) {
    e.preventDefault();


    var kdruangan = $('#kdruangan').val();
    var keybarangasal = $('#keybarangasal').val();
    var keybarangtujuan = $('#keybarangtujuan').val();


    if ( akseslevel_session=='1' ) {
      kdruangan == kdruangan_session;
    }else{

      if ( $('#optpersekolah').prop("checked") && kdruangan=='' ) {
        swal("Nama Sekolah", "Nama sekolah belum dipilih!", "warning");
        return false;
      }

      if ( $('#optkeseluruhan').prop("checked") ) {
        kdruangan = '';
      }

    }


    if (keybarangasal=='') {
      swal("Nama Barang Asal", "Nama barang asal belum dipilih!", "warning");
      return false;
    }

    if (keybarangtujuan=='') {
      swal("Nama Barang Tujuan", "Nama barang tujuan belum dipilih!", "warning");
      return false;
    }


    if ( keybarangasal == keybarangtujuan) {
      swal("Nama Barang Sama", "Nama barang asal dan nama barang tujuan tidak boleh sama!", "warning");
      return false;
    }


    swal({
      title: "Anda Yakin?",
      text: "Anda yakin akan melanjutkan migrasi kode barang ini?",
      icon: "warning",
       buttons: {
        cancel: "Batal",
        catch: {
          text: "Lanjutkan!",
          value: "lanjutkan",
        },
      },
      dangerMode: true,
    })
    .then((value) => {

      if (value=="lanjutkan") {


        if (kdruangan=='') {

          swal({
            title: "Semua Sekolah?",
            text: "Anda yakin akan migrasi kode barang ini untuk semua sekolah?",
            icon: "warning",
             buttons: {
              cancel: "Batal",
              catch: {
                text: "Lanjutkan!",
                value: "lanjutkan",
              },
            },
            dangerMode: true,
          })
          .then((value) => {

            if (value=="lanjutkan") {
              progress_migrasi(kdruangan, keybarangasal, keybarangtujuan);
            }

          });

        }else{

          swal({
            title: "Semua Sekolah?",
            text: "Anda yakin akan migrasi kode barang ini untuk semua sekolah?",
            icon: "warning",
             buttons: {
              cancel: "Batal",
              catch: {
                text: "Lanjutkan!",
                value: "lanjutkan",
              },
            },
            dangerMode: true,
          })
          .then((value) => {

            if (value=="lanjutkan") {
              progress_migrasi(kdruangan, keybarangasal, keybarangtujuan);
            }

          });

              progress_migrasi(kdruangan, keybarangasal, keybarangtujuan);
        }



      }

    });


  });

  function progress_migrasi(kdruangan, keybarangasal, keybarangtujuan)
  {

    $.ajax({
            url: '<?php echo site_url("Pengaturan/progress_migrasi") ?>',
            type: 'POST',
            dataType: 'json',
            data: {'kdruangan': kdruangan, 'keybarangasal': keybarangasal, 'keybarangtujuan': keybarangtujuan},
          })
          .done(function(resultprogress) {

            console.log(resultprogress);

            if (resultprogress.success) {

              swal("Berhasil", "Berhasil migrasikan kode barang", "success");
            }else{
              swal("Gagal", "Gagal migrasikan kode barang", "error");
            }

          })
          .fail(function() {
            swal("Gagal", "Script eror!!!", "error");
          });

  }
</script>

</body>
</html>
