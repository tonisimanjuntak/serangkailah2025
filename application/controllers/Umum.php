<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Umum extends CI_Controller {

	public function ajax_getakun()
	{
		$cari= $this->input->post('term');
		$tahunanggaran = $this->session->userdata('tahunanggaran');
    	$query = "SELECT * FROM akun5 WHERE  tahunanggaran='".$tahunanggaran."' and 
    		( kdakun5 like '%".$cari."%' or namaakun5 like '%".$cari."%' ) order by kdakun5 asc limit 10";
		$res = $this->db->query($query);
		$result = array();
		foreach ($res->result() as $row) {
			array_push($result, array(
				'keyakun5' => $row->keyakun5,
				'kdakun5' => $row->kdakun5,
				'namaakun5' => $row->namaakun5
			));
		}
		echo json_encode($result);
	}


	public function ajax_getprogram()
	{
		$cari= $this->input->post('term');
		$tahunanggaran = $this->session->userdata('tahunanggaran');
    	$query = "SELECT * FROM v_program WHERE  tahunanggaran='".$tahunanggaran."' and 
    		( kdprogram like '%".$cari."%' or namaprogram like '%".$cari."%' ) order by kdprogram asc limit 10";
		$res = $this->db->query($query);
		$result = array();
		foreach ($res->result() as $row) {
			array_push($result, array(
				'keyprogram' => $row->keyprogram,
				'kdprogram' => $row->kdprogram,
				'namaprogram' => $row->namaprogram
			));
		}
		echo json_encode($result);
	}


	public function ajax_getbarang()
	{
		$cari			= $this->input->post('term');
		$tahunanggaran 	= $this->session->userdata('tahunanggaran');
		$kdruangan 		= $this->session->userdata('kdruangan');
    	$query = "SELECT * FROM v_barang WHERE  tahunanggaran='".$tahunanggaran."' and 
    		( kdbarang like '%".$cari."%' or namabarang like '%".$cari."%' ) order by namabarang asc limit 10";
		$res = $this->db->query($query);
		$result = array();
		foreach ($res->result() as $row) {
			array_push($result, array(
				'keybarang' => $row->keybarang,
				'kdbarang' => $row->kdbarang,
				'namabarang' => $row->namabarang,
				'satuan' => $row->satuan
			));
		}
		echo json_encode($result);
	}


	public function ajax_getbarang_stok()
	{
		$cari			= $this->input->post('term');
		$tahunanggaran 	= $this->session->userdata('tahunanggaran');
		$kdruangan 		= $this->session->userdata('kdruangan');
    	$query = "SELECT keybarang, kdbarang, namabarang, satuan, sum(stokbarang) as stokbarang FROM v_barang_stok 
    				WHERE  tahunanggaran='".$tahunanggaran."' and kdruangan ='".$kdruangan."' and 
    					( kdbarang like '%".$cari."%' or namabarang like '%".$cari."%' ) 
    					GROUP by keybarang, kdbarang, namabarang, satuan 
    					order by namabarang asc limit 10";
		$res = $this->db->query($query);
		$result = array();
		foreach ($res->result() as $row) {
			array_push($result, array(
				'keybarang' => $row->keybarang,
				'kdbarang' => $row->kdbarang,
				'namabarang' => $row->namabarang,
				'satuan' => $row->satuan,
				'stokbarang' => $row->stokbarang
			));
		}
		echo json_encode($result);
	}

}

/* End of file Umum.php */
/* Location: ./application/controllers/Umum.php */