<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kelompokbarang extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->is_login();
		$this->cek_akses();
		$this->load->model('Kelompokbarang_model');
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
		$data['menu'] = 'kelompokbarang';
		$this->load->view('kelompokbarang/listdata', $data);
	}	

	public function tambah()
	{		
		$data['ltambah'] = "1";		
		$data['kdkelompok'] = "";		
		$data['menu'] = 'kelompokbarang';	
		$this->load->view('kelompokbarang/form', $data);
	}

	public function edit($kdkelompok)
	{		
		$kdkelompok = $this->encrypt->decode($kdkelompok);

		if ($this->Kelompokbarang_model->get_by_id($kdkelompok)->num_rows()<1) {
			$pesan = '<div>
						<div class="alert alert-danger alert-dismissable">
			                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
			                <strong>Ilegal!</strong> Data tidak ditemukan! 
					    </div>
					</div>';
			$this->session->set_flashdata('pesan', $pesan);
			redirect('Kelompokbarang');
			exit();
		};
		$data['ltambah'] = "0";		
		$data['kdkelompok'] = $kdkelompok;		
		$data['menu'] = 'kelompokbarang';
		$this->load->view('kelompokbarang/form', $data);
	}

	public function datatablesource()
	{
		$RsData = $this->Kelompokbarang_model->get_datatables();
		$no = $_POST['start'];
		$data = array();

		if ($RsData->num_rows()>0) {
			foreach ($RsData->result() as $rowdata) {
				$no++;
				$row = array();
				$row[] = $no;
	            $row[] = $rowdata->kdkelompok;
	            $row[] = htmlentities( $rowdata->namakelompok );
	            if ($rowdata->statusaktif=='1') {
		            $row[] = '<span class="badge badge-success">'.$rowdata->statusaktif2.'</span>' ;            	
	            }else{	
		            $row[] = '<span class="badge badge-danger">'.$rowdata->statusaktif2.'</span>' ;            	
	            }
	            $row[] = '<a href="'.site_url( 'Kelompokbarang/edit/'.$this->encrypt->encode($rowdata->kdkelompok) ).'" class="btn btn-sm btn-warning btn-circle"><i class="fa fa-edit"></i></a> | 
	            		<a href="'.site_url('Kelompokbarang/delete/'.$this->encrypt->encode($rowdata->kdkelompok) ).'" class="btn btn-sm btn-danger btn-circle" id="hapus"><i class="fa fa-trash"></i></a>';
	            $data[] = $row;
			}
		}

		$output = array(
                        "draw" => $_POST['draw'],
                        "recordsTotal" => $this->Kelompokbarang_model->count_all(),
                        "recordsFiltered" => $this->Kelompokbarang_model->count_filtered(),
                        "data" => $data,
                );

        //output to json format
        echo json_encode($output);
	}

	public function delete($id)
	{
		$id = $this->encrypt->decode($id);	
		
		if ($this->Kelompokbarang_model->get_by_id($id)->num_rows()<1) {
			$pesan = '<div>
						<div class="alert alert-danger alert-dismissable">
			                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
			                <strong>Ilegal!</strong> Data tidak ditemukan! 
					    </div>
					</div>';
			$this->session->set_flashdata('pesan', $pesan);
			redirect('Kelompokbarang');
			exit();
		};

		$hapus = $this->Kelompokbarang_model->hapus($id);
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
		redirect('Kelompokbarang');		

	}

	public function simpan()
	{		
		$ltambah 		= $this->input->post('ltambah');
		$kdkelompok 		= $this->input->post('kdkelompok');
		$namakelompok		= htmlspecialchars( $this->input->post('namakelompok') );
		$statusaktif		= $this->input->post('statusaktif');

		if ( $ltambah=='1' ) { // data baru 
			// $kdkelompok = $this->db->query("select create_kdkelompok('".strtoupper( substr($namakelompok, 0,2) )."') as kdkelompok")->row()->kdkelompok;

			$data = array(
							'kdkelompok' 	=> $kdkelompok, 
							'namakelompok' 	=> $namakelompok, 
							'statusaktif' 	=> $statusaktif,
							'lastupdate' 	=> date('Y-m-d H:i:s'),
							'idpengguna' 	=> $this->session->userdata('idpengguna'),
						);

			// var_dump($data);
			// exit();

			$simpan = $this->Kelompokbarang_model->simpan($data);		
		}else{ 

			$data = array(
							'kdkelompok' 	=> $kdkelompok, 
							'namakelompok' 	=> $namakelompok, 
							'statusaktif' 	=> $statusaktif,
							'lastupdate' 	=> date('Y-m-d H:i:s'),
							'idpengguna' 	=> $this->session->userdata('idpengguna'),
						);

			$simpan = $this->Kelompokbarang_model->update($data, $kdkelompok);
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
		redirect('Kelompokbarang');		
	}
	
	public function get_edit_data()
	{
		$kdkelompok = $this->input->post('kdkelompok');
		$RsData = $this->Kelompokbarang_model->get_by_id($kdkelompok)->row();

		$data = array(
					'kdkelompok' =>  $RsData->kdkelompok,
					'namakelompok' =>  $RsData->namakelompok,
					'statusaktif' =>  $RsData->statusaktif
					);
		echo(json_encode($data));
	}

}

/* End of file Kelompokbarang.php */
/* Location: ./application/controllers/Kelompokbarang.php */