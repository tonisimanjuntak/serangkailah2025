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
          <h1 class="m-0 text-dark">Pemakaian Barang</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="<?php echo(site_url()) ?>">Home</a></li>
            <li class="breadcrumb-item"><a href="<?php echo(site_url('pemakaianbarang')) ?>">Pemakaian Barang</a></li>
            <li class="breadcrumb-item active" id="lblactive"></li>
          </ol>
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>
  <!-- /.content-header -->

  <!-- Main content -->
  <section class="content text-sm">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
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


                      <input type="hidden" name="nokeluar" id="nokeluar">

                      <div class="form-group row required">
                        <label for="" class="col-md-2 col-form-label">Tanggal</label>
                        <div class="col-md-3">
                          <input type="date" name="tglkeluar" id="tglkeluar" class="form-control" value="<?php echo(date('Y-m-d')) ?>">
                        </div>
                      </div>

                      <div class="form-group row required">
                        <label for="" class="col-md-2 col-form-label">Uraian</label>
                        <div class="col-md-10">
                          <textarea name="uraian" id="uraian" class="form-control" rows="3" placeholder="Contoh: Penggunaan barang untuk ruangan administrasi"></textarea>
                        </div>
                      </div>

                      <div class="col-md-12">
                        <div class="card">
                          <div class="card-body">
                              <h3 class="text-muted text-center">Detail Pemakaian</h3>
                              <hr>

                              
                              <form action="<?php echo(site_url('pemakaianbarang/simpan')) ?>" method="post" id="form">                      
                                <div class="row">
                                  <div class="col-md-4">
                                    <div class="form-group">
                                      <label for="">Nama Barang</label>
                                        <input type="text" name="namabarang" id="namabarang" class="form-control" placeholder="Cari...">
                                        <input type="hidden" name="keybarang" id="keybarang">
                                        <input type="hidden" name="kdbarang" id="kdbarang">
                                    </div>
                                  </div>
                                  <div class="col-md-2">
                                    <div class="form-group">
                                      <label for="">Qty</label>
                                      <input type="number" name="qty" id="qty" class="form-control" min="0">
                                    </div>
                                  </div>
                                  <div class="col-md-2">
                                    <div class="form-group">
                                      <label for="">Satuan</label>
                                      <input type="text" name="satuan" id="satuan" class="form-control" readonly="">
                                    </div>
                                  </div>
                                  <div class="col-md-2">
                                    <div class="form-group">
                                      <label for="">Stok Barang</label>
                                      <input type="text" name="stokbarang" id="stokbarang" class="form-control text-right" readonly="">
                                    </div>
                                  </div>


                                  <div class="col-md-2">
                                    <button class="btn btn-primary mt-4" type="submit">Tambahkan</button>
                                  </div>

                                </div>
                              </form>

                                <hr>

                              <div class="table-responsive">
                                <table id="table" class="display" style="width: 100%;">
                                    <thead>
                                        <tr>
                                            <th style="width: 5%; text-align: center;">No</th>
                                            <th style="width: 10%; text-align: center;">Key Barang</th>
                                            <th style="width: 10%; text-align: center;">Kode Barang</th>
                                            <th>Nama Barang</th>
                                            <th style="width: 10%; text-align: center;">Satuan</th>
                                            <th style="text-align: right;">QTY</th>
                                            <th style="width: 5%; text-align: center;">Hapus</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                              </div>

                          </div>
                        </div>
                        <input type="hidden" id="total">
                      </div>
                      

                  </div> <!-- ./card-body -->

                  <div class="card-footer">
                    <button class="btn btn-info float-right" id="simpan"><i class="fa fa-save"></i> Simpan</button>
                    <a href="<?php echo(site_url('pemakaianbarang')) ?>" class="btn btn-default float-right mr-1 ml-1"><i class="fa fa-chevron-circle-left"></i> Kembali</a>
                  </div>
                </div> <!-- /.card -->
              </div> <!-- /.col -->
            </div>
        </div>
      </div> <!-- /.row -->
      <!-- Main row -->
    </div> <!--/. container-fluid -->
  </section> <!-- /.content -->
</div> <!-- /.content-wrapper -->
  


<?php $this->load->view('template/footer') ?>




