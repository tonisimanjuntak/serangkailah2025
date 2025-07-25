<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->is_login();
		//Do your magic here
	}

	public function is_login()
    {
        $idpengguna = $this->session->userdata('idpengguna');
        if (empty($idpengguna)) {
            $pesan = '<div class="alert alert-danger">Session telah berakhir. Silahkan login kembali . . . </div>';
            $this->session->set_flashdata('pesan', $pesan);
            redirect('Login'); 
            exit();
        }
    }	
    
	public function index()
	{
		$data['rowpengaturan'] = $this->db->query("select * from pengaturan")->row();
		$data['jumlahupt'] = $this->db->query("select count(*) as jumlahupt from upt")->row()->jumlahupt;
		$data['jumlahsekolah'] = $this->db->query("select count(*) as jumlahsekolah from ruangan where statusaktif='1'")->row()->jumlahsekolah;
		$data['jumlahpengguna'] = $this->db->query("select count(*) as jumlahpengguna from pengguna where akseslevel<>'9'")->row()->jumlahpengguna;
		$data['menu'] = 'home';	
		$this->load->view('home', $data);
	}

}

/* End of file Home.php */
/* Location: ./application/controllers/Home.php */