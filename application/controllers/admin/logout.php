<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------
| CONTROLADOR DE LOGOUT
| -------------------------------------------------------------------
| Especifica o controlador de logout da area administrativa
| 
| controller/admin/logout
| 
*/

class Logout extends CI_Controller {
		
	public function __construct() {		
		parent::__construct();	
		
		//se nao tiver sessao redireciona para o login
		if($this->session->has_userdata('logged_in') === false) {
			redirect('admin', 'location', 301);
		}		
	}
	
	public function index() {
		$this->session->sess_destroy();	
		redirect('admin', 'location', 301);
	}
}