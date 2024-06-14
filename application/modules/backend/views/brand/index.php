<div class="row">
	<div class="col-md-6">
		<div class="card radius-15 bg-dark">
			<div class="card-body text-center">
				<img src="" id="logo_brand" width="250" class="img-thumbail p-1" alt="">
				<h5 id="name_brand" class="mb-0 mt-4 text-white"></h5>
				<p id="email_brand" class="mb-2 text-white"></p>
				<p id="address_brand" class="mb-0 text-white"></p>
				<div class="list-inline contacts-social mt-3">
					<a href="" id="link_phone_brand" class="list-inline-item"><i class="bx bxs-phone"></i> <span id="phone_brand"></span></a>
				</div>
			</div>	
		</div>
	</div>
	<div class="col-md-6">
		<div class="card shadow radius-10">
			<div class="card-header"><strong>Form Update Brand</strong></div>
			<div class="card-body">
				<?php echo form_open_multipart('', 'id="form_add"') ?>
				<input type="hidden" name="id" class="validate">
				<div class="form-group row mb-2">
					<label class="form-label col-md-3">Title <span class="text-danger">*)</span></label>
					<div class="col-md-9">
						<input type="text" name="name" class="form-control validate" placeholder="Title ...">
					</div>
				</div>
				<div class="form-group row mb-2">
					<label class="form-label col-md-3">Email</label>
					<div class="col-md-9">
						<input type="email" name="email" class="form-control validate" placeholder="Email ...">
					</div>
				</div>
				<div class="form-group row mb-2">
					<label class="form-label col-md-3">Address</label>
					<div class="col-md-9">
						<textarea name="address" class="form-control" placeholder="Address ..."></textarea>
					</div>
				</div>
				<div class="form-group row mb-2">
					<label class="form-label col-md-3">Phone</label>
					<div class="col-md-9">
						<input type="text" name="phone" max="15" class="form-control validate" placeholder="Phone ...">
					</div>
				</div>
				<div class="form-group row mb-2">
					<label class="form-label col-md-3">Logo <span class="text-danger">*)</span></label>
					<div class="col-md-9">
						<input type="hidden" name="file_brand_old" class="validate">
						<input type="file" name="file_brand" class="form-control validate" accept=".png">
						<span class="text-danger">
							<em>*) Gambar wajib .png, Maksimal gambar 2 MB.</em>
						</span>
					</div>
				</div>
				<div class="form-group row mb-2">
					<label class="form-label col-md-3"></label>
					<div class="col-md-9">
						<a id="logo_brand_preview_fancy" data-fancybox data-src="">
							<img id="logo_brand_preview" class="img-thumbnail rounded" style="width:200px;height:100px;max-height:none;">
						</a>
					</div>
				</div>
				<div class="form-group row mb-2">
					<label class="form-label col-md-3">Logo Light <span class="text-danger">*)</span></label>
					<div class="col-md-9">
						<input type="hidden" name="file_brand_light_old" class="validate">
						<input type="file" name="file_brand_light" class="form-control validate" accept=".png">
						<span class="text-danger">
							<em>*) Gambar wajib .png, Maksimal gambar 2 MB.</em>
						</span>
					</div>
				</div>
				<div class="form-group row mb-2">
					<label class="form-label col-md-3"></label>
					<div class="col-md-9">
						<a id="logo_brand_light_preview_fancy" data-fancybox data-src="">
							<img id="logo_brand_light_preview" class="img-thumbnail rounded" style="width:200px;height:100px;max-height:none;">
						</a>
					</div>
				</div>
				<div class="form-group row mb-2">
					<label class="form-label col-md-3">Favicon <span class="text-danger">*)</span></label>
					<div class="col-md-9">
						<input type="hidden" name="file_brand_favicon_old" class="validate">
						<input type="file" name="file_brand_favicon" class="form-control validate" accept=".png">
						<span class="text-danger">
							<em>*) Gambar wajib .png, Maksimal gambar 2 MB.</em>
						</span>
					</div>
				</div>
				<div class="form-group row mb-2">
					<label class="form-label col-md-3"></label>
					<div class="col-md-9">
						<a id="logo_brand_favicon_preview_fancy" data-fancybox data-src="">
							<img id="logo_brand_favicon_preview" class="img-thumbnail rounded" style="width:100px;height:100px;max-height:none;">
						</a>
					</div>
				</div>
				<div class="row">
					<div class="col-md-12 right">
						<button type="reset" class="btn btn-secondary btn-sm btn-block"><i class="bx bx-x-circle"></i> Reset</button>
						<button type="submit" class="btn btn-primary btn-sm btn-block"><i class="bx bx-save"></i> Update</button>
					</div>
				</div>
				<?php echo form_close() ?>
			</div>
		</div>
	</div>
