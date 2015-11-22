<?
class member_orderdetail extends CI_Model 
{	
    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }
	
    public function ShowOrderDetail($order_id,$member_id="")
    {
		   	$data = array();
			$order = "select mem_id,receipt_id,order_id,order_date,format(order_summary,2) order_summary,ref_code,order_summary,order_status,payment_type,order_pay_date
							  from tbl_deal_order where order_id = ".$order_id;
			$query_order 			= $this->db->query($order);
			$data['order']				=	$query_order->row_array();
			
			if(empty($member_id))	$member_id	=	$data['order']	['mem_id']	;
			
			$member = "select m.member_id,m.member_name, m.member_sname, m.member_address, m.city_name, p.province_name, m.member_zipcode,m.member_email
								 	from  tbl_member_profile m
								 	left join tbl_province_data p on m.province_id = p.province_id
								 	where m.member_id = ".$member_id;
			$query_member = $this->db->query($member);
			
			 $order_detail	=	"select p.product_id,p.product_name,od.product_qty,p.product_total_price,p.product_total_price,od.vendor_id,d.deal_name
						 				from tbl_deal_order_detail od
						 				inner join tbl_deal_product p on od.product_id = p.product_id
						 				left join tbl_deal_main d on od.deal_id = d.deal_id
						 				 where od.order_id = ".$order_id;		
			$query_order_detail = $this->db->query($order_detail);
			
			
			$data['order_detail']	=	$query_order_detail->result_array();
			$data['member']		=	$query_member->row_array();
		   return $data;
	}
	
	 public function ShowOrderMember($filter_id="",$filter_type="")
	 {
	 		$order = 	"		select o.order_id,o.payment_type,o.mem_id,m.member_name,m.member_sname,o.order_date,o.order_pay_date,o.order_summary,o.order_status
							 		from tbl_deal_order o
							 		left join tbl_member_profile m on o.mem_id = m.member_id
									left join tbl_deal_order_detail od on o.order_id = od.order_id
							";
			
			if($filter_id != "")
			{
				switch($filter_type)	
				{
					case 1:
						$order .= " where od.vendor_id = ".$filter_id;
						break;
					case 2:
						$order .= " where od.deal_id = ".$filter_id;
						break;
					case 3:
						$order .= " where od.product_id = ".$filter_id;
						break;
					default:
						$order .= " where o.mem_id = ".$filter_id;
				}
			}
			
			$order .= " group by o.order_id";
			
			$query_order = $this->db->query($order);
			$order =  $query_order->result_array();
			
			$i = 0;
			$order_id = "";
			foreach($order as $data){
				if($i==0)
					$order_id =  "'".$data["order_id"]."'";
				else 
					$order_id .=  ","."'".$data["order_id"]."'";
				$i++;
			}
			
			if($order_id != ""){
				$order_detail	= "select od.order_id,d.deal_id,d.deal_name,v.vendor_id, v.vendor_name
		 											from tbl_deal_order_detail od 
		 											left join tbl_deal_main d on od.deal_id = d.deal_id 
		 											left join tbl_vendor_profile v on d.vendor_id = v.vendor_id
		 											where od.order_id in (".$order_id.")";
				$query_order_detail = $this->db->query($order_detail);
				$data['order_detail'] =  $query_order_detail->result_array();
			}
			
			$data['order'] =  $query_order->result_array();
			return $data;
	 }
	 
	 public function get_order_detail_by_product($product_id)
	{	
			$this->db->select('o.order_id,od.product_id,od.deal_id,o.mem_id');
			$this->db->from('tbl_deal_order_detail od');
			$this->db->join('tbl_deal_order o', 'o.order_id = od.order_id', 'inner');
			$this->db->where_in("od.product_id",$product_id);
			$this->db->order_by('od.order_id','DESC');
			$query = $this->db->get();
			
			return $query->result_array();
	}
	public function get_nOrder($cQuery)
	{
		$query = $this->db->query($cQuery);
		
		return $query->num_rows();
	}
	public function get_order_data($sQuery)
	{
		$sql	=	$sQuery;
			
		//echo $sql;
		
		$query_order = $this->db->query($sql);
		$order =  $query_order->result_array();
			
			$i = 0;
			$order_id = "";
			foreach($order as $data){
				if($i==0)
					$order_id =  "'".$data["order_id"]."'";
				else 
					$order_id .=  ","."'".$data["order_id"]."'";
				$i++;
			}
			
			if($order_id != ""){
				$order_detail	= "select od.order_id,d.deal_id,d.deal_name,v.vendor_id, v.vendor_name
		 											from tbl_deal_order_detail od 
		 											left join tbl_deal_main d on od.deal_id = d.deal_id 
		 											left join tbl_vendor_profile v on d.vendor_id = v.vendor_id
		 											where od.order_id in (".$order_id.")";
				$query_order_detail = $this->db->query($order_detail);
				$data['order_detail'] =  $query_order_detail->result_array();
			}
			
			$data['order'] =  $query_order->result_array();
			return $data;
	}
}
?>