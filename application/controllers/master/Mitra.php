<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * @property CI_DB $db
 * @property CI_Session $session
 * @property CI_Output $output
 * @property CI_Input $input
 * @property CI_Form_validation $form_validation
 * @property CI_Upload $upload
 */

class Mitra extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->helper("url");
        $this->session->sess_expiration = '60';
        $this->session->sess_expire_on_close = 'true';
        if ($this->session->userdata('log_in') != "login") {
            redirect(base_url("auth/login"));
        }
    }

    public function index()
    {
        $data = [
            'content' => 'pages/mitra',
        ];
        $this->load->view('layout/index', $data);
    }

    public function getdata()
    {
        date_default_timezone_set('Asia/Jakarta');
        $data = $this->db->get("mitra")->result();
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($data));
    }

    public function kodemitra()
    {
        $SQL = "SELECT MAX(RIGHT(kode, 4)) as KD_MAX FROM mitra";
        $query = $this->db->query($SQL);
        if ($query->num_rows() > 0) {
            $row = $query->row();
            $n = ((int) $row->KD_MAX) + 1;
            $no = sprintf("%04s", $n);
        } else {
            $no = "0001";
        }
        $kode = "MT" . date('ymd') . $no;
        return $kode;
    }

    public function insert()
    {
        date_default_timezone_set('Asia/Jakarta');
        $input = json_decode(file_get_contents('php://input'), true);
        $data = [
            'kode' => $this->kodemitra(),
            'nama' => $input['nama'],
            'email' => $input['email'],
            'hp' => $input['hp'],
            'alamat' => $input['alamat'],
            'status_account' => 0,
            'created_at' => date('Y-m-d H:i:s'),
            'created_by' => $this->session->userdata('username'),
        ];
        $query1 = $this->db->insert('mitra', $data);
        if ($query1) {
            $response = [
                'status' => "success",
                'message' => "Data berhasil disimpan",
            ];
        } else {
            $response = [
                'status' => "error",
                'message' => "Data gagal disimpan",
            ];
        }
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($response));
    }

    public function activate()
    {
        date_default_timezone_set('Asia/Jakarta');
        $input = json_decode(file_get_contents('php://input'), true);
        $data = [
            'status_account' => 1,
            'updated_at' => date('Y-m-d H:i:s'),
            'updated_by' => $this->session->userdata('username'),
        ];
        $row = $this->db->where('kode', $input['kode'])->get('mitra')->row();
        $data2 = [
            'fullname' => $row->nama,
            'username' => $row->kode,
            'email' => $row->email,
            'password' => md5($row->kode),
            'level' => 'Mitra',
            'inititated' => 'Mitra',
            'created_at' => date('Y-m-d H:i:s'),
        ];
        $query1 = $this->db->where('kode', $input['kode'])->update('mitra', $data);
        $query2 = $this->db->insert('users', $data2);
        if ($query1 && $query2) {
            $response = [
                'status' => "success",
                'message' => "Data berhasil diaktifkan",
            ];
        } else {
            $response = [
                'status' => "error",
                'message' => "Data gagal diaktifkan",
            ];

        }
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($response));
    }

    public function deactivate()
    {
        date_default_timezone_set('Asia/Jakarta');
        $input = json_decode(file_get_contents('php://input'), true);
        $data = [
            'status_account' => 0,
            'updated_at' => date('Y-m-d H:i:s'),
            'updated_by' => $this->session->userdata('username'),
        ];
        $query1 = $this->db->where('kode', $input['kode'])->update('mitra', $data);
        $query2 = $this->db->where('username', $input['kode'])->delete('users');
        if ($query1 && $query2) {
            $response = [
                'status' => "success",
                'message' => "Data berhasil dinonaktifkan",
            ];
        } else {
            $response = [
                'status' => "error",
                'message' => "Data gagal dinonaktifkan",
            ];
        }
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($response));
    }

    public function update()
    {
        date_default_timezone_set('Asia/Jakarta');
        $input = json_decode(file_get_contents('php://input'), true);
        $data = [
            'kode' => $input['kode'],
            'nama' => $input['nama'],
            'email' => $input['email'],
            'hp' => $input['hp'],
            'alamat' => $input['alamat'],
            'updated_at' => date('Y-m-d H:i:s'),
            'updated_by' => $this->session->userdata('username'),
        ];
        $query1 = $this->db->where('id', $input['id'])->update('mitra', $data);
        if ($query1) {
            $response = [
                'status' => "success",
                'message' => "Data berhasil diubah",
            ];
        } else {
            $response = [
                'status' => "error",
                'message' => "Data gagal diubah",
            ];
        }
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($response));
    }

    public function delete()
    {
        date_default_timezone_set('Asia/Jakarta');
        $input = json_decode(file_get_contents('php://input'), true);
        $query1 = $this->db->where('id', $input['id'])->delete('mitra');
        if ($query1) {
            $response = [
                'status' => "success",
                'message' => "Data berhasil dihapus",
            ];
        } else {
            $response = [
                'status' => "error",
                'message' => "Data gagal dihapus",
            ];
        }
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($response));
    }
}
