<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Tool extends CI_Controller 
{
	public function update_coupon()
	{
		$this->load->database();
		$query 	= 	$this->db->get('tbl_deal_order_detail');	
		$data	=	$query->result_array();
	} 	
}