<!DOCTYPE html>
<html lang="pt-BR">

<head>

    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="keywords" content="">
    <meta name="author" content="Carlos Eduardo de Vargas">

    <title>Moblin Admin</title>

    <link href="<?php echo base_url()?>public/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo base_url()?>public/font-awesome/css/font-awesome.css" rel="stylesheet">

    <link href="<?php echo base_url()?>public/css/animate.css" rel="stylesheet">
    <link href="<?php echo base_url()?>public/css/style.css" rel="stylesheet">

</head>

<body class="gray-bg">

    <div class="middle-box text-center loginscreen  animated fadeInDown">
        <div>
            <div>
                <h1 class="logo-name">Moblin</h1>
            </div>
            	<?php $this->load->view($view);?>
            <p class="m-t"> <small>Moblin Web & Design &copy; 2015</small> </p>
        </div>
    </div>

    <script src="<?php echo base_url()?>public/js/jquery-2.1.1.js"></script>
    <script src="<?php echo base_url()?>public/js/bootstrap.min.js"></script>

</body>
</html>