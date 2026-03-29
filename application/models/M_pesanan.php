<?php
class M_pesanan extends CI_Model
{
    private function getTakeawayCondition($alias = '')
    {
        $prefix = $alias !== '' ? $alias . '.' : '';

        return "(LOWER(COALESCE({$prefix}no_meja, '')) = 'takeaway'
            OR LOWER(COALESCE({$prefix}metode_service, '')) = 'takeaway'
            OR COALESCE({$prefix}no_transaksi, '') LIKE 'TKI%'
            OR COALESCE({$prefix}no_order, '') LIKE 'TAK%')";
    }

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
            $SQL = "SELECT * FROM invoice
                    WHERE tanggal BETWEEN '" . $date_start . "' AND '" . $date_end . "'
                    AND LOWER(COALESCE(no_meja, '')) <> 'takeaway'
                    AND LOWER(COALESCE(metode_service, '')) <> 'takeaway'
                    AND no_transaksi NOT LIKE 'TKI%'
                    ORDER BY id DESC";
        } elseif ($type == 'Owner') {
            $SQL = "SELECT
					a.no_transaksi as no_transaksi,
					b.no_order as no_order,
					b.no_meja as no_meja,
					b.no_split as no_split,
					b.created_by as created_by,
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
					AND LOWER(COALESCE(b.no_meja, '')) <> 'takeaway'
					AND LOWER(COALESCE(b.metode_service, '')) <> 'takeaway'
					AND b.no_transaksi NOT LIKE 'TKI%'
					GROUP BY 1,2,3,4,5,6,7,8,9
					ORDER BY b.created_at DESC";
        } else {
            $SQL = "SELECT
					a.no_transaksi as no_transaksi,
					b.no_order as no_order,
					b.no_meja as no_meja,
					b.no_split as no_split,
					b.created_by as created_by,
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
					AND LOWER(COALESCE(b.no_meja, '')) <> 'takeaway'
					AND LOWER(COALESCE(b.metode_service, '')) <> 'takeaway'
					AND b.no_transaksi NOT LIKE 'TKI%'
					GROUP BY 1,2,3,4,5,6,7,8,9
					ORDER BY b.created_at DESC";
        }
        $query = $this->db->query($SQL)->result();
        return $query;
    }

    public function GetPeriodeTransaksi($date_start, $date_end)
    {
        date_default_timezone_set('Asia/Jakarta');
        $takeawayCondition = $this->getTakeawayCondition('b');
        $SQL = "SELECT
				a.jenis,
				a.kategori,
				a.nama,
				a.harga,
				a.owner,
				c.nama AS owner_name,
				CASE
					WHEN {$takeawayCondition} THEN 'Takeaway'
					ELSE 'Dine In'
				END AS service_label,
				CASE
					WHEN {$takeawayCondition} THEN 1
					ELSE 0
				END AS is_takeaway,
				SUM(a.qty) AS qty,
				SUM((COALESCE(a.qty, 0) * COALESCE(a.harga, 0)) - COALESCE(a.potongan, 0) + COALESCE(a.discount, 0)) AS subtotal
				FROM invoice_detail a
				LEFT JOIN invoice b
				ON a.no_transaksi = b.no_transaksi
				AND a.no_order = b.no_order
				AND a.no_meja = b.no_meja
				LEFT JOIN mitra c
				ON a.owner = c.kode
				WHERE
				a.tanggal BETWEEN '" . $date_start . "'
				AND '" . $date_end . "'
				GROUP BY
				a.jenis,
				a.kategori,
				a.nama,
				a.harga,
				a.owner,
				c.nama,
				service_label,
				is_takeaway
				ORDER BY
				is_takeaway ASC,
				a.jenis ASC,
				a.kategori ASC,
				a.nama ASC";
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
				CASE
					WHEN LOWER(COALESCE(a.metode, '')) LIKE '%qris%' THEN 'QRIS'
					WHEN LOWER(COALESCE(a.metode, '')) LIKE '%cash%' OR COALESCE(a.metode, '') = '' THEN 'Cash'
					WHEN LOWER(COALESCE(a.metode, '')) LIKE '%transfer%' THEN 'Transfer'
					WHEN LOWER(COALESCE(a.metode, '')) LIKE '%debit%' OR LOWER(COALESCE(a.metode, '')) LIKE '%card%' THEN 'Debit'
					ELSE COALESCE(a.metode, 'Lainnya')
				END AS metode,
				COUNT(*) AS jumlah,
				SUM(COALESCE(a.amount_total, 0)) as total
				FROM invoice a
				WHERE a.tanggal BETWEEN '" . $start . "' AND '" . $end . "'
				GROUP BY 1
				ORDER BY total DESC";
        $query = $this->db->query($SQL)->result();
        return $query;
    }

    public function SummaryServiceTransaksi($start, $end)
    {
        $takeawayCondition = $this->getTakeawayCondition('a');

        $SQL = "SELECT
				CASE
					WHEN {$takeawayCondition} THEN 'Takeaway'
					ELSE 'Dine In'
				END AS service_label,
				COUNT(*) AS jumlah_transaksi,
				SUM(COALESCE(a.qty, 0)) AS total_qty,
				SUM(COALESCE(a.amount_total, 0)) AS total
				FROM invoice a
				WHERE a.tanggal BETWEEN '" . $start . "' AND '" . $end . "'
				GROUP BY 1
				ORDER BY total DESC";

        return $this->db->query($SQL)->result();
    }

    public function SummaryOverviewTransaksi($start, $end)
    {
        $takeawayCondition = $this->getTakeawayCondition('a');

        $SQL = "SELECT
				COUNT(*) AS jumlah_transaksi,
				SUM(COALESCE(a.qty, 0)) AS total_qty,
				SUM(COALESCE(a.amount_total, 0)) AS total_pendapatan,
				SUM(CASE WHEN {$takeawayCondition} THEN COALESCE(a.amount_total, 0) ELSE 0 END) AS total_takeaway,
				SUM(CASE WHEN {$takeawayCondition} THEN 1 ELSE 0 END) AS transaksi_takeaway,
				SUM(CASE WHEN {$takeawayCondition} THEN COALESCE(a.qty, 0) ELSE 0 END) AS qty_takeaway
				FROM invoice a
				WHERE a.tanggal BETWEEN '" . $start . "' AND '" . $end . "'";

        return $this->db->query($SQL)->row();
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
