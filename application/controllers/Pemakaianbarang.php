<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pemakaianbarang extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->is_login();
		$this->cekbataswaktupenginputan();
		$this->load->model('Pemakaianbarang_model');
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
		$data['menu'] = 'pemakaianbarang';
		$this->load->view('pemakaianbarang/listdata', $data);
	}	



	public function tambah()
	{		
		$data['nokeluar'] = "";		
		$data['menu'] = 'pemakaianbarang';	
		$this->load->view('pemakaianbarang/form', $data);
	}

	public function edit($nokeluar)
	{		
		$nokeluar = $this->encrypt->decode($nokeluar);

		if ($this->Pemakaianbarang_model->get_by_id($nokeluar)->num_rows()<1) {
			$pesan = '<div>
						<div class="alert alert-danger alert-dismissable">
			                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
			                <strong>Ilegal!</strong> Data tidak ditemukan! 
					    </div>
					</div>';
			$this->session->set_flashdata('pesan', $pesan);
			redirect('pemakaianbarang');
			exit();
		};
		$data['nokeluar'] = $nokeluar;		
		$data['menu'] = 'pemakaianbarang';
		$this->load->view('pemakaianbarang/form', $data);
	}

	public function datatablesource()
	{
		$RsData = $this->Pemakaianbarang_model->get_datatables();
		$no = $_POST['start'];
		$data = array();

		if ($RsData->num_rows()>0) {
			foreach ($RsData->result() as $rowdata) {
				$no++;
				$row = array();
				$row[] = $no;
	            $row[] = $rowdata->nokeluar;
	            $row[] = date('d-m-Y', strtotime($rowdata->tglkeluar));
	            $row[] = htmlentities($rowdata->uraian);
	            $row[] = '<a href="'.site_url( 'pemakaianbarang/edit/'.$this->encrypt->encode($rowdata->nokeluar) ).'" class="btn btn-sm btn-warning btn-circle"><i class="fa fa-edit"></i></a> | 
	            		<a href="'.site_url('pemakaianbarang/delete/'.$this->encrypt->encode($rowdata->nokeluar) ).'" class="btn btn-sm btn-danger btn-circle" id="hapus"><i class="fa fa-trash"></i></a>';
	            $data[] = $row;
			}
		}

		$output = array(
                        "draw" => $_POST['draw'],
                        "recordsTotal" => $this->Pemakaianbarang_model->count_all(),
                        "recordsFiltered" => $this->Pemakaianbarang_model->count_filtered(),
                        "data" => $data,
                );

        //output to json format
        echo json_encode($output);
	}

	public function datatablesourcedetail()
	{
		// query ini untuk item yang dimunculkan sesuai dengan kategori yang dipilih		

		$nokeluar = $this->input->post('nokeluar');
		$query = "select * from v_pengeluaranbarangdetail
						WHERE v_pengeluaranbarangdetail.nokeluar='".$nokeluar."'";

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
	            $row[] = number_format($rowdata->qtykeluar);
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
		
		if ($this->Pemakaianbarang_model->get_by_id($id)->num_rows()<1) {
			echo json_encode(array('message' => 'Data tidak ditemukan!'));
			exit();
		};

		$hapus = $this->Pemakaianbarang_model->hapus($id);
		if ($hapus['status'] == 'success') {
			echo json_encode(array('success' => true));
		}else{
			echo json_encode(array('message' => 'Data gagal dihapus! '.$hapus['message']));
		}
	}

	public function simpan()
	{		
		$nokeluar			= $this->input->post('nokeluar');
		$tglkeluar  		= date('Y-m-d', strtotime($this->input->post('tglkeluar')) );
		$uraian				= htmlspecialchars($this->input->post('uraian'));
		$isidatatable		= $_REQUEST['isidatatable']; 				
		$idpengguna			= $this->session->userdata('idpengguna');
		$tahunanggaran		= $this->session->userdata('tahunanggaran');
		$tglupdate 		    = date('Y-m-d H:i:s');
		$kdruangan			= $this->session->userdata('kdruangan');


		// echo json_encode(array('msg'=>$tglkeluar));
		// exit();	

		//jika session berakhir
		if (empty($idpengguna)) { 
			echo json_encode(array('msg'=>"Session telah berakhir, Silahkan refresh halaman!"));
			exit();
		}				

		if ( date('Y', strtotime($tglkeluar)) != $tahunanggaran ) {
				echo json_encode(array('msg'=>'Tanggal transaksi tidak sama dengan tahun anggaran '));
				exit();	
			}

		if ($nokeluar=='') {
			
			$nokeluar = $this->db->query("select create_nokeluar('".date('Y-m-d')."') as nokeluar")->row()->nokeluar;

			// echo json_encode(array('msg'=>$isidatatable));
			// exit();	
			$arrayhead = array(
								'nokeluar' 					=> $nokeluar,
								'tglkeluar' 				=> $tglkeluar,
								'uraian' 					=> $uraian,
								'tahunanggaran' 			=> $tahunanggaran,
								'kdruangan' 				=> $kdruangan,
								'tglinsert' 				=> $tglupdate,
								'tglupdate' 				=> $tglupdate,
								'idpengguna' 				=> $idpengguna
								);

			// echo json_encode(array('msg'=>$arrayhead));
			// 	exit();	
			//-------------------------------- >> simpan dari datatable	
			$i=0;
			$arraydetail=array();		
			foreach ($isidatatable as $item) {
				$keybarang 				= $item[1];
				$qty					= $item[5];
				$i++;

				$detail = array(
								'nokeluar'				=> $nokeluar,
								'keybarang' 			=> $keybarang,
								'qtykeluar' 			=> str_replace(',', '', $qty)
								);

				array_push($arraydetail, $detail);				
			}


			$simpan  = $this->Pemakaianbarang_model->simpan($arrayhead, $arraydetail, $nokeluar);
		}else{


			$arrayhead = array(
								'nokeluar' 					=> $nokeluar,
								'tglkeluar' 				=> $tglkeluar,
								'uraian' 					=> $uraian,
								'tahunanggaran' 			=> $tahunanggaran,
								'tglupdate' 				=> $tglupdate,
								'idpengguna' 				=> $idpengguna
								);
			//-------------------------------- >> simpan dari datatable	
			$i=0;
			$arraydetail=array();		
			foreach ($isidatatable as $item) {
				$keybarang 				= $item[1];
				$qty					= $item[5];
				$i++;

				$detail = array(
								'nokeluar'				=> $nokeluar,
								'keybarang' 			=> $keybarang,
								'qtykeluar' 			=> str_replace(',', '', $qty)
								);

				array_push($arraydetail, $detail);				
			}

			$simpan  = $this->Pemakaianbarang_model->update($arrayhead, $arraydetail, $nokeluar);

		}


		if ($simpan['status'] == 'success') {
			echo json_encode(array('success' => true, 'nokeluar' => $nokeluar));
		}else{
			echo json_encode(array('message' => 'Data gagal disimpan! '.$simpan['message']));						
		}		

	}
	
	public function get_edit_data()
	{
		$nokeluar = $this->input->post('nokeluar');
		$RsData = $this->Pemakaianbarang_model->get_by_id($nokeluar)->row();

		$data = array(
					'nokeluar' 		=>  $RsData->nokeluar,
					'tglkeluar' 	=>  $RsData->tglkeluar,
					'uraian' 			=>  $RsData->uraian
					);
		echo(json_encode($data));
	}

}

/* End of file Pemakaianbarang.php */
/* Location: ./application/controllers/Pemakaianbarang.php */