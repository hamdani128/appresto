<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * @property CI_DB $db
 * @property CI_Session $session
 * @property CI_Output $output
 * @property CI_Input $input
 * @property M_home $M_home
 * @property CI_Form_validation $form_validation
 * @property CI_Upload $upload
 */
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
        $this->load->model('M_home');
    }

    public function index()
    {
        if ($this->session->userdata('level') == 'Kasir') {
            $view = 'pages/kasir/home';
        } elseif ($this->session->userdata('level') == 'Mitra') {
            $view = 'pages/mitra/home_mitra';
        } else {
            $view = 'pages/home';
        }
        $data = [
            'content' => $view,
        ];
        $this->load->view('layout/index', $data);
    }

    public function home_kasir_summary()
    {
        date_default_timezone_set('Asia/Jakarta');
        $input = json_decode(file_get_contents('php://input'), true);
        $date_start = $input['date_start'];
        $date_end = $input['date_end'];
        $total_revenue = $this->M_home->GetRevenue($date_start, $date_end);
        $total_visitor = $this->M_home->GetVisitor($date_start, $date_end);
        $total_count_transaksi = $this->M_home->GetCountTransaksi($date_start, $date_end);
        $resultDeskripsi = $this->M_home->getDeskripsiMenuCount($date_start, $date_end);

        $year = date('Y');
        $chart_data = $this->M_home->GetForChart1($year);

        $jumlah_per_bulan = array_fill(1, 12, 0); // isi default 0 dari bulan 1 sampai 12
        foreach ($chart_data as $row) {
            $bulan = (int) $row['bulan'];
            $jumlah_per_bulan[$bulan] = (int) $row['jumlah'];
        }

        $data = [
            'total_revenue' => $total_revenue,
            'total_visitor' => $total_visitor,
            'total_count_transaksi' => $total_count_transaksi,
            'menu_deskripsi' => $resultDeskripsi,
            'visitor_chart' => array_values($jumlah_per_bulan), // kirim array 12 elemen ke JS
        ];
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($data));
    }

    public function mitra_notification()
    {
        $mitra = $this->session->userdata('username');
        $data = [
            'jumlah_notifikasi' => $this->M_home->CountNotifikasiMitra($mitra),
            'rows' => $this->M_home->RowNotifikasiMitra($mitra),
        ];
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($data));
    }

    public function mark_as_read_mitra_notification()
    {
        date_default_timezone_set('Asia/Jakarta');
        $input = json_decode(file_get_contents('php://input'), true);
        $no_order = $input['no_order'];
        $no_meja = $input['no_meja'];
        $owner = $input['owner'];

        $data = [
            'notif' => 0,
            'updated_at' => date('Y-m-d H:i:s'),
            'updated_by' => $this->session->userdata('username'),
        ];
        $query = $this->db->where(['no_order' => $no_order, 'no_meja' => $no_meja, 'owner' => $owner])->update('mitra_order_notif', $data);
        return $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($query));
    }

    public function get_row_orders()
    {
        date_default_timezone_set('Asia/Jakarta');
        $mitra = $this->session->userdata('username');
        $data = $this->M_home->ListDetailPesananByOwner($mitra);
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($data));
    }

    public function get_data_transaksi_mitra()
    {
        date_default_timezone_set('Asia/Jakarta');
        $mitra = $this->session->userdata('username');
        $input = json_decode(file_get_contents('php://input'), true);
        $start_date = $input['start_date'];
        $end_date = $input['end_date'];
        $data = $this->M_home->LoadDataTransaksiMitra($mitra, $start_date, $end_date);
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($data));
    }

    public function home_kasir_summary_mitra()
    {
        date_default_timezone_set('Asia/Jakarta');
        $input = json_decode(file_get_contents('php://input'), true);
        $date_start = $input['date_start'];
        $date_end = $input['date_end'];
        $mitra = $this->session->userdata('username');
        $total_revenue = $this->M_home->GetRevenueMitra($date_start, $date_end, $mitra);
        $total_visitor = $this->M_home->GetVisitorMitra($date_start, $date_end, $mitra);
        $total_count_transaksi = $this->M_home->GetCountTransaksiMitra($date_start, $date_end, $mitra);
        $resultDeskripsi = $this->M_home->getDeskripsiMenuCountMitra($date_start, $date_end, $mitra);
        $year = date('Y');
        $chart_data = $this->M_home->GetForChart1($year);
        $jumlah_per_bulan = array_fill(1, 12, 0); // isi default 0 dari bulan 1 sampai 12
        foreach ($chart_data as $row) {
            $bulan = (int) $row['bulan'];
            $jumlah_per_bulan[$bulan] = (int) $row['jumlah'];
        }

        $data = [
            'total_revenue' => $total_revenue,
            'total_visitor' => $total_visitor,
            'total_count_transaksi' => $total_count_transaksi,
            'menu_deskripsi' => $resultDeskripsi,
            'visitor_chart' => array_values($jumlah_per_bulan), // kirim array 12 elemen ke JS
        ];
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($data));
    }

}
