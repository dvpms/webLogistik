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
								<th class="center" width="5%">Avatar</th>
								<th width="10%">Username</th>
								<th width="35%">Nama Lengkap</th>
								<th width="25%">Akses Group</th>
								<th width="5%">Status</th>
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

<div class="modal fade" id="modal_form" data-bs-backdrop="static" role="dialog">
	<div class="modal-dialog" style="max-width:600px">
		<div class="modal-content">
			<?php echo form_open_multipart('', 'id="form_add"') ?>
			<div class="modal-header">
				<h5 class="modal-title" id="modal_form_label">Form Tambah Data</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<input type="hidden" name="id">
				<div class="form-group row mb-2">
					<label class="form-label bold col-md-4">Nama Lengkap <span class="text-danger">*)</span></label>
					<div class="col-md-8">
						<input type="text" name="name" class="form-control validate" placeholder="Nama Lengkap ...">
					</div>
				</div>
				<div class="form-group row mb-2 form_username">
					<label class="form-label bold col-md-4">Username <span class="text-danger">*)</span></label>
					<div class="col-md-8">
						<input type="text" name="username" class="form-control validate" placeholder="Username ...">
					</div>
				</div>
				<div class="form-group row mb-2 form_password">
					<label class="form-label bold col-md-4">Password Default</label>
					<div class="col-md-3">
						<input type="text" class="form-control" value="1 2 3 4 5" disabled>
					</div>
				</div>
				<div class="form-group row mb-2">
					<label class="form-label bold col-md-4">User Group / Level <span class="text-danger">*)</span></label>
					<div class="col-md-8">
						<select name="id_user_group" class="form-select validate">
							<option value="">Pilih ...</option>
							<?php foreach ($users_group as $row) : ?>
								<option value="<?php echo $row->id ?>"><?php echo $row->name ?></option>
							<?php endforeach; ?>
						</select>
					</div>
				</div>
				<div class="form-group row foto">
					<label class="form-label bold col-md-4">Foto / Avatar</label>
					<div class="col-md-8">
						<input type="hidden" name="file_avatar_old">
						<input type="file" name="file_avatar" class="form-control" accept=".png, .jpeg, .jpg">
					</div>
				</div>
				<div class="form-group row mb-2 foto">
					<label class="form-label bold col-md-4"></label>
					<div class="col-md-8">
						<span class="text-danger">
							<em>*) Gambar wajib png, jpg, jpeg, Maksimal gambar 5 MB.</em>
						</span>
					</div>
				</div>
				<div class="form-group row mb-2 foto">
					<label class="form-label col-md-4"></label>
					<div class="col-md-8">
						<img id="image_preview" width="100" height="100" class="img-fluid rounded d-block img-thumbnail">
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

