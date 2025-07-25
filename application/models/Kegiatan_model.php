<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kegiatan_model extends CI_Model {

	// ------------------------- >   Ubah Data Disini Aja

	var $tabelview = 'v_kegiatan';
	var $tabel     = 'kegiatan';
	var $keykegiatan = 'keykegiatan';

    var $column_order = array(null, 'kdkegiatan', 'namakegiatan', 'namaprogram'); //set nama field yang bisa diurutkan
    var $column_search = array('kdkegiatan','namakegiatan', 'namaprogram'); //set nama field yang akan di cari
    var $order = array('kdkegiatan' => 'asc'); // default order 

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
        $this->db->where('keykegiatan', $id);
        return $this->db->get($this->tabelview);
    }

    public function hapus($id)
    {
    	$this->db->where('keykegiatan', $id);		
        return $this->db->delete($this->tabel);
    }

    public function simpan($data)
    {    	
    	return $this->db->insert($this->tabel, $data);
    }

    public function update($data, $id)
    {
    	$this->db->where('keykegiatan', $id);
        return $this->db->update($this->tabel, $data);
    }

}

/* End of file Kegiatan_model.php */
/* Location: ./application/models/Kegiatan_model.php */