<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pembelianbarang extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->is_login();
		$this->cekbataswaktupenginputan();
		$this->load->model('Pembelianbarang_model');
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

    public function cekbataswaktupenginputan()
    {
    	$rowpengaturan = $this->db->query("select * from pengaturan")->row();
    	if ($rowpengaturan->aktifbataspenginputan) {
            if ( date('Y-m-d H:i', strtotime($rowpengaturan->tglbataspenginputan)) <= date('Y-m-d H:i') ) {
    			redirect(site_url());
    			exit();
    		}
    	}

    }

	public function index()
	{
		$data['menu'] = 'pembelianbarang';
		$this->load->view('pembelianbarang/listdata', $data);
	}	

	public function tambah()
	{		
		$data['noterima'] = "";		
		$data['menu'] = 'pembelianbarang';	
		$this->load->view('pembelianbarang/form', $data);
	}

	public function edit($noterima)
	{		
		$noterima = $this->encrypt->decode($noterima);

		if ($this->Pembelianbarang_model->get_by_id($noterima)->num_rows()<1) {
			$pesan = '<div>
						<div class="alert alert-danger alert-dismissable">
			                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
			                <strong>Ilegal!</strong> Data tidak ditemukan! 
					    </div>
					</div>';
			$this->session->set_flashdata('pesan', $pesan);
			redirect('Pembelianbarang');
			exit();
		};

		if ($this->cek_pemakaian($noterima)) {
			$pesan = '<div>
						<div class="alert alert-danger alert-dismissable">
			                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
			                <strong>Upss!</strong> Barang ini sudah digunakan, tidak bisa diedit lagi! 
					    </div>
					</div>';
			$this->session->set_flashdata('pesan', $pesan);
			redirect('Pembelianbarang');
			exit();
		}

		$data['noterima'] = $noterima;		
		$data['menu'] = 'pembelianbarang';
		$this->load->view('pembelianbarang/form', $data);
	}

	public function datatablesource()
	{
		$RsData = $this->Pembelianbarang_model->get_datatables();
		$no = $_POST['start'];
		$data = array();

		if ($RsData->num_rows()>0) {
			foreach ($RsData->result() as $rowdata) {
				$no++;
				$row = array();
				$row[] = $no;
	            $row[] = $rowdata->noterima;
	            $row[] = date('d-m-Y', strtotime($rowdata->tglterima));
	            $row[] = htmlentities($rowdata->uraian);
	            $row[] = number_format($rowdata->totalbeli);
	            $row[] = '<a href="'.site_url( 'Pembelianbarang/edit/'.$this->encrypt->encode($rowdata->noterima) ).'" class="btn btn-sm btn-warning btn-circle"><i class="fa fa-edit"></i></a> | 
	            		<a href="'.site_url('Pembelianbarang/delete/'.$this->encrypt->encode($rowdata->noterima) ).'" class="btn btn-sm btn-danger btn-circle" id="hapus"><i class="fa fa-trash"></i></a>';
	            $data[] = $row;
			}
		}

		$output = array(
                        "draw" => $_POST['draw'],
                        "recordsTotal" => $this->Pembelianbarang_model->count_all(),
                        "recordsFiltered" => $this->Pembelianbarang_model->count_filtered(),
                        "data" => $data,
                );

        //output to json format
        echo json_encode($output);
	}

	public function datatablesourcedetail()
	{
		// query ini untuk item yang dimunculkan sesuai dengan kategori yang dipilih		

		$noterima = $this->input->post('noterima');
		$query = "select * from v_penerimaanbarangdetail
						WHERE v_penerimaanbarangdetail.noterima='".$noterima."'";

		$RsData = $this->db->query($query);

		$no = 0;
		$data = array();

		if ($RsData->num_rows()>0) {
			foreach ($RsData->result() as $rowdata) {				
				$no++;
				$row = array();
				$row[] = $no;
	            $row[] = $rowdata->keybarang;
	            $row[] = $rowdata->kdbarang;
	            $row[] = $rowdata->namabarang;
	            $row[] = $rowdata->satuan;
	            $row[] = number_format($rowdata->hargabelisatuan);
	            $row[] = number_format($rowdata->qtyterima);
	            $row[] = number_format( $rowdata->qtyterima * $rowdata->hargabelisatuan );
	            $row[] = '<span class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></span>';
	            $data[] = $row;
			}
		}

		$output = array(
                        "data" => $data,
                		);

        //output to json format
        echo json_encode($output);
	}

	public function delete($id)
	{
		$id = $this->encrypt->decode($id);	
		
		if ($this->Pembelianbarang_model->get_by_id($id)->num_rows()<1) {
			$pesan = '<div>
						<div class="alert alert-danger alert-dismissable">
			                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
			                <strong>Ilegal!</strong> Data tidak ditemukan! 
					    </div>
					</div>';
			$this->session->set_flashdata('pesan', $pesan);
			redirect('Pembelianbarang');
			exit();
		};


		if ($this->cek_pemakaian($id)) {
			$pesan = '<div>
						<div class="alert alert-danger alert-dismissable">
			                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
			                <strong>Upss!</strong> Barang ini sudah digunakan, tidak bisa hapus lagi! 
					    </div>
					</div>';
			$this->session->set_flashdata('pesan', $pesan);
			redirect('Pembelianbarang');
			exit();
		}

		$hapus = $this->Pembelianbarang_model->hapus($id);
		if ($hapus) {			
			$pesan = '<div>
						<div class="alert alert-success alert-dismissable">
			                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
			                <strong>Berhasil!</strong> Data berhasil dihapus!
					    </div>
					</div>';
		}else{
			$eror = $this->db->error();			
			$pesan = '<div>
						<div class="alert alert-danger alert-dismissable">
			                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
			                <strong>Gagal!</strong> Data gagal dihapus karena barang sudah digunakan! <br>
					    </div>
					</div>';
		}

		$this->session->set_flashdata('pesan', $pesan);
		redirect('Pembelianbarang');		

	}

	public function simpan()
	{		
		$noterima			= $this->input->post('noterima');
		$tglterima  		= date('Y-m-d', strtotime($this->input->post('tglterima')) );
		$uraian				= htmlspecialchars($this->input->post('uraian'));
		$total				= str_replace(',', '', $this->input->post('total'));
		$isidatatable		= $_REQUEST['isidatatable']; 				
		$idpengguna			= $this->session->userdata('idpengguna');
		$tahunanggaran		= $this->session->userdata('tahunanggaran');
		$tglupdate 		    = date('Y-m-d H:i:s');
		$kdruangan			= $this->session->userdata('kdruangan');
		$jenispenerimaan	= 'Penerimaan';



		//jika session berakhir
		if (empty($idpengguna)) { 
			echo json_encode(array('msg'=>"Session telah berakhir, Silahkan refresh halaman!"));
			exit();
		}				

		if ( date('Y', strtotime($tglterima)) != $tahunanggaran ) {
				echo json_encode(array('msg'=>'Tanggal transaksi tidak sama dengan tahun anggaran '));
				exit();	
			}

		if ($noterima=='') {
			
			$noterima = $this->db->query("select create_noterima('".date('Y-m-d')."') as noterima")->row()->noterima;

			// echo json_encode(array('msg'=>$isidatatable));
			// exit();	
			$arrayhead = array(
								'noterima' 					=> $noterima,
								'tglterima' 				=> $tglterima,
								'uraian' 					=> $uraian,
								'tahunanggaran' 			=> $tahunanggaran,
								'kdruangan' 				=> $kdruangan,
								'jenispenerimaan' 			=> $jenispenerimaan,
								'tglinsert' 				=> $tglupdate,
								'tglupdate' 				=> $tglupdate,
								'idpengguna' 				=> $idpengguna,
								'totalbeli' 				=> $total
								);

			//-------------------------------- >> simpan dari datatable	
			$i=0;
			$arraydetail=array();		
			foreach ($isidatatable as $item) {
				$keybarang 				= $item[1];
				$hargabelisatuan 		= $item[5];
				$qty					= $item[6];
				$i++;

				$detail = array(
								'noterima'				=> $noterima,
								'keybarang' 			=> $keybarang,
								'qtyterima' 			=> str_replace(',', '', $qty),
								'hargabelisatuan' 		=> str_replace(',', '', $hargabelisatuan),
								'stokbarang' 			=> str_replace(',', '', $qty)
								);

				array_push($arraydetail, $detail);				
			}

			$simpan  = $this->Pembelianbarang_model->simpan($arrayhead, $arraydetail, $noterima);
		}else{


			$arrayhead = array(
								'noterima' 					=> $noterima,
								'tglterima' 				=> $tglterima,
								'uraian' 					=> $uraian,
								'tahunanggaran' 			=> $tahunanggaran,
								'tglupdate' 				=> $tglupdate,
								'idpengguna' 				=> $idpengguna,
								'totalbeli' 				=> $total
								);
			
			//-------------------------------- >> simpan dari datatable	
			$i=0;
			$arraydetail=array();		
			foreach ($isidatatable as $item) {
				$keybarang 				= $item[1];
				$hargabelisatuan 		= $item[5];
				$qty					= $item[6];
				$i++;

				$detail = array(
								'noterima'				=> $noterima,
								'keybarang' 			=> $keybarang,
								'qtyterima' 			=> str_replace(',', '', $qty),
								'hargabelisatuan' 		=> str_replace(',', '', $hargabelisatuan),
								'stokbarang' 			=> str_replace(',', '', $qty)
								);

				array_push($arraydetail, $detail);				
			}

			$simpan  = $this->Pembelianbarang_model->update($arrayhead, $arraydetail, $noterima);

		}


		if (!$simpan) { //jika gagal
			$eror = $this->db->error();	
			echo json_encode(array('msg'=>'Kode Eror: '.$eror['code'].' '.$eror['message']));
			exit();
		}

		// jika berhasil akan sampai ke tahap ini		
		echo json_encode(array('success' => true, 'noterima' => $noterima));
	}
	
	public function get_edit_data()
	{
		$noterima = $this->input->post('noterima');
		$RsData = $this->Pembelianbarang_model->get_by_id($noterima)->row();

		$data = array(
					'noterima' 		=>  $RsData->noterima,
					'tglterima' 	=>  $RsData->tglterima,
					'uraian' 			=>  $RsData->uraian
					);
		echo(json_encode($data));
	}

	public function cek_pemakaian($noterima)
	{
		$cekrow = $this->db->query("select * from pengeluaranbarangdetail_noterima where noterima='$noterima'")->num_rows();
		if ($cekrow>0) {
			return true;
		}else{
			return false;
		}
	}

}

/* End of file Pembelianbarang.php */
/* Location: ./application/controllers/Pembelianbarang.php */