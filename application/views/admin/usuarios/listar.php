<div class="ibox float-e-margins">
    <div class="ibox-title">
        <h5>USUÁRIOS </h5>        
        <div class="pull-right">        
        	<a href="<?php echo base_url()?>admin/usuarios"
            	class="btn btn-info btn-sm btn-bitbucket tooltips" 
            	data-placement="top" title="Recarregar Usuários">
            	<i class="fa fa-refresh"></i>&nbsp;Recarregar
            </a>
            
            <?php
				if($this->acl->has_perm_list('usuarios', 'novo') == TRUE) :
			?>
        	<a href="<?php echo base_url()?>admin/usuarios/novo"
            	class="btn btn-info btn-sm btn-bitbucket tooltips" 
            	data-placement="top" title="Novo Usuário">
            	<i class="fa fa-asterisk"></i>&nbsp;Adicionar
            </a>
            <?php endif; ?> 
             
        </div>
        <div class="col-sm-4 pull-right">
            <?php echo form_open( base_url( 'admin/usuarios/listar' ), array( 'id' => 'form-pesquisa', 'method' => 'post' ) ); ?>
            <div class="input-group">
                <input type="text" name="termo" placeholder="Digite um termo" class="input-sm form-control" 
                    value="<?php if(isset($termo)) echo $termo;?>">
                <span class="input-group-btn">
                    <button type="submit" class="btn btn-sm btn-primary">Pesquisar</button> 
                </span>
            </div>
            <?php echo form_close();?>
        </div>
    </div>
    
    <div class="ibox-content">  
   		
    	<div class="table-responsive"> 
            <table class="table table-striped">
                <thead>
                <tr>
                 	<th class="col-md-1">
                    <span class="text-left">
                    <a href="<?php echo base_url()?>admin/usuarios/index?orderby=id&order=<?php if(isset($orderby) and $orderby == 'id') echo $ord; else echo 'ASC';?>&termo=<?=$termo?>&per_page=<?=$per_page?>">Código</a> 
                    </span>          
                    </th>
                    
                	<th class="col-md-3">
                    <span class="text-left">
                    <a href="<?php echo base_url()?>admin/usuarios/index?orderby=nome&order=<?php if(isset($orderby) and $orderby == 'nome') echo $ord; else echo 'ASC';?>&termo=<?=$termo?>&per_page=<?=$per_page?>">Nome</a> 
                    </span>
                    </th>
                    
                    <th class="col-md-3">
                    <span class="text-left">
                    <a href="<?php echo base_url()?>admin/usuarios/index?orderby=email&order=<?php if(isset($orderby) and $orderby == 'email') echo $ord; else echo 'ASC';?>&termo=<?=$termo?>&per_page=<?=$per_page?>">Email</a> 
                    </span>
                    </th>
                    
                  	<th class="col-md-2">
                    <span class="text-left">
                    <a href="<?php echo base_url()?>admin/usuarios/index?orderby=grupos.nome&order=<?php if(isset($orderby) and $orderby == 'grupos.nome') echo $ord; else echo 'ASC';?>&termo=<?=$termo?>&per_page=<?=$per_page?>">Grupo</a> 
                    </span>
                    </th>
                    
                    <th class="col-md-2">
                    <span class="text-left">
                    <a href="<?php echo base_url()?>admin/usuarios/index?orderby=status&order=<?php if(isset($orderby) and $orderby == 'status') echo $ord; else echo 'ASC';?>&termo=<?=$termo?>&per_page=<?=$per_page?>">Status</a> 
                    </span>
                    </th>
                    
                    <th class="col-md-1">Opções</th>
                </tr>
                </thead>
                <tbody>
                <?php
                foreach($listar_usuarios as $usuarios):
                ?>
                    <tr>
                        <td><?php echo $usuarios->id;?></td>
                        <td><?php echo $usuarios->nome?></td>
                        <td><?php echo $usuarios->email?></td>
                        <td><?php echo $usuarios->grupoNome?></td>
                        <td>
                            <?php echo ($usuarios->status == 1) ? '<span class="label label-primary">Ativo</span>' 
								: '<span class="label label-danger">Inativo</span>';?>
                        </td>
                        <td>       
                        
                        	<?php
								if($this->acl->has_perm_list('usuarios', 'editar') == TRUE) :
							?>             	
                                <a href="<?php echo base_url()?>admin/usuarios/editar/<?php echo $usuarios->id;?>" 
                                        class="btn btn-info btn-bitbucket btn-xs tooltips"
                                        data-placement="top" title="Editar">
                                            <i class="fa fa-wrench"></i>
                                </a>
                            <?php endif;?>
                            
                            <?php
								if($this->acl->has_perm_list('usuarios', 'excluir') == TRUE) :
							?>
                                <?php if($usuarios->id != $this->session->userdata('usuario_id')) :?>
                                <button type="button" class="btn btn-info btn-bitbucket btn-xs tooltips modalConfirm" 
                                        data-toggle="modal" data-placement="top" title="Excluir" 
                                        data-id="<?php echo $usuarios->id;?>" data-value="<?php echo $usuarios->nome?>"
                                        data-url="<?php echo base_url()?>admin/usuarios/excluir/<?php echo $usuarios->id;?>"
                                        data-target="#modal-confirm">
                                            <i class="fa fa-trash"></i>
                                </button>
                                <?php endif;?>
                             <?php endif;?>
                        </td>
                    </tr>
                 <?php
                  	endforeach;
				 
                  	if(count($listar_usuarios) == 0):
                 ?>                 
                  <tr>
                        <td colspan="6">Nenhum informação para exibir.</td>
                  </tr>      
                 <?php endif;?>
                </tbody>
            </table>
        </div>
        <div class="row">
            <div class="col-md-12 text-right">
                <?php echo $paginacao; ?>
            </div>
        </div>
    </div>

    <div class="modal inmodal" id="modal-confirm" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
        <div class="modal-content animated bounceInRight">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <i class="fa fa-trash modal-icon"></i>
                    <h4 class="modal-title">Confirmação</h4>
                    <small class="font-bold">Esta ação requer confirmação.</small>
                </div>
                <div class="modal-body">
                	Deseja realmente excluir <strong><span id="paramValue"></span></strong>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-white" data-dismiss="modal">Cancelar</button>
                    <a id="linkConfirm" href="#" class="btn btn-primary">Excluir</a>
                </div>
            </div>
        </div>
    </div>
        
</div>