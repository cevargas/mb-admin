<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sobre extends CI_Controller {

	public function index()
	{
		$data = array("view" => "site/sobre", 
					  "title" => "Sobre",
					  "currentmenu" => "sobre");
		$this->load->view('site/app', $data);
	}
}
