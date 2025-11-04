<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Laporan_model extends CI_Model
{

    public function get_laporanstokfifo($where)
    {
        return $this->db->query("select * from v_penerimaanbarangdetail " . $where . " order by namabarang asc, tglterima asc, noterima asc");
    }

    public function get_laporanpembelian($where)
    {
        return $this->db->query("select * from v_penerimaanbarangdetail " . $where . " order by tglterima asc, noterima asc, namabarang asc");
    }

    public function get_laporanpemakaian($where)
    {
        return $this->db->query("select * from v_pengeluaranbarangdetail " . $where . " order by tglkeluar asc, nokeluar asc, namabarang asc");
    }

    public function get_daftarmutasipersediaan($where)
    {
        return $this->db->query("select * from v_lap_mutasi " . $where . " order by kdkelompok asc, namabarang asc");
    }

    public function get_daftarmutasipersediaan_fifo($where, $kdruangan, $kdupt)
    {
        if ($kdruangan!='-') {
            
            return $this->db->query("SELECT keybarang, hargabelisatuan, kdruangan, tahunanggaran, kdbarang, kdkelompok, keyakun5, merk, namabarang, satuan, `type`, namaruangan, kdupt, namaupt
                FROM v_penerimaanbarangdetail_all
                " . $where . "
                GROUP BY keybarang, hargabelisatuan, kdruangan, tahunanggaran, kdbarang, kdkelompok, keyakun5, merk, namabarang, satuan, `type`, namaruangan, kdupt, namaupt
                ORDER BY kdkelompok ASC, namabarang ASC");

        }else{
            if ($kdupt!='') {
                
                return $this->db->query("SELECT keybarang, hargabelisatuan, tahunanggaran, kdbarang, kdkelompok, keyakun5, merk, namabarang, satuan, `type`, kdupt
                    FROM v_penerimaanbarangdetail_all
                    " . $where . "
                    GROUP BY keybarang, hargabelisatuan, tahunanggaran, kdbarang, kdkelompok, keyakun5, merk, namabarang, satuan, `type`, kdupt
                    ORDER BY kdkelompok ASC, namabarang ASC");

            }else{

                // echo "SELECT keybarang, hargabelisatuan, tahunanggaran, kdbarang, kdkelompok, keyakun5, merk, namabarang, satuan, `type`
                //     FROM v_penerimaanbarangdetail_all
                //     " . $where . "
                //     GROUP BY keybarang, hargabelisatuan, tahunanggaran, kdbarang, kdkelompok, keyakun5, merk, namabarang, satuan, `type`
                //     ORDER BY kdkelompok ASC, namabarang ASC";
                // exit();

                return $this->db->query("SELECT keybarang, hargabelisatuan, tahunanggaran, kdbarang, kdkelompok, keyakun5, merk, namabarang, satuan, `type`, kdupt, namaupt
                    FROM v_penerimaanbarangdetail_all
                    " . $where . "
                    GROUP BY keybarang, hargabelisatuan, tahunanggaran, kdbarang, kdkelompok, keyakun5, merk, namabarang, satuan, `type`, kdupt, namaupt
                    ORDER BY namaupt ASC, kdkelompok ASC, namabarang ASC");

            }
        }
        
    }

}

/* End of file Laporan_model.php */
/* Location: ./application/models/Laporan_model.php */
