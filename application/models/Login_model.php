<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login_model extends CI_Model {
	
	public function __construct() {
		parent::__construct();
	}
	
	public function checkLogin($email, $senha) {
		
		//criptografa a senha	
		$senha = hash('sha256', $senha . $email);
		
		$this->db->select('usuarios.nome AS usuarioNome,
							 grupos.nome AS grupoNome, 
							 usuarios.id AS usuarioId, 
							 grupos.id AS grupoId');
							 
		$this->db->from('usuarios');
		$this->db->join('grupos', 'usuarios.id_grupo = grupos.id');
		$this->db->where('usuarios.email', $email);
		$this->db->where('usuarios.senha', $senha);
		$this->db->where('usuarios.status', 1);
		$this->db->where('grupos.status', 1);
		
		$query = $this->db->get();
		return $query->row();
	}   
}
