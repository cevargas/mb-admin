<div class="ibox-content">
   	<?php echo form_open( base_url( 'admin/usuarios/salvar' ), array( 'id' => 'form-usuarios', 'method' => 'post', 'class' => 'form-horizontal', 'role' =>'form', 'autocomplete' => 'off' ) ); ?>

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
        	<label class="col-sm-2 control-label">Grupo</label>
            <div class="col-sm-6">
  
			   <?php foreach($listar_grupo as $grupos) :
			   
			   			$check = '';
						if(isset($usuario))
			   				if($grupos->id == $usuario->id_grupo) 
								$check = 'checked';
			   ?>
                    <div class="radio i-checks">
                        <label> 
                        	<input type="radio" <?php echo $check;?> value="<?php echo $grupos->id?>" name="grupo"> 
                            <i></i>
                             <?php echo $grupos->nome?> 
                        </label>
                    </div>
                <?php endforeach;?>    
               
            </div>
        </div>
        
        <div class="form-group">
            <label class="col-sm-2 control-label">Nome</label>
            <div class="col-sm-6">
                <input type="text" class="form-control" id="nome" name="nome" 
                	placeholder="Nome" value="<?php echo (isset($usuario)) ? $usuario->nome : set_value('nome');?>">
            </div>
        </div>    
        
        <div class="form-group">
        	<label class="col-sm-2 control-label">Email</label>
            <div class="col-sm-6">
            	<input type="text" autocomplete="off" class="form-control" id="email" name="email"
                	placeholder="Email" value="<?php echo (isset($usuario)) ? $usuario->email : set_value('email');?>">
            </div>
        </div>
        
        <div class="form-group">
        	<label class="col-sm-2 control-label">Senha</label>
            <div class="col-sm-6">
            	<input type="password" style="display:none"/>
            	<input type="password" autocomplete="off" class="form-control" id="senha" name="senha"
                	placeholder="Senha" value="">
            </div>
        </div>

		<div class="form-group">
        	<label class="col-sm-2 control-label">Ativo</label>
			<div class="col-sm-6">            	
            	<label class="checkbox-inline i-checks">
                	<input type="checkbox"
                        value="1" 
                        id="status"
                        name="status"
                         <?php echo (isset($usuario) and $usuario->status == 1) ? "checked" : "";?>>
                </label>               
            </div>
        </div>
        
        <div class="hr-line-dashed"></div>
        
        <div class="form-group">        	
            <div class="col-sm-offset-2 col-sm-8">    
            	 <input type="hidden" name="id" value="<?php echo (isset($usuario)) ? $usuario->id : NULL;?>" />         
            	 <button type="submit" class="btn btn-primary">Salvar</button>
                 <a href="<?php echo base_url()?>admin/usuarios" class="btn btn-white ">Voltar</a>
            </div>
        </div>

	</form>
    
    <?php echo form_close();?>
</div>