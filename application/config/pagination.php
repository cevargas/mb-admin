<?php if(!defined('BASEPATH')) exit('Direct Access Not Allowed');

/* This Application Must Be Used With BootStrap 3 *  */
$config['full_tag_open'] = '<ul class="pagination">';
$config['full_tag_close'] = '</ul>';

$config['first_link'] = '<i class="fa fa-angle-double-left"></i>';
$config['last_link'] = '<i class="fa fa-angle-double-right"></i>';

$config['first_tag_open'] = '<li>';
$config['first_tag_close'] = '</li>';

$config['prev_link'] = '<i class="fa fa-angle-left"></i>';

//$config['prev_tag_open'] = '<li class="prev"><span class="tooltips" data-placement="left" title="Anterior">';
//$config['prev_tag_close'] = '</span></li>';

$config['prev_tag_open'] = '<li class="prev">';
$config['prev_tag_close'] = '</li>';

$config['next_link'] = '<i class="fa fa-angle-right"></i>';

$config['next_tag_open'] = '<li>';
$config['next_tag_close'] = '</li>';

$config['last_tag_open'] = '<li>';
$config['last_tag_close'] = '</li>';

$config['cur_tag_open'] = '<li class="active"><a href="#">';
$config['cur_tag_close'] = '</a></li>';

$config['num_tag_open'] = '<li>';
$config['num_tag_close'] = '</li>';

$config['per_page'] = 20;
//$config['num_links'] = 4;
$config['page_query_string'] = TRUE;
$config['reuse_query_string'] = TRUE;
$config['use_page_numbers'] = TRUE;

// end of file Pagination.php 
// Location config/pagination.php 
// By @emanisof 