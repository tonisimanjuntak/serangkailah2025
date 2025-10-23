<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Saldoawal extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->is_login();
        $this->cekbataswaktupenginputan();
        $this->load->model('Saldoawal_model');
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
            if (date('Y-m-d H:i', strtotime($rowpengaturan->tglbataspenginputan)) <= date('Y-m-d H:i')) {
                redirect(site_url());
                exit();
            }
        }

    }

    public function index()
    {
        $kdruangan     = $this->session->userdata('kdruangan');
        $tahunanggaran = $this->session->userdata('tahunanggaran');

        $rsSaldoAwal = $this->db->query("
			select * from v_saldoawal where kdruangan='$kdruangan' and tahunanggaran='$tahunanggaran'
		");

        if ($rsSaldoAwal->num_rows() > 1) {
            $pesan = '<div>
						<div class="alert alert-danger alert-dismissable">
			                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
			                <strong>Upss!</strong> Terjadi kesalahan saldo awal, hubungi administrator!
					    </div>
					</div>';
            $this->session->set_flashdata('pesan', $pesan);
            redirect(site_url());
            exit();
        }

        if ($rsSaldoAwal->num_rows() == 0) {
            $noterima = '';
        } else {
            $noterima = $rsSaldoAwal->row()->noterima;
        }

        $tglsaldoawal         = date('Y-m-d', strtotime($tahunanggaran . '-01-01'));
        $data['noterima']     = $noterima;
        $data['tglsaldoawal'] = $tglsaldoawal;
        $data['menu']         = 'saldoawal';
        $this->load->view('saldoawal/form', $data);
    }

    public function datatablesourcedetail()
    {
        // query ini untuk item yang dimunculkan sesuai dengan kategori yang dipilih

        $noterima = $this->input->post('noterima');
        $query    = "select * from v_saldoawaldetail
						WHERE v_saldoawaldetail.noterima='" . $noterima . "' order by keybarang";

        $RsData = $this->db->query($query);

        $no   = 0;
        $data = array();

        if ($RsData->num_rows() > 0) {
            foreach ($RsData->result() as $rowdata) {
                $no++;
                $row    = array();
                $row[]  = $no;
                $row[]  = $rowdata->keybarang;
                $row[]  = $rowdata->kdbarang;
                $row[]  = $rowdata->namabarang;
                $row[]  = $rowdata->satuan;
                $row[]  = number_format($rowdata->hargabelisatuan);
                $row[]  = number_format($rowdata->qtyterima);
                $row[]  = number_format($rowdata->qtyterima * $rowdata->hargabelisatuan);
                $row[]  = '<span class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></span>';
                $data[] = $row;
            }
        }

        $output = array(
            "data" => $data,
        );

        //output to json format
        echo json_encode($output);
    }

    public function simpan()
    {
        $noterima        = $this->input->post('noterima');
        $tglterima       = date('Y-m-d', strtotime($this->input->post('tglterima')));
        $uraian          = htmlspecialchars($this->input->post('uraian'));
        $total           = str_replace(',', '', $this->input->post('total'));
        $isidatatable    = $_REQUEST['isidatatable'];
        $idpengguna      = $this->session->userdata('idpengguna');
        $tahunanggaran   = $this->session->userdata('tahunanggaran');
        $tglupdate       = date('Y-m-d H:i:s');
        $kdruangan       = $this->session->userdata('kdruangan');
        $jenispenerimaan = 'Saldo Awal';

        //jika session berakhir
        if (empty($idpengguna)) {
            echo json_encode(array('msg' => "Session telah berakhir, Silahkan refresh halaman!"));
            exit();
        }

        if (date('Y', strtotime($tglterima)) != $tahunanggaran) {
            echo json_encode(array('msg' => 'Tanggal transaksi tidak sama dengan tahun anggaran '));
            exit();
        }

        if ($noterima == '') {

            $rsSaldoAwal = $this->db->query("
				select * from v_saldoawal where kdruangan='$kdruangan' and tahunanggaran='$tahunanggaran'
			");

            if ($rsSaldoAwal->num_rows() > 1) {
                $pesan = '<div>
							<div class="alert alert-danger alert-dismissable">
				                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
				                <strong>Upss!</strong> Terjadi kesalahan, Coba ulangi kembali input saldo awal!
						    </div>
						</div>';
                $this->session->set_flashdata('pesan', $pesan);
                redirect(site_url());
                exit();
            }

            $noterima = $this->db->query("select create_noterima('" . date('Y-m-d') . "') as noterima")->row()->noterima;

            // echo json_encode(array('msg'=>$isidatatable));
            // exit();
            $arrayhead = array(
                'noterima'        => $noterima,
                'tglterima'       => $tglterima,
                'uraian'          => $uraian,
                'tahunanggaran'   => $tahunanggaran,
                'kdruangan'       => $kdruangan,
                'jenispenerimaan' => $jenispenerimaan,
                'tglinsert'       => $tglupdate,
                'tglupdate'       => $tglupdate,
                'idpengguna'      => $idpengguna,
                'totalbeli'       => $total,
            );

            //-------------------------------- >> simpan dari datatable
            $i           = 0;
            $arraydetail = array();
            foreach ($isidatatable as $item) {
                $keybarang       = $item[1];
                $hargabelisatuan = $item[5];
                $qty             = $item[6];
                $i++;

                $detail = array(
                    'noterima'        => $noterima,
                    'keybarang'       => $keybarang,
                    'qtyterima'       => str_replace(',', '', $qty),
                    'hargabelisatuan' => str_replace(',', '', $hargabelisatuan),
                    'stokbarang'      => str_replace(',', '', $qty),
                );

                array_push($arraydetail, $detail);
            }

            $simpan = $this->Saldoawal_model->simpan($arrayhead, $arraydetail, $noterima);
        } else {

            $arrayhead = array(
                'noterima'      => $noterima,
                'tglterima'     => $tglterima,
                'uraian'        => $uraian,
                'tahunanggaran' => $tahunanggaran,
                'tglupdate'     => $tglupdate,
                'idpengguna'    => $idpengguna,
                'totalbeli'     => $total,
            );

            //-------------------------------- >> simpan dari datatable
            $i           = 0;
            $arraydetail = array();
            foreach ($isidatatable as $item) {
                $keybarang       = $item[1];
                $hargabelisatuan = $item[5];
                $qty             = $item[6];
                $i++;

                $detail = array(
                    'noterima'        => $noterima,
                    'keybarang'       => $keybarang,
                    'qtyterima'       => str_replace(',', '', $qty),
                    'hargabelisatuan' => str_replace(',', '', $hargabelisatuan),
                    'stokbarang'      => str_replace(',', '', $qty),
                );

                array_push($arraydetail, $detail);
            }

            $simpan = $this->Saldoawal_model->update($arrayhead, $arraydetail, $noterima);

        }

        if (!$simpan) {
            //jika gagal
            $eror = $this->db->error();
            echo json_encode(array('msg' => 'Kode Eror: ' . $eror['code'] . ' ' . $eror['message']));
            exit();
        }

        // jika berhasil akan sampai ke tahap ini
        echo json_encode(array('success' => true, 'noterima' => $noterima));
    }

    public function delete()
    {
        $hapus = $this->Saldoawal_model->hapus();
        if ($hapus['status'] == 'success') {
			echo json_encode(array('success' => true));
		}else{
			echo json_encode(array('message' => 'Data gagal dihapus! '.$hapus['message']));
		}

    }

    public function get_edit_data()
    {
        $noterima = $this->input->post('noterima');
        $RsData   = $this->Saldoawal_model->get_by_id($noterima)->row();

        $data = array(
            'noterima'  => $RsData->noterima,
            'tglterima' => $RsData->tglterima,
            'uraian'    => $RsData->uraian,
        );
        echo (json_encode($data));
    }

}

/* End of file Saldoawal.php */
/* Location: ./application/controllers/Saldoawal.php */
