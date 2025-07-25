<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Saldoawal_model extends CI_Model {

	// ------------------------- >   Ubah Data Disini Aja

	var $tabelview = 'v_saldoawal';
	var $tabel     = 'penerimaanbarang';
	var $noterima = 'noterima';

    var $column_order = array(null, 'noterima', 'tglterima', 'uraian', 'totalbeli', null); //set nama field yang bisa diurutkan
    var $column_search = array('noterima','tglterima', 'uraian'); //set nama field yang akan di cari
    var $order = array('noterima' => 'desc'); // default order 

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
        $this->db->where('kdruangan', $this->session->userdata('kdruangan'));
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
        $this->db->where('noterima', $id);
        return $this->db->get($this->tabelview);
    }

    public function hapus()
    {

    	$tahunanggaran 	= $this->session->userdata('tahunanggaran');
    	$kdruangan 		= $this->session->userdata('kdruangan');

    	$rsSaldoAwal = $this->db->query("select * from v_saldoawal where kdruangan='$kdruangan' and tahunanggaran='$tahunanggaran' ");
    	if ($rsSaldoAwal->num_rows()>0) {
    		
	    	$this->db->trans_begin();
    		
    		$noterima = $rsSaldoAwal->row()->noterima;	
	        $this->db->query('delete from penerimaanbarangdetail where noterima="'.$noterima.'"');
	    	$this->db->where('noterima', $noterima);		
	        $this->db->delete('penerimaanbarang');

	        if ($this->db->trans_status() === FALSE){
	                $this->db->trans_rollback();
	                return false;
	        }else{
	                $this->db->trans_commit();
	                return true;
	        }
    	}else{
            return true;
    	}


    }

    public function simpan($arrayhead, $arraydetail, $noterima)
    {    	
    	$this->db->trans_begin();

        $this->db->insert('penerimaanbarang', $arrayhead);

        $this->db->query('delete from penerimaanbarangdetail where noterima="'.$noterima.'"');

        $this->db->insert_batch('penerimaanbarangdetail', $arraydetail);

        if ($this->db->trans_status() === FALSE){
                $this->db->trans_rollback();
                return false;
        }else{
                $this->db->trans_commit();
                return true;
        }
    }

    public function update($arrayhead, $arraydetail, $noterima)
    {
    	$this->db->trans_begin();

    	$this->db->where('noterima', $noterima);
        $this->db->update('penerimaanbarang', $arrayhead);


        $this->db->query('delete from penerimaanbarangdetail where noterima="'.$noterima.'"');

        $this->db->insert_batch('penerimaanbarangdetail', $arraydetail);


        $this->db->query("UPDATE penerimaanbarangdetail 
                        JOIN pengeluaranbarangdetail_noterima ON pengeluaranbarangdetail_noterima.`noterima`=penerimaanbarangdetail.noterima
                            AND pengeluaranbarangdetail_noterima.`keybarang`=penerimaanbarangdetail.keybarang
                            AND pengeluaranbarangdetail_noterima.`hargabelisatuan` = penerimaanbarangdetail.hargabelisatuan
                            SET penerimaanbarangdetail.stokbarang=penerimaanbarangdetail.stokbarang - pengeluaranbarangdetail_noterima.qtykeluar
                            WHERE penerimaanbarangdetail.noterima='$noterima' ");

        if ($this->db->trans_status() === FALSE){
                $this->db->trans_rollback();
                return false;
        }else{
                $this->db->trans_commit();
                return true;
        }
    }

}

/* End of file Saldoawal_model.php */
/* Location: ./application/models/Saldoawal_model.php */