</div>

<script>
	var max_file_size = 2 * 1024 * 1024; // 2Mb
	var methodName = 'eo/brand';

	$(function() {
		getData()

		$('[name="file_brand"]').change(function() {
			if (this.files[0].size > max_file_size) {
				$('[name="file_brand"]').val('')
				$('#logo_brand_preview').attr('src', '')
				$('#logo_brand_preview_fancy').attr('data-src', '')
				swalAlert('warning', 'Validasi Upload', 'File tidak boleh lebih dari 2 Mb')
				return false
			} else {
				$('#logo_brand_preview').attr('src', URL.createObjectURL(this.files[0]))
				$('#logo_brand_preview_fancy').attr('data-src', URL.createObjectURL(this.files[0]))
			}
		})

		$('[name="file_brand_light"]').change(function() {
			if (this.files[0].size > max_file_size) {
				$('[name="file_brand_light"]').val('')
				$('#logo_brand_light_preview').attr('src', '')
				$('#logo_brand_light_preview_fancy').attr('data-src', '')
				swalAlert('warning', 'Validasi Upload', 'File tidak boleh lebih dari 2 Mb')
				return false
			} else {
				$('#logo_brand_light_preview').attr('src', URL.createObjectURL(this.files[0]))
				$('#logo_brand_light_preview_fancy').attr('data-src', URL.createObjectURL(this.files[0]))
			}
		})

		$('[name="file_brand_favicon"]').change(function() {
			if (this.files[0].size > max_file_size) {
				$('[name="file_brand_favicon"]').val('')
				$('#logo_brand_favicon_preview').attr('src', '')
				$('#logo_brand_favicon_preview_fancy').attr('data-src', '')
				swalAlert('warning', 'Validasi Upload', 'File tidak boleh lebih dari 2 Mb')
				return false
			} else {
				$('#logo_brand_favicon_preview').attr('src', URL.createObjectURL(this.files[0]))
				$('#logo_brand_favicon_preview_fancy').attr('data-src', URL.createObjectURL(this.files[0]))
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
						url: baseUrl + methodName + '/store' ,
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
								syamValidationServer('[name="file_brand"]', 'file_brand', data)
								syamValidationServer('[name="file_brand_light"]', 'file_brand_light', data)
								syamValidationServer('[name="file_brand_favicon"]', 'file_brand_favicon', data)
								return false;
							}

							if (data.status) {
								getData()
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

	function getData() {
		$.ajax({
			type: 'GET',
			url: baseUrl + methodName + '/show/' + <?php echo $this->brand->id ?>,
			cache: false,
			dataType: 'JSON',
			success: function(data) {
				if (data) {
					// view
					$('#name_brand').text(data.name)
					$('#email_brand').text(data.email)
					$('#address_brand').text(data.address)
					$('#link_phone_brand').attr('href', 'tel:' + data.phone)

					if (data.logo !== null) {
						$('#logo_brand').attr('src', '<?php echo base_url('assets/clouds/drives/brand/') ?>' + data.logo)
					}

					$('[name="id"]').val(data.id)
					$('[name="name"]').val(data.name)
					$('[name="email"]').val(data.email)
					$('[name="address"]').val(data.address)
					$('[name="phone"]').val(data.phone)

					$('[name="file_brand_old"]').val(data.logo)
					if (data.logo !== null) {
						$('#logo_brand_preview').attr('src', '<?php echo base_url('assets/clouds/drives/brand/') ?>' + data.logo)
						$('#logo_brand_preview_fancy').attr('data-src', '<?php echo base_url('assets/clouds/drives/brand/') ?>' + data.logo)
					}
					$('[name="file_brand_light_old"]').val(data.logo_light)
					if (data.logo !== null) {
						$('#logo_brand_light_preview').attr('src', '<?php echo base_url('assets/clouds/drives/brand/') ?>' + data.logo_light)
						$('#logo_brand_light_preview_fancy').attr('data-src', '<?php echo base_url('assets/clouds/drives/brand/') ?>' + data.logo_light)
					}
					$('[name="file_brand_favicon_old"]').val(data.favicon)
					if (data.logo !== null) {
						$('#logo_brand_favicon_preview').attr('src', '<?php echo base_url('assets/clouds/drives/brand/') ?>' + data.favicon)
						$('#logo_brand_favicon_preview_fancy').attr('data-src', '<?php echo base_url('assets/clouds/drives/brand/') ?>' + data.favicon)
					}
				}
			},
			error: function(e) {
				toastrAlert('error', e.status, e.statusText)
			}
		})
	}
</script>