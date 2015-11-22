<?
class Member_coupon extends CI_Model 
{
    protected $table_name	=	 "view_member_coupon";
	
    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }
	public function get_all_coupon($filter_id="",$filter_type="")
	{
			$this->db->select('v.vendor_id,v.vendor_name,d.deal_id,d.deal_name,c.coupon_id,c.order_id,c.mem_id,m.member_name,m.member_id,m.member_sname
												,c.coupon_create_time,c.coupon_can_use,c.coupon_expire,coupon_use_date
												,c.coupon_status,d.deal_id,c.barcode,c.redemption_code,c.voucher_number');
			$this->db->from('tbl_coupon c');
			
			$this->db->join('tbl_deal_main d', 'c.deal_id = d.deal_id', 'left');
			
			$this->db->join('tbl_vendor_profile v', 'd.vendor_id = v.vendor_id', 'left');
			
			$this->db->join('tbl_member_profile m', 'c.mem_id = m.member_id', 'left');
			
			if($filter_id != "")
			{
				switch($filter_type)	
				{
					case 1:
						$this->db->where("v.vendor_id",$filter_id);
						break;
					case 2:
						$this->db->where("d.deal_id",$filter_id);
						break;
					case 3:
						$this->db->where("c.product_id",$filter_id);
						break;
					default:
						$this->db->where("m.member_id",$filter_id);			
				}
			}
			
			$query = $this->db->get();
			
		return $query->result_array();
	}
	
	public function get_coupon_by_product_id($product_id)
	{
		$this->db->select(	array('coupon_id',
									'deal_id',
									'order_id',
									'product_id',
									'coupon_can_use',
									'coupon_expire',
									'coupon_status',
									'coupon_use_date',
									'coupon_create_time',
									'redemption_code',
									'voucher_number',
									'barcode',
									'member_id',
									'member_name',
									'member_sname',
									'member_email',
									'member_mobile')
								);
		$query = $this->db->get_where($this->table_name, array('product_id' =>$product_id));
			
		return $query->result_array();
	}
	
	public function get_coupon_by_coupon_list($product_id,$coupon_list)
	{
		$this->db->select(	array('coupon_id',
									'deal_id',
									'order_id',
									'product_id',
									'coupon_can_use',
									'coupon_expire',
									'coupon_status',
									'coupon_use_date',
									'coupon_create_time',
									'redemption_code',
									'voucher_number',
									'barcode',
									'member_id',
									'member_name',
									'member_sname',
									'member_email',
									'member_mobile')
								);
		$this->db->where_in('coupon_id', $coupon_list);
		$query = $this->db->get_where($this->table_name, array('product_id' =>$product_id));
			
		return $query->result_array();
	}
	public function get_coupon_by_fillter($product_id,$coupon_id="",$member_name="",$coupon_status="")
	{
			$this->db->select(	array('coupon_id',
									'deal_id',
									'order_id',
									'product_id',
									'coupon_can_use',
									'coupon_expire',
									'coupon_status',
									'coupon_use_date',
									'coupon_create_time',
									'redemption_code',
									'voucher_number',
									'barcode',
									'member_id',
									'member_name',
									'member_sname',
									'member_email',
									'member_mobile')
								);
		$this->db->where('product_id', $product_id); 
		if($coupon_id!="")
		{
			$this->db->where('coupon_id', $coupon_id); 
		}
		if($coupon_status!="")
		{
			$this->db->where('coupon_status', $coupon_status); 
		}
		if($member_name!="")
		{
			$this->db->like('member_name',$member_name); 
			$this->db->or_like('member_sname', $member_name); 
		}
		$query = $this->db->get($this->table_name);
			
		return $query->result_array();
	}
}
?>