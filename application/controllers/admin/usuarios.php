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
| habilita profiler 
| $this->output->enable_profiler(TRUE);
|
| print da query, executar no metodo em Models
| $this->db->last_query();
*/

class Usuarios extends CI_Controller {
	
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
	
		//load models
		$this->load->model('Grupos_model');
		$this->load->model('Usuarios_model');
		$this->load->model('Uploadimages_model');

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
			$config['total_rows'] = $this->Usuarios_model->getPesquisaNumRows($data['termo']);
			$config['base_url'] = site_url("admin/usuarios/index?termo={$data['termo']}");
		}
		else {
			$config['total_rows'] = $this->Usuarios_model->countAll();		
			$config['base_url'] = site_url("admin/usuarios/index/");
		}
		
		$offset = ($data['per_page'] == 1) ? 0 : ($data['per_page'] * $this->config->item('per_page')) - $this->config->item('per_page');
		
		$this->pagination->initialize($config);		
		$data['paginacao'] = $this->pagination->create_links();	

		if($data['order'] == 'ASC')
			$data['ord'] = 'DESC';
		else
			$data['ord'] = 'ASC';

		$usuarios = $this->Usuarios_model->getList($this->config->item('per_page'), $offset, $data['orderby'], $data['order'], $data['termo']);
				
		$data['programa'] = 'Usuários';
		$data['acao'] = 'Lista de Usuários';
		$data['listar_usuarios'] = $usuarios;
        $data['view'] = 'admin/usuarios/listar'; 
	
		$this->load->view('admin/index', $data);
	}
	
	/*public function pesquisar() {
		
		$data = array();
		
		$termo = ($this->input->post('termo', TRUE)) ? $this->input->post('termo', TRUE) : $this->uri->segment(4);
		$data['termo'] = $termo;

		//paginacao
		$config['base_url'] = base_url()."admin/usuarios/pesquisar/".$termo;
		$config['total_rows'] = $this->Usuarios_model->getPesquisaNumRows($termo);
		$config['uri_segment'] = 5;
		
		$this->pagination->initialize($config);
		
		$data['paginacao'] = $this->pagination->create_links();
		$data['page'] = ($this->uri->segment(5)) ? $this->uri->segment(5) : 0;
		
		$usuarios = $this->Usuarios_model->getPesquisa($this->config->item('per_page'), $data['page'], $termo);
		
		$data['programa'] = 'Usuários';
		$data['acao'] = 'Lista de Usuários';
		$data['listar_usuarios'] = $usuarios;
        $data['view'] = 'admin/usuarios/listar'; 
				
		$this->load->view('admin/index', $data);
	}*/
	
	public function novo() {
		
		$data = array();
		
		$grupos = $this->Grupos_model->getList();
		
		$data['programa'] = 'Usuários';
		$data['acao'] = 'Adicionar Novo Usuário';
		$data['view'] = 'admin/usuarios/form'; 
		$data['listar_grupo'] = $grupos;
		
		$this->load->view('admin/index', $data);		
	}
	
	public function editar($id = NULL) {
		
		$data = array();
		
		if(trim((int)$id)) {
		
			$usuario = $this->Usuarios_model->getUsuario($id);			
			$grupos = $this->Grupos_model->getList();
			 
			if(!$usuario) {
				$this->set_error();	
				return;
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
			return;
		}
	}
	
	public function salvar() {	
	
		$id = trim($this->input->post('id', TRUE));	
				
		$this->form_validation->set_rules('nome', 'Nome', 'trim|required');
		$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
		$this->form_validation->set_rules('grupo', 'Grupo', 'trim|required');
	
		//validacao e teste da senha no cadastro
		if($this->input->post('alterar_senha', TRUE) == 0 and !$id) {
			$this->form_validation->set_rules('senha', 'Senha', 'trim|required');
			$this->form_validation->set_rules('conf_senha', 'Confirmação da Senha', 'required|matches[senha]');
			
			//criptografa a senha
			$senha = $this->Usuarios_model->cryptPass($this->input->post('senha', TRUE));
		}		
		//validacao e testa da senha na alteracao do cadastro
		elseif($this->input->post('alterar_senha', TRUE) == 1 and $id) {
			$this->form_validation->set_rules('senha_atual', 'Senha Atual', 'trim|required|callback_checkSenhaAtual');
			$this->form_validation->set_rules('nova_senha', 'Nova Senha', 'trim|required');
			$this->form_validation->set_rules('conf_nova_senha', 'Confirmação da Nova Senha', 'trim|required|matches[nova_senha]');
			
			//criptografa a senha
			$senha = $this->Usuarios_model->cryptPass($this->input->post('nova_senha', TRUE));
		}

		$data = array(
		   'nome' => $this->input->post('nome', TRUE),
		   'email' => $this->input->post('email', TRUE),
		   'id_grupo' => $this->input->post('grupo', TRUE)
		);

		if($this->session->userdata('usuario_id') != $id) {
			$data['status'] = ($this->input->post('status', TRUE)) ? $this->input->post('status', TRUE) : 0;
		}
		
		if(isset($senha)) {
			$data['senha'] = $senha;
		}

		//editar
		if(!empty($id)) {
			
			$usuario = $this->Usuarios_model->getUsuario($id);
			
			if($usuario) {
				
				//se o email for diferente do que esta armazenado para o usuario
				//significa que ele foi alterado, entao testa se o novo email
				//esta cadastrado
				if($usuario->email != $this->input->post('email', TRUE)) {
					
					$checkemail = $this->checkEmail($this->input->post('email', TRUE));
					
					if($checkemail) {
						$this->set_error("Opss... O email " . $this->input->post('email', TRUE) . " não esta disponível!");	
						return;
					}				
				}			
					
				if ($this->form_validation->run() === TRUE) {
					
					if (!empty($_FILES['arquivo']['name'])) {				
						$upload = $this->Uploadimages_model->do_upload();
						if($upload[0] == TRUE) {
							$data['foto'] = $upload[1];
							//altera foto da sessao
							$this->session->set_userdata('usuario_foto', $data['foto']);
						}
						else {	
							$this->set_error($upload[1]);
							return;
						}
					}

					$this->Usuarios_model->update($data, $id);					
					$this->set_success("Usuário editado com Sucesso.");
				}
				else {
					$this->editar($id);
					return;
				}				
			}
			else {
				$this->set_error();	
				return;
			}
		}
		else {		
		
			if ($this->form_validation->run() === TRUE) {
						
				$checkemail = $this->checkEmail($this->input->post('email', TRUE));
			
				if($checkemail) {
					$this->set_error("Opss... O email " .$this->input->post('email', TRUE) . " não esta disponível!");	
					return;
				}
				
				if (!empty($_FILES['arquivo']['name'])) {					
					$upload = $this->Uploadimages_model->do_upload();
					if($upload[0] == TRUE) {
						$data['foto'] = $upload[1];
					}
					else {	
						$this->set_error($upload[1]);
						return;
					}
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
		
		if(trim((int)$id)) {
		
			if($this->session->userdata('usuario_id') != $id) {

				$usuario = $this->Usuarios_model->getUsuario($id);
			
				if($usuario) {
				
					if($usuario->status == 1) {
						$this->set_error("Usuário " . $usuario->nome . " está Ativo e não pode ser excluído! Desative-o antes.");
						return;
					}	
					else {
						$this->Usuarios_model->delete($id);						
						$this->set_success("Usuário excluído com Sucesso.");
					}
				}
				else {
					$this->set_error();	
					return;
				}
			}
			else {
				$this->set_error("Você não pode se excluir!");	
				return;
			}			
		}		
		else {
			$this->set_error();	
			return;
		}
	}
	
	//verifica se o email existe..caso ele seja alterado ou incluido quando cadastrar um usuario
	function checkEmail($email){		
		return $this->Usuarios_model->getUsuarioParam('usuarios.email', $this->input->post('email', TRUE));
	}
	
	//verificacao da senha atual
	public function checkSenhaAtual($senha) {

		try {
			
			$email = $this->input->post('email', TRUE);
			$hash = $this->Usuarios_model->getUsuarioCheckSenha($email, $senha);
			$checksenha = $this->Usuarios_model->passVerify($senha, $hash->senha);

			if($checksenha === FALSE) {			
				$this->form_validation->set_message('checkSenhaAtual', 'Senha atual inválida!');
				return FALSE;
			}
			
			return TRUE;
								   
		} catch(Exception $e){
			log_message('error', $e->getMessage());
			redirect('admin/usuarios', 'location', 303);
			exit;
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