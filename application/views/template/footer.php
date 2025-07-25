
  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->

  <!-- Main Footer -->
  <footer class="main-footer text-sm">
    <strong>Copyright &copy; 2014-2019 <a href="http://adminlte.io">AdminLTE.io</a>.</strong>
    All rights reserved.
    <div class="float-right d-none d-sm-inline-block">
      <b>Version</b> 3.0.2
    </div>
  </footer>
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->
<!-- jQuery -->
<script src="<?php echo(base_url()) ?>assets/adminlte/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap -->
<script src="<?php echo(base_url()) ?>assets/adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- overlayScrollbars -->
<script src="<?php echo(base_url()) ?>assets/adminlte/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<!-- AdminLTE App -->
<script src="<?php echo(base_url()) ?>assets/adminlte/dist/js/adminlte.js"></script>

<!-- OPTIONAL SCRIPTS -->
<script src="<?php echo(base_url()) ?>assets/adminlte/dist/js/demo.js"></script>

<!-- ChartJS -->
<script src="<?php echo(base_url()) ?>assets/adminlte/plugins/chart.js/Chart.min.js"></script>


<!-- datatables -->
  <script src="<?php echo(base_url()) ?>assets/datatables/js/jquery.dataTables.min.js"></script>


  <script type="text/javascript" src="<?php echo base_url(); ?>assets/bootbox/bootbox.js"></script>
  

  <!-- jquery-confirm  -->
  <script src="<?php echo(base_url('assets/')) ?>jquery-confirm/js/jquery-confirm.min.js"></script>

  <!-- jquery-mask -->
  <script type="text/javascript" src="<?php echo base_url('assets/') ?>jquery_mask/jquery.mask.js"></script>

  <!-- Bootstrap validator -->
  <script src="<?php echo(base_url('assets/')) ?>bootstrap-validator/js/bootstrapValidator.js"></script>

  <!-- jquery-ui -->
  <script src="<?php echo(base_url('assets/')) ?>jquery-ui/jquery-ui-2.js"></script>


  <!-- select2 -->
  <script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>

  <!-- sweetalert -->
  <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
  
<!-- -------------------------------------------------------------------------------------------PAGE SCRIPTS / buang aja -->
<!-- <script src="<?php echo(base_url()) ?>assets/adminlte/dist/js/pages/dashboard2.js"></script> -->





<script>
    const numberWithCommas = (x) => {
          return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        }  

    const untitik = (i) => {
        return typeof i === 'string' ?
                            i.replace(/[\$,]/g, '')*1 :
                            typeof i === 'number' ?
                                i : 0;
    }

    $("input#kdkelompok").mask("S", {
            translation: {
                "S": {
                    pattern: /[^ ]/, // Hanya karakter selain spasi
                    recursive: true
                }
            },
            placeholder: "Kode Kelompok Barang"
        }).on('input', function () {
            // Konversi otomatis ke huruf besar
            $(this).val(function (_, val) {
                return val.toUpperCase();
            });
        });

    $("input#kdbarang").mask("S", {
            translation: {
                "S": {
                    pattern: /[^ ]/, // Hanya karakter selain spasi
                    recursive: true
                }
            },
            placeholder: "Kode Barang"
        }).on('input', function () {
            // Konversi otomatis ke huruf besar
            $(this).val(function (_, val) {
                return val.toUpperCase();
            });
        });
   
</script>



<script>
  
</script>