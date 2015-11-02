<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Grupos_model extends CI_Model {
	
	public function __construct() {
		parent::__construct();
	}
	
	public function countAll(){		
		return $this->db->count_all('grupos');	
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
		$this->db->from('grupos');
		$this->db->limit($limit, $offset);
		$query = $this->db->get();
		$result = $query->result();		
		
		return $result;
	}   
	
	/*public function getPesquisa($limit=0, $offset=20, $termo) {

		$this->db->select('*');
		$this->db->from('grupos');
		$this->db->like('nome', $termo);
		$this->db->order_by('nome', 'ASC');
		$this->db->limit($limit, $offset);
		$query = $this->db->get();
		
		$result = $query->result();		
		
		return $result;
	}*/
	
	public function getPesquisaNumRows($termo) {

		$this->db->select('*');
		$this->db->from('grupos');
		$this->db->like('nome', quotes_to_entities($termo));
		$this->db->or_like('descricao', quotes_to_entities($termo));
		$query = $this->db->get();
		
		$result = $query->num_rows();		
		
		return $result;
	}  
	
	public function getGrupo($id) {
		
		$this->db->select('*');
		$this->db->from('grupos');
		$this->db->where('grupos.id', $id);
		$query = $this->db->get();
		$result = $query->row();		
		
		return $result;
	} 
	
	public function getGruposProgramas($id) {
		
		$this->db->select('*');
		$this->db->from('grupos');
		$this->db->join('grupos_programas', 'grupos_programas.id_grupo = grupos.id');
		$this->db->join('programas', 'grupos_programas.id_programa = programas.id');
		$this->db->where('grupos.id', $id);
		
		$query = $this->db->get();
		$result = $query->result();
		
		return $result;
	}
	
	public function getGruposPermissoes($id) {
		
		$this->db->select('*');
		$this->db->from('grupos');
		$this->db->join('grupos_permissoes', 'grupos_permissoes.id_grupo = grupos.id');
		$this->db->where('grupos.id', $id);
		
		$query = $this->db->get();
		$result = $query->result();
		
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
	
	public function insertGruposProgramas($data) {		
		
		try {
						
			$result = $this->db->insert('grupos_programas', $data);
				
			return $result;	
				 
		} catch (Exception $e) {			
		  log_message('error', $e->getMessage());
		  return;		  
		}		
	} 
	
	public function deleteGruposProgramas($id) {		
		
		try {
			
			$this->db->where('id_grupo', $id);
			$result = $this->db->delete('grupos_programas'); 
					
			return $result;	
				 
		} catch (Exception $e) {			
		  log_message('error', $e->getMessage());
		  return;		  
		}		
	} 
	
	public function checkGruposProgramas($programa, $grupo) {
		
		try {
						
			$this->db->select('*');
			$this->db->from('grupos_programas');
			$this->db->where('id_programa', $programa);
			$this->db->where('id_grupo', $grupo);
			
			$query = $this->db->get();
			$result = $query->row();
				
			return $result;	
				 
		} catch (Exception $e) {			
		  log_message('error', $e->getMessage());
		  return;		  
		}		
	} 
	
	public function insertGruposPermissoes($data) {		
		
		try {
						
			$result = $this->db->insert('grupos_permissoes', $data);
				
			return $result;	
				 
		} catch (Exception $e) {			
		  log_message('error', $e->getMessage());
		  return;		  
		}		
	} 
	
	public function deleteGruposPermissoes($id) {		
		
		try {
			
			$this->db->where('id_grupo', $id);
			$result = $this->db->delete('grupos_permissoes'); 
					
			return $result;	
				 
		} catch (Exception $e) {			
		  log_message('error', $e->getMessage());
		  return;		  
		}		
	} 	
}