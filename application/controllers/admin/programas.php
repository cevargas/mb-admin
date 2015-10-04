<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------
| CONTROLADOR DE PROGRAMAS	
| -------------------------------------------------------------------
| Especifica o controlador de administracao de programas da
| area de administracao
|
| controller/admin/programas
| 
*/

class Programas extends CI_Controller {
	
	public function __construct() {
		
		parent::__construct();

		//se nao tiver usuario logado redireciona para o login
		if($this->session->has_userdata('logged_in') === FALSE) {
			redirect('admin', 'location', 301);
		}
		//verifica se o grupo do usuario tem permissao para acessar o controlador, carrega no controller login
		if($this->acl->has_perm() === FALSE) {
			$this->set_error('Você não possui permissão para acessar '. strtoupper($this->uri->segment(2, 0)));
		}
	
		$this->load->model('Programas_model');
		$this->load->model('Icons_model');
	}	
	
	public function index() {		
		$this->listar();		
	}
	
	public function listar() {
		
		$data = array();
		
		//paginacao
		$config['base_url'] = base_url()."admin/programas/index";
		$config['total_rows'] = $this->Programas_model->countAll();
		$config['uri_segment'] = 4;
		
		$this->pagination->initialize($config); 	
		
		$data['paginacao'] = $this->pagination->create_links();
		$data['page'] = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;

		$programas = $this->Programas_model->getList($this->config->item('per_page'), $data['page']);
		
		$data['programa'] = 'Programas';
		$data['acao'] = 'Lista de Programas';
        $data['view'] = 'admin/programas/listar'; 
		$data['listar_programas'] = $programas;
		
		$this->load->view('admin/index', $data);
	}
	
	public function pesquisar() {
		
		$data = array();
		
		$termo = ($this->input->post('termo', TRUE)) ? $this->input->post('termo', TRUE) : $this->uri->segment(4);
		$data['termo'] = $termo;

		//paginacao
		$config['base_url'] = base_url()."admin/programas/pesquisar/".$termo;
		$config['total_rows'] = $this->Programas_model->getPesquisaNumRows($termo);
		$config['uri_segment'] = 5;
		
		$this->pagination->initialize($config); 	
		
		$data['paginacao'] = $this->pagination->create_links();
		$data['page'] = ($this->uri->segment(5)) ? $this->uri->segment(5) : 0;
		
		$programas = $this->Programas_model->getPesquisa($this->config->item('per_page'), $data['page'], $termo);
		
		$data['programa'] = 'Programas';
		$data['acao'] = 'Lista de Programas';
        $data['view'] = 'admin/programas/listar'; 
		$data['listar_programas'] = $programas;
		
		$this->load->view('admin/index', $data);
	}
	
	public function novo() {
		
		$data['programa'] = 'Programas';
		$data['acao'] = 'Adicionar Novo Programa';
		$data['view'] = 'admin/programas/form'; 
		$data['listar_programas'] = $this->Programas_model->getProgramas();
		$data['icons'] = $this->Icons_model->getIcons();
		
		$this->load->view('admin/index', $data);		
	}
	
	public function editar($id) {
		
		if(trim((int)$id)) {
		
			$programa = $this->Programas_model->getPrograma($id);
			 
			if(!$programa) {
				$this->set_error();	
				return;
			}					 
			
			$data['programa'] = 'Programas';
			$data['acao'] = 'Editar Programa';
			$data['view'] = 'admin/programas/form'; 
			$data['_programa'] = $programa;
			$data['listar_programas'] = $this->Programas_model->getProgramas();
			$data['icons'] = $this->Icons_model->getIcons();
			
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
		$this->form_validation->set_rules('url', 'URL', 'trim|required');
		$this->form_validation->set_rules('programaPai', 'parent', 'trim|required');
		
		//editar
		if(trim($this->input->post('id'))) {

			$programa = $this->Programas_model->getProgramas($this->input->post('id'));
			
			if($programa) {

				if ($this->form_validation->run() == TRUE) {						
					
					$data = array(
					   'nome' => $this->input->post('nome', TRUE),
					   'descricao' => $this->input->post('descricao', TRUE),
					   'status' => ($this->input->post('status', TRUE)) ? $this->input->post('status', TRUE) : 0,
					   'url' => $this->input->post('url', TRUE),
					   'icone' => $this->input->post('icone', TRUE),
					   'parent' => $this->input->post('programaPai', TRUE)
					);							
				}
				else {										
					$this->editar($this->input->post('id'));
					return;
				}

				$this->Programas_model->update($data, $this->input->post('id'));				
				$this->set_success("Programa editado com Sucesso.");
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
					   'status' => ($this->input->post('status', TRUE)) ? $this->input->post('status', TRUE) : 0,
					   'url' => $this->input->post('url', TRUE),
					   'icone' => $this->input->post('icone', TRUE),
					   'parent' => $this->input->post('programaPai', TRUE)
					);		
							
				$this->Programas_model->insert($data);		
				$this->set_success("Programa adicionado com Sucesso.");
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
			
			$programa = $this->Programas_model->getPrograma($id);

			//testa se o grupo existe			
			if($programa) {
				
				if($programa->status == 1) {
					$this->set_error("Programa " . $programa->nome . " está Ativo e não pode ser excluído!");
					return;
				}	
				else {					
					$this->Programas_model->delete($id);						
					$this->set_success("Programa excluído com Sucesso.");	
					return;
				}
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
		redirect('admin/programas', 'location', 303);
		exit;
	}
	
	public function set_error($mensagem = NULL) {
		
		if(!$mensagem)
			$mensagem = 'Dados inválidos!';
		
		$this->session->set_flashdata('error_msg', $mensagem);
		redirect('admin/programas', 'location', 303);	
		exit;	
	}	
}