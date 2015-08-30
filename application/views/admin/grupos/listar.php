<div class="ibox float-e-margins">
    <div class="ibox-title">
        <h5>GRUPOS DE USUÁRIOS </h5>        
        <div class="pull-right">
        	<a href="<?php echo base_url()?>admin/grupos/novo"
            	class="btn btn-info btn-xs btn-bitbucket" 
            	data-toggle="tooltip" data-placement="top" title="Novo Grupo">
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
                <th>Descrição</th>
                <th>Status</th>
                <th>Opções</th>
            </tr>
            </thead>
            <tbody>
            <?php
			foreach($listar_grupos as $grupos):
            ?>
                <tr>
                    <td><?php echo $grupos->id;?></td>
                    <td><?php echo $grupos->nome?></td>
                    <td><?php echo $grupos->descricao?></td>
                    <td>
						<?php echo ($grupos->status == 1) ? '<i class="fa fa-check text-navy"></i> Ativo' : '<i class="fa fa-check text-primary"></i> Inativo';?>
                    </td>
                    <td>                    	
                    	<a href="<?php echo base_url()?>admin/grupos/editar/<?php echo $grupos->id;?>" 
                        		class="btn btn-info btn-bitbucket btn-xs"
                                data-toggle="tooltip" data-placement="top" title="Editar">
                            		<i class="fa fa-wrench"></i>
                        </a>                        
                        <?php if($grupos->restricao == 0) :?>              
                            <a href="<?php echo base_url()?>admin/grupos/excluir/<?php echo $grupos->id;?>" 
                                    class="btn btn-info btn-bitbucket btn-xs" 
                                    data-toggle="tooltip" data-placement="top" title="Excluir">
                                        <i class="fa fa-trash"></i>
                            </a>
                        <?php endif;?>
                    </td>
                </tr>
             <?php
			 endforeach;
			 ?>
            </tbody>
        </table>
    </div>
</div>