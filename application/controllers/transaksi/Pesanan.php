<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pesanan extends CI_Controller
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
        $this->load->model("M_pesanan");
    }

    public function index()
    {
        $data = [
            'content' => 'pages/kasir/kasir'
        ];
        $this->load->view('layout/index', $data);
    }
}
