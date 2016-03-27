<div class="titulo">Fale aí!.</div>
<div class="descricao">
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
