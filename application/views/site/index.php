<!DOCTYPE html>
<html lang="pt-br">
<head>
	<meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0,maximum-scale=1.0, user-scalable=no" />   
    <meta name="description" content="Olá, seja bem-vindo a Moblin Web Studio. Somos um estúdio especializado no desenvolvimento de aplicações para a Web" />	
    <meta name="keywords" content="web design, design responsivo, webapps, aplicacacoes web, web mobile, sites, marketing digital, passo fundo" />
	<meta name="author" content="Carlos Eduardo de Vargas" /> 
    <meta name="robots" content="index,follow" />
    <meta name="rating" content="general" />
    <meta name="language" content="pt-br" />
    <meta name="revisit-after" content="1 days" />
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="mobile-web-app-capable" content="yes">
	<title>Moblin Web Studio :: Desenvolvimento de Aplicações para Web, Web Mobile e Web Design em Passo Fundo, RS</title>    
    
    <link rel="shortcut icon" type="image/x-icon" href="<?php echo base_url()?>public/site/images/favicon/favicon.ico"/>   
        
    <!--link href='//fonts.googleapis.com/css?family=Open+Sans:300,400,500,600,700' rel='stylesheet' type='text/css'-->   
    <!--link href='https://fonts.googleapis.com/css?family=Lato:400,700,300' rel='stylesheet' type='text/css'-->
    <link href='https://fonts.googleapis.com/css?family=Source+Sans+Pro:400,600,700,300' rel='stylesheet' type='text/css'>
    
    <link href="<?php echo base_url()?>public/site/components/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url()?>public/site/css/styles.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url()?>public/site/css/responsive.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url()?>public/site/components/simplelineicons/css/simple-line-icons.css" rel="stylesheet" type="text/css" />
        
</head>
<body>

<div class="container">
  	
    <div class="row">
    
        <div id="menu" class="col-sm-12">         
            <div id="logo-menu" class="col-sm-3 ">
            	<img src="<?php echo base_url()?>public/site/images/logo.png" alt="Moblin Web Studio">
                <!--div id="logo-nome">MOBLIN</div>    
                <div id="logo-descricao">Web Studio</div-->                
            </div> 	
            <div class="col-sm-9 ">
                <ul id="links-menu" class="pull-right">
                    <li><a href="<?php echo base_url()?>" class="link">Home</a></li>
                    <li><a href="<?php echo base_url()?>sobre" class="link">Quem somos</a></li>
                    <li><a href="<?php echo base_url()?>servicos" class="link">O que fazemos</a></li>
                    <li><a href="<?php echo base_url()?>contato" class="link">Contato</a></li>
                </ul>
            </div>
            <!--div id="social-menu" class="col-sm-2 ">    	
                <ul>
                    <li><a class="link"><i class="icon-social-facebook"></i></a> 
                    <li><a class="link"><i class="icon-social-pinterest"></i></a> 
                </ul>
            </div-->
        </div><!-- #menu -->

        <div id="conteudo" class="col-sm-12">        
        	
        	<?php echo $this->session->flashdata('msg'); ?>
            
			<?php $this->load->view($view); ?>            
            
        </div><!-- #conteudo -->    
        
        <div class="container-fluid">
        
            <div id="contato" class="col-sm-12">
                <div class="titulo">Fala aí!.</div>                                
                <div class="descricao">                
                <?php 
                    echo form_open( base_url( 'site/contato/submit' ), 
                            array( 'id' => 'frm-contato', 'method' => 'post', 
                                'class' => 'form-horizontal', 'role' =>'form', 
                                'autocomplete' => 'off' ) ); 
                    ?>
        
                    <div class="form-group">
                        <div class="col-sm-5">
                            <input type="text" class="form-control" name="txtnome" id="nome" placeholder="Seu nome*">
                        </div>
                        <div class="col-sm-5">
                            <input type="email" class="form-control" name="txtemail" id="Email" placeholder="Seu email*">
                        </div>
                    </div>  
                                  
                    <div class="form-group">           
                        <div class="col-sm-10">
                            <textarea class="form-control" name="txtmensagem" id="mensagem" rows="3" placeholder="Sua mensagem*"></textarea>
                        </div>
                    </div>
                    <div class="form-group">                  
                        <div class="col-sm-10">
                            <input class="btn btn-default" type="submit" value="Enviar">
                        </div>
                    </div>                  
                 <?php echo form_close();?>
                </div>
            </div><!-- #contato -->         
            
            <div id="footer" class="col-sm-12">
                Moblin Web Studio 2016.
            </div><!-- #footer --> 
		</div>              

    </div><!-- .row -->
   
</div><!-- .container -->

<script type="text/javascript" src="<?php echo base_url()?>public/site/js/jquery-1.11.1.min.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>public/site/components/bootstrap/js/bootstrap.min.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>public/site/components/isotope/jquery.isotope.min.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>public/template/js/plugins/validate/jquery.validate.min.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>public/template/js/plugins/validate/localization/messages_pt_BR.min.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>public/site/js/scripts.js"></script>

</body>
</html>