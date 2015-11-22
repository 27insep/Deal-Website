<?
class Deal_order extends CI_Model 
{
    protected $table_name	=	 "tbl_deal_order";
	
    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }
	public function get_order_by_id($order_id)
	{
			$this->db->select('order_id,mem_id,ref_code,order_summary,order_status,order_date,order_modify,payment_type,receipt_id');
		
			$where	=	array("order_id"=>$order_id);
			$query = $this->db->get_where($this->table_name, $where);
		
			return $query->row_array();
	}

	public function add_order($member_id,$product_set,$price_summary,$order_id,$pay_type,$special="")
	{
		if(empty($pay_type))
		{
			$pay_type	=	2;
			
			$log_data	=	array(
					"log_code"=>"1004",
					"log_detail"=>$agent." : member = ".$member_id."/ product = ".$log_detail."/ ip ".$this->input->ip_address(),
					"log_time"=>date("Y-m-d H:i:s")
			);
		}
		
		$this->load->library('user_agent');
		$agent	=	"";
				
		if ($this->agent->is_browser())
		{
   	 		$agent = $this->agent->browser().' '.$this->agent->version();
		}
		elseif ($this->agent->is_robot())
		{
    		$agent = $this->agent->robot();
		}
		elseif ($this->agent->is_mobile())
		{
    		$agent = $this->agent->mobile();
		}
		else
		{
   			 $agent = 'Unidentified User Agent';
		}
				
		if(empty($member_id))
		{
				$log_data	=	array(
					"log_code"=>"1003",
					"log_detail"=>$agent." : member = ".$member_id."/ product = ".$log_detail."/ ip ".$this->input->ip_address(),
					"log_time"=>date("Y-m-d H:i:s")
				);
				
				$this -> db -> insert("error_log", $log_data);
				return 0; 
				exit;
		}
		
		$set_product	=	array();
		
		foreach($product_set as $index=>$data)
		{
			$set_product[]	=	$index;	
		}
		
		$this->db->select('product_id,product_price,product_total_price,product_include_vat,vendor_id');
		$this->db->from('view_deal');
		$this->db->where_in('product_id',$set_product);
		$query = $this->db->get();
		
		$price_set		=	$query->result_array();
		
		$price_data	=	array();
		$log_detail		=	"";
		
		foreach($price_set as $data)
		{
			$index	=	$data["product_id"];
			$price_data[$index]["price"]			=	$data["product_total_price"];
			$price_data[$index]["vat"]				=	$data["product_include_vat"];
			$price_data[$index]["vendor_id"]		=	$data["vendor_id"];
			
			$log_detail	.=	$index.",";
		}
		
		unset($set_product);
		
		if($price_summary != 0){
			$data	=	array(
			"order_id"=>$order_id,
			"mem_id"=>$member_id,
			"order_summary"=>$price_summary,
			"order_status"=>'1',
			"order_date"=>date("Y-m-d H:i:s",time()),
			"payment_type"=>$pay_type
		);
		}else{
			if($special==1)
			{
				$receive_id = $this->get_pre_receive_id();
				$data	=	array(
					"order_id"=>$order_id,
					"mem_id"=>$member_id,
					"order_summary"=>$price_summary,
					"order_status"=>'2',
					"order_date"=>date("Y-m-d H:i:s",time()),
					"order_pay_date"=>date("Y-m-d H:i:s",time()),
					"payment_type"=>$pay_type,
					"receipt_id"=>$receive_id
				);
			}else{
				$log_data	=	array(
					"log_code"=>"1001",
					"log_detail"=>$agent." : member = ".$member_id."/ product = ".$log_detail."/ ip ".$this->input->ip_address(),
					"log_time"=>date("Y-m-d H:i:s")
				);
				$this -> db -> insert("error_log", $log_data);
			}
		}
		
		
		$this -> db -> insert($this->table_name, $data);
		
		foreach($product_set as $product_id=>$product)
		{
			$total_amount	=	$price_data[$product_id]["price"]*$product["qty"];
			$vat					=	0;
			
			if($price_data[$product_id]["vat"]>0)
			$vat					=	$total_amount*($price_data[$product_id]["vat"]/100);
			
			$total_vat			=	$total_amount+$vat;
			
			$this->db->select('deal_id,product_total_price');
			$this->db->from('tbl_deal_product');
			$this->db->where('product_id',$product_id);
			$query 			= $this->db->get();
			$get_product_data		=	$query->row_array();
			
			$this->db->select('round_id');
			$this->db->from('tbl_deal_round');
			$this->db->where('deal_id',$get_product_data["deal_id"]);
			$this->db->order_by("round_id","DESC");
			$query 			= $this->db->get();
			$round_data	=	$query->row_array();
			
			$data	=	array(
				"order_id"=>$order_id,
				"product_qty"=>$product["qty"],
				"sell_price"=>$get_product_data["product_total_price"],
				"product_id"=>$product_id,
				"deal_id"=>$get_product_data["deal_id"],
				"round_id"=>$round_data["round_id"],
				"total_summary"=>$total_amount,
				"vat"=>$vat,
				"total_vat"=>$total_vat,
				"vendor_id"=>$price_data[$product_id]["vendor_id"]
			);
		
			$this -> db -> insert("tbl_deal_order_detail", $data);
		}
	}
	public function get_pre_oreder_id($member_id)
	{
		$th_year		=	(int)(date("Y",time()))+543;
		$prefix			= substr($th_year,-2).date("m",time());
		
		$this->db->like('order_id', $prefix, 'after'); 
		$this->db->from($this->table_name);
		$this->db->order_by("order_id", "desc"); 
		$query	=	$this->db->get();
		$data	=	$query->row_array();
		
		if(sizeof($data)>0)
		{
			$nRow	=	((int)substr($data["order_id"],-6))+1;
		}else{
			$nRow	=	1;
		}
		
		$fill_zero	=	6-strlen($nRow);
		for($i=0;$i<$fill_zero;$i++)
		{
			$nRow	=	"0".$nRow;
		}
		
		$order_id	=	$prefix.$nRow;
		return $order_id;
	}
	
	public function get_pre_receive_id()
	{
		$th_year		=	(int)(date("Y",time()))+543;
		$prefix			= substr($th_year,-2).date("m",time());
		
		$this->db->like('receipt_id', $prefix, 'after'); 
		$this->db->from($this->table_name);
		$this->db->order_by("receipt_id", "desc"); 
		$query	=	$this->db->get();
		$data	=	$query->row_array();
		
		if(sizeof($data)>0)
		{
			$nRow	=	((int)substr($data["receipt_id"],-6))+1;
		}else{
			$nRow	=	1;
		}
		
		$fill_zero	=	6-strlen($nRow);
		for($i=0;$i<$fill_zero;$i++)
		{
			$nRow	=	"0".$nRow;
		}
		
		$receive_id	=	$prefix.$nRow;
		return $receive_id;
	}
}
?>