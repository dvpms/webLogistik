<div class="card shadow radius-10">
	<div class="card-header card-light">
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
								<th class="center" width="5%">ID</th>
								<th class="center" width="20%">Tanggal</th>
								<th width="70%">Nama Group</th>
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
	<div class="modal-dialog">
		<div class="modal-content">
			<?php echo form_open_multipart('', 'id="form_add"') ?>
			<div class="modal-header">
				<h5 class="modal-title" id="modal_form_label">Form Tambah Data & Setting Permission</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<input type="hidden" name="id" class="validate">
				<div class="form-group mb-2">
					<label class="form-label bold">Nama Group <span class="text-danger">*)</span></label>
					<input type="text" name="name" class="form-control validate" placeholder="Nama Menu ...">
				</div>

				<!-- privileges list -->
				<div id="privileges_area"></div>
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

<link rel="stylesheet" href="<?php echo base_url('assets/clouds/css/jquery.treetable.css') ?>">
<link rel="stylesheet" href="<?php echo base_url('assets/clouds/css/jquery.treetable.theme.css') ?>">
<script src="<?php echo base_url('assets/clouds/js/jquery.treetable.js') ?>"></script>

<script>
	var methodName = 'eo/role-permissions';

	$(function() {
		getListData(1)

		$('#keyword_search').keyup(function() {
			getListData(1)
		})

		$('#btn_add').click(function() {
			resetForm()
			getListDataPrivileges()
			$('#modal_form').modal('show')
			$('#modal_form_label').text('Form Tambah Data & Setting Permission')
		})

		$('#btn_reload').click(function() {
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
								return false;
							}

							if (data.status) {
								$('#modal_form').modal('hide')
								resetForm()
								getListData($('#page_list').val())
								toastrAlert('success', 'Berhasil', data.message)
								setTimeout(location.reload(), 6000)
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
			data: 'page=' + page + '&keyword=' + $('#keyword_search').val(),
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
				$.each(data.data, function(i, v) {
					var no = ((i + 1) + ((data.page - 1) * data.limit))
					var html = '<tr>' +
						'<td class="center">' + no + '</td>' +
						'<td class="center">' + v.id + '</td>' +
						'<td class="center">' + dateTimeInd(v.created_date) + '</td>' +
						'<td>' + v.name + '</td>' +
						'<td class="right nowrap">' +
						'<button type="button" class="btn btn-success btn-sm" onclick="editData(' + v.id + ', ' + data.page + ')"><i class="bx bx-edit"></i></button> ' +
						'<button type="button" class="btn btn-danger btn-sm" onclick="deleteData(' + v.id + ', ' + data.page + ')"><i class="bx bx-trash"></i></button>' +
						'</td>' +
						'</tr>';

					$('#table_list tbody').append(html)
				})
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
					$('[name="name"]').val(data.name)

					getListDataPrivileges(data.id)
					$('#modal_form').modal('show')
					$('#modal_form_label').text('Form Ubah Data & Setting Permission')
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

	function getListDataPrivileges(id = '') {
		$.ajax({
			type: 'GET',
			url: baseUrl + methodName + '/list_privileges',
			data: 'id=' + id,
			cache: false,
			dataType: 'JSON',
			beforeSend: function() {
				$('#privileges_area').html(pleaseWait())
			},
			success: function(data) {
				var html = `
					<div class="row mb-2">
						<div class="col-md-12">
							<button type="button" style="font-size:12px" class="btn btn-primary btn-sm btn-block" onclick="checkAll()"><i class="bx bx-checkbox-checked"></i> Check All</button>
							<button type="button" style="font-size:12px" class="btn btn-danger btn-sm btn-block" onclick="unCheckAll()"><i class="bx bx-checkbox"></i> Uncheck All</button>
						</div>
					</div>
					<div class="table-responsive">
						<table id="table_privileges" class="table table-striped table-hover table-sm">
							<thead>
								<tr>
									<th>All Menus</th>
								</tr>
							</thead>
							<tbody></tbody>
						</table>
					</div>
				`;

				$('#privileges_area').html(html)
				$('#table_privileges tbody').empty()

				if (id == '' || id == null || id == undefined) {
					var list = `<tr><td><ul class="tree mt-2" id="tree">`;
					for (let i = 0; i < data.all_menus.length; i++) {
						if (data.all_menus[i].id_parent == null) {
							list += `
								<li class="form-check" style="padding:3px 0.5rem">
									<input type="checkbox" name="id_menu[]" id="check_menu_${i}" onclick="checkParent(this)" value="${data.all_menus[i].id}" class="form-check-input check me-1 mb-1">
									<label class="form-check-label" for="check_menu_${i}"><b><i class="${data.all_menus[i].icon}"></i>&nbsp;&nbsp;${data.all_menus[i].name}</b></label>
									<ul style="padding-left:0.9rem">`;
							for (let j = 0; j < data.all_menus.length; j++) {
								if (data.all_menus[j].id_parent == data.all_menus[i].id) {
									list += `
													<li class="form-check" style="padding:3px 0.5rem">
														<input type="checkbox" name="id_menu[]" id="check_menu_${j}" onclick="checkParent(this)" value="${data.all_menus[j].id}" class="form-check-input check me-1 mb-1">
														<label class="form-check-label" for="check_menu_${j}"><i class="${(data.all_menus[j].icon !== '' ? data.all_menus[j].icon : 'bx bx-right-arrow-alt')}"></i>&nbsp;&nbsp;${data.all_menus[j].name}</label>
														<ul style="padding-left:0.9rem">`;
									for (let k = 0; k < data.all_menus.length; k++) {
										if (data.all_menus[k].id_parent == data.all_menus[j].id) {
											list += `<li class="form-check" style="padding:3px 0.5rem">
																			<input type="checkbox" name="id_menu[]" id="check_menu_${k}" onclick="checkParent(this)" value="${data.all_menus[k].id}" class="form-check-input check me-1 mb-1">
																			<label class="form-check-label" for="check_menu_${k}"><i class="${(data.all_menus[k].icon !== '' ? data.all_menus[k].icon : 'bx bx-right-arrow-alt')}"></i>&nbsp;&nbsp;${data.all_menus[k].name}</label>
																		</li>`;
										}
									}
									list += `</ul>
													</li>`;
								}
							}
							list += `</ul>
								</li>`;
						}
					}
					list + `</ul></td></tr>`;
					$('#table_privileges tbody').append(list)
				} else {
					var list = `<tr><td><ul class="tree mt-2" id="tree">`;
					for (let i = 0; i < data.all_menus.length; i++) {
						if (data.all_menus[i].id_parent == null) {
							var checked = '';
							for (let isub = 0; isub < data.all_menus_by_group.length; isub++) {
								if (data.all_menus[i].id == data.all_menus_by_group[isub].id) {
									checked = 'checked="checked"';
								}
							}
							list += `
								<li class="form-check" style="padding:3px 0.5rem">
									<input type="checkbox" name="id_menu[]" id="check_menu_${i}" onclick="checkParent(this)" value="${data.all_menus[i].id}" class="form-check-input check me-1 mb-1" ${checked}>
									<label class="form-check-label" for="check_menu_${i}"><b><i class="${data.all_menus[i].icon}"></i>&nbsp;&nbsp;${data.all_menus[i].name}</b></label>
									<ul style="padding-left:0.9rem">`;
							for (let j = 0; j < data.all_menus.length; j++) {
								if (data.all_menus[j].id_parent == data.all_menus[i].id) {
									var checked = '';
									for (let jsub = 0; jsub < data.all_menus_by_group.length; jsub++) {
										if (data.all_menus[j].id == data.all_menus_by_group[jsub].id) {
											checked = 'checked="checked"';
										}
									}
									list += `
													<li class="form-check" style="padding:3px 0.5rem">
														<input type="checkbox" name="id_menu[]" id="check_menu_${j}" onclick="checkParent(this)" value="${data.all_menus[j].id}" class="form-check-input check me-1 mb-1" ${checked}>
														<label class="form-check-label" for="check_menu_${j}"><i class="${(data.all_menus[j].icon !== '' ? data.all_menus[j].icon : 'bx bx-right-arrow-alt')}"></i>&nbsp;&nbsp;${data.all_menus[j].name}</label>
														<ul style="padding-left:0.9rem">`;
									for (let k = 0; k < data.all_menus.length; k++) {
										if (data.all_menus[k].id_parent == data.all_menus[j].id) {
											var checked = '';
											for (let ksub = 0; ksub < data.all_menus_by_group.length; ksub++) {
												if (data.all_menus[k].id == data.all_menus_by_group[ksub].id) {
													checked = 'checked="checked"';
												}
											}
											list += `
																		<li class="form-check" style="padding:3px 0.5rem">
																			<input type="checkbox" name="id_menu[]" id="check_menu_${k}" onclick="checkParent(this)" value="${data.all_menus[k].id}" class="form-check-input check me-1 mb-1" ${checked}>
																			<label class="form-check-label" for="check_menu_${k}"><i class="${(data.all_menus[k].icon !== '' ? data.all_menus[k].icon : 'bx bx-right-arrow-alt')}"></i>&nbsp;&nbsp;${data.all_menus[k].name}</label>
																		</li>
																	`;
										}
									}

									list += `</ul>
													</li>
												`;
								}
							}
							list += `</ul>
								</li>`;
						}
					}
					list + `</ul></td></tr>`;
					$('#table_privileges tbody').append(list)
				}
			},
			complete: function() {

			},
			error: function(e) {
				toastrAlert('error', e.status, e.statusText)
			}
		})
	}

	function checkAll() {
		$('.check').each(function() {
			$(this).attr('checked', 'checked')
		})
	}

	function unCheckAll() {
		$('.check').each(function() {
			$(this).removeAttr('checked', 'checked')
		})
	}

	function checkParent(el) {
		if (el.checked) {
			$(el).parents('li').children('input[type=checkbox]').prop('checked', true)
		}
		$(el).parent().find('input[type=checkbox]').prop('checked', el.checked)
	}
</script>