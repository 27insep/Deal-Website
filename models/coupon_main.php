<?
class coupon_main extends CI_Model 
{
	protected $table_name	=	 "tbl_coupon";
	 	
    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }
	
    public function get_coupon($member_id,$deal_id,$coupon_id)
    {
    		$data = array();
			$deal = "select d.deal_name,v.vendor_logo,d.deal_main_detail,d.deal_address  location,
							  d.deal_main_condition,v.vendor_email,v.vendor_website
							 from tbl_deal_main d 
							 left join tbl_vendor_profile v on v.vendor_id = d.vendor_id
							 where d.deal_id = ".$deal_id;
			$query_deal = $this->db->query($deal);
			
			$mem = "select member_id,member_name,member_sname   from tbl_member_profile where member_id = ".$member_id;
			$query_mem = $this->db->query($mem);
			
			$coupon = "select c.coupon_id,c.order_id,c.redemption_code ,p.product_name,p.product_detail,
									c.coupon_can_use,c.coupon_expire,voucher_number,barcode
									from tbl_coupon c
								    inner join tbl_deal_product p on c.product_id = p.product_id
									where c.coupon_id = ".$coupon_id;
			$query_coupon = $this->db->query($coupon);

				//echo $deal;
				$data['deal_main']	=	$query_deal->row_array();
				$data['member']	=	$query_mem->row_array();
				$data['coupon']	=	$query_coupon->row_array();
				return $data;
	}
	public function get_coupon_expile_soon($member_id)
	{
		$this->db->select('coupon_id');
		
		$where	=	array(	"mem_id"=>$member_id,
									"coupon_expire <"=>date("Y-m-d H:i:s",(time()+(60*60*24*7)))
								);
		$query = $this->db->get_where($this->table_name, $where);
		
		$data	=	array();
		$data	=	 $query->result_array();
		
		$nRow	=	sizeof($data);
		unset($data);
		
		return $nRow;
	}
	
	public function get_coupon_duplicate($order_id)
	{
		$this->db->select('coupon_id');
		
		$where	=	array(	"order_id"=>$order_id);
		$query = $this->db->get_where($this->table_name, $where);
		
		$data	=	array();
		$data	=	 $query->result_array();
		
		$nRow	=	sizeof($data);
		unset($data);
		
		return $nRow;
	}
	
	public function update_coupon_status($status,$coupon_id)
	{
		if($status==2)
		{
			$data	=	array(
									"coupon_status"=>$status,
									"coupon_use_date"=>date("Y-m-d H:i:s",time())
									);
		}
		if($status==1)
		{
			$data	=	array(
									"coupon_status"=>$status,
									"coupon_use_date"=>NULL
									);
		}
		$this->db->where('coupon_id', $coupon_id);
		$this->db->update($this->table_name, $data);
	}
	
	public function get_product_qty($product_id)
	{		
		$this->db->select('count(product_id) as qtyProduct'); 
		$this->db->from($this->table_name);
		$this->db->where('product_id', $product_id);
		
		$query 	= $this->db->get();
		$data	=	$query->row_array();
		
		return ($data["qtyProduct"]+1);
	}
	
	public function get_coupon_barcode($order_id)
	{		
		$this->db->select('c.coupon_id,product_price'); 
		$this->db->from('tbl_coupon c');
		$this->db->join('tbl_deal_product p', 'c.product_id = p.product_id', 'left');
		$this->db->where('c.order_id', $order_id);
		
		$query 	= $this->db->get();
		$data	=	$query->result_array();
		
		return $data;
	}
	
	public function update_coupon_barcode($coupon_id,$barcode)
	{
			$data	=	array("barcode"=>$barcode);
			$this->db->where('coupon_id', $coupon_id);
			$this->db->update($this->table_name, $data);
	}
	
		public function get_coupon_summary($product_id="")
	{
			$this->db->select("count(c.coupon_id) as nCoupon,c.product_id");
			$this->db->from('tbl_coupon c');
			
			if (!empty($product_id))
				$this->db->where_in('c.product_id',$product_id);
			
			$this->db->group_by("c.product_id","ASC"); 
			$query_Coupon 	=  $this->db->get();
			
			$nCoupon			=	$query_Coupon->result_array();
			return $nCoupon;
	}
}
?>