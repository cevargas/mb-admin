<?php defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------
| MENU
| -------------------------------------------------------------------
| Construcao do menu baseado no grupo do usuario
| 
| libraries/Menu.php
| 
*/

class Menu {
	
	protected $CI;

	public function __construct() {
		
	   	$this->CI =& get_instance();
		
	   	$this->CI->load->helper('url');
		$this->CI->config->item('base_url');
		$this->CI->load->database();

		log_message('debug', 'Menu Class Initialized');			   
	}
	
	//monta menu de acordo com o grupo do usuario
	public function getMenu(){
		
		//pega id do usuario da sessao
		$grupo_id = $this->CI->session->userdata('grupo_id');		
		
		$this->CI->db->select('programas.id AS idPrograma, 
								programas.icone, 
								programas.url, 
								grupos.nome AS grupoNome, 
								programas.nome AS programaNome, 
								programas.parent AS programaPai');
								
		$this->CI->db->from('grupos_programas');
		$this->CI->db->join('programas', 'programas.id = grupos_programas.id_programa');
		$this->CI->db->join('grupos', 'grupos.id =  grupos_programas.id_grupo');
		$this->CI->db->where('grupos.id', $grupo_id);
		$this->CI->db->where('programas.status', 1);
		$this->CI->db->where('grupos.status', 1);
		$this->CI->db->order_by('programas.parent', 'ASC');
		$this->CI->db->order_by('programas.nome', 'ASC');
		$query = $this->CI->db->get();
		$result = $query->result();
		
        $menu = $this->buildMenu($result);
		
		return $menu;
		
		//$data_session_set = array('menu' => $menu);			  
		//$this->CI->session->set_userdata($data_session_set);
	}
	
	function buildMenu($items) {
		
		$html = '';
		$parent = 0;
		$parent_stack = array();
		
		// $items contains the results of the SQL query
		$children = array();
		foreach ( $items as $item )		
			$children[$item->programaPai][] = $item;

		while ( ( $option = each( $children[$parent] ) ) || ( $parent > 0 ) )
		{
			if ( !empty( $option ) )
			{					
			
				// 1) The item contains children:
				// store current parent in the stack, and update current parent
				if ( !empty( $children[$option['value']->idPrograma] ) )
				{
					$active = '';
					if($this->CI->uri->segment(1, 0) == $option['value']->url) {
						$active = 'active';		
					}
					
					$html .= '<li class="'.$active.'">';
					$html .= '<a href="javascript:;"><i class="fa '.$option['value']->icone.'"></i> <span class="nav-label">'.$option['value']->programaNome.'</span>';
					$html .= '<span class="fa arrow"></span></a>';
					
					if($parent == 0) 				
						$html .= '<ul class="nav nav-second-level">'; 
					else 
						$html .= '<ul class="nav nav-third-level">'; 
					
					array_push( $parent_stack, $parent );
					$parent = $option['value']->idPrograma;
				}
				// 2) The item does not contain children
				else {	
				
					$activeSub = '';
					if($this->CI->uri->segment(2, 0) == $option['value']->url) {
						$activeSub = 'active';		
					}					
					$html .= '<li class="'.$activeSub.'"><a href="'.base_url().'admin/'.$option['value']->url.'"><i class="fa '.$option['value']->icone.'"></i>' . $option['value']->programaNome . '</a></li>';
				}
			}
			// 3) Current parent has no more children:
			// jump back to the previous menu level
			else
			{
				$html .= '</ul></li>';
				$parent = array_pop( $parent_stack );
			}
		}
		
		// At this point, the HTML is already built
		return $html;
	}
	
	
	/*function buildMenu($items) {
		
		$html = '';
		$parent = 0;
		$parent_stack = array();
		
		// $items contains the results of the SQL query
		$children = array();
		foreach ( $items as $item )		
			$children[$item->getIdPrograma()->getParent()][] = $item;

		while ( ( $option = each( $children[$parent] ) ) || ( $parent > 0 ) )
		{
			if ( !empty( $option ) )
			{					
			
				// 1) The item contains children:
				// store current parent in the stack, and update current parent
				if ( !empty( $children[$option['value']->getIdPrograma()->getId()] ) )
				{
					$active = '';
					if($this->CI->uri->segment(1, 0) == $option['value']->getIdPrograma()->getUrl()) {
						$active = 'active';		
					}
					
					$html .= '<li class="'.$active.'">';
					$html .= '<a href="javascript:;"><i class="fa '.$option['value']->getIdPrograma()->getIcone().'"></i> <span class="nav-label">'.$option['value']->getIdPrograma()->getNome().'</span>';
					$html .= '<span class="fa arrow"></span></a>';
					
					if($parent == 0) 				
						$html .= '<ul class="nav nav-second-level">'; 
					else 
						$html .= '<ul class="nav nav-third-level">'; 
					
					array_push( $parent_stack, $parent );
					$parent = $option['value']->getIdPrograma()->getId();
				}
				// 2) The item does not contain children
				else {	
				
					$activeSub = '';
					if($this->CI->uri->segment(2, 0) == $option['value']->getIdPrograma()->getUrl()) {
						$activeSub = 'active';		
					}					
					$html .= '<li class="'.$activeSub.'"><a href="'.base_url().'admin/'.$option['value']->getIdPrograma()->getUrl().'">' . $option['value']->getIdPrograma()->getNome() . '</a></li>';
				}
			}
			// 3) Current parent has no more children:
			// jump back to the previous menu level
			else
			{
				$html .= '</ul></li>';
				$parent = array_pop( $parent_stack );
			}
		}
		
		// At this point, the HTML is already built
		return $html;
	}*/
        
	/*
	function buildNavigation($items, $parent = NULL) {
		
		$hasChildren = false;
		$outputHtml = '<ul>%s</ul>';
		$childrenHtml = '';
	
		foreach($items as $item)
		{
			if ($item['parent'] == $parent) {
				$hasChildren = true;
				$childrenHtml .= '<li><a href="'.base_url().$item['url'].'">'.$item['nome'].'</a></li>';         
				$childrenHtml .= $this->buildNavigation($items, $item['id']);       
			}
		}
	
		// Without children, we do not need the <ul> tag.
		if (!$hasChildren) {
			$outputHtml = '';
		}
	
		// Returns the HTML
		return sprintf($outputHtml, $childrenHtml);
	} 
	*/ 	
}