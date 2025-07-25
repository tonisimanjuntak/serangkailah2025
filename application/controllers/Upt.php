<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Upt extends CI_Controller {

    public function __construct()
	{
		parent::__construct();
		$this->is_login();
		$this->cek_akses();
		$this->load->model('Upt_model');
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
    	if ($this->session->userdata('akseslevel')=='1') {
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
		$data['menu'] = 'upt';
		$this->load->view('upt/listdata', $data);
	}	

	public function tambah()
	{		
		$data['kdupt'] = "";		
		$data['menu'] = 'upt';	
		$this->load->view('upt/form', $data);
	}

	public function edit($kdupt)
	{		
		$kdupt = $this->encrypt->decode($kdupt);

		if ($this->Upt_model->get_by_id($kdupt)->num_rows()<1) {
			$pesan = '<div>
						<div class="alert alert-danger alert-dismissable">
			                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
			                <strong>Ilegal!</strong> Data tidak ditemukan! 
					    </div>
					</div>';
			$this->session->set_flashdata('pesan', $pesan);
			redirect('upt');
			exit();
		};
		$data['kdupt'] = $kdupt;		
		$data['menu'] = 'upt';
		$this->load->view('upt/form', $data);
	}

	public function datatablesource()
	{
		$RsData = $this->Upt_model->get_datatables();
		$no = $_POST['start'];
		$data = array();

		if ($RsData->num_rows()>0) {
			foreach ($RsData->result() as $rowdata) {
				$no++;
				$row = array();
				$row[] = $no;
	            $row[] = $rowdata->kdupt;
	            $row[] = htmlentities( $rowdata->namaupt );
	            $row[] = htmlentities( $rowdata->alamat );
	            $row[] = htmlentities( $rowdata->notelp );
	            if ( $this->session->userdata('akseslevel')=='9' || $this->session->userdata('akseslevel')=='3' ) {	            	
		            $row[] = '<a href="'.site_url( 'upt/edit/'.$this->encrypt->encode($rowdata->kdupt) ).'" class="btn btn-sm btn-warning btn-circle"><i class="fa fa-edit"></i></a> | 
		            		<a href="'.site_url('upt/delete/'.$this->encrypt->encode($rowdata->kdupt) ).'" class="btn btn-sm btn-danger btn-circle" id="hapus"><i class="fa fa-trash"></i></a>';
	            }else{
	            	$row[] = '<a href="'.site_url( 'upt/edit/'.$this->encrypt->encode($rowdata->kdupt) ).'" class="btn btn-sm btn-warning btn-circle"><i class="fa fa-edit"></i></a>';
	            	
	            }
	            $data[] = $row;
			}
		}

		$output = array(
                        "draw" => $_POST['draw'],
                        "recordsTotal" => $this->Upt_model->count_all(),
                        "recordsFiltered" => $this->Upt_model->count_filtered(),
                        "data" => $data,
                );

        //output to json format
        echo json_encode($output);
	}

	public function delete($id)
	{
		$id = $this->encrypt->decode($id);	
		
		if ($this->Upt_model->get_by_id($id)->num_rows()<1) {
			$pesan = '<div>
						<div class="alert alert-danger alert-dismissable">
			                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
			                <strong>Ilegal!</strong> Data tidak ditemukan! 
					    </div>
					</div>';
			$this->session->set_flashdata('pesan', $pesan);
			redirect('upt');
			exit();
		};

		$hapus = $this->Upt_model->hapus($id);
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
		redirect('upt');		

	}

	public function simpan()
	{		
		$kdupt 			= $this->input->post('kdupt');
		$namaupt		= htmlspecialchars( $this->input->post('namaupt') );
		$alamat				= htmlspecialchars( $this->input->post('alamat') );
		$notelp				= htmlspecialchars( $this->input->post('notelp') );
		$kdskpd 			= $this->input->post('kdskpd');
		

		if ( $kdupt=='' ) { // data baru 
			$kdupt = $this->db->query("select create_kdupt('UPT') as kdupt")->row()->kdupt;

			$data = array(
							'kdupt' 	=> $kdupt, 
							'namaupt' 	=> $namaupt, 
							'alamat' 		=> $alamat, 
							'notelp' 		=> $notelp, 
							'kdskpd' 		=> $kdskpd, 
							'lastupdate' 	=> date('Y-m-d H:i:s'),
							'idpengguna' 	=> $this->session->userdata('idpengguna'),
						);

			// var_dump($data);
			// exit();

			$simpan = $this->Upt_model->simpan($data);		
		}else{ 

			$data = array(
							'kdupt' 	=> $kdupt, 
							'namaupt' 	=> $namaupt, 
							'alamat' 		=> $alamat, 
							'notelp' 		=> $notelp, 
							'kdskpd' 	=> $kdskpd,
							'lastupdate' 	=> date('Y-m-d H:i:s'),
							'idpengguna' 	=> $this->session->userdata('idpengguna'),
						);

			$simpan = $this->Upt_model->update($data, $kdupt);
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
		redirect('upt');		
	}
	
	public function get_edit_data()
	{
		$kdupt = $this->input->post('kdupt');
		$RsData = $this->Upt_model->get_by_id($kdupt)->row();

		$data = array(
					'kdupt' =>  $RsData->kdupt,
					'namaupt' =>  $RsData->namaupt,
					'alamat' =>  $RsData->alamat,
					'notelp' =>  $RsData->notelp,
					'kdskpd' =>  $RsData->kdskpd
					);
		echo(json_encode($data));
	}

}

/* End of file Upt.php */

?>