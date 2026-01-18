<?php
defined('BASEPATH') or exit('No direct script access allowed');

class MY_Controller extends CI_Controller {

    public function cekbataswaktupenginputan()
    {

        $rowPerruangan = $this->db->query("
            select * from bataswaktuperruangan where kdruangan='".$this->session->userdata('kdruangan')."'
        ");
        if ($rowPerruangan->num_rows()>0) {
            if ( date('Y-m-d H:i', strtotime($rowPerruangan->row()->tglruangan)) <= date('Y-m-d H:i') ) {
                redirect(site_url());
                exit();
            }
        }else{
            $rowpengaturan = $this->db->query("select * from pengaturan")->row();
            if ($rowpengaturan->aktifbataspenginputan) {
                if ( date('Y-m-d H:i', strtotime($rowpengaturan->tglbataspenginputan)) <= date('Y-m-d H:i') ) {
                    redirect(site_url());
                    exit();
                }
            }
        }

    }

    public function isBatasPenginputan()
    {
        $rowPerruangan = $this->db->query("
            select * from bataswaktuperruangan where kdruangan='".$this->session->userdata('kdruangan')."'
        ");
        if ($rowPerruangan->num_rows()>0) {
            if ( date('Y-m-d H:i', strtotime($rowPerruangan->row()->tglruangan)) <= date('Y-m-d H:i') ) {
                return true;
            }
        }else{
            $rowpengaturan = $this->db->query("select * from pengaturan")->row();
            if ($rowpengaturan->aktifbataspenginputan) {
                if ( date('Y-m-d H:i', strtotime($rowpengaturan->tglbataspenginputan)) <= date('Y-m-d H:i') ) {
                    return true;
                }
            }
        }
        return false;
    }

}