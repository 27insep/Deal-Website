<?
class Category_sub extends CI_Model 
{
    protected $table_name	=	 "tbl_category_sub";
	
    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }
	public function get_category_sub_by_category_id($cat_id="")
	{
		$this->db->select('sub_cat_id,cat_id,sub_cat_name,sub_cat_status');
		if(!empty($cat_id))
		{
			$query = $this->db->get_where($this->table_name, array('cat_id' => $cat_id));
		}else{
			$query = $this->db->get($this->table_name);
		}
		
		return $query->result_array();
	}
	public function get_all_category_sub()
	{
		$this->db->select('sub_cat_id,cat_id,sub_cat_name,sub_cat_status');
		$query = $this->db->get_where($this->table_name);
				
		$data	=	array();
		foreach($query->result_array() as $sub_cat)
		{
			$index	=	$sub_cat["sub_cat_id"];
			$data[$index]	=	$sub_cat;
		}
		return $data;
	}
	public function get_sub_category_data($sub_cat_id)
	{
		$this->db->select('cat_id,sub_cat_id, sub_cat_name');
		$query = $this->db->get_where($this->table_name, array('sub_cat_id' => $sub_cat_id));
		
		return $query->row_array();
	}
	public function get_category_sub()
	{
			$this->db->select('s.sub_cat_id,s.cat_id,s.sub_cat_name,s.sub_cat_status,m.cat_name');
			$this->db->from('tbl_category_sub s');
			$this->db->join('tbl_category_main m', 's.cat_id = m.cat_id', 'left');
			$query = $this->db->get();
				
		$data	=	array();
		foreach($query->result_array() as $sub_cat)
		{
			$index	=	$sub_cat["sub_cat_id"];
			$data[$index]	=	$sub_cat;
		}
		return $data;
	}
}
?>