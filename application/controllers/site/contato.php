<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Contato extends CI_Controller {

	public function index()
	{
		$data = array("view" => "site/contato", 
					  "title" => "Contato",
					  "currentmenu" => "contato");
		$this->load->view('site/app', $data);
	}
}
