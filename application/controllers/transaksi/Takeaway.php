<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * @property CI_DB $db
 * @property CI_Session $session
 * @property CI_Output $output
 * @property CI_Input $input
 * @property CI_Form_validation $form_validation
 * @property CI_Upload $upload
 */
class Takeaway extends CI_Controller
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
            'content' => 'pages/kasir/takeaway_kasir',
        ];
        $this->load->view('layout/index', $data);
    }

    public function create_queue()
    {
        date_default_timezone_set("Asia/Jakarta");
        $input = json_decode(file_get_contents("php://input"), true);

        $orderDetail = isset($input['order_detail']) && is_array($input['order_detail'])
            ? $input['order_detail']
            : [];

        if (empty($orderDetail)) {
            return $this->json_response([
                'status'  => 'error',
                'message' => 'Order detail kosong.',
            ], 422);
        }

        $tanggal     = date('Y-m-d');
        $now         = date('Y-m-d H:i:s');
        $username    = $this->session->userdata('username');
        $userId      = $this->session->userdata('user_id');
        $noOrder     = $this->generate_takeaway_order_number();
        $queueNumber = $this->generate_takeaway_queue_number();
        $noMeja      = 'Takeaway';
        $statusLabel = 'Menunggu';
        $meta        = $this->build_order_meta($queueNumber, $statusLabel);

        $dataOrder = [
            'no_order'   => $noOrder,
            'no_meja'    => $noMeja,
            'tanggal'    => $tanggal,
            'status'     => 1,
            'keterangan' => $meta,
            'user_id'    => $userId,
            'created_at' => $now,
            'updated_at' => $now,
        ];

        $insertedOwners  = [];
        $dataOrderDetail = [];
        $dataNotif       = [];

        foreach ($orderDetail as $row) {
            $owner  = ! empty($row['owner']) ? $row['owner'] : 'Owner';
            $harga  = (float) ($row['harga'] ?? 0);
            $qtyRow = (int) ($row['qty'] ?? 0);

            if ($qtyRow <= 0) {
                continue;
            }

            if ($owner !== 'Owner' && ! in_array($owner, $insertedOwners, true)) {
                $dataNotif[] = [
                    'no_order'   => $noOrder,
                    'no_meja'    => $noMeja,
                    'tanggal'    => $tanggal,
                    'owner'      => $owner,
                    'notif'      => 1,
                    'created_at' => $now,
                    'created_by' => $username,
                ];
                $insertedOwners[] = $owner;
            }

            $dataOrderDetail[] = [
                'no_order'   => $noOrder,
                'no_meja'    => $noMeja,
                'tanggal'    => $tanggal,
                'kategori'   => $row['kategori'] ?? '',
                'nama'       => $row['nama'] ?? '',
                'harga'      => $harga,
                'qty'        => $qtyRow,
                'potongan'   => 0,
                'discount'   => 0,
                'jenis'      => $row['jenis'] ?? 'Menu',
                'owner'      => $owner,
                'status'     => 1,
                'user_id'    => $userId,
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }

        if (empty($dataOrderDetail)) {
            return $this->json_response([
                'status'  => 'error',
                'message' => 'Item order takeaway tidak valid.',
            ], 422);
        }

        $this->db->trans_begin();
        $this->db->insert('order', $dataOrder);
        $this->db->insert_batch('order_detail', $dataOrderDetail);
        if (! empty($dataNotif)) {
            $this->db->insert_batch('mitra_order_notif', $dataNotif);
        }

        if ($this->db->trans_status() === false) {
            $this->db->trans_rollback();

            return $this->json_response([
                'status'  => 'error',
                'message' => 'Gagal membuat antrian takeaway.',
            ], 500);
        }

        $this->db->trans_commit();

        return $this->json_response([
            'status'       => 'success',
            'message'      => 'Antrian takeaway berhasil dibuat.',
            'no_order'     => $noOrder,
            'queue_no'     => $queueNumber,
            'status_label' => $statusLabel,
            'created_at'   => $now,
        ]);
    }

    public function submit_payment()
    {
        date_default_timezone_set("Asia/Jakarta");
        $input = json_decode(file_get_contents("php://input"), true);

        $noOrder        = trim($input['no_order'] ?? '');
        $amountTotal    = (float) ($input['amount_total'] ?? 0);
        $paidAmount     = (float) ($input['dibayar'] ?? 0);
        $inputOrderRows = isset($input['order_detail']) && is_array($input['order_detail'])
            ? $input['order_detail']
            : [];

        if ($amountTotal <= 0) {
            return $this->json_response([
                'status'  => 'error',
                'message' => 'Total transaksi tidak valid.',
            ], 422);
        }

        if ($paidAmount < $amountTotal) {
            return $this->json_response([
                'status'  => 'error',
                'message' => 'Jumlah dibayar kurang dari grand total.',
            ], 422);
        }

        $tanggal      = date('Y-m-d');
        $now          = date('Y-m-d H:i:s');
        $username     = $this->session->userdata('username');
        $userId       = $this->session->userdata('user_id');
        $noTransaksi  = $this->generate_takeaway_invoice_number();
        $noMeja       = 'Takeaway';
        $discountText = (float) ($input['discount_text'] ?? 0);
        $discount     = (float) ($input['discount'] ?? 0);
        $ppnText      = (float) ($input['ppn_text'] ?? 0);
        $ppnAmount    = (float) ($input['ppn'] ?? 0);
        $qty          = (int) ($input['qty'] ?? 0);
        $kembalian    = (float) ($input['kembalian'] ?? 0);
        $metode       = $input['metode'] ?? 'Cash';
        $referencePay = $input['refrence_payment'] ?? '';
        $referenceNo  = $input['refrence_number'] ?? '';
        $serviceMode  = $input['metode_service'] ?? 'Takeaway';
        $queueNumber  = '';
        $orderDetail  = [];

        if ($noOrder !== '') {
            $orderRow = $this->db->where('no_order', $noOrder)
                ->where('no_meja', $noMeja)
                ->get('order')
                ->row();

            if (! $orderRow) {
                return $this->json_response([
                    'status'  => 'error',
                    'message' => 'Data order takeaway tidak ditemukan.',
                ], 404);
            }

            if ((int) $orderRow->status === 4) {
                return $this->json_response([
                    'status'  => 'error',
                    'message' => 'Order takeaway ini sudah dibayar.',
                ], 409);
            }

            $meta        = $this->parse_order_meta($orderRow->keterangan);
            $queueNumber = $meta['queue_no'];
            $orderDetail = $this->db->where('no_order', $noOrder)
                ->where('no_meja', $noMeja)
                ->get('order_detail')
                ->result();

            if (empty($orderDetail)) {
                return $this->json_response([
                    'status'  => 'error',
                    'message' => 'Detail order takeaway tidak ditemukan.',
                ], 404);
            }
        } else {
            if (empty($inputOrderRows)) {
                return $this->json_response([
                    'status'  => 'error',
                    'message' => 'Draft order takeaway belum ada.',
                ], 422);
            }

            $noOrder = $this->generate_takeaway_order_number();
            $orderDetail = $this->map_input_order_to_objects($inputOrderRows);
        }

        $dataInvoice = [
            'no_transaksi'      => $noTransaksi,
            'no_order'          => $noOrder,
            'no_meja'           => $noMeja,
            'tanggal'           => $tanggal,
            'qty'               => $qty,
            'subtotal'          => (float) ($input['subtotal'] ?? 0),
            'ppn_text'          => $ppnText,
            'ppn'               => $ppnAmount,
            'potongan_desc'     => ($discountText > 0 || $discount > 0) ? 'Discount' : '-',
            'discount'          => $discountText,
            'potongan'          => $discount,
            'amount_total'      => $amountTotal,
            'dibayar'           => $paidAmount,
            'kembalian'         => $kembalian,
            'metode'            => $metode,
            'reference_number'  => $referenceNo,
            'reference_payment' => $referencePay,
            'metode_service'    => $serviceMode,
            'created_at'        => $now,
            'created_by'        => $username,
        ];

        $dataInvoiceDetail = [];
        $newOrderRows      = [];

        foreach ($orderDetail as $row) {
            $harga = (float) ($row->harga ?? 0);
            $qtyRow = (int) ($row->qty ?? 0);

            if ($qtyRow <= 0) {
                continue;
            }

            $dataInvoiceDetail[] = [
                'no_transaksi' => $noTransaksi,
                'no_order'     => $noOrder,
                'no_meja'      => $noMeja,
                'tanggal'      => $tanggal,
                'kategori'     => $row->kategori,
                'nama'         => $row->nama,
                'harga'        => $harga,
                'qty'          => $qtyRow,
                'potongan'     => $row->potongan ?? 0,
                'discount'     => $row->discount ?? 0,
                'jenis'        => $row->jenis,
                'owner'        => $row->owner,
                'status'       => 4,
                'created_at'   => $now,
                'created_by'   => $username,
            ];

            if (empty($input['no_order'])) {
                $newOrderRows[] = [
                    'no_order'   => $noOrder,
                    'no_meja'    => $noMeja,
                    'tanggal'    => $tanggal,
                    'kategori'   => $row->kategori,
                    'nama'       => $row->nama,
                    'harga'      => $harga,
                    'qty'        => $qtyRow,
                    'potongan'   => 0,
                    'discount'   => 0,
                    'jenis'      => $row->jenis,
                    'owner'      => $row->owner,
                    'status'     => 4,
                    'user_id'    => $userId,
                    'created_at' => $now,
                    'updated_at' => $now,
                ];
            }
        }

        if (empty($dataInvoiceDetail)) {
            return $this->json_response([
                'status'  => 'error',
                'message' => 'Detail item takeaway tidak valid.',
            ], 422);
        }

        $this->db->trans_begin();

        if (empty($input['no_order'])) {
            $this->db->insert('order', [
                'no_order'   => $noOrder,
                'no_meja'    => $noMeja,
                'tanggal'    => $tanggal,
                'status'     => 4,
                'keterangan' => $this->build_order_meta('', 'Dibayar', $noTransaksi),
                'user_id'    => $userId,
                'created_at' => $now,
                'updated_at' => $now,
            ]);

            if (! empty($newOrderRows)) {
                $this->db->insert_batch('order_detail', $newOrderRows);
                $this->db->where('no_order', $noOrder)
                    ->where('no_meja', $noMeja)
                    ->delete('order_detail');
            }
        }

        $this->db->insert('invoice', $dataInvoice);

        if (! empty($dataInvoiceDetail)) {
            $this->db->insert_batch('invoice_detail', $dataInvoiceDetail);
        }

        if (! empty($input['no_order'])) {
            $this->db->where('no_order', $noOrder)
                ->where('no_meja', $noMeja)
                ->delete('order_detail');

            $this->db->where('no_order', $noOrder)
                ->where('no_meja', $noMeja)
                ->update('order', [
                    'status'     => 4,
                    'keterangan' => $this->build_order_meta($queueNumber, 'Dibayar', $noTransaksi),
                    'user_id'    => $userId,
                    'updated_at' => $now,
                ]);
        }

        if ($this->db->trans_status() === false) {
            $this->db->trans_rollback();

            return $this->json_response([
                'status'  => 'error',
                'message' => 'Transaksi takeaway gagal disimpan.',
            ], 500);
        }

        $this->db->trans_commit();

        return $this->json_response([
            'status'       => 'success',
            'message'      => 'Transaksi takeaway berhasil disimpan.',
            'no_order'     => $noOrder,
            'queue_no'     => $queueNumber ?: '-',
            'no_transaksi' => $noTransaksi,
        ]);
    }

    public function cancel_queue()
    {
        date_default_timezone_set("Asia/Jakarta");
        $input   = json_decode(file_get_contents("php://input"), true);
        $noOrder = trim($input['no_order'] ?? '');

        if ($noOrder === '') {
            return $this->json_response([
                'status'  => 'error',
                'message' => 'No order takeaway tidak ditemukan.',
            ], 422);
        }

        $orderRow = $this->db->where('no_order', $noOrder)
            ->where('no_meja', 'Takeaway')
            ->get('order')
            ->row();

        if (! $orderRow) {
            return $this->json_response([
                'status'  => 'error',
                'message' => 'Order takeaway tidak ditemukan.',
            ], 404);
        }

        if ((int) $orderRow->status === 4) {
            return $this->json_response([
                'status'  => 'error',
                'message' => 'Order takeaway yang sudah dibayar tidak bisa dibatalkan dari form ini.',
            ], 409);
        }

        $this->db->trans_begin();
        $this->db->where('no_order', $noOrder)->where('no_meja', 'Takeaway')->delete('order_detail');
        $this->db->where('no_order', $noOrder)->where('no_meja', 'Takeaway')->delete('mitra_order_notif');
        $meta = $this->parse_order_meta($orderRow->keterangan);
        $this->db->where('no_order', $noOrder)->where('no_meja', 'Takeaway')->update('order', [
            'status'     => 0,
            'keterangan' => $this->build_order_meta($meta['queue_no'], 'Dibatalkan', $meta['invoice_no']),
            'updated_at' => date('Y-m-d H:i:s'),
            'user_id'    => $this->session->userdata('user_id'),
        ]);

        if ($this->db->trans_status() === false) {
            $this->db->trans_rollback();

            return $this->json_response([
                'status'  => 'error',
                'message' => 'Gagal membatalkan antrian takeaway.',
            ], 500);
        }

        $this->db->trans_commit();

        return $this->json_response([
            'status'  => 'success',
            'message' => 'Antrian takeaway berhasil dibatalkan.',
        ]);
    }

    public function find_queue()
    {
        date_default_timezone_set("Asia/Jakarta");
        $input       = json_decode(file_get_contents("php://input"), true);
        $queueNumber = strtoupper(trim($input['queue_no'] ?? ''));

        if ($queueNumber === '') {
            return $this->json_response([
                'status'  => 'error',
                'message' => 'No antrian belum diisi.',
            ], 422);
        }

        $orders = $this->db->where('no_meja', 'Takeaway')
            ->where('status', 1)
            ->order_by('created_at', 'DESC')
            ->get('order')
            ->result();

        $selectedOrder = null;
        $selectedMeta  = null;

        foreach ($orders as $order) {
            $meta = $this->parse_order_meta($order->keterangan);
            if (strtoupper($meta['queue_no']) === $queueNumber) {
                $selectedOrder = $order;
                $selectedMeta  = $meta;
                break;
            }
        }

        if (! $selectedOrder) {
            return $this->json_response([
                'status'  => 'error',
                'message' => 'No antrian takeaway tidak ditemukan atau sudah dibayar.',
            ], 404);
        }

        $detail = $this->db->where('no_order', $selectedOrder->no_order)
            ->where('no_meja', 'Takeaway')
            ->get('order_detail')
            ->result();

        if (empty($detail)) {
            return $this->json_response([
                'status'  => 'error',
                'message' => 'Detail antrian takeaway tidak ditemukan.',
            ], 404);
        }

        $subtotal = 0;
        $qty      = 0;

        foreach ($detail as $row) {
            $subtotal += ((float) $row->harga * (int) $row->qty) - (float) ($row->potongan ?? 0);
            $qty      += (int) $row->qty;
        }

        return $this->json_response([
            'status'       => 'success',
            'message'      => 'Antrian takeaway ditemukan.',
            'no_order'     => $selectedOrder->no_order,
            'queue_no'     => $selectedMeta['queue_no'],
            'status_label' => $selectedMeta['status_label'],
            'invoice_no'   => $selectedMeta['invoice_no'],
            'created_at'   => $selectedOrder->created_at,
            'qty'          => $qty,
            'subtotal'     => $subtotal,
            'detail'       => $detail,
        ]);
    }

    private function generate_takeaway_order_number()
    {
        $tanggal = date('Y-m-d');
        $query   = $this->db->query(
            "SELECT MAX(RIGHT(no_order, 4)) AS KD_MAX
             FROM `order`
             WHERE tanggal = ?
             AND no_meja = ?
             AND no_order LIKE 'TAK%'",
            [$tanggal, 'Takeaway']
        );

        $no = "0001";
        if ($query->num_rows() > 0) {
            $row = $query->row();
            if (! empty($row->KD_MAX)) {
                $no = sprintf("%04s", ((int) $row->KD_MAX) + 1);
            }
        }

        return 'TAK' . date('ymd') . $no;
    }

    private function generate_takeaway_invoice_number()
    {
        $tanggal = date('Y-m-d');
        $query   = $this->db->query(
            "SELECT MAX(RIGHT(no_transaksi, 4)) AS KD_MAX
             FROM invoice
             WHERE tanggal = ?
             AND no_meja = ?
             AND no_transaksi LIKE 'TKI%'",
            [$tanggal, 'Takeaway']
        );

        $no = "0001";
        if ($query->num_rows() > 0) {
            $row = $query->row();
            if (! empty($row->KD_MAX)) {
                $no = sprintf("%04s", ((int) $row->KD_MAX) + 1);
            }
        }

        return 'TKI' . date('ymd') . $no;
    }

    private function generate_takeaway_queue_number()
    {
        $tanggal = date('Y-m-d');
        $query   = $this->db->query(
            "SELECT COUNT(*) AS total
             FROM `order`
             WHERE tanggal = ?
             AND no_meja = ?
             AND keterangan LIKE '%\"queue_no\":\"TA%'",
            [$tanggal, 'Takeaway']
        )->row();

        $next = ((int) ($query->total ?? 0)) + 1;
        return 'TA' . sprintf('%03d', $next);
    }

    private function map_input_order_to_objects($rows)
    {
        $result = [];

        foreach ($rows as $row) {
            $result[] = (object) [
                'kategori' => $row['kategori'] ?? '',
                'nama'     => $row['nama'] ?? '',
                'harga'    => (float) ($row['harga'] ?? 0),
                'qty'      => (int) ($row['qty'] ?? 0),
                'potongan' => 0,
                'discount' => 0,
                'jenis'    => $row['jenis'] ?? 'Menu',
                'owner'    => $row['owner'] ?? 'Owner',
            ];
        }

        return $result;
    }

    private function build_order_meta($queueNo, $statusLabel, $invoiceNo = '')
    {
        return json_encode([
            'service'      => 'Takeaway',
            'queue_no'     => $queueNo,
            'status_label' => $statusLabel,
            'invoice_no'   => $invoiceNo,
        ]);
    }

    private function parse_order_meta($rawMeta)
    {
        $default = [
            'service'      => 'Takeaway',
            'queue_no'     => '',
            'status_label' => '-',
            'invoice_no'   => '',
        ];

        if (! $rawMeta) {
            return $default;
        }

        $decoded = json_decode($rawMeta, true);
        if (! is_array($decoded)) {
            return $default;
        }

        return array_merge($default, $decoded);
    }

    private function json_response($data, $statusCode = 200)
    {
        return $this->output
            ->set_status_header($statusCode)
            ->set_content_type('application/json')
            ->set_output(json_encode($data));
    }
}
