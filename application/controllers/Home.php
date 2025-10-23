<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->is_login();
		//Do your magic here
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
		$data['rowpengaturan'] = $this->db->query("select * from pengaturan")->row();
		$data['jumlahupt'] = $this->db->query("select count(*) as jumlahupt from upt")->row()->jumlahupt;
		$data['jumlahsekolah'] = $this->db->query("select count(*) as jumlahsekolah from ruangan where statusaktif='1'")->row()->jumlahsekolah;
		$data['jumlahpengguna'] = $this->db->query("select count(*) as jumlahpengguna from pengguna where akseslevel<>'9'")->row()->jumlahpengguna;
		$data['menu'] = 'home';	
		$this->load->view('home', $data);
	}


	public function riwayataktifitas()
	{		
		$data['menu'] = 'home';	
		$this->load->view('riwayataktifitas', $data);
	}


	public function listriwayat()
	{
		$this->db->reset_query();
		$Datatables = new $this->Datatables;
		$Datatables->tabelview = 'riwayataktifitas';
		$Datatables->column_order = array('id', 'deskripsi', 'namapengguna', 'namatabel', 'namafunction', null);
		$Datatables->column_search = array('deskripsi', 'namapengguna', 'namatabel', 'namafunction');
		$Datatables->order_array = array('inserted_date' => 'desc');

		
		//Where Condition
		$idpengguna = $_POST['idpengguna'];
		$tglawal = $_POST['tglawal'];
		$tglakhir = $_POST['tglakhir'];
		
		
		
		$where = " CAST(inserted_date as date) between '$tglawal' and '$tglakhir' ";
		if (!empty($idpengguna)) {
			$where .= " and idpengguna = '" . $idpengguna . "' ";
		}

		// echo json_encode(['error' => $where]);
		// exit();

		$Datatables->where_condition = $where;


		// static value
		$Datatables->search_value = $this->input->post('search')['value'];
		$Datatables->length_row = $this->input->post('length');
		$Datatables->start_row = $this->input->post('start');
		$urutkan = $this->input->post('order');
		if (isset($urutkan)) {
			$Datatables->num_order_colomn = $urutkan['0']['column'];
			$Datatables->num_order_dir = $urutkan['0']['dir'];
		} else {
			$Datatables->num_order_colomn = NULL;
			$Datatables->num_order_colomn = NULL;
		}
		//-- 

		$RsData = $Datatables->get_datatables();
		$no = $this->input->post('start');
		$data = array();

		if ($RsData->num_rows() > 0) {
			foreach ($RsData->result() as $rowdata) {
				$no++;
				$row = array();
				$row[] = $rowdata->id;
				$row[] = $rowdata->deskripsi;
				$row[] = $rowdata->namapengguna;
				$row[] = $rowdata->namatabel;
				$row[] = $rowdata->namafunction;
				$row[] = since($rowdata->inserted_date);
				$data[] = $row;
			}
		}

		$output = array(
			"draw" => $this->input->post('draw'),
			"recordsTotal" => $Datatables->count_all(),
			"recordsFiltered" => $Datatables->count_filtered(),
			"data" => $data,
		);

		//output to json format
		echo json_encode($output);
	}
}

/* End of file Home.php */
/* Location: ./application/controllers/Home.php */