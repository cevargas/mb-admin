<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------
| CONTROLADOR DE GRUPOS
| -------------------------------------------------------------------
| Especifica o controlador de administracao de grupos da
| area de administracao
|
| controller/admin/grupos
| 
*/

class Grupos extends CI_Controller {
	
	public function __construct() {
		
		parent::__construct();

		//se nao tiver usuario logado redireciona para o login
		if($this->session->has_userdata('logged_in') === false) {
			redirect('admin', 'location', 301);
		}
		//verifica se o grupo do usuario tem permissao para acessar o controlador, carrega no controller login
		if($this->acl->has_perm() == false) {
			$this->set_error('Você não possui permissão para acessar '. strtoupper($this->uri->segment(2, 0)));
		}
	
		$this->load->model('Grupos_model');
		$this->load->model('Usuarios_model');
		$this->load->model('Programas_model');
	}	
	
	public function index() {		
		$this->listar();		
	}
	
	public function listar() {
		
		$data = array();
		
		//paginacao
		$config['base_url'] = base_url()."admin/grupos/index";
		$config['total_rows'] = $this->Grupos_model->countAll();
		$config['uri_segment'] = 4;
		
		$this->pagination->initialize($config); 	
		
		$data['paginacao'] = $this->pagination->create_links();
		$data['page'] = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;

		$grupos = $this->Grupos_model->getList($this->config->item('per_page'), $data['page']);

		$data['programa'] = 'Grupos';
		$data['acao'] = 'Lista de Grupos';
        $data['view'] = 'admin/grupos/listar'; 
		$data['listar_grupos'] = $grupos;
		
		$this->load->view('admin/index', $data);
	}
	
	public function pesquisar() {
		
		$data = array();
		
		$termo = ($this->input->post('termo')) ? $this->input->post('termo') : $this->uri->segment(4);
		$data['termo'] = $termo;

		//paginacao
		$config['base_url'] = base_url()."admin/grupos/pesquisar/".$termo;
		$config['total_rows'] = $this->Grupos_model->getPesquisaNumRows($termo);
		$config['uri_segment'] = 5;
		
		$this->pagination->initialize($config); 	
		
		$data['paginacao'] = $this->pagination->create_links();
		$data['page'] = ($this->uri->segment(5)) ? $this->uri->segment(5) : 0;
		
		$grupos = $this->Grupos_model->getPesquisa($this->config->item('per_page'), $data['page'], $termo);
		
		$data['programa'] = 'Grupos';
		$data['acao'] = 'Lista de Grupos';
        $data['view'] = 'admin/grupos/listar'; 
		$data['listar_grupos'] = $grupos;
		
		$this->load->view('admin/index', $data);
	}
	
	public function novo() {
		
		$data = array();
		
		$data['programas'] = $this->Programas_model->getProgramas();
		
		$data['programa'] = 'Grupos';
		$data['acao'] = 'Adicionar Novo Grupo';
		$data['view'] = 'admin/grupos/form'; 
		
		$this->load->view('admin/index', $data);		
	}
	
	public function editar($id) {
		
		$data = array();
		
		if(trim(is_numeric((int)$id))) {
		
			$data['programas'] = $this->Programas_model->getProgramas();
			//$data['grupo_programas'] = $this->Grupos_model->getGruposProgramas($id);

			$grupo = $this->Grupos_model->getGrupo($id);
			 
			if(!$grupo) {
				$this->set_error();	
			}					 
			
			$data['programa'] = 'Grupos';
			$data['acao'] = 'Editar Grupo';
			$data['view'] = 'admin/grupos/form'; 
			$data['grupo'] = $grupo;
			
			$this->load->view('admin/index', $data);
		}
		else {
			$this->set_error();	
		}
	}
	
	public function salvar() {
		
		//editar
		if(trim($this->input->post('id'))) {

			$grupo = $this->Grupos_model->getGrupo($this->input->post('id'));
			
			if($grupo) {
				
				if($grupo->restricao == 0) {
					
					$this->form_validation->set_rules('nome', 'Nome', 'trim|required');
					$this->form_validation->set_rules('descricao', 'Descrição', 'trim|required|max_length[255]');

  					if ($this->form_validation->run() == TRUE) {						
						
						$data = array(
						   'nome' => $this->input->post('nome', true),
						   'descricao' => $this->input->post('descricao', true),
						   'status' => ($this->input->post('status', true)) ? $this->input->post('status', true) : 0,
						   'restricao' => 0
						);							
					}
					else {										
						$this->editar($this->input->post('id'));
						return;
					}
				}
				else {
					
					$this->form_validation->set_rules('descricao', 'Descrição', 'trim|required|max_length[255]');					
					if ($this->form_validation->run() == TRUE) {
						
						$data = array(
						   'descricao' => $this->input->post('descricao', true)
						);	
								
					}
					else {										
						$this->editar($this->input->post('id'));
						return;
					}
				}

				$this->Grupos_model->update($data, $this->input->post('id'));					
				$this->set_success("Grupo editado com Sucesso.");
			}
			else {
				$this->set_error();	
			}
		}
		//novo
		else {
			
			$this->form_validation->set_rules('nome', 'Nome', 'trim|required');
			$this->form_validation->set_rules('descricao', 'Descrição', 'trim|required|max_length[255]');

			if ($this->form_validation->run() == TRUE) {
				
				$data = array(
				   'nome' => $this->input->post('nome', true),
				   'descricao' => $this->input->post('descricao', true),
				   'status' => ($this->input->post('status', true)) ? $this->input->post('status', true) : 0,
				   'restricao' => 0
				);		
								
				$this->Grupos_model->insert($data);		
				$this->set_success("Grupo adicionado com Sucesso.");
			}
			else {										
				$this->novo();
				return;
			}
		}
	}
	
	public function excluir($id) {		
		
		if(trim(is_numeric((int)$id))) {
			
			$grupo = $this->Grupos_model->getGrupo($id);

			//testa se o grupo existe			
			if($grupo) {
			
				//testa se o grupo pode ser excluir
				if($grupo->restricao == 1) {
					$this->set_error("Grupo " . $grupo->nome . " possui Restrição e não pode ser excluído!");
				}
				else if($grupo->status == 1) {
					$this->set_error("Grupo " . $grupo->nome . " está Ativo e não pode ser excluído!");
				}	
				else {
					//testa se o grupo tem usuarios vinculados
					$usuarios = $this->Usuarios_model->countUsuariosByGrupo($id);	

					if($usuarios > 0) {
						$this->set_error("Grupo " . $grupo->nome . " possui Usuários vinculados e não pode ser excluído!");
					}						
					else {				
						$this->Grupos_model->delete($id);						
						$this->set_success("Grupo excluído com Sucesso.");	
					}
				}
			}
			else {
				$this->set_error();	
			}
		}
		else {
			$this->set_error();	
		}
	}
	
	public function set_success($mensagem = NULL) {
		
		if(!$mensagem)
			$mensagem = 'Dados salvos com sucesso';
		
		$this->session->set_flashdata('success_msg', $mensagem);
		redirect('admin/grupos', 'location', 303);
		exit;
	}
	
	public function set_error($mensagem = NULL) {
		
		if(!$mensagem)
			$mensagem = 'Dados inválidos!';
		
		$this->session->set_flashdata('error_msg', $mensagem);
		redirect('admin/grupos', 'location', 303);	
		exit;	
	}	
}