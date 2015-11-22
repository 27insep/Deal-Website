<?
class admin_profile extends CI_Model 
{
    protected $table_name	=	 "tbl_admin";
	protected $col_set			=		array(	'admin_id',
															'admin_user',
															'admn_pwd',
															'admin_name',
															'admin_status',
															'admin_type',
															'admin_create',
															'admin_modify');
    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }
	public function get_admin_by_login($admin_user,$admin_pwd)
	{
			$this->db->select('admin_id,admin_type');
			$query = $this->db->get_where($this->table_name, array('admin_user' =>$admin_user,'admn_pwd'=>$admin_pwd,'admin_status'=>'1'));
			
			return $query->row_array();
	}
	
	public function get_admin_by_id($admin_id)
	{
			$this->db->select('admin_user,admn_pwd');
			$query = $this->db->get_where($this->table_name, array('admin_id' =>$admin_id,'admin_status'=>'1'));
			
			return $query->row_array();
	}
}
?>