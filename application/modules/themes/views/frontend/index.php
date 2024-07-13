<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $page_title?></title>
    <link href="<?php echo base_url('public/assets/frontend/css/service-details-p.css'); ?>" rel="stylesheet">
    <link href="<?php echo base_url('public/assets/frontend/css/service-p.css'); ?>" rel="stylesheet">
    <link href="<?php echo base_url('public/assets/frontend/css/style.css'); ?>" rel="stylesheet">
</head>

<body>
    <header>
        <nav>
            <div class="logo">Logo</div>
            <ul>
                <li><a href="<?php echo base_url('/index/home'); ?>">Home</a></li>
                <li><a href="<?php echo base_url('/index/about'); ?>">About</a></li>
                <li><a href="<?php echo base_url('/index/services'); ?>">Services</a></li>
                <li><a href="<?php echo base_url('/index/pricing'); ?>">Pricing</a></li>
                <li><a href="<?php echo base_url('/index/history'); ?>">History</a></li>
            </ul>
            <button class="login-btn">Login</button>
        </nav>
    </header>

    <?php
		try {
			$this->load->view($content);
		} catch (\Exception $error) {
			echo "<pre><code>" .$error . "</code></pre>";
		}
	?>
    <footer>
        <p>&copy; 2024 webLogistik</p>
    </footer>
</body>

</html>