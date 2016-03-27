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
            <div class="col-sm-6">     
            	<select name="programas_grupos[]" class="form-control select2 input-large" multiple="multiple">
 				<?php
					if(isset($programas)) {		
						foreach($programas as $programa):	
							if($programa->programaPai == 0) {
								echo "<optgroup label=".$programa->programaNome.">";							
								$hasChildren = false;
								foreach($programas as $prog): 	
									if($programa->idPrograma == $prog->programaPai) {										
										$sel = '';
										if(isset($programas_grupos)) {
											foreach($programas_grupos as $gp) :
												if($gp->id == $prog->idPrograma)
													$sel = 'selected';
											endforeach;
										}										
										$hasChildren = true;
										echo "<option value='".$prog->idPrograma."' ".$sel.">".$prog->programaNome."</option>";
									}									
								endforeach;								
								if($hasChildren == true)
									echo "</optgroup>";
							}
						endforeach;
					}
                ?>
                </select> 
            </div>
        </div>

 		<div class="form-group">
        	<label class="col-sm-2 control-label">Permissões</label>
            <div class="col-sm-6">
            	<select name="permissoes_grupos[]" class="form-control select2 input-large" multiple="multiple">
 				<?php
					if(isset($permissoes)) {
						foreach($permissoes as $permissao):
							$sel = '';
							if(isset($permissoes_grupos)) {
								foreach($permissoes_grupos as $pg) :
									if($pg->id_permissao == $permissao->id)
										$sel = 'selected';
								endforeach;
							}					
							echo "<option value='".$permissao->id."' ".$sel.">".$permissao->nome."</option>";						
						endforeach;
					}
                ?>
                </select> 
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