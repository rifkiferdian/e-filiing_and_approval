<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Chart extends CI_Controller
{
    // public function __construct()
    // {
    //     parent::__construct();
    //     $this->load->library('form_validation');
    // }

    public function get_data_mutasi_surat()
    {
        $tahun = $this->_get_tahun_filter();
        $bulan = array(
            1 => 'Januari',
            2 => 'Februari',
            3 => 'Maret',
            4 => 'April',
            5 => 'Mei',
            6 => 'Juni',
            7 => 'Juli',
            8 => 'Agustus',
            9 => 'September',
            10 => 'Oktober',
            11 => 'November',
            12 => 'Desember'
        );
        $data = array(
            'periode' => array_values($bulan),
            'surat_masuk' => array_fill(0, 12, 0),
            'surat_keluar' => array_fill(0, 12, 0)
        );

        $this->db->select("MONTH(tanggal_surat) bulan, count(id) jumlah");
        $this->db->where("YEAR(tanggal_surat)", $tahun);
        $this->db->group_by("MONTH(tanggal_surat)");
        $surat_masuk = $this->db->get("tbl_surat_masuk")->result_array();

        $this->db->select("MONTH(tanggal_surat) bulan, count(id) jumlah");
        $this->db->where("YEAR(tanggal_surat)", $tahun);
        $this->db->group_by("MONTH(tanggal_surat)");
        $surat_keluar = $this->db->get("tbl_surat_keluar")->result_array();

        foreach ($surat_masuk as $value_masuk) {
            $index = (int) $value_masuk['bulan'] - 1;
            $data['surat_masuk'][$index] = (int) $value_masuk['jumlah'];
        }

        foreach ($surat_keluar as $value_keluar) {
            $index = (int) $value_keluar['bulan'] - 1;
            $data['surat_keluar'][$index] = (int) $value_keluar['jumlah'];
        }

        echo json_encode($data);
    }

    public function get_data_prosentase_surat()
    {
        $tahun = $this->_get_tahun_filter();

        $this->db->where("YEAR(tanggal_surat)", $tahun);
        $surat_masuk = $this->db->count_all_results("tbl_surat_masuk");

        $this->db->where("YEAR(tanggal_surat)", $tahun);
        $surat_keluar = $this->db->count_all_results("tbl_surat_keluar");

        $data = array(
            'jumlah' => array((int) $surat_masuk, (int) $surat_keluar)
        );

        echo json_encode($data);
    }

    private function _get_tahun_filter()
    {
        $tahun = (int) $this->input->post('tahun');
        return $tahun > 0 ? $tahun : (int) date('Y');
    }
}
