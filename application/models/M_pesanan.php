<?php
class M_pesanan extends CI_Model
{

    public function GetDataMenu()
    {
        $SQL = "SELECT
                a.id as id,
                b.id as kategori_id,
                b.kategori as kategori,
                a.nama as nama,
                a.harga as harga,
                a.img as img,
                a.owner as owner,
                'Makanan' as jenis,
                a.status as status_food
                FROM makanan a
                LEFT JOIN kategori_makanan b ON a.kategori_id = b.id

                UNION ALL

                SELECT
                a.id as id,
                b.id as kategori_id,
                b.kategori as kategori,
                a.nama as nama,
                a.harga as harga,
                a.img as img,
                a.owner as owner,
                'Minuman' as jenis,
                a.status as status_food
                FROM minuman a
                LEFT JOIN kategori_minuman b ON a.kategori_id = b.id
                ";
        $query = $this->db->query($SQL)->result();
        return $query;
    }

    public function ListDataMenuByNoOrder($no_order)
    {
        $SQL = "SELECT
                a.kategori,
                a.nama,
                a.harga,
                a.jenis,
                SUM(a.qty) AS qty,
                AVG(a.discount) AS discount,
                SUM(a.potongan) AS potongan,
                SUM(a.qty * a.harga) - SUM(COALESCE(a.potongan, 0)) AS subtotal
            FROM order_detail a
            WHERE a.no_order = ?
            GROUP BY a.nama, a.harga, a.kategori, a.jenis";

        return $this->db->query($SQL, [$no_order])->result();
    }

    public function ListDetailPesanan($no_booking, $no_meja, $makanan)
    {
        $SQL = "SELECT
                a.*,
                b.nama as status_food
                FROM order_detail a
                LEFT JOIN status_food b ON a.status = b.id
                WHERE a.no_order='" . $no_booking . "'
                AND a.no_meja='" . $no_meja . "'
                AND a.nama='" . $makanan . "'";
        $query = $this->db->query($SQL)->result();
        return $query;
    }

    public function CountMakanan($no_order)
    {
        $SQL = "SELECT
                SUM(a.qty) as qty
                FROM order_detail a
                WHERE a.no_order='" . $no_order . "'
                AND a.jenis = 'Makanan'";
        $query = $this->db->query($SQL)->row()->qty;
        return $query;
    }

    public function CountMinuman($no_order)
    {
        $SQL = "SELECT
                SUM(a.qty) as qty
                FROM order_detail a
                WHERE a.no_order='" . $no_order . "'
                AND a.jenis = 'Minuman'";
        $query = $this->db->query($SQL)->row()->qty;
        return $query;
    }

    public function TotalTransaksiByOrder($orderan)
    {
        $SQL = "SELECT SUM(harga * qty) as total FROM order_detail WHERE no_order='" . $orderan . "'";
        $query = $this->db->query($SQL)->row()->total;
        return $query;
    }

    public function GetTransaksi($date_start, $date_end)
    {
        $SQL = "SELECT * FROM invoice WHERE tanggal BETWEEN '" . $date_start . "' AND '" . $date_end . "'";
        $query = $this->db->query($SQL)->result();
        return $query;
    }

}
