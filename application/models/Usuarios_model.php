<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Usuarios_model extends CI_Model {
	
	public function __construct() {
		parent::__construct();
	}
	
	public function checkLogin($email, $senha) {
		
		//criptografa a senha	
		$senha = $this->cryptPass($email, $senha);
		
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
	
	public function getList() {
		
		$this->db->select('usuarios.*, grupos.nome AS grupoNome');
		$this->db->from('usuarios');
		$this->db->order_by('nome', 'ASC');
		$this->db->join('grupos', 'grupos.id = usuarios.id_grupo');
		$query = $this->db->get();
		$result = $query->result();		
		
		return $result;
	}   
	
	public function getUsuario($id) {
		
		$this->db->select('usuarios.*, grupos.id AS grupoId, grupos.nome AS grupoNome');
		$this->db->from('usuarios');	
		$this->db->where('usuarios.id', $id);
		$this->db->join('grupos', 'grupos.id = usuarios.id_grupo');
		$query = $this->db->get();
		$result = $query->row();		
		
		return $result;
	} 
	
	public function getUsuarioParam($param, $field) {
		
		$this->db->select('usuarios.*, grupos.id AS grupoId, grupos.nome AS grupoNome');
		$this->db->from('usuarios');	
		$this->db->where($param, $field);
		$this->db->join('grupos', 'grupos.id = usuarios.id_grupo');
		$query = $this->db->get();
		$result = $query->row();		
		
		return $result;
	} 
	
	public function getUsuarioCheckSenha($email, $senha) {
		
		$this->db->select('usuarios.id');
		$this->db->from('usuarios');	
		$this->db->where('usuarios.email', $email);
		$this->db->where('usuarios.senha', $senha);
		$query = $this->db->get();
		$result = $query->row();	
		
		return $result;
	}
	
	public function countUsuariosByGrupo($grupoId) {
		
		$this->db->select('*');
		$this->db->from('usuarios');
		$this->db->where('id_grupo', $grupoId);
		$query = $this->db->get();
		$result = $query->num_rows();		
		
		return $result;
	} 
	
	public function insert($data) {		
		
		try {
						
			$result = $this->db->insert('usuarios', $data);
				
			return $result;	
				 
		} catch (Exception $e) {			
		  log_message('error', $e->getMessage());
		  return;		  
		}		
	} 
	
	public function update($data, $id) {		
		
		try {
			
			$this->db->where('id', $id);
			$result = $this->db->update('usuarios', $data); 
					
			return $result;	
				 
		} catch (Exception $e) {			
		  log_message('error', $e->getMessage());
		  return;		  
		}		
	} 
	
	public function delete($id) {		
		
		try {
			
			$this->db->where('id', $id);
			$result = $this->db->delete('usuarios'); 
					
			return $result;	
				 
		} catch (Exception $e) {			
		  log_message('error', $e->getMessage());
		  return;		  
		}		
	} 
	
	public function cryptPass($email, $senha){
		return hash('sha256', $senha . $email);
	}	
}