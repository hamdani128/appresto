<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * @property CI_DB $db
 * @property CI_Session $session
 * @property CI_Input $input
 * @property CI_Upload $upload
 * @property CI_Output $output
 */
class Setting extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->helper(['url', 'form']);
        $this->session->sess_expiration      = '60';
        $this->session->sess_expire_on_close = 'true';
        if ($this->session->userdata('log_in') != "login") {
            redirect(base_url("auth/login"));
        }
    }

    public function index()
    {
        $data = [
            'content' => 'pages/setting',
            'setting' => $this->db->get('setting')->row(),
        ];

        $this->load->view('layout/index', $data);
    }

    public function getdata()
    {
        $setting = $this->db->get('setting')->row();

        if (! $setting) {
            $setting = [
                'company' => '',
                'address' => '',
                'logo'    => '',
            ];
        }
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($setting));
    }

    public function save()
    {
        $company = trim((string) $this->input->post('company'));
        $address = trim((string) $this->input->post('address'));

        if ($company === '' || $address === '') {
            $this->session->set_flashdata('setting_status', 'error');
            $this->session->set_flashdata('setting_message', 'Company dan address wajib diisi.');
            redirect(base_url('setting'));
            return;
        }

        $existing = $this->db->get('setting')->row();
        $logoName = $existing ? $existing->logo : null;

        if (isset($_FILES['logo']) && ! empty($_FILES['logo']['name'])) {
            $newName                 = time() . "-" . date('Ymd');
            $config['upload_path']   = './public/upload/';
            $config['allowed_types'] = 'gif|jpg|png|jpeg|svg|webp';
            $config['max_size']      = 4096;
            $config['file_name']     = $newName;

            $this->load->library('upload', $config);

            if (! $this->upload->do_upload('logo')) {
                $this->session->set_flashdata('setting_status', 'error');
                $this->session->set_flashdata('setting_message', strip_tags($this->upload->display_errors()));
                redirect(base_url('setting'));
                return;
            }

            if (! empty($logoName)) {
                $oldPath = FCPATH . 'public/upload/' . $logoName;
                if (is_file($oldPath)) {
                    unlink($oldPath);
                }
            }

            $uploadData = $this->upload->data();
            $logoName   = $uploadData['file_name'];
        }

        $data = [
            'company' => $company,
            'address' => $address,
            'logo'    => $logoName,
        ];

        if ($existing) {
            $query   = $this->db->update('setting', $data);
            $message = $query ? 'Setting berhasil diperbarui.' : 'Gagal memperbarui setting.';
            $status  = $query ? 'success' : 'error';
        } else {
            $query   = $this->db->insert('setting', $data);
            $message = $query ? 'Setting berhasil disimpan.' : 'Gagal menyimpan setting.';
            $status  = $query ? 'success' : 'error';
        }

        $this->session->set_flashdata('setting_status', $status);
        $this->session->set_flashdata('setting_message', $message);
        redirect(base_url('setting'));
    }
}
