<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Grupos_model extends CI_Model {
	
	public function __construct() {
		parent::__construct();
	}
	
	public function getList() {
		
		$this->db->select('*');
		$this->db->from('grupos');
		$this->db->order_by('nome', 'ASC');
		$query = $this->db->get();
		$result = $query->result();		
		
		return $result;
	}   
	
	public function getGrupo($id) {
		
		$this->db->select('*');
		$this->db->from('grupos');
		$this->db->where('id', $id);
		$query = $this->db->get();
		$result = $query->row();		
		
		return $result;
	} 
	
	public function insert($data) {		
		
		try {
						
			$result = $this->db->insert('grupos', $data);
				
			return $result;	
				 
		} catch (Exception $e) {			
		  log_message('error', $e->getMessage());
		  return;		  
		}		
	} 
	
	public function update($data, $id) {		
		
		try {
			
			$this->db->where('id', $id);
			$result = $this->db->update('grupos', $data); 
					
			return $result;	
				 
		} catch (Exception $e) {			
		  log_message('error', $e->getMessage());
		  return;		  
		}		
	} 
	
	public function delete($id) {		
		
		try {
			
			$this->db->where('id', $id);
			$result = $this->db->delete('grupos'); 
					
			return $result;	
				 
		} catch (Exception $e) {			
		  log_message('error', $e->getMessage());
		  return;		  
		}		
	} 	
	
}