<script>
	var max_file_size = 5 * 1024 * 1024; // 5Mb
	var methodName = 'eo/users';

	$(function() {
		getListData(1)

		$('#keyword_search').keyup(function() {
			getListData(1)
		})

		$('#btn_add').click(function() {
			resetForm()
			$('#modal_form').modal('show')
			$('#modal_form_label').text('Form Tambah Data')
		})

		$('#btn_reload').click(function() {
			resetForm()
			getListData(1)
		})

		$('[name="file_avatar"]').change(function() {
			if (this.files[0].size > max_file_size) {
				$('[name="file_avatar"]').val('')
				$('#image_preview').attr('src', '')
				swalAlert('warning', 'Validasi Upload', 'File tidak boleh lebih dari 5 Mb')
				return false
			} else {
				$('#image_preview').attr('src', URL.createObjectURL(this.files[0]))
			}
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
								syamValidationServer('[name="username"]', 'username', data)
								syamValidationServer('[name="name"]', 'name', data)
								syamValidationServer('[name="email"]', 'email', data)
								syamValidationServer('[name="id_user_group"]', 'id_user_group', data)
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
					var status = `<div class="form-check form-switch">
									<input class="form-check-input" type="checkbox" onclick="updateStatus(${v.id}, '${v.is_active}')" ${(v.is_active == 1 ? 'checked' : '')}>
									<label class="form-check-label">${(v.is_active == 1 ? '<span class="badge bg-success">Active</span>' : '<span class="badge bg-danger">Unactive</span>')}</label>
								</div>`;

					var foto = `<img src="<?php echo base_url('assets/clouds/drives/avatars/avatar.png') ?>" class="rounded-circle shadow bg-white p-1" width="34" height="34">`;
					if (v.foto_pegawai !== null) {
						if (v.is_pegawai == 1) {
							foto = `<a data-fancybox data-src="${v.foto_pegawai}" data-caption="${v.nama_pegawai}">
										<img src="${v.foto_pegawai}" class="rounded-circle shadow" width="34" height="34">
									</a>`;
						} else {
							foto = `<a data-fancybox data-src="<?php echo base_url('assets/clouds/drives/avatars/') ?>${v.foto_pegawai}" data-caption="${v.nama_pegawai}">
										<img src="<?php echo base_url('assets/clouds/drives/avatars/') ?>${v.foto_pegawai}" class="rounded-circle shadow" width="34" height="34">
									</a>`;
						}
					}

					var html = '<tr>' +
						'<td class="center">' + no + '</td>' +
						'<td class="center">' + foto + '</td>' +
						'<td>' + v.nip + '</td>' +
						'<td>' + v.nama_pegawai + '</td>' +
						'<td>' + v.user_group + '</td>' +
						'<td class="nowrap">' + status + '</td>' +
						'<td class="right nowrap">' +
						'<button type="button" class="btn btn-success btn-sm" onclick="editData(' + v.id + ', ' + data.page + ')"><i class="bx bx-edit"></i></button> ' +
						'<button type="button" class="btn btn-danger btn-sm" onclick="deleteData(' + v.id + ', \'' + (v.foto_pegawai !== null ? v.foto_pegawai : '') + '\', ' + data.page + ')"><i class="bx bx-trash"></i></button>' +
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
		$('.validate, #keyword_search').val('').change()
		$('#form_add')[0].reset()
		$('.form_username, .form_password, .foto').show()
		$('[name="name"]').prop('readonly', false)
		$('.form-control').prop('readonly', false)
		syamValidationRemove('.validate')
		$('#image_preview').attr('src', '<?php echo base_url('assets/clouds/drives/avatars/avatar.png') ?>')
	}

	function updateStatus(id, status) {
		$.ajax({
			type: 'POST',
			url: baseUrl + methodName + '/update-status',
			data: {
				id: id,
				status: status,
				csrf_token_fms : $('[name="'+csrfName+'"]').val(),
			},
			cache: false,
			dataType: 'JSON',
			success: function(data) {
				$('[name="'+csrfName+'"]').val(data._token);
				if (data.status !== false) {
					getListData($('#page_list').val())
					toastrAlert('success', 'Update Status', data.message)
				} else {
					toastrAlert('warning', 'Update Status', data.message)
				}
			},
			error: function(e) {
				toastrAlert('error', e.status, e.statusText)
			}
		})
	}

	function editData(id, page) {
		$.ajax({
			type: 'GET',
			url: baseUrl + methodName + '/show/' + id,
			cache: false,
			dataType: 'JSON',
			beforeSend: function() {
				resetForm()
				$('#page_list').val(page)
				showLoader()
			},
			success: function(data) {
				if (data) {
					$('.form_username, .form_password').hide()

					$('[name="id"]').val(data.id)
					$('[name="name"]').val(data.nama_pegawai)
					$('[name="id_user_group"]').val(data.id_user_group).change()

					if (data.is_pegawai == 1) {
						$('[name="name"]').prop('readonly', true)
						$('.foto').hide()
					} else {
						$('[name="name"]').prop('readonly', false)
						$('.foto').show()

						$('[name="file_avatar_old"]').val(data.foto_pegawai)
						if (data.foto_pegawai !== null) {
							$('#image_preview').attr('src', '<?php echo base_url('assets/clouds/drives/avatars/') ?>' + data.foto_pegawai)
						}
					}


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

	function deleteData(id, file_avatar, page) {
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
					url: baseUrl + methodName + '/destroy/' + id,
					data: {
						file_avatar: file_avatar,
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
</script>