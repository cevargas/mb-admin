<div class="ibox float-e-margins">
    <div class="ibox-title">
        <h5>PROGRAMAS </h5>        
        <div class="pull-right">
        	<a href="<?php echo base_url()?>admin/programas"
            	class="btn btn-info btn-sm btn-bitbucket tooltips" 
            	data-placement="top" title="Recarregar Programas">
            	<i class="fa fa-refresh"></i>&nbsp;Recarregar
            </a>
        	<a href="<?php echo base_url()?>admin/programas/novo"
            	class="btn btn-info btn-sm btn-bitbucket tooltips" 
            	data-placement="top" title="Novo Programa">
            	<i class="fa fa-asterisk"></i>&nbsp;Adicionar
            </a>
        </div>
        <div class="col-sm-4 pull-right">            
			<?php echo form_open( base_url( 'admin/programas/listar' ), array( 'id' => 'form-pesquisa', 'method' => 'post' ) ); ?>
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
                    <a href="<?php echo base_url()?>admin/programas/index?orderby=id&order=<?php if(isset($orderby) and $orderby == 'id') echo $ord; else echo 'ASC';?>&termo=<?=$termo?>&per_page=<?=$per_page?>">Código</a> 
                    </span>                    
                    <span class="text-right"><i class="fa <?php if(isset($orderby) and $orderby == 'id' and $ord == 'ASC') { ?>fa-sort-numeric-desc<?php } else {?>fa-sort-numeric-asc<?php }?> text-warning"></i></span>
                    </th>
                   
                    <th class="col-md-2">
                    <span class="text-left">
                    <a href="<?php echo base_url()?>admin/programas/index?orderby=nome&order=<?php if(isset($orderby) and $orderby == 'nome') echo $ord; else echo 'ASC';?>&termo=<?=$termo?>&per_page=<?=$per_page?>">Nome</a> 
                    </span>
                    <span class="text-right"><i class="fa <?php if(isset($orderby) and $orderby == 'nome' and $ord == 'ASC') { ?>fa-sort-alpha-desc<?php  } else {?>fa-sort-alpha-asc<?php } ?> text-warning"></i></span>
                    </th>
                    
                    <th class="col-md-7">
                    <span class="text-left">
                    <a href="<?php echo base_url()?>admin/programas/index?orderby=descricao&order=<?php if(isset($orderby) and $orderby == 'descricao') echo $ord; else echo 'ASC';?>&termo=<?=$termo?>&per_page=<?=$per_page?>">Descrição</a> 
                    </span>                    
                    <span class="text-right"><i class="fa <?php if(isset($orderby) and $orderby == 'descricao' and $ord == 'ASC') { ?>fa-sort-alpha-desc<?php  } else {?>fa-sort-alpha-asc<?php } ?> text-warning"></i></span>
                    </th>
                    
                    <th class="col-md-1">
                    <span class="text-left">
                    <a href="<?php echo base_url()?>admin/programas/index?orderby=status&order=<?php if(isset($orderby) and $orderby == 'status') echo $ord; else echo 'ASC';?>&termo=<?=$termo?>&per_page=<?=$per_page?>">Status</a>
                    </span>
                    <span class="text-right"><i class="fa <?php if(isset($orderby) and $orderby == 'status' and $ord == 'ASC') { ?>fa-sort-alpha-desc<?php  } else {?>fa-sort-alpha-asc<?php } ?> text-warning"></i></span>
                    </th>
                    
                    <th class="col-md-1">Opções</th>
                </tr>
                </thead>
                <tbody>
                <?php
                foreach($listar_programas as $programas):
                ?>
                    <tr>
                        <td><?php echo $programas->id;?></td>
                        <td><?php echo $programas->nome?></td>
                        <td><?php echo $programas->descricao?></td>
                        <td>
                            <?php echo ($programas->status == 1) ? '<i class="fa fa-check text-navy"></i> Ativo' : '<i class="fa fa-check text-primary"></i> Inativo';?>
                        </td>
                        <td>                    	
                            <a href="<?php echo base_url()?>admin/programas/editar/<?php echo $programas->id;?>" 
                                    class="btn btn-info btn-bitbucket btn-xs tooltips"
                                    data-placement="top" title="Editar">
                                        <i class="fa fa-wrench"></i>
                            </a>                        
                            <button type="button" class="btn btn-info btn-bitbucket btn-xs tooltips modalConfirm" 
                                data-toggle="modal" data-placement="top" title="Excluir" 
                                data-id="<?php echo $programas->id;?>" data-value="<?php echo $programas->nome?>"
                                data-url="<?php echo base_url()?>admin/programas/excluir/<?php echo $programas->id;?>"
                                data-target="#modal-confirm">
                                    <i class="fa fa-trash"></i>
                            </button>                               

                        </td>
                    </tr>
                 <?php
                 endforeach;
				 
				 if(count($listar_programas) == 0):
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