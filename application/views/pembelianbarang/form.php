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
          <h1 class="m-0 text-dark">Pembelian Barang</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="<?php echo(site_url()) ?>">Home</a></li>
            <li class="breadcrumb-item"><a href="<?php echo(site_url('Pembelianbarang')) ?>">Pembelian Barang</a></li>
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


                      <input type="hidden" name="noterima" id="noterima">

                      <div class="form-group row required">
                        <label for="" class="col-md-2 col-form-label">Tanggal</label>
                        <div class="col-md-3">
                          <input type="date" name="tglterima" id="tglterima" class="form-control" value="<?php echo(date('Y-m-d')) ?>">
                        </div>
                      </div>

                      <div class="form-group row required">
                        <label for="" class="col-md-2 col-form-label">Uraian</label>
                        <div class="col-md-10">
                          <textarea name="uraian" id="uraian" class="form-control" rows="3" placeholder="Contoh: Pembelian ATK Kegiatan Alat Tulis Kantor"></textarea>
                        </div>
                      </div>

                      <div class="col-md-12">
                        <div class="card">
                          <div class="card-body">
                              <h3 class="text-muted text-center">Detail Penerimaan</h3>
                              <hr>

                              
                              <form action="<?php echo(site_url('Pembelianbarang/simpan')) ?>" method="post" id="form">                      
                                <div class="row">
                                  <div class="col-md-4">
                                    <div class="form-group">
                                      <label for="">Nama Barang</label>
                                        <input type="text" name="namabarang" id="namabarang" class="form-control" placeholder="Cari...">
                                        <input type="hidden" name="keybarang" id="keybarang">
                                        <input type="hidden" name="kdbarang" id="kdbarang">
                                    </div>
                                  </div>
                                  <div class="col-md-1">
                                    <div class="form-group">
                                      <label for="">Satuan</label>
                                      <input type="text" name="satuan" id="satuan" class="form-control" readonly="">
                                    </div>
                                  </div>

                                  <div class="col-md-1">
                                    <div class="form-group">
                                      <label for="">Qty</label>
                                      <input type="number" name="qty" id="qty" class="form-control" min="0">
                                    </div>
                                  </div>

                                  <div class="col-md-2">
                                    <div class="form-group">
                                      <label for="">Harga Beli Satuan</label>
                                      <input type="text" name="hargabelisatuan" id="hargabelisatuan" class="form-control text-right" placeholder="000,000,000,000">
                                    </div>
                                  </div>

                                  <div class="col-md-2">
                                    <div class="form-group">
                                      <label for="">Subtotal</label>
                                      <input type="text" name="subtotal" id="subtotal" class="form-control text-right" placeholder="000,000,000,000" readonly="">
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
                                            <th style="width: 10%;">Key Barang</th>
                                            <th style="width: 10%;">Kode Barang</th>
                                            <th>Nama Barang</th>
                                            <th>Satuan</th>
                                            <th style="text-align: right;">Harga Satuan</th>
                                            <th style="text-align: right;">QTY</th>
                                            <th style="text-align: right;">Sub Total</th>
                                            <th style="width: 5%; text-align: center;">Hapus</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                    <tfoot>
                                      <th></th>
                                      <th></th>
                                      <th></th>
                                      <th></th>
                                      <th></th>
                                      <th></th>
                                      <th style="text-align: right; font-weight: bold; font-size: 20px;">TOTAL: </th>
                                      <th style="text-align: right; font-weight: bold; font-size: 20px" colspan="2"></th>
                                    </tfoot>   
                                </table>
                              </div>

                          </div>
                        </div>
                        <input type="hidden" id="total">
                      </div>
                      

                  </div> <!-- ./card-body -->

                  <div class="card-footer">
                    <button class="btn btn-info float-right" id="simpan"><i class="fa fa-save"></i> Simpan</button>
                    <a href="<?php echo(site_url('Pembelianbarang')) ?>" class="btn btn-default float-right mr-1 ml-1"><i class="fa fa-chevron-circle-left"></i> Kembali</a>
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
  
  var noterima = "<?php echo($noterima) ?>";

  // console.log("noterima"+noterima);
  $(document).ready(function() {



    table = $('#table').DataTable({ 
        "select": true,
            "processing": true, 
            "ordering": false,
            "bPaginate": false,      
            "searching": false,  
            "bInfo" : false, 
             "ajax"  : {
                      "url": "<?php echo site_url('Pembelianbarang/datatablesourcedetail')?>",
                      "dataType": "json",
                      "type": "POST",
                      "data": {"noterima": '<?php echo($noterima) ?>'}
                  },
                "footerCallback": function ( row, data, start, end, display ) {
                                    var api = this.api(), data;
                         
                                    // Hilangkan format number untuk menghitung sum
                                    var intVal = function ( i ) {
                                        return typeof i === 'string' ?
                                            i.replace(/[\$,.]/g, '')*1 :
                                            typeof i === 'number' ?
                                                i : 0;
                                    };
                         
                                    // Total Semua Halaman
                                    total = api
                                        .column( 7 )
                                        .data()
                                        .reduce( function (a, b) {
                                            return intVal(a) + intVal(b);
                                        }, 0 );
                         
                                    // Total Halaman Terkait
                                    pageTotal = api
                                        .column( 7, { page: 'current'} )
                                        .data()
                                        .reduce( function (a, b) {
                                            return intVal(a) + intVal(b);
                                        }, 0 );
                                    
                                    jlhkeseluruhan = total;
                                    // Update footer
                                    $( api.column( 7 ).footer() ).html(
                                        'Rp. '+ numberWithCommas(total)                                        
                                    );
                                    $('#total').val( numberWithCommas(total) );
                                },
            "columnDefs": [
            { "targets": [ 1 ], "className": 'dt-body-center', "visible": false},
            { "targets": [ 2 ], "className": 'dt-body-center'},
            { "targets": [ 4 ], "className": 'dt-body-center'},
            { "targets": [ 5 ], "className": 'dt-body-right'},
            { "targets": [ 6 ], "className": 'dt-body-right'},
            { "targets": [ 7 ], "className": 'dt-body-right'},
            { "targets": [ 8 ], "orderable": false, "className": 'dt-body-center'},
            ],
     
        });



    //---------------------------------------------------------> JIKA EDIT DATA
    if ( noterima != "" ) { 
          $.ajax({
              type        : 'POST', 
              url         : '<?php echo site_url("Pembelianbarang/get_edit_data") ?>', 
              data        : {noterima: noterima}, 
              dataType    : 'json', 
              encode      : true
          })      
          .done(function(result) {
            console.log(result);

            $('#noterima').val(result.noterima);
            $('#tglterima').val(result.tglterima);
            $('#uraian').val(result.uraian);

          }); 
          
          $('#lbljudul').html('Edit Data Pembelian Barang');
          $('#lblactive').html('Edit');

    }else{
          $('#lbljudul').html('Tambah Data Pembelian Barang');
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
        hargabelisatuan: {
          trigger: 'change keyup',
          validators:{
            callback: {
                            message: '',
                            callback: function (value, validator, $hargabelisatuan) {

                                if ( $('#hargabelisatuan').val()=='' || $('#hargabelisatuan').val()=='0' ) {
                                  return {
                                      valid: false,
                                      message: 'Harga beli satuan tidak boleh kosong'
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
      kdbarang           = $('#kdbarang').val();
      qty                 = $('#qty').val();
      satuan              = $('#satuan').val();
      hargabelisatuan     = $('#hargabelisatuan').val();
      subtotal            = $('#subtotal').val();

      if (keybarang=='') {
        swal("Nama Barang", "Nama barang tidak boleh kosong!!", "warning");
        return false;
      }

      if (qty=='' || qty=='0') {
        swal("Qty", "Qty barang tidak boleh kosong!!", "warning");
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
                            $('#hargabelisatuan').val(),
                            $('#qty').val(),
                            $('#subtotal').val(),
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
    // $('#tglterima').mask('00-00-0000', {placeholder:"hh-bb-tttt"});
    $('#hargabelisatuan').mask('000,000,000,000', {reverse: true});
    $('#subtotal').mask('000,000,000,000', {reverse: true});
  }); //end (document).ready
  

  
  $('#simpan').click(function(){
    var tglterima       = $('#tglterima').val();
    var uraian          = $('#uraian').val();
    var noterima        = $('#noterima').val();
    var total           = $('#total').val();

    $('#simpan').attr("disabled", true);

    
      if (tglterima=='') {
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
              'noterima'        : noterima,
              'tglterima'       : tglterima,
              'uraian'          : uraian,
              'total'           : total,
              'isidatatable'    : isidatatable
          };

      //console.log(isidatatable);
      // console.log(formData);
      $.ajax({
                type        : 'POST', 
                url         : '<?php echo site_url("Pembelianbarang/simpan") ?>', 
                data        : formData, 
                dataType    : 'json', 
                encode      : true
            })
            .done(function(result){
                console.log(result);
                if (result.success) {
                    swal("Berhasil!", "Berhasil simpan data!", "success")
                      .then( (value) => {
                          window.location.href = "<?php echo(site_url('Pembelianbarang')) ?>";
                      });
                    // alert('Simpan data berhasil!');
                }else{
                  console.log(result.msg);
                  swal("Gagal!", "Gagal simpan data!", "warning");
                  $('#simpan').attr("disabled", false);
                  // alert(result.msg);
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
            url: "<?php echo site_url('Umum/ajax_getbarang'); ?>",
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
        $('#qty').focus();
        return false;
      }
    })
    .autocomplete( "instance" )._renderItem = function( ul, item ) {
      return $( "<li>" )
        .append( "<div><b>"+item.kdbarang +" "+ item.namabarang + "</b></div>" )
        .appendTo( ul );
    };

</script>


</body>
</html>
