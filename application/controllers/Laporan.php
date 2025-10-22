<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Laporan extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Laporan_model');
	}

	public function index()
	{
		redirect('home');
	}

	public function laporanstokfifo()
	{
		$tglawal = date('Y-m-d');
		$tglakhir = date('Y-m-d');
		$data['tglawal'] = $tglawal;
		$data['tglakhir'] = $tglakhir;
		$data['menu'] = 'laporanstokfifo';	
		$this->load->view('laporan/laporanstokfifo/index', $data);
	}

	public function laporanstokfifo_cetak()
	{
		error_reporting(0);
		$this->load->library('Pdf');

		$jenislaporan 	= $this->uri->segment(3);
		$kdruangan 		= $this->uri->segment(4);
		$kdkelompok 	= $this->uri->segment(5);
		$keybarang 		= $this->uri->segment(6);
		$namaruangan	= "";
		$subjudul = "";


		$where 			= "where tahunanggaran='".$this->session->userdata('tahunanggaran')."' ";
		if ($kdruangan!='-') {
			$where .=" and kdruangan ='".$kdruangan."' ";
			$namaruangan .= $this->db->get_where('ruangan', array('kdruangan' => $kdruangan))->row()->namaruangan;
		}else{
			if ($this->session->userdata('akseslevel')=='2') {
				
				$kdupt = $this->session->userdata('kdupt');
				$where .=" and kdupt ='".$kdupt."' ";			
				$namaruangan .= $this->db->get_where('upt', array('kdupt' => $kdupt))->row()->namaupt;
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


		$data['rslaporan'] = $this->Laporan_model->get_laporanstokfifo($where);
		$data['subjudul'] = $subjudul;
		$data['namaruangan'] = strtoupper($namaruangan);

		if ($jenislaporan=='cetak') {
			$this->load->view('laporan/laporanstokfifo/cetak', $data);
		}else{
			$this->load->view('laporan/laporanstokfifo/excel', $data);
		}
	}



	public function laporanpembelian()
	{
		$tglawal = date('Y-m-d');
		$tglakhir = date('Y-m-d');
		$data['tglawal'] = $tglawal;
		$data['tglakhir'] = $tglakhir;
		$data['menu'] = 'laporanpembelian';	
		$this->load->view('laporan/laporanpembelian/index', $data);
	}

	public function laporanpembelian_cetak()
	{
		error_reporting(0);
		$this->load->library('Pdf');

		$jenislaporan 	= $this->uri->segment(3);
		$kdruangan 		= $this->uri->segment(4);
		$tglawal 		= date('Y-m-d', strtotime($this->uri->segment(5)));
		$tglakhir 		= date('Y-m-d', strtotime($this->uri->segment(6)));
		$kdkelompok 	= $this->uri->segment(7);
		$keybarang 		= $this->uri->segment(8);
		$namaruangan	= "";
		
		$where 			= "where tahunanggaran='".$this->session->userdata('tahunanggaran')."' and tglterima between '".$tglawal."' and '".$tglakhir."' ";
		$namaruangan = '';

		if ($kdruangan!='-') {
			$where .=" and kdruangan ='".$kdruangan."' ";
			$namaruangan .= $this->db->get_where('ruangan', array('kdruangan' => $kdruangan))->row()->namaruangan;
		}else{
			if ($this->session->userdata('akseslevel')=='2') {
				
				$kdupt = $this->session->userdata('kdupt');
				$where .=" and kdupt ='".$kdupt."' ";			
				$namaruangan .= $this->db->get_where('upt', array('kdupt' => $kdupt))->row()->namaupt;
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

		$data['rslaporan'] = $this->Laporan_model->get_laporanpembelian($where);
		$data['subjudul'] = $subjudul;
		$data['tglawal'] = $tglawal;
		$data['tglakhir'] = $tglakhir;
		$data['namaruangan'] = strtoupper($namaruangan);

		if ($jenislaporan=='cetak') {
			$this->load->view('laporan/laporanpembelian/cetak', $data);
		}else{
			$this->load->view('laporan/laporanpembelian/excel', $data);
		}
	}

	public function laporanpemakaian()
	{
		$tglawal = date('Y-m-d');
		$tglakhir = date('Y-m-d');
		$data['tglawal'] = $tglawal;
		$data['tglakhir'] = $tglakhir;
		$data['menu'] = 'laporanpemakaian';	
		$this->load->view('laporan/laporanpemakaian/index', $data);
	}

	public function laporanpemakaian_cetak()
	{
		error_reporting(0);
		$this->load->library('Pdf');

		$jenislaporan 	= $this->uri->segment(3);
		$kdruangan 		= $this->uri->segment(4);
		$tglawal 		= date('Y-m-d', strtotime($this->uri->segment(5)));
		$tglakhir 		= date('Y-m-d', strtotime($this->uri->segment(6)));
		$kdkelompok 	= $this->uri->segment(7);
		$keybarang 		= $this->uri->segment(8);
		$namaruangan	= "";
		
		$where 			= "where tahunanggaran='".$this->session->userdata('tahunanggaran')."' and tglkeluar between '".$tglawal."' and '".$tglakhir."' ";
		if ($kdruangan!='-') {
			$where .=" and kdruangan ='".$kdruangan."' ";
			$namaruangan .= $this->db->get_where('ruangan', array('kdruangan' => $kdruangan))->row()->namaruangan;
		}else{
			if ($this->session->userdata('akseslevel')=='2') {
				
				$kdupt = $this->session->userdata('kdupt');
				$where .=" and kdupt ='".$kdupt."' ";			
				$namaruangan .= $this->db->get_where('upt', array('kdupt' => $kdupt))->row()->namaupt;
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

		$data['rslaporan'] = $this->Laporan_model->get_laporanpemakaian($where);
		$data['subjudul'] = $subjudul;
		$data['tglawal'] = $tglawal;
		$data['tglakhir'] = $tglakhir;
		$data['namaruangan'] = strtoupper($namaruangan);

		if ($jenislaporan=='cetak') {
			$this->load->view('laporan/laporanpemakaian/cetak', $data);
		}else{
			$this->load->view('laporan/laporanpemakaian/excel', $data);
		}
	}


	public function daftarmutasipersediaan()
	{
		$tglawal = date('Y-m-d');
		$tglakhir = date('Y-m-d');
		$data['akseslevel'] = $this->session->userdata('akseslevel');
		$data['tglawal'] = $tglawal;
		$data['tglakhir'] = $tglakhir;
		$data['menu'] = 'daftarmutasipersediaan';	
		$this->load->view('laporan/daftarmutasipersediaan/index', $data);
	}

	public function daftarmutasipersediaan_cetak()
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
		

		/**
			DAFTAR PERSEDIAAN LAMA MENGGUNAKAN HARGA BELI AVERAGE
		**/

		/**
		$where 			= "where tahunanggaran='".$this->session->userdata('tahunanggaran')."' and keybarang is not null and jumlahunit_saldoawal+jumlahunit_penambahan+jumlahunit_pemakaian>0 ";
		if ($kdruangan!='-') {
			$where .=" and kdruangan ='".$kdruangan."' ";
			$namaruangan .= $this->db->get_where('ruangan', array('kdruangan' => $kdruangan))->row()->namaruangan;
		}else{
			if ($this->session->userdata('akseslevel')=='2') {
				
				$kdupt = $this->session->userdata('kdupt');
				$where .=" and kdupt ='".$kdupt."' ";			
				$namaruangan .= $this->db->get_where('upt', array('kdupt' => $kdupt))->row()->namaupt;
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

		$data['rslaporan'] = $this->Laporan_model->get_daftarmutasipersediaan($where);
		$data['subjudul'] = $subjudul;
		$data['tglawal'] = $tglawal;
		$data['tglakhir'] = $tglakhir;
		$data['namaruangan'] = strtoupper($namaruangan);
		if ($jenislaporan=='cetak') {
			$this->load->view('laporan/daftarmutasipersediaan/cetak', $data);
		}else{
			$this->load->view('laporan/daftarmutasipersediaan/excel', $data);
		}
		**/


		/**
		DAFTAR PERSEDIAAN SEBELUM GROUPING
		$where 			= "where tahunanggaran='".$this->session->userdata('tahunanggaran')."' and keybarang is not null and qtysaldoawal+qtypenerimaan+qtypengeluaran>0 ";
		if ($kdruangan!='-') {
			$where .=" and kdruangan ='".$kdruangan."' ";
			$namaruangan .= $this->db->get_where('ruangan', array('kdruangan' => $kdruangan))->row()->namaruangan;
		}else{
			if ($this->session->userdata('akseslevel')=='2') {
				
				$kdupt = $this->session->userdata('kdupt');
				$where .=" and kdupt ='".$kdupt."' ";			
				$namaruangan .= $this->db->get_where('upt', array('kdupt' => $kdupt))->row()->namaupt;
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

		$data['rslaporan'] = $this->Laporan_model->get_daftarmutasipersediaan_fifo($where);
		$data['subjudul'] = $subjudul;
		$data['tglawal'] = $tglawal;
		$data['tglakhir'] = $tglakhir;
		$data['namaruangan'] = strtoupper($namaruangan);
		if ($jenislaporan=='cetak') {
			$this->load->view('laporan/daftarmutasipersediaan/cetak_fifo', $data);
		}else{
			$this->load->view('laporan/daftarmutasipersediaan/excel_fifo', $data);
		}
		**/


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
		
		// echo "SELECT keybarang, hargabelisatuan, kdruangan, tahunanggaran, kdbarang, kdkelompok, keyakun5, merk, namabarang, satuan, `type`, namaruangan, kdupt
		// 		FROM v_penerimaanbarangdetail_all
		// 		" . $where . "
		// 		GROUP BY keybarang, hargabelisatuan, kdruangan, tahunanggaran, kdbarang, kdkelompok, keyakun5, merk, namabarang, satuan, `type`, namaruangan, kdupt
		// 		ORDER BY kdkelompok ASC, namabarang ASC, tglterima ASC";

		// exit();

		$data['rslaporan'] = $this->Laporan_model->get_daftarmutasipersediaan_fifo($where, $kdruangan, $kdupt);
		$data['subjudul'] = $subjudul;
		$data['tglawal'] = $tglawal;
		$data['tglakhir'] = $tglakhir;
		$data['namaruangan'] = strtoupper($namaruangan);
		$data['kdruangan'] = $kdruangan;
		$data['kdupt'] = $kdupt;
		$data['tahunanggaran'] = $this->session->userdata('tahunanggaran');

		if ($jenislaporan=='cetak') {
			$this->load->view('laporan/daftarmutasipersediaan/cetak_fifo_grouping', $data);
		}else{
			$this->load->view('laporan/daftarmutasipersediaan/excel_fifo', $data);
		}


	}


}

/* End of file Laporan.php */
/* Location: ./application/controllers/Laporan.php */