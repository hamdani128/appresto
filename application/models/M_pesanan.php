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
                'Makanan' as jenis
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
                'Minuman' as jenis
                FROM minuman a
                LEFT JOIN kategori_minuman b ON a.kategori_id = b.id
                ";
        $query = $this->db->query($SQL)->result();
        return $query;
    }
}
