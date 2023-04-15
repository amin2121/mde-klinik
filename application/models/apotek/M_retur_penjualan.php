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

	public function get_barang($search)
	{
		// barang apotek
		return $this->db->query("
			SELECT * FROM apotek_barang
			WHERE nama_barang LIKE '%$search%'
			AND id_cabang = 3
		")->result_array();
	}

	public function tambah_penjualan($id_penjualan) {

		$id_user = $this->session->userdata('id_user');
		$id_barang_nota = $this->db->query("SELECT id_barang FROM apotek_penjualan_detail WHERE id_penjualan = '$id_penjualan'")->result_array();
		$id_barang = $this->input->post('id_barang');
		$cek_barang_baru = [];
	
		foreach ($id_barang as $key => $value_baru) {
		  $cek_barang_baru[$key] = $value_baru;
		}
	
		$cek_barang_nota = [];
		foreach ($id_barang_nota as $key => $value_nota) {
		  $cek_barang_nota[$key] = $value_nota['id_barang'];
		}
	
		$array_barang = array_diff($cek_barang_nota, $cek_barang_baru);
		$data_header = array(
		  'nilai_transaksi' => str_replace(',', '', $this->input->post('nilai_transaksi_retur')),
		  'nilai_laba' => str_replace(',', '', $this->input->post('nilai_laba_retur')),
		  'dibayar' => str_replace(',', '', $this->input->post('dibayar')),
		  'kembali' => str_replace(',', '', $this->input->post('kembali'))
		);
	
		$this->db->where('id', $id_penjualan);
		$this->db->update('penjualan', $data_header);

		$total_harga_barang_hapus = 0;
		$total_laba_barang_hapus = 0;
		// 1, 2, 3 - 4, 3, 2
	
		if (!empty(array_diff($cek_barang_nota, $cek_barang_baru))) {
		  foreach ($array_barang as $key => $value_barang) {
			$sqb = $this->db->query("SELECT * FROM penjualan_detail WHERE id_penjualan ='$id_penjualan' AND id_barang ='$value_barang' AND id_user ='$id_user'")->row_array();
			$jumlah_retur = $sqb['jumlah_beli'];
			$total_harga_barang_hapus += $sqb['total_harga_beli'];
			$total_laba_barang_hapus += $sqb['total_laba'];
			$this->db->query("UPDATE gudang SET stok = stok + $jumlah_retur WHERE id_barang = '$value_barang' AND id_user = '$id_user'");
	
		  }
	
		}
	
		$get_data_penjualan = $this->klik_penjualan($id_penjualan);
	
		$data_retur = array(
		  'no_nota' => $this->input->post('no_penjualan'),
		  'tanggal_retur' => date('d-m-Y'),
		  'waktu_retur' => date('H:i:s'),
		  'ket_retur' => $this->input->post('ket_retur'),
		  'total_harga' => $total_harga_barang_hapus,
		  'total_laba' => $total_laba_barang_hapus,
		  'kode_retur' => $this->get_kode_retur(),
		  'id_user' => $this->session->userdata('id_user'),
		  'id_kasir' => $get_data_penjualan['id_kasir'],
		  'bulan' => date('m'),
		  'tahun' => date('Y')
		);
	
		$this->db->insert('retur_penjualan', $data_retur);
		$id_retur = $this->db->insert_id();
	
		if(!empty($array_barang)) {
		  $data_retur_detail = [];
		  foreach ($array_barang as $row) {
			$get_penjualan_detail = $this->db->get_where('penjualan_detail', ['id_penjualan' => $id_penjualan, 'id_barang' => $row])->row_array();
			array_push($data_retur_detail, array(
			  'id_user' => $id_user,
			  'id_retur' => $id_retur,
			  'id_barang' => $row,
			  'kode_barang' => $get_penjualan_detail['kode_barang'],
			  'nama_barang' => $get_penjualan_detail['nama_barang'],
			  'jumlah_retur' => $get_penjualan_detail['jumlah_beli'],
			  'total_harga_beli' => $get_penjualan_detail['total_harga_beli'],
			  'total_laba' => $get_penjualan_detail['total_laba']
			));
		  }
	
		  $this->db->insert_batch('retur_penjualan_detail', $data_retur_detail);
		}
	
		$this->db->where('id_penjualan', $id_penjualan);
		$this->db->delete('penjualan_detail');
	
		$update = '';
	
		foreach ($id_barang as $key => $value) {
		  $data = array(
			'id_user' => $this->session->userdata('id_user'),
			'id_kasir' => $this->session->userdata('id_kasir'),
			'id_penjualan' => $id_penjualan,
			'id_barang' => $value,
			'harga_jual' => $this->input->post('harga_jual')[$key],
			'total_harga_beli' => $this->input->post('total_harga_beli')[$key],
			'laba' => $this->input->post('laba')[$key],
			'total_laba' => $this->input->post('total_laba')[$key],
			'jumlah_beli' => $this->input->post('jumlah_beli')[$key],
			'status_diskon' => 0,
			'diskon' => 0,
			'tanggal' => date('d-m-Y'),
			'waktu' => date('H:i:s'),
			'kode_barang' => $this->input->post('kode_barang')[$key],
			'nama_barang' => $this->input->post('nama_barang')[$key]
		  );
	
		  $this->db->insert('penjualan_detail', $data);
	
		  if(!in_array($value, $cek_barang_nota)) {
			$jumlah_beli = $this->input->post('jumlah_beli')[$key];
			$update = $this->db->query("UPDATE gudang SET stok = stok - $jumlah_beli WHERE id_barang = '$value' AND id_user = '$id_user'");
		  }
		}
	
		return $update;
	
	  }

	public function get_kode_retur() {

		$this->db->select('RIGHT(retur_penjualan.kode_retur,4) as kode, retur_penjualan.id_user', FALSE);
	
		$this->db->where('id_user', $this->session->userdata('id_user'));
	
		$this->db->order_by('kode_retur','DESC');
	
		$this->db->limit(1);
	
		$query = $this->db->get('retur_penjualan');
		//cek dulu apakah ada sudah ada kode di tabel.
	
		if($query->num_rows() <> 0){
	
		  //jika kode ternyata sudah ada.
	
		  $data = $query->row();
	
		  $kode = intval($data->kode) + 1;
	
		} else {
	
		  $kode = 1;
	
		}
	
		$kodemax = str_pad($kode, 4, "0", STR_PAD_LEFT); // angka 4 menunjukkan jumlah digit angka 0
	
		$tanggal = date('dmy');
		$kodejadi = "REP".$kodemax;    // hasilnya ODJ-9921-0001 dst.
	
		return $kodejadi;
	}
}