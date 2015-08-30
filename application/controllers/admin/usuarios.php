<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------
| CONTROLADOR DE USUARIOS
| -------------------------------------------------------------------
| Especifica o controlador de administracao de usuarios da
| area de administracao
|
| controller/admin/usuarios
| 
*/

class Usuarios extends CI_Controller {
	
	public function __construct() {
		
		parent::__construct();

		//se nao tiver usuario logado redireciona para o login
		if($this->session->has_userdata('logged_in') === false) {
			redirect('admin', 'location', 301);
		}
		//verifica se o grupo do usuario tem permissao para acessar o controlador, carrega no controller login
		if($this->acl->has_perm() == false) {
			$this->session->set_flashdata('error_msg', 'Você não possui permissão para acessar '. strtoupper($this->uri->segment(2, 0)));
			redirect('admin/dashboard', 'refresh');
		}
		
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->load->model('Grupos_model');
		$this->load->model('Usuarios_model');
	}	
	
	public function index() {
		$this->listar();		
	}
	
	public function listar() {

		$usuarios = $this->Usuarios_model->getList();
		
		$data['programa'] = 'Usuários';
		$data['acao'] = 'Lista de Usuários';
		$data['listar_usuarios'] = $usuarios;
        $data['view'] = 'admin/usuarios/listar'; 
				
		$this->load->view('admin/index', $data);
	}
	
	public function novo() {
		
		$grupos = $this->Grupos_model->getList();
		
		$data['programa'] = 'Usuários';
		$data['acao'] = 'Adicionar Novo Usuário';
		$data['view'] = 'admin/usuarios/form'; 
		$data['listar_grupo'] = $grupos;
		
		$this->load->view('admin/index', $data);		
	}
	
	public function editar($id = NULL) {
		
		if(trim(is_numeric($id))) {
		
			$usuario = $this->Usuarios_model->getUsuario($id);			
			$grupos = $this->Grupos_model->getList();
			 
			if(!$usuario) {
				$this->set_error();	
			}					 
			
			$data['programa'] = 'Usuários';
			$data['acao'] = 'Editar Usuário';
			$data['view'] = 'admin/usuarios/form'; 
			$data['usuario'] = $usuario;
			$data['listar_grupo'] = $grupos;
			
			$this->load->view('admin/index', $data);
		}
		else {
			$this->set_error();	
		}
	}
	
	public function salvar() {		
				
		$this->form_validation->set_rules('nome', 'Nome', 'trim|required');
		$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
		$this->form_validation->set_rules('grupo', 'Grupo', 'trim|required');
		$this->form_validation->set_rules('senha', 'Senha', 'trim|required');
		
		//criptografa a senha
		$senha = $this->Usuarios_model->cryptPass($this->input->post('email', true), $this->input->post('senha', true));
		
		$data = array(
		   'nome' => $this->input->post('nome', true),
		   'email' => $this->input->post('email', true),
		   'id_grupo' => $this->input->post('grupo', true),
		   'senha' => $senha,
		   'status' => ($this->input->post('status', true)) ? $this->input->post('status', true) : 0,
		);
		
		//editar
		if(trim(is_numeric($this->input->post('id')))) {
			
			$usuario = $this->Usuarios_model->getUsuario($this->input->post('id', true));
			
			if($usuario) {
				
				//se o email for diferente do que esta armazenado para o usuario
				//significa que ele foi alterar, entao testa se o novo email
				//esta cadastrado
				if($usuario->email != $this->input->post('email', true)) {
					
					$checkemail = $this->Usuarios_model->getUsuarioParam('usuarios.email', $this->input->post('email', true));
					
					if($checkemail) {
						$this->set_error($this->input->post('email', true) .  "não esta disponível!");	
					}				
				}			
					
				if ($this->form_validation->run() == TRUE) {			
					$this->Usuarios_model->update($data, $this->input->post('id'));					
					$this->set_success("Usuário editado com Sucesso.");
				}
				else {
					$this->editar($this->input->post('id'));
					return;
				}				
			}
			else {
				$this->set_error();	
			}
		}
		else {		
		
			if ($this->form_validation->run() == TRUE) {			
				$checkemail = $this->Usuarios_model->getUsuarioParam('usuarios.email', $this->input->post('email', true));
			
				if($checkemail) {
					$this->set_error($this->input->post('email', true) . " não esta disponível!");	
				}	
					
				$this->Usuarios_model->insert($data);		
				$this->set_success("Usuário adicionado com Sucesso.");
			}
			else {
				$this->novo();
				return;
			}
		}
	}
	
	public function excluir($id) {		
		
		if(trim(is_numeric($id))) {
			
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
						$this->set_success("Usuário excluído com Sucesso.");	
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
		redirect('admin/usuarios', 'location', 303);
		exit;
	}
	
	public function set_error($mensagem = NULL) {
		
		if(!$mensagem)
			$mensagem = 'Dados inválidos!';
		
		$this->session->set_flashdata('error_msg', $mensagem);
		redirect('admin/usuarios', 'location', 303);	
		exit;	
	}	
}