<?
class Member_profile extends CI_Model 
{
    protected $table_name	=	 "tbl_member_profile";
	
    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }
	public function get_member_profile_by_login($email,$password)
	{
			$this->db->select('member_id,member_last_login');
			$query = $this->db->get_where($this->table_name, array('member_email' =>$email,'member_pwd'=>$password));
			
			return $query->row_array();
	}
	public function get_member_profile_by_email($email)
	{
			$this->db->select('member_id,member_last_login,member_pwd,member_name,member_sname');
			$query = $this->db->get_where($this->table_name, array('member_email' =>$email));
			
			return $query->row_array();
	}

	public function get_member_profile_by_id($member_id)
	{
		$this->db->select(	array('member_id',
									'member_name',
									'member_email',
									'member_sname',
									'member_gendar',
									'member_birth_date',
									'member_ssn',
									'member_mobile',
									'member_address',
									'city_name',
									'province_id',
									'member_zipcode',
									'member_update_time',
									'subscript_email')
								);
		$query = $this->db->get_where($this->table_name, array('member_id' =>$member_id));
			
		return $query->row_array();
	}
	public function get_member_news_letter()
	{
		$sql	=	"SELECT member_id,
									member_name,
									member_email,
									member_sname,
									member_gendar,
									member_birth_date,
									member_ssn,
									member_mobile,
									member_address,
									city_name,
									province_id,
									member_zipcode,
									member_update_time,
									subscript_email
						FROM ".$this->table_name." WHERE";
		$today	=	date("w",time());	
		$sql 		.= " subscript_email='1' AND MOD(member_id, 10) = '".$today."'";
		
		if($today==5)		
		$sql .= " OR MOD(member_id, 10) = '7'";
		
		if($today==6)		
		$sql .= " OR MOD(member_id, 10) = '8'";
		
		if($today==0)		
		$sql .= " OR MOD(member_id, 10) = '9'";
		
		//echo $sql;
		$query = $this->db->query($sql);
		
		return $query->result_array();
	}
	public function check_profile($member_id)
	{
		$this->db->select(	array('member_id',
									'member_name',
									'member_sname',
									'member_gendar',
									'member_birth_date',
									'member_ssn',
									'member_mobile',
									'member_address',
									'city_name',
									'province_id',
									'member_zipcode',
									'member_update_time',
									'subscript_email')
								);
		$query = $this->db->get_where($this->table_name, array('member_id' =>$member_id));
			
		$member_data	= 	$query->row_array();
		
		if(empty($member_data["member_name"]))		return false;
		if(empty($member_data["member_sname"]))		return false;
		if(empty($member_data["member_gendar"]))		return false;
		if(empty($member_data["member_birth_date"]))	return false;
		if(empty($member_data["member_mobile"]))		return false;
		if(empty($member_data["member_address"]))		return false;
		if(empty($member_data["city_name"]))				return false;
		if(empty($member_data["province_id"]))				return false;
		if(empty($member_data["member_zipcode"]))		return false;
		
		return true;
	}
	public function add_user($email,$password,$subscript,$ref_id="",$know_from="",$member_name,$member_sname,$member_mobile)
	{
		$th_year		=	(int)(date("Y",time()))+543;
		$th_year		= substr($th_year,-2);
		
		$this->db->like('member_id', $th_year, 'after'); 
		$this->db->from($this->table_name);
		$this->db->order_by("member_id", "DESC");
		
		$query = $this->db->get();
			
		$data		=	$query->row_array();
		$nRow		=	(int)substr($data["member_id"], 2)+1;
		
		$fill_zero	=	6-strlen($nRow);
		
		for($i=0;$i<$fill_zero;$i++)
		{
			$nRow	=	"0".$nRow;
		}
		
		$member_id	=	$th_year.$nRow;
		
		$data	=	array(
			"member_id"=>$member_id,
			"member_email"=>$email,
			"member_pwd"=>base64_encode($password),
			"subscript_email"=>$subscript,
			"know_from"=>$know_from,
			"member_regis_time"=>date("Y-m-d H:i:s",time()),
			"member_update_time"=>date("Y-m-d H:i:s",time()),
			"member_name"=>$member_name,
			"member_sname"=>$member_sname,
			"member_mobile"=>$member_mobile
		);
		
		$this -> db -> insert( $this->table_name, $data);
	}
	public function has_email($email)
	{
		$this->db->select('member_id');
		$query = $this->db->get_where($this->table_name, array('member_email' =>$email));
		
		if($query->num_rows()>0)
		{
			return true;
		}else{
			return false;
		}
	}
	
	public function update_changepwd($member_id,$password)
	{
		$data	=	array(
							"member_pwd"=>$password,
							"member_update_time"=>date("Y-m-d H:i:s",time())
						);
		$this->db->where('member_id', $member_id);
		$this->db->update($this->table_name, $data);
	}

	public function check_password($member_id,$pwd_old)
	{
		$this->db->select(array('member_pwd'));
		$query = $this->db->get_where($this->table_name, array('member_id' =>$member_id));
			
		$member_data	= 	$query->row_array();
		
		if($member_data["member_pwd"] != $pwd_old)		return false;
	
		return true;
	}
	public function unsubscript($email)
	{
		$data	=	array(
							"subscript_email"=>0
						);
		$this->db->where('member_email', $email);
		$this->db->update($this->table_name, $data);
		
		return true;
	}
	public function update_profile($member_id,$member_name,$member_sname,$member_gendar,$member_birth_date,$member_ssn,$member_mobile,$subscript,$member_address,$city_name,$province_id,$member_zipcode)
	{
		$b_day	=	array();
		$b_day	=	explode("/",$member_birth_date);
		$member_birth_date	=	$b_day[2]."-".$b_day[1]."-".$b_day[0];
		
		$data	=	array(
							"member_name"=>$member_name,
							"member_sname"=>$member_sname,
							"member_gendar"=>$member_gendar,
							"member_birth_date"=>$member_birth_date,
							"member_ssn"=>$member_ssn,
							"member_mobile"=>$member_mobile,
							"member_address"=>$member_address,
							"city_name"=>$city_name,
							"province_id"=>$province_id,
							"member_zipcode"=>$member_zipcode,
							"member_update_time"=>date("Y-m-d H:i:s",time()),
							"subscript_email"=>$subscript
						);
		$this->db->where('member_id', $member_id);
		$this->db->update($this->table_name, $data);
	}
	public function activate_user($member_id)
	{
				$data	=	array(
									"member_status"=>1,
								);
		$this->db->where('member_id', $member_id);
		$this->db->update($this->table_name, $data);
	
	}
	public function get_all_member_profile()
	{
		$this->db->select(array('member_id',
									'member_name',
									'member_email',
									'member_sname',
									'member_gendar',
									'member_birth_date',
									'member_ssn',
									'member_mobile',
									'member_address',
									'city_name',
									'province_id',
									'member_zipcode',
									'member_regis_time',
									'member_update_time',
									'subscript_email'));
		$query = $this->db->get($this->table_name);
		
		$data	=	array();
		foreach($query->result_array() as $shop)
		{
			$index	=	$shop["member_id"];
			$data[$index]	=	$shop;
		}
		return $data;
	}
	public function get_nMember($cQuery)
	{
		$query = $this->db->query($cQuery);
		return $query->num_rows();
	}
	public function get_member_data($sQuery)
	{
		$sql	=	$sQuery;
		//echo $sql;
		$query = $this->db->query($sql);
		
		$data	=	array();
		$data	=	$query->result_array();
		return $data;
	}
	public function get_all_member_profile_view()
	{
		$sql	=	"SELECT 
						mp.member_id, 
						mp.member_name, 
						mp.member_email, 
						mp.member_sname, 
						mp.member_gendar, 
						mp.member_birth_date, 
						mp.member_ssn, 
						mp.member_mobile, 
						mp.member_address, 
						mp.city_name, 
						mp.member_zipcode, 
						mp.member_regis_time, 
						mp.member_update_time, 
						mp.subscript_email, 
						count( DISTINCT md.order_id ) AS nOrder, 
						count( DISTINCT mc.coupon_id ) AS nCoupon
					FROM tbl_member_profile AS mp
					LEFT JOIN tbl_deal_order AS md ON mp.member_id = md.mem_id
					LEFT JOIN tbl_coupon AS mc ON mp.member_id = mc.mem_id
					GROUP BY mp.member_id";
					
		$query = $this->db->query($sql);
		
		$data	=	array();
		foreach($query->result_array() as $shop)
		{
			$index	=	$shop["member_id"];
			$data[$index]	=	$shop;
		}
		return $data;
	}
}
?>