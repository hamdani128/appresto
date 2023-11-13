<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Kasir extends CI_Controller
{

    public function getdata_meja()
    {
        $query = $this->db->get("daftar_meja")->result();
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($query));
    }

    public function get_nomor_meja($no_meja)
    {
        $SQL = "SELECT MAX(RIGHT(kode_transaksi,5)) as KD_MAX FROM transaksi";
        $query = $this->db->query($SQL);
        if ($query->num_rows() > 0) {
            $row = $query->row();
            $n = ((int) $row->KD_MAX) + 1;
            $no = sprintf("%04s", $n);
        } else {
            $no = "00001";
        }
        $kode = '#BK' . date('ymd') . $no_meja . $no;
        // return $kode;
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($kode));
    }
}
