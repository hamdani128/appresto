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
        $this->session->sess_expiration      = '60';
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
        $input      = json_decode(file_get_contents("php://input"), true);
        $date_start = $input['date_start'];
        $date_end   = $input['date_end'];
        $type       = $input['type'];
        $query1     = $this->M_pesanan->GetTransaksi($date_start, $date_end, $type);
        $query2     = $this->M_pesanan->GetPeriodeSaldoAwal($date_start, $date_end);
        $query3     = $this->M_pesanan->GetPeriodePengeluaran($date_start, $date_end);
        $data       = [
            'transaksi'   => $query1,
            'saldo_awal'  => $query2,
            'pengeluaran' => $query3,
        ];

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($data));
    }

    public function get_detail_transaksi()
    {
        date_default_timezone_set('Asia/Jakarta');
        $input        = json_decode(file_get_contents("php://input"), true);
        $no_booking   = $input['no_booking'];
        $no_meja      = $input['no_meja'];
        $no_transaksi = $input['no_transaksi'];
        $no_split     = $input['no_split'];

        if ($no_split != null) {

            $row = $this->db
                ->select('invoice.*, users.id as user_id, users.fullname')
                ->join('users', 'users.username = invoice.created_by', 'left')
                ->where("no_order", $no_booking)
                ->where("no_meja", $no_meja)
                ->where("no_split", $no_split)
                ->get("invoice")
                ->row();

            $result = $this->db
                ->where("no_order", $no_booking)
                ->where("no_meja", $no_meja)
                ->where("no_split", $no_split)
                ->get("invoice_detail")
                ->result();

        } else {
            $row = $this->db
                ->select('invoice.*, users.id as user_id, users.fullname')
                ->join('users', 'users.username = invoice.created_by', 'left')
                ->where("no_transaksi", $no_transaksi)
                ->where("no_split", null)
                ->get("invoice")
                ->row();

            $result = $this->db
                ->where("no_meja", $no_meja)
                ->where("no_transaksi", $no_transaksi)
                ->where("no_split IS NULL", null, false)
                ->where("qty >", 0)
                ->get("invoice_detail")
                ->result();
        }

        $data = [
            'transaksi'        => $row,
            'detail_transaksi' => $result,
        ];

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($data));
    }

    public function get_detail_transaksi_by_owner()
    {
        date_default_timezone_set('Asia/Jakarta');
        $input        = json_decode(file_get_contents("php://input"), true);
        $type         = $input['type'];
        $no_transaksi = $input['no_transaksi'];
        if ($type == "All") {
            $result = $this->db->where("no_transaksi", $no_transaksi)
                ->get("invoice_detail")->result();
        } elseif ($type == "Owner") {
            $result = $this->db->where("no_transaksi", $no_transaksi)
                ->where("owner", "Owner")
                ->get("invoice_detail")->result();
        } else {
            $result = $this->db->where("no_transaksi", $no_transaksi)
                ->where("owner", $type)
                ->get("invoice_detail")->result();
        }
        $data = $result;
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($data));
    }

    public function get_transaksi_periode()
    {
        date_default_timezone_set('Asia/Jakarta');
        $input      = json_decode(file_get_contents("php://input"), true);
        $date_start = $input['date_start'];
        $date_end   = $input['date_end'];
        $query      = $this->M_pesanan->GetPeriodeTransaksi($date_start, $date_end);
        $data       = [
            'kasir'  => $this->session->userdata('username') . '-' . $this->session->userdata('fullname'),
            'detail' => $query,
        ];
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($data));
    }

    public function get_transaksi_periode_summary()
    {
        date_default_timezone_set('Asia/Jakarta');
        $input            = json_decode(file_get_contents("php://input"), true);
        $date_start       = $input['date_start'];
        $date_end         = $input['date_end'];
        $metode_transaksi = $this->M_pesanan->SummaryMetodeTransaksi($date_start, $date_end);
        $saldo_awal       = $this->M_pesanan->SummarySaldoAwal($date_start, $date_end);
        $pengeluaran      = $this->M_pesanan->SummaryPengeluaran($date_start, $date_end);
        $detail           = $this->M_pesanan->GetPeriodeTransaksi($date_start, $date_end);
        $data             = [
            'metode'      => $metode_transaksi,
            'saldo_awal'  => $saldo_awal,
            'pengeluaran' => $pengeluaran,
            'detail'      => $detail,
        ];
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($data));
    }

}
