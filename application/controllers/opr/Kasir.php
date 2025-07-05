<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * @property CI_DB $db
 * @property CI_Session $session
 * @property CI_Output $output
 * @property CI_Input $input
 * @property CI_
 * @property CI_Form_validation $form_validation
 * @property CI_Upload $upload
 * @property M_pesanan $M_pesanan
 */
class Kasir extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model("M_pesanan");
    }

    public function getdata_meja()
    {
        $query = $this->db->get("daftar_meja")->result();
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($query));
    }

    public function getdata_transaksi_today()
    {
        date_default_timezone_set("Asia/Jakarta");
        $query = $this->db->where('tanggal', date('Y-m-d'))->get("invoice")->result();
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($query));
    }

    public function get_number_order()
    {
        date_default_timezone_set("Asia/Jakarta");
        $SQL = "SELECT MAX(RIGHT(no_order,4)) as KD_MAX FROM `order` WHERE tanggal = '" . date('Y-m-d') . "'";
        $query = $this->db->query($SQL);
        if ($query->num_rows() > 0) {
            $row = $query->row();
            $n = ((int) $row->KD_MAX) + 1;
            $no = sprintf("%04s", $n);
        } else {
            $no = "0001";
        }
        $kode = 'ORD' . date('ymd') . $no;
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($kode));
    }

    public function get_number_invoice()
    {
        date_default_timezone_set("Asia/Jakarta");
        $SQL = "SELECT MAX(RIGHT(no_order,4)) as KD_MAX FROM `invoice` WHERE tanggal = '" . date('Y-m-d') . "'";
        $query = $this->db->query($SQL);
        if ($query->num_rows() > 0) {
            $row = $query->row();
            $n = ((int) $row->KD_MAX) + 1;
            $no = sprintf("%04s", $n);
        } else {
            $no = "0001";
        }
        $kode = 'INV' . date('ymd') . $no;
        return $kode;
    }

    public function getdata_menu()
    {
        $query = $this->M_pesanan->GetDataMenu();
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($query));
    }

    public function create_order_detail()
    {
        date_default_timezone_set("Asia/Jakarta");
        $input = json_decode(file_get_contents("php://input"), true);
        $order = $input['order_detail'];
        $no_booking = $input['no_booking'];
        $no_meja = $input['no_meja'];
        $user_id = $this->session->userdata('user_id');
        foreach ($order as $row) {
            $data3 = [
                'no_order' => $no_booking,
                'no_meja' => $no_meja,
                'tanggal' => date('Y-m-d'),
                'kategori' => $row['kategori'],
                'nama' => $row['nama'],
                'harga' => $row['harga'],
                'qty' => $row['qty'],
                'jenis' => $row['jenis'],
                'owner' => $row['owner'],
                'status' => 1,
                'user_id' => $user_id,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ];
            $query1 = $this->db->insert("order_detail", $data3);
        }

        $data2 = [
            'no_order' => $no_booking,
            'no_meja' => $no_meja,
            'tanggal' => date('Y-m-d'),
            'status' => '1',
            'keterangan' => '',
            'user_id' => $user_id,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ];

        $query2 = $this->db->insert("order", $data2);

        $data1 = [
            'status' => 1,
            'no_order' => $no_booking,
            'updated_at' => date('Y-m-d H:i:s'),
        ];

        $query3 = $this->db->where('no_meja', $no_meja)->update("daftar_meja", $data1);

        if ($query2 && $query3) {
            $response = [
                'status' => true,
                'message' => 'Successfully Insert Order',
            ];
        } else {
            $response = [
                'status' => false,
                'message' => '',
            ];
        }

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($response));
    }

    public function create_order_detail_tambahan()
    {
        date_default_timezone_set("Asia/Jakarta");
        $input = json_decode(file_get_contents("php://input"), true);
        $order = $input['order_detail'];
        $no_booking = $input['no_booking'];
        $no_meja = $input['no_meja'];
        $user_id = $this->session->userdata('user_id');

        if (empty($order)) {
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode([
                    'status' => false,
                    'message' => 'Order detail kosong',
                ]));
            return;
        }

        $data3 = [];
        foreach ($order as $row) {
            $data3[] = [
                'no_order' => $no_booking,
                'no_meja' => $no_meja,
                'tanggal' => date('Y-m-d'),
                'kategori' => $row['kategori'],
                'nama' => $row['nama'],
                'harga' => $row['harga'],
                'qty' => $row['qty'],
                'jenis' => $row['jenis'],
                'owner' => $row['owner'],
                'status' => 1,
                'user_id' => $user_id,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ];
        }

        $query1 = $this->db->insert_batch("order_detail", $data3);

        $response = $query1 ? [
            'status' => true,
            'message' => 'Successfully Insert Order Tambahan',
        ] : [
            'status' => false,
            'message' => 'Gagal insert ke database',
        ];

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($response));
    }

    public function list_pesanan()
    {
        $input = json_decode(file_get_contents("php://input"), true);
        $no_meja = $input['no_meja'];
        $value = $this->db->where('no_meja', $no_meja)->get('daftar_meja')->row();
        $no_order = $value->no_order;

        $result = $this->M_pesanan->ListDataMenuByNoOrder($no_order);
        $countMakanan = $this->M_pesanan->CountMakanan($no_order);
        $countMinuman = $this->M_pesanan->CountMinuman($no_order);

        $data = [
            'no_meja' => $no_meja,
            'no_order' => $no_order,
            'created_at' => $value->updated_at,
            'detail' => $result,
            'count_makanan' => $countMakanan,
            'count_minuman' => $countMinuman,
        ];
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($data));
    }

    public function list_pesanan_detail()
    {
        date_default_timezone_set("Asia/Jakarta");
        $input = json_decode(file_get_contents("php://input"), true);
        $no_booking = $input['no_booking'];
        $no_meja = $input['no_meja'];
        $nama = $input['nama'];
        $data = $this->M_pesanan->ListDetailPesanan($no_booking, $no_meja, $nama);
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($data));
    }

    public function update_qty_pesanan_list_detail()
    {
        $input = json_decode(file_get_contents("php://input"), true);
        $id = $input['id'];
        $qty = $input['qty'];
        $data = [
            'qty' => $qty,
            'updated_at' => date('Y-m-d H:i:s'),
        ];
        $this->db->where('id', $id)->update('order_detail', $data);
    }

    public function update_qty_pesanan_list_detail_hapus()
    {
        $input = json_decode(file_get_contents("php://input"), true);
        $id = $input['id'];
        $this->db->where('id', $id)->delete('order_detail');
    }

    public function update_served_food()
    {
        $input = json_decode(file_get_contents("php://input"), true);
        if (!isset($input['ids']) || !is_array($input['ids']) || empty($input['ids'])) {
            $response = [
                'status' => false,
                'message' => 'Data ID tidak valid atau kosong.',
            ];
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode($response));
            return;
        }

        $ids = $input['ids'];
        $data = [
            'status' => '2',
            'updated_at' => date('Y-m-d H:i:s'),
        ];
        // Update semua ID yang ada dalam array
        $this->db->where_in('id', $ids);
        $this->db->update('order_detail', $data); // Misal: status 3 artinya 'served'
        $response = [
            'status' => true,
            'message' => 'Successfully Update Status Served',
        ];
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($response));
    }

    public function update_delivered_food()
    {
        $input = json_decode(file_get_contents("php://input"), true);
        if (!isset($input['ids']) || !is_array($input['ids']) || empty($input['ids'])) {
            $response = [
                'status' => false,
                'message' => 'Data ID tidak valid atau kosong.',
            ];
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode($response));
            return;
        }

        $ids = $input['ids'];
        $data = [
            'status' => '3',
            'updated_at' => date('Y-m-d H:i:s'),
        ];
        // Update semua ID yang ada dalam array
        $this->db->where_in('id', $ids);
        $this->db->update('order_detail', $data); // Misal: status 3 artinya 'served'
        $response = [
            'status' => true,
            'message' => 'Successfully Update Status Served',
        ];
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($response));
    }

    public function update_completed_food()
    {
        $input = json_decode(file_get_contents("php://input"), true);
        if (!isset($input['ids']) || !is_array($input['ids']) || empty($input['ids'])) {
            $response = [
                'status' => false,
                'message' => 'Data ID tidak valid atau kosong.',
            ];
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode($response));
            return;
        }

        $ids = $input['ids'];
        $data = [
            'status' => '4',
            'updated_at' => date('Y-m-d H:i:s'),
        ];
        // Update semua ID yang ada dalam array
        $this->db->where_in('id', $ids);
        $this->db->update('order_detail', $data); // Misal: status 3 artinya 'served'
        $response = [
            'status' => true,
            'message' => 'Successfully Update Status Served',
        ];
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($response));
    }

    public function pindah_meja()
    {
        $input = json_decode(file_get_contents("php://input"), true);
        $no_booking = $input['no_booking'];
        $no_meja_lama = $input['no_meja_lama'];
        $no_meja_baru = $input['no_meja_baru'];
        $data1 = [
            'status' => 1,
            'no_order' => $no_booking,
            'updated_at' => date('Y-m-d H:i:s'),
        ];

        $data2 = [
            'status' => 0,
            'no_order' => null,
            'updated_at' => date('Y-m-d H:i:s'),
        ];
        $data3 = [
            'no_meja' => $no_meja_baru,
            'updated_at' => date('Y-m-d H:i:s'),
        ];
        $data4 = [
            'no_meja' => $no_meja_baru,
            'updated_at' => date('Y-m-d H:i:s'),
        ];

        $query1 = $this->db->where('no_meja', $no_meja_baru)->update("daftar_meja", $data1);
        $query2 = $this->db->where('no_meja', $no_meja_lama)->update("daftar_meja", $data2);
        $query3 = $this->db->where('no_order', $no_booking)->update("order", $data3);
        $query4 = $this->db->where('no_order', $no_booking)->update("order_detail", $data4);

        if ($query1 && $query2 && $query3 && $query4) {
            $response = [
                'status' => 'success',
                'message' => 'meja berhasil dipindahkan',
            ];
        } else {
            $response = [
                'status' => 'error',
                'message' => 'meja gagal dipindahkan',
            ];
        }

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($response));
    }

    public function delete_pesanan_list()
    {
        $input = json_decode(file_get_contents("php://input"), true);
        $id = $input['id'];
        echo $id;
    }

    public function get_list_meja_standby()
    {
        $query = $this->db->where("status", 0)->get("daftar_meja")->result();
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($query));
    }

    public function get_list_meja_terisi()
    {
        date_default_timezone_set("Asia/Jakarta");
        $input = json_decode(file_get_contents("php://input"), true);
        $no_meja = $input['no_meja'];
        $query = $this->db->where("status", 1)->where_not_in("no_meja", $no_meja)->get("daftar_meja")->result();
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($query));
    }

    public function cek_subtotal_transaksi()
    {
        $input = json_decode(file_get_contents("php://input"), true);
        $no_booking = $input['no_booking'];
        $total = $this->M_pesanan->TotalTransaksiByOrder($no_booking);
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($total));
    }

    public function get_pesanan_detail()
    {
        $input = json_decode(file_get_contents("php://input"), true);
        $no_booking = $input['no_booking'];
        $no_meja = $input['no_meja'];
        $data = $this->db->where("no_order", $no_booking)->where("no_meja", $no_meja)->get("order_detail")->result();
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($data));
    }

    public function get_pesanan_detail_no_meja()
    {
        $input = json_decode(file_get_contents("php://input"), true);
        $no_meja = $input['no_meja'];

        $data = $this->db
            ->where("no_meja", $no_meja)
            ->where("no_order !=", "") // ini lebih aman
            ->where("no_order IS NOT NULL") // tambahan, jaga-jaga kalau ada null
            ->get("order_detail")
            ->result();

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($data));
    }

    public function payment_before_service()
    {
        date_default_timezone_set("Asia/Jakarta");
        $input = json_decode(file_get_contents("php://input"), true);
        $data1 = [
            'no_transaksi' => $this->get_number_invoice(),
            'no_order' => $input['no_order'],
            'no_meja' => $input['no_meja'],
            'tanggal' => date('Y-m-d'),
            'qty' => $input['qty'],
            'subtotal' => $input['subtotal'],
            'ppn_text' => $input['ppn_text'],
            'ppn' => $input['ppn'],
            'amount_total' => $input['amount_total'],
            'dibayar' => $input['dibayar'],
            'kembalian' => $input['kembalian'],
            'metode' => $input['metode'],
            'reference_number' => $input['refrence_number'],
            'reference_payment' => $input['refrence_payment'],
            'metode_service' => $input['metode_service'],
            'created_at' => date('Y-m-d H:i:s'),
            'created_by' => $this->session->userdata('username'),
        ];
        $row_order_detail = $this->db->where("no_order", $input['no_order'])->where("no_meja", $input['no_meja'])->get("order_detail")->result();
        $data2 = [];
        foreach ($row_order_detail as $row) {
            $data2[] = [
                'no_transaksi' => $this->get_number_invoice(),
                'no_order' => $row->no_order,
                'no_meja' => $row->no_meja,
                'tanggal' => $row->tanggal,
                'kategori' => $row->kategori,
                'nama' => $row->nama,
                'harga' => $row->harga,
                'qty' => $row->qty,
                'jenis' => $row->jenis,
                'owner' => $row->owner,
                'status' => '4',
                'created_at' => date('Y-m-d H:i:s'),
                'created_by' => $this->session->userdata('username'),
            ];
        }
        $query1 = $this->db->insert("invoice", $data1);
        $query2 = $this->db->insert_batch("invoice_detail", $data2);
        $query3 = $this->db->where("no_meja", $input['no_meja'])->update("daftar_meja", ["no_order" => "", "status" => 0, "updated_at" => date('Y-m-d H:i:s')]);
        $query4 = $this->db->where("no_meja", $input['no_meja'])->delete("order_detail");
        $query5 = $this->db->where("no_meja", $input['no_meja'])->update("order", ["status" => 4, "user_id" => $this->session->userdata('user_id'), "updated_at" => date('Y-m-d H:i:s')]);
        if ($query1 && $query2 && $query3 && $query4 && $query5) {
            $response = [
                'status' => "success",
                'message' => 'Successfully Insert Payment',
            ];
        } else {
            $response = [
                'status' => "error",
                'message' => 'Error Payment',
            ];
        }
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($response));
    }

    public function payment_after_service()
    {
        date_default_timezone_set("Asia/Jakarta");
        $input = json_decode(file_get_contents("php://input"), true);
        $data1 = [
            'no_transaksi' => $this->get_number_invoice(),
            'no_order' => $input['no_order'],
            'no_meja' => $input['no_meja'],
            'tanggal' => date('Y-m-d'),
            'qty' => $input['qty'],
            'subtotal' => $input['subtotal'],
            'ppn_text' => $input['ppn_text'],
            'ppn' => $input['ppn'],
            'amount_total' => $input['amount_total'],
            'dibayar' => $input['dibayar'],
            'kembalian' => $input['kembalian'],
            'metode' => $input['metode'],
            'reference_number' => $input['refrence_number'],
            'reference_payment' => $input['refrence_payment'],
            'metode_service' => $input['metode_service'],
            'created_at' => date('Y-m-d H:i:s'),
            'created_by' => $this->session->userdata('username'),
        ];
        $row_order_detail = $this->db->where("no_order", $input['no_order'])->where("no_meja", $input['no_meja'])->get("order_detail")->result();
        $data2 = [];
        foreach ($row_order_detail as $row) {
            $data2[] = [
                'no_transaksi' => $this->get_number_invoice(),
                'no_order' => $row->no_order,
                'no_meja' => $row->no_meja,
                'tanggal' => $row->tanggal,
                'kategori' => $row->kategori,
                'nama' => $row->nama,
                'harga' => $row->harga,
                'qty' => $row->qty,
                'jenis' => $row->jenis,
                'owner' => $row->owner,
                'status' => '4',
                'created_at' => date('Y-m-d H:i:s'),
                'created_by' => $this->session->userdata('username'),
            ];
        }
        $query1 = $this->db->insert("invoice", $data1);
        $query2 = $this->db->insert_batch("invoice_detail", $data2);
        $query3 = $this->db->where("no_meja", $input['no_meja'])->update("daftar_meja", ["no_order" => "", "status" => 0, "updated_at" => date('Y-m-d H:i:s')]);
        $query4 = $this->db->where("no_meja", $input['no_meja'])->delete("order_detail");
        $query5 = $this->db->where("no_meja", $input['no_meja'])->update("order", ["status" => 4, "user_id" => $this->session->userdata('user_id'), "updated_at" => date('Y-m-d H:i:s')]);

        if ($query1 && $query2 && $query3 && $query4 && $query5) {
            $response = [
                'status' => "success",
                'message' => 'Successfully Insert Payment',
            ];
        } else {
            $response = [
                'status' => "error",
                'message' => 'Error Payment',
            ];
        }
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($response));
    }

    public function payment_bill_gabung()
    {
        date_default_timezone_set("Asia/Jakarta");

        $input = json_decode(file_get_contents("php://input"), true);
        $invoice = $this->get_number_invoice();
        $group = $input['group'];
        $jumlah_dibayar = $input['dibayar'];
        $metode = $input['metode'];
        $kembalian = $input['kembalian'];
        $refrence_payment = $input['refrence_payment'];
        $refrence_number = $input['refrence_number'];
        $metode_service = $input['metode_service'];
        $grouped_items = [];

        // Step 1: Group by no_meja dan no_order
        foreach ($group as $meja) {
            if (isset($meja['items']) && is_array($meja['items'])) {
                foreach ($meja['items'] as $item) {
                    $no_meja = $item['no_meja'];
                    $no_order = $item['no_order'];

                    if (!isset($grouped_items[$no_meja])) {
                        $grouped_items[$no_meja] = [];
                    }

                    if (!isset($grouped_items[$no_meja][$no_order])) {
                        $grouped_items[$no_meja][$no_order] = [];
                    }

                    $grouped_items[$no_meja][$no_order][] = $item;
                }
            }
        }

        // Step 2: Group ulang hanya berdasarkan no_order
        $orders = [];

        foreach ($grouped_items as $meja => $orders_by_meja) {
            foreach ($orders_by_meja as $no_order => $items) {
                if (!isset($orders[$no_order])) {
                    $orders[$no_order] = [];
                }
                $orders[$no_order] = array_merge($orders[$no_order], $items);
            }
        }

        // Step 3: Perulangan untuk proses simpan invoice per order
        foreach ($orders as $no_order => $items) {
            // Ambil no_meja dari salah satu item (misalnya item pertama)
            $no_meja = $items[0]['no_meja'];

            $qtyCount = 0;
            $subtotalCOUNT = 0;

            $rowResult = $this->db->where("no_order", $no_order)->get("order_detail")->result();

            foreach ($rowResult as $row) {
                $qtyCount += $row->qty;
                $subtotalCOUNT += $row->harga * $row->qty;
                $dataDetail = [
                    'no_transaksi' => $invoice,
                    'no_order' => $row->no_order,
                    'no_meja' => $row->no_meja,
                    'tanggal' => $row->tanggal,
                    'kategori' => $row->kategori,
                    'nama' => $row->nama,
                    'harga' => $row->harga,
                    'qty' => $row->qty,
                    'jenis' => $row->jenis,
                    'owner' => $row->owner,
                    'status' => '4',
                    'created_at' => date('Y-m-d H:i:s'),
                    'created_by' => $this->session->userdata('username'),
                ];
                $this->db->insert("invoice_detail", $dataDetail);
            }

            $ppn = $subtotalCOUNT * 0.10;
            $amount_total = $subtotalCOUNT + $ppn;

            $dataTemp = [
                'no_transaksi' => $invoice,
                'no_order' => $no_order,
                'no_meja' => $no_meja, //
                'tanggal' => date('Y-m-d'),
                'qty' => $qtyCount,
                'subtotal' => $subtotalCOUNT,
                'ppn_text' => "10%",
                'ppn' => $ppn,
                'amount_total' => $amount_total,
                'dibayar' => $jumlah_dibayar,
                'kembalian' => $kembalian,
                'metode' => $metode,
                'reference_number' => $refrence_number,
                'reference_payment' => $refrence_payment,
                'metode_service' => $metode_service,
                'created_at' => date('Y-m-d H:i:s'),
                'created_by' => $this->session->userdata('username'),
            ];

            $this->db->insert("invoice", $dataTemp);
            $query1 = $this->db->where("no_meja", $no_meja)->update("daftar_meja", ["no_order" => "", "status" => 0, "updated_at" => date('Y-m-d H:i:s')]);
            $query2 = $this->db->where("no_meja", $no_meja)->delete("order_detail");
            $query3 = $this->db->where("no_meja", $no_meja)->update("order", ["status" => 4, "user_id" => $this->session->userdata('user_id'), "updated_at" => date('Y-m-d H:i:s')]);
        }
        $response = [
            'status' => "success",
            'message' => 'Successfully Insert Payment',
        ];
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($response));
    }

}
