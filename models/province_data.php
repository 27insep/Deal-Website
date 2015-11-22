<?
class Province_data extends CI_Model 
{
    protected $table_name	=	 "tbl_province_data";
	
    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }
	public function get_provicne_by_id($province_id)
	{
		$this->db->select(	array('province_id','province_name'));
		$query = $this->db->get_where($this->table_name, array('province_id' =>$province_id,'province_status'=>1));
			
		return $query->row_array();
	}
	public function get_all_province()
	{
		$this->db->select(	array('province_id','province_name'));
		$this->db->order_by("province_name","ASC");
		
		$query = $this->db->get_where($this->table_name, array('province_status'=>1));
			
		return $query->result_array();
	}
}
?>