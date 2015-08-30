<?php echo form_open( base_url( 'admin/login' ), array( 'id' => 'form-login', 'method' => 'post', 'class' => 'm-t', 'role' =>'form' ) ); ?>

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
    	<label for="email">Email</label>
    	<input type="email" class="form-control" id="email" name="email" placeholder="Email" value="<?php echo set_value('email');?>">
    </div>
    <div class="form-group">
    	<label for="senha">Senha</label>
    	<input type="password" class="form-control" id="senha" name="senha" placeholder="Senha">
    </div>
    
    <button type="submit" class="btn btn-primary block full-width m-b">Login</button>
    <a class="btn btn-sm btn-white btn-block" href="register.html">Recuperar Senha</a>
    
<?php echo form_close();?>