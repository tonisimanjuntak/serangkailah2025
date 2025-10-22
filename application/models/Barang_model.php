<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Barang_model extends CI_Model {

	// ------------------------- >   Ubah Data Disini Aja

	var $tabelview = 'v_barang';
	var $tabel     = 'barang';
	var $keybarang = 'keybarang';

    var $column_order = array(null, 'kdbarang', 'namabarang', 'merk', 'type', 'satuan', null); //set nama field yang bisa diurutkan
    var $column_search = array('kdbarang','namabarang', 'merk', 'type', 'satuan'); //set nama field yang akan di cari
    var $order = array('kdbarang' => 'asc'); // default order 

    // ----------------------------


	function get_datatables()
    {
        $this->_get_datatables_query();
        if($_POST['length'] != -1)
        $this->db->limit($_POST['length'], $_POST['start']);
        return $this->db->get();        
    }

	private function _get_datatables_query()
    {
        $this->db->where('tahunanggaran', $this->session->userdata('tahunanggaran'));
        $this->db->from($this->tabelview);
        $i = 0;
     
        foreach ($this->column_search as $item) 
        {
            if($_POST['search']['value']) 
            {
                if($i===0) {
                    $this->db->group_start(); // Untuk Menggabung beberapa kondisi "AND"
                    $this->db->like($item, $_POST['search']['value']);
                }else{
                    $this->db->or_like($item, $_POST['search']['value']);
                }
                if(count($this->column_search) - 1 == $i) //last loop
                    $this->db->group_end(); 
            }
            $i++;
        }
        
        // -------------------------> Proses Order by        
        if(isset($_POST['order'])){
            $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        }else if(isset($this->order)){
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }

    }

    function count_filtered()
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

    public function get_by_id($id)
    {
        $this->db->where('keybarang', $id);
        return $this->db->get($this->tabelview);
    }

    public function hapus($id)
    {
        try {
            $this->db->trans_begin();
            
            $data = $this->get_by_id($id)->row();
            
            $this->db->where('keybarang', $id);		
            $this->db->delete($this->tabel);

            $this->App->riwayatAktifitas($data, 'barang', 'hapusBarang');

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
            $this->App->riwayatAktifitas($data, 'barang', 'simpanBarang');

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

    public function update($data, $id)
    {
        try {
            $this->db->trans_begin();
            
            $this->db->where('keybarang', $id);
            $this->db->update($this->tabel, $data);

            $this->App->riwayatAktifitas($data, 'barang', 'updateBarang');
        
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

    public function kodeSudahAda($kdbarang, $keybarang)
    {
        if (!empty($keybarang)) {
            $this->db->where('keybarang !=', $keybarang);            
        }
        $this->db->where('kdbarang', $kdbarang);
        $this->db->from('barang');
        $rsCek = $this->db->get();
        if ($rsCek->num_rows()>0) {
            return true;
        }else{
            return false;
        }
    }

}

/* End of file Barang_model.php */
/* Location: ./application/models/Barang_model.php */