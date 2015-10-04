<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Uploadimages_model extends CI_Model {
	
	private $original_path;
	private $resized_path;
	private $thumbs_path;
	
	public function __construct() {
		parent::__construct();
				
		//initialize the path where you want to save your images    
		//return the full path of the directory
		//make sure these directories have read and write permissions		
		$this->original_path = FCPATH .'public/admin/images/users/original';
   		$this->resized_path = FCPATH .'public/admin/images/users/resized';
    	$this->thumbs_path = FCPATH .'public/admin/images/users/thumbs';
	}

	function do_upload(){

    	$this->load->library('image_lib');
		
    	$config = array('allowed_types'     => 'jpg|jpeg|gif|png', //only accept these file types
						'max_size'          => 2048, //2MB max
						'upload_path'       => $this->original_path, //upload directory
						'encrypt_name'		=> TRUE,
						'file_ext_tolower'	=> TRUE);
 
		$this->load->library('upload', $config);
		
		if( ! $this->upload->do_upload('arquivo')) {
			$error = $this->upload->display_errors();
			return array(FALSE, $error);
		}
		
		$image_data = $this->upload->data(); //upload the image
		
		//your desired config for the resize() function
		$config = array('image_library'		=> 'gd2',
						'source_image'      => $image_data['full_path'], //path to the uploaded image
						'new_image'         => $this->resized_path, //path to
						'maintain_ratio'    => TRUE,
						'width'             => 128,
						'height'            => 128);			

		//this is the magic line that enables you generate multiple thumbnails
		//you have to call the initialize() function each time you call the resize()
		//otherwise it will not work and only generate one thumbnail
		$this->image_lib->clear();
		$t = $this->image_lib->initialize($config);
		
		if ( ! $this->image_lib->resize())
		{
			$error = $this->image_lib->display_errors();
			return array(FALSE, $error);
			exit;
		}
 
		$config = array('image_library'		=> 'gd2',
						'source_image'      => $image_data['full_path'],
						'new_image'         => $this->thumbs_path,
						'maintain_ratio'    => TRUE,
						'width'             => 48,
						'height'            => 48);
			
    	//here is the second thumbnail, notice the call for the initialize() function again
		$this->image_lib->clear();
   	 	$this->image_lib->initialize($config);
    	if ( ! $this->image_lib->resize())
		{
			$error = $this->image_lib->display_errors();
			return array(FALSE, $error);
			exit;
		}
	
		return array(TRUE, $image_data['file_name']);
  	}
}