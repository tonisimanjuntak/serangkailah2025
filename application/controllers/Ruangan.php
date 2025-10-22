<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Ruangan extends CI_Controller {

    public function __construct()
	{
		parent::__construct();
		$this->is_login();
		$this->load->model('Ruangan_model');
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

	public function index()
	{
		$data['menu'] = 'ruangan';
		$this->load->view('ruangan/listdata', $data);
	}	

	public function tambah()
	{		
		$data['kdruangan'] = "";		
		$data['menu'] = 'ruangan';	
		$this->load->view('ruangan/form', $data);
	}

	public function edit($kdruangan)
	{		
		$kdruangan = $this->encrypt->decode($kdruangan);

		if ($this->Ruangan_model->get_by_id($kdruangan)->num_rows()<1) {
			$pesan = '<div>
						<div class="alert alert-danger alert-dismissable">
			                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
			                <strong>Ilegal!</strong> Data tidak ditemukan! 
					    </div>
					</div>';
			$this->session->set_flashdata('pesan', $pesan);
			redirect('ruangan');
			exit();
		};
		$data['kdruangan'] = $kdruangan;		
		$data['menu'] = 'ruangan';
		$this->load->view('ruangan/form', $data);
	}

	public function datatablesource()
	{
		$RsData = $this->Ruangan_model->get_datatables();
		$no = $_POST['start'];
		$data = array();

		if ($RsData->num_rows()>0) {
			foreach ($RsData->result() as $rowdata) {
				$no++;
				$row = array();
				$row[] = $no;
	            $row[] = $rowdata->kdruangan;
	            $row[] = htmlentities($rowdata->namaruangan).'<br><small>'.htmlentities($rowdata->namaupt).'</small>';
	            $row[] = htmlentities($rowdata->alamat);
	            $row[] = htmlentities($rowdata->notelp);
	            if ($rowdata->statusaktif=='1') {
		            $row[] = '<span class="badge badge-success">'.$rowdata->statusaktif2.'</span>' ;            	
	            }else{	
		            $row[] = '<span class="badge badge-danger">'.$rowdata->statusaktif2.'</span>' ;            	
	            }
	            if ($this->session->userdata('akseslevel')=='9' || $this->session->userdata('akseslevel')=='3') {
	            	
		            $row[] = '<a href="'.site_url( 'ruangan/edit/'.$this->encrypt->encode($rowdata->kdruangan) ).'" class="btn btn-sm btn-warning btn-circle"><i class="fa fa-edit"></i></a> | 
		            		<a href="'.site_url('ruangan/delete/'.$this->encrypt->encode($rowdata->kdruangan) ).'" class="btn btn-sm btn-danger btn-circle" id="hapus"><i class="fa fa-trash"></i></a>';
	            }else{
	            	$row[] = '<a href="'.site_url( 'ruangan/edit/'.$this->encrypt->encode($rowdata->kdruangan) ).'" class="btn btn-sm btn-warning btn-circle"><i class="fa fa-edit"></i></a>';
	            	
	            }
	            $data[] = $row;
			}
		}

		$output = array(
                        "draw" => $_POST['draw'],
                        "recordsTotal" => $this->Ruangan_model->count_all(),
                        "recordsFiltered" => $this->Ruangan_model->count_filtered(),
                        "data" => $data,
                );

        //output to json format
        echo json_encode($output);
	}

	public function delete($id)
	{
		$id = $this->encrypt->decode($id);	
		
		if ($this->Ruangan_model->get_by_id($id)->num_rows()<1) {
			echo json_encode(array('message' => 'Data gagal dihapus! Data tidak ditemukan.'));
			exit();
		};

		$hapus = $this->Ruangan_model->hapus($id);
		if ($hapus['status'] == 'success') {
			echo json_encode(array('success' => true));
		}else{
			echo json_encode(array('message' => 'Data gagal dihapus! '.$hapus['message']));
		}

	}

	public function simpan()
	{		
		$kdruangan 			= $this->input->post('kdruangan');
		$namaruangan		= htmlspecialchars( $this->input->post('namaruangan') );
		$alamat				= htmlspecialchars( $this->input->post('alamat') );
		$notelp				= htmlspecialchars( $this->input->post('notelp') );
		$statusaktif		= htmlspecialchars( $this->input->post('statusaktif') );
		$kdupt 				= $this->input->post('kdupt');

		if ( $kdruangan=='' ) { // data baru 
			$kdruangan = $this->db->query("select create_kdruangan('".date('Y-m-d')."') as kdruangan")->row()->kdruangan;

			$data = array(
							'kdruangan' 	=> $kdruangan, 
							'namaruangan' 	=> $namaruangan, 
							'alamat' 		=> $alamat, 
							'notelp' 		=> $notelp, 
							'statusaktif' 	=> $statusaktif,
							'kdupt' 	=> $kdupt,
							'lastupdate' 	=> date('Y-m-d H:i:s'),
							'idpengguna' 	=> $this->session->userdata('idpengguna'),
						);

			// var_dump($data);
			// exit();

			$simpan = $this->Ruangan_model->simpan($data);		
		}else{ 

			$data = array(
							'kdruangan' 	=> $kdruangan, 
							'namaruangan' 	=> $namaruangan, 
							'alamat' 		=> $alamat, 
							'notelp' 		=> $notelp, 
							'statusaktif' 	=> $statusaktif,
							'kdupt' 	=> $kdupt,
							'lastupdate' 	=> date('Y-m-d H:i:s'),
							'idpengguna' 	=> $this->session->userdata('idpengguna'),
						);

			$simpan = $this->Ruangan_model->update($data, $kdruangan);
		}

		if ($simpan['status'] == 'success') {
			echo json_encode(array('success' => true));
		}else{
			echo json_encode(array('message' => 'Data gagal disimpan! '.$simpan['message']));						
		}
	}
	
	public function get_edit_data()
	{
		$kdruangan = $this->input->post('kdruangan');
		$RsData = $this->Ruangan_model->get_by_id($kdruangan)->row();

		$data = array(
					'kdruangan' =>  $RsData->kdruangan,
					'namaruangan' =>  $RsData->namaruangan,
					'alamat' =>  $RsData->alamat,
					'notelp' =>  $RsData->notelp,
					'statusaktif' =>  $RsData->statusaktif,
					'kdupt' =>  $RsData->kdupt,
					);
		echo(json_encode($data));
	}

}

/* End of file Ruangan.php */

?>