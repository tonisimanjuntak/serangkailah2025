<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Kartustok_model extends CI_Model {

    public function getKartuStok($where)
    {
        return $this->db->query("SELECT * FROM v_kartustok $where");
    }

}