<?php
class xlog_vendor_login extends CI_Model 
{
    protected $table_name	=	 "xlog_vendor_login_";
	
    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
		$this->table_name .= date("Y_m",time());
		
		if (!$this->db->table_exists($this->table_name))
		{
			$sql	=	"	CREATE TABLE `xlog_vendor_login_".date("Y_m",time())."` (
  							`log_id` int(11) NOT NULL auto_increment,
  							`vendor_id` int(11) NOT NULL,
  							`vendor_ip` varchar(16) NOT NULL,
  							`action_type` int(1) NOT NULL COMMENT '1 login,2 logout',
  							`log_time` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  							PRIMARY KEY  (`log_id`),
  							KEY `vendor_id` (`vendor_id`),
  							KEY `vendor_ip` (`vendor_ip`)
							) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;";
			$this->db->query($sql);
		}
    }

	public function save_log($member_id,$log_type)
	{
		$data = array(
   			'vendor_id' => $member_id ,
   			'vendor_ip' => $this->input->ip_address(),
   			'action_type' => $log_type
		);

		$this->db->insert($this->table_name, $data); 		
	}
}
?>