<?
class category_main extends CI_Model 
{
    protected $table_name	=	 "tbl_category_main";
	
    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }
	
    public function get_active_category($offset=0,$limit=10)
    {
    	$this->db->select('cat_id, cat_name,cat_icon');
		$this->db->order_by('cat_id','ASC');
		
    	$query = $this->db->get_where($this->table_name, array('cat_status' => 1), $limit, $offset);
		
		return $query->result_array();
    }
	public function get_all_category()
    {
    	$this->db->select('cat_id, cat_name,cat_icon');
		$this->db->order_by('cat_id','ASC');
    	$query = $this->db->get_where($this->table_name);
		
		$data	=	array();
		foreach($query->result_array() as $cat)
		{
			$index	=	$cat["cat_id"];
			$data[$index]	=	$cat;
		}
		return $data;
    }
	public function get_category_data($cat_id)
	{
		$this->db->select('cat_id, cat_name,cat_icon');
		$query = $this->db->get_where($this->table_name, array('cat_id' => $cat_id));
		
		return $query->row_array();
	}
}
?>