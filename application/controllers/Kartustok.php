<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Kartustok extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Kartustok_model');
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
		$tglawal 	= $this->uri->segment(4);
		$tglakhir 	= $this->uri->segment(5);
		
		$kdruangan 		= $this->uri->segment(6);
		$kdkelompok 	= $this->uri->segment(7);
		$keybarang 		= $this->uri->segment(8);
		$namaruangan	= "";
		


		$kdupt = '';
		$where 			= "where tahunanggaran='".$this->session->userdata('tahunanggaran')."' and keybarang is not null";
		if ($kdruangan!='-') {
			$where .=" and kdruangan ='".$kdruangan."' ";
			$namaruangan .= $this->db->get_where('ruangan', array('kdruangan' => $kdruangan))->row()->namaruangan;
			$kdupt = '';
		}else{
			if ($this->session->userdata('akseslevel')=='2') {
				
				$kdupt = $this->session->userdata('kdupt');
				$where .=" and kdupt ='".$kdupt."' ";			
				$namaruangan .= $this->db->get_where('upt', array('kdupt' => $kdupt))->row()->namaupt;
			}else{
				$where .= '';
				$namaruangan = '';
			}
		}

		if ($kdkelompok!='-') {
			$where .=" and kdkelompok ='".$kdkelompok."' ";
			if (!empty($subjudul)) { $subjudul .= " | "; }
			$subjudul .= "Kelompok Barang : ". $this->db->get_where('kelompokbarang', array('kdkelompok' => $kdkelompok))->row()->namakelompok;
		}

		if ($keybarang!='-') {
			$where .=" and keybarang ='".$keybarang."' ";
			if (!empty($subjudul)) { $subjudul .= " | "; }
			$subjudul .= "Nama Barang : ". $this->db->get_where('barang', array('keybarang' => $keybarang))->row()->namabarang;
		}
		

		$data['rslaporan'] = $this->Laporan_model->get_daftarmutasipersediaan_fifo($where, $kdruangan, $kdupt);
		$data['subjudul'] = $subjudul;
		$data['tglawal'] = $tglawal;
		$data['tglakhir'] = $tglakhir;
		$data['namaruangan'] = strtoupper($namaruangan);
		$data['kdruangan'] = $kdruangan;
		$data['kdupt'] = $kdupt;
		$data['tahunanggaran'] = $this->session->userdata('tahunanggaran');

		if ($jenislaporan=='pdf') {
			$this->load->view('kartustok/cetak', $data);
		}else{
			$this->load->view('kartustok/cetak', $data);
		}


	}


}