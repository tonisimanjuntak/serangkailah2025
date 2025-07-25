<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class App_model extends CI_Model {

	public function query($namatabel, $where, $order_by)
	{
		$query = "select * from ".$namatabel." ".$where." ".$order_by;
		return $this->db->query($query);
	}	

}

/* End of file App_model.php */
/* Location: ./application/models/App_model.php */