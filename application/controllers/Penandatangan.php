<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Penandatangan extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->is_login();
        $this->cek_akses();
        $this->load->model('Penandatangan_model');
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
        if ($this->session->userdata('akseslevel') != '1') {
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

    public function index()
    {
        $data['menu'] = 'penandatangan';
        $this->load->view('penandatangan/listdata', $data);
    }

    public function tambah()
    {
        $data['idpenandatangan'] = "";
        $data['menu']            = 'penandatangan';
        $this->load->view('penandatangan/form', $data);
    }

    public function edit($idpenandatangan)
    {
        $idpenandatangan = $this->encrypt->decode($idpenandatangan);

        if ($this->Penandatangan_model->get_by_id($idpenandatangan)->num_rows() < 1) {
            $pesan = '<div>
						<div class="alert alert-danger alert-dismissable">
			                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
			                <strong>Ilegal!</strong> Data tidak ditemukan!
					    </div>
					</div>';
            $this->session->set_flashdata('pesan', $pesan);
            redirect('penandatangan');
            exit();
        };
        $data['idpenandatangan'] = $idpenandatangan;
        $data['menu']            = 'penandatangan';
        $this->load->view('penandatangan/form', $data);
    }

    public function datatablesource()
    {
        $RsData = $this->Penandatangan_model->get_datatables();
        $no     = $_POST['start'];
        $data   = array();

        if ($RsData->num_rows() > 0) {
            foreach ($RsData->result() as $rowdata) {
                $no++;
                $row   = array();
                $row[] = $no;
                $row[] = htmlentities($rowdata->nip);
                $row[] = htmlentities($rowdata->namapenandatangan);
                $row[] = htmlentities($rowdata->jabatan);
                $row[] = htmlentities($rowdata->golongan);
                $row[] = htmlentities($rowdata->namaruangan);
                if ($rowdata->statusaktif == '1') {
                    $row[] = '<span class="badge badge-success">' . $rowdata->statusaktif2 . '</span>';
                } else {
                    $row[] = '<span class="badge badge-danger">' . $rowdata->statusaktif2 . '</span>';
                }
                $row[] = '<a href="' . site_url('penandatangan/edit/' . $this->encrypt->encode($rowdata->idpenandatangan)) . '" class="btn btn-sm btn-warning btn-circle"><i class="fa fa-edit"></i></a> |
	            		<a href="' . site_url('penandatangan/delete/' . $this->encrypt->encode($rowdata->idpenandatangan)) . '" class="btn btn-sm btn-danger btn-circle" id="hapus"><i class="fa fa-trash"></i></a>';
                $data[] = $row;
            }
        }

        $output = array(
            "draw"            => $_POST['draw'],
            "recordsTotal"    => $this->Penandatangan_model->count_all(),
            "recordsFiltered" => $this->Penandatangan_model->count_filtered(),
            "data"            => $data,
        );

        //output to json format
        echo json_encode($output);
    }

    public function delete($id)
    {
        $id = $this->encrypt->decode($id);

        if ($this->Penandatangan_model->get_by_id($id)->num_rows() < 1) {
            $pesan = '<div>
						<div class="alert alert-danger alert-dismissable">
			                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
			                <strong>Ilegal!</strong> Data tidak ditemukan!
					    </div>
					</div>';
            $this->session->set_flashdata('pesan', $pesan);
            redirect('penandatangan');
            exit();
        };

        $hapus = $this->Penandatangan_model->hapus($id);
        if ($hapus) {
            $pesan = '<div>
						<div class="alert alert-success alert-dismissable">
			                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
			                <strong>Berhasil!</strong> Data berhasil dihapus!
					    </div>
					</div>';
        } else {
            $eror  = $this->db->error();
            $pesan = '<div>
						<div class="alert alert-danger alert-dismissable">
			                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
			                <strong>Gagal!</strong> Data gagal dihapus karena sudah digunakan! <br>
					    </div>
					</div>';
        }

        $this->session->set_flashdata('pesan', $pesan);
        redirect('penandatangan');

    }

    public function simpan()
    {
        $idpenandatangan   = $this->input->post('idpenandatangan');
        $nip               = htmlspecialchars($this->input->post('nip'));
        $namapenandatangan = htmlspecialchars($this->input->post('namapenandatangan'));
        $idstruktur        = $this->input->post('idstruktur');
        $jabatan           = htmlspecialchars($this->input->post('jabatan'));
        $golongan          = htmlspecialchars($this->input->post('golongan'));
        $statusaktif       = $this->input->post('statusaktif');
        $kdruangan         = $this->session->userdata('kdruangan');

        if (empty($kdruangan)) {
            $pesan = '<div>
						<div class="alert alert-danger alert-dismissable">
			                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
			                <strong>Upps!</strong> Anda tidak berhak menambah penandatangan!
					    </div>
					</div>';
            $this->session->set_flashdata('pesan', $pesan);
            redirect('penandatangan');
        }

        if ($idpenandatangan == '') {
            // data baru
            $idpenandatangan = $this->db->query("select create_idpenandatangan('" . date('Y-m-d') . "') as idpenandatangan")->row()->idpenandatangan;

            $data = array(
                'idpenandatangan'   => $idpenandatangan,
                'nip'               => $nip,
                'namapenandatangan' => $namapenandatangan,
                'idstruktur'        => $idstruktur,
                'jabatan'           => $jabatan,
                'golongan'          => $golongan,
                'kdruangan'         => $kdruangan,
                'statusaktif'       => $statusaktif,
                'lastupdate'    => date('Y-m-d H:i:s'),
                'idpengguna'    => $this->session->userdata('idpengguna'),
            );

            // var_dump($data);
            // exit();

            $simpan = $this->Penandatangan_model->simpan($data);
        } else {

            $data = array(
                'idpenandatangan'   => $idpenandatangan,
                'nip'               => $nip,
                'namapenandatangan' => $namapenandatangan,
                'idstruktur'        => $idstruktur,
                'jabatan'           => $jabatan,
                'golongan'          => $golongan,
                'kdruangan'         => $kdruangan,
                'statusaktif'       => $statusaktif,
                'lastupdate'    => date('Y-m-d H:i:s'),
                'idpengguna'    => $this->session->userdata('idpengguna'),
            );

            $simpan = $this->Penandatangan_model->update($data, $idpenandatangan);
        }

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
        redirect('penandatangan');
    }

    public function get_edit_data()
    {
        $idpenandatangan = $this->input->post('idpenandatangan');
        $RsData          = $this->Penandatangan_model->get_by_id($idpenandatangan)->row();

        $data = array(
            'idpenandatangan'   => $RsData->idpenandatangan,
            'nip'               => $RsData->nip,
            'namapenandatangan' => $RsData->namapenandatangan,
            'idstruktur'        => $RsData->idstruktur,
            'jabatan'           => $RsData->jabatan,
            'golongan'          => $RsData->golongan,
            'kdruangan'         => $RsData->kdruangan,
            'statusaktif'       => $RsData->statusaktif,
        );
        echo (json_encode($data));
    }

}

/* End of file Penandatangan.php */
/* Location: ./application/controllers/Penandatangan.php */
