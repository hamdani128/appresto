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

    }

    public function insert()
    {
        date_default_timezone_set('Asia/Jakarta');
        $input = json_decode(file_get_contents('php://input'), true);

    }
}
