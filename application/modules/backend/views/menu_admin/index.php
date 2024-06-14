<div class="card shadow radius-10">
	<div class="card-header bg-light">
		<div class="row">
			<div class="col-md-6">
				<button type="button" id="btn_add" class="btn btn-primary btn-block btn-sm"><i class="bx bx-plus-circle"></i> Tambah Data</button>
				<button type="button" id="btn_reload" class="btn btn-secondary btn-block btn-sm"><i class="bx bx-sync"></i> Refresh Data</button>
			</div>
			<div class="col-md-6">
				<div class="custom-search">
					<input type="text" class="form-search" id="keyword_search" placeholder="Parameter Search...">
				</div>
			</div>
		</div>
	</div>
	<div class="card-body">
		<div class="row">
			<div class="col-md-12">
				<div class="table-responsive">
					<table id="table_list" class="table table-striped table-hover table-sm">
						<thead>
							<tr>
								<th class="center" width="5%">No.</th>
								<th width="40%">Nama Menu</th>
								<th width="20%">Path</th>
								<th class="center" width="5%">Position</th>
								<th class="center" width="20%">Icon</th>
								<th widht="5%"></th>
							</tr>
						</thead>
						<tbody></tbody>
					</table>
				</div>
			</div>
		</div>
		<div class="row">
			<input type="hidden" id="page_list">
			<div class="col-sm-12 col-md-5">
				<div id="summary"></div>
			</div>
			<div class="col-sm-12 col-md-7">
				<div id="pagination"></div>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="modal_form" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<?php echo form_open_multipart('', 'id="form_add"') ?>
			<div class="modal-header">
				<h5 class="modal-title" id="modal_form_label">Form Tambah Data</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<input type="hidden" name="id" class="validate">
				<input type="hidden" name="id_parent" class="validate">
				<div class="form-group row mb-2">
					<label class="form-label bold right col-md-3">Nama Menu <span class="text-danger">*)</span></label>
					<div class="col-md-9">
						<input type="text" name="name" class="form-control validate" placeholder="Nama Menu ...">
					</div>
				</div>
				<div class="form-group row mb-2">
					<label class="form-label bold right col-md-3">Path <span class="text-danger">*)</span></label>
					<div class="col-md-9">
						<div class="input-group">
							<span class="input-group-text"><?php echo site_url('eo/') ?></span>
							<input type="text" name="path" class="form-control validate" placeholder="Path ...">
						</div>
					</div>
				</div>
				<div class="form-group row mb-2 icon_parent">
					<label class="form-label bold right col-md-3">Icon</label>
					<div class="col-md-9">
						<div class="input-group">
							<button class="btn btn-primary search_boxicons" type="button"><i class="bx bx-search-alt"></i> Cari Icon</button>
							<span class="input-group-text"><i id="icon_boxicons"></i></span>
							<input type="text" name="icon" class="form-control input_boxicons validate" placeholder="Icon ...">
						</div>
					</div>
				</div>
				<div class="form-group row mb-2">
					<label class="form-label bold right col-md-3">Position</label>
					<div class="col-md-9">
						<input type="number" min="1" name="position" class="form-control validate" placeholder="Index Urutan / Posisi ...">
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal"><i class="bx bx-x-circle"></i> Batal</button>
				<button type="submit" class="btn btn-primary btn-sm"><i class="bx bx-save"></i> Simpan</button>
			</div>
			<?php echo form_close() ?>
		</div>
	</div>
</div>
<?php $this->load->view('backend/boxicons/index') ?>

<link rel="stylesheet" href="public/assets/clouds/css/jquery.treetable.css">
<link rel="stylesheet" href="public/assets/clouds/css/jquery.treetable.theme.css">
<script src="public/assets/clouds/js/jquery.treetable.js"></script>

