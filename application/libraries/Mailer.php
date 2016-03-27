<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Mailer extends CI_Email {
	
	protected $CI;
	private $config;
		
	public function __construct($config = array()) {
		
		$this->config = $config;		
		parent::__construct($this->config);			
		$this->CI =& get_instance();
		$this->CI->load->library('email', $this->config);
		
	}
	
	function sendmail($params)
	{		
		$this->CI->email->from('admin@moblin.com.br', $params['txtnome']);
		$this->CI->email->to('contato@moblin.com.br');
		$this->CI->email->subject('Contato Moblin');
		
		$html = '';
		$html .= '<br /> Nome: ' . $params['txtnome'];
		$html .= '<br /> Email: ' . $params['txtnome'];
		$html .= '<br /> Mensagem: ' . $params['txtmensagem'];		
		
		$this->CI->email->message($html);	
		
		if ($this->CI->email->send(FALSE)) {
			log_message('info', 'Mensagem enviada com sucesso de: ' . $params['txtemail'] .', '. 
				$params['txtnome'] .', Mensagem: '. $params['txtmensagem'] .
				' OK: ' . $this->CI->email->print_debugger());
			return TRUE;
		}
		else {			
			log_message('error', 'Falha no envio de mensagem: ' . 
				$params['txtemail'] .', '. $params['txtnome'] .', Mensagem: '. $params['txtmensagem'] .
			 	' ERROR: ' . $this->CI->email->print_debugger());
			return FALSE;			
		}
	}
	
	function sendmail_reset_pass($params)
	{		
		$this->CI->email->from('admin@moblin.com.br', 'Administrador Moblin');
		$this->CI->email->to($params['to']);
		$this->CI->email->subject($params['title']);
		
		$message = "<p>Olá " . $params['nome'].",</p>";
		
		$message .= "<p>Este email esta sendo enviado para que você possa recuperar sua senha de Acesso a Administração do Sistema.</p>";
        $message .= "<p><a href='".base_url()."admin/recovery/reset_password/".$params['to']."/".$params['token']."'>Acesse aqui</a> se você deseja criar uma nova senha,
                        se não, apenas ignore esse email.</p>";
		
		$this->CI->email->message($message);	
		
		if ($this->CI->email->send(FALSE)) {
			log_message('info', 'Mensagem enviada com sucesso para recuperacao de senha: ' . $params['to']);
			return TRUE;
		}
		else {			
			log_message('error', 'Falha no envio de mensagem para recuperacao de senha: ' . $params['to'] . ' Error: '.$this->CI->email->print_debugger());
			return FALSE;			
		}
	}
}