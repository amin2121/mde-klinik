<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_retur_penjualan extends CI_Model {

	public function get_penjualan($no_transaksi = '')
	{
		return $this->db->query("
			SELECT * FROM apotek_penjualan
			WHERE no_transaksi LIKE '%$no_transaksi%'
			LIMIT 50
		")->result_array();
	}

	public function get_penjualan_detail($id_penjualan)
	{
		return $this->db->query("
			SELECT * FROM apotek_penjualan_detail
			WHERE id_penjualan = $id_penjualan
		")->result_array();
	}

	public function get_barang()
	{
		return $this->db->query("
			SELECT * FROM apotek_barang
		")->result_array();
	}
}

/* End of file M_retur_penjualan.php */
/* Location: ./application/models/M_retur_penjualan.php */