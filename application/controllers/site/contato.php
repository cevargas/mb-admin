<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Contato extends CI_Controller {
	
	private $_mail;
	
	public function __construct() {		
		parent::__construct();
		$this->_mail = new Mailer;
	}

	public function index() {
		$data = array("view" => "site/contato/index", 
					  "title" => "Contato",
					  "currentmenu" => "contato");
		$this->load->view('site/index', $data);
	}
	
	public function submit() {		
	
		$this->form_validation->set_rules('txtemail', 'Email', 'trim|required|valid_email');
		$this->form_validation->set_rules('txtnome', 'Nome', 'trim|required|min_length[5]');
		$this->form_validation->set_rules('txtmensagem', 'Mensagem', 'trim|required|min_length[20]|max_length[200]');
	
		//se NAO validar o login, retorna para o Formulario
  		if ($this->form_validation->run() == TRUE) {	
		
			$params = array();
			
			$params['txtemail'] = $this->input->post('txtemail', true);
			$params['txtnome'] = $this->input->post('txtnome', true);
			$params['txtmensagem'] = $this->input->post('txtmensagem', true);
					
			if($this->_mail->sendmail($params)) {
				 // mail sent
        		$this->session->set_flashdata('msg','<div class="alert alert-success text-center col-sm-10">Opa! Sua mensagem foi enviada com sucesso! Logo mais retornaremos. :)</div>');
        		redirect('/');	
			}
			else { 
				//error
        		$this->session->set_flashdata('msg','<div class="alert alert-danger text-center col-sm-10">Uauu! Parece que não deu para enviar sua mensagem agora. Não se preocupe, estamos verificando o que ocorreu.</div>');
				redirect('/');				
			}
		}			
	}
}
