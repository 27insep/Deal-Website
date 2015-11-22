<?
class member_order extends CI_Model 
{
	protected $table_name	=	 "tbl_deal_order";
		
    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }
	
    public function showorder($order_id)
    {
			$this->db->select('o.order_id,o.mem_id,o.order_summary,o.order_status,o.order_date,o.order_modify,p.product_id,p.product_name,d.deal_name');
			$this->db->from('tbl_deal_order o');
			$this->db->join('tbl_deal_order_detail pd', 'o.order_id = pd.order_id', 'left');
			$this->db->join('tbl_deal_product p', 'p.product_id = pd.product_id', 'left');
			$this->db->join('tbl_deal_main d', 'd.deal_id = pd.deal_id', 'left');
			$this->db->where('o.order_id  in('.$order_id.')');
			$this->db->order_by('o.order_id','DESC');
			$query = $this->db->get();
			
			return $query->result_array();
	}
	public function get_waitting_payment($member_id)
	{
		$this->db->select('order_id');
		
		$where	=	array(	"mem_id"=>$member_id,
									 "order_status"=>1
								);
		$query = $this->db->get_where($this->table_name, $where);
		
		$data	=	array();
		$data	=	$query->result_array();
		
		$nRow	=	sizeof($data);
		unset($data);
		
		return $nRow;
	}
	
	public function get_total_active_order($member_id,$fill_status)
    {
    		$this->db->select('order_id');
			$this->db->from('tbl_deal_order');
			
			if($fill_status == "")
				$where	=	array("mem_id"=>$member_id);
			else 
				$where	=	array("mem_id"=>$member_id,"order_status"=>$fill_status);
			
			$this->db->where($where);
			$query = $this->db->get();
			
			$result		=	$query->result_array();
			$total_row	=	sizeof($result);
			unset($result);
			
			return $total_row;
    }
	
	public function get_active_order($member_id,$offset,$limit,$fill_status)
    {
    		$this->db->select('order_id');
			$this->db->from('tbl_deal_order');
			
			if($fill_status == "")
				$where	=	array("mem_id"=>$member_id);
			else 
				$where	=	array("mem_id"=>$member_id,"order_status"=>$fill_status);
			
			$this->db->where($where);
			$this->db->limit($limit,$offset);
			$query = $this->db->get();
			
			$result		=	$query->result_array();
			return $result;
    }

	public function status_cancel($order_id,$upStatus)
	{
		$data	=	array(
							"order_status"=>$upStatus,
							"order_modify"=>date("Y-m-d H:i:s",time())
						);
		$this->db->where('order_id', $order_id);
		$this->db->update($this->table_name, $data);
	}
}
?>