<!doctype html>
<html lang="en">

<head>
  <!-- meta tags -->
  <meta charset="utf-8">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="title" content="<?php echo $this->brand->name ?>">
  <meta name="description" content="">
  <meta name="keywords" content="">
  <meta name="robots" content="index, follow">
  <meta name="language" content="Indonesian, English">
  <meta name="revisit-after" content="1 days">
  <meta name="author" content="Faiz Muhammad Syam, S.Kom">
  <meta name="msapplication-tap-highlight" content="no">
  <meta name="theme-color" content="#132649">

  <title><?php echo $page_title . ' | ' . $this->brand->name ?></title>

  <!-- favicon -->
  <link rel="icon" type="image/png" href="public/assets/clouds/drives/brand/favicon-32x32.png" sizes="32x32">
  <link rel="icon" type="image/png" href="public/assets/clouds/drives/brand/favicon-16x16.png') ?>" sizes="16x16">

  <!-- fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Titillium+Web:wght@400;700&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">

  <!-- css -->
  <link href="public/assets/clouds/bs5/css/bootstrap.min.css" rel="stylesheet">

  <!-- js -->
  <script src="public/assets/clouds/jquery/jquery-3.6.0.min.js"></script>
  <script src="public/assets/clouds/bs5/js/bootstrap.bundle.min.js"></script>
  <script src="public/assets/clouds/js/blockui.js"></script>
  <script src="public/assets/clouds/js/sweetalert2.all.min.js"></script>
  <script src="public/assets/clouds/js/syam.min.js"></script>
</head>

<body>
  <?php $this->load->view($content) ?>
</body>

</html>