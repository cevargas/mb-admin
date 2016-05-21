<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------
| CONTROLADOR DE PERMISSOES	
| -------------------------------------------------------------------
| Especifica o controlador de administracao de permissoes da
| area de administracao
|
| controller/admin/permissoes
| 
*/

class Permissoes extends CI_Controller {
	
	public function __construct() {
		
		parent::__construct();

		//se nao tiver usuario logado redireciona para o login
		if($this->session->has_userdata('logged_in') === FALSE) {
			redirect('admin', 'location', 301);
		}
		//verifica se o grupo do usuario tem permissao para acessar o controlador, carrega no controller login
		if($this->acl->has_perm() === FALSE) {
			$ctr = strtoupper($this->uri->segment(2, 0));
			$mtd = ($this->uri->segment(3, 0)) ? ' / ' . strtoupper($this->uri->segment(3, 0)) : '';
			
			$this->session->set_flashdata('error_msg', 'Você não possui permissão para acessar '. $ctr . $mtd);
			redirect('admin/dashboard', 'refresh');
		}
	
		$this->load->model('Permissoes_model');
	}	
	
	public function index() {		
		$this->listar();		
	}
	
	public function listar() {
		
		$data = array();
		
		$data['per_page'] = ($this->input->get('per_page')) ? $this->input->get('per_page') : 1;	
		$data['orderby'] = ($this->input->get('orderby')) ? $this->input->get('orderby') : 'nome';	
		$data['order'] = ($this->input->get('order')) ? $this->input->get('order') : 'ASC';	
		$data['termo'] = ($this->input->post('termo', TRUE)) ? $this->input->post('termo', TRUE) : $this->input->get('termo');

		if($this->input->post('termo')) {
			$config['total_rows'] = $this->Permissoes_model->getPesquisaNumRows($data['termo']);
			$config['base_url'] = site_url("admin/permissoes/index?termo={$data['termo']}");
		}
		else {
			$config['total_rows'] = $this->Permissoes_model->countAll();
			$config['base_url'] = site_url("admin/permissoes/index/");
		}
		
		$offset = ($data['per_page'] == 1) ? 0 : ($data['per_page'] * $this->config->item('per_page')) - $this->config->item('per_page');
		
		$this->pagination->initialize($config);		
		$data['paginacao'] = $this->pagination->create_links();	

		if($data['order'] == 'ASC')
			$data['ord'] = 'DESC';
		else
			$data['ord'] = 'ASC';
			
		$permissoes = $this->Permissoes_model->getList($this->config->item('per_page'), $offset, $data['orderby'], $data['order'], $data['termo']);
		
		$data['programa'] = 'Permissões';
		$data['acao'] = 'Lista de Permissões';
        $data['view'] = 'admin/permissoes/listar'; 
		$data['permissoes'] = $permissoes;
		
		$this->load->view('admin/index', $data);
	}
	
	public function pesquisar() {
		
		$data = array();
		
		$termo = ($this->input->post('termo', TRUE)) ? $this->input->post('termo', TRUE) : $this->uri->segment(4);
		$data['termo'] = $termo;

		//paginacao
		$config['base_url'] = base_url()."admin/permissoes/pesquisar/".$termo;
		$config['total_rows'] = $this->Permissoes_model->getPesquisaNumRows($termo);
		$config['uri_segment'] = 5;
		
		$this->pagination->initialize($config); 	
		
		$data['paginacao'] = $this->pagination->create_links();
		$data['page'] = ($this->uri->segment(5)) ? $this->uri->segment(5) : 0;
		
		$permissoes = $this->Permissoes_model->getPesquisa($this->config->item('per_page'), $data['page'], $termo);
		
		$data['programa'] = 'Permissões';
		$data['acao'] = 'Lista de Permissões';
        $data['view'] = 'admin/permissoes/listar'; 
		$data['permissoes'] = $permissoes;
		
		$this->load->view('admin/index', $data);
	}
	
