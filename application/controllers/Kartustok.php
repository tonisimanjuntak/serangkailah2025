<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Kartustok extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
		$this->is_login();
        $this->load->model('Kartustok_model');
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
        $tglawal = date('Y-m-d');
		$tglakhir = date('Y-m-d');
		$data['akseslevel'] = $this->session->userdata('akseslevel');
		$data['tglawal'] = $tglawal;
		$data['tglakhir'] = $tglakhir;
		$data['menu'] = 'kartustok';	
		$this->load->view('kartustok/index', $data);
    }

    public function cetak()
	{
		error_reporting(0);
		$this->load->library('Pdf');

		$jenislaporan 	= $this->uri->segment(3);
		$tglawal 	= date('Y-m-d', strtotime($this->uri->segment(4)));
		$tglakhir 	= date('Y-m-d', strtotime($this->uri->segment(5)));
		
		$kdruangan 		= $this->uri->segment(6);
		$kdkelompok 	= $this->uri->segment(7);
		$keybarang 		= $this->uri->segment(8);
		$namaruangan	= $this->App->getRuangan($kdruangan)->namaruangan;
		$rowBarang = $this->App->getBarangById($keybarang);

		$where 			= "where tahunanggaran='".$this->session->userdata('tahunanggaran')."' and tgltransaksi between '".$tglawal."' and '".$tglakhir."' and keybarang is not null and kdruangan ='".$kdruangan."' and keybarang ='".$keybarang."' ";

		// var_dump($where);
		// exit();
		$data['rsStok'] = $this->Kartustok_model->getKartuStok($where);
		$data['subjudul'] = $subjudul;
		$data['tglawal'] = $tglawal;
		$data['tglakhir'] = $tglakhir;
		$data['namaruangan'] = strtoupper($namaruangan);
		$data['kdruangan'] = $kdruangan;
		$data['keybarang'] = $keybarang;
		$data['rowBarang'] = $rowBarang;
		$data['tahunanggaran'] = $this->session->userdata('tahunanggaran');

		if ($jenislaporan=='pdf') {
			$this->load->view('kartustok/cetak', $data);
		}else{
			$this->load->view('kartustok/cetak', $data);
		}


	}


}