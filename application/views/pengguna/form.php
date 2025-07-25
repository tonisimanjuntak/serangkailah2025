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
          <h1 class="m-0 text-dark">Pengguna</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="<?php echo(site_url()) ?>">Home</a></li>
            <li class="breadcrumb-item"><a href="<?php echo(site_url('Pengguna')) ?>">Pengguna</a></li>
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
          <form action="<?php echo(site_url('Pengguna/simpan')) ?>" method="post" id="form" enctype="multipart/form-data">                      
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

                      <input type="hidden" name="idpengguna" id="idpengguna" class="form-control" placeholder="Contoh: 01">
                      
                      <div class="form-group row required">
                        <label for="" class="col-md-3 col-form-label">Nama Pengguna</label>
                        <div class="col-md-9">
                          <input type="text" name="namapengguna" id="namapengguna" class="form-control" placeholder="Contoh: Budi Susanto" autofocus="">
                        </div>
                      </div>

                      <div class="form-group row">
                        <label for="" class="col-md-3 col-form-label">Nomor Induk Pegawai</label>
                        <div class="col-md-4">
                          <input type="text" name="nip" id="nip" class="form-control" placeholder="Contoh: 18290102929201">
                        </div>
                      </div>

                      <div class="form-group row">
                        <label for="" class="col-md-3 col-form-label">No Telpon</label>
                        <div class="col-md-9">
                          <input type="text" name="notelp" id="notelp" class="form-control" placeholder="Contoh: Budi Susanto" autofocus="">
                        </div>
                      </div>

                      <div class="form-group row">
                        <label for="" class="col-md-3 col-form-label">Tempat Lahir</label>
                        <div class="col-md-5">
                          <input type="text" name="tempatlahir" id="tempatlahir" class="form-control" placeholder="Contoh: Deli Serdang">
                        </div>
                        <label for="" class="col-md-2 col-form-label text-right">Tgl Lahir</label>
                        <div class="col-md-2">
                          <input type="text" name="tgllahir" id="tgllahir" class="form-control">
                        </div>
                      </div>

                        <div class="form-group row required">
                          <label for="" class="col-md-3 col-form-label">Username</label>
                          <div class="col-md-4">
                            <input type="text" name="username" id="username" class="form-control" placeholder="Contoh: budisusanto">
                          </div>
                        </div>


                        <div class="form-group row required">
                          <label for="" class="col-md-3 col-form-label">Password</label>
                          <div class="col-md-4">
                            <input type="password" name="password" id="password" class="form-control" placeholder="************">
                          </div>
                        </div>

                        <div class="form-group row required">
                          <label for="" class="col-md-3 col-form-label">Jenis Kelamin</label>
                          <div class="col-md-9">
                            <select name="jk" id="jk" class="form-control">
                              <option value="">Pilih jenis kelamin..</option>
                              <option value="L">Laki-laki</option>
                              <option value="P">Perempuan</option>
                            </select>
                          </div>
                        </div>

                        <div class="form-group row required">
                          <label for="" class="col-md-3 col-form-label">Status Aktif</label>
                          <div class="col-md-9">
                            <select name="statusaktif" id="statusaktif" class="form-control">
                              <option value="1">Aktif</option>
                              <option value="0">Tidak Aktif</option>
                            </select>
                          </div>
                        </div>


                        <div class="form-group row required">
                          <label for="" class="col-md-3 col-form-label">AKSES LEVEL</label>
                          <div class="col-md-9">
                            <select name="akseslevel" id="akseslevel" class="form-control">
                              <option value="">Pilih akses level...</option>
                              <option value="1">User Sekolah</option>
                              <option value="2">User UPT</option>
                              <option value="3">User Dinas Pendidikan</option>
                              <option value="9">Admin System</option>
                            </select>
                          </div>
                        </div>

                        <div id="divruangan">
                          
                          <div class="form-group row required">
                            <label for="" class="col-md-3 col-form-label">SEKOLAH</label>
                            <div class="col-md-9">
                              <select name="kdruangan" id="kdruangan" class="form-control js-example-basic-single">
                                <option value="">Pilih nama sekolah...</option>
                                <?php  
                                  $rsruangan = $this->db->query("select * from ruangan order by namaruangan");
                                  foreach ($rsruangan->result() as $rowruangan) {
                                    echo '<option value="'.$rowruangan->kdruangan.'">'.$rowruangan->namaruangan.'</option>';
                                  }
                                ?>
                                
                              </select>
                            </div>
                          </div>
                        </div>

                        <div id="divupt">
                          
                          <div class="form-group row required">
                            <label for="" class="col-md-3 col-form-label">Nama UPT</label>
                            <div class="col-md-9">
                              <select name="kdupt" id="kdupt" class="form-control js-example-basic-single">
                                <option value="">Pilih nama upt...</option>
                                <?php  
                                  $rsupt = $this->db->query("select * from upt order by namaupt");
                                  foreach ($rsupt->result() as $rowupt) {
                                    echo '<option value="'.$rowupt->kdupt.'">'.$rowupt->namaupt.'</option>';
                                  }
                                ?>
                                
                              </select>
                            </div>
                          </div>
                        </div>


                        <div class="form-group row">
                            <label for="" class="col-md-3 col-form-label">Foto Pengguna <span style="color: red; font-size: 12px; font-weight: bold;"><i> Max ukuran file 2MB</i></span></label>
                            <div class="col-md-9">
                              <img src="<?php echo base_url('images/nofoto.png'); ?>" id="output1" class="img-thumbnail" style="width:30%;max-height:30%;">
                              <div class="form-group">
                                  <span class="btn btn-primary btn-file btn-block;" style="width:30%;">
                                    <span class="fileinput-new"><span class="fa fa-camera"></span> Upload Foto</span>
                                    <input type="file" name="file" id="file" accept="image/*" onchange="loadFile1(event)">
                                    <input type="hidden" value="" name="file_lama" id="file_lama" class="form-control" />
                                  </span>
                              </div>
                              <script type="text/javascript">
                                  var loadFile1 = function(event) {
                                      var output1 = document.getElementById('output1');
                                      output1.src = URL.createObjectURL(event.target.files[0]);
                                  };
                              </script>
                            </div>
                        </div>    


                  </div> <!-- ./card-body -->

                  <div class="card-footer">
                    <button type="submit" class="btn btn-info float-right"><i class="fa fa-save"></i> Simpan</button>
                    <a href="<?php echo(site_url('Pengguna')) ?>" class="btn btn-default float-right mr-1 ml-1"><i class="fa fa-chevron-circle-left"></i> Kembali</a>
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
  


