<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Retur_penjualan extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('apotek/M_retur_penjualan', 'model');
	}

	public function index()
	{
		if (!$this->session->userdata('logged_in')) {
    		redirect('auth');
    	}

		$data['title'] = 'Retur Penjualan';
		$data['menu'] = 'apotek';

		$this->load->view('admin/apotek/retur_penjualan', $data);
	}

	public function get_penjualan()
	{
		$no_transaksi = $this->input->post('no_transaksi');
		$data = $this->model->get_penjualan($no_transaksi);
		echo json_encode(['data' => $data]);
	}

	public function get_penjualan_detail()
	{
		$id = $this->input->post('id');
		$data = $this->model->get_penjualan_detail($id);
		echo json_encode(['data' => $data]);
	}

	public function get_barang()
	{
		$search = $this->input->post('search');
		$data = $this->model->get_barang($search);
		echo json_encode(['data' => $data]);
	}
}

/* End of file Retur_penjualan.php */
/* Location: ./application/controllers/Retur_penjualan.php */