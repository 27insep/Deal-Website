<?
class Free_ads extends CI_Model 
{
    protected $table_name	=	"tbl_free_ads";
	protected $col_set			=	"	free_ads_id
												,vendor_name
												,contact_name
												,website
												,contact_email
												,contact_phone
												,contact_time
												,contact_status
												,ip
												";
    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }
	public function add_free_ads($data)
	{
			$this -> db -> insert( $this->table_name, $data);
			unset($data);
	}
	
	public function get_free_ads()
	{
			$this->db->select($this->col_set);
			$this->db->from($this->table_name);
			$this->db->order_by("contact_time","DESC");
			$query = $this->db->get();
			
			return $query->result_array();
	}
}
?>