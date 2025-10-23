<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Penandatangan_model extends CI_Model
{

    // ------------------------- >   Ubah Data Disini Aja

    public $tabelview       = 'v_penandatangan';
    public $tabel           = 'penandatangan';
    public $idpenandatangan = 'idpenandatangan';

    public $column_order  = array(null, 'nip', 'namapenandatangan', 'jabatan', 'golongan', 'namaruangan', 'statusaktif2'); //set nama field yang bisa diurutkan
    public $column_search = array('nip', 'namapenandatangan', 'jabatan', 'golongan', 'namaruangan', 'statusaktif2'); //set nama field yang akan di cari
    public $order         = array('nip' => 'asc'); // default order

    // ----------------------------

    public function get_datatables()
    {
        $this->_get_datatables_query();
        if ($_POST['length'] != -1) {
            $this->db->limit($_POST['length'], $_POST['start']);
        }

        return $this->db->get();
    }

    private function _get_datatables_query()
    {
        if ($this->session->userdata('akseslevel') == '1') {
            $this->db->where('kdruangan', $this->session->userdata('kdruangan'));
        }
        $this->db->from($this->tabelview);
        $i = 0;

        foreach ($this->column_search as $item) {
            if ($_POST['search']['value']) {
                if ($i === 0) {
                    $this->db->group_start(); // Untuk Menggabung beberapa kondisi "AND"
                    $this->db->like($item, $_POST['search']['value']);
                } else {
                    $this->db->or_like($item, $_POST['search']['value']);
                }
                if (count($this->column_search) - 1 == $i) //last loop
                {
                    $this->db->group_end();
                }

            }
            $i++;
        }

        // -------------------------> Proses Order by
        if (isset($_POST['order'])) {
            $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else if (isset($this->order)) {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }

    }

    public function count_filtered()
    {
        $this->db->select('count(*) as jlh');
        $this->_get_datatables_query();
        $query = $this->db->get();
        return $query->row()->jlh;
    }

    public function count_all()
    {
        $this->db->select('count(*) as jlh');
        return $this->db->get($this->tabelview)->row()->jlh;
    }

    public function get_all()
    {
        return $this->db->get($this->tabelview);
    }

    public function get_by_id($idpenandatangan)
    {
        $this->db->where('idpenandatangan', $idpenandatangan);
        return $this->db->get($this->tabelview);
    }

    public function hapus($idpenandatangan)
    {
        try {
            $this->db->trans_begin();
            
            $data = $this->get_by_id($idpenandatangan)->row();
            
            $this->db->where('idpenandatangan', $idpenandatangan);
            $this->db->delete($this->tabel);

            $this->App->riwayatAktifitas($data, 'penandatangan', 'hapusPenandatangan');

            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                $error = $this->db->error();
                return [
                    'status' => 'error',
                    'message' => "Terjadi kesalahan: " . $error['message']
                ];
            } else {
                $this->db->trans_commit();
                return ['status' => 'success', 'message' => "Data berhasil dihapus"];
            }
        } catch (\Throwable $th) {
            $this->db->trans_rollback();
            return [
                'status' => 'error',
                'message' => "Terjadi kesalahan: " . $th->getMessage()
            ];
        }

        
    }

    public function simpan($data)
    {
        try {
            $this->db->trans_begin(); 

            $this->db->insert($this->tabel, $data);
            $this->App->riwayatAktifitas($data, 'penandatangan', 'simpanPenandatangan');

            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                $error = $this->db->error();
                return [
                    'status' => 'error',
                    'message' => "Terjadi kesalahan: " . $error['message']
                ];
            } else {
                $this->db->trans_commit();
                return ['status' => 'success', 'message' => "Data berhasil disimpan"];
            }
        } catch (\Throwable $th) {
            $this->db->trans_rollback();
            return [
                'status' => 'error',
                'message' => "Terjadi kesalahan: " . $th->getMessage()
            ];
        }
        
    }

    public function update($data, $idpenandatangan)
    {
        try {
            $this->db->trans_begin();
            
            $this->db->where('idpenandatangan', $idpenandatangan);
            $this->db->update($this->tabel, $data);

            $this->App->riwayatAktifitas($data, 'penandatangan', 'updatePenandatangan');
        
            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                $error = $this->db->error();
                return [
                    'status' => 'error',
                    'message' => "Terjadi kesalahan: " . $error['message']
                ];
            } else {
                $this->db->trans_commit();
                return ['status' => 'success', 'message' => "Data berhasil disimpan"];
            }
        } catch (\Throwable $th) {
            $this->db->trans_rollback();
            return [
                'status' => 'error',
                'message' => "Terjadi kesalahan: " . $th->getMessage()
            ];
        }   
        
    }

}

/* End of file Penandatangan_model.php */
/* Location: ./application/models/Penandatangan_model.php */
