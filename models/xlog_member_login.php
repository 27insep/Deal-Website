<?php
class xlog_member_login extends CI_Model 
{
    protected $table_name	=	 "xlog_member_login_";
	
    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
		$this->table_name .= date("Y_m",time());
		
		if (!$this->db->table_exists($this->table_name))
		{
			$sql	=	"	CREATE TABLE `xlog_member_login_".date("Y_m",time())."` (
  							`log_id` int(11) NOT NULL auto_increment,
  							`member_id` int(11) NOT NULL,
  							`member_ip` varchar(16) NOT NULL,
  							`action_type` int(1) NOT NULL COMMENT '1 login,2 logout',
  							`log_time` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  							PRIMARY KEY  (`log_id`),
  							KEY `member_id` (`member_id`),
  							KEY `member_ip` (`member_ip`)
							) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;";
			$this->db->query($sql);
		}
    }

	public function save_log($member_id,$log_type)
	{
		$login_time	=	date('Y-m-d H:i:s',time());
		$data = array(
   			'member_id' => $member_id ,
   			'member_ip' => $this->input->ip_address(),
   			'action_type' => $log_type,
   			'log_time'	=> $login_time	
		);

		$this->db->insert($this->table_name, $data); 		
		
		$data	=	array('member_last_login'=>$login_time);
		
		$this->db->where('member_id', $member_id);
		$this->db->update("tbl_member_profile", $data);
	}
}
?>