<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Program extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->is_login();
		$this->load->model('Program_model');
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
		$data['menu'] = 'program';
		$this->load->view('program/listdata', $data);
	}	

	public function tambah()
	{		
		$data['keyprogram'] = "";		
		$data['menu'] = 'program';	
		$this->load->view('program/form', $data);
	}

	public function edit($keyprogram)
	{		
		$keyprogram = $this->encrypt->decode($keyprogram);

		if ($this->Program_model->get_by_id($keyprogram)->num_rows()<1) {
			$pesan = '<div>
						<div class="alert alert-danger alert-dismissable">
			                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
			                <strong>Ilegal!</strong> Data tidak ditemukan! 
					    </div>
					</div>';
			$this->session->set_flashdata('pesan', $pesan);
			redirect('Program');
			exit();
		};
		$data['keyprogram'] = $keyprogram;		
		$data['menu'] = 'program';
		$this->load->view('program/form', $data);
	}

	public function datatablesource()
	{
		$RsData = $this->Program_model->get_datatables();
		$no = $_POST['start'];
		$data = array();

		if ($RsData->num_rows()>0) {
			foreach ($RsData->result() as $rowdata) {
				$no++;
				$row = array();
				$row[] = $no;
	            $row[] = $rowdata->kdprogram;
	            $row[] = $rowdata->namaprogram;
	            $row[] = '<a href="'.site_url( 'Program/edit/'.$this->encrypt->encode($rowdata->keyprogram) ).'" class="btn btn-sm btn-warning btn-circle"><i class="fa fa-edit"></i></a> | 
	            		<a href="'.site_url('Program/delete/'.$this->encrypt->encode($rowdata->keyprogram) ).'" class="btn btn-sm btn-danger btn-circle" id="hapus"><i class="fa fa-trash"></i></a>';
	            $data[] = $row;
			}
		}

		$output = array(
                        "draw" => $_POST['draw'],
                        "recordsTotal" => $this->Program_model->count_all(),
                        "recordsFiltered" => $this->Program_model->count_filtered(),
                        "data" => $data,
                );

        //output to json format
        echo json_encode($output);
	}

	public function delete($id)
	{
		$id = $this->encrypt->decode($id);	
		
		if ($this->Program_model->get_by_id($id)->num_rows()<1) {
			$pesan = '<div>
						<div class="alert alert-danger alert-dismissable">
			                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
			                <strong>Ilegal!</strong> Data tidak ditemukan! 
					    </div>
					</div>';
			$this->session->set_flashdata('pesan', $pesan);
			redirect('Program');
			exit();
		};

		$hapus = $this->Program_model->hapus($id);
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
		redirect('Program');		

	}

	public function simpan()
	{		
		$keyprogram 			= $this->input->post('keyprogram');
		$kdprogram 				= $this->input->post('kdprogram');
		$namaprogram			= $this->input->post('namaprogram');
		$tahunanggaran			= $this->session->userdata('tahunanggaran');


		if ( $keyprogram=='' ) { // data baru 
			$keyprogram = $kdprogram.$tahunanggaran;

			$data = array(
							'keyprogram' 		=> $keyprogram, 
							'kdprogram' 		=> $kdprogram, 
							'namaprogram' 		=> $namaprogram, 
							'tahunanggaran' 	=> $tahunanggaran, 
						);

			$simpan = $this->Program_model->simpan($data);		
		}else{ 

			$data = array(
							'kdprogram' 		=> $kdprogram, 
							'namaprogram' 		=> $namaprogram, 
							'tahunanggaran' 	=> $tahunanggaran, 
						);

			$simpan = $this->Program_model->update($data, $keyprogram);
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
		redirect('Program');		
	}
	
	public function get_edit_data()
	{
		$keyprogram = $this->input->post('keyprogram');
		$RsData = $this->Program_model->get_by_id($keyprogram)->row();

		$data = array(
					'keyprogram' =>  $RsData->keyprogram,
					'kdprogram' =>  $RsData->kdprogram,
					'namaprogram' =>  $RsData->namaprogram
					);
		echo(json_encode($data));
	}

}

/* End of file Program.php */
/* Location: ./application/controllers/Program.php */