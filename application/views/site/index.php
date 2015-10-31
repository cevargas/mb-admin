<!DOCTYPE html>
<html lang="pt-br">
<head>
	<meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0,maximum-scale=1.0, user-scalable=no" />   
    <meta name="description" content="Olá, seja bem-vindo a Moblin Web & Design. Somos um estúdio digital especializado em desenvolvimento e criação de sites, design gráfico e marketing digital em Passo Fundo - RS." />	
    <meta name="keywords" content="web design, design responsivo, design gráfico, design grafico, sites, marketing digital, passo fundo" />
	<meta name="author" content="Carlos Eduardo de Vargas" /> 
    <meta name="robots" content="index,follow" />
    <meta name="rating" content="general" />
    <meta name="language" content="pt-br" />
    <meta name="revisit-after" content="1 days" />
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="mobile-web-app-capable" content="yes">
	<title>Moblin Web & Design :: Desenvolvimento de Sites e Aplicações para Web, Web Design e Design Gráfico em Passo Fundo, RS</title>    
    <link rel="shortcut icon" href="<?php echo base_url()?>public/site/images/favicon.ico"/>        
</head>
<body>

<div class="container">
  	
    <div class="row">
    
        <div id="menu" class="col-sm-3">           
            <div id="logo-menu">
                <div id="logo-nome">MOBLIN</div>    
                <div id="logo-descricao">Web &amp; Design</div>
                <div id="logo-sobre">
                	<p>Somos um estúdio digital de desenvolvimento de aplicações web e design gráfico.</p>
                </div>
            </div> 	
            <ul id="links-menu">
                <li><a href="<?php echo base_url()?>" class="link">
                		Home
                		<!--<div class="glyph">
							<span class="glyph-item mega" aria-hidden="true" data-icon="&#xe069;"></span>&nbsp;&nbsp;Home
						</div>-->
                    </a>
                </li>
                <li>
                	<a href="<?php echo base_url()?>sobre" class="link">
                    	Sobre
                        <!--<div class="glyph">
                            <span class="glyph-item mega" aria-hidden="true" data-icon="&#xe001;"></span>&nbsp;&nbsp;Sobre
                        </div>-->
                    </a>
                </li>
                <li>
                	<a href="<?php echo base_url()?>servicos" class="link">
	                    Serviços
                    	<!--<div class="glyph">
							<span class="glyph-item mega" aria-hidden="true" data-icon="&#xe05f;"></span>&nbsp;&nbsp;Serviços
						</div>-->
                    </a>
                </li>
                <li>
                	<a href="<?php echo base_url()?>contato" class="link">
                    	Contato
                    	<!--<div class="glyph">
							<span class="glyph-item mega" aria-hidden="true" data-icon="&#xe07d;"></span>&nbsp;&nbsp;Contato
						</div>-->
                    </a>
                </li>
            </ul>
            <div id="social-menu">    	
                <ul>
                    <li><a class="link">facebook</a> // <a class="link">pinterest</a></li>
                    <li><a class="link">contato@moblin.com.br</a></li>
                </ul>
            </div>
        </div><!-- #menu -->

        <div id="conteudo" class="col-sm-9">     
			<?php $this->load->view($view); ?>
        </div><!-- #conteudo -->         
        
        <div id="footer" class="col-sm-offset-3 col-sm-9">
            Moblin Web & Design 2016.
        </div>

    </div><!-- .row -->
    
</div><!-- .container-fluid -->

<?php 
    //add css files
	$this->minify->css(array('site/components/bootstrap/css/bootstrap.min.css',
							 'site/css/fonts.css', 
							 'site/css/styles.css',
							 'site/css/responsive.css',
							 'site/components/simplelineicons/simple-line-icons.css'));
	echo $this->minify->deploy_css(false, "site.css");
    
	//add js files
	$this->minify->js(array('site/js/jquery-1.11.1.min.js',
							'site/components/bootstrap/js/bootstrap.min.js',
							'site/components/isotope/jquery.isotope.min.js',
							'site/js/scripts.js'));
	echo $this->minify->deploy_js(false, "site.js");
?>
</body>
</html>