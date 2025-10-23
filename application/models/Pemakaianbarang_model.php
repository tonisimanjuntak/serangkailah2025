<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pemakaianbarang_model extends CI_Model {

	// ------------------------- >   Ubah Data Disini Aja

	var $tabelview = 'v_pengeluaranbarang';
	var $tabel     = 'pengeluaranbarang';
	var $nokeluar = 'nokeluar';

    var $column_order = array(null, 'nokeluar', 'tglkeluar', 'uraian', null); //set nama field yang bisa diurutkan
    var $column_search = array('nokeluar','tglkeluar', 'uraian'); //set nama field yang akan di cari
    var $order = array('nokeluar' => 'desc'); // default order 

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
        $this->db->where('nokeluar', $id);
        return $this->db->get($this->tabelview);
    }

    public function hapus($id)
    {

        try {
            $this->db->trans_begin();
            
            $data = $this->get_by_id($id)->row();
            
            $this->kembalikan_stok_penerimaan($id);

            $this->db->query('delete from pengeluaranbarangdetail where nokeluar="'.$id.'"');
            $this->db->where('nokeluar', $id);		
            $this->db->delete('pengeluaranbarang');

            $this->App->riwayatAktifitas($data, 'pengeluaranbarang', 'hapusPengeluaranBarang');

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

    public function simpan($arrayhead, $arraydetail, $nokeluar)
    {    	

        try {
            $this->db->trans_begin(); 

            $this->db->insert('pengeluaranbarang', $arrayhead);
            $this->db->query('delete from pengeluaranbarangdetail where nokeluar="'.$nokeluar.'"');
            $this->db->insert_batch('pengeluaranbarangdetail', $arraydetail);

            //update stok fifo
            $this->kurangi_stok_penerimaan($arrayhead, $arraydetail);

            $this->App->riwayatAktifitas($arrayhead, 'pengeluaranbarang', 'simpanPengeluaranBarang');

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

    public function update($arrayhead, $arraydetail, $nokeluar)
    {

        try {
            $this->db->trans_begin();
            
            //update stok fifo
            $this->kembalikan_stok_penerimaan($nokeluar);
            $this->kurangi_stok_penerimaan($arrayhead, $arraydetail);

            $this->db->where('nokeluar', $nokeluar);
            $this->db->update('pengeluaranbarang', $arrayhead);

            $this->db->query('delete from pengeluaranbarangdetail where nokeluar="'.$nokeluar.'"');
            $this->db->insert_batch('pengeluaranbarangdetail', $arraydetail);

            $this->App->riwayatAktifitas($arrayhead, 'pengeluaranbarang', 'updatePengeluaranBarang');
        
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

    function kurangi_stok_penerimaan($arrayhead, $arraydetail)
    {
        $nokeluar           = $arrayhead['nokeluar'];
        $tahunanggaran      = $arrayhead['tahunanggaran'];
        $kdruangan          = $this->session->userdata('kdruangan');

        foreach ($arraydetail as $row) {

            $keybarang = $row['keybarang'];
            $qtykeluar = $row['qtykeluar'];

            //update stok fifo
            while ($qtykeluar > 0) {
                
                $rspenerimaan = $this->db->query("
                        select * from v_penerimaanbarangdetail_all where stokbarang != 0 and stokbarang is not null and keybarang='".$keybarang."' and kdruangan='".$kdruangan."' and tahunanggaran='".$tahunanggaran."' order by noterima asc limit 1
                    ");

                if ($rspenerimaan->num_rows()>0) {

                    $rowpenerimaan = $rspenerimaan->row();
                    if ( $rowpenerimaan->stokbarang >= $qtykeluar ) {
                        /**
                        ==================================================================
                        JIKA STOK PENERIMAAN MENCUKUPI 
                        ==================================================================
                        **/
                        $this->db->query("
                                insert into pengeluaranbarangdetail_noterima(nokeluar, noterima, keybarang, qtykeluar, hargabelisatuan)
                                    values('".$nokeluar."', '".$rowpenerimaan->noterima."', '".$rowpenerimaan->keybarang."', ".$qtykeluar.", ".$rowpenerimaan->hargabelisatuan.")
                            ");

                        $this->db->query("
                                update penerimaanbarangdetail set stokbarang=stokbarang-".$qtykeluar." where noterima='".$rowpenerimaan->noterima."' and keybarang='".$rowpenerimaan->keybarang."' and hargabelisatuan=".$rowpenerimaan->hargabelisatuan."
                            ");
                        $qtykeluar = 0;
                    }else{
                         /**
                        ==================================================================
                        JIKA STOK PENERIMAAN TIDAK MENCUKUPI MAKA LANJUTKAN KE PENERIMAAN BERIKUTNYA
                        ==================================================================
                        **/
                        $this->db->query("
                                insert into pengeluaranbarangdetail_noterima(nokeluar, noterima, keybarang, qtykeluar, hargabelisatuan)
                                    values('".$nokeluar."', '".$rowpenerimaan->noterima."', '".$rowpenerimaan->keybarang."', ".$rowpenerimaan->stokbarang.", ".$rowpenerimaan->hargabelisatuan.")
                            ");

                        $this->db->query("
                                update penerimaanbarangdetail set stokbarang=stokbarang-".$rowpenerimaan->stokbarang." where noterima='".$rowpenerimaan->noterima."' and keybarang='".$rowpenerimaan->keybarang."' and hargabelisatuan=".$rowpenerimaan->hargabelisatuan."
                            ");
                        $qtykeluar = $qtykeluar - $rowpenerimaan->stokbarang;
                    }


                }else{
                    /**
                    ==================================================================
                    JIKA STOK PENERIMAAN SEMUA SUDAH HABIS MAKA BIARKAN MINUS
                    DAN SIMPAN DI NOTERIMA TERAKHIR
                    ==================================================================
                    **/
                    $rspenerimaan = $this->db->query("
                        select * from v_penerimaanbarangdetail_all where keybarang='".$keybarang."' and kdruangan='".$kdruangan."' and tahunanggaran='".$tahunanggaran."' order by noterima desc limit 1
                    ");
                    $rowpenerimaan = $rspenerimaan->row();

                    $this->db->query("
                            insert into pengeluaranbarangdetail_noterima(nokeluar, noterima, keybarang, qtykeluar, hargabelisatuan)
                                values('".$nokeluar."', '".$rowpenerimaan->noterima."', '".$rowpenerimaan->keybarang."', ".$qtykeluar.", ".$rowpenerimaan->hargabelisatuan.")
                        ");

                    $this->db->query("
                            update penerimaanbarangdetail set stokbarang=stokbarang-".$qtykeluar." where noterima='".$rowpenerimaan->noterima."' and keybarang='".$rowpenerimaan->keybarang."' and hargabelisatuan=".$rowpenerimaan->hargabelisatuan."
                        ");
                    $qtykeluar = 0;
                }

            } 
        }
    }


    function kembalikan_stok_penerimaan($nokeluar)
    {
        $rsbarangkeluar = $this->db->query("
                    select * from pengeluaranbarangdetail_noterima where nokeluar='".$nokeluar."'
                ");

        if ($rsbarangkeluar->num_rows()>0) {
            foreach ($rsbarangkeluar->result() as $row) {
                $noterima = $row->noterima;
                $keybarang = $row->keybarang;
                $qtykeluar = $row->qtykeluar;
                $hargabelisatuan = $row->hargabelisatuan;

                $this->db->query("
                        update penerimaanbarangdetail set stokbarang=stokbarang+".$qtykeluar." where noterima='".$noterima."' and keybarang='".$keybarang."' and hargabelisatuan=".$hargabelisatuan."
                    ");

            }
        }

        $this->db->query("delete from pengeluaranbarangdetail_noterima where nokeluar='".$nokeluar."'");
    }

}

/* End of file Pemakaianbarang_model.php */
/* Location: ./application/models/Pemakaianbarang_model.php */