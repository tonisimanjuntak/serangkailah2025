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
              <li class="breadcrumb-item active">Penandatangan</li>
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
            <div class="card" id="cardcontent">
              <div class="card-header">
                <h5 class="card-title">List Data Penandatangan</h5>
                <a href="<?php echo (site_url('penandatangan/tambah')) ?>" class="btn btn-sm btn-info float-right"><i class="fa fa-plus-circle"></i> Tambah Data</a>
              </div>
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
                  <div class="col-md-12">
                    <!-- datatable -->
                    <div class="table-responsive">
                      <table class="table table-bordered table-striped table-condesed" id="table">
                        <thead>
                          <tr class="bg-info" style="">
                            <th style="width: 5%; text-align: center;">No</th>
                            <th style="width: 15%; text-align: center;">NIP</th>
                            <th style="text-align: center;">Nama Pegawai</th>
                            <th style="text-align: center;">Jabatan</th>
                            <th style="text-align: center;">Golongan</th>
                            <th style="text-align: center;">Nama Ruangan</th>
                            <th style="text-align: center;">Status Aktif</th>
                            <th style="text-align: center; width: 15%;">Aksi</th>
                          </tr>
                        </thead>
                        <tbody>

                        </tbody>
                      </table>
                    </div>

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



<?php $this->load->view('template/footer')?>



<script type="text/javascript">

  var table;

  $(document).ready(function() {

    //defenisi datatable
    table = $('#table').DataTable({
        "select": true,
        "processing": true,
        "serverSide": true,
        "order": [],
         "ajax": {
            "url": "<?php echo site_url('penandatangan/datatablesource') ?>",
            "type": "POST"
        },
        "columnDefs": [
        { "targets": [ 0 ], "orderable": false, "className": 'dt-body-center' },
        { "targets": [ 1 ], "className": 'dt-body-center' },
        { "targets": [ 4 ], "className": 'dt-body-center' },
        { "targets": [ 5 ], "className": 'dt-body-center' },
        { "targets": [ 6 ], "className": 'dt-body-center' },
        { "targets": [ 7 ], "orderable": false, "className": 'dt-body-center' },
        ],

    });

  }); //end (document).ready


  $(document).on("click", "#hapus", function(e) {
    var link = $(this).attr("href");
    e.preventDefault();
    bootbox.confirm("Anda yakin ingin menghapus data ini ?", function(result) {
      if (result) {
        document.location.href = link;
      }
    });
  });


</script>

</body>
</html>
