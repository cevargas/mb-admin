<div class="ibox-content">
   	<?php echo form_open_multipart( base_url( 'admin/usuarios/salvar' ), 
				array( 'id' => 'form-usuarios', 'method' => 'post', 
						'class' => 'form-horizontal', 'role' =>'form', 
						'autocomplete' => 'off' ) ); 
	?>

	<?php 
		if(strlen(validation_errors()) > 0):
		?>
        	<div class="alert alert-danger">	
				<?php echo validation_errors();?>
            </div>
		<?php
		endif;	
	?>
    
       <div class="form-group">
        	<label class="col-sm-2 control-label">Grupo</label>
            <div class="col-sm-3">
            
            	<select data-tags="true" name="grupo" class="form-control select2" placeholder="Selecione"> 
                	<option value=""></option>
                     <?php foreach($listar_grupo as $grupos) :
			   
			   			$sel = '';
						$disabled = '';
						if(isset($usuario)) {
			   				if($grupos->id == $usuario->id_grupo) 
								$sel = 'selected';
						}					
			   			?>
                    	<option value="<?php echo $grupos->id?>" <?php echo $sel;?>><?php echo $grupos->nome?></option>
                  	<?php
						endforeach;
					?>
                </select> 
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
        	<label class="col-sm-2 control-label">Foto</label>
            <div class="col-sm-6">
            <p>
				<?php if(isset($usuario) and $usuario->foto):?>          
                    <img src="<?php echo base_url() ?>public/admin/images/users/resized/<?php echo $usuario->foto;?>" alt="Foto do Perfil" />
                <?php endif;?>
            </p>
            <p>            
				<?php
                    $image = array(
                        'name'  =>  'arquivo',
                        'id'    =>  'arquivo',
                    );
                ?>
				<?php echo form_upload($image); ?>
            </p>
                
            </div>         
        </div>

        <?php 
			$hiddenPass = '';
			if(isset($usuario)):
				$hiddenPass = 'hidden'
		?>
        <div class="form-group ">
        	<label class="col-sm-2 control-label">Senha</label>
            <div class="col-sm-6">
            	<p class="form-control-static"><a href="javascritp:;" class="altpass">Alterar senha</a></p>
                <input type="hidden" id="alterar_senha" name="alterar_senha" value="" />
            </div>
        </div>

        <div class="form-group passw <?php echo $hiddenPass?>">
        	<label class="col-sm-2 control-label">Senha Atual</label>
            <div class="col-sm-6">
            	<input type="password" style="display:none"/>
            	<input type="password" autocomplete="off" class="form-control" id="senha_atual" name="senha_atual"
                	placeholder="Senha Atual" value="">
            </div>
        </div>
        
        <div class="form-group passw <?php echo $hiddenPass?>">
        	<label class="col-sm-2 control-label">Nova Senha</label>
            <div class="col-sm-6">
            	<input type="password" style="display:none"/>
            	<input type="password" autocomplete="off" class="form-control" id="nova_senha" name="nova_senha"
                	placeholder="Nova Senha" value="">
            </div>
        </div>
        
        <div class="form-group passw <?php echo $hiddenPass?>">
        	<label class="col-sm-2 control-label">Confirmação</label>
            <div class="col-sm-6">
            	<input type="password" style="display:none"/>
            	<input type="password" autocomplete="off" class="form-control" id="conf_nova_senha" name="conf_nova_senha"
                	placeholder="Confirmação da Nova Senha" value="">
            </div>
        </div>
        
        <?php else: ?>
        
        <div class="form-group">
        	<label class="col-sm-2 control-label">Senha</label>
            <div class="col-sm-6">
            	<input type="password" style="display:none"/>
            	<input type="password" autocomplete="off" class="form-control" id="senha" name="senha"
                	placeholder="Senha" value="">
            </div>
        </div>
        
        <div class="form-group">
        	<label class="col-sm-2 control-label">Confirmação</label>
            <div class="col-sm-6">
            	<input type="password" style="display:none"/>
            	<input type="password" autocomplete="off" class="form-control" id="conf_senha" name="conf_senha"
                	placeholder="Confirme a Senha" value="">
            </div>
        </div>
        <input type="hidden" id="alterar_senha" name="alterar_senha" value="" />
        
 		<?php endif;?>
 
		<div class="form-group">
        	<label class="col-sm-2 control-label">Status</label>
			<div class="col-sm-6">
                <input type="checkbox" class="js-switch" value="1" id="status" name="status"
               		 <?php echo (isset($usuario) and $usuario->status == 1) ? "checked" : "";?>
                     <?php echo (isset($usuario) and $usuario->id == $this->session->userdata('usuario_id')) ? "disabled" : "";?>>      
            </div>
        </div>
        
        <div class="hr-line-dashed"></div>
        
        <div class="form-group">        	
            <div class="col-sm-offset-2 col-sm-8">    
            	 <input type="hidden" name="id" value="<?php echo (isset($usuario)) ? $usuario->id : NULL;?>" /> 
                 <a href="<?php echo base_url()?>admin/usuarios" class="btn btn-white ">Voltar</a>        
            	 <button type="submit" class="btn btn-primary">Salvar</button>                 
            </div>
        </div>   
    <?php echo form_close();?>
</div>