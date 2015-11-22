<?php
class xlog_admin extends CI_Model 
{
    protected $table_name	=	 "xlog_admin";
	
    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
		/*
		$this->table_name .= date("Y_m",time());
		
		if (!$this->db->table_exists($this->table_name))
		{
			$sql	=	"	CREATE TABLE `xlog_admin_".date("Y_m",time())."` (
  							`log_id` int(11) NOT NULL auto_increment,
  							`admin_id` int(11) NOT NULL,
  							`admin_ip` varchar(16) NOT NULL,
  							`action_type` int(1) NOT NULL COMMENT '1 login,2 logout',
  							`log_time` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  							PRIMARY KEY  (`log_id`),
  							KEY `admin_id` (`admin_id`),
  							KEY `admin_ip` (`admin_ip`)
							) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;";
			$this->db->query($sql);
		}*/
    }

	public function save_log($admin_id,$log_type,$comment="")
	{
		$data = array(
   			'admin_id' => $admin_id ,
   			'admin_ip' => $this->input->ip_address(),
   			'action_type' => $log_type,
   			'action_comment' => $comment
		);

		$this->db->insert($this->table_name, $data); 		
	}
}
?>