<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------
| CONTROLADOR DE EDICAO DE PERFIL
| -------------------------------------------------------------------
| Especifica o controlador de administracao para edicao de dados do
| perfil do usuarios
|
| controller/admin/perfil
| 
| habilita profiler 
| $this->output->enable_profiler(TRUE);
|
| print da query, executar no metodo em Models
| $this->db->last_query();
*/

class Perfil extends CI_Controller {
	
	public function __construct() {
		
		parent::__construct();
		
		//se nao tiver usuario logado redireciona para o login
		if($this->session->has_userdata('logged_in') === FALSE) {
			redirect('admin', 'location', 301);
		}
		
		$this->load->model('Usuarios_model');
		$this->load->model('Uploadimages_model');
		
	}
	
	public function editar($id = NULL) {
		
		if($id != NULL) {
			if($id != $this->session->userdata('usuario_id')) {
				$this->set_error("Opss..o que você esta querendo fazer?");	
				return;
			}
		}
		
		$id = $this->session->userdata('usuario_id');
		
		$data = array();
		
		if(trim((int)$id)) {
		
			$usuario = $this->Usuarios_model->getUsuario($id);			

			if(!$usuario) {
				$this->set_error();	
				return;
			}					 
			
			$data['programa'] = 'Perfil';
			$data['acao'] = 'Editar Perfil';
			$data['view'] = 'admin/perfil/form'; 
			$data['usuario'] = $usuario;
			
			$this->load->view('admin/index', $data);
		}
		else {
			$this->set_error();	
			return;
		}
	}
	
	public function salvar() {	
	
		$id = $this->session->userdata('usuario_id');
				
		$this->form_validation->set_rules('nome', 'Nome', 'trim|required');
		$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');

		//validacao e testa da senha na alteracao do cadastro
		if($this->input->post('alterar_senha', TRUE) == 1 and $id) {
			$this->form_validation->set_rules('senha_atual', 'Senha Atual', 'trim|required|callback_checkSenhaAtual');
			$this->form_validation->set_rules('nova_senha', 'Nova Senha', 'trim|required');
			$this->form_validation->set_rules('conf_nova_senha', 'Confirmação da Nova Senha', 'trim|required|matches[nova_senha]');
			
			//criptografa a senha
			$senha = $this->Usuarios_model->cryptPass($this->input->post('nova_senha', TRUE));
		}

		$data = array(
		   'nome' => $this->input->post('nome', TRUE),
		   'email' => $this->input->post('email', TRUE)
		);
		
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
					$this->set_success("Perfil editado com Sucesso.");
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
		redirect('admin/perfil/editar', 'location', 303);
		exit;
	}
	
	public function set_error($mensagem = NULL) {
		
		if(!$mensagem)
			$mensagem = 'Dados inválidos!';
		
		$this->session->set_flashdata('error_msg', $mensagem);
		redirect('admin/perfil/editar', 'location', 303);	
		exit;	
	}	
}