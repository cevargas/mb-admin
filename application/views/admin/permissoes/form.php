<div class="ibox-content">
   	<?php echo form_open( base_url( 'admin/permissoes/salvar' ),
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
                	placeholder="Nome" value="<?php echo (isset($permissao)) ? $permissao->nome : set_value('nome');?>">
            </div>
        </div>    
        
        <div class="form-group">
        	<label class="col-sm-2 control-label">Descrição</label>
            <div class="col-sm-6">
            	<input type="text" class="form-control" id="descricao" name="descricao"
                	placeholder="Descrição" value="<?php echo (isset($permissao)) ? $permissao->descricao : set_value('descricao');?>">
            </div>
        </div>
        
        <div class="form-group">
        	<label class="col-sm-2 control-label">Regras</label>
            <div class="col-sm-3 div-to-append">
            	<?php			

            		if(isset($roles) and count($roles) > 0) :	
						foreach($roles as $role):?>                        
                        	<div class="div-chave input-group m-b">
                            	<input type="text" class="form-control"  name="chave[]" placeholder="Ação permitida" value="<?php echo $role->chave;?>">
                            	<span class="input-group-btn"> 
                                	<button type="button" class="del-chave btn btn-warning tooltips " title="Excluir">
                            			<i class="fa fa-trash"></i>
                            		</button>
                                    <button type="button" class="add-chave btn btn-success tooltips " title="Adicionar">
                            			<i class="fa fa-asterisk"></i>
                            		</button>      
                                 </span>
                            </div>
                        <?php 								
						endforeach;		
						
					else:
					?>
						<div class="div-chave input-group m-b">
                            <input type="text" class="form-control" name="chave[]" placeholder="Ação permitida">
                            <span class="input-group-btn"> 
                                <button type="button" class="del-chave btn btn-warning tooltips " title="Excluir">
                                    <i class="fa fa-trash"></i>
                                </button>
                                <button type="button" class="add-chave btn btn-success tooltips " title="Adicionar">
                                    <i class="fa fa-asterisk"></i>
                                </button>      
                             </span>
                        </div>                        
                    <?php    				
					endif;		
				?>
            </div>
        </div>
        
        <div class="form-group">
        	<label class="col-sm-2 control-label">Controlador</label>
            <div class="col-sm-6">
            	<input type="text" class="form-control" id="controlador" name="controlador"
                	placeholder="Controlador" value="<?php echo (isset($permissao)) ? $permissao->controlador : set_value('controlador');?>">
            </div>
        </div>
  

        <div class="hr-line-dashed"></div>
        
        <div class="form-group">        	
            <div class="col-sm-offset-2 col-sm-8">    
            	 <input type="hidden" name="id" value="<?php echo (isset($permissao)) ? $permissao->id : NULL;?>" />
                 <a href="<?php echo base_url()?>admin/permissoes" class="btn btn-white ">Voltar</a>    
            	 <button type="submit" class="btn btn-primary">Salvar</button>
            </div>
        </div>    
    <?php echo form_close();?>
</div>