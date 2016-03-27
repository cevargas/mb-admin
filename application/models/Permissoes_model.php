<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Permissoes_model extends CI_Model {
	
	public function __construct() {
		parent::__construct();
	}
	
	public function countAll(){		
		return $this->db->count_all('permissoes');	
	} 
	
	public function getList($limit=0, $offset=20, $order_by=NULL, $order=NULL, $termo=NULL) {
		
		if( isset($order_by) && ! empty($order_by) && isset($order) && ! empty($order) ) { 
			$this->db->order_by($order_by, $order);
		}		
		else {
			$this->db->order_by('nome', 'ASC');	
		}
		
		if(isset($termo)) {
			$this->db->like('nome', quotes_to_entities($termo));
			$this->db->or_like('descricao', quotes_to_entities($termo));
		}	
		
		$this->db->select('*');
		$this->db->from('permissoes');
		$this->db->limit($limit, $offset);
		$query = $this->db->get();
		
		$result = $query->result();		
		
		return $result;
	}   
	
	/*public function getPesquisa($limit=0, $offset=20, $termo) {

		$this->db->select('*');
		$this->db->from('permissoes');
		$this->db->like('nome', $termo);
		$this->db->or_like('descricao', $termo);
		$this->db->order_by('nome', 'ASC');
		$this->db->limit($limit, $offset);
		$query = $this->db->get();
		
		$result = $query->result();		
		
		return $result;
	}*/
	
	public function getPesquisaNumRows($termo) {

		$this->db->select('*');
		$this->db->from('permissoes');
		$this->db->like('nome', quotes_to_entities($termo));
		$this->db->or_like('descricao', quotes_to_entities($termo));
		$query = $this->db->get();
		
		$result = $query->num_rows();		
		
		return $result;
	}   
	
	public function getPermissao($id) {
		
		$this->db->select('*');
		$this->db->from('permissoes');
		$this->db->where('id', $id);
		$query = $this->db->get();
		$result = $query->row();		
		
		return $result;
	} 
	
	public function getPermissoes() {

		$this->db->select('*');							
		$this->db->from('permissoes');
		$this->db->order_by('nome', 'ASC');
		
		$query = $this->db->get();
		$result = $query->result();
		
		return $result;
	} 
	
	public function getPermissoesParam($param, $field) {

		$this->db->select('*');
		$this->db->from('permissoes');	
		$this->db->where($param, $field);
		$result = $this->db->get();		
		
		return $result;
	} 
	
	public function getPermissoesRegras() {
		
		$this->db->select('*');
		$this->db->from('permissoes');
		$this->db->join('permissoes_regras', 'permissoes.id = permissoes_regras.id_permissao');

		$query = $this->db->get();
		$result = $query->result();
		
		return $result;
	}
	
	public function getPermissoesRegra($id) {
		
		$this->db->select('permissoes_regras.*');
		$this->db->from('permissoes');
		$this->db->join('permissoes_regras', 'permissoes.id = permissoes_regras.id_permissao');

		$this->db->where('permissoes.id', $id);
		$query = $this->db->get();
		$result = $query->result();
		
		return $result;
	}
	
	public function deletePermissoesRegras($id) {
		
		$this->db->where('id_permissao', $id);
		$result = $this->db->delete('permissoes_regras'); 
		
		return $result;
	}
	
	public function insertPermissoesRegras($data) {		
		
		try {
						
			$result = $this->db->insert('permissoes_regras', $data);				
			return $result;	
				 
		} catch (Exception $e) {			
		  log_message('error', $e->getMessage());
		  return;		  
		}		
	} 
	
	public function insert($data) {		
		
		try {
						
			$result = $this->db->insert('permissoes', $data);				
			return $result;	
				 
		} catch (Exception $e) {			
		  log_message('error', $e->getMessage());
		  return;		  
		}		
	} 
	
	public function update($data, $id) {		
		
		try {
			
			$this->db->where('id', $id);
			$result = $this->db->update('permissoes', $data); 
					
			return $result;	
				 
		} catch (Exception $e) {			
		  log_message('error', $e->getMessage());
		  return;		  
		}		
	} 
	
	public function delete($id) {		
		
		try {
			
			$this->db->where('id', $id);
			$result = $this->db->delete('permissoes'); 
					
			return $result;	
				 
		} catch (Exception $e) {			
		  log_message('error', $e->getMessage());
		  return;		  
		}		
	} 	
}