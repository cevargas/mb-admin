<div class="ibox-content">
   	<?php echo form_open( base_url( 'admin/grupos/salvar' ), array( 'id' => 'form-grupos', 'method' => 'post', 'class' => 'form-horizontal', 'role' =>'form' ) ); ?>

	<?php 
		if(strlen(validation_errors()) > 0):
		?>
        	<div class="alert alert-danger">	
				<?php echo validation_errors(); ?>
            </div>
		<?php
		endif;	
	?>
        <div class="form-group">
            <label class="col-sm-2 control-label">Nome</label>
            <div class="col-sm-6">
                <input type="text" class="form-control" id="nome" name="nome" <?php echo (isset($grupo) and $grupo->restricao == 1) ? 'disabled' : '';?>
                	placeholder="Nome" value="<?php echo (isset($grupo)) ? $grupo->nome : set_value('nome');?>">
            </div>
        </div>    
        
        <div class="form-group">
        	<label class="col-sm-2 control-label">Descrição</label>
            <div class="col-sm-6">
            	<input type="text" class="form-control" id="descricao" name="descricao"
                	placeholder="Descrição" value="<?php echo (isset($grupo)) ? $grupo->descricao : set_value('descricao');?>">
            </div>
        </div>

        <div class="form-group">
        	<label class="col-sm-2 control-label">Programas</label>
            <div class="col-sm-8">   
          
				<?php
					if(isset($programas))
                    	echo '<ul class="programas">'.$programas.'</ul>';
                ?> 
                  
            </div>
        </div>

		<div class="form-group">
        	<label class="col-sm-2 control-label">Ativo</label>
			<div class="col-sm-6">             
            	 <input type="checkbox" class="js-switch" value="1" id="status" name="status" 
					<?php echo (isset($grupo) and $grupo->restricao == 1) ? "disabled" : "";?>
					<?php echo (isset($grupo) and $grupo->status == 1) ? "checked" : "";?>>  
            </div>
        </div>
        
        <div class="hr-line-dashed"></div>
        
        <div class="form-group">        	
            <div class="col-sm-offset-2 col-sm-8">    
            	 <input type="hidden" name="id" value="<?php echo (isset($grupo)) ? $grupo->id : NULL;?>" />
                 <a href="<?php echo base_url()?>admin/grupos" class="btn btn-white ">Voltar</a>    
            	 <button type="submit" class="btn btn-primary">Salvar</button>
            </div>
        </div>    
    <?php echo form_close();?>
</div>