<!DOCTYPE html>
<html lang="en">
<head>
<?php $this->load->view('admin/css'); ?>
</head>

<body>

<?php $this->load->view('admin/nav'); ?>
<?php $this->load->view('admin/apotek/menu'); ?>

<!-- Page container -->
<div class="page-container">

<!-- Page content -->
<div class="page-content">

<!-- Main content -->
<div class="content-wrapper">
<div class="content">

	<div class="panel pane-flat border-top-success border-top-lg">
		<div class="panel-heading">
			<h6 class="panel-title"><?= $title ?></h6>
		</div>

		<div class="panel-body">
			<div class="row">
				<div class="col-sm-12">

						<!-- message -->
						<?php if ($this->session->flashdata('status')): ?>
							<div class="alert alert-<?= $this->session->flashdata('status'); ?> no-border">
								<button type="button" class="close" data-dismiss="alert"><span>&times;</span><span class="sr-only">Close</span></button>
								<p class="message-text"><?= $this->session->flashdata('message'); ?></p>
							</div>
						<?php endif ?>
						<!-- message -->

						<div class="form-group">
							<div class="input-group">
								<span class="input-group-btn">
									<button class="btn bg-primary" type="button" onclick="tampil_modal_penjualan();"><i class="fa fa-search"></i></button>
								</span>
								<input type="text" class="form-control" autocomplete="off" placeholder="Cari Nota Penjualan" readonly="">
							</div>
						</div>
						<br>

						<!-- Modal Tampil Penjualan -->
						<div id="modal_tampil_penjualan" class="modal fade">
							<div class="modal-dialog modal-lg">
								<div class="modal-content">
									<div class="modal-header bg-primary">
										<button type="button" class="close" data-dismiss="modal">&times;</button>
										<h5 class="modal-title">Penjualan</h5>
									</div>

									<div class="modal-body">
										<div class="form-group">
											<div class="input-group">
												<input type="text" class="form-control" autocomplete="off" id="cari_nota_penjualan" onkeyup="get_penjualan()" placeholder="cari nota penjualan">
												<span class="input-group-btn">
													<button class="btn bg-primary" type="button" onclick="get_penjualan()"><i class="fa fa-search"></i></button>
												</span>
											</div>
										</div>	
										<div class="table-responsive">
											<table class="table table-bordered table-striped" id="table_penjualan">
												<thead>
													<tr class="bg-success">
														<th class="text-center">No</th>
														<th class="text-center">No Transaksi</th>
														<th class="text-center">Total Transaksi</th>
														<th class="text-center">Tanggal & Waktu</th>
													</tr>
												</thead>
												<tbody>
													
												</tbody>
											</table>
										</div>
										<br>
										<ul id="pagination-penjualan" class="pagination float-right">

										</ul>
									</div>
										
										
									<div class="modal-footer">
										<button class="btn btn-link" data-dismiss="modal"><i class="icon-cross"></i> Keluar</button>
									</div>
								</div>
							</div>
						</div>

						<!-- Modal Tampil Barang -->
						<div id="modal_tampil_barang" class="modal fade">
							<div class="modal-dialog modal-lg">
								<div class="modal-content">
									<div class="modal-header bg-primary">
										<button type="button" class="close" data-dismiss="modal">&times;</button>
										<h5 class="modal-title">Barang</h5>
									</div>

									<div class="modal-body">
										<div class="form-group">
											<div class="input-group">
												<input type="text" class="form-control" autocomplete="off" id="cari_barang_modal" onkeyup="get_barang()" placeholder="cari barang berdasarkan nama / kode barang">
												<span class="input-group-btn">
													<button class="btn bg-primary" type="button" onclick="get_barang()"><i class="fa fa-search"></i></button>
												</span>
											</div>
										</div>	
										<div class="table-responsive">
											<table class="table table-bordered table-striped" id="table_barang_modal">
												<thead>
													<tr class="bg-success">
														<th class="text-center">No</th>
														<th class="text-center">Kode Barang</th>
														<th class="text-center">Nama Barang</th>
														<th class="text-center">Harga Jual</th>
													</tr>
												</thead>
												<tbody>
													
												</tbody>
											</table>
										</div>
										<br>
										<ul id="pagination-barang" class="pagination float-right">

										</ul>
									</div>
										
										
									<div class="modal-footer">
										<button class="btn btn-link" data-dismiss="modal"><i class="icon-cross"></i> Keluar</button>
									</div>
								</div>
							</div>
						</div>
						
						<input type="hidden" id="input-num" value="0">
						<form action="<?= base_url('apotek/retur_penjualan/tambah_retur_penjualan') ?>" method="POST" class="form-horizontal">
							<div class="table-responsive">
								<table class="table table-bordered" id="table_barang">
									<thead>
										<tr class="bg-success">
											<th class="text-center">Kode Barang</th>
											<th class="text-center">Nama Barang</th>
											<th class="text-center">Jumlah Beli</th>
											<th class="text-center">Harga Jual</th>
											<th class="text-center">Aksi</th>
										</tr>
									</thead>
									
									<tbody>
									</tbody>

									<tfoot>
										<tr>
											<td class="text-center"><button class="btn btn-info btn-sm" onclick="tambah_row_barang()" type="button">Tambah Barang</button></td>
											<td colspan="2" class="text-right"><b>Total :</b> </td>
											<td class="text-right"><b id="total-transaksi"></b></td>
										</tr>
									</tfoot>
								</table>
								<br>
							</div>
							<br><br>

							<div class="form-group">
								<label class="control-label col-lg-2">Nilai Transaksi</label>
								<div class="col-lg-10">
									<div class="input-group">
										<span class="input-group-btn">
											<button class="btn btn-success btn-icon" type="button">Rp</button>
										</span>
										<input type="text" class="form-control" readonly id="input-nilai-transaksi" name="nilai_transaksi">
									</div>
								</div>
							</div>

							<div class="form-group">
								<label class="control-label col-lg-2">Dibayar</label>
								<div class="col-lg-10">
									<div class="input-group">
										<span class="input-group-btn">
											<button class="btn btn-success btn-icon" type="button">Rp</button>
										</span>
										<input type="text" class="form-control" id="input-dibayar" name="dibayar" onkeyup="FormatCurrency(this); hitung_kembalian()">
									</div>
								</div>
							</div>

							<div class="form-group">
								<label class="control-label col-lg-2">Kembali</label>
								<div class="col-lg-10">
									<div class="input-group">
										<span class="input-group-btn">
											<button class="btn btn-success btn-icon" type="button">Rp</button>
										</span>
										<input type="text" class="form-control" readonly id="input-kembali" name="kembali">
									</div>
								</div>
							</div>

							<div class="form-group">
								<label class="control-label col-lg-2">Keterangan</label>
								<div class="col-lg-10">
									<textarea name="keterangan" id="input-keterangan" cols="30" rows="5" class="form-control"></textarea>
								</div>
							</div>
							
							<button class="btn btn-lg btn-primary btn-block" id="btn_simpan" type="submit"><i class="icon-floppy-disk position-left"></i> Simpan</button>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
