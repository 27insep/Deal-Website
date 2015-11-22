<?
class Deal_product extends CI_Model 
{
    protected $table_name	=	 "view_deal";
	
    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }
	public function get_product_all()
	{
		/*
		$this->db->select(' deal_id,cat_id,sub_cat_id,vendor_id,vendor_name,deal_name,deal_intro,deal_index_image,deal_price_show,
		deal_buy_time_start,deal_buy_time_end,deal_start,deal_expile,deal_buy_count,deal_percent_off,deal_hilight_detail,
		deal_aboutus_detail,deal_main_detail,deal_status,deal_create,deal_modify,product_id,product_name,
 		product_detail,product_price,product_include_vat,product_total_vat,product_total_price,product_status,product_create,
 		product_modify,product_limit,product_in_store');
		*/
		$this->db->order_by('product_create','DESC');
		$query = $this->db->get_where($this->table_name,array('product_id !=' => ''));
		
		return $query->result_array();
	}
	public function get_product_by_deal_id($deal_id)
	{
		/*
		$this->db->select(' deal_id,cat_id,sub_cat_id,vendor_id,vendor_name,deal_name,deal_intro,deal_index_image,deal_price_show,
		deal_buy_time_start,deal_buy_time_end,deal_start,deal_expile,deal_buy_count,deal_percent_off,deal_hilight_detail,
		deal_aboutus_detail,deal_main_detail,deal_contact_us,deal_status,deal_create,deal_modify,product_id,product_name,
 		product_detail,product_price,product_include_vat,product_total_vat,product_total_price,product_status,product_create,
 		product_modify,product_limit,product_in_store');
		*/
		$where	=	array(	"product_status"=>1,
									"deal_id"=>$deal_id
								);
		$query = $this->db->get_where($this->table_name, $where);
		
		return $query->result_array();
	}

	public function get_product_vendor($deal_id)
	{
		$this->db->select('p.product_id,p.product_name,d.deal_id,d.deal_name,r.round_start,r.round_end'); 
		$this->db->from('tbl_deal_product p');
		$this->db->join('tbl_deal_main d', 'p.deal_id = d.deal_id', 'left');
		$this->db->join('tbl_deal_round r', 'd.deal_id = r.deal_id', 'left');
		$this->db->where(array('d.deal_id' =>$deal_id,'p.product_status'=>1) );
		$query = $this->db->get();
		
		return $query->result_array();
	}

	public function get_product_by_product_id($product_id)
	{
		//$this->db->select('deal_id,vendor_name,product_id,product_name,product_detail,product_price,product_limit,product_in_store');
		
		$where	=	array("product_status"=>1,"product_id"=>$product_id
								);
		$query = $this->db->get_where($this->table_name, $where);
		

		return $query->row_array();
	}
	
	public function get_all_product_by_product_id($product_id)
	{
		//$this->db->select('deal_id,vendor_name,product_id,product_name,product_detail,product_price,product_limit,product_in_store');
		
		$where	=	array("product_id"=>$product_id);
		$query = $this->db->get_where($this->table_name, $where);
		
		return $query->row_array();
	}

	public function get_product_all_by_product_id($product_id)
	{
		/*
		 $this->db->select('deal_id,vendor_name,deal_name,product_id,product_name,product_detail
											,product_price,product_limit,product_in_store,product_include_vat,product_total_price,product_status');
		*/
		$where	=	array("product_id"=>$product_id
								);
		$query = $this->db->get_where($this->table_name, $where);
		

		return $query->row_array();
	}

	public function get_summary_price_by_product_set($product_set)
	{
		$this->db->select('product_id,product_total_price');
		
		$set_product	= array();
		
		$i	=	0;
		
		foreach($product_set as $index=>$data)
		{
			$set_product[$i++]	=	$index;
		}
		
		$this->db->where_in("product_id",$set_product);
		
		unset($set_product);

		$query 	= $this->db->get($this->table_name);
		
		$price_set	=	$query->result_array();
		$summary_price		=	0;
		
		foreach($price_set as $data)
		{
			$index	=	$data['product_id'];
			$summary_price	+= $data["product_total_price"]*$product_set[$index]["qty"];		
		}
		
		return $summary_price;
	}
	public function check_store($product)
	{
		$product_set	=	array();
		
		$i	=	0;
		foreach($product as $product_id=>$item)
		{
			$product_set[$i++]	=	$product_id;
		}
		
		$this->db->select('deal_id,product_id,product_in_store');
		
		$this->db->where_in('product_id',$product_set);
		
		$query = $this->db->get($this->table_name);
		
		$data	= $query->result_array();
		
		foreach($data as $item)
		{
			$product_id	=	$item["product_id"];
			
			if($item["product_in_store"]<$product[$product_id]["qty"])
				return false;
		}
		return true;
	}
}
?>