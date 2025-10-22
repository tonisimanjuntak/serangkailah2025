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
            <h1 class="m-0 text-dark">UPT</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo(site_url()) ?>">Home</a></li>
              <li class="breadcrumb-item active">UPT</li>
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
                <h5 class="card-title">List Data UPT</h5>
                <?php if ($this->session->userdata('akseslevel')=='9') { ?>
                  <a href="<?php echo(site_url('upt/tambah')) ?>" class="btn btn-sm btn-info float-right"><i class="fa fa-plus-circle"></i> Tambah Data</a>
                <?php } ?>
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
                            <th style="width: 15%; text-align: center;">Kode UPT</th>
                            <th style="text-align: left;">Nama UPT</th>
                            <th style="text-align: left;">Alamat</th>
                            <th style="text-align: left;">No Telp</th>
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
  


<?php $this->load->view('template/footer') ?>



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
            "url": "<?php echo site_url('upt/datatablesource')?>",
            "type": "POST"
        },
        "columnDefs": [
        { "targets": [ 0 ], "orderable": false, "className": 'dt-body-center' },
        { "targets": [ 1 ], "className": 'dt-body-center' },
        { "targets": [ 4 ], "className": 'dt-body-center' },
        { "targets": [ 5 ], "orderable": false, "className": 'dt-body-center' },
        ],
 
    });

  }); //end (document).ready

  
  $(document).on("click", "#hapus", function(e) {
    var link = $(this).attr("href");
    console.log(link);
    e.preventDefault();
    swal({
                title: "Hapus?",
                text: "Apakah anda yakin akan menghapus data ini!",
                icon: "warning",
                buttons: ["Batal", "Ya"],
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    $.ajax({
                        url: link,
                        type: 'GET',
                        dataType: 'json',
                        success: function(response) {                            
                            if (response.success) {
                                swal('Berhasil!', 'Data berhasil dihapus.', 'success')
                                .then(() => {
                                    window.location.href = "<?php echo(site_url('upt')) ?>";
                                });
                            } else {
                                swal('Gagal!', response.message, 'error');
                            }
                        },
                        error: function(xhr) {
                            let message = 'Terjadi kesalahan.';
                            if (xhr.responseJSON && xhr.responseJSON.message) {
                                message = xhr.responseJSON.message;
                            } else if (xhr.status === 422) {
                                // Validation errors
                                const errors = xhr.responseJSON.errors;
                                message = Object.values(errors).flat().join('<br>');
                            }
                            swal('Error!', message, 'error');
                        }
                    });
                    
                }
            });
  });  
  

</script>

</body>
</html>
