<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Meja extends CI_Controller
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
            'content' => 'pages/meja',
            'meja' => $this->db->get('daftar_meja')->result(),
        ];
        $this->load->view('layout/index', $data);
    }

    public function getdata_meja()
    {
        $query = $this->db->get('daftar_meja')->result();
        echo json_encode($query);
    }

    public function insert_meja()
    {
        date_default_timezone_set('Asia/Jakarta');
        $user_id = $this->session->userdata('user_id');
        $no_meja = $this->input->post('no_meja');
        $nama_meja = $this->input->post('nama_meja');
        $now = date('Y-m-d H:i:s');
        $data = array(
            'no_meja' => $no_meja,
            'nama_meja' => $nama_meja,
            'status' => '0',
            'user_id' => $user_id,
            'created_at' => $now,
            'updated_at' => $now
        );
        $query = $this->db->insert('daftar_meja', $data);
        if ($query) {
            $response = array(
                'status' => 'success',
                'message' => 'Successfully created',
            );
        } else {
            $response = array(
                'status' => 'error',
                'message' => 'Error creating'
            );
        }
        echo json_encode($response);
    }

    public function update_meja()
    {
        date_default_timezone_set('Asia/Jakarta');
        $user_id = $this->session->userdata('user_id');
        $id = $this->input->post('id_update');
        $no_meja = $this->input->post('no_meja_update');
        $nama_meja = $this->input->post('nama_meja_update');
        $now = date('Y-m-d H:i:s');
        $data = array(
            'no_meja' => $no_meja,
            'nama_meja' => $nama_meja,
            'status' => '0',
            'user_id' => $user_id,
            'created_at' => $now,
            'updated_at' => $now
        );
        $query = $this->db->where('id', $id)->update('daftar_meja', $data);
        if ($query) {
            $response = array(
                'status' => 'success',
                'message' => 'Successfully Updated',
            );
        } else {
            $response = array(
                'status' => 'error',
                'message' => 'Error Updated'
            );
        }
        echo json_encode($response);
    }

    public function delete_meja($id)
    {
        $this->db->delete('daftar_meja', array('id' => $id));
        $response = array(
            'status' => 'success',
            'message' => 'Data meja berhasil dihapus'
        );
        // Ubah respon menjadi format JSON dan kirim kembali ke frontend
        header('Content-Type: application/json');
        echo json_encode($response);
    }
}