<?php $this->load->view('template/footer') ?>



<script type="text/javascript">
  
  var idpengguna = "<?php echo($idpengguna) ?>";

  $(document).ready(function() {

    $('.js-example-basic-single').select2();
    //---------------------------------------------------------> JIKA EDIT DATA
    if ( idpengguna != "" ) { 
          $.ajax({
              type        : 'POST', 
              url         : '<?php echo site_url("Pengguna/get_edit_data") ?>', 
              data        : {idpengguna: idpengguna}, 
              dataType    : 'json', 
              encode      : true
          })      
          .done(function(result) {
            $('#idpengguna').val(result.idpengguna);
            $('#nip').val(result.nip);
            $('#namapengguna').val(result.namapengguna);
            $('#notelp').val(result.notelp);
            $('#tempatlahir').val(result.tempatlahir);
            $('#tgllahir').val(result.tgllahir);
            $('#username').val(result.username);
            $('#akseslevel').val(result.akseslevel);
            $('#kdruangan').val(result.kdruangan).trigger('change');
            $('#jk').val(result.jk);
            $('#statusaktif').val(result.statusaktif);
            $('#akseslevel').val(result.akseslevel);
            $('#file_lama').val(result.foto);

            if ( result.foto != '' && result.foto != null ) {
                $("#output1").attr("src","<?php echo(base_url('./uploads/pengguna/')) ?>" + result.foto);              
            }else{
                $("#output1").attr("src","<?php echo(base_url('./images/nofoto.png')) ?>");    
            }

            $('#akseslevel').change();
          }); 


          $('#lbljudul').html('Edit Data Pengguna');
          $('#lblactive').html('Edit');

    }else{
          $('#lbljudul').html('Tambah Data Pengguna');
          $('#lblactive').html('Tambah');
          $('#divruangan').hide();
          $('#divupt').hide();
    }     

    //----------------------------------------------------------------- > validasi
    $('#form').bootstrapValidator({
      feedbackIcons: {
        valid: 'glyphicon glyphicon-ok',
        invalid: 'glyphicon glyphicon-remove',
        validating: 'glyphicon glyphicon-refresh'
      },
      fields: {
        namapengguna: {
          validators:{
            notEmpty: {
                message: 'Nama Pengguna tidak boleh kosong'
            },
            stringLength: {
                max: 100,
                message: 'Panjang karakter maksimal 50 karakter'
            },
          }
        },
        username: {
          validators:{
            notEmpty: {
                message: 'Username tidak boleh kosong'
            },
            stringLength: {
                min: 5,
                max: 25,
                message: 'Panjang karakter minimal 5 sd 25 karakter'
            },
          }
        },
        password: {
          validators:{
            notEmpty: {
                message: 'Password tidak boleh kosong'
            },
            stringLength: {
                min: 8,
                max: 25,
                message: 'Panjang karakter minimal 8 sd 25 karakter'
            },
          }
        },
        jk: {
          validators:{
            notEmpty: {
                message: 'Jenis kelamin belum dipilih'
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
        akseslevel: {
          validators:{
            notEmpty: {
                message: 'Akses level belum dipilih'
            },
          }
        },
        kdruangan: {
          trigger: 'change keyup',
          validators:{
            callback: {
                            message: 'Nama sekolah belum dipilih',
                            callback: function (value, validator, $kdruangan) {

                                if ( $('#akseslevel').val()=='1' && $('#kdruangan').val()=='' ) {
                                  return {
                                      valid: false,
                                      message: 'Nama sekolah belum dipilih'
                                  }
                                }
                              return true
                            }
                        }
          }
        },
      }
    });
  //------------------------------------------------------------------------> END VALIDASI DAN SIMPAN


    $("form").attr('autocomplete', 'off');
    $('#tgllahir').mask('00-00-0000', {placeholder:"hh-bb-tttt"});
  }); //end (document).ready
  
  $('#akseslevel').change(function(){

    $('#divruangan').hide();
    $('#divupt').hide();

    switch($('#akseslevel').val()) {
      case '1' :
        $('#divruangan').show();
        $('#divupt').hide();
        
        break;
      case '2' :
        $('#divruangan').hide();
        $('#divupt').show();
        break;
    }

  })
</script>

</body>
</html>
