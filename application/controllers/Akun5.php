<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Akun5 extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->is_login();
		$this->load->model('Akun5_model');
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
		$data['menu'] = 'akun5';
		$this->load->view('akun5/listdata', $data);
	}	

	public function tambah()
	{		
		$data['keyakun5'] = "";		
		$data['menu'] = 'akun5';	
		$this->load->view('akun5/form', $data);
	}

	public function edit($keyakun5)
	{		
		$keyakun5 = $this->encrypt->decode($keyakun5);

		if ($this->Akun5_model->get_by_id($keyakun5)->num_rows()<1) {
			$pesan = '<div>
						<div class="alert alert-danger alert-dismissable">
			                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
			                <strong>Ilegal!</strong> Data tidak ditemukan! 
					    </div>
					</div>';
			$this->session->set_flashdata('pesan', $pesan);
			redirect('Akun5');
			exit();
		};
		$data['keyakun5'] = $keyakun5;		
		$data['menu'] = 'akun5';
		$this->load->view('akun5/form', $data);
	}

	public function datatablesource()
	{
		$RsData = $this->Akun5_model->get_datatables();
		$no = $_POST['start'];
		$data = array();

		if ($RsData->num_rows()>0) {
			foreach ($RsData->result() as $rowdata) {
				$no++;
				$row = array();
				$row[] = $no;
	            $row[] = $rowdata->kdakun5;
	            $row[] = $rowdata->namaakun5;
	            $row[] = '<a href="'.site_url( 'Akun5/edit/'.$this->encrypt->encode($rowdata->keyakun5) ).'" class="btn btn-sm btn-warning btn-circle"><i class="fa fa-edit"></i></a> | 
	            		<a href="'.site_url('Akun5/delete/'.$this->encrypt->encode($rowdata->keyakun5) ).'" class="btn btn-sm btn-danger btn-circle" id="hapus"><i class="fa fa-trash"></i></a>';
	            $data[] = $row;
			}
		}

		$output = array(
                        "draw" => $_POST['draw'],
                        "recordsTotal" => $this->Akun5_model->count_all(),
                        "recordsFiltered" => $this->Akun5_model->count_filtered(),
                        "data" => $data,
                );

        //output to json format
        echo json_encode($output);
	}

	public function delete($id)
	{
		$id = $this->encrypt->decode($id);	
		
		if ($this->Akun5_model->get_by_id($id)->num_rows()<1) {
			$pesan = '<div>
						<div class="alert alert-danger alert-dismissable">
			                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
			                <strong>Ilegal!</strong> Data tidak ditemukan! 
					    </div>
					</div>';
			$this->session->set_flashdata('pesan', $pesan);
			redirect('Akun5');
			exit();
		};

		$hapus = $this->Akun5_model->hapus($id);
		if ($hapus) {			
			$pesan = '<div>
						<div class="alert alert-success alert-dismissable">
			                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
			                <strong>Berhasil!</strong> Data berhasil dihapus!
					    </div>
					</div>';
		}else{
			$eror = $this->db->error();			
			$pesan = '<div>
						<div class="alert alert-danger alert-dismissable">
			                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
			                <strong>Gagal!</strong> Data gagal dihapus karena sudah digunakan di jurnal! <br>
					    </div>
					</div>';
		}

		$this->session->set_flashdata('pesan', $pesan);
		redirect('Akun5');		

	}

	public function simpan()
	{		
		$keyakun5 			= $this->input->post('keyakun5');
		$kdakun5			= $this->input->post('kdakun5');
		$namaakun5			= $this->input->post('namaakun5');
		$tahunanggaran		= $this->session->userdata('tahunanggaran');

		if ( $keyakun5=='' ) { // data baru 
			$keyakun5 = $kdakun5.$tahunanggaran;

			$data = array(
							'keyakun5' 		=> $keyakun5, 
							'kdakun5' 		=> $kdakun5, 
							'namaakun5' 	=> $namaakun5, 
							'tahunanggaran' 	=> $tahunanggaran, 
						);

			$simpan = $this->Akun5_model->simpan($data);		
		}else{ 

			$data = array(
							'kdakun5' 		=> $kdakun5, 
							'namaakun5' 	=> $namaakun5, 
							'tahunanggaran' 	=> $tahunanggaran, 
						);

			$simpan = $this->Akun5_model->update($data, $keyakun5);
		}

		if ($simpan) {
			$pesan = '<div>
						<div class="alert alert-success alert-dismissable">
			                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
			                <strong>Berhasil!</strong> Data berhasil disimpan!
					    </div>
					</div>';
		}else{
			$eror = $this->db->error();			
			$pesan = '<div>
						<div class="alert alert-danger alert-dismissable">
			                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
			                <strong>Gagal!</strong> Data gagal disimpan! <br>
			                Pesan Error : '.$eror['code'].' '.$eror['message'].'
					    </div>
					</div>';
		}

		$this->session->set_flashdata('pesan', $pesan);
		redirect('Akun5');		
	}
	
	public function get_edit_data()
	{
		$keyakun5 = $this->input->post('keyakun5');
		$RsData = $this->Akun5_model->get_by_id($keyakun5)->row();

		$data = array(
					'keyakun5' =>  $RsData->keyakun5,
					'kdakun5' =>  $RsData->kdakun5,
					'namaakun5' =>  $RsData->namaakun5
					);
		echo(json_encode($data));
	}

}

/* End of file Akun5.php */
/* Location: ./application/controllers/Akun5.php */