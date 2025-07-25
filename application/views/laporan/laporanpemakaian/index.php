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
            <h1 class="m-0 text-dark">Laporan Pemakaian Barang</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo(site_url()) ?>">Home</a></li>
              <li class="breadcrumb-item active">Laporan Pemakaian Barang</li>
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
          <div class="col-md-2"></div>
          <div class="col-md-8">
            <div class="card" id="cardcontent">
              <div class="card-body">
                <div class="row">
                  <div class="col-md-12">
                    <?php 
                      $pesan = $this->session->flashdata('pesan');
                      if (!empty($pesan)) {
                        echo $pesan;
                      }
                    ?>
                  </div>
                  
                  
                  <div class="col-md-12 mt-3 text-gray">
                    <h4>FILTER LAPORAN</h4><hr>
                  </div>
                  
                  <div class="col-md-12">
                    <div class="form-group row">
                      <label for="" class="col-form-label col-md-3">Tanggal Periode</label>
                      <div class="col-md-4">
                        <input type="date" id="tglawal" name="tglawal" class="form-control" value="<?php echo($tglawal) ?>">
                      </div>
                      <label for="" class="col-form-label col-md-1">S/D</label>
                      <div class="col-md-4">
                        <input type="date" id="tglakhir" name="tglakhir" class="form-control" value="<?php echo($tglakhir) ?>">
                      </div>

                    </div>
                  </div>

                  <div class="col-md-12"><hr></div>
                  <div class="col-md-12" style="<?php echo ($this->session->userdata('akseslevel')=='1') ? 'display: none;' : '' ?>">
                    <div class="form-group">
                      <label for="">Nama Sekolah</label>
                      <select name="kdruangan" id="kdruangan" class="form-control js-example-basic-single">
                        <option value="">Semua sekolah...</option>
                        <?php  

                          $akseslevel = $this->session->userdata('akseslevel');
                          switch ($akseslevel) {
                            case '1':
                              $rsruangan = $this->App->query('ruangan', 'where kdruangan="'.$this->session->userdata('kdruangan').'"', 'order by namaruangan');
                              break;
                            case '2':
                              $rsruangan = $this->App->query('ruangan', 'where statusaktif="1" and kdupt="'.$this->session->userdata('kdupt').'"', 'order by namaruangan');
                              break;
                            
                            default:
                              $rsruangan = $this->App->query('ruangan', 'where statusaktif="1"', 'order by namaruangan');
                              break;
                          }
                          
                          foreach ($rsruangan->result() as $rowruangan) {
                            $selected = '';
                            if ($this->session->userdata('akseslevel')=='1') {
                              if ($this->session->userdata('kdruangan') == $rowruangan->kdruangan) {
                                $selected = 'selected="selected"';
                              }
                            }
                            echo '<option value="'.$rowruangan->kdruangan.'" '.$selected.'>'.$rowruangan->namaruangan.'</option>';
                          }
                        ?>
                      </select>
                    </div>
                  </div>



                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="">Kelompok Barang</label>
                      <select name="kdkelompok" id="kdkelompok" class="form-control js-example-basic-single">
                        <option value="">Semua kelompok barang...</option>
                        <?php  
                          $rskelompok = $this->App->query('kelompokbarang', 'where statusaktif="1"', 'order by namakelompok');
                          foreach ($rskelompok->result() as $rowkelompok) {
                            echo '<option value="'.$rowkelompok->kdkelompok.'">'.$rowkelompok->namakelompok.'</option>';
                          }
                        ?>
                      </select>
                    </div>
                  </div>


                  
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="">Nama Barang</label>
                        <select name="keybarang" id="keybarang" class="form-control js-example-basic-single">
                          <option value="">Semua barang...</option>
                          <?php  
                            $rsbarang = $this->App->query('barang', 'where tahunanggaran="'.$this->session->userdata('tahunanggaran').'"', 'order by namabarang' );
                            foreach ($rsbarang->result() as $rowbarang) {
                              echo '<option value="'.$rowbarang->keybarang.'">'.$rowbarang->namabarang.'</option>';
                            }
                          ?>
                        </select>
                    </div>
                  </div>

                  <div class="col-md-12"><hr>
                      <button class="btn btn-info float-right ml-2" id="cetak"><i class="fa fa-print"></i> Cetak</button>
                      <button class="btn btn-success float-right" id="excel"><i class="fa fa-file-excel"></i> Download Excel</button>
                  </div>
  
                </div> <!-- /.row -->
              </div> <!-- ./card-body -->
            </div> <!-- /.card -->
          </div> <!-- /.col -->
        </div> <!-- /.row -->
        <!-- Main row -->
      </div> <!--/. container-fluid -->
    </section> <!-- /.content -->
  </div> <!-- /.content-wrapper -->
  


<?php $this->load->view('template/footer') ?>



<script type="text/javascript">

  $(document).ready(function() {

    $('.js-example-basic-single').select2();

  }); //end (document).ready


  $('#cetak').click(function(e){
        // e.preventDefault();

        // fileter
        var tglawal      = $('#tglawal').val();
        var tglakhir      = $('#tglakhir').val();
        var kdruangan      = $('#kdruangan').val();
        var kdkelompok      = $('#kdkelompok').val();
        var keybarang     = $('#keybarang').val();

        
        if (tglawal=='') {
          alert("Tanggal awal tidak boleh kosong!");
          return;
        }

        if (tglakhir=='') {
          alert("Tanggal akhir tidak boleh kosong!");
          return;
        }

        if ( kdruangan=='' ) { kdruangan='-' };
        if ( kdkelompok=='' ) { kdkelompok='-' };
        if ( keybarang=='' ) { keybarang='-' };

        window.open("<?php echo site_url('laporan/laporanpemakaian_cetak/cetak/') ?>" + kdruangan + "/" + tglawal + "/" + tglakhir + "/" + kdkelompok + "/" + keybarang + "/Laporan Pemakaian");
    });

  $('#excel').click(function(e){
        // e.preventDefault();

        // fileter
        var tglawal      = $('#tglawal').val();
        var tglakhir      = $('#tglakhir').val();
        var kdruangan      = $('#kdruangan').val();
        var kdkelompok      = $('#kdkelompok').val();
        var keybarang     = $('#keybarang').val();


        if (tglawal=='') {
          alert("Tanggal awal tidak boleh kosong!");
          return;
        }

        if (tglakhir=='') {
          alert("Tanggal akhir tidak boleh kosong!");
          return;
        }

        if ( kdruangan=='' ) { kdruangan='-' };
        if ( kdkelompok=='' ) { kdkelompok='-' };
        if ( keybarang=='' ) { keybarang='-' };

        window.open("<?php echo site_url('laporan/laporanpemakaian_cetak/excel/') ?>" + kdruangan + "/" + tglawal + "/" + tglakhir + "/" + kdkelompok + "/" + keybarang + "/Laporan Pemakaian");

    });
  

</script>

</body>
</html>
