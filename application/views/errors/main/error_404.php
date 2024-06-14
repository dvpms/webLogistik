<!DOCTYPE html>
<html lang="en" 
	data-layout="vertical" 
	data-layout-style="detached" 
	data-sidebar="light" 
	data-topbar="dark" 
	data-sidebar-size="lg" 
	data-sidebar-image="none" 
	data-preloader="disable">

<head>

<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="title" content="<?php echo $this->brand->name ?>">
<meta name="description" content="Ini adalah Content Management System <?php echo $this->brand->name ?>">
<meta name="keywords" content="website, aplikasi, sistem informasi manajemen">
<meta name="robots" content="index, follow">
<meta name="language" content="Indonesian, English">
<meta name="revisit-after" content="1 days">
<meta name="author" content="Faiz Muhammad Syam, S.Kom">
<meta name="msapplication-tap-highlight" content="no">
<meta name="theme-color" content="#132649">

<title><?php echo '404 Page Not Found | ' . $this->brand->name ?></title>

<!-- favicon -->
<link rel="icon" type="image/png" href="<?php echo base_url('assets/clouds/drives/brand/'.$this->brand->favicon) ?>" sizes="32x32">
<link rel="icon" type="image/png" href="<?php echo base_url('assets/clouds/drives/brand/'.$this->brand->favicon) ?>" sizes="16x16">

<link href="<?php echo base_url('assets/backend/themes/css/bootstrap.min.css') ?>" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url('assets/backend/themes/css/icons.min.css') ?>" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url('assets/backend/themes/css/app.min.css') ?>" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url('assets/backend/themes/css/custom.min.css') ?>" rel="stylesheet" type="text/css" />
<script src="<?php echo base_url('assets/backend/themes/js/layout.js') ?>"></script>
</head>

<body>
<!-- auth-page wrapper -->
<div class="auth-page-wrapper py-5 d-flex justify-content-center align-items-center min-vh-100">
<!-- auth-page content -->
    <div class="auth-page-content overflow-hidden p-0">
		<div class="container">
			<div class="row justify-content-center">
				<div class="col-xl-7 col-lg-8">
					<div class="text-center">
						<img src="<?php echo base_url('assets/backend/themes/images/error400-cover.png') ?>" alt="error img" class="img-fluid">
						<div class="mt-3">
							<h3 class="text-uppercase">Maaf, Halaman tidak Ditemukan 😭</h3>
							<p class="text-muted mb-4">Halaman yang Anda cari tidak tersedia!</p>
							<a href="<?php echo site_url('/') ?>" class="btn btn-info"><i class="mdi mdi-home me-1"></i>Back to home</a>
						</div>
					</div>
				</div><!-- end col -->
			</div>
			<!-- end row -->
		</div>
		<!-- end container -->
	</div>
	<!-- end auth-page content -->	
</div>
<!-- end auth-page-wrapper -->
</body>
</html>