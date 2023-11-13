<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Makanan extends CI_Controller
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
            'content' => 'pages/makanan'
        ];
        $this->load->view('layout/index', $data);
    }

    public function get_kategori_makanan()
    {
        $query = $this->db->get("kategori_makanan")->result();
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($query));
    }

    public function insert_kategori_makanan()
    {
        date_default_timezone_set('Asia/Jakarta');
        $now = date('Y-m-d H:i:s');
        $json = file_get_contents('php://input');
        $input = json_decode($json, true);
        $kategori = $input["kategori"];
        $userid = $this->session->userdata('user_id');
        $data = array(
            'kategori' => $kategori,
            'user_id' => $userid,
            'created_at' => $now,
            'updated_at' => $now,
        );
        $query = $this->db->insert("kategori_makanan", $data);
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($query));
    }

    public function delete_kategori_makanan($id)
    {
        $query = $this->db->where('id', $id)->delete("kategori_makanan");
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($query));
    }

    public function insert_makanan()
    {
        date_default_timezone_set('Asia/Jakarta');
        $now = date('Y-m-d H:i:s');
        $jenis_id = $this->input->post('cmb_kategori');
        $nama = $this->input->post('nama');
        $harga = $this->input->post('harga');
        $owner = $this->input->post('cmb_owner');
        $userid = $this->session->userdata('user_id');

        $data = array(
            'kategori_id' => $jenis_id,
            'nama' => $nama,
            'harga' => $harga,
            'owner' => $owner,
            'user_id' => $userid,
            'created_at' => $now,
            'updated_at' => $now
        );
        $query = $this->db->insert("makanan", $data);
        if ($query) {
            $response = array(
                'status' => 'success',
                'message' => 'Success Created !'
            );
        }
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($response));
    }

    public function data_makanan()
    {
        $SQL = "SELECT
                a.id as id,
                b.id as kategori_id,
                b.kategori as kategori,
                a.nama as nama,
                a.harga as harga,
                a.owner as owner
                FROM makanan a
                LEFT JOIN kategori_makanan b ON a.kategori_id = b.id";
        $query = $this->db->query($SQL)->result();
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($query));
    }

    public function update_makanan()
    {
        date_default_timezone_set('Asia/Jakarta');
        $now = date('Y-m-d H:i:s');
        $id = $this->input->post('id_update');
        $kategori_makanan = $this->input->post('cmb_kategori_update');
        $nama = $this->input->post('nama_update');
        $harga = $this->input->post('harga_update');
        $owner = $this->input->post('cmb_owner_update');
        $userid = $this->session->userdata('user_id');
        $data = array(
            'kategori_id' => $kategori_makanan,
            'nama' => $nama,
            'harga' => $harga,
            'owner' => $owner,
            'user_id' => $userid,
            'updated_at' => $now
        );
        $query = $this->db->where('id', $id)->update("makanan", $data);
        if ($query) {
            $response = array(
                'status' => 'success',
                'message' => 'Success Updated !'
            );
        }
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($response));
    }
}
