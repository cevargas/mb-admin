<?php defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------
| ACL
| -------------------------------------------------------------------
| Controle de Permissoes de acesso por grupo / usuario
| 
| libraries/Acl.php
| 
*/

class Acl {
		
	protected $CI;	

	public function __construct() {
		
	   	$this->CI =& get_instance();
		
		$this->CI->load->library('session');
		$this->CI->load->database();
		
		log_message('debug', 'ACL Class Initialized');	   
	}
	
	//monta menu de acordo com o grupo do usuario
	public function getPermissions(){
		
		//pega grupo do usuario				 
		$grupo_id = $this->CI->session->userdata('grupo_id');

		$this->CI->db->select('*');
		$this->CI->db->from('grupos_permissoes');
		$this->CI->db->join('permissoes', 'grupos_permissoes.id_permissao = permissoes.id');
		//$this->CI->db->join('permissoes_regras', 'permissoes_regras.id_permissao = permissoes.id', 'left');
		$this->CI->db->where('id_grupo', $grupo_id);
		$query = $this->CI->db->get();
		$permissoes = $query->result();
		   
		if($permissoes) {		
			$arr = array();
			
			foreach($permissoes as $key => $val) {

				$arr[$val->controlador] = array();
				
				$this->CI->db->select('*');
				$this->CI->db->from('permissoes_regras');
				$this->CI->db->where('id_permissao', $val->id_permissao);
				$query = $this->CI->db->get();
				$regras = $query->result();
				
				if($regras) {
					foreach($regras as $k => $regra) {
						$arr[$val->controlador][] = $regra->chave;
					}
				}				
			}				
			$data_session_set = array('permissoes' => $arr);
			$this->CI->session->set_userdata($data_session_set);	
			
			/*$roles = array();
			foreach($permissoes as $key => $val) {		
				$roles[$key] = $val->chave;		
			}				
			$data_session_set_roles = array('roles' => $roles);								  
			$this->CI->session->set_userdata($data_session_set_roles);*/
			
		}
		else {
			log_message('debug', 'Sem permissoes definidas em Entities\GruposPermissoes');
			$this->CI->session->sess_destroy();	
			exit("403 Forbidden sadas");
		}
	}
	
	public function has_perm() {

		if($this->CI->session->userdata('permissoes')) {
			$perms = $this->CI->session->userdata('permissoes');
			
			if ( (array_key_exists($this->CI->uri->segment(2, 0), $perms))
				 and ((in_array($this->CI->uri->segment(3, 0), $perms[$this->CI->uri->segment(2, 0)])
				 	or !$this->CI->uri->segment(3, 0) or $this->CI->uri->segment(3, 0) == 'index') )) { 
				return true;
			}
			else {
				return false;
			}
		}
		log_message('debug', 'Session de permissoes nao retornou valor');
		$this->CI->session->sess_destroy();	
		exit("403 Forbidden 1");
	}
	
	public function has_perm_list($controller, $method) {

		if($this->CI->session->userdata('permissoes')) {
			$perms = $this->CI->session->userdata('permissoes');
			
			if ( (array_key_exists($controller, $perms))
				 and ((in_array($method, $perms[$controller])
				 	or !$method or $method == 'index') )) { 
				return true;
			}
			else {
				return false;
			}
		}
		log_message('debug', 'Session de permissoes nao retornou valor');
		$this->CI->session->sess_destroy();	
		exit("403 Forbidden 1");
	}
}