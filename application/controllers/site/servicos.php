<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Servicos extends CI_Controller {

	public function index() {
		$data = array("view" => "site/servicos/index", 
					  "title" => "Serviços",
					  "currentmenu" => "servicos");
		$this->load->view('site/index', $data);
	}
	
	public function descricao() {
		
		
		var_dump($this->uri->segment(2));
		exit;
		
		
		
		$data = array("view" => "site/servicos/servicos", 
					  "title" => "Serviços",
					  "currentmenu" => "servicos");
		$this->load->view('site/index', $data);
		
	}
}
