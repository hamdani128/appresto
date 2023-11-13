<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Home extends CI_Controller
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
        if ($this->session->userdata('level') == 'Kasir') {
            $view = 'pages/kasir/home';
        } else {
            $view = 'pages/home';
        }
        $data = [
            'content' => $view,
        ];
        $this->load->view('layout/index', $data);
    }
}
