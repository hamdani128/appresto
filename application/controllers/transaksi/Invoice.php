<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * @property CI_DB $db
 * @property CI_Session $session
 * @property M_pesanan $M_pesanan
 * @property CI_Output $output
 * @property CI_Input $input
 * @property CI_Form_validation $form_validation
 * @property CI_Upload $upload
 */
class Invoice extends CI_Controller
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
            'content' => 'pages/transaksi',
        ];
        $this->load->view('layout/index', $data);
    }

    public function get_transaksi()
    {
        date_default_timezone_set('Asia/Jakarta');
        $input = json_decode(file_get_contents("php://input"), true);
        $date_start = $input['date_start'];
        $date_end = $input['date_end'];
        $query = $this->M_pesanan->GetTransaksi($date_start, $date_end);
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($query));
    }

    public function get_detail_transaksi()
    {
        date_default_timezone_set('Asia/Jakarta');
        $input = json_decode(file_get_contents("php://input"), true);
        $no_booking = $input['no_booking'];
        $no_meja = $input['no_meja'];
        $row = $this->db->where("no_order", $no_booking)->where("no_meja", $no_meja)->get("invoice")->row();
        $result = $this->db->where("no_order", $no_booking)->where("no_meja", $no_meja)->get("invoice_detail")->result();
        $data = [
            'transaksi' => $row,
            'detail_transaksi' => $result,
        ];
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($data));
    }

}
