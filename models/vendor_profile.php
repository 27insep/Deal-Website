<?
class Vendor_profile extends CI_Model 
{
    protected $table_name	=	 "tbl_vendor_profile";
	protected $col_set			=		array(	'vendor_id',
															'vendor_logo',
															'vendor_name',
															'vendor_contact_fname',
															'vendor_contact_sname',
															'vendor_pwd',
															'vendor_address',
															'vendor_email',
															'vendor_fax',
															'vendor_phone',
															'vendor_website',
															'vendor_map',
															'vendor_about_us',
															'vendor_modify',
															'vendor_status',
															'vendor_create');
    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }
	public function get_next_vendor_id()
	{
		$th_year		=	(int)(date("Y",time()))+543;
		$th_year		= substr($th_year,-2).date("m",time());
		
		$this->db->like('vendor_id', $th_year, 'after'); 
		$this->db->from($this->table_name);
		$this->db->order_by("vendor_id","DESC");
		
		$query	=	$this->db->get();
		$data	=	$query->row_array();
		if(sizeof($data)>0)
		{
			$nRow	=	((int)substr($data["vendor_id"],-4))+1;
		}else{
			$nRow	=	1;
		}
		$fill_zero	=	4-strlen($nRow);
		for($i=0;$i<$fill_zero;$i++)
		{
			$nRow	=	"0".$nRow;
		}
		
		return	$th_year.$nRow;
	}
	public function get_vendor_profile_by_login($vendor_user,$vendor_pwd)
	{
			$this->db->select('vendor_id');
			$query = $this->db->get_where($this->table_name, array('vendor_email' =>$vendor_user,'vendor_pwd'=>$vendor_pwd));
			
			return $query->row_array();
	}
	public function get_vendor_profile_by_id($vendor_id)
	{
		$this->db->select(	$this->col_set);
		$query = $this->db->get_where($this->table_name, array('vendor_id' =>$vendor_id));
			
		return $query->row_array();
	}
	
	public function get_vendor_profile_by_dealid($deal_id)
	{
			$this->db->select("v.vendor_name,d.deal_name");
			$this->db->from('tbl_deal_main d');
			$this->db->join('tbl_vendor_profile v', 'v.vendor_id = d.vendor_id', 'left');
			$this->db->where('d.deal_id', $deal_id);
			$query = $this->db->get();
			$query->row_array() ;
			
			return $query->row_array() ;
	}
	
	public function get_all_vendor_profile()
	{
		$this->db->select(	$this->col_set);
		$query = $this->db->get($this->table_name);
		
		$data	=	array();
		foreach($query->result_array() as $shop)
		{
			$index	=	$shop["vendor_id"];
			$data[$index]	=	$shop;
		}
		return $data;
	}
	public function get_vendor_summary($vendor_id)
	{
		$sql					=	"select count(distinct order_id) as nOrder
						 			from tbl_deal_order_detail 
						 			where vendor_id = ".$vendor_id."
						 			group by vendor_id";		
		$query_nOrder 	= $this->db->query($sql);
		
		$nOrder				=	$query_nOrder->row_array();
		
		$sql					=	"select count(c.coupon_id) as nCoupon
						 			from tbl_coupon as c,tbl_deal_order_detail as d
						 			where d.vendor_id = ".$vendor_id."
						 			and c.order_id = d.order_id
						 			and c.product_id = d.product_id
						 			group by d.vendor_id";	
		$query_Coupon 	= $this->db->query($sql);
		
		$nCoupon			=	$query_Coupon->row_array();
		
		$sql					=	"select c.product_id,count(c.coupon_id) as nCoupon
						 			from tbl_coupon as c,tbl_deal_order_detail as d
						 			where d.vendor_id = ".$vendor_id."
						 			and c.order_id = d.order_id
						 			and c.product_id = d.product_id
						 			group by c.product_id";	
		$query_sell 	= $this->db->query($sql);
		
		$nSell			=	$query_sell->result_array();
		
		$sql				=	"	SELECT dp.product_id,dp.product_total_price 
									FROM tbl_deal_product as dp,tbl_deal_main as d
									WHERE d.vendor_id = ".$vendor_id."
									AND d.deal_id = dp.deal_id
									";
		$query_product 	= $this->db->query($sql);
		
		$nProduct	=	$query_product->result_array();
		$nPrice	=	array();
		foreach($nProduct as $data)
		{
			$index	=	$data["product_id"];
			$nPrice[$index]	=	$data["product_total_price"];
		}
		unset($nProduct);
			
		$nIncome	=	0;
		foreach($nSell as $cal_data)
		{
			$index	=	$cal_data["product_id"];
			$nIncome	+=	$nPrice[$index]*$cal_data["nCoupon"];
		}
		
		$data	=	array();
		$data["nOrder"]		=	0;
		$data["nCoupon"]	=	0;
		$data["nIncome"]	=	0;
		
		if(!empty($nOrder))	$data["nOrder"]			=	$nOrder["nOrder"];
		if(!empty($nCoupon))	$data["nCoupon"]		=	$nCoupon["nCoupon"];
		if(!empty($nIncome))	$data["nIncome"]		=	$nIncome;
		
		return $data;
	}
	public function has_vendor_email($email)
	{
		$this->db->select('vendor_id');
		$query = $this->db->get_where($this->table_name, array('vendor_email' =>$email));
		
		if($query->num_rows()>0)
		{
			return true;
		}else{
			return false;
		}
	}
	public function check_pwd($pwd,$vendor_id)
	{
		$pwd	=	base64_encode($pwd);
		$this->db->select('vendor_id');
		$query = $this->db->get_where($this->table_name, array('vendor_id' =>$vendor_id,'vendor_pwd'=>$pwd));
		
		if($query->num_rows()>0)
		{
			return true;
		}else{
			return false;
		}
	}
	public function add_vendor_user($vendor_data)
	{
		//$vendor_data["vendor_id"]		=	$this->get_next_vendor_id();
		$this -> db -> insert( $this->table_name, $vendor_data);
	}
	public function update_verndor_profile($vendor_data)
	{
		$this->db->where('vendor_id', $vendor_data["vendor_id"]);
		$this->db->update($this->table_name, $vendor_data);
	}
	public function has_email($email,$vendor_id="")
	{
		$this->db->select('vendor_id');
		
		$query = $this->db->get_where($this->table_name, array('vendor_email' =>$email,'vendor_id !=' =>$vendor_id));
		
		if($query->num_rows()>0)
		{
			return true;
		}else{
			return false;
		}
	}
	public function delete_vendor_profile($vendor_id)
	{
		$this -> db -> where("vendor_id", $vendor_id);
		$this -> db -> delete("tbl_vendor_profile");
		
		$this->db->select("deal_id");
		$where	=	array(	
									"vendor_id"=>$vendor_id
								);
		$query = $this->db->get_where("tbl_deal_main", $where);
		
		$data_set	=	 $query->result_array();
		
		foreach($data_set as $deal)
		{
			$this -> db -> where("deal_id", $deal["deal_id"]);			
			$this -> db -> delete("tbl_deal_main");
			$this -> db -> delete("tbl_deal_order_detail");
			$this -> db -> delete("tbl_coupon");
			$this -> db -> delete("tbl_deal_gallery");
			$this -> db -> delete("tbl_deal_product");
			$this -> db -> delete("tbl_deal_slide");
		}
	}
}
?>