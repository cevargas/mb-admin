<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------
| CONTROLADOR DE BACKUP DA BASE DE DADOS
| -------------------------------------------------------------------
| Especifica o controlador de administracao para backup da base de dados
| area de administracao
|
| controller/admin/backup
| 
| habilita profiler 
| $this->output->enable_profiler(TRUE);
*/

class backup extends CI_Controller {
	
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
	}	
	
	public function index() {

		$this->load->dbutil();		
		$backup =& $this->dbutil->backup(); 
		
		$this->load->helper('file');
		$db_name = 'backup-on-'. date("Y-m-d-H-i-s") .'.zip';
        $save = 'backup/'.$db_name;
		
		$this->load->helper('file');
        write_file($save, $backup); 

        $this->load->helper('download');
        force_download($db_name, $backup);
	}
}