<script>
	var tipeData = 'list';
	var methodName = 'eo/menu-admin';

	$(function() {
		getListData(1)

		$('#keyword_search').keyup(function() {
			if ($(this).val() !== '') {
				tipeData = 'search';
			} else {
				tipeData = 'list';
			}
			getListData(1)
		})

		$('#btn_add').click(function() {
			resetForm()
			$('#modal_form').modal('show')
			$('#modal_form_label').text('Form Tambah Data')
		})

		$('#btn_reload').click(function() {
			tipeData = 'list';
			resetForm()
			getListData(1)
		})

		$('#form_add').submit(function(e) {
			e.preventDefault()

			var text = 'Apakah anda yakin ingin menyimpan data ini?';
			var id = $('[name="id"]').val()
			if (id !== '') {
				text = 'Apakah anda yakin ingin mengubah data ini?';
			}

			Swal.fire({
				title: 'Konfirmasi',
				text: text,
				icon: 'question',
				showCancelButton: true,
				confirmButtonColor: '#673ab7',
				cancelButtonColor: '#6c757d',
				cancelButtonText: '<i class="bx bx-x-circle"></i> Tutup',
				confirmButtonText: '<i class="bx bx-paper-plane"></i> Ya',
				allowOutsideClick: false,
				reverseButtons: true,
			}).then((result) => {
				if (result.isConfirmed) {
					var data = new FormData($(this)[0])
					$.ajax({
						type: 'POST',
						url: baseUrl + methodName + '/store',
						data: data,
						cache: false,
						contentType: false,
						processData: false,
						dataType: 'JSON',
						beforeSend: function() {
							showLoader()
						},
						success: function(data) {
							$('[name="'+csrfName+'"]').val(data._token);

							if (data.validasi == false) {
								syamValidationServer('[name="name"]', 'name', data)
								syamValidationServer('[name="path"]', 'path', data)
								return false;
							}

							if (data.status) {
								$('#modal_form').modal('hide')
								resetForm()
								getListData($('#page_list').val())
								toastrAlert('success', 'Berhasil', data.message)
							} else {
								toastrAlert('warning', 'Validasi', data.message)
							}
						},
						complete: function() {
							hideLoader()
						},
						error: function(e) {
							toastrAlert('error', e.status, e.statusText)
						}
					})
				}
			})
		})

		$('.validate').keyup(function() {
			if ($(this).val() !== '') {
				syamValidationRemove(this)
			}
		})

		$('.validate').change(function() {
			if ($(this).val() !== '') {
				syamValidationRemove(this)
			}
		})
	})

	function getListData(page) {
		$.ajax({
			type: 'GET',
			url: baseUrl + methodName + '/list',
			data: 'page=' + page + '&keyword=' + $('#keyword_search').val() + '&tipedata=' + tipeData,
			cache: false,
			dataType: 'JSON',
			beforeSend: function() {
				showLoader()
				$('#page_list').val(page)
			},
			success: function(data) {
				if ((page > 1) && (data.data.length == 0)) {
					getListData(page - 1)
					return false
				}

				$('#pagination').html(paginationJump(data.jumlah, data.limit, data.page, 1))
				$('#summary').html(pageSummary(data.jumlah, data.data.length, data.limit, data.page))

				$('#table_list tbody').empty()
				if (tipeData === 'list') {
					$('#table_list').treetable('destroy')
					extractData(data)
					$('#table_list').treetable('expandAll')
				} else {
					showListData(data)
				}
			},
			complete: function() {
				hideLoader()
			},
			error: function(e) {
				toastrAlert('error', e.status, e.statusText)
			}
		})
	}

	function paging(page) {
		getListData(page)
	}

	function resetForm() {
		$('#form_add')[0].reset()
		$('#icon_boxicons').removeClass()
		$('.validate, #keyword_search').val('')
		syamValidationRemove('.form-control')
	}

	function showListData(data) {
		var html = '';
		$.each(data.data, function(i, v) {
			var no = ((i + 1) + ((data.page - 1) * data.limit))
			html = '<tr>' +
				'<td class="center">' + no + '</td>' +
				'<td>' + v.name + '</td>' +
				'<td>' + v.url + '</td>' +
				'<td>' + v.url + '</td>' +
				'<td class="center"><i class="' + v.icon + '"></i></td>' +
				'<td class="right nowrap">' +
				'<button type="button" class="btn btn-light btn-sm"><i class="bx bx-edit"></i></button>' +
				'<button type="button" class="btn btn-light btn-sm"><i class="bx bx-trash"></i></button>' +
				'</td>' +
				'</tr>';
			$('#table_list tbody').append(html)
		})
	}

	function extractData(data) {
		var html = '';
		var branch = '';
		var parent = '';
		var root = '';
		var no = '';

		$.each(data.data, function(i, v) {
			no = ((i + 1) + ((data.page - 1) * data.limit))
			root = ((i + 1) + ((data.page - 1) * data.limit))
			branch = 'data-tt-id="' + root + '"';
			html = drawTable(v, no, branch, parent, data.page, 0)
			$('#table_list tbody').append(html)

			if (v.child !== null) {
				$.each(v.child, function(i2, v2) {
					no = ((i2 + 1) + ((data.page - 1) * data.limit))
					branch = 'data-tt-id="' + root + '-' + i2 + '"';
					parent = 'data-tt-parent-id="' + root + '"';
					html = drawTable(v2, no, branch, parent, data.page, 20)
					$('#table_list tbody').append(html)

					if (v2.child !== null) {
						$.each(v2.child, function(i3, v3) {
							branch = 'data-tt-id="' + root + '-' + i2 + '-' + i3 + '"';
							parent = 'data-tt-parent-id="' + root + '-' + i2 + '"';
							html = drawTable(v3, '', branch, parent, data.page, 50)
							$('#table_list tbody').append(html)
						})
					}
				})
			}

			branch = '';
			parent = '';
		})

		$('#table_list').treetable({
			expandable: true
		})
	}

	function drawTable(v, no, branch, parent, page, indent) {
		var btn = '';
		var btn_add = '';

		if (no !== '') {
			btn_add = '<button type="button" class="btn btn-primary btn-sm" onclick="addSubMenu(' + v.id + ',' + '\'' + v.name + '\'' + ',' + page + ')" title="Klik untuk menambah sub menu"><i class="bx bx-plus-circle"></i></button> ';
		}

		if (v.id !== '') {
			btn = '<button type="button" class="btn btn-success btn-sm" onclick="editData(' + v.id + ', ' + page + ')" title="Klik untuk menambah mengubah"><i class="bx bx-edit"></i></button> ' +
				'<button type="button" class="btn btn-danger btn-sm" onclick="deleteData(' + v.id + ', ' + page + ')" title="Klik untuk menghapus sub menu"><i class="bx bx-trash"></i></button> ';
		}

		var html = '<tr ' + branch + ' ' + parent + '>' +
			'<td class="nowrap">' + no + '</td>' +
			'<td class="nowrap"><span style="margin-left: ' + indent + 'px">' + v.name + '</span></td>' +
			'<td class="nowrap">' + v.url + '</td>' +
			'<td class="center">' + v.position + '</td>' +
			'<td class="center"><i class="' + v.icon + '"></i></td>' +
			'<td class="right nowrap">' + btn_add + btn + '</td>' +
			'</tr>';
		return html;
	}

	function editData(id, page) {
		$.ajax({
			type: 'GET',
			url: baseUrl + methodName + '/show',
			data: 'id=' + id,
			cache: false,
			dataType: 'JSON',
			beforeSend: function() {
				showLoader()
				$('#page_list').val(page)
			},
			success: function(data) {
				if (data) {
					$('[name="id"]').val(data.id)
					$('[name="id_parent"]').val(data.id_parent)

					$('[name="name"]').val(data.name)
					$('[name="path"]').val(data.url)

					$('[name="icon"]').val(data.icon)
					$('#icon_boxicons').removeClass()
					$('#icon_boxicons').addClass(data.icon)

					$('[name="position"]').val(data.position)

					$('#modal_form').modal('show')
					$('#modal_form_label').text('Form Ubah Data')
				}
			},
			complete: function() {
				hideLoader()
			},
			error: function(e) {
				toastrAlert('error', e.status, e.statusText)
			}
		})
	}

	function deleteData(id, page) {
		Swal.fire({
			title: 'Konfirmasi',
			text: 'Apakah anda yakin ingin mengapus data ini?',
			icon: 'question',
			showCancelButton: true,
			confirmButtonColor: '#673ab7',
			cancelButtonColor: '#6c757d',
			cancelButtonText: '<i class="bx bx-x-circle"></i> Tutup',
			confirmButtonText: '<i class="bx bx-paper-plane"></i> Ya',
			allowOutsideClick: false,
			reverseButtons: true,
		}).then((result) => {
			if (result.isConfirmed) {
				$.ajax({
					type: 'POST',
					url: baseUrl + methodName + '/destroy',
					data: {
						id: id,
						csrf_token_fms : $('[name="'+csrfName+'"]').val(),
					},
					cache: false,
					dataType: 'JSON',
					beforeSend: function() {
						showLoader()
					},
					success: function(data) {
						if (data.status) {
							getListData(page)
							toastrAlert('success', 'Berhasil', data.message)
						} else {
							toastrAlert('warning', 'Validasi', data.message)
						}
					},
					complete: function() {
						hideLoader()
					},
					error: function(e) {
						toastrAlert('error', e.status, e.statusText)
					}
				})
			}
		})
	}

	function addSubMenu(id, name, page) {
		resetForm()
		$('[name="id_parent"]').val(id)
		$('#modal_form').modal('show')
		$('#modal_form_label').text('Form Tambah Sub ' + name)
	}
</script>