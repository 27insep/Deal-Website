<?
class Deal_gallery extends CI_Model 
{
    protected $table_name	=	"tbl_deal_gallery";
	protected $col_set			=	"pic_id,deal_id,pic_path,pic_order";
	
    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }
    public function get_gallery_by_deal_id($deal_id)
    {
    	$this->db->select($this->col_set);
		$where		=	array("deal_id"=>$deal_id);
    	$query 		= $this->db->get_where($this->table_name,$where);
		
		return $query->result_array();
    }
}
?>