<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------
| CONTROLADOR INICIAL DA AREA ADMINISTRATIVA
| -------------------------------------------------------------------
| Especifica o controlador inicial que sera carregado ao 
| acessar a area administrativa.
| 
| controller/admin/admin
| Rotas definidas em config/routes.php
|
*/

class Admin extends CI_Controller {
	
	public function __construct() {
		
		parent::__construct();		
		
		//se tiver usuario logado, redireciona para dashboard
		if($this->session->has_userdata('logged_in') === true) {
			redirect('admin/dashboard', 'location', 301);
		}
	}
	//carrega a view de login
	public function index() {
		$data = array();
        $data['view'] = 'admin/login/frm_login';
		$this->load->view('admin/login/index', $data);
	}
}