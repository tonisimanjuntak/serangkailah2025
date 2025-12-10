<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class App extends CI_Model {

	public function query($namatabel, $where, $order_by)
	{
		$query = "select * from ".$namatabel." ".$where." ".$order_by;
		return $this->db->query($query);
	}	

	public function riwayatAktifitas($data, $namatabel, $namafunction)
    {
        $dataRiwayat = array(
            'deskripsi' => json_encode($data),
            'idpengguna' => $this->session->userdata('idpengguna'),
            'namapengguna' => $this->session->userdata('namapengguna'),
            'inserted_date' => date('Y-m-d H:i:s'),
            'namatabel' => $namatabel,
            'namafunction' => $namafunction,
        );
		$this->db->insert('riwayataktifitas', $dataRiwayat);
        return true;
    }

    public function getRuangan($kdruangan)
    {
        if (!empty($kdruangan)) {
            $this->db->where('kdruangan', $kdruangan);
            return $this->db->get('ruangan')->row();
        }else{
            return $this->db->get('ruangan');
        }
    }

    public function getBarangById($keybarang)
    {
        $this->db->where('keybarang', $keybarang);
        return $this->db->get('barang')->row();
    }

}
