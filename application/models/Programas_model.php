<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Programas_model extends CI_Model {
	
	public function __construct() {
		parent::__construct();
	}
	
	public function countAll(){		
		return $this->db->count_all('programas');	
	} 
	
	public function getList($limit=0, $offset=20) {
		
		$this->db->select('*');
		$this->db->from('programas');
		$this->db->order_by('nome', 'ASC');
		$this->db->limit($limit, $offset);
		$query = $this->db->get();
		
		$result = $query->result();		
		
		return $result;
	}   
	
	public function getPesquisa($limit=0, $offset=20, $termo) {

		$this->db->select('*');
		$this->db->from('programas');
		$this->db->like('nome', $termo);
		$this->db->or_like('descricao', $termo);
		$this->db->order_by('nome', 'ASC');
		$this->db->limit($limit, $offset);
		$query = $this->db->get();
		
		$result = $query->result();		
		
		return $result;
	} 
	
	public function getPesquisaNumRows($termo) {

		$this->db->select('*');
		$this->db->from('programas');
		$this->db->like('nome', $termo);
		$this->db->or_like('descricao', $termo);
		$query = $this->db->get();
		
		$result = $query->num_rows();		
		
		return $result;
	}   
	
	public function getPrograma($id) {
		
		$this->db->select('programas.*, programas.parent AS programaPai');
		$this->db->from('programas');
		$this->db->where('id', $id);
		$query = $this->db->get();
		$result = $query->row();		
		
		return $result;
	} 
	
	public function getProgramas() {
		
		$this->db->select('programas.*, programas.parent AS programaPai');
		$this->db->from('programas');
		$this->db->order_by('nome', 'ASC');
		
		$query = $this->db->get();

		$result = $query->result();
		
		return $result;
	} 
	
	public function getProgramasParam($param, $field) {
		
		$this->db->select('*');
		$this->db->from('programas');	
		$this->db->where($param, $field);
		$retul = $this->db->get();		
		
		return $result;
	} 
	
	public function insert($data) {		
		
		try {
						
			$result = $this->db->insert('programas', $data);				
			return $result;	
				 
		} catch (Exception $e) {			
		  log_message('error', $e->getMessage());
		  return;		  
		}		
	} 
	
	public function update($data, $id) {		
		
		try {
			
			$this->db->where('id', $id);
			$result = $this->db->update('programas', $data); 
					
			return $result;	
				 
		} catch (Exception $e) {			
		  log_message('error', $e->getMessage());
		  return;		  
		}		
	} 
	
	public function delete($id) {		
		
		try {
			
			$this->db->where('id', $id);
			$result = $this->db->delete('programas'); 
					
			return $result;	
				 
		} catch (Exception $e) {			
		  log_message('error', $e->getMessage());
		  return;		  
		}		
	} 	
}