<?php echo form_open( base_url( 'admin/recovery/resetpass' ), array( 'id' => 'form-login', 'method' => 'post', 'class' => 'm-t', 'role' =>'form' ) ); ?>

	<?php 
		if(strlen(validation_errors()) > 0):
		?>
        	<div class="alert alert-danger">	
				<?php echo validation_errors(); ?>
            </div>
		<?php
		endif;	
	?>
    
    <?php		
		if($this->session->flashdata('success_msg') != NULL) :
	?>
    	<div class="alert alert-success">	
    		<?php echo $this->session->flashdata('success_msg');?>
    	</div>
    <?php endif;?>  
    
    <?php		
		if($this->session->flashdata('error_msg') != NULL) :
	?>
    	<div class="alert alert-danger">	
    		<?php echo $this->session->flashdata('error_msg');?>
    	</div>
    <?php endif;?> 

    <div class="form-group">
    	<input type="email" class="form-control" id="email" name="email" placeholder="Email" value="<?php echo $email;?>">
    </div>    
    
    <div class="form-group">
    	<input type="password" class="form-control" id="senha" name="senha" placeholder="Nova Senha">
    </div>
    
    <div class="form-group">
    	<input type="password" class="form-control" id="confsenha" name="confsenha" placeholder="Confirme a Nova Senha">
    </div>
    
    <input type="hidden" name="token" value="<?php echo $token;?>" /> 
    
    <button type="submit" class="btn btn-primary block full-width m-b">Salvar nova Senha</button>
    <a class="btn btn-sm btn-white btn-block" href="<?php echo base_url()?>admin/login">Login</a>
    
<?php echo form_close();?>