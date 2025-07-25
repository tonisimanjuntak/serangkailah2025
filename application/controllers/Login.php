<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

	public function __construct()
	{
		parent::__construct();		
		$this->load->model('Login_model'); 
	}

	public function keluar()
	{
		$this->session->sess_destroy(); 
		redirect('Login');
	}

	public function index()
	{ 
		$username = $this->session->userdata('username');
		if (!empty($username)) {
			redirect('Home');
		}else{
			$this->load->view('login');		
		}

	}


	function validate()
	{

	}

	public function cek_login()
	{
		$username = htmlspecialchars(trim($this->input->post('username')));
		$password = htmlspecialchars(trim($this->input->post('password')));
		$tahunanggaran = trim($this->input->post('tahunanggaran'));
		$captcha_response = trim($this->input->post('g-recaptcha-response'));

		// Validasi jika username atau password kosong
		if (empty($username) && empty($password)) {
			$pesan = '<div class="alert alert-danger">Username atau Password anda salah. Silahkan coba lagi.</div>';
			$this->session->set_flashdata('pesan', $pesan);
			redirect('Login');
		} else {
			// Pengecekan environment
			if (ENVIRONMENT === 'development') {
				// Jika environment adalah development, lewati validasi captcha
				$kirim = $this->Login_model->cek_login($username, md5($password));
				if ($kirim->num_rows() > 0) {
					$result = $kirim->row();
					$data = array(
						'idpengguna' => $result->idpengguna,
						'namapengguna' => $result->namapengguna,
						'kdruangan' => $result->kdruangan,
						'namaruangan' => $result->namaruangan,
						'nip' => $result->nip,
						'jk' => $result->jk,
						'jk2' => $result->jk2,
						'username' => $result->username,
						'foto' => $result->foto,
						'akseslevel' => $result->akseslevel,
						'akseslevel2' => $result->akseslevel2,
						'kdupt' => $result->kdupt,
						'namaupt' => $result->namaupt,
						'tahunanggaran' => $tahunanggaran
					);

					$this->session->set_userdata($data);
					redirect('Home');
				} else {
					$pesan = '<div class="alert alert-danger">Username atau Password Anda Salah, Silahkan Coba Lagi!</div>';
					$this->session->set_flashdata('pesan', $pesan);
					redirect('Login');
				}
			} elseif (ENVIRONMENT === 'production') {
				// Jika environment adalah production, validasi captcha wajib dilakukan
				if ($captcha_response != '') {
					$keySecret = '6Lclr9wfAAAAAHk9ttx39srSNbWzg-uhMCHsVjed';

					$check = array(
						'secret' => $keySecret,
						'response' => $this->input->post('g-recaptcha-response')
					);

					$startProcess = curl_init();
					curl_setopt($startProcess, CURLOPT_URL, "https://www.google.com/recaptcha/api/siteverify");
					curl_setopt($startProcess, CURLOPT_POST, true);
					curl_setopt($startProcess, CURLOPT_POSTFIELDS, http_build_query($check));
					curl_setopt($startProcess, CURLOPT_SSL_VERIFYPEER, false);
					curl_setopt($startProcess, CURLOPT_RETURNTRANSFER, true);
					$receiveData = curl_exec($startProcess);
					$finalResponse = json_decode($receiveData, true);

					if ($finalResponse['success']) {
						$kirim = $this->Login_model->cek_login($username, md5($password));
						if ($kirim->num_rows() > 0) {
							$result = $kirim->row();
							$data = array(
								'idpengguna' => $result->idpengguna,
								'namapengguna' => $result->namapengguna,
								'kdruangan' => $result->kdruangan,
								'namaruangan' => $result->namaruangan,
								'nip' => $result->nip,
								'jk' => $result->jk,
								'jk2' => $result->jk2,
								'username' => $result->username,
								'foto' => $result->foto,
								'akseslevel' => $result->akseslevel,
								'akseslevel2' => $result->akseslevel2,
								'kdupt' => $result->kdupt,
								'namaupt' => $result->namaupt,
								'tahunanggaran' => $tahunanggaran
							);

							$this->session->set_userdata($data);
							redirect('Home');
						} else {
							$pesan = '<div class="alert alert-danger">Username atau Password Anda Salah, Silahkan Coba Lagi!</div>';
							$this->session->set_flashdata('pesan', $pesan);
							redirect('Login');
						}
					} else {
						$pesan = '<div class="alert alert-danger">Validasi captcha gagal, silahkan coba lagi!</div>';
						$this->session->set_flashdata('pesan', $pesan);
						redirect('Login');
					}
				} else {
					$pesan = '<div class="alert alert-danger">Silahkan klik reCAPTCHA <b>\'I\'m not a robot\'</b> untuk melanjutkan, silahkan coba lagi!</div>';
					$this->session->set_flashdata('pesan', $pesan);
					redirect('Login');
				}
			}
		}
	}

}

/* End of file Login.php */
/* Location: ./application/controllers/Login.php */