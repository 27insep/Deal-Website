<?
class Deal_main extends CI_Model 
{
    protected $table_name	=	 "view_deal";
	protected $col_set			=	" deal_id
	,cat_id
	,sub_cat_id
	,vendor_id
	,vendor_name
	,deal_name
	,deal_intro
	,deal_index_image
	,deal_price_show
	,deal_buy_time_start
	,deal_buy_time_end
	,deal_reopen
	,deal_start
	,deal_expile
	,deal_buy_count
	,deal_percent_off
	,deal_hilight_detail
	,deal_aboutus_detail
	,deal_main_detail
	,deal_main_condition
	,deal_address
	,deal_email
	,deal_website
	,deal_map
	,deal_hot
	,deal_new
	,deal_recomment
	,deal_status
	,deal_special
	,deal_create
	,deal_modify
	,deal_meta_keyword
	,deal_meta_description
	,product_id
	,product_name
	,product_detail
	,product_price
	,product_include_vat
	,product_total_vat
	,product_total_price
	,product_discount_per
	,product_mrd
	,product_status
	,product_create
	,product_modify
	,product_limit
	,product_in_store";
	
    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }
    public function get_active_deal_category($cat_id="",$offset=0,$limit=10)
    {
    	$this->db->select('deal_id, deal_name,deal_intro,deal_index_image,deal_price_show,deal_buy_time_end
    										,deal_buy_count,deal_percent_off,deal_special,deal_main_condition');
		$this->db->order_by("deal_special", "desc");
		
		$this->db->group_by('deal_id');
		if($cat_id!="")
		{
			$where	=	array(	"deal_status"=>1,
										//"deal_buy_time_start <="=>date("Y-m-d H:i:s",time()),
										//"deal_buy_time_end >="=>date("Y-m-d H:i:s",time()),
										"cat_id"	=>	$cat_id
								);
			$this->db->order_by("deal_modify","desc");
    		
    		$query = $this->db->get_where($this->table_name,$where , $limit, $offset);
		}else{
			$where	=	array(	"deal_status"=>1,
										//"deal_buy_time_start <="=>date("Y-m-d H:i:s",time()),
										//"deal_buy_time_end >="=>date("Y-m-d H:i:s",time()),
							);
			$this->db->order_by("deal_buy_count", "desc"); 
			$this->db->order_by("deal_modify","desc");
			$query = $this->db->get_where($this->table_name, $where, $limit, $offset);
		}
		return $query->result_array();
    }
    public function get_active_deal_sub_category($sub_cat_id="",$offset=0,$limit=10)
    {
    	$this->db->select('deal_id, deal_name,deal_intro,deal_index_image,deal_price_show,deal_buy_time_end
    										,deal_buy_count,deal_percent_off,deal_special,deal_main_condition');
		$this->db->order_by("deal_special", "desc");
		
		$this->db->group_by('deal_id');
		if($sub_cat_id!="")
		{
			$where	=	array(	"deal_status"=>1,
										//"deal_buy_time_start <="=>date("Y-m-d H:i:s",time()),
										//"deal_buy_time_end >="=>date("Y-m-d H:i:s",time()),
										"sub_cat_id"	=>	$sub_cat_id
								);
			$this->db->order_by("deal_modify","desc");
    		
    		$query = $this->db->get_where($this->table_name,$where , $limit, $offset);
		}else{
			$where	=	array(	"deal_status"=>1,
										//"deal_buy_time_start <="=>date("Y-m-d H:i:s",time()),
										//"deal_buy_time_end >="=>date("Y-m-d H:i:s",time()),
							);
			$this->db->order_by("deal_buy_count", "desc"); 
			$this->db->order_by("deal_modify","desc");
			$query = $this->db->get_where($this->table_name, $where, $limit, $offset);
		}
		return $query->result_array();
    }

	public function get_best_deal($offset=0,$limit=10)
    {
    	$deal_data		=	array();
		$data			=	array();
		$i					=	0;
		
    	$this->db->select('deal_id, deal_name,deal_intro,deal_index_image,deal_price_show,deal_buy_time_end,deal_buy_count,deal_percent_off,deal_special');
		
		$where	=	array(	"deal_status"=>1,
									"deal_special"=>1,
									//"deal_buy_time_start <="=>date("Y-m-d H:i:s",(time()+(60*60*24))),
									//"deal_buy_time_end >="=>date("Y-m-d H:i:s",time()),
									"deal_recomment"	=>	'1'
								);
								
    	$this->db->group_by('deal_id');
		$query = $this->db->get_where($this->table_name,$where);
		
		$data	=	$query->result_array();
		foreach($data as $row)
		{
			 	$deal_data	[$i]	=	$row;
				$i++;
		}
		
		$this->db->select('deal_id, deal_name,deal_intro,deal_index_image,deal_price_show,deal_buy_time_end,deal_buy_count,deal_percent_off,deal_special');
		
		$where	=	array(	"deal_status"=>1,
									"deal_special"=>0,
									//"deal_buy_time_start <="=>date("Y-m-d H:i:s",(time()+(60*60*24))),
									//"deal_buy_time_end >="=>date("Y-m-d H:i:s",time()),
									"deal_recomment"	=>	'1'
								);
    	
		$this->db->order_by("deal_buy_count","desc");
		$this->db->group_by('deal_id');
		$query = $this->db->get_where($this->table_name,$where);
		
		$deal_data[$i]		=	$query->row_array();
		
		if(isset($deal_data[$i]["deal_id"]))
			$best_sell_id				=	$deal_data[$i]["deal_id"];
		else 
			$best_sell_id = "";

		$i++;
		/*
		$this->db->order_by("deal_buy_time_end", "asc"); 

		$where	=	array(	"deal_status"=>1,
									"deal_special"=>0,
									"deal_id != "=>$best_sell_id,
									"deal_buy_time_start >="=>date("Y-m-d 00:00:00",time()),
									"deal_buy_time_start <="=>date("Y-m-d 23:00:00",time()),
									"deal_buy_time_end >="=>date("Y-m-d H:i:s",time()),
									"deal_recomment"	=>	'1'
								);
		$this->db->group_by('deal_id');
    	$query = $this->db->get_where($this->table_name,$where , $limit, $offset);
		
		
		$data	=	$query->result_array();
		foreach($data as $row)
		{
			 	$deal_data	[$i]	=	$row;
				$i++;
		}
		*/		
		$this->db->order_by("deal_buy_time_end", "desc"); 

		if($best_sell_id != ""){
			$where	=	array(	"deal_status"=>1,
									"deal_special"=>0,
									"deal_id != "=>$best_sell_id,
									//"deal_buy_time_start <="=>date("Y-m-d H:i:s",(time())),
									//"deal_buy_time_end >="=>date("Y-m-d H:i:s",time()),
									"deal_recomment"	=>	'1'
				);
		}else{
				$where	=	array(	"deal_status"=>1,
									"deal_special"=>0,
									//"deal_buy_time_start <="=>date("Y-m-d H:i:s",(time())),
									//"deal_buy_time_end >="=>date("Y-m-d H:i:s",time()),
									"deal_recomment"	=>	'1'
				);
		}
		
		$this->db->group_by('deal_id');
    	$query = $this->db->get_where($this->table_name,$where);
		
		
		$data	=	$query->result_array();
		foreach($data as $row)
		{
			 	$deal_data	[$i]	=	$row;
				$i++;
		}
		
		$get_data	=	array();
		
		for($index=$offset,$n=0;$n<$limit&&$index<sizeof($deal_data);$index++,$n++)
		{
			$get_data[$index]	=	$deal_data[$index];
		}
		return $get_data;
   	}
    public function get_total_active_deal_category($cat_id="")
    {
    	$this->db->select('deal_id');
		$this->db->group_by('deal_id');
		$this->db->order_by("deal_special", "desc");
		$this->db->order_by("deal_buy_time_end", "asc"); 
		
		if($cat_id!="")
		{
					$where	=	array(	"deal_status"=>1,
									//"deal_buy_time_start <="=>date("Y-m-d H:i:s",time()),
									//"deal_buy_time_end >="=>date("Y-m-d H:i:s",time()),
									"cat_id"	=>	$cat_id
								);
    		$query = $this->db->get_where($this->table_name,$where);
		}else{
					$where	=	array(	"deal_status"=>1,
									//"deal_buy_time_start <="=>date("Y-m-d H:i:s",time()),
									//"deal_buy_time_end >="=>date("Y-m-d H:i:s",time())
								);
			$query = $this->db->get_where($this->table_name, $where);
		}
		 
		
		$result		=	$query->result_array();
		$total_row	=	sizeof($result);
		unset($result);
		
		return $total_row;
    }
	
	 public function get_total_active_deal_sub_category($sub_cat_id="")
    {
    	$this->db->select('deal_id');
		$this->db->group_by('deal_id');
		$this->db->order_by("deal_special", "desc");
		$this->db->order_by("deal_buy_time_end", "asc"); 
		
		if($sub_cat_id!="")
		{
					$where	=	array(	"deal_status"=>1,
									//"deal_buy_time_start <="=>date("Y-m-d H:i:s",time()),
									//"deal_buy_time_end >="=>date("Y-m-d H:i:s",time()),
									"sub_cat_id"	=>	$sub_cat_id
								);
    		$query = $this->db->get_where($this->table_name,$where);
		}else{
					$where	=	array(	"deal_status"=>1,
									//"deal_buy_time_start <="=>date("Y-m-d H:i:s",time()),
									//"deal_buy_time_end >="=>date("Y-m-d H:i:s",time())
								);
			$query = $this->db->get_where($this->table_name, $where);
		}
		 
		
		$result		=	$query->result_array();
		$total_row	=	sizeof($result);
		unset($result);
		
		return $total_row;
    }
	
    public function get_total_active_deal_keyword($keyword)
    {
    	$this->db->select('deal_id');
		$this->db->group_by('deal_id');
		$this->db->order_by("deal_special", "desc");
		$this->db->order_by("deal_buy_time_end", "asc"); 
		
		$this->db->like('deal_name', $keyword); 
		$this->db->or_like('deal_intro', $keyword);
		$this->db->or_like('deal_hilight_detail', $keyword);
		$this->db->or_like('deal_aboutus_detail', $keyword);
		$this->db->or_like('deal_main_detail', $keyword);
		$this->db->or_like('deal_main_condition', $keyword);
		$this->db->or_like('deal_address', $keyword);
		$this->db->or_like('vendor_name', $keyword);
		$this->db->or_like('product_name', $keyword);
		$this->db->or_like('product_detail', $keyword);
		 	
		$where	=	array(	"deal_status"=>1,
									//"deal_buy_time_start <="=>date("Y-m-d",time()),
									//"deal_buy_time_end >="=>date("Y-m-d",(time()-(60*60*24))),
								);
		$query = $this->db->get_where($this->table_name,$where);
		
		
		$result		=	$query->result_array();
		$total_row	=	sizeof($result);
		unset($result);
		
		return $total_row;
    }
    
    public function get_total_sale_by_deal_id($deal_id,$product_id="")
	{
		$this->db->select('c.vendor_id,c.product_name,c.deal_name,c.round_start,c.product_key,c.deal_expile,
											c.deal_start,c.round_end,c.round_id,c.coupon_expire,c.coupon_can_use,
											c.sell_price,c.price_include_vat,c.product_mrd,c.product_total_price,c.deal_id');
		$this->db->from('view_sell_coupon c');	
		
		if(!empty($product_id)){
			$where	=	array(	"c.deal_id"=>$deal_id, "c.product_key"=>$product_id);
			$this -> db -> where($where);
		}
		else
			$this -> db -> where('c.deal_id', $deal_id);
		
		$this->db->order_by('c.product_key','asc');
		$this->db->group_by('c.vendor_id,c.product_name,c.deal_name,c.round_start,c.product_key,
		c.deal_expile,c.deal_start,c.round_end,c.round_id,c.coupon_expire,c.coupon_can_use,
		c.sell_price,c.price_include_vat,c.product_mrd,c.product_total_price,c.deal_id');
		$query = $this->db->get();
		
		$this->db->select('count(coupon_id) n,product_key');
		$this->db->from('view_sell_coupon');	
		
		if(!empty($product_id)){
			$where	=	array(	"deal_id"=>$deal_id, "product_key"=>$product_id);
			$this -> db -> where($where);
		}
		else
			$this -> db -> where('deal_id', $deal_id);
			
		$this->db->group_by('product_key');
		$query_coupon = $this->db->get();
		
		$data['sell_coupon']	=	$query->result_array();
		$data['nCoupon']	=	$query_coupon->result_array();
		return $data;
	}
	public function get_total_sale_by_vendor_id($vendor_id)
	{
		$this->db->select('c.vendor_id,c.product_name,c.deal_name,c.round_start,c.product_key,c.deal_expile,
											c.deal_start,c.round_end,c.round_id,c.coupon_expire,c.coupon_can_use,
											c.sell_price,c.price_include_vat,c.product_mrd,c.product_total_price,c.deal_id');
		$this->db->from('view_sell_coupon c');	
		$this -> db -> where('c.vendor_id', $vendor_id);
		$this->db->order_by('c.product_key','asc');
		$this->db->group_by('c.vendor_id,c.product_name,c.deal_name,c.round_start,c.product_key,
		c.deal_expile,c.deal_start,c.round_end,c.round_id,c.coupon_expire,c.coupon_can_use,
		c.sell_price,c.price_include_vat,c.product_mrd,c.product_total_price,c.deal_id');
		$query = $this->db->get();
		
		$this->db->select('count(coupon_id) n,product_key');
		$this->db->from('view_sell_coupon');	
		$this -> db -> where('vendor_id', $vendor_id);
		$this->db->group_by('product_key');
		$query_coupon = $this->db->get();
		
		$data['sell_coupon']	=	$query->result_array();
		$data['nCoupon']	=	$query_coupon->result_array();
		return $data;
		
	}
	public function get_active_deal_by_id($deal_id)
	{
		$this->db->select($this->col_set);
		
		$where	=	array(	"deal_status"=>1,
									//"deal_buy_time_start <="=>date("Y-m-d",time()),
									//"deal_buy_time_end >="=>date("Y-m-d",time()),
									"deal_id"=>$deal_id
								);
		$query = $this->db->get_where($this->table_name, $where);
		
		return $query->row_array();
	}
	public function get_deal_by_id($deal_id)
	{
		$this->db->select($this->col_set);
									
		$where	=	array(	"deal_id"=>$deal_id);
		$query = $this->db->get_where($this->table_name, $where);
		
		return $query->row_array();
	}
	public function get_vendor_deal_by_id($deal_id)
	{
		$this->db->select($this->col_set);
		
		$where	=	array(	"deal_id"=>$deal_id );
		$query = $this->db->get_where($this->table_name, $where);
		
		return $query->row_array();
	}
	public function get_deal_by_vendor_id($vendor_id)
	{
		$this->db->select($this->col_set);
		$this->db->group_by('deal_id');
		$where	=	array(	
									"vendor_id"=>$vendor_id
								);
		$query = $this->db->get_where($this->table_name, $where);
		
		return $query->result_array();
	}
	
	public function get_deal_by_vendor_id_round($vendor_id)
	{
		$this->db->select('d.deal_id,d.deal_name,r.round_start,r.round_end'); 
		$this->db->from('tbl_deal_main d');
		$this->db->join('tbl_deal_round r', 'd.deal_id = r.deal_id', 'left');
		$this->db->where("d.vendor_id",$vendor_id);		
		$this->db->group_by('d.deal_id,d.deal_name,r.round_start,r.round_end');
		$query = $this->db->get();
		
		return $query->result_array();
	}
	public function get_last_deal_by_vendor_id($vendor_id)
	{
		$this->db->select($this->col_set);
		$this->db->order_by('deal_id','desc');
		$this->db->limit(1);
		$where	=	array(	
									"vendor_id"=>$vendor_id
								);
		$query = $this->db->get_where($this->table_name, $where);
		
		return $query->row_array();
	}
	public function get_recomment_deal($limit="")
	{
		$this->db->select($this->col_set);
		
		$where	=	array(	
									"deal_status"=>1,
									//"deal_buy_time_start <="=>date("Y-m-d",time()),
									//"deal_buy_time_end >="=>date("Y-m-d",time()),
									"deal_recomment"=>1
								);
		$this->db->order_by('rand()');
		
		if(!empty($limit))
			$this->db->limit($limit);
		
		$this->db->group_by('deal_id');
		
		$query = $this->db->get_where($this->table_name, $where);
		
		return $query->result_array();
	}
	public function get_deal_cart_by_id($deal_id)
	{
		$this->db->select('deal_id, deal_name,deal_index_image,deal_percent_off,deal_price_show');
		
		$where	=	array(	"deal_status"=>1,
									//"deal_buy_time_start <="=>date("Y-m-d",time()),
									//"deal_buy_time_end >="=>date("Y-m-d",time()),
									"deal_id"=>$deal_id
								);
		$query = $this->db->get_where($this->table_name, $where);
		
		return $query->row_array();
	}
	public function get_relate_deal($deal_id,$limit)
	{
		$this->db->select('cat_id');
		
		$where	=	array(	
									"deal_status"=>1,
									//"deal_buy_time_start <="=>date("Y-m-d",time()),
									//"deal_buy_time_end >="=>date("Y-m-d",time()),
									"deal_id"=>$deal_id
								);
		$query = $this->db->get_where($this->table_name, $where);
		
		$data	=	$query->row_array();
		
		if(sizeof($data)>0)
		{
			$cat_id	=	$data["cat_id"];
		
			$this->db->select('deal_id, deal_name,deal_intro,deal_index_image,deal_price_show,deal_buy_time_end,deal_buy_count,deal_percent_off');
		
			$where	=	array(	"deal_status"=>1,
										//"deal_buy_time_start <="=>date("Y-m-d",time()),
										//"deal_buy_time_end >="=>date("Y-m-d",time()),
										"cat_id"=>$cat_id,
										"deal_id !="=>$deal_id,
										"deal_price_show >"=>'0'
									
								);
			$this->db->group_by('deal_id');
			$query = $this->db->get_where($this->table_name, $where, $limit, 0);
		}else{
			$this->db->select('deal_id, deal_name,deal_intro,deal_index_image,deal_price_show,deal_buy_time_end,deal_buy_count,deal_percent_off');
		
			$where	=	array(	"deal_status"=>1,
										//"deal_buy_time_start <="=>date("Y-m-d",time()),
										//"deal_buy_time_end >="=>date("Y-m-d",time()),
										"deal_id !="=>$deal_id,
										"deal_price_show >"=>'0'
								);
			$this->db->group_by('deal_id');
			$query = $this->db->get_where($this->table_name, $where, $limit, 0);
		}
		
		return $query->result_array();
	}
	public function get_all_deal()
	{
		$this->db->select($this->col_set);
		$this->db->order_by('deal_create','DESC');
		$this->db->group_by('deal_id');
		$query = $this->db->get($this->table_name);
		
		return $query->result_array();
	}
	public function get_deal_new($offset=0,$limit=5)
	{
		$this->db->select('deal_id, deal_name,deal_intro,deal_index_image,deal_price_show,deal_buy_time_end,deal_buy_count,deal_percent_off');
		$where	=	array(	"deal_status"=>1,
									//"deal_buy_time_start <="=>date("Y-m-d",time()),
									//"deal_buy_time_end >="=>date("Y-m-d",time()),
									"deal_price_show >"=>'0');
		$this->db->where($where);
		$this->db->order_by('deal_create','DESC');
		$this->db->group_by('deal_id');
		$query = $this->db->get($this->table_name, $limit, $offset);
		
		return $query->result_array();
	}
	public function get_deal_best_sell($offset=0,$limit=5)
	{
		$this->db->select('deal_id, deal_name,deal_intro,deal_index_image,deal_price_show,deal_buy_time_end,deal_buy_count,deal_percent_off');
		$where	=	array(	"deal_status"=>1,
									//"deal_buy_time_start <="=>date("Y-m-d",time()),
									//"deal_buy_time_end >="=>date("Y-m-d",time()),
									"deal_price_show >"=>'0');
		$this->db->where($where);
		$this->db->order_by('deal_buy_count','DESC');
		$this->db->group_by('deal_id');
		$query = $this->db->get($this->table_name, $limit, $offset);
		
		return $query->result_array();
	}
	public function get_deal_by_keyword($offset=0,$limit=5,$keyword)
	{
		$sql	=	"	SELECT deal_id, deal_name,deal_intro,deal_index_image,deal_price_show,deal_buy_time_end,deal_buy_count,deal_percent_off,deal_special
						FROM view_deal
						WHERE deal_status = '1' 
						AND deal_buy_time_start <= '".date("Y-m-d H:i:s",time())."'
						AND deal_buy_time_end >= '".date("Y-m-d H:i:s",time())."'
						AND deal_price_show > 0
						AND (deal_name LIKE '%".$keyword."%'
						OR deal_intro LIKE '%".$keyword."%'
						OR deal_hilight_detail LIKE '%".$keyword."%'
						OR deal_aboutus_detail LIKE '%".$keyword."%'
						OR deal_main_detail LIKE '%".$keyword."%'
						OR deal_main_condition LIKE '%".$keyword."%'
						OR deal_address LIKE '%".$keyword."%'
						OR vendor_name LIKE '%".$keyword."%'
						OR product_name LIKE '%".$keyword."%'
						OR product_detail LIKE '%".$keyword."%'
						)
						GROUP BY deal_id
						ORDER BY deal_buy_count DESC
						LIMIT ".$offset.",".$limit;
		
		$query = $this->db->query($sql);
		
		return $query->result_array();
	}

	public function update_buy_count($deal_id)
	{
		$this->db->select('order_id,product_id');
		
		$where	=	array(	
									"deal_id"=>$deal_id
								);
								
		$query = $this->db->get_where("tbl_coupon", $where);
		
		$data 	=	$query->result_array();	 
		
		$product_set	=	array();
		
		$nQty	=	0;
		
		foreach($data as $item)
		{
			$index	=	$item["product_id"];
			$nQty++;
			
			if(!isset($product_set[$index]))
			{
				$product_set[$index]	=	0;
			}else{
				$product_set[$index]++;
			}
		}
		
		foreach($product_set as $id=>$qty)
		{
			$this->db->select('product_id,product_in_store');
			$where	=	array("product_id"=>$id);
			$query = $this->db->get_where("tbl_deal_product", $where);
			$product_limit	=	$query->row_array();
			
			$nLess	=	$product_limit["product_in_store"]-$qty;
			
			$data_less	=	array(
							"product_in_store"=>$nLess
						);
			$this->db->where('product_id', $id);
			$this->db->update("tbl_deal_product", $data_less);
		}
		
		$data	=	array(
							"deal_buy_count"=>$nQty
						);
		$this->db->where('deal_id', $deal_id);
		$this->db->update("tbl_deal_main", $data);
		
		unset($data);
	}
	public function update_deal_price($deal_id)
	{
		$this->db->select('product_id,product_total_price,product_discount_per');
		$where	=	array(	
									"deal_id"=>$deal_id
								);
		$this->db->order_by('product_total_price','ASC');
		$query = $this->db->get_where("tbl_deal_product", $where);
		$price_data	=	$query->row_array();
		
		$data	=	array(
							"deal_price_show"=>$price_data["product_total_price"],
							"deal_percent_off"=>$price_data["product_discount_per"]
						);
		$this->db->where('deal_id', $deal_id);
		$this->db->update("tbl_deal_main", $data);
	}
	public function get_deal_id()
	{		
		$this->db->select('deal_id'); 
		$this->db->from($this->table_name);
		$this->db->order_by("deal_id", "desc"); 
		
		$query 	= $this->db->get();
		$data	=	$query->row_array();
		
		return ($data["deal_id"]+1);
	}
	
	public function get_product_special($deal_id,$member_id)
	{
		$order = "select count(*) c
							  from tbl_deal_order o inner join tbl_deal_order_detail od on o.order_id = od.order_id
							  where od.deal_id = ".$deal_id." and o.mem_id = ".$member_id;
		$query_order = $this->db->query($order);
		$num				=	$query_order->row_array();
		
		if($num["c"] == "0")
		{
				$this->db->select("product_id"); 
				$this->db->from($this->table_name);
				$this->db->where('deal_id', $deal_id);
				$query 	= $this->db->get();
				$data	=	$query->row_array();
		}else {
			$data["product_id"] = "";
		}
		
		return $data["product_id"];
	}
	
	public function get_active_deal_last_modify()
	{
		$this->db->select($this->col_set);
		//echo date("Y-m-d H:i:s",(time()-(60*60*24*14)));
		$where	=	array(	"deal_status"=>1,
									"deal_buy_time_start <="=>date("Y-m-d",time()),
									"deal_buy_time_end >="=>date("Y-m-d",time()),
									"deal_modify >="=>date("Y-m-d H:i:s",(time()-(60*60*24*7)))
								);
		$this->db->group_by('deal_id');
		$query = $this->db->get_where($this->table_name, $where);
		
		return $query->result_array();
	}
}
?>