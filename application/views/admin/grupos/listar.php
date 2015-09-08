<div class="ibox float-e-margins">
    <div class="ibox-title">
        <h5>GRUPOS DE USUÁRIOS </h5>        
        <div class="pull-right">
        	<a href="<?php echo base_url()?>admin/grupos/novo"
            	class="btn btn-info btn-xs btn-bitbucket tooltips" 
            	data-placement="top" title="Novo Grupo">
            	<i class="fa fa-asterisk"></i>&nbsp;Adicionar
            </a>
        </div>
    </div>
    
    <div class="ibox-content">    
    
    	<div class="row">
            <div class="col-sm-4 pull-right">
            
            	<?php echo form_open( base_url( 'admin/grupos/pesquisar' ), array( 'id' => 'form-pesquisa', 'method' => 'post' ) ); ?>
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
        <div class="table-responsive"> 
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
                                    class="btn btn-info btn-bitbucket btn-xs tooltips"
                                    data-placement="top" title="Editar">
                                        <i class="fa fa-wrench"></i>
                            </a>                        
                            <?php if($grupos->restricao == 0 and $grupos->id != $this->session->userdata('grupo_id')) :?>      
                            
                                <button type="button" class="btn btn-info btn-bitbucket btn-xs tooltips modalConfirm" 
                                    data-toggle="modal" data-placement="top" title="Excluir" 
                                    data-id="<?php echo $grupos->id;?>" data-value="<?php echo $grupos->nome?>"
                                    data-url="<?php echo base_url()?>admin/grupos/excluir/<?php echo $grupos->id;?>"
                                    data-target="#modal-confirm">
                                        <i class="fa fa-trash"></i>
                                </button>                                
                            <?php endif;?>
                        </td>
                    </tr>
                 <?php
                 endforeach;
				 
				 if(count($listar_grupos) == 0):
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