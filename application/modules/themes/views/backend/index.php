<!doctype html>
<html 
  lang="en" 
  data-layout="vertical" 
  data-layout-style="default" 
  data-sidebar="dark" 
  data-topbar="light"
  data-sidebar-size="lg" 
  data-sidebar-image="img-2" 
  data-preloader="disable" 
  data-layout-position="fixed"
  data-layout-width="fluid">

<head>

  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="title" content="<?php echo $this->brand->name ?>">
  <meta name="description" content="<?php echo $this->brand->name ?>">
  <meta name="keywords" content="">
  <meta name="robots" content="index, follow">
  <meta name="language" content="Indonesian, English">
  <meta name="revisit-after" content="1 days">
  <meta name="author" content="Faiz Muhammad Syam, S.Kom - Dinas Komunikasi dan Informatika">
  <meta name="msapplication-tap-highlight" content="no">
  <meta name="<?php echo $this->security->get_csrf_token_name() ?>" content="<?php echo $this->security->get_csrf_hash() ?>">
  <meta name="theme-color" content="#132649">

  <title><?php echo $page_title . ' | ' . $this->brand->name ?></title>

  <!-- favicon -->
  <link rel="icon" type="image/png" href="public/assets/clouds/drives/brand/ . <?php echo $this->brand->favicon ?>" sizes="32x32">
  <link rel="icon" type="image/png" href="public/assets/clouds/drives/brand/ . <?php echo $this->brand->favicon ?>" sizes="16x16">


  <link href="public/assets/backend/themes/css/bootstrap.min.css" rel="stylesheet" type="text/css">
  <link href="public/assets/backend/themes/css/icons.min.css" rel="stylesheet" type="text/css">
  <link href="public/assets/backend/themes/css/app.min.css" rel="stylesheet" type="text/css">
  <link href="public/assets/backend/themes/css/custom.min.css" rel="stylesheet" type="text/css">
  <link href="public/assets/clouds/bs5/icons/font/bootstrap-icons.css" rel="stylesheet">
  <link href="public/assets/clouds/css/fancybox.css" rel="stylesheet" type="text/css">
  <link href="public/assets/clouds/css/syam.min.css" rel="stylesheet" type="text/css">
  <link href="public/assets/clouds/css/eo.min.css" rel="stylesheet" type="text/css">
  <link href="public/assets/clouds/plugins/toastr/toastr.css" rel="stylesheet" type="text/css">
  <link href="public/assets/clouds/plugins/select2/css/select2.css" rel="stylesheet" type="text/css">

  <script src="public/assets/clouds/jquery/jquery-3.6.4.min.js"></script>
  <script src="public/assets/backend/themes/js/bootstrap.bundle.min.js"></script>
  <script src="public/assets/backend/themes/js/layout.js"></script>
  <script src="public/assets/backend/themes/js/simplebar.min.js"></script>
  <script src="public/assets/backend/themes/js/waves.min.js"></script>
  <script src="public/assets/backend/themes/js/feather.min.js"></script>
  <script src="public/assets/backend/themes/js/lord-icon-2.1.0.js"></script>
  <script src="public/assets/backend/themes/js/pickr.min.js"></script>
  <script src="public/assets/backend/themes/js/flatpickr.min.js"></script>
  <script src="public/assets/backend/themes/js/choices.min.js"></script>
  <script src="public/assets/clouds/js/blockui.js"></script>
  <script src="public/assets/clouds/js/bootbox.js"></script>
  <script src="public/assets/clouds/js/pdfobject.min.js"></script>
  <script src="public/assets/clouds/js/sweetalert2.all.min.js"></script>
  <script src="public/assets/clouds/js/fancybox.js"></script>
  <script src="public/assets/clouds/js/syam.min.js"></script>
  <script src="public/assets/clouds/plugins/toastr/toastr.min.js"></script>
  <script src="public/assets/clouds/plugins/select2/js/select2.js"></script>
  <script>
    var baseUrl = '<?php echo site_url() ?>';
    var csrfName = '<?php echo $this->security->get_csrf_token_name() ?>';
  </script>
</head>

<body>
  <div id="layout-wrapper">
    <?php $this->load->view('_header') ?>
    <?php $this->load->view('_sidebar') ?>
    <div class="vertical-overlay"></div>
    <!-- main content -->
    <div class="main-content">
      <div class="page-content">
        <div class="bg-overlay-content"></div>
        <div class="container-fluid">
          <?php $this->load->view('_breadcrumb') ?>
          <?php
          try {
            $this->load->view($content);
          } catch (\Exception $error) {
            echo "<pre><code>" . $error . "</code></pre>";
          }
          ?>
        </div>
        <!-- container fluid -->
      </div>
      <!-- end page content -->
      <?php $this->load->view('_footer') ?>
    </div>
    <!-- end main content-->
  </div>
  <!-- bantuan WA -->
  <!-- <a class="float-button-wa" title="Butuh Bantuan" target="_blank" href="https://api.whatsapp.com/send?phone=628111145288&text=Hallo,%20Saya%20Butuh%20Bantuan%20mengenai%20aplikasi%20Web%20E-Office??.">
    <i class="bx bxl-whatsapp" aria-hidden="true"></i>
    <span>Butuh Bantuan ?<span>
  </a> -->
  <!-- end layout wrapper -->
  <script src="public/assets/backend/themes/js/app.js"></script>
</body>

</html>