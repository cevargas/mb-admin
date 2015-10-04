<div class="ibox-content">
   	<?php echo form_open_multipart( base_url( 'admin/perfil/salvar' ), 
				array( 'id' => 'form-perfil', 'method' => 'post', 
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
        
        <?php endif;?>
      
        <div class="hr-line-dashed"></div>
        
        <div class="form-group">        	
            <div class="col-sm-offset-2 col-sm-8">    
                 <a href="<?php echo base_url()?>admin" class="btn btn-white ">Início</a>        
            	 <button type="submit" class="btn btn-primary">Salvar</button>                 
            </div>
        </div>   
    <?php echo form_close();?>
</div>