	public function novo() {
		
		$data['programa'] = 'Permissões';
		$data['acao'] = 'Adicionar Nova Permissão';
		$data['view'] = 'admin/permissoes/form'; 
		$data['permissoes'] = $this->Permissoes_model->getPermissoes();
		
		$this->load->view('admin/index', $data);		
	}
	
	public function editar($id) {
		
		if(trim((int)$id)) {

			$permissao = $this->Permissoes_model->getPermissao($id);			
			$roles = $this->Permissoes_model->getPermissoesRegra($id);
			 
			if(!$permissao) {
				$this->set_error();	
				return;
			}		
			
			$data['programa'] = 'Permissões';
			$data['acao'] = 'Editar Permissão';
			$data['view'] = 'admin/permissoes/form'; 
			$data['permissao'] = $permissao;
			$data['roles'] = $roles;
			
			$this->load->view('admin/index', $data);
		}
		else {
			$this->set_error();	
			return;
		}
	}
	
	public function salvar() {
		
		$this->form_validation->set_rules('nome', 'Nome', 'trim|required');
		$this->form_validation->set_rules('descricao', 'Descrição', 'trim|required|max_length[255]');
		$this->form_validation->set_rules('controlador', 'Controlador', 'trim|required');
		
		//editar
		if(trim($this->input->post('id'))) {

			$permissao = $this->Permissoes_model->getPermissao($this->input->post('id'));
			
			if($permissao) {

				if ($this->form_validation->run() == TRUE) {						
					
					$data = array(
					   'nome' => $this->input->post('nome', TRUE),
					   'descricao' => $this->input->post('descricao', TRUE),
					   'controlador' => $this->input->post('controlador', TRUE)
					);
				}
				else {										
					$this->editar($this->input->post('id'));
					return;
				}

				$this->Permissoes_model->update($data, $this->input->post('id'));	
			
				//permissoes regras
				if($this->input->post('chave')) {
					
					$this->Permissoes_model->deletePermissoesRegras($this->input->post('id'));

					foreach($this->input->post('chave') as $gp) {
						
						if($gp) {						
							$datac['id_permissao'] = $this->input->post('id');
							$datac['chave'] = $gp;
							$this->Permissoes_model->insertPermissoesRegras($datac);
						}
					}			
				}
							
				$this->set_success("Permissão editada com Sucesso.");
				return;
			}
			else {
				$this->set_error();	
				return;
			}
		}
		//novo
		else {
					
			if ($this->form_validation->run() == TRUE) {
				
				$data = array(
				   'nome' => $this->input->post('nome', TRUE),
				   'descricao' => $this->input->post('descricao', TRUE),
				   'chave' => $this->input->post('chave', TRUE),
				   'controlador' => $this->input->post('controlador', TRUE)
				);	
							
				$this->Permissoes_model->insert($data);		
				$this->set_success("Permissão adicionada com Sucesso.");
				return;
			}
			else {										
				$this->novo();
				return;
			}
		}
	}
	
	public function excluir($id) {		
		
		if(trim((int)$id)) {
			
			$permissao = $this->Permissoes_model->getPermissao($id);

			if($permissao) {
					
				$this->Permissoes_model->delete($id);						
				$this->set_success("Permissão excluída com Sucesso.");	
				return;
				
			}
			else {
				$this->set_error();	
				return;
			}
		}
		else {
			$this->set_error();	
			return;
		}
	}
	
	public function set_success($mensagem = NULL) {
		
		if(!$mensagem)
			$mensagem = 'Dados salvos com sucesso';
		
		$this->session->set_flashdata('success_msg', $mensagem);
		redirect('admin/permissoes', 'location', 303);
		exit;
	}
	
	public function set_error($mensagem = NULL) {
		
		if(!$mensagem)
			$mensagem = 'Dados inválidos!';
		
		$this->session->set_flashdata('error_msg', $mensagem);
		redirect('admin/permissoes', 'location', 303);	
		exit;	
	}	
}