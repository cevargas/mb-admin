<!--<div class="titulo">Quem somos.</div>
<div class="descricao">
    <p>Somos um estúdio digital de desenvolvimento de aplicações web e design gráfico.</p>
</div>              

<div class="titulo">O que fazemos.</div>-->            

<div class="container-fluid pg-inside">

    <div id="posts" class="row">
        <div id="1" class="item col-xs-12 col-sm-5">
            <div class="itens radius shadow effect">
                <div class="item-image radius-top">
                    <a href="#">
                        <img src="<?php echo base_url()?>public/site/images/responsive.jpg" alt="Responsive Design" class="radius-top">
                    </a>
                </div>
                <div class="item-descript radius-bottom">Web Design + Responsive Design</div>
            </div>
        </div>
        <div id="2" class="item col-xs-12 col-sm-5">
            <div class="itens radius shadow effect">
                <div class="item-image radius-top">
                    <a href="#">
                        <img src="<?php echo base_url()?>public/site/images/card.jpg" alt="Cartões" class="radius-top">
                    </a>    
                </div>
                <div class="item-descript radius-bottom">Cartões</div>
            </div>
        </div>
        <div id="3" class="item col-xs-12 col-sm-5">
             <div class="itens radius shadow effect">
                <div class="item-image radius-top">
                    <a href="#">
                        <img src="<?php echo base_url()?>public/site/images/identidade.jpg" alt="Identidade Visual" class="radius-top">
                    </a>    
                </div>
                <div class="item-descript radius-bottom">Identidade Visual</div>
            </div>
        </div>
        <div id="4" class="item col-xs-12 col-sm-5">
            <div class="itens radius shadow effect">
                <div class="item-image radius-top">
                    <a href="#">
                        <img src="<?php echo base_url()?>public/site/images/logo.jpg" alt="Logo" class="radius-top">
                    </a>    
                </div>
                <div class="item-descript radius-bottom">Logotipos</div>
            </div>
        </div>
        <div id="5" class="item col-xs-12 col-sm-5">
             <div class="itens radius shadow effect">
                <div class="item-image radius-top">
                    <a href="#">
                        <img src="<?php echo base_url()?>public/site/images/design.jpg" alt="Design Gráfico" class="radius-top">
                    </a>    
                </div>
                <div class="item-descript radius-bottom">+ Design Gráfico</div>
            </div>
        </div>
        <div id="6" class="item col-xs-12 col-sm-5">
            <div class="itens radius shadow effect">
                <div class="item-image radius-top">
                    <a href="#">	
                        <img src="<?php echo base_url()?>public/site/images/seo.jpg" alt="SEO" class="radius-top">
                    </a>
                </div>
                <div class="item-descript radius-bottom">SEO</div>
            </div> 
        </div>                  
    </div>
</div>

<div id="contato">             
    <div class="titulo">Fale aí!.</div>
    <form id="contato" class="form-horizontal" action="<?php echo base_url()?>contato/submit" method="post">
    
      <div class="form-group">
        <div class="col-sm-5">
          <input type="text" class="form-control" name="nome" id="nome" placeholder="Seu nome*">
        </div>
        <div class="col-sm-5">
          <input type="email" class="form-control" name="email" id="Email" placeholder="Seu email*">
        </div>
      </div>  
     <!-- <div class="form-group">	
        <div class="col-sm-6">
          <input type="email" class="form-control" name="email" id="Email" placeholder="Seu email*">
        </div>
      </div> -->                 
      <div class="form-group">                  
        <div class="col-sm-10">
          <textarea class="form-control" name="mensagem" id="mensagem" rows="3" placeholder="Sua mensagem*"></textarea>
        </div>
      </div>
      <div class="form-group">                  
        <div class="col-sm-10">
            <input class="btn btn-default" type="submit" value="Enviar">
        </div>
      </div>                  
    </form>
</div>