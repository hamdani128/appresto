<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Sdm extends CI_Controller
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
            'content' => 'pages/sdm'
        ];
        $this->load->view('layout/index', $data);
    }

    public function getkode_sdm()
    {
        $cd = $this->db->query("SELECT MAX(RIGHT(kd_sdm,3)) AS kd_max FROM sdm");
        $kd = "";
        if ($cd->num_rows() > 0) {
            foreach ($cd->result() as $k) {
                $tmp = ((int)$k->kd_max) + 1;
                $kd = sprintf("%03s", $tmp);
            }
        } else {
            $kd = "001";
        }
        date_default_timezone_set('Asia/Jakarta');
        $newDate = date('ymd', strtotime(date('Y-m-d')));
        $kodesdm = "SDM" . "-"  . $kd;
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($kodesdm));
    }

    public function getdata_sdm()
    {
        $query = $this->db->get("sdm")->result();
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($query));
    }

    public function insert_sdm()
    {
        date_default_timezone_set('Asia/Jakarta');
        $kode = $this->input->post("kode");
        $nama = $this->input->post("nama");
        $jk = $this->input->post("cmb_jk");
        $jabatan = $this->input->post("cmb_jabatan");
        $user_id = $this->session->userdata('user_id');
        $data = [
            'kd_sdm' => $kode,
            'nama' => $nama,
            'jk' => $jk,
            'jabatan' => $jabatan,
            'user_id' => $user_id,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ];

        $query = $this->db->insert("sdm", $data);

        if ($query) {
            $response = [
                'status' => 'success',
                'message' => 'Successfully created'
            ];
        } else {
            $response = [
                'status' => 'error',
                'message' => 'Error creating'
            ];
        }
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($response));
    }

    public function aktivasi()
    {
        date_default_timezone_set('Asia/Jakarta');
        $payload = json_decode(file_get_contents('php://input'), true);
        $kd_sdm = $payload['kd_sdm'];
        $fullname = $payload['nama'];
        $jabatan = $payload['jabatan'];

        $data1 = [
            'fullname' => $fullname,
            'username' => $kd_sdm,
            'email' => '-',
            'password' => md5("admin"),
            'level' => $jabatan,
            'inititated' => $jabatan,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ];

        $data2 = [
            'status' => 'active',
            'updated_at' => date('Y-m-d H:i:s'),
        ];

        $query1 = $this->db->insert("users", $data1);
        $uqery2 = $this->db->where('kd_sdm', $kd_sdm)->update('sdm', $data2);

        if ($query1 && $uqery2) {
            $response = [
                'status' => 'success',
                'message' => 'Success Processing'
            ];
        } else {
            $response = [
                'status' => 'error',
                'message' => 'Error Processing',
            ];
        }
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($response));
    }
}