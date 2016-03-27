<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sobre extends CI_Controller {

	public function index()
	{
		$data = array("view" => "site/sobre/index", 
					  "title" => "Sobre",
					  "currentmenu" => "sobre");
		$this->load->view('site/index', $data);
	}
}
