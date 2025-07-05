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
class Minuman extends CI_Controller
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
            'content' => 'pages/minuman',
        ];
        $this->load->view('layout/index', $data);
    }

    public function get_kategori_minuman()
    {
        $query = $this->db->get("kategori_minuman")->result();
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($query));
    }

    public function insert_kategori_minuman()
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
        $query = $this->db->insert("kategori_minuman", $data);
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($query));
    }

    public function delete_kategori_minuman($id)
    {
        $query = $this->db->where('id', $id)->delete("kategori_minuman");
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($query));
    }

    public function insert_minuman()
    {
        date_default_timezone_set('Asia/Jakarta');
        $now = date('Y-m-d H:i:s');
        $jenis_id = $this->input->post('cmb_kategori');
        $nama = $this->input->post('nama');
        $harga = $this->input->post('harga');
        $owner = $this->input->post('cmb_owner');
        $userid = $this->session->userdata('user_id');
        $file_image = $_FILES["file_img"];
        if ($file_image["error"] == 4) {
            // Jika tidak ada file diunggah
            $data = array(
                'kategori_id' => $jenis_id,
                'nama' => $nama,
                'harga' => $harga,
                'owner' => $owner,
                'user_id' => $userid,
                'created_at' => $now,
                'updated_at' => $now,
            );
            $query = $this->db->insert("minuman", $data);

            if ($query) {
                $response = array(
                    'status' => 'success',
                    'message' => 'Success Created !',
                );
            } else {
                $response = array(
                    'status' => 'error',
                    'message' => 'Failed to insert data',
                );
            }
        } else {
            // Jika ada file diunggah
            $new_name = time() . "-" . date('Ymd');
            $config['upload_path'] = './public/upload/';
            $config['allowed_types'] = 'gif|jpg|png|jpeg';
            $config['max_size'] = 2048;
            $config['file_name'] = $new_name;

            $this->load->library('upload', $config);

            if (!$this->upload->do_upload('file_img')) {
                $response = array(
                    'status' => 'img_error',
                    'message' => $this->upload->display_errors() . " Upload failed",
                );
            } else {
                $dataupload = array('upload_data' => $this->upload->data());
                $data = array(
                    'img' => $dataupload['upload_data']['file_name'],
                    'kategori_id' => $jenis_id,
                    'nama' => $nama,
                    'harga' => $harga,
                    'owner' => $owner,
                    'user_id' => $userid,
                    'created_at' => $now,
                    'updated_at' => $now,
                );
                $query = $this->db->insert("minuman", $data);

                if ($query) {
                    $response = array(
                        'status' => 'success',
                        'message' => 'Success Created !',
                    );
                } else {
                    $response = array(
                        'status' => 'error',
                        'message' => 'Failed to insert data',
                    );
                }
            }
        }

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($response));
    }

    public function data_minuman()
    {
        if ($this->session->userdata('level') == 'Super Admin' && $this->session->userdata('level') == 'Kasir') {
            $SQL = "SELECT
                a.id AS id,
                b.id AS kategori_id,
                b.kategori AS kategori,
                a.nama AS nama,
                a.harga AS harga,
                a.img AS img,
                a.owner AS owner,
                IF(c.nama IS NULL, 'Owner', c.nama) AS 'name_owner',
                a.status AS status
            FROM minuman a
            LEFT JOIN kategori_minuman b ON a.kategori_id = b.id
            LEFT JOIN mitra c ON a.owner = c.kode";
        } elseif ($this->session->userdata('level') == 'Mitra') {
            $SQL = "SELECT
                a.id AS id,
                b.id AS kategori_id,
                b.kategori AS kategori,
                a.nama AS nama,
                a.harga AS harga,
                a.img AS img,
                a.owner AS owner,
                IF(c.nama IS NULL, 'Owner', c.nama) AS 'name_owner',
                a.status AS status
            FROM minuman a
            LEFT JOIN kategori_minuman b ON a.kategori_id = b.id
            LEFT JOIN mitra c ON a.owner = c.kode
            WHERE a.owner = '" . $this->session->userdata('username') . "'
            ";
        }

        $query = $this->db->query($SQL)->result();
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($query));
    }

    public function update_minuman()
    {
        date_default_timezone_set('Asia/Jakarta');
        $now = date('Y-m-d H:i:s');
        $id = $this->input->post('id_update');
        $kategori_makanan = $this->input->post('cmb_kategori_update');
        $nama = $this->input->post('nama_update');
        $harga = $this->input->post('harga_update');
        $owner = $this->input->post('cmb_owner_update');
        $userid = $this->session->userdata('user_id');
        $file_image = $_FILES["file_img_update"];
        if ($file_image["error"] == 4) {
            $data = array(
                'kategori_id' => $kategori_makanan,
                'nama' => $nama,
                'harga' => $harga,
                'owner' => $owner,
                'status' => 1,
                'user_id' => $userid,
                'updated_at' => $now,
            );
            $query = $this->db->where('id', $id)->update("minuman", $data);
            if ($query) {
                $response = array(
                    'status' => 'success',
                    'message' => 'Success Updated !',
                );
            }
        } else {
            $file_name = $this->db->where('id', $id)->get('minuman')->row()->img;
            if (empty($file_name)) {
            } else {
                $path = './public/upload/' . $file_name;
                unlink($path);
            }
            $new_name = time() . "-" . date('Ymd');
            $config['upload_path'] = './public/upload/';
            $config['allowed_types'] = 'gif|jpg|png|jpeg';
            $config['max_size'] = 2048;
            $config['file_name'] = $new_name;

            $this->load->library('upload', $config);

            if (!$this->upload->do_upload('file_img_update')) {
                $response = array(
                    'status' => 'img_error',
                    'message' => $this->upload->display_errors() . " Upload failed",
                );
            } else {
                $dataupload = array('upload_data' => $this->upload->data());
                $data = array(
                    'img' => $dataupload['upload_data']['file_name'],
                    'kategori_id' => $kategori_makanan,
                    'nama' => $nama,
                    'harga' => $harga,
                    'owner' => $owner,
                    'status' => 1,
                    'user_id' => $userid,
                    'created_at' => $now,
                    'updated_at' => $now,
                );
                $query = $this->db->where('id', $id)->update("minuman", $data);

                if ($query) {
                    $response = array(
                        'status' => 'success',
                        'message' => 'Success Created !',
                    );
                } else {
                    $response = array(
                        'status' => 'error',
                        'message' => 'Failed to insert data',
                    );
                }
            }
        }
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($response));
    }
}