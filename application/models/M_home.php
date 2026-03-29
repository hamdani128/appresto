<?php
class M_home extends CI_Model
{
    private function getTakeawayCondition($alias = '')
    {
        $prefix = $alias !== '' ? $alias . '.' : '';

        return "(LOWER(COALESCE({$prefix}no_meja, '')) = 'takeaway'
            OR LOWER(COALESCE({$prefix}metode_service, '')) = 'takeaway'
            OR COALESCE({$prefix}no_transaksi, '') LIKE 'TKI%'
            OR COALESCE({$prefix}no_order, '') LIKE 'TAK%')";
    }

    public function GetRevenue($date_start, $date_end)
    {
        date_default_timezone_set('Asia/Jakarta');
        $this->db->select('SUM(amount_total) as total_revenue');
        $this->db->from('invoice');
        $this->db->where('tanggal >=', $date_start);
        $this->db->where('tanggal <=', $date_end);
        $query = $this->db->get();
        return $query->row()->total_revenue;
    }

    public function GetVisitor($date_start, $date_end)
    {
        date_default_timezone_set('Asia/Jakarta');
        $this->db->select('COUNT(*) as jumlah');
        $this->db->from('order');
        $this->db->where("tanggal BETWEEN '$date_start' AND '$date_end'");
        $query = $this->db->get();
        return $query->row()->jumlah;
    }

    public function GetCountTransaksi($date_start, $date_end)
    {
        date_default_timezone_set('Asia/Jakarta');
        $this->db->select('COUNT(*) as jumlah');
        $this->db->from('invoice');
        $this->db->where("tanggal BETWEEN '$date_start' AND '$date_end'");
        $query = $this->db->get();
        return $query->row()->jumlah;
    }

    public function getDeskripsiMenuCount($date_start, $date_end)
    {
        date_default_timezone_set('Asia/Jakarta');
        $this->db->select('jenis as jenis,nama as nama,SUM(qty) as jumlah');
        $this->db->from('invoice_detail');
        $this->db->where("tanggal BETWEEN '$date_start' AND '$date_end'");
        $this->db->group_by('jenis,nama');
        $this->db->order_by('jumlah', 'DESC');
        $query = $this->db->get();
        return $query->result();
    }

    public function GetTakeawayRevenue($date_start, $date_end)
    {
        date_default_timezone_set('Asia/Jakarta');
        $this->db->select('SUM(COALESCE(amount_total, 0)) AS total_revenue', false);
        $this->db->from('invoice');
        $this->db->where('tanggal >=', $date_start);
        $this->db->where('tanggal <=', $date_end);
        $this->db->where($this->getTakeawayCondition(), null, false);
        $query = $this->db->get();
        return $query->row()->total_revenue;
    }

    public function GetTakeawayCountTransaksi($date_start, $date_end)
    {
        date_default_timezone_set('Asia/Jakarta');
        $this->db->select('COUNT(*) AS jumlah', false);
        $this->db->from('invoice');
        $this->db->where('tanggal >=', $date_start);
        $this->db->where('tanggal <=', $date_end);
        $this->db->where($this->getTakeawayCondition(), null, false);
        $query = $this->db->get();
        return $query->row()->jumlah;
    }

    public function GetPaymentMethodSummary($date_start, $date_end)
    {
        $SQL = "SELECT
                CASE
                    WHEN LOWER(COALESCE(metode, '')) LIKE '%qris%' THEN 'QRIS'
                    WHEN LOWER(COALESCE(metode, '')) LIKE '%cash%' OR COALESCE(metode, '') = '' THEN 'Cash'
                    WHEN LOWER(COALESCE(metode, '')) LIKE '%transfer%' THEN 'Transfer'
                    WHEN LOWER(COALESCE(metode, '')) LIKE '%debit%' OR LOWER(COALESCE(metode, '')) LIKE '%card%' THEN 'Debit'
                    ELSE COALESCE(metode, 'Lainnya')
                END AS metode_group,
                COUNT(*) AS jumlah,
                SUM(COALESCE(amount_total, 0)) AS total
            FROM invoice
            WHERE tanggal BETWEEN ? AND ?
            GROUP BY metode_group
            ORDER BY total DESC";

        return $this->db->query($SQL, array($date_start, $date_end))->result_array();
    }

    public function GetTransactionTrend($date_start, $date_end)
    {
        $takeawayCondition = $this->getTakeawayCondition();

        $SQL = "SELECT
                DATE(tanggal) AS tanggal,
                COUNT(*) AS total_count,
                SUM(CASE WHEN {$takeawayCondition} THEN 1 ELSE 0 END) AS takeaway_count,
                SUM(COALESCE(amount_total, 0)) AS total_amount,
                SUM(CASE WHEN {$takeawayCondition} THEN COALESCE(amount_total, 0) ELSE 0 END) AS takeaway_amount
            FROM invoice
            WHERE tanggal BETWEEN ? AND ?
            GROUP BY DATE(tanggal)
            ORDER BY DATE(tanggal) ASC";

        return $this->db->query($SQL, array($date_start, $date_end))->result_array();
    }

    public function GetForChart1($year)
    {
        date_default_timezone_set('Asia/Jakarta');
        $this->db->select('MONTH(tanggal) as bulan, COUNT(*) as jumlah');
        $this->db->from('order');
        $this->db->where('YEAR(tanggal)', $year);
        $this->db->group_by('bulan');
        $this->db->order_by('bulan', 'asc');
        $query = $this->db->get();

        return $query->result_array(); // ✅ bukan row(), tapi result_array()
    }

    public function CountNotifikasiMitra($mitra)
    {
        date_default_timezone_set('Asia/Jakarta');
        $this->db->select('COUNT(*) as jumlah');
        $this->db->from('mitra_order_notif');
        $this->db->where('owner', $mitra);
        $this->db->where('tanggal', date('Y-m-d'));
        $this->db->where('notif', 1);
        $query = $this->db->get();
        return $query->row()->jumlah;
    }

    public function RowNotifikasiMitra($mitra)
    {
        date_default_timezone_set('Asia/Jakarta');
        $this->db->select('*');
        $this->db->from('mitra_order_notif');
        $this->db->where('owner', $mitra);
        $this->db->where('tanggal', date('Y-m-d'));
        $this->db->where('notif', 1);
        $query = $this->db->get();
        return $query->result();
    }

    public function ListDetailPesananByOwner($mitra)
    {
        $SQL = "SELECT
                a.*,
                b.nama as status_food
                FROM order_detail a
                LEFT JOIN status_food b ON a.status = b.id
                WHERE a.owner='" . $mitra . "'";
        $query = $this->db->query($SQL)->result();
        return $query;
    }

    public function LoadDataTransaksiMitra($mitra, $start_date, $end_date)
    {
        $SQL = "SELECT
                a.no_transaksi AS no_transaksi,
                a.no_order AS no_order,
                a.no_meja AS no_meja,
                a.tanggal AS tanggal,
                b.metode AS metode,
                b.created_at as created_at,
                b.reference_payment AS reference_payment,
                SUM((COALESCE(a.harga, 0) * COALESCE(a.qty, 0)) - COALESCE(a.potongan, 0)) AS subtotal
            FROM invoice_detail a
            LEFT JOIN invoice b
                ON a.no_transaksi = b.no_transaksi
                AND a.no_order = b.no_order
                AND a.no_meja = b.no_meja
            WHERE a.owner = '" . $mitra . "'
            AND a.tanggal BETWEEN '" . $start_date . "' AND '" . $end_date . "'
            GROUP BY
                a.no_transaksi,
                a.no_order,
                a.no_meja,
                a.tanggal,
                b.metode,
                b.reference_payment,
                b.created_at";
        $query = $this->db->query($SQL)->result();
        return $query;
    }

    public function GetRevenueMitra($date_start, $date_end, $mitra)
    {
        date_default_timezone_set('Asia/Jakarta');
        $this->db->select('SUM((COALESCE(harga, 0) * COALESCE(qty, 0)) - COALESCE(potongan, 0)) AS  total_revenue');
        $this->db->from('invoice_detail');
        $this->db->where('tanggal >=', $date_start);
        $this->db->where('tanggal <=', $date_end);
        $this->db->where('owner', $mitra);
        $query = $this->db->get();
        return $query->row()->total_revenue;
    }

    public function GetVisitorMitra($date_start, $date_end)
    {
        date_default_timezone_set('Asia/Jakarta');
        $this->db->select('COUNT(*) as jumlah');
        $this->db->from('order');
        $this->db->where("tanggal BETWEEN '$date_start' AND '$date_end'");
        $query = $this->db->get();
        return $query->row()->jumlah;
    }

    public function GetCountTransaksiMitra($date_start, $date_end, $mitra)
    {
        date_default_timezone_set('Asia/Jakarta');
        $this->db->select('COUNT(*) as jumlah');
        $this->db->from('invoice_detail');
        $this->db->where("tanggal BETWEEN '$date_start' AND '$date_end'");
        $this->db->where('owner', $mitra);
        $query = $this->db->get();
        return $query->row()->jumlah;
    }

    public function getDeskripsiMenuCountMitra($date_start, $date_end, $mitra)
    {
        date_default_timezone_set('Asia/Jakarta');
        $this->db->select('jenis as jenis,nama as nama,SUM(qty) as jumlah');
        $this->db->from('invoice_detail');
        $this->db->where("tanggal BETWEEN '$date_start' AND '$date_end'");
        $this->db->where("owner", $mitra);
        $this->db->group_by('jenis,nama');
        $this->db->order_by('jumlah', 'DESC');
        $query = $this->db->get();
        return $query->result();
    }

}
