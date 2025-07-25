<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pengaturan_model extends CI_Model
{

    public function update($data)
    {
        return $this->db->update('pengaturan', $data);
    }

    public function progress_migrasi($tahunanggaran, $kdruangan, $keybarangasal, $keybarangtujuan, $namabarangasal, $namabarangtujuan)
    {
        $this->db->trans_begin();

        $kdupt = $this->session->userdata('kdupt');
        if (!empty($kdruangan)) {
            $kdupt = null;
        }

        $datariwayat = array(
            'tglmigrasi'       => date('Y-m-d H:i:s'),
            'kdruangan'        => $kdruangan,
            'kdupt'            => $kdupt,
            'keybarangasal'    => $keybarangasal,
            'namabarangasal'   => $namabarangasal,
            'keybarangtujuan'  => $keybarangtujuan,
            'namabarangtujuan' => $namabarangtujuan,
            'tahunanggaran'    => $tahunanggaran,
            'idpengguna'       => $this->session->userdata('idpengguna'),
        );

        $this->db->insert("migrasibarang", $datariwayat);

        $andWhere = "";

        if (!empty($kdruangan)) {
            $andWhere = " and ruangan.kdruangan='$kdruangan'";
        } else {
            if ($this->session->userdata('akseslevel') == '2') {
                $andWhere = " and ruangan.kdupt='$kdupt'";
            }
        }

        $this->db->query("update pengeluaranbarangdetail_noterima set keybarang='$keybarangtujuan' where keybarang='$keybarangasal' and nokeluar in
                            (select nokeluar from pengeluaranbarang
                                join ruangan on pengeluaranbarang.kdruangan=ruangan.kdruangan where tahunanggaran='$tahunanggaran' " . $andWhere . " )
            ");

        $this->db->query("update pengeluaranbarangdetail set keybarang='$keybarangtujuan' where keybarang='$keybarangasal' and nokeluar in
                            (select nokeluar from pengeluaranbarang
                                join ruangan on pengeluaranbarang.kdruangan=ruangan.kdruangan where tahunanggaran='$tahunanggaran' " . $andWhere . " )
            ");

        $this->db->query("update penerimaanbarangdetail set keybarang='$keybarangtujuan' where keybarang='$keybarangasal' and noterima in
                            (select noterima from penerimaanbarang
                                join ruangan on penerimaanbarang.kdruangan=ruangan.kdruangan  where tahunanggaran='$tahunanggaran' " . $andWhere . " )
            ");

        if ($this->db->trans_status() === false) {
            $this->db->trans_rollback();
            return false;
        } else {
            $this->db->trans_commit();
            return true;
        }
    }

}

/* End of file Pengaturan_model.php */
/* Location: ./application/models/Pengaturan_model.php */
