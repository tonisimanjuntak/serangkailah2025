<?php  
  $this->load->view('template/header');
  $this->load->view('template/topmenu');
  $this->load->view('template/sidemenu');
?>
<style>
  #table td {
    white-space: normal; /* Memungkinkan teks wrap */
    word-wrap: break-word; /* Memecah kata jika terlalu panjang */
    overflow-wrap: break-word; /* Alternatif untuk browser modern */
    max-width: 300px; /* Batasi lebar maksimum kolom (opsional) */
}
</style>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Riwayat Aktifitas Pengguna</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo site_url() ?>">Home</a></li>
              <li class="breadcrumb-item active">Riwayat Aktifitas</li>
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
              $pesan = $this->session->flashdata('pesan');
              if (!empty($pesan)) {
                echo $pesan;
              }
            ?>
          </div>

          <div class="col-12">
            <div class="card">

              <div class="card-body">
                  <div class="row">
                    <div class="col-12 mb-5">
                      <div class="row">
                        <div class="col-md-3">
                          <label for="">Tanggal Awal</label>
                          <input type="date" name="tglawal" id="tglawal" class="form-control" value="<?php echo(date('Y-m-d')) ?>">
                        </div>
                        <div class="col-md-3">
                          <label for="">Tanggal Akhir</label>
                          <input type="date" name="tglakhir" id="tglakhir" class="form-control" value="<?php echo(date('Y-m-d')) ?>">
                        </div>
                        <div class="col-md-6">
                          <label for="">Nama Pengguna</label>
                          <select name="idpengguna" id="idpengguna" class="form-control select2">
                            <option value="">Semua</option>
                            <?php  
                              $rsPengguna = $this->db->query("select * from pengguna order by namapengguna");
                              foreach ($rsPengguna->result() as $rowPengguna) {
                                echo '<option value="'.$rowPengguna->idpengguna.'">'.$rowPengguna->namapengguna.'</option>';
                              }
                            ?>
                          </select>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-12">
                      <div class="table-responsive">
                        <table class="table table-striped table-bordered text-sm" id="table" style="width: 100%;">
                          <thead>
                            <tr>
                              <th style="width: 5%; text-align: center;">NO</th>
                              <th style="width: 50%; text-align: center;">DESKRIPSI</th>
                              <th style="width: 15%; text-align: center;">PENGGUNA</th>
                              <th style="width: 10%; text-align: center;">TABEL</th>
                              <th style="width: 10%; text-align: center;">FUNCTION</th>
                              <th style="width: 10%; text-align: center;">WAKTU</th>
                            </tr>
                          </thead>
                          <tbody>
                          </tbody>
                        </table>
                      </div>
                    
                    </div>

                </div>
            </div>
          </div>

          
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
	var table;

  $(document).ready(function() { 
    $('.select2').select2();


    table = $('#table').DataTable({
			"select": true,
			"processing": true,
			"serverSide": true,
			"order": [],
      "responsive": true, // Aktifkan responsive mode
      "scrollX": true, // Aktifkan horizontal scrolling jika perlu
			"ajax": {
				"url": "<?php echo site_url('home/listriwayat') ?>",
				"type": "POST",
				"data": function(d) {
					d.tglawal = $('#tglawal').val();
					d.tglakhir = $('#tglakhir').val();
					d.idpengguna = $('#idpengguna').val();
				}
			},
			"columnDefs": [{
					"targets": [0],
					"className": 'dt-body-center'
				},
				{
					"targets": [1],
					"className": 'dt-body-left'
				},
				{
					"targets": [2],
					"className": 'dt-body-center'
				},
				{
					"targets": [3],
					"className": 'dt-body-center',
				},
				{
					"targets": [4],
					"className": 'dt-body-center'
				},
        {
					"targets": [5],
					"orderable": false,
					"className": 'dt-body-center'
				},
			],

		});
		table.columns.adjust()

  }); //end (document).ready

  $(document).on('change', '#tglawal', function() {
    $("#table").DataTable().draw();
		table.columns.adjust();
  });

  $(document).on('change', '#tglakhir', function() {
    $("#table").DataTable().draw();
    table.columns.adjust();
  });

  $(document).on('change', '#idpengguna', function() {
    $("#table").DataTable().draw();
    table.columns.adjust();
  });
</script>
</body>
</html>
