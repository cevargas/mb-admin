<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Servicos extends CI_Controller {

	public function index()
	{
		$data = array("view" => "site/servicos", 
					  "title" => "Serviços",
					  "currentmenu" => "servicos");
		$this->load->view('site/app', $data);
	}
}
