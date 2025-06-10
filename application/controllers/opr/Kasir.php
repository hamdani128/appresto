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

    public function get_number_order()
    {
        date_default_timezone_set("Asia/Jakarta");
        $SQL = "SELECT MAX(RIGHT(no_order,5)) as KD_MAX FROM `order` WHERE tanggal = '" . date('Y-m-d') . "'";
        $query = $this->db->query($SQL);
        if ($query->num_rows() > 0) {
            $row = $query->row();
            $n = ((int) $row->KD_MAX) + 1;
            $no = sprintf("%04s", $n);
        } else {
            $no = "00001";
        }
        $kode = '#BK' . date('ymd') . $no;
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($kode));
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

    public function cek_subtotal_transaksi()
    {
        $input = json_decode(file_get_contents("php://input"), true);
        $no_booking = $input['no_booking'];
        $total = $this->M_pesanan->TotalTransaksiByOrder($no_booking);
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($total));
    }

}
