<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Select2 extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
    }

    public function searchBarang()
    {
        // Ambil parameter pencarian
        $tahunanggaran = $this->session->userdata('tahunanggaran');

        $search = $this->input->get('q'); 
        $kdruangan = $this->input->get('kdruangan');
        $kdkelompok = $this->input->get('kdkelompok');

        // Query dengan proteksi SQL Injection
        $query = $this->db->query("
            SELECT * 
            FROM barang 
            WHERE kdkelompok = ? AND tahunanggaran = ? AND (namabarang LIKE ? OR kdbarang LIKE ? )
            ORDER BY namabarang ASC
            LIMIT 50
        ", [$kdkelompok, $tahunanggaran, "%$search%", "%$search%"]);

        $formattedResults = [];

        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $formattedResults[] = [
                    'id' => $row->keybarang,
                    'text' => $row->kdbarang . ' - ' . $row->namabarang,
                ];
            }
        }

        // Kembalikan hasil sebagai JSON
        echo json_encode(['results' => $formattedResults]);
    }

}