<script type="text/javascript">
  
  var nokeluar = "<?php echo($nokeluar) ?>";

  // console.log("nokeluar"+nokeluar);
  $(document).ready(function() {



    table = $('#table').DataTable({ 
        "select": true,
            "processing": true, 
            "ordering": false,
            "bPaginate": false,      
            "searching": false,  
            "bInfo" : false, 
             "ajax"  : {
                      "url": "<?php echo site_url('pemakaianbarang/datatablesourcedetail')?>",
                      "dataType": "json",
                      "type": "POST",
                      "data": {"nokeluar": '<?php echo($nokeluar) ?>'}
                  },
            "columnDefs": [
            { "targets": [ 1 ], "className": 'dt-body-center', "visible": false},
            { "targets": [ 2 ], "className": 'dt-body-center'},
            { "targets": [ 4 ], "className": 'dt-body-center'},
            { "targets": [ 5 ], "className": 'dt-body-right'},
            { "targets": [ 6 ], "orderable": false, "className": 'dt-body-center'},
            ],
     
        });



    //---------------------------------------------------------> JIKA EDIT DATA
    if ( nokeluar != "" ) { 
          $.ajax({
              type        : 'POST', 
              url         : '<?php echo site_url("Pemakaianbarang/get_edit_data") ?>', 
              data        : {nokeluar: nokeluar}, 
              dataType    : 'json', 
              encode      : true
          })      
          .done(function(result) {
            console.log(result);

            $('#nokeluar').val(result.nokeluar);
            $('#tglkeluar').val(result.tglkeluar);
            $('#uraian').val(result.uraian);

          }); 
          
          $('#lbljudul').html('Edit Data Pemakaian Barang');
          $('#lblactive').html('Edit');

    }else{
          $('#lbljudul').html('Tambah Data Pemakaian Barang');
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
        namabarang: {
          trigger: 'change keyup',
          validators:{
            callback: {
                            message: 'Nama Barang',
                            callback: function (value, validator, $namabarang) {

                                if ( $('#keybarang').val()=='' || $('#namabarang').val()=='' ) {
                                  return {
                                      valid: false,
                                      message: 'Nama barang tidak boleh kosong'
                                  }
                                }
                              return true
                            }
                        }
          }
        },
        qty: {
          trigger: 'change keyup',
          validators:{
            callback: {
                            message: '',
                            callback: function (value, validator, $qty) {

                                if ( $('#qty').val()=='' || $('#qty').val()=='0' ) {
                                  return {
                                      valid: false,
                                      message: 'Qty barang tidak boleh kosong'
                                  }
                                }
                              return true
                            }
                        }
          }
        },
      }
    })
    .on('success.form.bv', function(e) {
      e.preventDefault();
      
      keybarang           = $('#keybarang').val();
      kdbarang            = $('#kdbarang').val();
      qty                 = $('#qty').val();
      satuan              = $('#satuan').val();
      stokbarang          = $('#stokbarang').val();

      if (keybarang=='') {
        swal("Nama Barang", "Nama barang tidak boleh kosong!!", "warning");
        return false;
      }

      if (qty=='' || qty=='0') {
        swal("Qty", "Qty barang tidak boleh kosong!!", "warning");
        return false;
      }

      if ( parseInt(qty) > parseInt(stokbarang) ) {
        swal("Stok Tidak Cukup", "Stok tidak mencukupi!!", "warning");
        return false; 
      }
      
      var isicolomn = table.columns(1).data().toArray();
      for (var i = 0; i < isicolomn.length; i++) {
        for (var j = 0; j < isicolomn[i].length; j++) {            
          if (isicolomn[i][j] === keybarang) {
              swal("Sudah Ada", "Kode barang sudah ada!!", "warning");
              return false;
          }
        }
      };

        nomorrow = table.page.info().recordsTotal + 1;
        table.row.add( [
                            nomorrow,
                            $('#keybarang').val(),
                            $('#kdbarang').val(),
                            $('#namabarang').val(),
                            $('#satuan').val(),
                            $('#qty').val(),
                            '<span class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></span>'
                        ] ).draw( false );

        $('#qty').val('');
        $('#keybarang').val('');
        $('#kdbarang').val('');
        $('#namabarang').val('');
        $('#satuan').val('');
        $('#hargabelisatuan').val('');
        $('#subtotal').val('');
        $('#namabarang').focus();


    });
  //------------------------------------------------------------------------> END VALIDASI DAN SIMPAN

    $('#table tbody').on( 'click', 'span', function () {
        table
            .row( $(this).parents('tr') )
            .remove()
            .draw();
    });


    $("form").attr('autocomplete', 'off');
    // $('#tglkeluar').mask('00-00-0000', {placeholder:"hh-bb-tttt"});
    $('#hargabelisatuan').mask('000,000,000,000', {reverse: true});
    $('#subtotal').mask('000,000,000,000', {reverse: true});
  }); //end (document).ready
  

  
  $('#simpan').click(function(){
    var tglkeluar       = $('#tglkeluar').val();
    var uraian          = $('#uraian').val();
    var nokeluar        = $('#nokeluar').val();
    var total           = $('#total').val();

    $('#simpan').attr("disabled", true);

    
      if (tglkeluar=='') {
        swal("Tanggal Pembelian", "Tanggal pembelian tidak boleh kosong!!", "warning");
        $('#simpan').attr("disabled", false);
        return; 
      }

      if (uraian=='') {
        swal("Uraian", "Uraian tidak boleh kosong!!", "warning");
        $('#simpan').attr("disabled", false);
          return; 
      }

    if ( ! table.data().count() ) {
          swal("Detail Penerimaan", "Detail penerimaan belum ada!!", "warning");
        $('#simpan').attr("disabled", false);
          return;
      }

      var isidatatable = table.data().toArray();

      var formData = {
              'nokeluar'        : nokeluar,
              'tglkeluar'       : tglkeluar,
              'uraian'          : uraian,
              'total'           : total,
              'isidatatable'    : isidatatable
          };

      //console.log(isidatatable);
      // console.log(formData);
      $.ajax({
                type        : 'POST', 
                url         : '<?php echo site_url("Pemakaianbarang/simpan") ?>', 
                data        : formData, 
                dataType    : 'json', 
                encode      : true
            })
            .done(function(result){
                console.log(result);
                if (result.success) {
                    swal("Berhasil!", "Berhasil simpan data!", "success")
                      .then( (value) => {
                          window.location.href = "<?php echo(site_url('pemakaianbarang')) ?>";
                      });
                    // alert('Simpan data berhasil!');
                }else{
                  console.log(result.message);
                  swal("Gagal!", "Gagal simpan data! " + result.message, "warning");
                  $('#simpan').attr("disabled", false);
                }
            })
            .fail(function(){
                swal("Gagal!", "Gagal script simpan data!", "warning");
                $('#simpan').attr("disabled", false);
            });

  })

  $('#qty').change(function(){
    hitung_subtotal();
  });

  $('#hargabelisatuan').change(function(){
    hitung_subtotal();
  });

  function hitung_subtotal()
  {
    var qty = $('#qty').val();
    var hargabelisatuan = untitik($('#hargabelisatuan').val());
    var subtotal = parseInt(qty) * parseInt(hargabelisatuan);
    $('#subtotal').val( numberWithCommas(subtotal) );
  }

  $( "#namabarang").autocomplete({
      minLength: 0,
      source: function( request, response ){
          $.ajax({
            type: "POST",
            url: "<?php echo site_url('Umum/ajax_getbarang_stok'); ?>",
            dataType: "json",
            data:{term: request.term},
            success: function(data){
              response( data );
            }
          });
      },
      focus: function( event, ui ) {
        // $('#keybarang').val(ui.item.keybarang);
        // $('#namabarang').val(ui.item.namabarang);
        return false;
      },
      select: function( event, ui ) {
        $('#keybarang').val(ui.item.keybarang);
        $('#kdbarang').val(ui.item.kdbarang);
        $('#namabarang').val(ui.item.namabarang);
        $('#satuan').val(ui.item.satuan);
        $('#stokbarang').val(ui.item.stokbarang);
        $('#qty').focus();
        return false;
      }
    })
    .autocomplete( "instance" )._renderItem = function( ul, item ) {
      return $( "<li>" )
        .append( "<div><b>"+ item.namabarang + "</b><br />" + item.kdbarang + " - Stok : " + item.stokbarang + "</div>" )
        .appendTo( ul );
    };

</script>


</body>
</html>
