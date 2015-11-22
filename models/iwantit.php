<?
class Iwantit extends CI_Model 
{
    protected $table_name	=	 "tbl_iwantit";
	
    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }
	public function add_iwantit($email,$deal_id)
	{
			$data	=	array(
				"deal_id"=>$deal_id,
				"email"=>$email,
				"iwantit_status"=>'0',
				"iwantit_create"=>date("Y-m-d H:i:s",time())
			);
			
			$this -> db -> insert( $this->table_name, $data);
			unset($data);
	}
	
	public function get_iwantit_all()
	{
			$this->db->select('w.iwantit_id,d.deal_id,d.deal_name,w.email,w.iwantit_create,w.sendemail_date,w.iwantit_status');
			$this->db->from('tbl_iwantit w');
			$this->db->join('tbl_deal_main d', 'w.deal_id = d.deal_id', 'inner');
			$this->db->order_by('w.iwantit_id','ASC');
			$query = $this->db->get();
		
		return $query->result_array();
	}
	
		public function get_iwantit_deal($deal_id)
	{
			$this->db->select('w.iwantit_id,d.deal_id,d.deal_name,w.email,w.iwantit_create,w.sendemail_date,w.iwantit_status,m.member_name,m.member_sname,d.deal_index_image');
			$this->db->from('tbl_iwantit w');
			$this->db->join('tbl_deal_main d', 'w.deal_id = d.deal_id', 'inner');
			$this->db->join('tbl_member_profile m', 'w.email = m.member_email', 'left');
			$this->db->where('w.deal_id', $deal_id);
			$this->db->order_by('w.iwantit_id','ASC');
			$query = $this->db->get();
		
		return $query->result_array();
	}
}
?>