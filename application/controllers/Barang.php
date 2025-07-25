<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Barang extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->is_login();
		$this->cek_akses();
		$this->load->model('Barang_model');
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
		$data['menu'] = 'barang';
		$this->load->view('barang/listdata', $data);
	}	

	public function tambah()
	{		
		$data['keybarang'] = "";		
		$data['menu'] = 'barang';	
		$this->load->view('barang/form', $data);
	}

	public function edit($keybarang)
	{		
		$keybarang = $this->encrypt->decode($keybarang);

		if ($this->Barang_model->get_by_id($keybarang)->num_rows()<1) {
			$pesan = '<div>
						<div class="alert alert-danger alert-dismissable">
			                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
			                <strong>Ilegal!</strong> Data tidak ditemukan! 
					    </div>
					</div>';
			$this->session->set_flashdata('pesan', $pesan);
			redirect('Barang');
			exit();
		};
		$data['keybarang'] = $keybarang;		
		$data['menu'] = 'barang';
		$this->load->view('barang/form', $data);
	}

	public function datatablesource()
	{
		$RsData = $this->Barang_model->get_datatables();
		$no = $_POST['start'];
		$data = array();

		if ($RsData->num_rows()>0) {
			foreach ($RsData->result() as $rowdata) {
				$no++;
				$row = array();
				$row[] = $no;
	            $row[] = $rowdata->kdbarang;
	            $row[] = htmlentities($rowdata->namabarang);
	            $row[] = htmlentities($rowdata->merk);
	            $row[] = htmlentities($rowdata->type);
	            $row[] = htmlentities($rowdata->satuan);
	            $row[] = '<a href="'.site_url( 'Barang/edit/'.$this->encrypt->encode($rowdata->keybarang) ).'" class="btn btn-sm btn-warning btn-circle"><i class="fa fa-edit"></i></a> | 
	            		<a href="'.site_url('Barang/delete/'.$this->encrypt->encode($rowdata->keybarang) ).'" class="btn btn-sm btn-danger btn-circle" id="hapus"><i class="fa fa-trash"></i></a>';
	            $data[] = $row;
			}
		}

		$output = array(
                        "draw" => $_POST['draw'],
                        "recordsTotal" => $this->Barang_model->count_all(),
                        "recordsFiltered" => $this->Barang_model->count_filtered(),
                        "data" => $data,
                );

        //output to json format
        echo json_encode($output);
	}

	public function delete($id)
	{
		$id = $this->encrypt->decode($id);	
		
		if ($this->Barang_model->get_by_id($id)->num_rows()<1) {
			$pesan = '<div>
						<div class="alert alert-danger alert-dismissable">
			                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
			                <strong>Ilegal!</strong> Data tidak ditemukan! 
					    </div>
					</div>';
			$this->session->set_flashdata('pesan', $pesan);
			redirect('Barang');
			exit();
		};

		$hapus = $this->Barang_model->hapus($id);
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
		redirect('Barang');		

	}

	public function simpan()
	{		
		$keybarang 			= $this->input->post('keybarang');
		$kdbarang 			= $this->input->post('kdbarang');
		$namabarang			= htmlspecialchars($this->input->post('namabarang'));
		$kdkelompok			= $this->input->post('kdkelompok');
		$keyakun5			= NULL;
		$merk			= htmlspecialchars($this->input->post('merk'));
		$type			= htmlspecialchars($this->input->post('type'));
		$satuan			= htmlspecialchars($this->input->post('satuan'));
		$tahunanggaran			= $this->session->userdata('tahunanggaran');

		if ($this->Barang_model->kodeSudahAda($kdbarang)) {			
			$pesan = '<div>
						<div class="alert alert-danger alert-dismissable">
			                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
			                <strong>Gagal!</strong> Kode barang sudah ada!
					    </div>
					</div>';
			$this->session->set_flashdata('pesan', $pesan);
			redirect('Barang');	
		}

		if ( $keybarang=='' ) { // data baru 
			// $kdbarang = $this->db->query("select create_kdbarang('".strtoupper( $kdkelompok )."') as kdbarang")->row()->kdbarang;
			$keybarang = $kdbarang.$tahunanggaran;

			$data = array(
							'keybarang' 		=> $keybarang, 
							'kdbarang' 		=> $kdbarang, 
							'namabarang' 	=> $namabarang, 
							'kdkelompok' 	=> $kdkelompok, 
							'keyakun5' 	=> $keyakun5, 
							'merk' 	=> $merk, 
							'type' 	=> $type, 
							'satuan' 	=> $satuan, 
							'tahunanggaran' 	=> $tahunanggaran, 
							'tglinsert' 	=> date('Y-m-d H:i:s'),
							'lastupdate' 	=> date('Y-m-d H:i:s'),
							'idpengguna' 	=> $this->session->userdata('idpengguna'),
						);

			$simpan = $this->Barang_model->simpan($data);		
		}else{ 

			$data = array(
							'keybarang' 		=> $keybarang, 
							'kdbarang' 	=> $kdbarang, 
							'namabarang' 	=> $namabarang, 
							'kdkelompok' 	=> $kdkelompok, 
							'keyakun5' 	=> $keyakun5, 
							'merk' 	=> $merk, 
							'type' 	=> $type, 
							'satuan' 	=> $satuan, 
							'tahunanggaran' 	=> $tahunanggaran, 
							'lastupdate' 	=> date('Y-m-d H:i:s'),
							'idpengguna' 	=> $this->session->userdata('idpengguna'),
						);

			$simpan = $this->Barang_model->update($data, $keybarang);
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
		redirect('Barang');		
	}
	
	public function get_edit_data()
	{
		$keybarang = $this->input->post('keybarang');
		$RsData = $this->Barang_model->get_by_id($keybarang)->row();

		$data = array(
					'keybarang' =>  $RsData->keybarang,
					'kdbarang' =>  $RsData->kdbarang,
					'namabarang' =>  $RsData->namabarang,
					'kdkelompok' =>  $RsData->kdkelompok,
					'merk' =>  $RsData->merk,
					'type' =>  $RsData->type,
					'satuan' =>  $RsData->satuan,
					);
		echo(json_encode($data));
	}

}

/* End of file Barang.php */
/* Location: ./application/controllers/Barang.php */