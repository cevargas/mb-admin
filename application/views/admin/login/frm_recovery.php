<?php echo form_open( base_url( 'admin/recovery/post' ), array( 'id' => 'form-login', 'method' => 'post', 'class' => 'm-t', 'role' =>'form' ) ); ?>

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
    	<input type="email" class="form-control" id="email" name="email" placeholder="Email" value="<?php echo set_value('email');?>">
    </div>    
    
    <button type="submit" class="btn btn-primary block full-width m-b">Enviar nova Senha</button>
    <a class="btn btn-sm btn-white btn-block" href="<?php echo base_url()?>admin/login">Voltar</a>
    
<?php echo form_close();?>