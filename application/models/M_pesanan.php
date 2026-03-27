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
        $SQL   = "SELECT SUM(harga * qty) as total FROM order_detail WHERE no_order='" . $orderan . "'";
        $query = $this->db->query($SQL)->row()->total;
        return $query;
    }

    public function GetTransaksi($date_start, $date_end, $type)
    {
        if ($type == 'All') {
            $SQL = "SELECT * FROM invoice WHERE tanggal BETWEEN '" . $date_start . "' AND '" . $date_end . "'";
        } elseif ($type == 'Owner') {
            $SQL = "SELECT
					a.no_transaksi as no_transaksi,
					b.no_order as no_order,
					b.no_meja as no_meja,
					b.metode as metode,
					b.metode_service as metode_service,
					a.tanggal as tanggal,
					b.created_at as created_at,
					SUM((COALESCE(a.harga, 0) * COALESCE(a.qty, 0)) - (COALESCE(a.potongan, 0)) + COALESCE(a.discount, 0)) as subtotal
					FROM invoice_detail a
					LEFT JOIN invoice b ON a.no_transaksi = b.no_transaksi
					WHERE
					a.tanggal BETWEEN '" . $date_start . "' AND '" . $date_end . "'
					AND a.owner='Owner'
					GROUP BY 1,2,3,4,5,6,7";
        } else {
            $SQL = "SELECT
					a.no_transaksi as no_transaksi,
					b.no_order as no_order,
					b.no_meja as no_meja,
					b.metode as metode,
					b.metode_service as metode_service,
					a.tanggal as tanggal,
					b.created_at as created_at,
					SUM((COALESCE(a.harga, 0) * COALESCE(a.qty, 0)) - (COALESCE(a.potongan, 0)) + COALESCE(a.discount, 0)) as subtotal
					FROM invoice_detail a
					LEFT JOIN invoice b ON a.no_transaksi = b.no_transaksi
					WHERE
					a.tanggal BETWEEN '" . $date_start . "' AND '" . $date_end . "'
					AND a.owner='" . $type . "'
					GROUP BY 1,2,3,4,5,6,7";
        }
        $query = $this->db->query($SQL)->result();
        return $query;
    }

    public function GetPeriodeTransaksi($date_start, $date_end)
    {
        date_default_timezone_set('Asia/Jakarta');
        $SQL = "SELECT
				a.jenis,
				a.kategori,
				a.nama,
				a.harga,
				a.owner,
				b.nama AS owner_name,
				SUM(a.qty) AS qty,
				SUM(a.qty * a.harga) AS subtotal
				FROM invoice_detail a
				LEFT JOIN mitra b
				ON a.owner = b.kode
				WHERE
				a.tanggal BETWEEN '" . $date_start . "'
				AND '" . $date_end . "'
				GROUP BY
				a.jenis,
				a.kategori,
				a.nama,
				a.harga,
				a.owner,
				b.nama
				ORDER BY
				a.jenis ASC";
        $query = $this->db->query($SQL)->result();
        return $query;
    }

    public function GetPeriodeSaldoAwal($date_start, $date_end)
    {
        date_default_timezone_set('Asia/Jakarta');
        $SQL   = "SELECT * FROM saldo_awal WHERE tanggal BETWEEN '" . $date_start . "' AND '" . $date_end . "'";
        $query = $this->db->query($SQL)->result();
        return $query;
    }

    public function GetPeriodePengeluaran($date_start, $date_end)
    {
        date_default_timezone_set('Asia/Jakarta');
        $SQL   = "SELECT * FROM pengeluaran WHERE tanggal BETWEEN '" . $date_start . "' AND '" . $date_end . "'";
        $query = $this->db->query($SQL)->result();
        return $query;
    }

    public function SummaryMetodeTransaksi($start, $end)
    {
        $SQL = "SELECT
				a.metode,
				SUM(a.subtotal) as total
				FROM invoice a
				WHERE a.tanggal BETWEEN '" . $start . "' AND '" . $end . "'
				GROUP BY 1";
        $query = $this->db->query($SQL)->result();
        return $query;
    }

    public function SummarySaldoAwal($start, $end)
    {
        $SQL = "SELECT
				SUM(a.saldo) as total
				FROM saldo_awal a
				WHERE a.tanggal BETWEEN '" . $start . "' AND '" . $end . "'";
        $query = $this->db->query($SQL)->row();
        return $query;
    }

    public function SummaryPengeluaran($start, $end)
    {
        $SQL = "SELECT
				SUM(a.amount) as total
				FROM pengeluaran a
				WHERE a.tanggal BETWEEN '" . $start . "' AND '" . $end . "'";
        $query = $this->db->query($SQL)->row();
        return $query;
    }

}
