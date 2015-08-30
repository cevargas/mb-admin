<div class="ibox float-e-margins">
    <div class="ibox-title">
        <h5>USUÁRIOS </h5>        
        <div class="pull-right">
        	<a href="<?php echo base_url()?>admin/usuarios/novo"
            	class="btn btn-info btn-xs btn-bitbucket" 
            	data-toggle="tooltip" data-placement="top" title="Novo Usuário">
            	<i class="fa fa-asterisk"></i>&nbsp;Adicionar
            </a>
        </div>
    </div>
    
    <div class="ibox-content">    
        <table class="table table-striped">
            <thead>
            <tr>
                <th>#</th>
                <th>Nome</th>
                <th>Email</th>
                <th>Grupo</th>
                <th>Status</th>
                <th>Opções</th>
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
						<?php echo ($usuarios->status == 1) ? '<i class="fa fa-check text-navy"></i> Ativo' : '<i class="fa fa-check text-primary"></i> Inativo';?>
                    </td>
                    <td>                    	
                    	<a href="<?php echo base_url()?>admin/usuarios/editar/<?php echo $usuarios->id;?>" 
                        		class="btn btn-info btn-bitbucket btn-xs"
                                data-toggle="tooltip" data-placement="top" title="Editar">
                            		<i class="fa fa-wrench"></i>
                        </a>
                        
                        <a href="<?php echo base_url()?>admin/usuarios/excluir/<?php echo $usuarios->id;?>" 
                                class="btn btn-info btn-bitbucket btn-xs" 
                                data-toggle="tooltip" data-placement="top" title="Excluir">
                                    <i class="fa fa-trash"></i>
                        </a>
                    </td>
                </tr>
             <?php
			 endforeach;
			 ?>
            </tbody>
        </table>
    </div>
</div>