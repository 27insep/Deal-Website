<?
class Coupon_history_main extends CI_Model 
{	
    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }
	
	public function DateDiff($strDate1,$strDate2)
	 {
				return (strtotime($strDate2) - strtotime($strDate1))/  ( 60 * 60 * 24 );  // 1 day = 60*60*24
	 }
	 
    public function coupon_history($order_id,$fill)
    {
    		$data = array();
    		$this->db->select("d.deal_index_image,d.deal_name,d.deal_id,o.order_date,
    											d.deal_expile,o.order_id");
			$this->db->from('tbl_deal_order o');
			$this->db->join('tbl_deal_order_detail od', 'o.order_id = od.order_id', 'inner');
			$this->db->join('tbl_deal_main d', 'od.deal_id = d.deal_id', 'left');
			
			if($fill == "0" || $fill == "")	
				$this->db->where('o.order_id  in ('.$order_id.') and o.order_status=2');
			else if($fill == "1")
				$this->db->where("o.order_id  in ('.$order_id.') and o.order_status='2' and d.deal_expile >='".date("Y-m-d",time())."'");
			else if($fill == "2")
				$this->db->where("o.order_id  in ('.$order_id.') and o.order_status='2' 
														and DATEDIFF(d.deal_expile,'".date("Y-m-d",time())."') <= 7
														and DATEDIFF(d.deal_expile,'".date("Y-m-d",time())."') > -1");
			else if($fill == "3")
				$this->db->where("o.order_id  in ('.$order_id.') and o.order_status='2' and d.deal_expile <'".date("Y-m-d",time())."'");

			$this->db->group_by('o.order_id,od.deal_id');
			$query = $this->db->get();
			
			$this->db->select("c.coupon_id,o.order_id,c.coupon_status,c.deal_id,c.mem_id,c.deal_id");
			$this->db->from('tbl_deal_order o');
			$this->db->join('tbl_coupon c', 'o.order_id = c.order_id', 'inner');
			$this->db->where('o.order_id  in('.$order_id.')');
			$this->db->order_by('c.coupon_id','ASC');
			$query_coupon = $this->db->get();
		    
			$result		=	$query->result_array();
			$total_row	=	sizeof($result);
			$data['total_rows'] = $total_row;
			$data['order']	=	$query->result_array();
			$data['coupon']	=	$query_coupon->result_array();
			
			return	$data;
	}
	
	 
	 
	public function coupon_updateStatus($coupon_id,$data)
	{
				$d_now = date("Y-m-d H:i:s");
				if($data == '2')
			 		$updata=array('coupon_status' => $data,'coupon_use_date' => $d_now);
				else 
					$updata=array('coupon_status' => $data,'coupon_use_date' => "");
					
				$this -> db -> where('coupon_id', $coupon_id);
				$this -> db -> update('tbl_coupon', $updata);
				unset($updata);
	}
	
	public function get_total_active_coupon($member_id)
    {
    		$this->db->select('order_id');
			$this->db->from('tbl_deal_order');
			$where	=	array("mem_id"=>$member_id,'order_status'=>'2');
			$this->db->where($where);
			$query = $this->db->get();
			
			$result		=	$query->result_array();
			$total_row	=	sizeof($result);
			unset($result);
			
			return $total_row;
    }
	
	public function get_active_coupon($member_id,$offset,$limit)
    {
    		$this->db->select('order_id');
			$this->db->from('tbl_deal_order');
			$where	=	array("mem_id"=>$member_id,'order_status'=>'2');
			$this->db->where($where);
			$this->db->limit($limit,$offset);
			$query = $this->db->get();
			
			$result		=	$query->result_array();
			return $result;
    }
}
?>