<?php $this->load->view('admin/js'); ?>
<script>
	let loading = `
					<tr class="tr-loading">
						<td colspan="3" id="td-loading">
							<div class="loader">
								<img src="<?= base_url('assets/images/svg-loader/svg-loaders/vectorpaint.svg') ?>" alt="">
							</div>
						</td>
					</tr>
				`
	$(`#btn_simpan`).prop('disabled', true);
	get_penjualan();

	function tampil_modal_penjualan() {
		$(`#modal_tampil_penjualan`).modal('toggle');
	}

	function get_penjualan() {
		let no_transaksi = $(`#cari_nota_penjualan`).val();
		let count_col = $(`#table_penjualan thead tr th`).length

		$.ajax({
			url : '<?= base_url('apotek/retur_penjualan/get_penjualan') ?>',
			data : {no_transaksi},
			method : 'POST',
			dataType : 'json',
			beforeSend : () => {
				$(`#table_penjualan tbody`).html(loading)
			},
			success : (res) => {
				let row = '';
				if(res.data.length > 0) {
					let i = 0;
					for(const item of res.data) {
						row += `
							<tr onclick="select_nota(${item.id}, '${item.nilai_transaksi}')" style="cursor: pointer">
								<td class="text-center">${++i}</td>
								<td class="text-center">${item.no_transaksi}</td>
								<td class="text-center">Rp. ${NumberToMoney(item.nilai_transaksi)}</td>
								<td class="text-center">${item.waktu} / ${item.tanggal}</td>
							</tr>
						`
					}
				} else {
					row += `
						<tr><td colspan="${count_col}" class="text-center">Data Penjualan Kosong</td></tr>
					`
				}

				$(`#table_penjualan tbody`).html(row);
				paging();
			},
			complete : () => {
				$(`#table_penjualan tbody .tr-loading`).fadeOut();
			}
		})
	}

	function paging($selector) {
    	var jumlah_tampil = '10';

        if(typeof $selector == 'undefined')
        {
            $selector = $("#table_penjualan tbody tr");
        }

        window.tp = new Pagination('#pagination', {
            itemsCount:$selector.length,
            pageSize : parseInt(jumlah_tampil),
            onPageSizeChange: function (ps) {
                console.log('changed to ' + ps);
            },
            onPageChange: function (paging) {
                //custom paging logic here
                //console.log(paging);
                var start = paging.pageSize * (paging.currentPage - 1),
                    end = start + paging.pageSize,
                    $rows = $selector;

                $rows.hide();

                for (var i = start; i < end; i++) {
                    $rows.eq(i).show();
                }
            }
        });
    }

	function select_nota(id, nilai_transaksi) {
		let count_col = $(`#table_barang thead tr th`).length

		$.ajax({
			url : '<?= base_url('apotek/retur_penjualan/get_penjualan_detail') ?>',
			data : {id},
			method : 'POST',
			dataType : 'json',
			beforeSend : () => {
				$(`#table_barang tbody`).html(loading)
			},
			success : (res) => {
				let row = '';
				if(res.data.length > 0) {
					let i = 0;
					for(const item of res.data) {
						row += `
						<tr class="tr_barang_${id}">
							<td class="text-center">
								${item.kode_barang}
								<input type="hidden" name="id_barang[]" value="${item.id}">
								<input type="hidden" name="nama_barang[]" value="${item.nama_barang}">
								<input type="hidden" name="kode_barang[]" value="${item.kode_barang}">
								<input type="hidden" name="jumlah_beli[]" value="${item.jumlah_beli}">
								<input type="hidden" name="harga_jual[]" value="${item.harga_jual}" class="harga-jual">
							</td>
							<td class="text-center">${item.nama_barang}</td>
							<td class="text-center">${item.jumlah_beli}</td>
							<td class="text-right">Rp. ${NumberToMoney(item.harga_jual)}</td>
							<td class="text-center">
								<button class="btn btn-danger" onclick="hapus_row(this)"><i class="icon-trash"></i></button>
							</td>
						</tr>
						`
					}
				} else {
					row += `
						<tr><td colspan="${count_col}" class="text-center">Data Barang Kosong</td></tr>
					`
				}

				$(`#table_barang tbody`).html(row);
				$(`#total-transaksi`).html(`Rp. ${NumberToMoney(nilai_transaksi)}`)
				paging();
			}
		})

		$(`#btn_simpan`).prop('disabled', false);
		$(``)
	}

	function tambah_row_barang() {
		let num = $(`#input-num`).val()
		num = parseInt(num) + 1
		let row = 	`<tr id="tr-barang-${num}">
						<td class="text-center">
							<input type="hidden" name="id_barang[]" id="input-id-barang-${num}">
							<div class="form-group">
								<input type="text" class="form-control text-center" name="kode_barang[]" id="input-kode-barang-${num}" readonly>
							</div>
						</td>
						<td class="text-center">
							<div class="form-group">
								<div class="input-group">
									<span class="input-group-btn">
										<button class="btn btn-success btn-icon" type="button" onclick="get_barang(${num})"><i class=" icon-search4"></i></button>
									</span>
									<input type="text" name="nama_barang[]" class="form-control" placeholder="Cari Barang Anda.." readonly id="input-nama-barang-${num}">
								</div>
							</div>
						</td>
						<td class="text-center">
							<div class="form-group">
								<input type="text" class="form-control" name="jumlah_beli[]" id="input-jumlah-beli-${num}" onkeyup="hitung_transaksi(${num})" value='1'>
							</div>
						</td>
						<td class="text-right">
							<span id="span-harga-jual-${num}"></span>
							<input type="hidden" class="form-control harga-jual" name="harga_jual[]" id="input-harga-jual-${num}" readonly>
							<input type="hidden" class="form-control" name="harga_jual_satuan[]" id="input-harga-jual-satuan-${num}" readonly>
						</td>
						<td class="text-center">
							<button class="btn btn-danger" onclick="hapus_row(this)"><i class="icon-trash"></i></button>
						</td>
					</tr>
		`

		$(`#table_barang tbody`).append(row);
		$(`#input-num`).val(num)
	}

	function get_barang(num) {
		let count_col = $(`#table_barang_modal thead tr th`).length
		$(`#modal_tampil_barang`).modal('toggle');

		$.ajax({
			url : '<?= base_url('apotek/retur_penjualan/get_barang') ?>',
			method : 'POST',
			dataType : 'json',
			beforeSend : () => {
				$(`#table_barang_modal tbody`).html(loading)
			},
			success : (res) => {
				let row = '';
				if(res.data.length > 0) {
					let i = 0;
					for(const item of res.data) {
						row += `
						<tr onclick="tambah_barang(${num}, ${item.id}, '${item.kode_barang}', '${item.nama_barang}', '${item.harga_jual}')" style="cursor: pointer;">
							<td class="text-center">${++i}</td>
							<td class="text-center">${item.kode_barang}</td>
							<td class="text-center">${item.nama_barang}</td>
							<td class="text-right">Rp. ${NumberToMoney(item.harga_jual)}</td>
						</tr>
						`
					}
				} else {
					row += `
						<tr><td colspan="${count_col}" class="text-center">Data Barang Kosong</td></tr>
					`
				}

				$(`#table_barang_modal tbody`).html(row);
				paging_barang();
			}
		})

		$(`#btn_simpan`).prop('disabled', false);
	}

	function paging_barang($selector) {
    	var jumlah_tampil = '10';

        if(typeof $selector == 'undefined')
        {
            $selector = $("#table_barang_modal tbody tr");
        }

        window.tp = new Pagination('#pagination-barang', {
            itemsCount:$selector.length,
            pageSize : parseInt(jumlah_tampil),
            onPageSizeChange: function (ps) {
                console.log('changed to ' + ps);
            },
            onPageChange: function (paging) {
                //custom paging logic here
                //console.log(paging);
                var start = paging.pageSize * (paging.currentPage - 1),
                    end = start + paging.pageSize,
                    $rows = $selector;

                $rows.hide();

                for (var i = start; i < end; i++) {
                    $rows.eq(i).show();
                }
            }
        });
    }

	function tambah_barang(num, id, kode_barang, nama_barang, harga_jual) {
		$(`#input-id-barang-${num}`).val(id)
		$(`#input-kode-barang-${num}`).val(kode_barang)
		$(`#input-nama-barang-${num}`).val(nama_barang)
		$(`#input-harga-jual-${num}`).val(harga_jual)
		$(`#span-harga-jual-${num}`).html('Rp. ' + NumberToMoney(harga_jual))
		$(`#input-harga-jual-satuan-${num}`).val(harga_jual)

		$(`#modal_tampil_barang`).modal('toggle');

		// MENGHITUNG TOTAL HARGA JUAL
		let total_harga_jual = 0
		$(`.harga-jual`).each((id, element) => {
			let value = element.value
			total_harga_jual += parseInt(value) 
		})

		$(`#input-nilai-transaksi`).val(NumberToMoney(total_harga_jual))
		$(`#total-transaksi`).html('Rp. ' + NumberToMoney(total_harga_jual))
	}

	function hitung_transaksi(num) {
		let jumlah_beli = $(`#input-jumlah-beli-${num}`).val() == '' ? 0 : $(`#input-jumlah-beli-${num}`).val()
		let harga_jual = $(`#input-harga-jual-satuan-${num}`).val()
		let total_harga_jual = 0

		let total_harga_jual_satuan = parseInt(jumlah_beli) * parseInt(harga_jual)
		$(`#input-harga-jual-${num}`).val(total_harga_jual_satuan)
		$(`#span-harga-jual-${num}`).html('Rp. ' + NumberToMoney(total_harga_jual_satuan))

		// MENGHITUNG TOTAL HARGA JUAL
		$(`.harga-jual`).each((id, element) => {
			let value = element.value
			total_harga_jual += parseInt(value) 
		})

		$(`#input-nilai-transaksi`).val(NumberToMoney(total_harga_jual))
		$(`#total-transaksi`).html('Rp. ' + NumberToMoney(total_harga_jual))
	}

	function hitung_kembalian() {
		let nilai_transaksi = $(`#input-nilai-transaksi`).val().split(',').join('')
		let dibayar = $(`#input-dibayar`).val().split(',').join('')

		let kembali = parseInt(dibayar) - parseInt(nilai_transaksi)
		$(`#input-kembali`).val(NumberToMoney(kembali))
	}

	function hapus_row(btn, num = null) {
		let row = btn.parentNode.parentNode;
 		row.parentNode.removeChild(row);

		if(num != null) {
			num = num - 1
			$(`#input-num`).val(num)
		}

 		let jumlah_row_barang = $(`#table_barang tbody tr`).length
		if(jumlah_row_barang == 0) {
			$(`#btn_simpan`).prop('disabled', true);
		}
	}

</script>

</div>
</div>
<!-- /main content -->

</div>
<!-- /page content -->

</div>
<!-- /page container -->
</body>
</html>
