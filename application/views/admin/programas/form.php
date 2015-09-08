<div class="ibox-content">
   	<?php echo form_open( base_url( 'admin/programas/salvar' ),
				 array( 'id' => 'form-programas', 'method' => 'post', 
				 'class' => 'form-horizontal', 'role' =>'form' ) );?>

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
                <input type="text" class="form-control" id="nome" name="nome"
                	placeholder="Nome" value="<?php echo (isset($_programa)) ? $_programa->nome : set_value('nome');?>">
            </div>
        </div>    
        
        <div class="form-group">
        	<label class="col-sm-2 control-label">Descrição</label>
            <div class="col-sm-6">
            	<input type="text" class="form-control" id="descricao" name="descricao"
                	placeholder="Descrição" value="<?php echo (isset($_programa)) ? $_programa->descricao : set_value('descricao');?>">
            </div>
        </div>
        
        <div class="form-group">
        	<label class="col-sm-2 control-label">URL</label>
            <div class="col-sm-6">
            	<input type="text" class="form-control" id="url" name="url"
                	placeholder="URL Controller" value="<?php echo (isset($_programa)) ? $_programa->url : set_value('url');?>">
            </div>
        </div>
  
        <div class="form-group">
        	<label class="col-sm-2 control-label">Icone</label>
            <div class="col-sm-3">
            	<select data-tags="true" name="icone" class="form-control select2" placeholder="Selecione"> 
                	<option value=""></option>
                    <?php					
					foreach($icons as $icon) :
						$selected = '';
						if(isset($_programa)) {							
							if($_programa->icone == $icon) {
								$selected = 'selected';	
							}
						}
                    ?>
                    	<option value="<?=$icon?>" <?php echo $selected;?>><?=$icon?></option>
                  	<?php
						endforeach;
					?>
                </select> 
            </div>
        </div>

        <div class="form-group">
        	<label class="col-sm-2 control-label">Programa Pai</label>
            <div class="col-sm-3">            
            	<select name="programaPai" class="form-control select2" placeholder="Selecione"> 
                	<option value=""></option>
                    <option value="0" <?php if(isset($_programa) and $_programa->programaPai == 0) echo 'selected';?>>Este é o Pai</option>
                    <?php		
						unset($selected);				
						foreach($listar_programas as $programas) :
							$selected = '';
							if(isset($_programa)) {								
								if($_programa->programaPai != 0 and $_programa->programaPai == $programas->id){
									$selected = 'selected';
								}
							}
							if($_programa->id != $programas->id) :
					?>
                    		<option value="<?php echo $programas->id?>" <?php echo $selected;?>><?php echo $programas->nome?></option>
                    <?php 
							endif;
						endforeach;
					?>                
                </select>                            
            </div>
        </div>

		<div class="form-group">
        	<label class="col-sm-2 control-label">Ativo</label>
			<div class="col-sm-6">             
            	 <input type="checkbox" class="js-switch" value="1" id="status" name="status" 
					<?php echo (isset($_programa) and $_programa->status == 1) ? "checked" : "";?>>  
            </div>
        </div>
        
        <div class="hr-line-dashed"></div>
        
        <div class="form-group">        	
            <div class="col-sm-offset-2 col-sm-8">    
            	 <input type="hidden" name="id" value="<?php echo (isset($_programa)) ? $_programa->id : NULL;?>" />
                 <a href="<?php echo base_url()?>admin/programas" class="btn btn-white ">Voltar</a>    
            	 <button type="submit" class="btn btn-primary">Salvar</button>
            </div>
        </div>    
    <?php echo form_close();?>
</div>