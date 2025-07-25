<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kegiatan extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->is_login();
		$this->load->model('Kegiatan_model');
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
		$data['menu'] = 'kegiatan';
		$this->load->view('kegiatan/listdata', $data);
	}	

	public function tambah()
	{		
		$data['keykegiatan'] = "";		
		$data['menu'] = 'kegiatan';	
		$this->load->view('kegiatan/form', $data);
	}

	public function edit($keykegiatan)
	{		
		$keykegiatan = $this->encrypt->decode($keykegiatan);

		if ($this->Kegiatan_model->get_by_id($keykegiatan)->num_rows()<1) {
			$pesan = '<div>
						<div class="alert alert-danger alert-dismissable">
			                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
			                <strong>Ilegal!</strong> Data tidak ditemukan! 
					    </div>
					</div>';
			$this->session->set_flashdata('pesan', $pesan);
			redirect('Kegiatan');
			exit();
		};
		$data['keykegiatan'] = $keykegiatan;		
		$data['menu'] = 'kegiatan';
		$this->load->view('kegiatan/form', $data);
	}

	public function datatablesource()
	{
		$RsData = $this->Kegiatan_model->get_datatables();
		$no = $_POST['start'];
		$data = array();

		if ($RsData->num_rows()>0) {
			foreach ($RsData->result() as $rowdata) {
				$no++;
				$row = array();
				$row[] = $no;
	            $row[] = $rowdata->kdkegiatan;
	            $row[] = $rowdata->namakegiatan;
	            $row[] = $rowdata->namaprogram;
	            $row[] = '<a href="'.site_url( 'Kegiatan/edit/'.$this->encrypt->encode($rowdata->keykegiatan) ).'" class="btn btn-sm btn-warning btn-circle"><i class="fa fa-edit"></i></a> | 
	            		<a href="'.site_url('Kegiatan/delete/'.$this->encrypt->encode($rowdata->keykegiatan) ).'" class="btn btn-sm btn-danger btn-circle" id="hapus"><i class="fa fa-trash"></i></a>';
	            $data[] = $row;
			}
		}

		$output = array(
                        "draw" => $_POST['draw'],
                        "recordsTotal" => $this->Kegiatan_model->count_all(),
                        "recordsFiltered" => $this->Kegiatan_model->count_filtered(),
                        "data" => $data,
                );

        //output to json format
        echo json_encode($output);
	}

	public function delete($id)
	{
		$id = $this->encrypt->decode($id);	
		
		if ($this->Kegiatan_model->get_by_id($id)->num_rows()<1) {
			$pesan = '<div>
						<div class="alert alert-danger alert-dismissable">
			                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
			                <strong>Ilegal!</strong> Data tidak ditemukan! 
					    </div>
					</div>';
			$this->session->set_flashdata('pesan', $pesan);
			redirect('Kegiatan');
			exit();
		};

		$hapus = $this->Kegiatan_model->hapus($id);
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
		redirect('Kegiatan');		

	}

	public function simpan()
	{		
		$keykegiatan 			= $this->input->post('keykegiatan');
		$kdkegiatan 				= $this->input->post('kdkegiatan');
		$namakegiatan			= $this->input->post('namakegiatan');
		$keyprogram 			= $this->input->post('keyprogram');
		$tahunanggaran			= $this->session->userdata('tahunanggaran');


		if ( $keykegiatan=='' ) { // data baru 
			$keykegiatan = $kdkegiatan.$tahunanggaran;

			$data = array(
							'keykegiatan' 		=> $keykegiatan, 
							'kdkegiatan' 		=> $kdkegiatan, 
							'namakegiatan' 		=> $namakegiatan, 
							'keyprogram' 		=> $keyprogram, 
							'tahunanggaran' 	=> $tahunanggaran, 
						);

			$simpan = $this->Kegiatan_model->simpan($data);		
		}else{ 

			$data = array(
							'kdkegiatan' 		=> $kdkegiatan, 
							'namakegiatan' 		=> $namakegiatan, 
							'keyprogram' 		=> $keyprogram, 
							'tahunanggaran' 	=> $tahunanggaran, 
						);

			$simpan = $this->Kegiatan_model->update($data, $keykegiatan);
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
		redirect('Kegiatan');		
	}
	
	public function get_edit_data()
	{
		$keykegiatan = $this->input->post('keykegiatan');
		$RsData = $this->Kegiatan_model->get_by_id($keykegiatan)->row();

		$data = array(
					'keykegiatan' =>  $RsData->keykegiatan,
					'kdkegiatan' =>  $RsData->kdkegiatan,
					'namakegiatan' =>  $RsData->namakegiatan,
					'keyprogram' =>  $RsData->keyprogram,
					'kdprogram' =>  $RsData->kdprogram,
					'namaprogram' =>  $RsData->namaprogram
					);
		echo(json_encode($data));
	}

}

/* End of file Kegiatan.php */
/* Location: ./application/controllers/Kegiatan.php */