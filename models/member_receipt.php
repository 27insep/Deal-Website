<?
class member_receipt extends CI_Model 
{	
    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }
	
    public function showreceipt($order_id)
    {
    		$data = array();
			
			$this->db->select('o.order_id,o.mem_id,o.order_date,p.member_name,p.member_sname,o.receipt_id,o.order_pay_date,
												 o.payment_type,p.member_address,p.city_name,pd.province_name,p.member_zipcode');
			$this->db->from('tbl_deal_order o');
			$this->db->join('tbl_member_profile p', 'o.mem_id = p.member_id', 'left');
			$this->db->join('tbl_province_data pd', 'p.province_id = pd.province_id', 'left');
			$where	=	array("o.order_id"=>$order_id);
			$this->db->where($where);
			$query = $this->db->get();
			
			$this->db->select('p.product_name,p.product_price,od.product_qty,p.product_total_price,d.deal_name');
			$this->db->from('tbl_deal_order_detail od');
			$this->db->join('tbl_deal_product p', 'od.product_id = p.product_id', 'inner');
			$this->db->join('tbl_deal_main d', 'od.deal_id = d.deal_id', 'left');
			$where	=	array("od.order_id"=>$order_id);
			$this->db->where($where);
			$query_detail = $this->db->get();
			
			$data['order']	=	$query->row_array();
			$data['order_detail']	=	$query_detail->result_array();
			return	$data;
	}
}
?>