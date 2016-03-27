<!DOCTYPE html>
<html lang="pt-BR">

<head>

    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="keywords" content="">
    <meta name="author" content="Carlos Eduardo de Vargas">

    <title>Moblin Web Studio :: Dashboard</title>

    <link href="<?php echo base_url()?>public/template/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo base_url()?>public/template/font-awesome/css/font-awesome.css" rel="stylesheet">

    <link href="<?php echo base_url()?>public/template/css/animate.css" rel="stylesheet">
    <link href="<?php echo base_url()?>public/template/css/style.css" rel="stylesheet">
    <link href="<?php echo base_url()?>public/admin/css/styles.css" rel="stylesheet">

</head>

<body class="gray-bg">

    <div class="middle-box text-center loginscreen animated fadeInDown">
        <div class="row">
            <div class="col-md-12 logo-admin">          
                <img src="<?php echo base_url()?>public/site/images/logo.png" alt="Moblin Web Studio">
            </div>
            <div class="col-md-12">
				<?php $this->load->view($view);?>
            </div>
            <div class="col-md-12">
	            <p class="m-t"> <small>Moblin Web & Design &copy; <?php echo date('Y');?></small> </p>
            </div>    
        </div>
    </div>

    <script src="<?php echo base_url()?>public/template/js/jquery-2.1.1.js"></script>
    <script src="<?php echo base_url()?>public/template/js/bootstrap.min.js"></script>

</body>
</html>