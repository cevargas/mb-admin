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
		$this->CI->db->where('id_grupo', $grupo_id);
		$query = $this->CI->db->get();
		$permissoes = $query->result();
		   
		if($permissoes) {		
			$arr = array();
			foreach($permissoes as $key => $val) {
				
				//$this->_config[$key]['id'] = $val->getIdPermissao()->getId();			
				$arr[$val->id_permissao] = $val->controlador;
				//$this->_config[$key]['chave'] = $val->getIdPermissao()->getChave();
				//$this->_config[$key]['descricao'] = $val->getIdPermissao()->getDescricao();				
			}
				
			$data_session_set = array('permissoes' => $arr);				  
			$this->CI->session->set_userdata($data_session_set);
			
		}
		else {
			log_message('debug', 'Sem permissoes definidas em Entities\GruposPermissoes');
			exit("403 Forbidden");
		}
	}
	
	public function has_perm() {
		
		if($this->CI->session->userdata('permissoes')) {
			$perms = $this->CI->session->userdata('permissoes');
			
			if (in_array($this->CI->uri->segment(2, 0), $perms)) { 
				return true;
			}
			else {
				return false;
			}
		}
		log_message('debug', 'Session de permissoes nao retornou valor');
		exit("403 Forbidden");
	}	
}