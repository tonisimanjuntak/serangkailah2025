<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pengaturan extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->is_login();
        $this->load->model('Pengaturan_model');
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

    public function cek_akses()
    {
        if ($this->session->userdata('akseslevel') != '9' || $this->session->userdata('akseslevel') != '9') {
            $pesan = '<div>
                        <div class="alert alert-danger alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                            <strong> Maaf!</strong> Anda tidak dapat mengakses halaman ini!
                        </div>
                    </div>';
            $this->session->set_flashdata('pesan', $pesan);
            redirect('Home');
            exit();
        }
    }

    public function bataspenginputan()
    {
        $this->cek_akses();

        $data['rowpengaturan'] = $this->db->query("select * from pengaturan")->row();
        $data['menu']          = 'bataspenginputan';
        $this->load->view('pengaturan/bataspenginputan', $data);
    }

    public function simpanbataswaktupenginputan()
    {
        $aktifbataspenginputan = $this->input->post('aktifbataspenginputan');
        $tglbataspenginputan   = date('Y-m-d', strtotime($this->input->post('tglbataspenginputan'))) . ' ' . date('H:i', strtotime($this->input->post('timebataspenginputan')));
        $sekolahbisalogin      = $this->input->post('sekolahbisalogin');
        $uptbisalogin          = $this->input->post('uptbisalogin');
        $tahunanggaran         = $this->session->userdata('tahunanggaran');

        if (empty($aktifbataspenginputan)) {$aktifbataspenginputan = 0;}
        if (empty($sekolahbisalogin)) {$sekolahbisalogin = 0;}
        if (empty($uptbisalogin)) {$uptbisalogin = 0;}

        if ($aktifbataspenginputan == '1') {

            $data = array(
                'aktifbataspenginputan' => $aktifbataspenginputan,
                'tglbataspenginputan'   => $tglbataspenginputan,
            );
        } else {
            $data = array(
                'aktifbataspenginputan' => $aktifbataspenginputan,
            );

        }
        $simpan = $this->Pengaturan_model->update($data);

        if ($simpan) {
            $pesan = '<div>
                        <div class="alert alert-success alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                            <strong>Berhasil!</strong> Data berhasil disimpan!
                        </div>
                    </div>';
        } else {
            $eror  = $this->db->error();
            $pesan = '<div>
                        <div class="alert alert-danger alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                            <strong>Gagal!</strong> Data gagal disimpan! <br>
                            Pesan Error : ' . $eror['code'] . ' ' . $eror['message'] . '
                        </div>
                    </div>';
        }

        $this->session->set_flashdata('pesan', $pesan);
        redirect('pengaturan/bataspenginputan');
    }

    public function ttd()
    {
        $rsks = $this->db->query("select * from penandatangan
                    where kdruangan='" . $this->session->userdata('kdruangan') . "' and kdttd='KS'");
        if ($rsks->num_rows() > 0) {
            $idpenandatangan_kepsek = $rsks->row()->idpenandatangan;
        } else {
            $idpenandatangan_kepsek = '';
        }

        $rspb = $this->db->query("select * from penandatangan where kdruangan='" . $this->session->userdata('kdruangan') . "' and kdttd='PB'");
        if ($rspb->num_rows() > 0) {
            $idpenandatangan_pengurusbarang = $rspb->row()->idpenandatangan;
        } else {
            $idpenandatangan_pengurusbarang = '';
        }

        $data['idpenandatangan_kepsek']         = $idpenandatangan_kepsek;
        $data['idpenandatangan_pengurusbarang'] = $idpenandatangan_pengurusbarang;
        $data['rowpengaturan']                  = $this->db->query("select * from pengaturan")->row();
        $data['menu']                           = 'pengaturan';
        $this->load->view('pengaturan/pengaturanttd', $data);
    }

    public function simpanttd()
    {
        $idpenandatangan_kepsek         = $this->input->post('idpenandatangan_kepsek');
        $idpenandatangan_pengurusbarang = $this->input->post('idpenandatangan_pengurusbarang');

        $tahunanggaran = $this->session->userdata('tahunanggaran');

        $this->db->query("update penandatangan set kdttd=NULL where kdruangan='" . $this->session->userdata('kdruangan') . "'");

        if (!empty($idpenandatangan_kepsek)) {
            $this->db->query("update penandatangan set kdttd='KS' where kdruangan='" . $this->session->userdata('kdruangan') . "'
                            and idpenandatangan = '" . $idpenandatangan_kepsek . "'
                ");
        }

        if (!empty($idpenandatangan_pengurusbarang)) {
            $this->db->query("update penandatangan set kdttd='PB' where kdruangan='" . $this->session->userdata('kdruangan') . "'
                            and idpenandatangan = '" . $idpenandatangan_pengurusbarang . "'
                ");
        }
        $pesan = '<div>
                    <div class="alert alert-success alert-dismissable">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                        <strong>Berhasil!</strong> Data berhasil disimpan!
                    </div>
                </div>';

        $this->session->set_flashdata('pesan', $pesan);
        redirect('pengaturan/ttd');

    }

    public function migrasibarang()
    {
        $data['menu'] = 'migrasibarang';
        $this->load->view('pengaturan/migrasibarang', $data);
    }

    public function get_data_barang()
    {
        $kdkelompok    = $this->input->get("kdkelompok");
        $tahunanggaran = $this->session->userdata('tahunanggaran');

        $rsbarang     = $this->db->query("select * from barang where kdkelompok='$kdkelompok' and tahunanggaran='$tahunanggaran' order by kdbarang");
        $resultbarang = array();
        if ($rsbarang->num_rows() > 0) {
            foreach ($rsbarang->result() as $row) {
                array_push($resultbarang, array(
                    'keybarang'  => $row->keybarang,
                    'kdbarang'   => $row->kdbarang,
                    'namabarang' => $row->namabarang,
                ));
            }
        }

        echo json_encode($resultbarang);
    }

    public function progress_migrasi()
    {
        $this->load->model('Barang_model');

        $tahunanggaran   = $this->session->userdata("tahunanggaran");
        $kdruangan       = $this->input->post("kdruangan");
        $keybarangasal   = $this->input->post("keybarangasal");
        $keybarangtujuan = $this->input->post("keybarangtujuan");

        $namabarangasal   = $this->Barang_model->get_by_id($keybarangasal)->row()->namabarang;
        $namabarangtujuan = $this->Barang_model->get_by_id($keybarangtujuan)->row()->namabarang;

        $simpan = $this->Pengaturan_model->progress_migrasi($tahunanggaran, $kdruangan, $keybarangasal, $keybarangtujuan, $namabarangasal, $namabarangtujuan);
        if ($simpan) {
            echo json_encode(array('success' => true));
        } else {
            echo json_encode(array('success' => false));
        }
    }

}

/* End of file Pengaturan.php */
/* Location: ./application/controllers/Pengaturan.php */
