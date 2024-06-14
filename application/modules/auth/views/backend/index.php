<!doctype html>
<html lang="en" data-layout="vertical" data-layout-style="detached" data-sidebar="light" data-topbar="dark" data-sidebar-size="lg" data-sidebar-image="none" data-preloader="disable">

<head>

  <meta charset="utf-8" />
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

  <title><?php echo $page_title . ' | ' . $this->brand->name ?></title>

  <!-- favicon -->
  <link rel="icon" type="image/png" href="<?php echo base_url('assets/clouds/drives/brand/' . $this->brand->favicon) ?>" sizes="32x32">
  <link rel="icon" type="image/png" href="<?php echo base_url('assets/clouds/drives/brand/' . $this->brand->favicon) ?>" sizes="16x16">

  <link href="public/assets/backend/themes/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
  <link href="public/assets/backend/themes/css/icons.min.css" rel="stylesheet" type="text/css" />
  <link href="public/assets/backend/themes/css/app.min.css" rel="stylesheet" type="text/css" />
  <link href="public/assets/backend/themes/css/auth.css" rel="stylesheet" type="text/css" />

  <script src="<?php echo base_url('assets/clouds/jquery/jquery-3.6.0.min.js') ?>"></script>
  <script src="<?php echo base_url('assets/backend/themes/js') ?>/bootstrap.bundle.min.js"></script>
  <script src="<?php echo base_url('assets/clouds/plugins/toastr/toastr.min.js') ?>"></script>
  <script src="<?php echo base_url('assets/backend/themes/js/layout.js') ?>"></script>

  <script>
    $(document).ready(function() {
      $(".show_hide_password button").on('click', function(event) {
        event.preventDefault()
        if ($('.show_hide_password input').attr("type") == "text") {
          $('.show_hide_password input').attr('type', 'password')
          $('.show_hide_password i').addClass("bx-hide")
          $('.show_hide_password i').removeClass("bx-show")
        } else if ($('.show_hide_password input').attr("type") == "password") {
          $('#password').attr('type', 'text')
          $('.show_hide_password i').removeClass("bx-hide")
          $('.show_hide_password i').addClass("bx-show")
        }
      })

      setTimeout(() => {
        $('#alert').fadeOut();
      }, 3000);
    })
  </script>
</head>

<body>
  <!-- auth-page wrapper -->
  <div class="auth-page-wrapper auth-bg-cover py-5 d-flex justify-content-center align-items-center min-vh-100">
    <div class="bg-overlay"></div>
    <!-- auth-page content -->
    <div class="auth-page-content overflow-hidden">
      <div class="container">
        <div class="row">
          <div class="col-lg-4 mt-lg-0 mt-5 mx-auto">
            <!-- <div class="card overflow-hidden"> -->
              <div class="row g-0">
                <div class="col-lg-12">
                  <div class="box-brand p-lg-0 p-3">
                    <?php if ($this->brand->logo) : ?>
                      <img src="<?php echo base_url('assets/clouds/drives/brand/'.$this->brand->logo) ?>" alt="">
                    <?php endif; ?>
                    <div class="brand-text">
                      <h1><?php echo $this->brand->name ?></h1>
                    </div>
                  </div>
                  <div class="p-lg-0 p-3">
                    <?php if ($this->session->flashdata('alert')) echo '<div class="alert alert-warning mt-3" id="alert" role="alert"><small>' . $this->session->flashdata('alert') . '</small></div>' ?>
                    <div class="mt-3">
                      <?php echo form_open('auth', 'class="row g-3"') ?>
                      <div class="mb-1">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" name="username" autofocus="true" autocomplete="off" class="form-control-auth form-control" id="username" placeholder="Enter Username ..." value="<?php echo set_value('username') ?>">
                        <small class="text-danger error"><i><?php echo form_error('username') ?></i></small>
                      </div>
                      <div class="mb-1">
                        <label for="password" class="form-label">Password</label>
                        <div class="position-relative auth-pass-inputgroup show_hide_password">
                          <input type="password" name="password" autocomplete="off" class="form-control-auth form-control pe-5 password-input" id="password" placeholder="Enter Password ...">
                          <button class="btn btn-link position-absolute end-0 top-0 text-decoration-none text-muted" type="button"><b><i class="bx bx-hide fs-20 align-middle"></i></b></button>
                        </div>
                        <small class="text-danger error"><i><?php echo form_error('password') ?></i></small>
                      </div>

                      <div class="">
                        <button type="submit" class="btn btn-primary w-100"><i class="bx bxs-lock-open"></i> Sign in</button>
                      </div>
                      <?php echo form_close() ?>
                    </div>
                  </div>
                </div>
                <!-- end col -->
              </div>
              <!-- end row -->
            <!-- </div> -->
            <!-- end card -->
          </div>
          <!-- end col -->
        </div>
        <!-- end row -->
      </div>
      <!-- end container -->
    </div>
    <!-- end auth page content -->

    <!-- footer -->
    <footer class="footer">
      <div class="container">
        <div class="row">
          <div class="col-lg-12">
            <div class="text-center">
              <p class="mb-0">
                <?php echo (date('Y') == '2023') ? date('Y') : '2023 - ' . date('Y') ?> © Pemerintah Kota Tangerang.
              </p>
            </div>
          </div>
        </div>
      </div>
    </footer>
    <!-- end Footer -->
  </div>
  <!-- end auth-page-wrapper -->
</body>

</html>