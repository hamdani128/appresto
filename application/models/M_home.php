<?php
class M_home extends CI_Model
{

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
        $query = $this->db->get();
        return $query->result();
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

}
