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
	            $row[] = $rowdata->namaruangan;
	            $row[] = $rowdata->alamat;
	            $row[] = $rowdata->notelp;
	            if ($rowdata->statusaktif=='1') {
		            $row[] = '<span class="badge badge-success">'.$rowdata->statusaktif2.'</span>' ;            	
	            }else{	
		            $row[] = '<span class="badge badge-danger">'.$rowdata->statusaktif2.'</span>' ;            	
	            }
	            if ($this->session->userdata('akseslevel')=='9') {
	            	
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

		$hapus = $this->Ruangan_model->hapus($id);
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
		redirect('ruangan');		

	}

	public function simpan()
	{		
		$kdruangan 			= $this->input->post('kdruangan');
		$namaruangan		= $this->input->post('namaruangan');
		$alamat				= $this->input->post('alamat');
		$notelp				= $this->input->post('notelp');
		$statusaktif		= $this->input->post('statusaktif');

		if ( $kdruangan=='' ) { // data baru 
			$kdruangan = $this->db->query("select create_kdruangan('".date('Y-m-d')."') as kdruangan")->row()->kdruangan;

			$data = array(
							'kdruangan' 	=> $kdruangan, 
							'namaruangan' 	=> $namaruangan, 
							'alamat' 		=> $alamat, 
							'notelp' 		=> $notelp, 
							'statusaktif' 	=> $statusaktif
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
							'statusaktif' 	=> $statusaktif
						);

			$simpan = $this->Ruangan_model->update($data, $kdruangan);
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
		redirect('ruangan');		
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
					'statusaktif' =>  $RsData->statusaktif
					);
		echo(json_encode($data));
	}

}

/* End of file Ruangan.php */
/* Location: ./application/controllers/Ruangan.php */