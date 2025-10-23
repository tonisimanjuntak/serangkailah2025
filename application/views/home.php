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
            <h1 class="m-0 text-dark">Home</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- Info boxes -->
        <div class="row">
          <div class="col-md-12">

            <?php  
              if ($rowpengaturan->aktifbataspenginputan) {
                if ( date('Y-m-d H:i', strtotime($rowpengaturan->tglbataspenginputan)) <= date('Y-m-d H:i') ) {
                  
                  $sisawaktu = berapawaktuyanglalu($rowpengaturan->tglbataspenginputan);
                  echo '

                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                      <strong>Batas waktu penginputan transaksi telah berakhir '.$sisawaktu.'!</strong><br>Anda tidak dapat melakukan input data transaksi lagi, karena batas waktu penginputan data telah berakhir! Terimakasih.
                      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>

                  ';

                }else{

                  $sisawaktu = sisawaktu($rowpengaturan->tglbataspenginputan);
                  echo '

                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                      <strong>Batas waktu penginputan akan berakhir dalam '.$sisawaktu.' Lagi !</strong><br>Silahkan lakukan penginputan data sebelum batas waktu penginputan berakhir! Terimakasih.
                      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>

                  ';

                }
              }
            ?>
            


            <?php 
              $pesan = $this->session->flashdata('pesan');
              if (!empty($pesan)) {
                echo $pesan;
              }
            ?>
          </div>

          <?php if ($this->session->userdata('akseslevel') !='1') { ?>
              
              <div class="col-12 col-sm-4 col-md-4">
                <div class="info-box">
                  <span class="info-box-icon bg-info elevation-1"><i class="fas fa-warehouse"></i></span>

                  <div class="info-box-content">
                    <span class="info-box-text">Jumlah UPT</span>
                    <span class="info-box-number">
                      <?php echo $jumlahupt ?>
                      <small>UPT</small>
                    </span>
                  </div>
                  <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
              </div>
              <!-- /.col -->
              <div class="col-12 col-sm-4 col-md-4">
                <div class="info-box mb-3">
                  <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-school"></i></span>

                  <div class="info-box-content">
                    <span class="info-box-text">Jumlah Sekolah</span>
                    <span class="info-box-number"><?php echo $jumlahsekolah ?> <small>Sekolah</small></span>
                  </div>
                  <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
              </div>
              <!-- /.col -->

              <!-- fix for small devices only -->
              <!-- <div class="clearfix hidden-md-up"></div> -->

              <div class="col-12 col-sm-4 col-md-4">
                <div class="info-box mb-3">
                  <span class="info-box-icon bg-success elevation-1"><i class="fas fa-users"></i></span>

                  <div class="info-box-content">
                    <span class="info-box-text">Jumlah Pengguna</span>
                    <span class="info-box-number"><?php echo $jumlahpengguna ?> <small>Pengguna</small></span>
                  </div>
                  <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
              </div>

              <div class="col-12">
                <div class="card">
                  <div class="card-header">
                    <h5>Riwayat Aktifitas Pengguna</h5>
                    <a href="<?php echo site_url('home/riwayataktifitas') ?>"><i class="fas fa-arrow-right"></i> Lihat Riwayat Selengkapnya</a>
                  </div>
                  <div class="card-body">
                      <div class="row">
                        <div class="col-md-12">
                          <div class="table-responsive">
                            <table class="table table-bordered table-striped table-condesed" id="table">
                              <thead>
                                <tr>
                                  <th style="width: 5%; text-align: center;">NO</th>
                                  <th style="width: 15%; text-align: center;">PENGGUNA</th>
                                  <th style="text-align: center;">AKTIVITAS</th>
                                  <th style="width: 20%; text-align: center;">WAKTU</th>
                                </tr>
                              </thead>
                              <tbody>
                                <?php  
                                  $rsRiwayat = $this->db->query("
                                    SELECT * FROM riwayataktifitas ORDER BY inserted_date DESC LIMIT 20 
                                  ");
                                  if ($rsRiwayat->num_rows()>0) {
                                    foreach ($rsRiwayat->result() as $row) {
                                      echo '
                                        <tr>
                                          <td style="text-align: center;">'. $row->id .'</td>
                                          <td style="text-align: center;">'. $row->namapengguna .'</td>
                                          <td>'. $row->namafunction  .'</td>
                                          <td style="text-align: center;">'. since($row->inserted_date) .'</td>
                                        </tr>
                                      ';
                                    }
                                  }
                                ?>

                              </tbody>
                            </table>
                          </div>
                        
                        </div>
                        <div class="col-12">
                          
                        </div>
                    </div>
                </div>
              </div>


          <?php }else{ ?>

              <div class="col-md-12">

                <div class="card" id="cardcontent">
                  <div class="card-header">
                    <h5 class="card-title">INFORMASI PERSEDIAAN BARANG HABIS PAKAI <?php echo $this->session->userdata('namaruangan').' TAHUN '. $this->session->userdata('tahunanggaran'); ?></h5>
                  </div>
                  <div class="card-body">
                    <div class="row">
                      <div class="col-md-12">
                        <!-- datatable -->
                        <div class="table-responsive">
                          <table class="table table-bordered table-striped table-condesed" id="table">
                            <thead>
                              <tr>
                                <th style="width: 5%; text-align: center;">NO</th>
                                <th style="text-align: center;">JENIS BARANG</th>
                                <th style="width: 10%; text-align: center;">UNIT</th>
                                <th style="width: 15%; text-align: center;">SATUAN</th>
                                <th style="width: 15%; text-align: center;">HARGA SATUAN</th>
                                <th style="width: 15%; text-align: center;">NILAI</th>
                              </tr>
                            </thead>
                            <tbody>
                                <?php  
                                  $rsdata = $this->db->query("select * from v_lap_mutasi where kdruangan = '".$this->session->userdata('kdruangan')."' and tahunanggaran='".$this->session->userdata('tahunanggaran')."' and keybarang is not null and jumlahunit_saldoawal+jumlahunit_penambahan+jumlahunit_pemakaian>0  order by kdkelompok asc, namabarang asc ");
                                  if ($rsdata->num_rows()>0) {
                                    $no = 1;
                                    foreach ($rsdata->result() as $row) {
                                      $jumlahunit = $row->jumlahunit_saldoawal+$row->jumlahunit_penambahan-$row->jumlahunit_pemakaian;
                                      echo '
                                        <tr>
                                          <td style="text-align: center;">'.$no++.'</td>
                                          <td style="text-align: left;">'.$row->namabarang.'</td>
                                          <td style="text-align: center;">'.$jumlahunit.'</td>
                                          <td style="text-align: center;">'.$row->satuan.'</td>
                                          <td style="text-align: right;">'.number_format($row->hargabeli_average).'</td>
                                          <td style="text-align: right;">'.number_format($jumlahunit*$row->hargabeli_average).'</td>
                                        </tr>

                                      ';
                                    }
                                  }else{
                                    echo '
                                      <tr>
                                          <td style="text-align: center;" colspan="6">Persediaan tahun ini belum ada.</td>
                                      </tr>
                                    ';
                                  }
                                ?>
                            </tbody>              
                          </table>
                        </div>

                      </div>

                    </div>
                  </div>
                </div>

              </div>
          <?php } ?>
          
          
        </div>
        <!-- /.row -->

        

        <!-- Main row -->
      
      </div><!--/. container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->


<?php $this->load->view('template/footer') ?>


<script>
  $(document).ready(function() {

    //defenisi datatable
    // table = $('#table').DataTable({ 
    //     "select": true
    // });

  }); //end (document).ready
</script>
</body>
</html>
