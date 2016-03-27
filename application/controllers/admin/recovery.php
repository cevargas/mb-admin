<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------
| CONTROLADOR DE LOGIN DA AREA ADMINISTRATIVA
| -------------------------------------------------------------------
| Especifica o controlador para recuperar senha
| 
| controller/admin/recovery
| 
*/

class Recovery extends CI_Controller {
	
	public function __construct() {
		
		parent::__construct();
		
		$this->_mail = new Mailer;
				
		$this->load->helper('form');
		$this->load->library('form_validation');
		
		$this->load->model('Usuarios_model');
		
		//se tiver usuario logado, redireciona para dashboard
		if($this->session->has_userdata('logged_in') === TRUE) {
			redirect('admin/dashboard', 'location', 301);
		}
	}
	
	public function index() 
	{
		$data = array();
		$data['view'] = 'admin/login/frm_recovery';
		$this->load->view('admin/login/index', $data);
	}
	
	public function post()
	 {
		//seta validacoes
		$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|callback_verificacao_email');
		
		//se validar o email, retorna para o Formulario de login
  		if ($this->form_validation->run() == TRUE) {			
			redirect('admin/login', 'location', 303);			
		}
		else {
			//se nao validar o login
			$this->index();
		}		
	}
	
	public function valid_email($email){
		
		try {

			//consulta no banco de dados se o email existe
			$usuario = $this->Usuarios_model->checkEmail($email);
			return $usuario;
							   
		} catch(Exception $e){
			log_message('error', $e->getMessage());
        }
	}
	
	
	//validacao do login
	public function verificacao_email($email) {
		
		$usuario = $this->valid_email($email);

		if($usuario !== FALSE) {
		
			//se encontrar o usuario
			if(isset($usuario) and $usuario !== FALSE) {
	
				$temp_pass = md5(uniqid());
				
				$params['to'] = $usuario->email;
				$params['title'] = "Moblin :: Recuperação de Senha";
				$params['nome'] = $usuario->nome;
				$params['token'] = $temp_pass;
						
				if($this->_mail->sendmail_reset_pass($params)) {			
		
					$data = array();
					$email = $this->input->post('email');
					$data['token'] = $temp_pass;
					$data['status'] = 0;
					
					$now = new DateTime(); 				
					$now->add(new DateInterval('PT2H'));
					$data['time_expired'] = $now->format('Y-m-d H:i:s');
					
					$this->Usuarios_model->setToken($data, $email);			
					$this->session->set_flashdata('success_msg', 'Enviamos um email para você. Siga as instruções nele para alterar sua Senha.');				
					return TRUE;                  
				}
				
				return FALSE;			
			}
		}
		else {
			$this->form_validation->set_message('verificacao_email', 'O email '.$email.' não foi localizado!');
			return FALSE;
		}
    }
	
	public function reset_password(){
		
		$email = $this->uri->segment(4);
		$token = $this->uri->segment(5);
		
		$params = array();
		$params['email'] = $email;
		$params['token'] = $token;
		
		$usuario = $this->Usuarios_model->getUsuarioResetPass($params);
				
		$agora = new DateTime();
		$expired_At = new DateTime($usuario->time_expired);
		
		if($agora < $expired_At) {			
		
			if( isset($usuario) and $usuario !== FALSE ) {
				//load view to change pass
				$data = array();
				$data['email'] = $params['email'];
				$data['token'] = $params['token'];
				$data['view'] = 'admin/login/frm_reset';
				$this->load->view('admin/login/index', $data);
			}
		}
		else {
			$this->session->set_flashdata('error_msg', 'Dados inválidos ou o prazo para alteração da sua senha expirou.');
			redirect('admin/recovery', 'location', 303);
		}
	}
	
	public function resetpass() {
		
		//seta validacoes
		$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|callback_valid_email');
		$this->form_validation->set_rules('senha', 'Senha', 'trim|required');
		$this->form_validation->set_rules('confsenha', 'Confirmação da Senha', 'trim|required|matches[senha]');
		$this->form_validation->set_rules('token', 'Token', 'trim|required');

		$params = array();
		$params['email'] = $this->input->post('email');
		$params['token'] = $this->input->post('token');
		
		//se validar o email, retorna para o Formulario de login
  		if ($this->form_validation->run() == TRUE) {
	
			$usuario = $this->Usuarios_model->getUsuarioResetPass($params);
			
			if( isset($usuario) and $usuario !== FALSE ) {
				
				$agora = new DateTime();
				$expired_At = new DateTime($usuario->time_expired);
			
				if($agora < $expired_At) {	
				
					$params['senha'] = $this->Usuarios_model->cryptPass($this->input->post('senha', TRUE));
					$params['status'] = 1;
					$params['token'] = NULL;
					$params['time_expired'] = NULL;
				
					$this->Usuarios_model->update($params, $usuario->id);
					$this->session->set_flashdata('success_msg', 'Sua senha foi alterada com sucesso.');
					redirect('admin/login', 'location', 303);
				}
			}
		}
		else {
			$this->session->set_flashdata('error_msg', 'Dados inválidos, não foi possível alterar sua senha.');
			redirect('admin/recovery/reset_password/'.$params['email'].'/'.$params['token'], 'location', 303);
		}	
	}
}