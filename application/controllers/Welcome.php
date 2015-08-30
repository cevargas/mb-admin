<?php
defined('BASEPATH') OR exit('No direct script access allowed');

//Controlador inicial, carrega a view index do site
class Welcome extends CI_Controller {

	public function index()
	{
		$data = array();
		$data['view'] = 'site/home/index';
		$this->load->view('site/index', $data);
	}
}
