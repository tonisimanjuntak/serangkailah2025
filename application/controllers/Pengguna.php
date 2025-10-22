<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pengguna extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->is_login();
		$this->cek_akses();
		$this->load->model('Pengguna_model');
		$this->load->library('image_lib');
	}

	public function is_login()
    {
        $idpengguna = $this->session->userdata('idpengguna');
        if (empty($idpengguna)) {
            $pesan = '<div class="alert alert-danger">Session telah berakhir. Silahkan login kembali . . . </div>';
            $this->session->set_flashdata('pesan', $pesan);
            redirect('Login'); 
            exit();
        }
    }	

    public function cek_akses()
    {
    	if ($this->session->userdata('akseslevel')!='9') {
    		$pesan = '<div>
						<div class="alert alert-danger alert-dismissable">
			                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
			                <strong> Maaf!</strong> Anda tidak dapat mengakses halaman ini! 
					    </div>
					</div>';
            $this->session->set_flashdata('pesan', $pesan);
            redirect('Home'); 
            exit();
    	}
    }

	public function index()
	{
		$data['menu'] = 'pengguna';
		$this->load->view('pengguna/listdata', $data);
	}	

	public function tambah()
	{		
		$data['idpengguna'] = "";		
		$data['menu'] = 'pengguna';	
		$this->load->view('pengguna/form', $data);
	}

	public function edit($idpengguna)
	{		
		$idpengguna = $this->encrypt->decode($idpengguna);

		if ($this->Pengguna_model->get_by_id($idpengguna)->num_rows()<1) {
			$pesan = '<div>
						<div class="alert alert-danger alert-dismissable">
			                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
			                <strong>Ilegal!</strong> Data tidak ditemukan! 
					    </div>
					</div>';
			$this->session->set_flashdata('pesan', $pesan);
			redirect('Pengguna');
			exit();
		};
		$data['idpengguna'] = $idpengguna;		
		$data['menu'] = 'pengguna';
		$this->load->view('pengguna/form', $data);
	}

	public function datatablesource()
	{
		$RsData = $this->Pengguna_model->get_datatables();
		$no = $_POST['start'];
		$data = array();

		if ($RsData->num_rows()>0) {
			foreach ($RsData->result() as $rowdata) {
				$no++;
				$row = array();
				$row[] = $no;
	            $row[] = $rowdata->idpengguna;
	            $row[] = htmlentities( $rowdata->namapengguna );
	            $row[] = htmlentities( $rowdata->username );
	            switch ($rowdata->akseslevel) {
	            	case '1':
			            $row[] = $rowdata->akseslevel2.'<br><small>'.$rowdata->namaruangan.'</small>';
	            		break;
	            	case '2':
			            $row[] = $rowdata->akseslevel2.'<br><small>'.$rowdata->namaupt.'</small>';
	            		break;
	            	
	            	default:
			            $row[] = $rowdata->akseslevel2;
	            		break;
	            }
	            if ($rowdata->statusaktif=='1') {
		            $row[] = '<span class="badge badge-success">'.$rowdata->statusaktif2.'</span>' ;	 	            	
	            }else{
		            $row[] = '<span class="badge badge-warning">'.$rowdata->statusaktif2.'</span>' ;	 	            	
	            }
	            $row[] = '<a href="'.site_url( 'Pengguna/edit/'.$this->encrypt->encode($rowdata->idpengguna) ).'" class="btn btn-sm btn-warning btn-circle"><i class="fa fa-edit"></i></a> | 
	            		<a href="'.site_url('Pengguna/delete/'.$this->encrypt->encode($rowdata->idpengguna) ).'" class="btn btn-sm btn-danger btn-circle" id="hapus"><i class="fa fa-trash"></i></a>';
	            $data[] = $row;
			}
		}

		$output = array(
                        "draw" => $_POST['draw'],
                        "recordsTotal" => $this->Pengguna_model->count_all(),
                        "recordsFiltered" => $this->Pengguna_model->count_filtered(),
                        "data" => $data,
                );

        //output to json format
        echo json_encode($output);
	}

	public function delete($id)
	{
		$id = $this->encrypt->decode($id);	
		$rspengguna = $this->Pengguna_model->get_by_id($id);
		if ($rspengguna->num_rows()<1) {
			echo json_encode(array('message' => 'Data tidak ditemukan!'));
			exit();
		};

		if ($id=='9999999999') {
			echo json_encode(array('message' => 'Pengguna ini tidak bisa dihapus!'));
			exit();
		};


		$hapus = $this->Pengguna_model->hapus($id);
		if ($hapus['status'] == 'success') {
			$foto = $rspengguna->row()->foto;
			if (file_exists('./uploads/pengguna/'.$foto)) { unlink('./uploads/pengguna/'.$foto); };

			echo json_encode(array('success' => true));
		}else{
			echo json_encode(array('message' => 'Data gagal dihapus! '.$hapus['message']));
		}	

	}

	public function simpan()
	{		
		$idpengguna 			= $this->input->post('idpengguna');
		$nip					= htmlspecialchars( $this->input->post('nip') );
		$namapengguna			= htmlspecialchars( $this->input->post('namapengguna') );
		$notelp					= htmlspecialchars( $this->input->post('notelp') );
		$tempatlahir			= htmlspecialchars( $this->input->post('tempatlahir') );
		if ($this->input->post('tgllahir')=='') {
			$tgllahir = null;
		}else{
			$tgllahir				= date('Y-m-d', strtotime($this->input->post('tgllahir')));
		}
		$jk						= $this->input->post('jk');
		$username				= htmlspecialchars( $this->input->post('username') );
		$password				= md5($this->input->post('password'));
		$statusaktif			= $this->input->post('statusaktif');
		$akseslevel				= $this->input->post('akseslevel');
		$kdruangan				= $this->input->post('kdruangan');
		$kdupt				= $this->input->post('kdupt');

		if ($akseslevel!='1') {
			$kdruangan = NULL;
		}

		if ($akseslevel!='2') {
			$kdupt = NULL;
		}


		if ( $idpengguna=='' ) { // data baru 

			$idpengguna = $this->db->query("select create_idpengguna('".date('Y-m-d')."') as idpengguna")->row()->idpengguna;
			$foto 				= $this->upload_foto($_FILES, "file", $idpengguna);		

			$data = array(
							'idpengguna' 		=> $idpengguna, 
							'namapengguna' 		=> $namapengguna, 
							'nip' 				=> $nip, 
							'notelp' 			=> $notelp, 
							'tempatlahir' 		=> $tempatlahir, 
							'tgllahir' 			=> $tgllahir, 
							'jk' 				=> $jk, 
							'kdruangan' 		=> $kdruangan, 
							'username' 			=> $username, 
							'password' 			=> $password, 
							'foto' 				=> $foto, 
							'akseslevel' 		=> $akseslevel, 
							'statusaktif' 		=> $statusaktif,
							'kdupt' 		=> $kdupt,
							'lastupdate' 	=> date('Y-m-d H:i:s'),
							'idupdater' 	=> $this->session->userdata('idpengguna'),
						);
			$simpan = $this->Pengguna_model->simpan($data);		
		}else{ 

			if ($idpengguna=='9999999999') {
				$level='9';
			}

			$file_lama = $this->input->post('file_lama');
			$foto = $this->update_upload_foto($_FILES, "file", $file_lama, $idpengguna);

			$data = array(
							'namapengguna' 		=> $namapengguna, 
							'nip' 				=> $nip, 
							'notelp' 			=> $notelp, 
							'tempatlahir' 		=> $tempatlahir, 
							'tgllahir' 			=> $tgllahir, 
							'jk' 				=> $jk, 
							'kdruangan' 		=> $kdruangan, 
							'username' 			=> $username, 
							'password' 			=> $password, 
							'foto' 				=> $foto, 
							'akseslevel' 		=> $akseslevel, 
							'statusaktif' 		=> $statusaktif,
							'kdupt' 		=> $kdupt,
							'lastupdate' 	=> date('Y-m-d H:i:s'),
							'idupdater' 	=> $this->session->userdata('idpengguna'),
						);
			$simpan = $this->Pengguna_model->update($data, $idpengguna);
		}

		if ($simpan['status'] == 'success') {
			echo json_encode(array('success' => true));
		}else{
			echo json_encode(array('message' => 'Data gagal disimpan! '.$simpan['message']));						
		}		
	}
	
	public function get_edit_data()
	{
		$idpengguna = $this->input->post('idpengguna');
		$RsData = $this->Pengguna_model->get_by_id($idpengguna)->row();

		$data = array(
					'idpengguna' 	=>  $RsData->idpengguna,
					'namapengguna' 	=>  $RsData->namapengguna,
					'nip' 			=>  $RsData->nip,
					'kdruangan' 	=>  $RsData->kdruangan,
					'kdupt' 	=>  $RsData->kdupt,
					'jk' 			=>  $RsData->jk,
					'tgllahir' 		=>  ($RsData->tgllahir!='') ? date('d-m-Y', strtotime($RsData->tgllahir)) : '',
					'tempatlahir' 	=>  $RsData->tempatlahir,
					'notelp' 		=>  $RsData->notelp,
					'username' 		=>  $RsData->username,
					'notelp' 		=>  $RsData->notelp,
					'foto' 			=>  $RsData->foto,
					'akseslevel' 	=>  $RsData->akseslevel,
					'statusaktif' 	=>  $RsData->statusaktif
					);
		echo(json_encode($data));
	}

	public function autocomplate()
	{
		$cari= $this->input->post('term');
    	$query = "SELECT * FROM v_akun WHERE statusaktif='4' and 
    		( idpengguna like '%".$cari."%' or namapengguna like '%".$cari."%' ) order by idpengguna asc limit 10";
		$res = $this->db->query($query);
		$result = array();
		foreach ($res->result() as $row) {
			array_push($result, array(
				'idpengguna' => $row->idpengguna,
				'namapengguna' => $row->namapengguna,
				'statusaktif' => $row->statusaktif,
				'saldonormal' => $row->saldonormal,
				'saldonormal2' => $row->saldonormal2,
			));
		}
		echo json_encode($result);
	}


	public function upload_foto($file, $nama, $new_name)
	{

		if (!empty($file[$nama]['name'])) {
			$config['upload_path']          = './uploads/pengguna/';
	        $config['allowed_types']        = 'gif|jpg|png|jpeg';
	        $config['file_name'] 			= $new_name;
	        $config['remove_space']         = TRUE;
            $config['max_size']            	= '2000KB';

	        $this->load->library('upload', $config);
	        
		    if ($this->upload->do_upload($nama)) {
                $foto = $this->upload->data('file_name');
                $size = $this->upload->data('file_size');
                $ext  = $this->upload->data('file_ext'); 
             }else{
                 $foto = "";
             }

		}else{
			$foto = "";
		}
		return $foto;
	}

	public function update_upload_foto($file, $nama, $file_lama, $new_name)
	{
		if (!empty($file[$nama]['name'])) {
			if ($file_lama!='' && $file_lama != null) {
				//hapus file lama
				if (file_exists('./uploads/pengguna/'.$file_lama)) { unlink('./uploads/pengguna/'.$file_lama); };
			}

			$config['upload_path']          = './uploads/pengguna/';
	        $config['allowed_types']        = 'gif|jpg|png|jpeg';
            $config['file_name'] 			= $new_name;
            $config['remove_space']         = TRUE;
            $config['max_size']            = '2000KB';
	        

	        $this->load->library('upload', $config);	       
            if ($this->upload->do_upload($nama)) {
                $foto = $this->upload->data('file_name');
                $size = $this->upload->data('file_size');
                $ext  = $this->upload->data('file_ext'); //extension .pdf
            }else{
                $foto = $file_lama;
            }	       
		}else{			
			$foto = $file_lama;
		}

		return $foto;
	}

}

/* End of file Pengguna.php */
/* Location: ./application/controllers/Pengguna.php */