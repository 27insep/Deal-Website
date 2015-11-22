<?php
	define('FPDF_FONTPATH','fonts/');
	include_once($_SERVER["DOCUMENT_ROOT"] .'/main/libraries/code128.php');
if(!defined('BASEPATH'))exit('No direct script access allowed');
class Mybackoffice extends CI_Controller {
	protected $layout = 'template/admin_template.php';
	protected $stylesheets = array(
		'validate.css',
		'jquery.dataTables.css',
		'TableTools.css',
		'TableTools_JUI.css',
		'blitzer/jquery-ui.css',
    	'member.css',
    	'fancybox/jquery.fancybox.css?v=2.1.4',
    	'fancybox/helpers/jquery.fancybox-buttons.css?v=1.0.5',
    	'fancybox/helpers/jquery.fancybox-thumbs.css?v=1.0.7',
    	'admin.css'
	);
	protected $javascripts = array(
		'jquery.js',
		'tiny_mce/tiny_mce.js',
		'jquery.validate.js',
		'jquery.dataTables.min.js',
		'ZeroClipboard.js',
		'TableTools.min.js',
  		'jquery.form.js',
		'jquery-ui.min.js',
		'jquery.mousewheel-3.0.6.pack.js',
		'fancybox/jquery.fancybox.js?v=2.1.4',
		'fancybox/helpers/jquery.fancybox-buttons.js?v=1.0.5',
		'fancybox/helpers/jquery.fancybox-thumbs.js?v=1.0.7',
		'fancybox/helpers/jquery.fancybox-media.js?v=1.0.5'
	);
	protected 	$page_data = array();
	protected	$admin_id;
	protected	$admin_type;
	protected 	$admin_log_code	=	array();
	
	public function __construct() 
	{
		parent::__construct();
		// Your own constructor code
		//config page rend
		
		$params = array('layout' => $this -> layout, 'stylesheets' => $this -> stylesheets, 'javascripts' => $this -> javascripts);
		$this->load->library('render', $params);
		$this->load->library('convert_date');
		$this->load->library('session');
		$this->load->library('image_lib');
		
		$this->load->database();
		$this->load->helper(array('form', 'url'));
		$this->load->model('admin_profile');
		$this->load->model('coupon_main');
		$this->load->model('vendor_profile');
		$this->load->model('member_orderdetail');
		$this->load->model("xlog_admin");
		$this->load->model("iwantit");
		
		$this->admin_id 	=	$this->session->userdata('admin_id');
		$this->admin_type =	$this->session->userdata('admin_type');
		
		$this -> page_data["page_menu"] = $this -> get_admin_menu();
		
		$this ->admin_log_code["1001"]	=	"เข้าสู่ระบบ";
		$this ->admin_log_code["1002"]	=	"ออกจากระบบ";
		$this ->admin_log_code["2001"]	=	"เพิ่มข้อมูลสมาชิก";
		$this ->admin_log_code["2002"]	=	"แก้ไขข้อมูลสมาชิก";
		$this ->admin_log_code["2003"]	=	"ลบข้อมูลสมาชิก";
		$this ->admin_log_code["2011"]	=	"เพิ่มข้อมูลร้านค้า";
		$this ->admin_log_code["2012"]	=	"แก้ไขข้อมูลร้านค้า";
		$this ->admin_log_code["2013"]	=	"ลบข้อมูลร้านค้า";
		$this ->admin_log_code["2021"]	=	"เพิ่มข้อมูลดีล";
		$this ->admin_log_code["2022"]	=	"แก้ไขข้อมูลดีล";	
		$this ->admin_log_code["2023"]	=	"ลบข้อมูลดีล";	
		$this ->admin_log_code["2031"]	=	"เพิ่มข้อมูลแคมเปญ";
		$this ->admin_log_code["2032"]	=	"แก้ไขข้อมูลแคมเปญ";	
		$this ->admin_log_code["2033"]	=	"ลบข้อมูลแคมเปญ";	
		$this ->admin_log_code["2041"]	=	"เพิ่มข้อมูลการสั่งซื้อ";
		$this ->admin_log_code["2042"]	=	"แก้ไขข้อมูลการสั่งซื้อ";	
		$this ->admin_log_code["2043"]	=	"ลบข้อมูลการสั่งซื้อ";
		$this ->admin_log_code["2044"]	=	"เปลี่ยนสถานะการสั่งซื้อเป็นชำระเงิน";
		$this ->admin_log_code["2045"]	=	"เปลี่ยนสถานะการสั่งซื้อเป็นยกเลิก";
		$this ->admin_log_code["2046"]	=	"เปลี่ยนสถานะการสั่งซื้อเป็นคืนเงิน";	
		$this ->admin_log_code["2051"]	=	"เปลี่ยนสถานะคูปองเป็น USE";
		$this ->admin_log_code["2052"]	=	"เปลี่ยนสถานะคูปองเป็น NOT USE";	
		$this ->admin_log_code["2053"]	=	"สั่งพิมพ์คูปอง";	
		$this ->admin_log_code["2061"]	=	"เพิ่มข้อมูลจังหวัด";
		$this ->admin_log_code["2062"]	=	"แก้ไขข้อมูลจังหวัด";	
		$this ->admin_log_code["2063"]	=	"ลบข้อมูลจังหวัด";	
		$this ->admin_log_code["2071"]	=	"เพิ่มข้อมูลหมวดหมู่หลัก";
		$this ->admin_log_code["2072"]	=	"แก้ไขข้อมูลหมวดหมู่หลัก";	
		$this ->admin_log_code["2073"]	=	"ลบข้อมูลหมวดหมู่หลัก";	
		$this ->admin_log_code["2081"]	=	"เพิ่มข้อมูลหมวดหมู่ย่อย";
		$this ->admin_log_code["2082"]	=	"แก้ไขข้อมูลหมวดหมู่ย่อย";	
		$this ->admin_log_code["2083"]	=	"ลบข้อมูลหมวดหมู่ย่อย";	
		$this ->admin_log_code["2091"]	=	"เพิ่มข้อมูลสไลด์โปรโมชั่น";
		$this ->admin_log_code["2092"]	=	"แก้ไขข้อมูลสไลด์โปรโมชั่น";	
		$this ->admin_log_code["2093"]	=	"ลบข้อมูลสไลด์โปรโมชั่น";
		$this ->admin_log_code["2101"]	=	"เพิ่มข้อมูลผู้ที่ต้องการดีล";
		$this ->admin_log_code["2102"]	=	"แก้ไขข้อมูลผู้ที่ต้องการดีล";	
		$this ->admin_log_code["2103"]	=	"ลบข้อมูลผู้ที่ต้องการดีล";
		$this ->admin_log_code["2111"]	=	"เพิ่มข้อมูลพนักงานขาย";
		$this ->admin_log_code["2112"]	=	"แก้ไขข้อมูลพนักงานขาย";	
		$this ->admin_log_code["2113"]	=	"ลบข้อมูลพนักงานขาย";
		$this ->admin_log_code["2121"]	=	"เพิ่มข้อมูลแกลลอรี่";
		$this ->admin_log_code["2122"]	=	"แก้ไขข้อมูลแกลลอรี่";	
		$this ->admin_log_code["2123"]	=	"ลบข้อมูลแกลลอรี่";
		$this ->admin_log_code["2131"]	=	"เพิ่มข้อมูลสไลด์ดีล";
		$this ->admin_log_code["2132"]	=	"แก้ไขข้อมูลสไลด์ดีล";	
		$this ->admin_log_code["2133"]	=	"ลบข้อมูลสไลด์ดีล";
		$this ->admin_log_code["2141"]	=	"เพิ่มข้อมูลลงโฆษณา";
		$this ->admin_log_code["2142"]	=	"แก้ไขข้อมูลลงโฆษณา";	
		$this ->admin_log_code["2143"]	=	"ลบข้อมูลลงโฆษณา";
		
	}

	protected function get_admin_menu() 
	{
		$menu = array();
		$menu[0]["name"] = "ข้อมูลสมาชิก";
		$menu[0]["link"] = "/mybackoffice/member_profile";
		
		$menu[1]["name"] = "ข้อมูลร้านค้า";
		$menu[1]["link"] = "/mybackoffice/vendor_profile";
		
		$menu[2]["name"] = "ข้อมูลดีล";
		$menu[2]["link"] = "/mybackoffice/deal_main";

		$menu[3]["name"] = "ข้อมูลแคมเปญ";
		$menu[3]["link"] = "/mybackoffice/deal_product";

		$menu[4]["name"] = "ข้อมูลการสั่งซื้อ";
		$menu[4]["link"] = "/mybackoffice/deal_order";
	
		$menu[5]["name"] = "ข้อมูลคูปอง";
		$menu[5]["link"] = "/mybackoffice/coupon_manage";
		
		$menu[6]["name"] = "ข้อมูลจังหวัด";
		$menu[6]["link"] = "/mybackoffice/province";
	
		$menu[7]["name"] = "ข้อมูลหมวดหมู่หลัก";
		$menu[7]["link"] = "/mybackoffice/category";
		
		$menu[8]["name"] = "ข้อมูลหมวดหมู่ย่อย";
		$menu[8]["link"] = "/mybackoffice/category_sub";
		
		$menu[9]["name"] = "สไลด์โปรโมชั่น";
		$menu[9]["link"] = "/mybackoffice/home_slide";
		
		$menu[10]["name"] = "ผู้ที่ต้องการดีล";
		$menu[10]["link"] = "/mybackoffice/iwantit";
		
		if(isset($this->admin_type)&&$this->admin_type==1)
		{
			$menu[11]["name"] 	= "พนักงานขาย";
			$menu[11]["link"] 		= "/mybackoffice/user_admin";
		}
		
		if(isset($this->admin_type)&&($this->admin_type==1||$this->admin_type==2))
		{
		$menu[12]["name"]	=	"ประวัติการใช้งาน";
		$menu[12]["link"]	=	"/mybackoffice/log_admin";
		}
		
		$menu[13]["name"]	=	"การขายดีล";
		$menu[13]["link"]	=	"/mybackoffice/show_deal_sell";
		
		$menu[14]["name"]	=	"การขายแคมเปญ";
		$menu[14]["link"]	=	"/mybackoffice/show_product_sell";
		
		$menu[15]["name"]	=	"รายได้ของร้านค้า";
		$menu[15]["link"]		=	"/mybackoffice/show_vendor_sell";
		
		$menu[16]["name"]	=	"ติดต่อลงโฆษณา";
		$menu[16]["link"]		=	"/mybackoffice/free_ads";
		
		return $menu;
	}
	public function load_shop_data($vendor_id,$type)
	{
		$data			=	array();
		if($type==1)
		{
			$this->load->model('vendor_profile');
			$data	=	$this->vendor_profile->get_vendor_profile_by_id($vendor_id);
			
			$show_data	=	array();	

			$show_data["deal_address"]			=	$data["vendor_address"];
			$show_data["deal_email"]				=	$data["vendor_email"];
			$show_data["deal_website"]			=	$data["vendor_website"];
			$show_data["deal_map"]				=	$data["vendor_map"]; 
			$show_data["deal_aboutus_detail"]	=	$data["vendor_about_us"];
		}
		if($type==2)
		{
			$this->load->model('deal_main');
			$data	=	$this->deal_main->get_last_deal_by_vendor_id($vendor_id);
			if(sizeof($data)>0)
			{
				$show_data	=	array();	

				$show_data["deal_address"]			=	$data["deal_address"];
				$show_data["deal_email"]				=	$data["deal_email"];
				$show_data["deal_website"]			=	$data["deal_website"];
				$show_data["deal_map"]				=	$data["deal_map"];
				$show_data["deal_aboutus_detail"]	=	$data["deal_aboutus_detail"];
			}
		}
		echo json_encode($show_data);
	}
	public function admin_login()
	{
			$admin_user		=	$this->input->post('admin_username');
			$admin_pwd		=	base64_encode($this->input->post('admin_password'));

			$admin_data		=  $this->admin_profile->get_admin_by_login($admin_user,$admin_pwd);
			
			if(sizeof($admin_data)>0)
			{
				$remeberme	=	$this->input->post('remeberme');
			
				$this->admin_id			=	$admin_data["admin_id"];
				$this->admin_type		=	$admin_data["admin_type"];
				
				unset($admin_data);
		
				if($remeberme)
				{
					$cookie = array(
	    				'name'   => 'admin_auto_login_id',
	    				'value'  =>$this->admin_id,
	    				'expire' => (60*60*24),
	    				'domain' => '',
	    				'path'   => '/',
	    				'prefix' => '',
	   	 				'secure' => FALSE
					);
					$this->input->set_cookie($cookie);
					
					$cookie_type = array(
	    				'name'   => 'admin_auto_login_type',
	    				'value'  =>$this->admin_type,
	    				'expire' => (60*60*24),
	    				'domain' => '',
	    				'path'   => '/',
	    				'prefix' => '',
	   	 				'secure' => FALSE
					);
					$this->input->set_cookie($cookie_type);
				}
				$this->session->set_userdata('admin_id',$this->admin_id);
				$this->session->set_userdata('admin_type',$this->admin_type);
				$this->xlog_admin->save_log($this->admin_id,"1001");
				
				echo "1";
			}else{
				echo "0";
			}
	}
	public function log_admin($row_id="")
	{
		$this->check_admin_login();
		
		$base_table_ref = array();
		
		$page_title = ":: ประวัติการใช้งาน ::";
		$page_header = ":: ประวัติการใช้งาน ::";

		$base_url = "/mybackoffice/log_admin";
		$base_menu = "ข้อมูลประวัติการใช้งาน";

		$view_data = array();
		
		$sql	=	"	SELECT 
							a.admin_id,
							a.admin_user,
							a.admin_name,
							l.log_id,
							l.admin_ip,
							l.action_type,
							l.action_comment,
							l.log_time
						FROM xlog_admin l
						LEFT JOIN tbl_admin a ON (l.admin_id = a.admin_id) 
					";
		
		if(!empty($row_id))
		$sql	.=	" WHERE l.admin_id = '".$row_id."'";
		$sql	.= " ORDER BY log_time DESC";
		$query = $this->db->query($sql);
		
		$view_data["admin_log_data"] = $query->result_array();
		$view_data["admin_log_code"] = $this->admin_log_code;
		
		$this->page_data["content"] = $this->load->view($base_url.'/main.php',$view_data,true);
		
		unset($admin_log_data);
		
		$this -> page_data["page_title"] 		= $page_title;
		$this -> page_data["page_header"] = $page_header;
		$this -> render -> page_render($this -> page_data);

		unset($view_data);
	}
	private function check_admin_login()
	{
		if(empty($this->admin_id))
		{
			echo '
			<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
			<html xmlns:fb="http://ogp.me/ns/fb#">
			<head>
				<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
				<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
				<meta http-equiv="Cache-control" content="no-cache">
			</head>
			<body>
				<script>window.location.href = "/mybackoffice";</script>
			</body>
			</html>
			';
			exit;
			return 0;
		}
	}
	private function generate_page($sub_page, $row_id, $page_title, $page_header, $base_table, $base_url, $base_menu, $base_pk, $data) 
	{
		$view_data = array();

		switch ($sub_page) {
			case 'insert_form' :
				$view_data['page_action'] = $base_url . '/insert/';
				$view_data['action_status']	=	"insert";
				$view_data['manage_title'] = "เพิ่มข้อมูล " . $base_menu;

				$this -> page_data["content"] = $this -> load -> view($base_url . '/form.php', $view_data, true);
				break;

			case 'update_form' :
				$query = $this -> db -> get_where($base_table, array($base_pk => $row_id));
				$view_data = $query -> row_array();

				$view_data['page_action'] = $base_url . '/update/' . $row_id;
				$view_data['action_status']	=	"update";
				$view_data['manage_title'] = "แก้ไขข้อมูล " . $base_menu;
				$this -> page_data["content"] = $this -> load -> view($base_url . '/form.php', $view_data, true);
				break;

			case 'insert' :
				$this -> db -> insert($base_table, $data);
				
				$this->load->model('xlog_admin');
				
				if($base_table=="tbl_province_data")	$this->xlog_admin->save_log($this->admin_id,"2061");
				if($base_table=="tbl_category_main")	$this->xlog_admin->save_log($this->admin_id,"2071");
				if($base_table=="tbl_admin")				$this->xlog_admin->save_log($this->admin_id,"2111");
				
				echo "<script>window.location.href='" . $base_url . "'</script>";
				unset($data);
				return 0;
				break;

			case 'update' :
				$this -> db -> where($base_pk, $row_id);
				$this -> db -> update($base_table, $data);
				
				if($base_table=="tbl_province_data")	$this->xlog_admin->save_log($this->admin_id,"2062");
				if($base_table=="tbl_category_main")	$this->xlog_admin->save_log($this->admin_id,"2072");
				if($base_table=="tbl_admin")				$this->xlog_admin->save_log($this->admin_id,"2112");
				
				unset($data);
				echo "<script>window.location.href='" . $base_url . "'</script>";
				return 0;
				break;

			case 'delete' :
				$this -> db -> where($base_pk, $row_id);
				$this -> db -> delete($base_table);
				
				if($base_table=="tbl_province_data")	$this->xlog_admin->save_log($this->admin_id,"2063");
				if($base_table=="tbl_category_main")	$this->xlog_admin->save_log($this->admin_id,"2073");
				if($base_table=="tbl_admin")				$this->xlog_admin->save_log($this->admin_id,"2113");
				
				echo "<script>window.location.href='" . $base_url . "'</script>";
				return 0;
				break;

			case 'view_data':
				$query = $this -> db -> get_where($base_table, array($base_pk => $row_id));
				$view_data = $query -> row_array();
				
				$view_data['action_status']	=	"view";
				$view_data['page_action'] 	= 	$base_url . '/view/';
				$view_data['manage_title'] = 	"แสดงข้อมูล " . $base_menu;
				
				$this -> page_data["content"] = $this -> load -> view($base_url . '/view.php', $view_data, true);
			break;
			
			default :
				$view_data = array();

				$query = $this -> db -> get($base_table);
				$view_data[$base_table] = $query -> result_array();

				$this -> page_data["content"] = $this -> load -> view($base_url . '/main.php', $view_data, true);
				break;
		}

		$this -> page_data["page_title"] = $page_title;
		$this -> page_data["page_header"] = $page_header;
		$this -> render -> page_render($this -> page_data);

		unset($view_data);
	}

	private function generate_vendor_page($sub_page, $row_id, $page_title, $page_header, $base_table, $base_table_main, $base_table_ref, $base_status_ref, $base_url, $base_menu, $base_pk, $data) {
		$view_data = array();
		$view_data['admin_type']	=	$this->admin_type;
		
		switch ($sub_page) {
			case 'insert_form' :
			
				$view_data['action_status']	=	"insert";
				$view_data['page_action'] = $base_url . '/insert/';
				$view_data['manage_title'] = "เพิ่มข้อมูล " . $base_menu;

				if ($base_status_ref != "")
						$this -> db -> where($base_status_ref, '1');
					
				if($base_table_main=="tbl_province_data")
				{
					$this->db->order_by("province_name","ASC");
				}
				$query = $this -> db -> get($base_table_main);
				$view_data[$base_table_main] = $query -> result_array();
				
				$this->db->select("admin_id,admin_name");
				$this->db->order_by("admin_name","ASC");
				$query = $this -> db -> get("tbl_admin");
				$view_data["admin_data"] = $query -> result_array();
				
				$this -> page_data["content"] = $this -> load -> view($base_url . '/form.php', $view_data, true);
				break;

			case 'update_form' :
				$query = $this -> db -> get_where($base_table, array($base_pk => $row_id));
				$view_data = $query -> row_array();
				
				$view_data['action_status']	=	"update";
				$view_data['page_action'] 	= $base_url . '/update/' . $row_id;
				$view_data['manage_title'] = "แก้ไขข้อมูล " . $base_menu;

				$query = $this -> db -> get($base_table_main);
				$view_data[$base_table_main] = $query -> result_array();
				
				$this->db->select("admin_id,admin_name");
				$this->db->order_by("admin_name","ASC");
				$query = $this -> db -> get("tbl_admin");
				$view_data["admin_data"] = $query -> result_array();
				$view_data['admin_type']	=	$this->admin_type;
				
				$this -> page_data["content"] = $this -> load -> view($base_url . '/form.php', $view_data,true);
				
				break;

			case 'insert' :
				
				$this->load->model('vendor_profile');
				$vendor_id		=	$this->vendor_profile->get_next_vendor_id();
				
				$upload_path							=	'vendor/logo/'.($vendor_id%10);
				$input_name							=	"vendor_logo";
				
				if(!empty($_FILES[$input_name]["type"]))
				{
					$type_image				=	explode("/",$_FILES[$input_name]["type"]);
				
					$file_name					= 	$vendor_id.".".$type_image[1];
				
					$resize						=	array();
					$resize['width']			=	200;
					$resize['height']			=	65;
					$resize['save_path']	=	$upload_path;
					$resize['pic_name']	=	$file_name;
						
					$this->do_upload($upload_path,$file_name,$input_name,$resize);
			
					$data["vendor_logo"]				=	"";
					$data["vendor_logo"]				=	'upload/vendor/logo/'.($vendor_id%10).'/'.$file_name;
				}
				
				$upload_path					=	'vendor/map/'.($vendor_id%10);
				$input_name					=	"vendor_map";
				
				if(!empty($_FILES[$input_name]["type"]))
				{
					$type_image				=	explode("/",$_FILES[$input_name]["type"]);
				
					$file_name					= 	$vendor_id.".".$type_image[1];
				
					$resize						=	array();
					$resize['width']			=	550;
					$resize['height']			=	400;
					$resize['save_path']	=	$upload_path;
					$resize['pic_name']	=	$file_name;
						
					$this->do_upload($upload_path,$file_name,$input_name,$resize);
					
					$data["vendor_map"]				=	"";
					$data["vendor_map"]				=	'upload/vendor/map/'.($vendor_id%10).'/'.$file_name;
				}
				
				$data["vendor_id"]					=	$vendor_id;
				$data["vendor_create"]			=	date("Y-m-d H:i:s",time());	
				$data["vendor_modify"]			=	date("Y-m-d H:i:s",time());	
				
				$this -> db -> insert($base_table, $data);
				$this->xlog_admin->save_log($this->admin_id,"2011","vendor_id =".$vendor_id);
				
				echo "<script>window.location.href='" . $base_url . "'</script>";
				unset($data);
				return 0;
				break;

			case 'update' :
				$vendor_id	=	$row_id;
				
				$input_name	=	"vendor_logo";
					
				if(!empty($_FILES[$input_name]["type"]))
				{
					$upload_path				=	'vendor/logo/'.($vendor_id%10);
					$type_image				=	explode("/",$_FILES[$input_name]["type"]);
					
					$file_name					= 	$vendor_id.".".$type_image[1];
				
					$resize						=	array();
					$resize['width']			=	200;
					$resize['height']			=	65;
					$resize['save_path']	=	$upload_path;
					$resize['pic_name']	=	$vendor_id.".".$type_image[1];
						
					$this->do_upload($upload_path,$file_name,$input_name,$resize);
					
					$data["vendor_logo"]				=	"";
					$data["vendor_logo"]				=	'upload/vendor/logo/'.($vendor_id%10).'/'.$file_name;
					
					unset($resize);
				}
				
				$input_name	=	"vendor_map";
				
				if(!empty($_FILES[$input_name]["type"]))
				{
					$upload_path							=	'vendor/map/'.($vendor_id%10);
					$type_image							=	explode("/",$_FILES[$input_name]["type"]);
					
					$file_name					= 	$vendor_id.".".$type_image[1];
				
					$resize						=	array();
					$resize['width']			=	550;
					$resize['height']			=	400;
					$resize['save_path']	=	$upload_path;
					$resize['pic_name']	=	$file_name;
						
					$this->do_upload($upload_path,$file_name,$input_name,$resize);
					
					$data["vendor_map"]		=	"";
					$data["vendor_map"]		=	'upload/vendor/map/'.($vendor_id%10).'/'.$file_name;
					
					unset($resize);
				}
				$data["vendor_modify"]		=	date("Y-m-d H:i:s",time());	
				
				$this -> db -> where($base_pk, $row_id);
				$this -> db -> update($base_table, $data);
				$this->xlog_admin->save_log($this->admin_id,"2012","vendor_id =".$row_id);
				
				unset($data);
				echo "<script>window.location.href='" . $base_url . "'</script>";
				return 0;
				break;

			case 'delete' :
				$this->load->model('vendor_profile');
				$this->vendor_profile->delete_vendor_profile($row_id);
				$this->xlog_admin->save_log($this->admin_id,"2013","vendor_id =".$row_id);
				
				echo "<script>window.location.href='" . $base_url . "'</script>";
				return 0;
				break;
			case 'view_data':
				$query = $this -> db -> get_where($base_table, array($base_pk => $row_id));
				$view_data = $query -> row_array();
				
				$view_data['action_status']	=	"view";
				$view_data['page_action'] 	= 	$base_url . '/view/';
				$view_data['manage_title'] = 	"แสดงข้อมูล " . $base_menu;
				
				$this->db->select("admin_id,admin_name");
				$this->db->order_by("admin_name","ASC");
				$query = $this -> db -> get("tbl_admin");
				$view_data["admin_data"] = $query -> result_array();
				
				$view_data['admin_type']	=	$this->admin_type;
					
				if($base_table_main=="tbl_province_data")
				{
					$this->load->model('province_data');
					$view_data["province_data"]	=	$this->province_data->get_provicne_by_id($view_data["province_id"]);
				}
				
				$this -> page_data["content"] = $this -> load -> view($base_url . '/view.php', $view_data, true);
			break;
			case 'send_password':
				$query = $this -> db -> get_where($base_table, array($base_pk => $row_id));
				$view_data = $query -> row_array();
				
				$email	=	$view_data["vendor_email"];
				
				$this->load->library('email');

				$this->email->from('support@thebestdeal1.com', 'TheBestDeal1');
				$this->email->to($email);
				$this->email->subject("thebestdeal1 : แจ้งรหัสผ่านร้านค้าของท่านสมาชิก");
		
				$msg		=	"<br/><br/>".
						"แจ้งข้อมูลการเข้าใช้งานของร้านค้า<br/><br/>".
						"อีเมลของท่านคือ ".$view_data['vendor_email']." <br/>".
						"รหัสผ่านของท่านคือ ".base64_decode($view_data['vendor_pwd'])."<br/><br/>".
						"ขอบคุณค่ะ<br/><br/>";
				$view_data["content"]	=	$msg;
		
				$body	=	$this -> load -> view('template/email_template.php',$view_data, true);					
				$this->email->message($body);	

				$this->email->send();
				
				//echo $this->email->print_debugger();
				echo 1;
				return 0;
			break;
			case 'reset_password':
				$query = $this -> db -> get_where($base_table, array($base_pk => $row_id));
				$view_data = $query -> row_array();
				
				$email	=	$view_data["vendor_email"];
				
				$this->load->library('email');

				$this->email->from('support@thebestdeal1.com', 'TheBestDeal1');
				$this->email->to($email);
				$this->email->subject("thebestdeal1 : เปลี่ยนรหัสผ่านร้านค้าของท่านสมาชิก");
		
				$msg		=	"<br/><br/>".
						"<b>หากท่านต้องการเปลี่ยนรหัสผ่าน  กรุณาคลิกที่นี่</b><br/><br/>".
						"http://www..com/vendor/vendor_change_pass/".base64_decode($view_data['vendor_id'])."<br/><br/>".
						"<br/><br/>";
				$view_data["content"]	=	$msg;
				
				$activate_code	=	base64_encode($view_data['vendor_id']);
				$activate_link		=	"http://thebestdeal1.com/vendor/vendor_change_pass/".$activate_code;	
		
				$msg		=	"<br/><br/>".
						"<b>หากท่านต้องการเปลี่ยนรหัสผ่าน  </b><br/><br/>".
						"กรุณาคลิ๊กที่ url : ".$activate_link."<br/> เพื่อทำการเปลี่ยนรหัสผ่านของท่านค่ะ<br/><br/>";
				$view_data["content"]	=	$msg;
		
				$body	=	$this -> load -> view('template/email_template.php',$view_data, true);					
				$this->email->message($body);	

				$this->email->send();
				
				//echo $this->email->print_debugger();
				echo 1;
				return 0;
			break;
			default :
				$this->load->model('vendor_profile');
				
				$view_data[$base_table] = $this->vendor_profile->get_all_vendor_profile();
				
				$other_data	=	array();
				foreach($view_data[$base_table] as $index=>$data)
				{
					$other_data[$index]	=	$this->vendor_profile->get_vendor_summary($index);
				}
				$view_data["other_data"] =	$other_data;
				
				unset($other_data);
				
				$this -> page_data["content"] = $this -> load -> view($base_url . '/main.php', $view_data, true);

				break;
		}

		$this -> page_data["page_title"] 		= $page_title;
		$this -> page_data["page_header"] = $page_header;
		$this -> render -> page_render($this -> page_data);

		unset($view_data);
	}

	private function generate_member_page($sub_page, $row_id, $page_title, $page_header, $base_table, $base_table_main, $base_table_ref, $base_status_ref, $base_url, $base_menu, $base_pk, $data) {
		$view_data = array();

		switch ($sub_page) {
			case 'insert_form' :
			
				$view_data['action_status']	=	"insert";
				$view_data['page_action'] = $base_url . 'insert/';
				$view_data['manage_title'] = "เพิ่มข้อมูล " . $base_menu;

				if ($base_status_ref != "")
						$this -> db -> where($base_status_ref, '1');
					
				if($base_table_main=="tbl_province_data")
				{
					$this->db->order_by("province_name","ASC");
				}
				$query = $this -> db -> get($base_table_main);
				$view_data[$base_table_main] = $query -> result_array();

				$this -> page_data["content"] = $this -> load -> view($base_url . '/form.php', $view_data, true);
				break;

			case 'update_form' :
				$query = $this -> db -> get_where($base_table, array($base_pk => $row_id));
				$view_data = $query -> row_array();
				
				$view_data['action_status']	=	"update";
				$view_data['page_action'] 	= $base_url . '/update/' . $row_id;
				$view_data['manage_title'] = "แก้ไขข้อมูล " . $base_menu;

				if($base_table_main=="tbl_province_data")
				{
					$this->db->order_by("province_name","ASC");
				}
				$query = $this -> db -> get($base_table_main);
				$view_data[$base_table_main] = $query -> result_array();

				$this -> page_data["content"] = $this -> load -> view($base_url . '/form.php', $view_data,true);
				
				break;

			case 'insert' :
				$this -> db -> insert($base_table, $data);
				$email			=	$data["member_email"];
				$password		=	base64_decode($data["member_pwd"]);
				
				$this->load->library('email');

				$this->email->from('support@thebestdeal1.com', 'TheBestDeal1');
				$this->email->to($email); 
				$this->email->subject('"welcome to thebestdeal1"');
		
				$activate_code	=	base64_encode($email.",".$password);
				$activate_link		=	"http://thebestdeal1.com/member/activate_user/".$activate_code;	
		
				$msg		=	"<br/><br/>".
						"ยินดีต้อนรับท่านสมาชิกใหม่<br/><br/>".
						"อีเมลของท่านคือ ".$email." <br/>".
						"รหัสผ่านของท่านคือ ".$password."<br/><br/>".
						"กรุณาคลิ๊กที่ url : ".$activate_link."<br/> เพื่อทำการยื่นยันอีเมลของท่านค่ะ<br/><br/>";
				$view_data["content"]	=	$msg;
		
				$body	=	$this -> load -> view('template/email_template.php',$view_data, true);					
				$this->email->message($body);	

				$this->email->send();
				$this->xlog_admin->save_log($this->admin_id,"2001","email = ".$email);
				echo "<script>window.location.href='" . $base_url ."insert_form';</script>";
				unset($data);
				return 0;
				break;

			case 'update' :
				$this -> db -> where($base_pk, $row_id);
				$this -> db -> update($base_table, $data);
				$this->xlog_admin->save_log($this->admin_id,"2002","member_id = ".$row_id);
				unset($data);
				echo "<script>window.location.href='" . $base_url ."update_form/".$row_id."';</script>";
				return 0;
				break;

			case 'delete' :
				$this -> db -> where($base_pk, $row_id);
				$this -> db -> delete($base_table);
				$this->xlog_admin->save_log($this->admin_id,"2003","member_id = ".$row_id);
				echo 1;
				return 0;
				break;
				
			case 'view_data':
				$query = $this -> db -> get_where($base_table, array($base_pk => $row_id));
				$view_data = $query -> row_array();
				
				$view_data['action_status']	=	"view";
				$view_data['page_action'] 	= 	$base_url . '/view/';
				$view_data['manage_title'] = 	"แสดงข้อมูล " . $base_menu;
					
				if (isset($view_data['member_birth_date']))
				{
						$today = date("Y-m-d",time());
	
						list($byear, $bmonth, $bday)	= explode("-",$view_data['member_birth_date']);
						list($tyear, $tmonth, $tday)		= explode("-",$today);
							
						$mbirthday 	= mktime(0, 0, 0, $bmonth, $bday, ($byear)); 
						$mnow 			= mktime(0, 0, 0, $tmonth, $tday, $tyear );
						$mage 			= ($mnow - $mbirthday);
				
						$u_y		=	date("Y", $mage)-1970;
						$u_m	=	date("m",$mage)-1;
						$u_d		=	date("d",$mage)-1;
						
						$view_data['birth_day'] = $bday."/".$bmonth."/".($byear+543);
						$view_data['age'] = "$u_y&nbsp;  ปี&nbsp;&nbsp; $u_m&nbsp; เดือน&nbsp;&nbsp; $u_d&nbsp; วัน";
				}
				if($base_table_main=="tbl_province_data")
				{
					$this->load->model('province_data');
					$view_data["province_data"]	=	$this->province_data->get_provicne_by_id($view_data["province_id"]);
				}
				
				$this -> page_data["content"] = $this -> load -> view($base_url . '/view.php', $view_data, true);
			break;
			
			case 'member_order':
				$this->load->model('member_orderDetail');
				$content_data["order_data"]		=	$this->member_orderDetail->ShowOrderMember($row_id);
				$this->page_data["content"]		=	$this -> load -> view($base_url . '/order.php', $content_data, true);
			break;
			case 'send_password':
				$query = $this -> db -> get_where($base_table, array($base_pk => $row_id));
				$view_data = $query -> row_array();
				
				$email	=	$view_data["member_email"];
				
				$this->load->library('email');

				$this->email->from('support@thebestdeal1.com', 'TheBestDeal1');
				$this->email->to($email);
				$this->email->subject("thebestdeal1 : รหัสผ่านของคุณคือ");
		
				$msg		=	"<br/><br/>".
						"แจ้งข้อมูลการเข้าใช้งานของท่านสมาชิก<br/><br/>".
						"อีเมลของท่านคือ ".$view_data['member_email']." <br/>".
						"รหัสผ่านของท่านคือ ".base64_decode($view_data['member_pwd'])."<br/><br/>".
						"ขอบคุณค่ะ<br/><br/>";
				$view_data["content"]	=	$msg;
		
				$body	=	$this -> load -> view('template/email_template.php',$view_data, true);					
				$this->email->message($body);	

				$this->email->send();
				
				//echo $this->email->print_debugger();
				echo 1;
				return 0;
			break;
			default :
				$view_data = array();
				$this->load->model('member_profile');
				$view_data[$base_table] = $this->member_profile->get_all_member_profile_view();

				$this -> page_data["content"] = $this -> load -> view($base_url . '/main.php', $view_data, true);

				break;
		}

		$this -> page_data["page_title"] = $page_title;
		$this -> page_data["page_header"] = $page_header;
		$this -> render -> page_render($this -> page_data);

		unset($view_data);
	}

	private function generate_category_page($sub_page, $row_id, $page_title, $page_header, $base_table, $base_table_main, $base_table_ref, $base_status_ref, $base_url, $base_menu, $base_pk, $data) {
		$view_data = array();

		switch ($sub_page) {
			case 'insert_form' :
			
				$view_data['action_status']	=	"insert";
				$view_data['page_action'] = $base_url . '/insert/';
				$view_data['manage_title'] = "เพิ่มข้อมูล " . $base_menu;

				if ($base_status_ref != "")
						$this -> db -> where($base_status_ref, '1');
					
				if($base_table_main=="tbl_category_main")
				{
					$this->db->order_by("cat_name","ASC");
				}
				$query = $this -> db -> get($base_table_main);
				$view_data[$base_table_main] = $query -> result_array();

				$this -> page_data["content"] = $this -> load -> view($base_url . '/form.php', $view_data, true);
				break;

			case 'update_form' :
				$query = $this -> db -> get_where($base_table, array($base_pk => $row_id));
				$view_data = $query -> row_array();
				
				$view_data['action_status']	=	"update";
				$view_data['page_action'] 	= $base_url . '/update/' . $row_id;
				$view_data['manage_title'] = "แก้ไขข้อมูล " . $base_menu;

				$query = $this -> db -> get($base_table_main);
				$view_data[$base_table_main] = $query -> result_array();

				$this -> page_data["content"] = $this -> load -> view($base_url . '/form.php', $view_data,true);
				
				break;

			case 'insert' :
				$this -> db -> insert($base_table, $data);
				$this->xlog_admin->save_log($this->admin_id,"2081");
				echo "<script>window.location.href='" . $base_url . "'</script>";
				unset($data);
				return 0;
				break;

			case 'update' :
				$this -> db -> where($base_pk, $row_id);
				$this -> db -> update($base_table, $data);
				$this->xlog_admin->save_log($this->admin_id,"2082","cat_id = ".$row_id);
				unset($data);
				echo "<script>window.location.href='" . $base_url . "'</script>";
				return 0;
				break;

			case 'delete' :
				$this -> db -> where($base_pk, $row_id);
				$this -> db -> delete($base_table);
				$this->xlog_admin->save_log($this->admin_id,"2083","cat_id = ".$row_id);
				echo "<script>window.location.href='" . $base_url . "'</script>";
				return 0;
				break;
			case 'view_data':
				$query = $this -> db -> get_where($base_table, array($base_pk => $row_id));
				$view_data = $query -> row_array();
				
				$view_data['action_status']	=	"view";
				$view_data['page_action'] 	= 	$base_url . '/view/';
				$view_data['manage_title'] = 	"แสดงข้อมูล " . $base_menu;
					
				if($base_table_main=="tbl_category_main")
				{
					$this->load->model('category_main');
					$view_data["cat_data"]	=	$this->category_main->get_category_data($view_data["cat_id"]);
				}
				
				$this -> page_data["content"] = $this -> load -> view($base_url . '/view.php', $view_data, true);
			break;
			default :
				$view_data = array();
				$this->load->model('category_sub');
				
				$view_data[$base_table] = $this->category_sub->get_category_sub();

				$this -> page_data["content"] = $this -> load -> view($base_url . '/main.php', $view_data, true);

				break;
		}

		$this -> page_data["page_title"] = $page_title;
		$this -> page_data["page_header"] = $page_header;
		$this -> render -> page_render($this -> page_data);

		unset($view_data);
	}

private function generate_sub_page($sub_page, $row_id, $page_title, $page_header, $base_table, $base_table_main, $base_table_ref, $base_status_ref, $base_url, $base_menu, $base_pk, $data) {
		$view_data = array();

		switch ($sub_page) {
			case 'insert_form' :
			
				$view_data['action_status']	=	"insert";
				$view_data['page_action'] = $base_url . '/insert/';
				$view_data['manage_title'] = "เพิ่มข้อมูล " . $base_menu;

				if ($base_status_ref != "")
						$this -> db -> where($base_status_ref, '1');
					
				if($base_table_main=="tbl_category_main")
				{
					$this->db->order_by("cat_name","ASC");
				}
				$query = $this -> db -> get($base_table_main);
				$view_data[$base_table_main] = $query -> result_array();

				$this -> page_data["content"] = $this -> load -> view($base_url . '/form.php', $view_data, true);
				break;

			case 'update_form' :
				$query = $this -> db -> get_where($base_table, array($base_pk => $row_id));
				$view_data = $query -> row_array();
				
				$view_data['action_status']	=	"update";
				$view_data['page_action'] 	= $base_url . '/update/' . $row_id;
				$view_data['manage_title'] = "แก้ไขข้อมูล " . $base_menu;

				$query = $this -> db -> get($base_table_main);
				$view_data[$base_table_main] = $query -> result_array();

				$this -> page_data["content"] = $this -> load -> view($base_url . '/form.php', $view_data,true);
				
				break;

			case 'insert' :
				$this -> db -> insert($base_table, $data);
				echo "<script>window.location.href='" . $base_url . "'</script>";
				unset($data);
				return 0;
				break;

			case 'update' :
				$this -> db -> where($base_pk, $row_id);
				$this -> db -> update($base_table, $data);
				unset($data);
				echo "<script>window.location.href='" . $base_url . "'</script>";
				return 0;
				break;

			case 'delete' :
				$this -> db -> where($base_pk, $row_id);
				$this -> db -> delete($base_table);
				echo "<script>window.location.href='" . $base_url . "'</script>";
				return 0;
				break;
			case 'view_data':
				$query = $this -> db -> get_where($base_table, array($base_pk => $row_id));
				$view_data = $query -> row_array();
				
				$view_data['action_status']	=	"view";
				$view_data['page_action'] 	= 	$base_url . '/view/';
				$view_data['manage_title'] = 	"แสดงข้อมูล " . $base_menu;
					
				if($base_table_main=="tbl_category_main")
				{
					$this->load->model('category_main');
					$view_data["cat_data"]	=	$this->category_main->get_category_data($view_data["cat_id"]);
				}
				
				$this -> page_data["content"] = $this -> load -> view($base_url . '/view.php', $view_data, true);
			break;
			default :
				$view_data = array();
				$this->load->model('category_sub');
				
				$view_data[$base_table] = $this->category_sub->get_category_sub();

				$this -> page_data["content"] = $this -> load -> view($base_url . '/main.php', $view_data, true);

				break;
		}

		$this -> page_data["page_title"] = $page_title;
		$this -> page_data["page_header"] = $page_header;
		$this -> render -> page_render($this -> page_data);

		unset($view_data);
	}
	public function index() 
	{
		$view_data["stylesheets"]		=	$this->stylesheets;
		$view_data["javascripts"]		=	$this->javascripts;
		
		$admin_login	=	$this->input->cookie("admin_auto_login_id");	
		$admin_type	=	$this->input->cookie("admin_auto_login_type");	
			
		if(!empty($admin_login) && !empty($admin_type) )
		{
				$this->session->set_userdata('admin_id',$admin_login);
				$this->session->set_userdata('admin_type',$admin_type);
				$this->xlog_admin->save_log($admin_login,"1001");
				
				$view_data = array();
				$this->load->model('member_profile');
				$view_data["tbl_member_profile"] = $this->member_profile->get_all_member_profile_view();

				$this -> page_data["content"] = $this -> load -> view('mybackoffice/member_profile/main.php', $view_data, true);
				$this -> page_data["page_title"] =  ":: ข้อมูลสมาชิก ::";
				$this -> page_data["page_header"] = ":: ข้อมูลสมาชิก ::";
				$this -> render -> page_render($this -> page_data);
		}
		else
				$login_form	=	$this -> load -> view('mybackoffice/admin_login.php',$view_data);
	}

	public function member_profile($sub_page = '', $row_id = '') {
		$this->check_admin_login();
		//start config
		$page_title = ":: ข้อมูลสมาชิก ::";
		$page_header = ":: ข้อมูลสมาชิก ::";

		$base_table = "tbl_member_profile";
		$base_table_main = "tbl_province_data";
		$base_url = "/mybackoffice/member_profile/";
		$base_menu = "Member Profile";
		$base_pk = 'member_id';
		$base_table_ref = 'province_id';
		$base_status_ref = 'province_status';

		$member_name = $this -> input -> post('member_name');
		$member_sname = $this -> input -> post('member_sname');
		$member_ssn = $this -> input -> post('member_ssn');
		$member_email = $this -> input -> post('member_email');
		$member_gendar = $this -> input -> post('member_gendar');
		
		// password เข้ารหัส base64
		$pwd = $this -> input -> post('member_pwd');
		$member_pwd =  base64_encode($pwd);
	
		//วัดเกิด
		$d_birth = $this -> input -> post('d_birth');
		$m_birth = $this -> input -> post('m_birth');
		$y_birth = $this -> input -> post('y_birth');
		 $birth = $y_birth."/".$m_birth."/".$d_birth;
		 $member_birth_date = mysql_real_escape_string($birth);

		$member_mobile = $this -> input -> post('member_mobile');
		$member_address = $this -> input -> post('member_address');
		$city_name = $this -> input -> post('city_name');
		$province_id = $this -> input -> post('province_id');
		$member_zipcode = $this -> input -> post('member_zipcode');
		$subscript_email = $this -> input -> post('subscript_email');
		$register_email = $this -> input -> post('register_email');
		$d_now = date("Y-m-d H:i:s");
		$ipaddress = $this->input->ip_address();
		$know_from	=	$this->input->post("know_from");
	
		if($sub_page == 'insert'){
			$data = array('member_name' => $member_name, 'member_sname' => $member_sname, 'member_email' => $member_email, 
			'member_pwd' => $member_pwd, 'member_gendar' => $member_gendar, 'member_birth_date' => $member_birth_date,
			'member_ssn' => $member_ssn, 'member_mobile' => $member_mobile, 'member_address' => $member_address,
			'city_name' => $city_name, 'province_id' => $province_id, 'member_zipcode' => $member_zipcode,
			 'subscript_email' => $subscript_email, 'member_regis_time' => $d_now, 'member_regis_ip' => $ipaddress,
			 'member_update_time' => $d_now, 'register_email' => $register_email,"know_from"=>$know_from);
		}else{
			$data = array('member_name' => $member_name, 'member_sname' => $member_sname, 'member_email' => $member_email, 
			'member_gendar' => $member_gendar, 'member_birth_date' => $member_birth_date,
			'member_ssn' => $member_ssn, 'member_mobile' => $member_mobile, 'member_address' => $member_address,
			'city_name' => $city_name, 'province_id' => $province_id, 'member_zipcode' => $member_zipcode,
			 'subscript_email' => $subscript_email,'member_update_time' => $d_now, 'register_email' => $register_email,"know_from"=>$know_from);
		}
		//end config

		$this -> generate_member_page($sub_page, $row_id, $page_title, $page_header, $base_table, $base_table_main, $base_table_ref, $base_status_ref, $base_url, $base_menu, $base_pk, $data);
	}
	
	public function all_sell_deal_data()
	{
		$aColumns = array( 	'vendor_name', 
									'deal_name', 
									'deal_buy_time_start', 
									'deal_buy_time_end', 
									'deal_start',
									'deal_start',
									'product_price',
									'the_best_deal_price',
									'product_discount_per',
									'the_best_deal_price',
									'num_order',
									'num_coupon'
									);
	
		$sTable		=	"";
		$sWhere		=	"";
		$sOrder		=	"";
		$sLimit		=	"";
		
		$sTable = "view_deal_sale_report";
	
		$sLimit = "";
		$iDisplayStart	=	$this->input->get('iDisplayStart');
		$iDisplayLength	=	$this->input->get('iDisplayLength');
		if ( $iDisplayStart!="" &&  $iDisplayLength != '-1' )
		{
			$sLimit = "LIMIT ".mysql_real_escape_string($iDisplayStart).", ".
				mysql_real_escape_string($iDisplayLength);
		}
	
		$iSortCol_0	=	$this->input->get('iSortCol_0');

		if ($iSortCol_0!="")
		{
			$sOrder = "ORDER BY  ";
			for ( $i=0 ; $i<intval( $this->input->get('iSortingCols') ) ; $i++ )
			{
				if ( $this->input->get('bSortable_'.intval($this->input->get('iSortCol_'.$i))) == "true" )
				{
					$sOrder .= $aColumns[ intval( $this->input->get('iSortCol_'.$i) ) ]."
				 		".mysql_real_escape_string( $this->input->get('sSortDir_'.$i) ) .", ";
				}
			}
		
			$sOrder = substr_replace( $sOrder, "", -2 );
			if ( $sOrder == "ORDER BY" )
			{
				$sOrder = "";
			}
		}

		$sWhere = "";
		$sSearch		=	$this->input->get('sSearch');
		if ($sSearch != "" )
		{
			$sWhere = "WHERE (";
			for ( $i=0 ; $i<count($aColumns) ; $i++ )
			{
				$sWhere .= $aColumns[$i]." LIKE '%".mysql_real_escape_string( $sSearch )."%' OR ";
			}
			$sWhere = substr_replace( $sWhere, "", -3 );
			$sWhere .= ')';
		}
	
		for ( $i=0 ; $i<count($aColumns) ; $i++ )
		{
			if ( $this->input->get('bSearchable_'.$i) == "true" && $this->input->get('sSearch_'.$i) != '' )
			{
				if ( $sWhere == "" )
				{
					$sWhere = "WHERE ";
				}
				else
				{
					$sWhere .= " AND ";
				}
				$sWhere .= $aColumns[$i]." LIKE '%".mysql_real_escape_string($_GET['sSearch_'.$i])."%' ";
			}
		}
	/*
		$start_date		=	$this->input->get('start_date');
		$end_date		=	$this->input->get('end_date');
		$buy_status	=	$this->input->get('buy_status');
	
	if($start_date!="")
	{
		$date_set	=	explode("/",$start_date);
		$start_date	=	$date_set[2]."-".$date_set[1]."-".$date_set[0];
		
		if(empty($sWhere	))
		{
			$sWhere		=	" WHERE member_regis_time >= '".$start_date." 00:00:00'";
		}else{
			$sWhere		.=	" AND member_regis_time >= '".$start_date." 00:00:00'";
		}
	}
	if($end_date!="")
	{
		$date_set	=	explode("/",$end_date);
		$end_date	=	$date_set[2]."-".$date_set[1]."-".$date_set[0];
		if(empty($sWhere	))
		{
			$sWhere		=	" WHERE member_regis_time <= '".$end_date." 23:59:59'";
		}else{
			$sWhere		.=	" AND member_regis_time <= '".$end_date." 23:59:59'";
		}
	}
	if($buy_status!="")
	{
		if(empty($sWhere	))
		{
			if($buy_status==1)
			{
				$sWhere		.=	" WHERE nOrder > 0";
			}
			if($buy_status==0)
			{
				$sWhere		.=	" WHERE nOrder = 0";
			}
		}else{
			if($buy_status==1)
			{
				$sWhere		.=	" AND nOrder > 0";
			}
			if($buy_status==0)
			{
				$sWhere		.=	" AND nOrder = 0";
			}
		}
	}
	 */
	$sQuery = "
		SELECT ".str_replace(" , ", " ", implode(", ", $aColumns))."
		FROM   $sTable
		$sWhere
		$sOrder
		$sLimit
	";
	//echo $sQuery;
	
	$cQuery = "
		SELECT member_id
		FROM   $sTable
		$sWhere
	";
	
	$get_mamber_data 	= $this->member_profile->get_member_data($sQuery);
	$iFilteredTotal 			= $this->member_profile->get_nMember($cQuery);

	
	$iTotal =  $this->member_profile->get_nMember($cQuery);
	
	$output = array(
		"sEcho" => intval($this->input->get('sEcho')),
		"iTotalRecords" => $iTotal,
		"iTotalDisplayRecords" => $iFilteredTotal,
		"aaData" => array()
	);
	
	foreach($get_mamber_data as $data)
	{
		$row 		= array();
		$row[]	=	'<div align="center">'.$data["member_id"].'</div>';
		$row[]	=	$data["member_name"]."  ".$data["member_sname"];
		$row[]	=	$data["member_email"];
		$row[]	=	'<div align="center">'.$data["member_mobile"].'</div>';
		$row[]	=	'<div align="center">'.date("d/m/Y H:i:s",strtotime($data["member_regis_time"])).'</div>';

		if($data["nOrder"]>0)
		{
			$row[]	=	"<div align=\"center\"><a href='/mybackoffice/deal_order/main/0/0/".$data["member_id"]."/4'>".$data["nOrder"]."</a></div>";
		}else{
			$row[]	=	"<div align=\"center\">0</div>";
		}
		if($data["nCoupon"]>0)
		{
			$row[]	=	"<div align=\"center\"><a href='/mybackoffice/coupon_manage/main/0/".$data["member_id"]."/4'>".$data["nCoupon"]."</a></div>";
		}else{
			$row[]	=	"<div align=\"center\">0</div>";
		}
			$row[]	=	'<div align="center">'.
							'<a href="/mybackoffice/member_profile/view_data/'.$data["member_id"].'">'.image_asset("/icon/info.png", "", array("alt"=>"รายละเอียด","title"=>"รายละเอียด")).'</a> |'.
							'<a href="/mybackoffice/member_profile/update_form/'.$data["member_id"].'">'.image_asset('/icon/edit.png', '', array('alt'=>'แก้ไข','title'=>'แก้ไข')).'</a> |'.
							'<a href="#" onclick="send_password('.$data["member_id"].')">'.image_asset('/icon/email.png', '', array('alt'=>'แจ้งรหัสผ่าน','title'=>'แจ้งรหัสผ่าน')).'</a> |'.
							'<a href="#" onclick="delete_data('.$data["member_id"].',\''.$data["member_name"]."  ".$data["member_sname"].'\')">'.image_asset("/icon/delete.png", "", array("alt"=>"ลบข้อมูล","title"=>"ลบข้อมูล")).'</a>'.
							'</div>';
		$output['aaData'][] = $row;
	}
	
	echo json_encode( $output );
	}
	public function all_member_data()
	{
		$this->load->model('member_profile');
	
		$aColumns = array( 'member_id', 'member_name', 'member_email', 'member_mobile', 'member_regis_time','nOrder','nCoupon','member_sname');
		
		$sTable		=	"";
		$sWhere		=	"";
		$sOrder		=	"";
		$sLimit		=	"";
			
		$sTable = "view_member_data";
		
		$sLimit = "";
		$iDisplayStart	=	$this->input->get('iDisplayStart');
		$iDisplayLength	=	$this->input->get('iDisplayLength');
		if ( $iDisplayStart!="" &&  $iDisplayLength != '-1' )
		{
			$sLimit = "LIMIT ".mysql_real_escape_string($iDisplayStart).", ".
				mysql_real_escape_string($iDisplayLength);
		}
		
		
		$iSortCol_0	=	$this->input->get('iSortCol_0');

		if ($iSortCol_0!="")
		{
			$sOrder = "ORDER BY  ";
			for ( $i=0 ; $i<intval( $this->input->get('iSortingCols') ) ; $i++ )
			{
				if ( $this->input->get('bSortable_'.intval($this->input->get('iSortCol_'.$i))) == "true" )
				{
					$sOrder .= $aColumns[ intval( $this->input->get('iSortCol_'.$i) ) ]."
						".mysql_real_escape_string( $this->input->get('sSortDir_'.$i) ) .", ";
				}
			}
			
			$sOrder = substr_replace( $sOrder, "", -2 );
			if ( $sOrder == "ORDER BY" )
			{
				$sOrder = "";
			}
		}

		$sWhere = "";
		$sSearch		=	$this->input->get('sSearch');
		if ($sSearch != "" )
		{
			$sWhere = "WHERE (";
			for ( $i=0 ; $i<count($aColumns) ; $i++ )
			{
				$sWhere .= $aColumns[$i]." LIKE '%".mysql_real_escape_string( $sSearch )."%' OR ";
			}
			$sWhere = substr_replace( $sWhere, "", -3 );
			$sWhere .= ')';
		}
		
		for ( $i=0 ; $i<count($aColumns) ; $i++ )
		{
			if ( $this->input->get('bSearchable_'.$i) == "true" && $this->input->get('sSearch_'.$i) != '' )
			{
				if ( $sWhere == "" )
				{
					$sWhere = "WHERE ";
				}
				else
				{
					$sWhere .= " AND ";
				}
				$sWhere .= $aColumns[$i]." LIKE '%".mysql_real_escape_string($_GET['sSearch_'.$i])."%' ";
			}
		}
		
		$start_date		=	$this->input->get('start_date');
		$end_date		=	$this->input->get('end_date');
		$buy_status	=	$this->input->get('buy_status');
		
		if($start_date!="")
		{
			$date_set	=	explode("/",$start_date);
			$start_date	=	$date_set[2]."-".$date_set[1]."-".$date_set[0];
			
			if(empty($sWhere	))
			{
				$sWhere		=	" WHERE member_regis_time >= '".$start_date." 00:00:00'";
			}else{
				$sWhere		.=	" AND member_regis_time >= '".$start_date." 00:00:00'";
			}
		}
		if($end_date!="")
		{
			$date_set	=	explode("/",$end_date);
			$end_date	=	$date_set[2]."-".$date_set[1]."-".$date_set[0];
			if(empty($sWhere	))
			{
				$sWhere		=	" WHERE member_regis_time <= '".$end_date." 23:59:59'";
			}else{
				$sWhere		.=	" AND member_regis_time <= '".$end_date." 23:59:59'";
			}
		}
		if($buy_status!="")
		{
			if(empty($sWhere	))
			{
				if($buy_status==1)
				{
					$sWhere		.=	" WHERE nOrder > 0";
				}
				if($buy_status==0)
				{
					$sWhere		.=	" WHERE nOrder = 0";
				}
			}else{
				if($buy_status==1)
				{
					$sWhere		.=	" AND nOrder > 0";
				}
				if($buy_status==0)
				{
					$sWhere		.=	" AND nOrder = 0";
				}
			}
		}
		$sQuery = "
			SELECT ".str_replace(" , ", " ", implode(", ", $aColumns))."
			FROM   $sTable
			$sWhere
			$sOrder
			$sLimit
		";
		//echo $sQuery;
		
		$cQuery = "
			SELECT member_id
			FROM   $sTable
			$sWhere
		";
		
		$get_mamber_data 	= $this->member_profile->get_member_data($sQuery);
		$iFilteredTotal 			= $this->member_profile->get_nMember($cQuery);

		
		$iTotal =  $this->member_profile->get_nMember($cQuery);
		
		$output = array(
			"sEcho" => intval($this->input->get('sEcho')),
			"iTotalRecords" => $iTotal,
			"iTotalDisplayRecords" => $iFilteredTotal,
			"aaData" => array()
		);
		
		foreach($get_mamber_data as $data)
		{
			$row 		= array();
			$row[]	=	'<div align="center">'.$data["member_id"].'</div>';
			$row[]	=	$data["member_name"]."  ".$data["member_sname"];
			$row[]	=	$data["member_email"];
			$row[]	=	'<div align="center">'.$data["member_mobile"].'</div>';
			$row[]	=	'<div align="center">'.date("d/m/Y H:i:s",strtotime($data["member_regis_time"])).'</div>';

			if($data["nOrder"]>0)
			{
				$row[]	=	"<div align=\"center\"><a href='/mybackoffice/deal_order/main/0/0/".$data["member_id"]."/4'>".$data["nOrder"]."</a></div>";
			}else{
				$row[]	=	"<div align=\"center\">0</div>";
			}
			if($data["nCoupon"]>0)
			{
				$row[]	=	"<div align=\"center\"><a href='/mybackoffice/coupon_manage/main/0/".$data["member_id"]."/4'>".$data["nCoupon"]."</a></div>";
			}else{
				$row[]	=	"<div align=\"center\">0</div>";
			}
				$row[]	=	'<div align="center">'.
								'<a href="/mybackoffice/member_profile/view_data/'.$data["member_id"].'">'.image_asset("/icon/info.png", "", array("alt"=>"รายละเอียด","title"=>"รายละเอียด")).'</a> |'.
								'<a href="/mybackoffice/member_profile/update_form/'.$data["member_id"].'">'.image_asset('/icon/edit.png', '', array('alt'=>'แก้ไข','title'=>'แก้ไข')).'</a> |'.
								'<a href="#" onclick="send_password('.$data["member_id"].')">'.image_asset('/icon/email.png', '', array('alt'=>'แจ้งรหัสผ่าน','title'=>'แจ้งรหัสผ่าน')).'</a> |'.
								'<a href="#" onclick="delete_data('.$data["member_id"].',\''.$data["member_name"]."  ".$data["member_sname"].'\')">'.image_asset("/icon/delete.png", "", array("alt"=>"ลบข้อมูล","title"=>"ลบข้อมูล")).'</a>'.
								'</div>';
			$output['aaData'][] = $row;
		}
		
		echo json_encode( $output );
	}
	public function all_order_data()
	{
		$this->load->model('member_orderdetail');
	
	$aColumns = array('o.order_id','o.mem_id','m.member_name','m.member_sname','o.payment_type','o.order_date','o.order_pay_date','o.order_summary','o.order_status','o.order_status','o.payment_type');
	
	$sTable		=	"";
	$sWhere		=	"";
	$sOrder		=	"";
	$sLimit		=	"";
		
	$sTable = "tbl_deal_order o
					left join tbl_member_profile m on o.mem_id = m.member_id
					left join tbl_deal_order_detail od on o.order_id = od.order_id";
	
	$sLimit = "";
	$iDisplayStart	=	$this->input->get('iDisplayStart');
	$iDisplayLength	=	$this->input->get('iDisplayLength');
	if ( $iDisplayStart!="" &&  $iDisplayLength != '-1' )
	{
		$sLimit = "LIMIT ".mysql_real_escape_string($iDisplayStart).", ".
			mysql_real_escape_string($iDisplayLength);
	}
	
	
	$iSortCol_0	=	$this->input->get('iSortCol_0');

	if ($iSortCol_0!="")
	{
		$sOrder = "ORDER BY  ";
		for ( $i=0 ; $i<intval( $this->input->get('iSortingCols') ) ; $i++ )
		{
			if ( $this->input->get('bSortable_'.intval($this->input->get('iSortCol_'.$i))) == "true" )
			{
				$sOrder .= $aColumns[ intval( $this->input->get('iSortCol_'.$i) ) ]."
				 	".mysql_real_escape_string( $this->input->get('sSortDir_'.$i) ) .", ";
			}
		}
		
		$sOrder = substr_replace( $sOrder, "", -2 );
		if ( $sOrder == "ORDER BY" )
		{
			$sOrder = "";
		}
	}

	$sWhere = "";
	$sSearch		=	$this->input->get('sSearch');
	if ($sSearch != "" )
	{
		$sWhere = "WHERE (";
		for ( $i=0 ; $i<count($aColumns) ; $i++ )
		{
			$sWhere .= $aColumns[$i]." LIKE '%".mysql_real_escape_string( $sSearch )."%' OR ";
		}
		$sWhere = substr_replace( $sWhere, "", -3 );
		$sWhere .= ')';
	}
	
	for ( $i=0 ; $i<count($aColumns) ; $i++ )
	{
		if ( $this->input->get('bSearchable_'.$i) == "true" && $this->input->get('sSearch_'.$i) != '' )
		{
			if ( $sWhere == "" )
			{
				$sWhere = "WHERE ";
			}
			else
			{
				$sWhere .= " AND ";
			}
			$sWhere .= $aColumns[$i]." LIKE '%".mysql_real_escape_string($_GET['sSearch_'.$i])."%' ";
		}
	}
	
	$date_status	=	$this->input->get('date_status');
	$start_date		=	$this->input->get('start_date');
	$end_date		=	$this->input->get('end_date');
	$buy_status	=	$this->input->get('buy_status');
	
	if($date_status!=2)
	{
		if($start_date!="")
		{
			$date_set	=	explode("/",$start_date);
			$start_date	=	$date_set[2]."-".$date_set[1]."-".$date_set[0];
		
			if(empty($sWhere	))
			{
				$sWhere		=	" WHERE order_date >= '".$start_date." 00:00:00'";
			}else{
				$sWhere		.=	" AND order_date >= '".$start_date." 00:00:00'";
			}
		}
		if($end_date!="")
		{
			$date_set	=	explode("/",$end_date);
			$end_date	=	$date_set[2]."-".$date_set[1]."-".$date_set[0];
			if(empty($sWhere	))
			{
				$sWhere		=	" WHERE order_date <= '".$end_date." 23:59:59'";
			}else{
				$sWhere		.=	" AND order_date <= '".$end_date." 23:59:59'";
			}
		}
	}
	if($date_status==2)
	{
		if($start_date!="")
		{
			$date_set	=	explode("/",$start_date);
			$start_date	=	$date_set[2]."-".$date_set[1]."-".$date_set[0];
		
			if(empty($sWhere	))
			{
				$sWhere		=	" WHERE order_pay_date >= '".$start_date." 00:00:00'";
			}else{
				$sWhere		.=	" AND order_pay_date >= '".$start_date." 00:00:00'";
			}
		}
		if($end_date!="")
		{
			$date_set	=	explode("/",$end_date);
			$end_date	=	$date_set[2]."-".$date_set[1]."-".$date_set[0];
			if(empty($sWhere	))
			{
				$sWhere		=	" WHERE order_pay_date <= '".$end_date." 00:00:00'";
			}else{
				$sWhere		.=	" AND order_pay_date <= '".$end_date." 00:00:00'";
			}
		}
	}
	if($buy_status!="")
	{
		if(empty($sWhere	))
		{
			if($buy_status!=4)
			{
				$sWhere		.=	" WHERE order_status = ".$buy_status;
			}
		}else{
			if($buy_status!=4)
			{
				$sWhere		.=	" AND order_status = ".$buy_status;
			}
		}
	}
	
	$filter_id 		=	$this->input->get('filter_id');
	$filter_type 	=	$this->input->get('filter_type');
	
	if($filter_id != "")
	{
		if(empty($sWhere))
		{
			$pWhere	=	" WHERE ";
		}else{
			$pWhere	=	" AND ";
		}
		switch($filter_type)	
		{
			case 1:
				$sWhere .= $pWhere." od.vendor_id = ".$filter_id;
			break;
			case 2:
				$sWhere .= $pWhere." od.deal_id = ".$filter_id;
				break;
			case 3:
				$sWhere .= $pWhere." od.product_id = ".$filter_id;
				break;
			default:
				$sWhere .= $pWhere." o.mem_id = ".$filter_id;
		}
	}
	
	$sQuery = "
		SELECT ".str_replace(" , ", " ", implode(", ", $aColumns))."
		FROM   $sTable
		$sWhere
		group by o.order_id
		$sOrder
		$sLimit
	";
	
	$cQuery = "
		SELECT o.order_id
		FROM   $sTable
		$sWhere
		group by o.order_id
	";
	//echo $sQuery;
	
	$deal_order 	= $this->member_orderdetail->get_order_data($sQuery);
	$iFilteredTotal 	= $this->member_orderdetail->get_nOrder($cQuery);

	
	$iTotal =  $this->member_orderdetail->get_nOrder($cQuery);
	
	$output = array(
		"sEcho" => intval($this->input->get('sEcho')),
		"iTotalRecords" => $iTotal,
		"iTotalDisplayRecords" => $iFilteredTotal,
		"aaData" => array()
	);
	
	$admin_type		=	$this->input->get('admin_type');
	
	foreach($deal_order["order"] as $data)
	{
		$row 		= array();
		$row[] 	=	'<div align="center">'.$data["order_id"].'</div>';
		$row[] 	=	'<div align="center" class="deal_link"><a href="/mybackoffice/member_profile/view_data/'.$data["mem_id"].'" target="_blank">'.$data["mem_id"].'</a></div>';
		$row[] 	=	'<div align="left" class="deal_link"><a href="/mybackoffice/member_profile/view_data/'.$data["mem_id"].'" target="_blank">&nbsp;&nbsp;'.$data["member_name"].' &nbsp;&nbsp;'.$data["member_sname"].'</a></div>';
		
		$vender_name 	= 	"";
		$vender_id 			= 	"";
		$vendor_link		=	"";
		foreach($deal_order["order_detail"] as $datadetail)
		{
			if($data["order_id"] == $datadetail["order_id"])
			{
					$vender_name 	=  $datadetail["vendor_name"];
					$vender_id 			=  $datadetail["vendor_id"];
					$vendor_link		.=	'<div><a href="/mybackoffice/vendor_profile/view_data/'.$vender_id.'" target="_blank">*'.$vender_name.'</a></div>';
			}
		}
		
		$row[] 	=	'<div align="left" class="deal_link">'.$vendor_link.'</div>';
		
		$i = 0;
		$deal_name 	= "";
		$deal_id 			= "";
		foreach($deal_order["order_detail"] as $datadetail){
			if($data["order_id"] == $datadetail["order_id"]){
				if($i == 0)
				{
					$deal_name = "* ".$datadetail["deal_name"];
					$deal_id = "<a href=/category/deal_preview/".$datadetail["deal_id"]."/".urlencode($datadetail["deal_name"])." target='_blank'>".$deal_name."</a>";
				}else{ 
					$deal_name = "<br>"."* ".$datadetail["deal_name"];
					$deal_id .= "<a href=/category/deal_preview/".$datadetail["deal_id"]."/".urlencode($datadetail["deal_name"])." target='_blank'>".$deal_name."</a>";
				}
				$i++;
			}
		}
		$row[] 	=	'<div align="left" class="deal_link">'.$deal_id.'</div>';
		$row[] 	=	'<div align="center">'.date_format(date_create($data["order_date"]),"d/m/Y").'</div>';
		
		$show_order_date	=	"";
		 if(isset($data["order_pay_date"]) && $data["order_status"] == '2')
		 	$show_order_date	= date_format(date_create($data["order_pay_date"]),"d/m/Y");
		$row[] 	=	'<div align="center">'.$show_order_date.'</div>';
		$row[] 	=	'<div align="right">'.number_format ($data["order_summary"], 2).'&nbsp;&nbsp;&nbsp;</div>';
		$row[] 	=	'<div>$data["order_status"]</div>';
		
		$status	=	"";
		if ($data["order_status"]==0) 
			$status	= "ยกเลิก";
		elseif($data["order_status"]==1)
			$status	= "รอการชำระเงิน"; 
		elseif($data["order_status"]==2)
			$status	= "ชำระเงินแล้ว";
		elseif($data["order_status"]==3)
			$status	= "คืนเงิน";
							
		$row[] 	=	'<div align="center">'.$status.'</td>';

		$bank		=	"";
		
		if($data["payment_type"]=="1")
			$bank		= "ธนาคารกสิกรไทย";
		else if($data["payment_type"]=="2")
			$bank		= "ธนาคารไทยพาณิชย์";
		else if($data["payment_type"]=="3")
			$bank		= "ธนาคารกรุงเทพ";
		else if($data["payment_type"]=="4")
			$bank		= "ธนาคารกรุงศรีอยุธยา";
		else if($data["payment_type"]=="5")
			$bank		= "เคาร์เตอร์เซอร์วิท";
		else if($data["payment_type"]=="6")
			$bank		= "เทสโก้โลตัส";
		else if($data["payment_type"]=="7")
			$bank		= "บัตรเครดิต";
		else if($data["payment_type"]=="8")
			$bank		= "ไม่ต้องชำระเงิน";
		$row[] 	=	'<div align="center">'.$bank.'</div>';
		
		$manage = "";	
		$manage =	'<a href="/mybackoffice/deal_order/view_data/'.$data["order_id"].'/'.$data["mem_id"].'" alt="ดูรายละเอียด" title="ดูรายละเอียด">'.image_asset("payment/icon_bank.png").'</a>'; 
						if($data["order_status"]!=2)
						{
							$manage .=	' | <a class="fancybox fancybox.ajax" href="/mybackoffice/popup_payment/'.$data["order_id"].'">';
							$manage .=	image_asset("/icon/paid.png", "", array("alt"=>"แก้ไขสถานะเป็นชำระเงิน","title"=>"แก้ไขสถานะเป็นชำระเงิน"));
							$manage .=	'</a>'; 
					 	} 
						if($data["order_status"]==2)
						{
							$manage .=	' | <a href="/mybackoffice/deal_order/coupon/'.$data["order_id"].'/3" onclick="if(confirm(\'ต้องการปรับสถานะเลขใบสั่งซื้อ '.$data["order_id"].'เป็นคืนเงินแล้ว  ?\')){return true;}else{return false;};">';
							$manage .=	image_asset('/icon/repay.png', '', array('alt'=>'แก้ไขสถานะเป็นคืนเงิน','title'=>'แก้ไขสถานะเป็นคืนเงิน'));
							$manage .=	'</a>';
						}
						if($data["order_status"]!=0){
							$manage .=	' | <a href="/mybackoffice/deal_order/coupon/'.$data["order_id"].'/0" onclick="if(confirm(\'ต้องการยกเลิกการสั่งซื้อ รหัส '.$data["order_id"].' ?\')){return true;}else{return false;};">';
							$manage .=	image_asset('/icon/inactive.png', '', array('alt'=>'ยกเลิกการสั่งซื้อ','title'=>'ยกเลิกการสั่งซื้อ'));
							$manage .=	'</a>'; 
					 	}  
						if($admin_type!=3)
						{
							if($data["order_status"]!=2){
								$manage .=	' | <a href="/mybackoffice/deal_order/delete/'.$data["order_id"].'/0" onclick="if(confirm(\'คุณต้องการลบข้อมูลการสั่งซื้อ รหัส '.$data["order_id"].' ?\')){return true;}else{return false;};">';
								$manage .=	image_asset('/icon/delete.png', '', array('alt'=>'ลบข้อมูลการสั่งซื้อ','title'=>'ลบข้อมูลการสั่งซื้อ'));
								$manage .=	'</a>';
					 		}
						}  	
		$row[] 	=	'<div align="center">'.$manage.'</div>';					
		$output['aaData'][] = $row;
	}
	
	echo json_encode( $output );
	
	}
	public function vendor_profile($sub_page = '', $row_id = '') {
		$this->check_admin_login();
		//start config
		$page_title 		= ":: ข้อมูลร้านค้า ::";
		$page_header 	= ":: ข้อมูลร้านค้า ::";

		$base_table 			= "tbl_vendor_profile";
		$base_table_main 	= "tbl_province_data";
		$base_url 				= "/mybackoffice/vendor_profile";
		$base_menu 			= "Vendor Profile";
		$base_pk 				= 'vendor_id';
		$base_table_ref 	= 'province_id';
		$base_status_ref 	= 'province_status';
		
		$d_now = date("Y-m-d H:i:s"); 

		$vendor_email = $this -> input -> post('vendor_email');
		
		// password เข้ารหัส base64
		$pwd 			= 	$this -> input -> post('vendor_pwd');
		$vendor_pwd =  base64_encode($pwd);
		
		$data	=	$this -> input -> post();
		if(!empty($data["vendor_pwd"]))
		{
			$data["vendor_pwd"]		=	base64_encode($data["vendor_pwd"]);
		}else{
			unset($data["vendor_pwd"]);	
		}
		unset($data["submit"]);
		unset($data["vendor_confirm_pwd"]);
		$this -> generate_vendor_page($sub_page, $row_id, $page_title, $page_header, $base_table, $base_table_main, $base_table_ref, $base_status_ref, $base_url, $base_menu, $base_pk, $data);
	}

	public function province($sub_page = '', $row_id = '') {
		$this->check_admin_login();
		//start config
		$page_title = ":: ข้อมูลจังหวัด ::";
		$page_header = ":: ข้อมูลจังหวัด ::";

		$base_table = "tbl_province_data";
		$base_url = "/mybackoffice/province";
		$base_menu = "จังหวัด";
		$base_pk = 'province_id';

		$province_name = $this -> input -> post('province_name');
		$province_status = $this -> input -> post('province_status');

		$data = array('province_name' => $province_name, 'province_status' => $province_status);
		//end config

		$this -> generate_page($sub_page, $row_id, $page_title, $page_header, $base_table, $base_url, $base_menu, $base_pk, $data);
	}

	public function category($sub_page = '', $row_id = '') {
		$this->check_admin_login();
		//start config
		$page_title = ":: ข้อมูลหมวดหมู่หลัก ::";
		$page_header = ":: ข้อมูลหมวดหมู่หลัก ::";

		$base_table = "tbl_category_main";
		$base_url = "/mybackoffice/category";
		$base_menu = "หมวดการดีล";
		$base_pk = 'cat_id';

		$cat_name = $this -> input -> post('cat_name');
		$cat_status = $this -> input -> post('cat_status');

		$data = array('cat_name' => $cat_name, 'cat_status' => $cat_status);
		//end config

		$this -> generate_page($sub_page, $row_id, $page_title, $page_header, $base_table, $base_url, $base_menu, $base_pk, $data);
	}

	public function category_sub($sub_page = '', $row_id = '') {
		$this->check_admin_login();
		//start config
		$page_title = ":: ข้อมูลหมวดหมู่ย่อย ::";
		$page_header = ":: ข้อมูลหมวดหมู่ย่อย ::";

		$base_table = "tbl_category_sub";
		$base_table_main = "tbl_category_main";
		$base_url = "/mybackoffice/category_sub";
		$base_menu = "หมวดการดีลย่อย";
		$base_pk = 'sub_cat_id';
		$base_table_ref = 'cat_id';
		$base_status_ref = 'cat_status';

		$sub_cat_name = $this -> input -> post('sub_cat_name');
		$cat_id = $this -> input -> post('cat_id');
		$sub_cat_status = $this -> input -> post('sub_cat_status');

		$data = array('sub_cat_name' => $sub_cat_name, 'cat_id' => $cat_id, 'sub_cat_status' => $sub_cat_status);
		//end config

		$this -> generate_category_page($sub_page, $row_id, $page_title, $page_header, $base_table, $base_table_main, $base_table_ref, $base_status_ref, $base_url, $base_menu, $base_pk, $data);
	}
private function get_db_date($date)
{
	$data	=	explode("/",$date);
	return $data[2]."-".$data[1]."-".$data[0]." 00:00:00";
}
private function get_db_date_12($date)
{
	$data	=	explode("/",$date);
	return $data[2]."-".$data[1]."-".$data[0]." 12:00:00";
}
public function deal_main($sub_page = '', $row_id = '',$vendor_id="") {
	$this->check_admin_login();
		//start config
		$base_table_ref = array();
		
		$page_title 		= ":: ข้อมูลดีล ::";
		$page_header 	= ":: ข้อมูลดีล ::";

		$base_table = "tbl_deal_main";
		$base_table_ref[0]["tb"] 	= "tbl_category_main";
		$base_table_ref[1]["tb"]  	= "tbl_category_sub";
		$base_table_ref[2]["tb"]  	= "tbl_vendor_profile";
		
		$base_url 		= "/mybackoffice/deal_main";
		$base_menu 	= "ดีลหลัก";
		$base_pk 		= 'deal_id';
		
		$base_table_ref[0]["pk"] = 'cat_id';
		$base_table_ref[1]["pk"] = 'sub_cat_id';
		$base_table_ref[2]["pk"] = 'vendor_id';
		
		$base_table_ref[0]["status"] = 'cat_status';
		$base_table_ref[1]["status"]  = 'sub_cat_status';
		$base_table_ref[2]["status"]  = 'vendor_status';
		
		$data	=	$this -> input -> post();

		$this -> generate_deal_page($sub_page, $row_id, $page_title, $page_header, $base_table, $base_table_ref, $base_url, $base_menu, $base_pk, $data,$vendor_id);
	}
	public function deal_gallery($deal_id,$sub_page = '', $row_id = '') 
	{
		$this->check_admin_login();
		//start config

		$page_title 		= ":: จัดการข้อมูลแกลลอรี่ ::";
		$page_header 	= ":: จัดการข้อมูลแกลลอรี่ ::";

		$base_table 	= "tbl_deal_gallery";
		$base_url 		= "/mybackoffice/deal_gallery/".$deal_id;
		$base_menu 	= "แกลลอรี่";
		$base_pk = 'pic_id';
		
		$this->load->model("deal_main");
		
		$view_data 	= array();
		$view_data	=	$this->deal_main->get_deal_by_id($deal_id);
		
		switch ($sub_page) {
			case 'insert_form' :
				$view_data['page_action'] 	=	$base_url.'/insert/';
				$view_data['manage_title'] = 	"เพิ่มข้อมูล " . $base_menu;
				
				$this -> page_data["content"] = $this -> load -> view('/mybackoffice/deal_gallery/form.php', $view_data, true);
				break;

			case 'insert' :
				$nPic	=	1;
				 
				while(true)
				{
					$index	=	"gallary_image_".$nPic;
					if(!isset($_FILES[$index])||$nPic>100)
					{
						break;
					}else{
						$upload_path							=	'deal/'.($deal_id%10).'/'.$deal_id."/deal_slide";
						$type_image							=	explode("/",$_FILES[$index]["type"]);
						
						if(!isset($type_image[1]))	break;
						
						$file_name								= 	"gallary_".$deal_id."_".time()."_".$nPic.".".$type_image[1];
				
						$thumb['width']			=	200;
						$thumb['height']			=	120;
						$thumb['save_path']	=	$upload_path;
						$thumb['pic_name']	=	$file_name;
							
						$this->do_upload($upload_path,$file_name,$index);
						
						$data["deal_id"]						=	$deal_id;
						$data["pic_path"]					=	'upload/'.$upload_path.'/'.$file_name;
						$data["pic_order"]					=	$nPic;
						
						$this -> db -> insert($base_table, $data);
						$this->xlog_admin->save_log($this->admin_id,"2121","deal_id = ".$deal_id);
					}
					$nPic++;
				}

				echo "<script>window.location.href='" . $base_url . "'</script>";

				unset($data);
				return 0;
				break;

			case 'delete' :
				$pic_path	= $this->input->post("pic_path");
				unlink($_SERVER["DOCUMENT_ROOT"]."/assets/images/".$pic_path);
				
				$row_id		= $this->input->post("pic_id");
				$this -> db -> where($base_pk, $row_id);
				$this -> db -> delete($base_table);
				$this->xlog_admin->save_log($this->admin_id,"2123","id = ".$row_id);
				echo "<script>window.location.href='" . $base_url . "'</script>";
				echo 1;
				return 0;
				break;
			
			default :
				$query = $this -> db -> get_where($base_table,array("deal_id"=>$deal_id));
				$view_data["deal_gallery"] = $query -> result_array();
				
				$this -> page_data["content"] = $this -> load -> view('/mybackoffice/deal_gallery/main.php', $view_data, true);
				break;
		}

		$this -> page_data["page_title"] 			= $page_title;
		$this -> page_data["page_header"] 	= $page_header;
		$this -> render -> page_render($this -> page_data);

		unset($view_data);
	}
	public function deal_slide($deal_id,$sub_page = '', $row_id = '') 
	{
		$this->check_admin_login();
		//start config

		$page_title 		= ":: จัดการข้อมูลสไลด์ ::";
		$page_header 	= ":: จัดการข้อมูลสไลด์ ::";

		$base_table 	= "tbl_deal_slide";
		$base_url 		= "/mybackoffice/deal_slide/".$deal_id;
		$base_menu 	= "สไลด์";
		$base_pk = 'pic_id';
		
		$this->load->model("deal_main");
		
		$view_data 	= array();
		$view_data	=	$this->deal_main->get_deal_by_id($deal_id);
		
		switch ($sub_page) {
			case 'insert_form' :
				$view_data['page_action'] 	=	$base_url.'/insert/';
				$view_data['manage_title'] = 	"เพิ่มข้อมูล " . $base_menu;
				
				$this -> page_data["content"] = $this -> load -> view('/mybackoffice/deal_slide/form.php', $view_data, true);
				break;

			case 'insert' :
				$nPic	=	1;
				 
				while(true)
				{
					$index	=	"slide_image_".$nPic;
					if(!isset($_FILES[$index])||$nPic>100)
					{
						break;
					}else{
						$upload_path							=	'deal/'.($deal_id%10).'/'.$deal_id."/deal_slide";
						$type_image							=	explode("/",$_FILES[$index]["type"]);
						
						if(!isset($type_image[1]))	break;
						
						$file_name								= 	"slide_".$deal_id."_".time()."_".$nPic.".".$type_image[1];
			
						$resize						=	array();
						$resize['width']			=	625;
						$resize['height']			=	350;
						$resize['save_path']	=	$upload_path;
						$resize['pic_name']	=	$file_name;
						
						$this->do_upload($upload_path,$file_name,$index,$resize);
						
						$data["deal_id"]					=	$deal_id;
						$data["pic_path"]					=	'upload/'.$upload_path.'/'.$file_name;
						$data["pic_order"]				=	$nPic;
									
						$this -> db -> insert($base_table, $data);
						$this->xlog_admin->save_log($this->admin_id,"2131","deal_id = ".$deal_id);
					}
					$nPic++;
				}
				echo "<script>window.location.href='" . $base_url . "'</script>";

				unset($data);
				return 0;
				break;

			case 'delete' :
				$pic_path	= $this->input->post("pic_path");
				unlink($_SERVER["DOCUMENT_ROOT"]."/assets/images/".$pic_path);
				
				$row_id		= $this->input->post("pic_id");
				$this -> db -> where($base_pk, $row_id);
				$this -> db -> delete($base_table);
				$this->xlog_admin->save_log($this->admin_id,"2133","id = ".$row_id);
				
				echo "<script>window.location.href='" . $base_url . "'</script>";
				echo 1;
				return 0;
				break;
			
			default :
				$query = $this -> db -> get_where($base_table,array("deal_id"=>$deal_id));
				$view_data["deal_slide"] = $query -> result_array();
				
				$this -> page_data["content"] = $this -> load -> view('/mybackoffice/deal_slide/main.php', $view_data, true);
				break;
		}

		$this -> page_data["page_title"] 			= $page_title;
		$this -> page_data["page_header"] 	= $page_header;
		$this -> render -> page_render($this -> page_data);

		unset($view_data);
	}
public function home_slide($sub_page = '', $row_id = '') 
	{
		$this->check_admin_login();
		//start config

		$page_title 		= ":: สไลด์โปรโมชั่น ::";
		$page_header 	= ":: สไลด์โปรโมชั่น ::";

		$base_table 	= "tbl_promotion_slide";
		$base_url 		= "/mybackoffice/home_slide";
		$base_menu 	= "โปรโมชั่น";
		$base_pk = 'promotion_id';
		
		switch ($sub_page) {
			case 'insert_form' :
				$view_data['page_action'] 	=	$base_url.'/insert/';
				$view_data['manage_title'] = 	"เพิ่มข้อมูล " . $base_menu;
				$view_data['action']			=	"insert";
				
				$this -> page_data["content"] = $this -> load -> view('/mybackoffice/home_slide/form.php', $view_data, true);
				break;
			case 'update_form' :
				$query = $this -> db -> get_where($base_table, array($base_pk => $row_id));
				$view_data = $query -> row_array();
				
				$view_data['page_action'] 	=	$base_url.'/update/'.$row_id;
				$view_data['manage_title'] = 	"แก้ไขข้อมูล " . $base_menu;
				$view_data['action']			=	"update";
				
				$this -> page_data["content"] = $this -> load -> view('/mybackoffice/home_slide/form.php', $view_data, true);
				break;
				
				case 'insert' :
					$data		=	$this->input->post();
					$thumb		=	array();
					unset($data["submit"]);
					$index		=	'pic_path';
					if(isset($_FILES[$index]))
					{
						$upload_path							=	'home_slide/large';
						$type_image							=	explode("/",$_FILES[$index]["type"]);
						
						if(isset($type_image[1]))	
						{
							$save_time		=	time();	
							$file_name			= 	$save_time."_large.".$type_image[1];
			
							$thumb_name			= 	$save_time.".".$type_image[1];
							
							$thumb['width']			=	150;
							$thumb['height']			=	59;
							$thumb['save_path']	=	"home_slide/thumb";
							$thumb['pic_name']	=	$thumb_name;
							
							$resize						=	array();
							$resize['width']			=	1024;
							$resize['height']			=	400;
							$resize['save_path']	=	"home_slide/large";
							$resize['pic_name']	=	$file_name;
							
							
							$this->do_upload($upload_path,$file_name,$index,$resize,$thumb);
						
							$data["pic_path"]				=	'upload/'.$upload_path.'/'.$file_name;
							$data['thumb_path']			=	'upload/home_slide/thumb/'.$thumb_name;
							$this -> db -> insert($base_table, $data);
							$this->xlog_admin->save_log($this->admin_id,"2091");
						}
					}
					
				echo "<script>window.location.href='" . $base_url . "'</script>";

				unset($data);
				return 0;
				break;
				
				case 'update' :
					$data		=	$this->input->post();
					$thumb		=	array();
					unset($data["submit"]);
					$index		=	'pic_path';
					
					if(isset($_FILES[$index]))
					{
						$upload_path							=	'home_slide/large';
						$type_image							=	explode("/",$_FILES[$index]["type"]);
						
						if(isset($type_image[1]))	
						{
							$this->db->select("pic_path");
							$this->db->where($base_pk, $row_id);	
							$query 		= $this->db->get($base_table);
			
							$pic_data	= $query->row_array();
							
							//print_r($pic_data);
							
							$pic_path	=	$pic_data["pic_path"];
							
							unlink($_SERVER["DOCUMENT_ROOT"]."/assets/images/".$pic_path);
							$thumb_path	=	str_replace("large", 'thumb', $pic_path);
							unlink($_SERVER["DOCUMENT_ROOT"]."/assets/images/".$thumb_path);
							
							$save_time				=	time();	
							$file_name					=	$save_time."_large.".$type_image[1];
			
							$thumb_name			= 	$save_time.".".$type_image[1];
							
							$thumb['width']			=	150;
							$thumb['height']			=	59;
							$thumb['save_path']	=	"home_slide/thumb";
							$thumb['pic_name']	=	$thumb_name;
							
							$resize						=	array();
							$resize['width']			=	1024;
							$resize['height']			=	400;
							$resize['save_path']	=	"home_slide/large";
							$resize['pic_name']	=	$file_name;
							
							
							$this->do_upload($upload_path,$file_name,$index,$resize,$thumb);
						
							$data["pic_path"]				=	'upload/'.$upload_path.'/'.$file_name;
							$data['thumb_path']			=	'upload/home_slide/thumb/'.$thumb_name;
				 			
						}
							$this -> db -> where($base_pk, $row_id);
							$this -> db -> update($base_table, $data);
							$this->xlog_admin->save_log($this->admin_id,"2092","id = ".$row_id);
					}
					//echo "ok";
					echo "<script>window.location.href='" . $base_url . "'</script>";
				
				unset($data);
				return 0;
				break;
				
				case 'delete' :
				$pic_path	= $this->input->post("pic_path");
				unlink($_SERVER["DOCUMENT_ROOT"]."/assets/images/".$pic_path);
				$thumb_path	=	str_replace("large", 'thumb', $pic_path);
				unlink($_SERVER["DOCUMENT_ROOT"]."/assets/images/".$thumb_path);
				
				$row_id		= $this->input->post("pic_id");
				$this -> db -> where($base_pk, $row_id);
				$this -> db -> delete($base_table);
				$this->xlog_admin->save_log($this->admin_id,"2093","id = ".$row_id);
				//echo "<script>window.location.href='" . $base_url . "'</script>";
				echo 1;
				return 0;
				break;
			
			default :
				$this->db->order_by('promotion_status desc,pic_order asc'); 
				$query = $this -> db -> get($base_table);
				
				$view_data["promotion"] = $query -> result_array();
				
				$this -> page_data["content"] = $this -> load -> view('/mybackoffice/home_slide/main.php', $view_data, true);
				break;
		}

		$this -> page_data["page_title"] 			= $page_title;
		$this -> page_data["page_header"] 	= $page_header;
		$this -> render -> page_render($this -> page_data);

		unset($view_data);
	}


public function deal_product($sub_page='',$row_id='',$deal_id='') {
	$this->check_admin_login();
		//start config
		$page_title 		= ":: ข้อมูลแคมเปญ ::";
		$page_header 	= ":: ข้อมูลแคมเปญ ::";

		$base_table 			= "tbl_deal_product";
		$base_table_main 	= "tbl_deal_main";
		$base_url 				= "/mybackoffice/deal_product";
		$base_menu 			= "การจัดการข้อมูลสินค้า";
		$base_pk 				= 'product_id';
		$base_table_ref 	= 'deal_id';
		$base_status_ref 	= '';
		
		 /*
		$deal_id 				= $this -> input -> post('deal_id');
		$product_detail 		= $this -> input -> post('product_detail');
		$product_price 		= $this -> input -> post('product_price');
		$product_status 		= $this -> input -> post('product_status');
		*/
		
		$d_now = date("Y-m-d H:i:s");
		
		$view_data = array();

		switch ($sub_page) 
		{
			case 'insert_form' :
			
				$view_data['action_status']	=	"insert";
				$view_data['page_action'] = $base_url . '/insert/';
				$view_data['manage_title'] = "เพิ่มข้อมูล " . $base_menu;
				
				if(!empty($deal_id))
				{
					$view_data["deal_id"]				= $deal_id;
					$vendor = $this->vendor_profile->get_vendor_profile_by_dealid($deal_id);
					
				if($vendor["vendor_name"] == "")
						$view_data["vendor_name"] = "-";
					else 
						$view_data["vendor_name"] = $vendor["vendor_name"];
				}
				
				if ($base_status_ref != "")
						$this -> db -> where($base_status_ref, '1');
					
				if($base_table_main=="tbl_province_data")
				{
					$this->db->order_by("province_name","ASC");
				}
				$query = $this -> db -> get($base_table_main);
				$view_data[$base_table_main] = $query -> result_array();

				$this -> page_data["content"] = $this -> load -> view($base_url . '/form.php', $view_data, true);
				break;

			case 'update_form' :
				$this->load->model('deal_product');
				$view_data 	= $this->deal_product->get_all_product_by_product_id($row_id);
				//print_r($view_data);
				
				$view_data['action_status']	=	"update";
				$view_data['page_action'] 	= $base_url . '/update/' . $row_id;
				$view_data['manage_title'] = "แก้ไขข้อมูล " . $base_menu;

				$query = $this -> db -> get($base_table_main);
				$view_data[$base_table_main] = $query -> result_array();

				$this -> page_data["content"] = $this -> load -> view($base_url . '/form.php', $view_data,true);
				
				break;

			case 'insert' :
				$this->load->model("deal_main");
				
				$data	=	$this->input->post();
				$data["product_create"]			=	date("Y-m-d H:i:s");
				$data["product_modify"]			=	date("Y-m-d H:i:s");
				
				if($data["product_rd_limit"] == 0)
					$data["product_limit"] = 0;
				
				unset($data["submit"]);
				
				$this -> db -> insert($base_table, $data);
				$this->xlog_admin->save_log($this->admin_id,"2031");

			if(empty($deal_id))
				{
					echo "<script>window.location.href='" . $base_url . "'</script>";
				}else{
					echo "<script>window.location.href='" . $base_url . "/main/0/".$deal_id."'</script>";
				}
				$this->deal_main->update_deal_price($data["deal_id"]);
				unset($data);
				return 0;
				break;

			case 'update' :
				$this->load->model("deal_main");
				
				$data	=	$this->input->post();
				$data["product_modify"]			=	date("Y-m-d H:i:s");
				
				unset($data["submit"]);
				
				$this -> db -> where($base_pk, $row_id);
				$this -> db -> update($base_table, $data);
				$this->xlog_admin->save_log($this->admin_id,"2032",$base_pk." = ".$row_id);
				
				if(empty($deal_id))
				{
					echo "<script>window.location.href='" . $base_url . "'</script>";
				}else{
					echo "<script>window.location.href='" . $base_url . "/main/0/".$deal_id."'</script>";
				}
				$this->deal_main->update_deal_price($data["deal_id"]);
				unset($data);
				return 0;
				break;

			case 'delete' :
				$this -> db -> where($base_pk, $row_id);
				$this -> db -> delete($base_table);
				$this->xlog_admin->save_log($this->admin_id,"2033",$base_pk." = ".$row_id);
				
				if(empty($deal_id))
				{
					echo "<script>window.location.href='" . $base_url . "'</script>";
				}else{
					echo "<script>window.location.href='" . $base_url . "/main/0/".$deal_id."'</script>";
				}
				$this->deal_main->update_deal_price($data["deal_id"]);
				return 0;
				break;
			case 'view_data':
				$this->load->model('deal_product');
				$view_data 	= $this->deal_product->get_product_all_by_product_id($row_id);
				
				$view_data['action_status']	=	"view";
				$view_data['page_action'] 	= 	$base_url . '/view/';
				$view_data['manage_title'] = 	"แสดงข้อมูล " . $base_menu;
					
				if($base_table_main=="tbl_province_data")
				{
					$this->load->model('province_data');
					$view_data["province_data"]	=	$this->province_data->get_provicne_by_id($view_data["province_id"]);
				}
				
				$this -> page_data["content"] = $this -> load -> view($base_url . '/view.php', $view_data, true);
			break;
			default :
				$view_data = array();
				$this->load->model('deal_product');
				
				$product = $this->deal_product->get_product_by_deal_id($deal_id);
				$product_id	=	array();
				
				foreach($product as $index=>$data)
				{
						$product_id[$index]	=	$data["product_id"];		
				}
				
				if(empty($deal_id))
				{
					$view_data["deal_product"] 	= $this->deal_product->get_product_all();	
					$view_data["coupon"] 	= $this->coupon_main->get_coupon_summary();	
				}else{
					$view_data["deal_product"] 	= $this->deal_product->get_product_by_deal_id($deal_id);
					$view_data["deal_id"]				= $deal_id;
					$view_data["vendor"]		 		= $this->vendor_profile->get_vendor_profile_by_dealid($deal_id);
					$view_data["coupon"] 			= $this->coupon_main->get_coupon_summary();	
				}	
				
				$this -> page_data["content"] = $this -> load -> view($base_url . '/main.php', $view_data, true);
				break;
		}

		$this -> page_data["page_title"] = $page_title;
		$this -> page_data["page_header"] = $page_header;
		$this -> render -> page_render($this -> page_data);

		unset($view_data);
}

private function generate_order_page($sub_page, $row_id,$status, $page_title, $page_header, $base_url, $base_menu,$filter_id="",$filter_type="") {
		$view_data = array();

		switch ($sub_page) {
			case 'coupon' :
				$st  = substr($status, 0,1);
				$d_now = date("Y-m-d H:i:s");
				if ($st == 2) // เปลี่ยนสถานะเป็นชำระเงินเรียบร้อยแล้ว
				{
					$this->load->model("deal_order");
					$this->load->model("member_orderdetail");
					$this->load->model("coupon_main");
					
					$coupon_count	=	$this->coupon_main->get_coupon_duplicate($row_id);
					if($coupon_count == 0)  // ถ้าเคยออกคูปองแล้วจะไม่ออกซ้ำ
					{
							$pre_receive_id	=	$this->deal_order->get_pre_receive_id();
							$payment  = substr($status, 1,1);
							$data = array('o.order_status' => $st,
														'o.order_modify' => $d_now,
														'o.order_pay_date' => $d_now,
														'o.payment_type' => $payment,
														'o.receipt_id' => $pre_receive_id);
							$this -> db -> where('o.order_id', $row_id);
							$this -> db -> update('tbl_deal_order o', $data);
							$this->xlog_admin->save_log($this->admin_id,"2044","order_id=".$row_id);
							
							$order_data	=	$this->deal_order->get_order_by_id($row_id);
							
							$order_id		=	$order_data["order_id"];
							$member_id	=	$order_data["mem_id"];
							
							$this->load->library('email');
		
							
							$view_data["order"]					=	$this->member_orderdetail->ShowOrderDetail($order_id,$member_id);
							$view_data["order_date"]			=	$this->convert_date->show_thai_date($view_data["order"]["order"]["order_date"])." เวลา ".date("H:i:s",strtotime($view_data["order"]["order"]["order_date"]))." น.";
						
							$member_email 	=	$view_data["order"]["member"]["member_email"];
							
							$this->email->from('support@thebestdeal1.com', 'TheBestDeal1');
							$this->email->to($member_email); 
							$this->email->subject("TheBestDeal1.com - ใบแจ้งการชำระเงิน เลขที่ ".$order_data["receipt_id"]." สำหรับคำสั่งซื้อเลขที่ ".$order_data["order_id"]);
				
			
							$this->load->model('member_orderDetail');
							$content_data								=	array();
							$content_data["order_data"]			=	$this->member_orderDetail->ShowOrderDetail($order_id,$member_id);
							$content_data["not_show_detail"]	=	1;
							
							switch($payment)
							{
								case 0:
									$view_data["payment"] = "";
								break;
								case 1:
									$view_data["payment"] = $this -> load -> view('how2pay/kbank.php',$content_data,true);
								break;
								case 2:
									$view_data["payment"] = $this -> load -> view('how2pay/scbbank.php',$content_data,true);
								break;
								case 3:
									$view_data["payment"] = $this -> load -> view('how2pay/bblbank.php',$content_data,true);
								break;
								case 4:
									$view_data["payment"] = $this -> load -> view('how2pay/ksbank.php',$content_data,true);
								break;
								case 5:
									$view_data["payment"] = $this -> load -> view('how2pay/counter_service.php',$content_data,true);
								break;
								case 6:
									$view_data["payment"] = $this -> load -> view('how2pay/tesco_lotus.php',$content_data,true);
								break;
								case 7:
									$view_data["payment"] = $this -> load -> view('how2pay/online.php',$content_data,true);
								break;
							}
				
							$body		=	$this -> load -> view('mail/mail_coupon.php',$view_data,true);
			
							$this->email->message($body);	
		
							$this->email->send();
							
						//send email to back office
						$this->email->from('support@thebestdeal1.com', 'TheBestDeal1');
						$this->email->to('coupon@thebestdeal1.com'); 
						$this->email->subject("TheBestDeal1.com - ใบแจ้งการชำระเงิน เลขที่ ".$order_data["receipt_id"]." สำหรับคำสั่งซื้อเลขที่ ".$order_data["order_id"]);
						$this->email->message($body);	
						$this->email->send();
						
						$this->db->select('o.order_id,o.mem_id,od.deal_id,od.product_id,d.deal_start,d.deal_expile,od.product_qty,od.product_id,od.order_detail_id');
						$this->db->from('tbl_deal_order o');
						$this->db->join('tbl_deal_order_detail od', 'od.order_id = o.order_id', 'inner');
						$this->db->join('tbl_deal_main d', 'd.deal_id = od.deal_id', 'left');
						$where	=	array("o.order_id"=>$row_id);
						$this->db->where($where);
						$query = $this->db->get();
						$coupon_data = $query -> result_array();
						
						foreach($coupon_data as $coupon){
							for($i=0;$i<$coupon["product_qty"];$i++)
							{
								if(strlen($coupon["product_id"])<6)
								{
										$product_id = $coupon["product_id"];
										for($j=strlen($coupon["product_id"]);$j<6;$j++)
											$product_id = "0". $product_id;
								}	
								$qty_product 	= $this->coupon_main->get_product_qty($product_id);
								
								if(strlen($qty_product)<6)
								{
										$qty = $qty_product;
										for($j=strlen($qty_product);$j<6;$j++)
											$qty = "0". $qty;
								}
								
								$voucher_number = $product_id."-".$qty;
								$redemption_code = rand(1000,9999);
								
								$data 	= array('mem_id' => $coupon["mem_id"], 
														'order_id' => $coupon["order_id"], 
														'deal_id' => $coupon["deal_id"],
														'product_id' => $coupon["product_id"], 
														'coupon_can_use' => $coupon["deal_start"],
														'coupon_expire' =>$coupon["deal_expile"],
														'voucher_number' =>$voucher_number,
														'redemption_code' =>$redemption_code,
														'coupon_status' => '1',
														 'coupon_create_time' => $d_now,
														 'order_detail_id'=>$coupon["order_detail_id"]
														 );
								$this -> db -> insert('tbl_coupon', $data);
								unset($data);
							}
							
							//generate barcode
							$coupon_barcode =  $this->coupon_main->get_coupon_barcode($row_id);
							foreach($coupon_barcode as $bc){
								if(strlen($bc["coupon_id"])<8)
								{
										$coupon_c = $bc["coupon_id"];
										for($j=strlen($bc["coupon_id"]);$j<8;$j++)
											$coupon_c = "0". $coupon_c;
								}
								
								$price =str_replace(".", "", $bc["product_price"]);
								if(strlen($price)<8)
								{
										$coupon_price = $price;
										for($j=strlen($price);$j<8;$j++)
											$coupon_price = "0". $coupon_price;
								}
								$barcode = $coupon_c.$coupon_price;
								$this->coupon_main->update_coupon_barcode($bc["coupon_id"],$barcode);
							}
						}
					}
				}else{  // เปลี่ยนสถานะเป็นคืนเงิน หรือ ยกเลิก
					$data = array('o.order_status' => $status,'o.order_modify' => $d_now);
					
					$this -> db -> where('o.order_id', $row_id);
					$this -> db -> update('tbl_deal_order o', $data);
					if($status==0)
					{
						$this->xlog_admin->save_log($this->admin_id,"2045","order_id=".$row_id);
					}else{
						$this->xlog_admin->save_log($this->admin_id,"2046","order_id=".$row_id);
					}
					$this -> db -> where('order_id', $row_id);
					$this -> db -> delete('tbl_coupon');
				}
				unset($data);
				echo "<script>window.location.href='" . $base_url . "'</script>";
				return 0;
				break;
				
				case 'cancel' :
				
					$d_now = date("Y-m-d H:i:s");
					$data = array('order_status' => '0','order_modify' => $d_now);
					
					$this -> db -> where('order_id', $row_id);
					$this -> db -> update('tbl_deal_order', $data);
					$this->xlog_admin->save_log($this->admin_id,"2045","order_id=".$row_id);
					
					echo "<script>window.location.href='" . $base_url . "'</script>";
				
				return 0;
				
				case 'delete' :
					$this -> db -> where('order_id', $row_id);
					$this -> db -> delete('tbl_deal_order');
					
					$this -> db -> where('order_id', $row_id);
					$this -> db -> delete('tbl_deal_order_detail');
					
					$this -> db -> where('order_id', $row_id);
					$this -> db -> delete('tbl_coupon');
					
					$this->xlog_admin->save_log($this->admin_id,"2043","order_id=".$row_id);
					
					echo "<script>window.location.href='" . $base_url . "'</script>";
				
				return 0;
				break;
		case 'view_data':
				$this->load->model('member_orderDetail');
				
				$content_data["order_data"]	=	$this->member_orderDetail->ShowOrderDetail($row_id,$status);
				$content_data["back_page"]	= $this->session->userdata('back_page');
				
				switch($content_data["order_data"]["order"]["payment_type"])
				{
					case 0:
					case 8:
						$content_data["payment"] = "No Payment Required";
					break;
					case 1:
						$content_data["payment"] = $this -> load -> view('how2pay/kbank.php',$content_data,true);
					break;
					case 2:
						$content_data["payment"] = $this -> load -> view('how2pay/scbbank.php',$content_data,true);
					break;
					case 3:
						$content_data["payment"] = $this -> load -> view('how2pay/bblbank.php',$content_data,true);
					break;
					case 4:
						$content_data["payment"] = $this -> load -> view('how2pay/ksbank.php',$content_data,true);
					break;
					case 5:
						$content_data["payment"] = $this -> load -> view('how2pay/counter_service.php',$content_data,true);
					break;
					case 6:
						$content_data["payment"] = $this -> load -> view('how2pay/tesco_lotus.php',$content_data,true);
					break;
					case 7:
						$content_data["payment"] = $this -> load -> view('how2pay/online.php',$content_data,true);
					break;
				}
		
				$this->page_data["content"]		=	$this -> load -> view('mybackoffice/deal_order/admin_orderDetail.php',$content_data,true);
			break;
			
			case 'mem_order' :
				$view_data = array();
				$this->load->model('member_orderDetail');
				$view_data["deal_order"]		=	$this->member_orderDetail->ShowOrderMember($row_id);
				$this->session->set_userdata('back_page',$sub_page."/".$row_id);
				$this -> page_data["content"] = $this -> load -> view($base_url . '/main.php', $view_data, true);
				break;
				
			default :
				$view_data = array();
				$this->load->model('member_orderDetail');
				$view_data["deal_order"]		=	$this->member_orderDetail->ShowOrderMember($filter_id,$filter_type);
				$view_data["sub_page"] = "";
				$view_data["filter_id"]	=	$filter_id;
				$view_data["filter_type"]	=	$filter_type;
				$view_data["admin_type"]	=	$this->admin_type;
				$this->session->set_userdata('back_page',"");
				$this -> page_data["content"] = $this -> load -> view($base_url . '/main.php', $view_data, true);
				break;
		}

		$this -> page_data["page_title"] = $page_title;
		$this -> page_data["page_header"] = $page_header;
		$this -> render -> page_render($this -> page_data);

		unset($view_data);
	}

public function popup_payment($order_id)
{
		$view_data["order_id"]	=	$order_id;
		$this -> load -> view('mybackoffice/deal_order/popup_payment.php',$view_data);
}
private function generate_deal_page($sub_page, $row_id, $page_title, $page_header, $base_table, $base_table_ref, $base_url, $base_menu, $base_pk, $data,$vendor_id="") {
		$view_data = array();
				//print_r($data);
		switch ($sub_page) {
			case 'insert_form' :
				if(empty($vendor_id))
				{
					$view_data['page_action'] 	=	$base_url.'/insert/';
				}else{
					$view_data['page_action'] 	=	$base_url.'/insert/0/'.$vendor_id;
				}
				$view_data['manage_title'] 	= 	"เพิ่มข้อมูล " . $base_menu;
				$view_data['action'] 			= 	'insert';
				$view_data['vendor_id'] 		=	$vendor_id;
				$view_data['round_action']	=	"insert"; 
				foreach($base_table_ref as $tbrf)
				{		
						$this -> db -> where($tbrf['status'], '1');
						$query = $this -> db -> get($tbrf['tb']);
						$view_data[$tbrf['tb']] = $query -> result_array();
				}
					
				$this->db->order_by("province_name","ASC");
				$query = $this -> db -> get("tbl_province_data");
				$view_data["tbl_province_data"] = $query -> result_array();

				$this -> page_data["content"] = $this -> load -> view($base_url . '/form.php', $view_data, true);
				break;

			case 'update_form' :
				
				$this->load->model("vendor_profile");
				$query = $this -> db -> get_where($base_table, array($base_pk => $row_id));
				$view_data 		= $query -> row_array();
				$vendor_id			=	$view_data["vendor_id"];
				
				$view_data['action'] 			= 'update';
				
				$vendor_data							=	$this->vendor_profile->get_vendor_profile_by_id($vendor_id);
				$view_data["vendor_name"]	=	"";
				
				if(isset($vendor_data["vendor_name"]))
				$view_data["vendor_name"]	=	$vendor_data["vendor_name"];
			
				if(empty($vendor_id))
				{
					$view_data['page_action'] 		= $base_url .'/update/'.$row_id;
				}else{
					$view_data['page_action'] 		= $base_url .'/update/'.$row_id."/".$vendor_id;
				}
				
				$view_data['manage_title'] 		= "แก้ไขข้อมูล " . $base_menu;
				
				foreach($base_table_ref as $tbrf)
				{		
						$this -> db -> where($tbrf['status'], '1');
						$query = $this -> db -> get($tbrf['tb']);
						$view_data[$tbrf['tb']] = $query -> result_array();
				}
				
				$this->db->order_by("province_name","ASC");
				$query = $this -> db -> get("tbl_province_data");
				$view_data["tbl_province_data"] = $query -> result_array();
				
				$round_action	=	"";
				
				$this->db->select("round_id,round_start,round_end");
				$this->db->from("tbl_deal_round");
				$this->db->where("deal_id",$row_id);
				$this->db->order_by("round_id","ASC");
				
				$query = $this->db->get();
				$round_data	=	$query->result_array();
				
				$round_history	=	array();
				
				$i	=	0;
				foreach($round_data as $round)
				{
					$i++;
					$round_history[$i]	=	$round;	
				}
				if($i>0)
				{
					if(strtotime($round_history[$i]["round_end"])>time())
					{
						$view_data["round_start"]		=	$round_history[$i]["round_start"];
						$view_data["round_end"]		=	$round_history[$i]["round_end"];
						$view_data["round_id"]			=	$round_history[$i]["round_id"];
						unset($round_history[$i]);
					
						$round_action						=	"update";
						
					}else{
						$view_data["round_start"]		=	"";
						$view_data["round_end"]		=	"";
						$round_action	=	"insert";
					}
				}else{
					$view_data["round_start"]		=	"";
					$view_data["round_end"]		=	"";
					$round_action	=	"insert";
				}
				
				$view_data["round_history"]	=	$round_history;
				$view_data["round_action"]		=	$round_action;	
				
				$this -> page_data["content"] = $this -> load -> view($base_url . '/form.php', $view_data, true);
				break;

			case 'insert' :
				unset($data["submit"]);
				unset($data["data_form"]);
				
				$this->load->model("deal_main");
				$data["deal_id"]						=	$this->deal_main->get_deal_id();	
				$deal_id								=	$data["deal_id"];	

				$data["deal_buy_time_start"]	=	$this->get_db_date_12($data["deal_buy_time_start"]);
				$data["deal_buy_time_end"]	=	$this->get_db_date_12($data["deal_buy_time_end"]);
				
				$data["deal_start"]					=	$this->get_db_date($data["deal_start"]);
				$data["deal_expile"]				=	$this->get_db_date($data["deal_expile"]);
				$data["deal_create"]				=	date("Y-m-d H:i:s",time());
				$data["deal_modify"]				=	date("Y-m-d H:i:s",time());
				
				$round_data	=	array();
				$round_data["deal_id"]			=	$deal_id;
				$round_data["round_start"]		=	$this->get_db_date_12($data["round_start"]);
				$round_data["round_end"]		=	$this->get_db_date_12($data["round_end"]);
				
				unset($data["round_start"]);
				unset($data["round_end"]);
				
				$upload_path							=	'deal/'.($deal_id%10).'/'.$deal_id;
				$input_name							=	"deal_index_image";
				
				if(!empty($_FILES[$input_name]["type"]))
				{
					$type_image					=	explode("/",$_FILES[$input_name]["type"]);
					$file_name						= 	"deal_index_image.".$type_image[1];
				
					$resize							=	array();
					$resize['width']					=	360;
					$resize['height']				=	245;
					$resize['save_path']			=	$upload_path;
					$resize['pic_name']			=	$file_name;
					
					$thumb_name					= 	"deal_index_image_large.".$type_image[1];
					
					$thumb							=	array();
					$thumb['width']				=	625;
					$thumb['height']				=	345;
					$thumb['save_path']			=	$upload_path;
					$thumb['pic_name']			=	$thumb_name;
						
					$thumb_name_2				= 	"deal_index_image.".$type_image[1];
					
					$thumb_2						=	array();
					$thumb_2['width']				=	200;
					$thumb_2['height']			=	100;
					$thumb_2['save_path']		=	$upload_path;
					$thumb_2['pic_name']		=	$thumb_name_2;
					
					$this->do_upload($upload_path,$file_name,$input_name,$resize,$thumb,$thumb_2);
					
					chmod($_SERVER["DOCUMENT_ROOT"]."/assets/images/upload/".$upload_path."/".$file_name,0777);
					chmod($_SERVER["DOCUMENT_ROOT"]."/assets/images/upload/".$upload_path."/deal_index_image_large_thumb.".$type_image[1],0777);
					chmod($_SERVER["DOCUMENT_ROOT"]."/assets/images/upload/".$upload_path."/deal_index_image_thumb.".$type_image[1],0777);
					
					$data["deal_index_image"]		=	'upload/deal/'.($deal_id%10).'/'.$deal_id.'/'.$file_name;
				}

				$input_name							=	"deal_map";
				
				if(!empty($_FILES[$input_name]["type"]))
				{
					$type_image							=	explode("/",$_FILES[$input_name]["type"]);
					$file_name								= 	"deal_map.".$type_image[1];
				
					$resize							=	array();
					$resize['width']					=	550;
					$resize['height']				=	400;
					$resize['save_path']			=	$upload_path;
					$resize['pic_name']			=	$file_name;
					
					$this->do_upload($upload_path,$file_name,$input_name,$resize);
				
					$data["deal_map"]		=	'upload/deal/'.($deal_id%10).'/'.$deal_id.'/'.$file_name;
				}else{
					if(isset($data["show_deal_map"]))
					{
						$data["deal_map"]		=	$data["show_deal_map"];
					}
				}
				if(isset($data["show_deal_map"]))
				{
					unset($data["show_deal_map"]);
				}
				$this -> db -> insert($base_table, $data);
				$this -> db -> insert("tbl_deal_round",$round_data);
				$this->xlog_admin->save_log($this->admin_id,"2021","deal_id = ".$deal_id);
				
				echo "<script>window.location.href='" . $base_url ."/main/0/".$vendor_id. "'</script>";
				unset($data);
				return 0;
				break;

			case 'update' :
				unset($data["submit"]);
				unset($data["data_form"]);
				
				$data["deal_buy_time_start"]	=	$this->get_db_date_12($data["deal_buy_time_start"]);
				$data["deal_buy_time_end"]	=	$this->get_db_date_12($data["deal_buy_time_end"]);
				
				$data["deal_start"]					=	$this->get_db_date($data["deal_start"]);
				$data["deal_expile"]				=	$this->get_db_date($data["deal_expile"]);
				$data["deal_modify"]				=	date("Y-m-d H:i:s",time());
				
				$deal_id								=	$row_id;	
				
				$round_data	=	array();
				$round_data["deal_id"]			=	$deal_id;
				$round_data["round_start"]		=	$this->get_db_date_12($data["round_start"]);
				$round_data["round_end"]		=	$this->get_db_date_12($data["round_end"]);
				
				$round_action						=	$data["round_action"];
				$round_id								=	"";
				
				if($round_action=="update")
				{
					$round_id								=	$data["round_id"];
				}
				
				unset($data["round_id"]);
				unset($data["round_action"]);
				unset($data["round_start"]);
				unset($data["round_end"]);
				
				if($round_action=="insert")
				{
					//print_r($round_data);
					$this -> db -> insert("tbl_deal_round",$round_data);
					
					$this->load->library('email');
					
					$view_data["iwantit"]		=	$this->iwantit-> get_iwantit_deal($round_data["deal_id"]);
					
					foreach($view_data["iwantit"] as $iwantit)
					{
								$this->email->from('sale@thebestdeal1.com', 'TheBestDeal1');
								$this->email->to($iwantit["email"]);
								$this->email->subject("TheBestDeal1.com – ดีลที่คุณอยากซื้อ เปิดให้สั่งซื้อแล้ว ".$data["deal_name"]);
					
							$msg		=	"<br/><br/>";
						
							if(isset($iwantit["member_name"]))
									$msg		.= "สวัสดีคุณ ".$iwantit["member_name"]."  ".$iwantit["member_sname"]." <br/><br/>";
							else 
								   $msg		.= "สวัสดีคุณ ".$iwantit["email"]." <br/><br/>";
							
							$msg		.= "<a href='www.thebestdeal1.com/category/deal/".$round_data["deal_id"]."/".$data["deal_name"]."'>".$data["deal_name"]."</a> ขณะนี้ดีลที่คุณอยากซื้อ ขณะนี้ เปิดให้สั่งซื้อแล้ว <br/><br/>".
							"<table border='0' cellspacing='0' cellpadding='0'>".
							"<tr><td colspan='2'><a href='www.thebestdeal1.com/category/deal/".$round_data["deal_id"]."/".$data["deal_name"]."'><img src='www.thebestdeal1.com/assets/images/".$iwantit["deal_index_image"]."' width='200' height='205'/></a></td></tr>".
							"<tr style='background-color:black; color:white;'>".
							"<td width='140px' height='30px'><a href='www.thebestdeal1.com/category/deal/".$round_data["deal_id"]."/".$data["deal_name"]."'>  &nbsp;&nbsp;".$data["deal_name"]."</a></td>".
							"<td align='right'><a href='www.thebestdeal1.com/category/deal/".$round_data["deal_id"]."/".$data["deal_name"]."'><img src='www.thebestdeal1.com/assets/images/next.png' width='30'/>&nbsp;</a></td></tr>".
							"</table><br/><br/>".
							"ดีลนี้จะปิดการสั่งซื้อใน เวลา  ".$round_data["round_start"]." <br/><br/>".
							"คุณสามารถค้นหา <a href='www.thebestdeal1.com'>ดีลราคาถูกอื่นๆ </a> เพิ่มเติมตลอด 24 ชั่วโมง  ได้ที่  <a href='www.thebestdeal1.com'>www.thebestdeal1.com</a>"."<br/><br/>".
							"ขอบคุณที่ให้การไว้วางใจ<br/>".
							"ทีมงาน TheBestDeal1.com <br/><br/>";
							$view_data["content"]	=	$msg;
					
							$body	=	$this -> load -> view('template/email_template.php',$view_data, true);					
							$this->email->message($body);	
			
							$this->email->send();
					}
				}else{
					$this->db->where('round_id', $round_id);
					$this->db->update("tbl_deal_round",$round_data);
				}
				
				$input_name							=	"deal_index_image";
				
				$upload_path							=	'deal/'.($deal_id%10).'/'.$deal_id;
				if(!empty($_FILES[$input_name]["type"]))
				{
					$type_image							=	explode("/",$_FILES[$input_name]["type"]);
					$file_name								= 	"deal_index_image.".$type_image[1];
					
					if(strtolower($type_image[1])=="jpg"||strtolower($type_image[1])=="jpeg"||strtolower($type_image[1])=="gif"||strtolower($type_image[1])=="png")
					{
						if(file_exists($upload_path."/".$file_name))
						{
							unlink($upload_path."/".$file_name);
						}
						
						if(file_exists($upload_path."/deal_index_image_large.".$type_image[1]))
						{
							unlink($upload_path."/deal_index_image_large.".$type_image[1]);
						}
						
						if(file_exists($upload_path."/deal_index_image.".$type_image[1]))
						{
							unlink($upload_path."/deal_index_image.".$type_image[1]);
						}
						
						$resize							=	array();
						$resize['width']					=	360;
						$resize['height']				=	245;
						$resize['save_path']			=	$upload_path;
						$resize['pic_name']			=	$file_name;
					
						$thumb_name					= 	"deal_index_image_large.".$type_image[1];
					
						$thumb							=	array();
						$thumb['width']				=	625;
						$thumb['height']				=	345;
						$thumb['save_path']			=	$upload_path;
						$thumb['pic_name']			=	$thumb_name;
						
						$thumb_name_2				= 	"deal_index_image.".$type_image[1];
					
						$thumb_2						=	array();
						$thumb_2['width']				=	200;
						$thumb_2['height']			=	100;
						$thumb_2['save_path']		=	$upload_path;
						$thumb_2['pic_name']		=	$thumb_name_2;
					
						$this->do_upload($upload_path,$file_name,$input_name,$resize,$thumb,$thumb_2);
				
						chmod($_SERVER["DOCUMENT_ROOT"]."/assets/images/upload/".$upload_path."/".$file_name,0777);
						chmod($_SERVER["DOCUMENT_ROOT"]."/assets/images/upload/".$upload_path."/deal_index_image_large_thumb.".$type_image[1],0777);
						chmod($_SERVER["DOCUMENT_ROOT"]."/assets/images/upload/".$upload_path."/deal_index_image_thumb.".$type_image[1],0777);
					
						//echo $_SERVER["DOCUMENT_ROOT"]."/assets/images/upload/".$upload_path."/deal_index_image_large_thumb".$type_image[1];
						
						$data["deal_index_image"]		=	'upload/deal/'.($deal_id%10).'/'.$deal_id.'/'.$file_name;
					}
				}
				
				$input_name							=	"deal_map";
				
				if(!empty($_FILES[$input_name]["type"]))
				{
					$type_image							=	explode("/",$_FILES[$input_name]["type"]);
					$file_name								= 	"deal_map.".$type_image[1];
					if(strtolower($type_image[1])=="jpg"||strtolower($type_image[1])=="jpeg"||strtolower($type_image[1])=="gif"||strtolower($type_image[1])=="png")
					{
						if(file_exists($upload_path."/".$file_name))
						{
							unlink($upload_path."/".$file_name);
						}
						
						$this->do_upload($upload_path,$file_name,$input_name);
				
						$data["deal_map"]		=	'upload/deal/'.($deal_id%10).'/'.$deal_id.'/'.$file_name;
					}
				}else{
					if(isset($data["show_deal_map"]))
					{
						$data["deal_map"]		=	$data["show_deal_map"];
					}
				}
				if(isset($data["show_deal_map"]))
				{
					unset($data["show_deal_map"]);
				}
				
				$this -> db -> where($base_pk, $row_id);
				$this -> db -> update($base_table, $data);
				$this->xlog_admin->save_log($this->admin_id,"2022",$base_pk." = ".$row_id);
				unset($data);
				echo "<script>window.location.href='" . $base_url ."/main/0/".$vendor_id. "'</script>";
				return 0;
				break;

			case 'delete' :
				if($this->admin_type==1||$this->admin_type==2)
				{
					$this -> db -> where($base_pk, $row_id);
					$this -> db -> delete($base_table);
					$this->xlog_admin->save_log($this->admin_id,"2023",$base_pk." = ".$row_id);
				}
					echo "<script>window.location.href='" . $base_url ."/main/0/".$vendor_id. "'</script>";
				return 0;
				break;

			default :
				$view_data = array();
				$this->load->model('deal_main');
				$this->load->model('category_main');
				$this->load->model("category_sub");
				$this->load->model('vendor_profile');
				
				if(!empty($vendor_id))
				{
					$view_data["deal_data"]		=	$this->deal_main-> get_deal_by_vendor_id($vendor_id);
					$view_data["vendor_id"]		=	$vendor_id;
					$view_data["vendor"]	 		= $this->vendor_profile->get_vendor_profile_by_id($vendor_id);
				}else{
					$view_data["deal_data"]		=	$this->deal_main->get_all_deal();
				}
				$deal_option	=	array();
				
				foreach($view_data["deal_data"] as $data_deal)
				{
					$index			=	$data_deal["deal_id"];
					
					$sql				=	"	SELECT round_start,round_end 
												FROM tbl_deal_round
												WHERE deal_id = '".$index."'
												ORDER BY round_id DESC
												LIMIT 0,1
											";
					$query = $this->db->query($sql);

 	 				$round_data 	= $query->row_array(); 

					$sql				=	"	SELECT sum(dt.product_qty) as nOrder
												FROM tbl_deal_order od
												LEFT JOIN tbl_deal_order_detail dt ON od.order_id = dt.order_id
												WHERE dt.deal_id = '".$index."'
												AND od.order_status = 2
												AND od.order_date >= '".$round_data["round_start"]."'
												AND od.order_date <= '".$round_data["round_end"]."' 
												GROUP BY dt.deal_id
											";
					$query = $this->db->query($sql);

 	 				$order_data 	= $query->row_array(); 

					$sql				=	"	SELECT count(c.coupon_id) as nCoupon
												FROM tbl_coupon c 
												LEFT JOIN tbl_deal_order od ON (c.order_id = od.order_id)
												WHERE c.deal_id = '".$index."'
												AND od.order_date >= '".$round_data["round_start"]."'
												AND od.order_date <= '".$round_data["round_end"]."' 
												GROUP BY c.deal_id
											";
					$query = $this->db->query($sql);

 	 				$coupon_data 	= $query->row_array(); 

					$deal_option[$index]["now_round_start"]		=	"";
					$deal_option[$index]["now_round_end"]		=	"";
					$deal_option[$index]["now_order"]				=	0;
					$deal_option[$index]["now_coupon"]			=	0;

					$deal_option[$index]["now_round_start"]		=	$round_data["round_start"];
					$deal_option[$index]["now_round_end"]		=	$round_data["round_end"];	
					
					if(!empty($order_data["nOrder"])&&isset($order_data["nOrder"]))			
					$deal_option[$index]["now_order"]				=	$order_data["nOrder"];
					
					if(!empty($coupon_data["nCoupon"])&&isset($coupon_data["nCoupon"]))
					$deal_option[$index]["now_coupon"]			=	$coupon_data["nCoupon"];
					
				}
				
				$view_data["deal_option"]		=	$deal_option;
				
				$view_data["cat_data"]			= 	$this->category_main->get_all_category();
				$view_data["sub_cat_data"]	= 	$this->category_sub->get_all_category_sub();
				$view_data["vendor_data"]		= 	$this->vendor_profile->get_all_vendor_profile();
				$view_data["admin_type"]		=	$this->admin_type;
				
				$this -> page_data["content"] = $this -> load -> view($base_url . '/main.php', $view_data, true);

				break;
		}

		$this -> page_data["page_title"] = $page_title;
		$this -> page_data["page_header"] = $page_header;
		$this -> render -> page_render($this -> page_data);

		unset($view_data);
	}

	//public function deal_order($sub_page = '', $row_id = '',$senddata='',$start_date='',$end_date='',$buy_status='') 
	public function deal_order($sub_page = '', $row_id = '',$senddata='',$data_id="",$data_type="") 
	{
		$this->check_admin_login();
		//start config
		$base_table_ref = array();
		
		$page_title 		= ":: ข้อมูลการสั่งซื้อ ::";
		$page_header 	= ":: ข้อมูลการสั่งซื้อ ::";

		$base_url 		= "/mybackoffice/deal_order";
		$base_menu 	= "ข้อมูลการสั่งซื้อ";
		
		//end config
		$this -> generate_order_page($sub_page, $row_id,$senddata, $page_title, $page_header, $base_url, $base_menu,$data_id,$data_type);
	}
	private function generate_coupon_page($sub_page, $row_id, $page_title, $page_header, $base_url, $base_menu,$filter_id="",$filter_type="") {
		$view_data = array();

		switch ($sub_page) {
			default :
				$view_data = array();

				$this->db->select('c.coupon_id,c.order_id,m.merber_id,m.member_name,m.member_sname,d.deal_name,
													c.coupon_can_use,c.coupon_expire,c.coupon_use_date,c.redemption_code,c.coupon_status');
				$this->db->from('tbl_coupon c');
				$this->db->join('tbl_member_profile m', 'm.member_id = c.mem_id', 'left');
				$this->db->join('tbl_deal_main d', 'c.deal_id = d.deal_id', 'left');
				$query = $this->db->get();
				$view_data["coupon"] = $query -> result_array();
				
				$this -> page_data["content"] = $this -> load -> view($base_url . '/main.php', $view_data, true);
				break;
		}

		$this -> page_data["page_title"] = $page_title;
		$this -> page_data["page_header"] = $page_header;
		$this -> render -> page_render($this -> page_data);

		unset($view_data);
	}

	public function coupon_manage($sub_page = '', $row_id = '',$data_id="",$data_type="") {
		$this->check_admin_login();
		//start config
		$base_table_ref = array();
		
		$page_title = ":: ข้อมูลคูปอง ::";
		$page_header = ":: ข้อมูลคูปอง ::";

		$base_url = "/mybackoffice/coupon_manage";
		$base_menu = "ข้อมูลคูปอง";

		$view_data = array();

		switch ($sub_page) {
				default :
				$this->load->model('member_coupon');
				$view_data["coupon_data"]		=		$this->member_coupon->get_all_coupon($data_id,$data_type);
				$view_data["filter_id"]			=	$data_id;
				$this -> page_data["content"] = $this -> load -> view($base_url . '/main.php', $view_data, true);
				break;
		}

		$this -> page_data["page_title"] = $page_title;
		$this -> page_data["page_header"] = $page_header;
		$this -> render -> page_render($this -> page_data);

		unset($view_data);
	}
	
	private function do_upload($upload_path,$file_name,$input_name,$resize=array(),$thumb=array(),$thumb2=array())
	{
		$target_path = $_SERVER["DOCUMENT_ROOT"]."/assets/images/upload/".$upload_path."/";

		if(!is_dir($target_path))
		{
			mkdir($target_path);
			chmod($target_path,0777);
		}
		$target_path = $target_path.$file_name; 

		//echo $target_path."<br>";
		
		move_uploaded_file($_FILES[$input_name]['tmp_name'], $target_path);
		chmod($target_path,0777);
		
		if(sizeof($thumb)>0)
		{
			$config['image_library'] 		= 'gd2';
			$config['source_image'] 		= $target_path;
			$config['new_image'] 		= $_SERVER["DOCUMENT_ROOT"]."/assets/images/upload/".$thumb["save_path"]."/".$thumb["pic_name"];
			$config['create_thumb'] 	= TRUE;
			$config['maintain_ratio'] 		= FALSE;
			$config['width'] 				= $thumb["width"];
			$config['height'] 				= $thumb["height"];

			$this->image_lib->initialize($config); 

			$this->image_lib->resize();
			if(file_exists($config['new_image']))
			{
				chmod($config['new_image'],0777);
			}
		}			
		if(sizeof($thumb2)>0)
		{
			$config['image_library'] 		= 'gd2';
			$config['source_image'] 		= $target_path;
			$config['new_image'] 		= $_SERVER["DOCUMENT_ROOT"]."/assets/images/upload/".$thumb2["save_path"]."/".$thumb2["pic_name"];
			$config['create_thumb'] 	= TRUE;
			$config['maintain_ratio'] 		= FALSE;
			$config['width'] 				= $thumb2["width"];
			$config['height'] 				= $thumb2["height"];

			$this->image_lib->initialize($config); 

			$this->image_lib->resize();
			
			if(file_exists($config['new_image']))
			{
				chmod($config['new_image'],0777);
			}
		}			
		if(sizeof($resize)>0)
		{
			$config['image_library'] 	= 'gd2';
			$config['source_image'] 	= $target_path;
			$config['new_image'] 		= $_SERVER["DOCUMENT_ROOT"]."/assets/images/upload/".$resize["save_path"]."/".$resize["pic_name"];
			$config['maintain_ratio'] 	= FALSE;
			
			$config['width'] 				= $resize["width"];
			$config['height'] 			= $resize["height"];
			
			$this->image_lib->initialize($config); 

			if ( ! $this->image_lib->resize())
			{
    			echo $this->image_lib->display_errors();	
			}
			
			if(file_exists($config['new_image']))
			{
				chmod($config['new_image'],0777);
			}
			
		}	
		$this->image_lib->clear();
	}

	public function logout()
	{
				$cookie = array(
	    				'name'   => 'admin_auto_login_id',
	    				'value'  =>'',
	    				'expire' => '0',
	    				'domain' => '',
	    				'path'   => '/',
	    				'prefix' => '',
	   	 				'secure' => FALSE
					);
					$this->input->set_cookie($cookie);
					
					$cookie_type = array(
	    				'name'   => 'admin_auto_login_type',
	    				'value'  =>'',
	    				'expire' => '0',
	    				'domain' => '',
	    				'path'   => '/',
	    				'prefix' => '',
	   	 				'secure' => FALSE
					);
					$this->input->set_cookie($cookie_type);
			
			$this->session->unset_userdata('admin_id');
			$this->session->unset_userdata('back_page');
			
			$this->xlog_admin->save_log($this->admin_id,"1002");
			echo '
			<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
			<html xmlns:fb="http://ogp.me/ns/fb#">
			<head>
				<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
				<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
				<meta http-equiv="Cache-control" content="no-cache">
			</head>
			<body>
				<script>window.location.href = "/mybackoffice";</script>
			</body>
			</html>
			';
	}
	public function print_coupon($deal_id,$coupon_id,$member_id)
	{
		$this->check_admin_login();
		
		$this->load->model('coupon_main');
		
		$this->page_data["page_title"]	=	"The Best Deal One ::คูปอง";
		
		$coupon								= $this->coupon_main->get_coupon($member_id,$deal_id,$coupon_id);
		
		$coupon_data["deal_id"]			=	$deal_id;
		$coupon_data["deal_name"]	=	$coupon["deal_main"]["deal_name"];
		$coupon_data["fine_print"] 		= $coupon["deal_main"]["deal_main_detail"];
		$coupon_data["vendor_logo"]	=	$coupon["deal_main"]["vendor_logo"];
		$coupon_data["location"] 		= $coupon["deal_main"]["location"];
		$coupon_data["deal_main_condition"] = $coupon["deal_main"]["deal_main_condition"];
		$coupon_data["vendor_email"] 			= $coupon["deal_main"]["vendor_email"];
		$coupon_data["vendor_website"] 		= $coupon["deal_main"]["vendor_website"];
		$coupon_data["mem_name"]				=	$coupon["member"]["member_name"]."   ".$coupon["member"]["member_sname"];
		$coupon_data["member_id"]				=	$coupon["member"]["member_id"];
		$coupon_data["barcode"]					=	$coupon["coupon"]["barcode"];
		$coupon_data["coupon_id"]					=	$coupon["coupon"]["coupon_id"];
		$coupon_data["voucher_number"] 		= $coupon["coupon"]["voucher_number"];
		$coupon_data["order_id"]					=	$coupon["coupon"]["order_id"];
		$coupon_data["redemption_code"]		=	$coupon["coupon"]["redemption_code"];
		$coupon_data["product_name"] 			= $coupon["coupon"]["product_name"];
		$coupon_data["product_detail"] 			= $coupon["coupon"]["product_detail"];
		$coupon_data["coupon_can_use"] 		= $coupon["coupon"]["coupon_can_use"];
		$coupon_data["coupon_expire"] 			= $coupon["coupon"]["coupon_expire"];
	
		$this->xlog_admin->save_log($this->admin_id,"2053","coupon = ".$coupon_data["coupon_id"]);
	
		$this -> load -> view('member/printcoupon.php',$coupon_data);
	}
	private function clear_text_editor($text)
	{
		$text = str_replace('&nbsp;',' ',$text);
		$text = str_replace('&bull;',"•",$text);
		$text = str_replace('&ndash;','-',$text);
		$text = str_replace('&amp;','&',$text);
		$text = str_replace("<br />","\n",$text);
		$text	= strip_tags($text);
		
		return $text;
	}
					function thai_date($time)
				{
					    global $thai_month_arr;  
						
						$thai_month_arr=array(  
							    "0"=>"",  
							    "1"=>"ม.ค.",  
							    "2"=>"ก.พ.",  
							    "3"=>"มี.ค.",  
							    "4"=>"เม.ย.",  
							    "5"=>"พ.ค.",  
							    "6"=>"มิ.ย.",   
							    "7"=>"ก.ค.",  
							    "8"=>"ส.ค.",  
							    "9"=>"ก.ย.",  
							    "10"=>"ต.ค.",  
							    "11"=>"พ.ย.",  
							    "12"=>"ธ.ค."                    
						);  
				
					    $thai_date_return=  " ".date("j",$time);  
					    $thai_date_return.= " ".$thai_month_arr[date("n",$time)];  
					    $thai_date_return.= " ".(date("Y",$time));  
					    return $thai_date_return;  
				}  
				
	private function create_ex_coupon($vendor_id)
	{
			$pdf	=	new PDF_Code128();
			 
			// เพิ่มฟอนต์ภาษาไทยเข้ามา ตัวธรรมดา กำหนด ชื่อ เป็น angsana
			$pdf->AddFont('angsana','','angsa.php');
			 
			// เพิ่มฟอนต์ภาษาไทยเข้ามา ตัวหนา  กำหนด ชื่อ เป็น angsana
			$pdf->AddFont('angsana','B','angsab.php');
			 
			$pdf->AddFont('angsana','I','angsai.php');
			$pdf->AddFont('angsana','BI','angsaz.php');
			 
			//สร้างหน้าเอกสาร
			$pdf->AddPage();
			 
			$sql	=	"	SELECT sc.deal_start,
									sc.deal_expile,
									sc.round_start,
									sc.round_end,
									sc.deal_name,
									p.product_name,
									p.product_detail,
									v.vendor_id,
									v.vendor_name,
									v.vendor_contact_fname,
									v.vendor_contact_sname,
									v.vendor_email,
									v.vendor_address,
									v.vendor_website,
									v.vendor_logo,
									v.vendor_map,
									v.vendor_about_us,
									v.vendor_pay_type,
									d.deal_main_detail,
									d.deal_main_condition
						FROM view_sell_coupon sc
						LEFT JOIN tbl_vendor_profile v ON sc.vendor_id	=	v.vendor_id
						LEFT JOIN tbl_deal_product p ON p.deal_id = sc.deal_id
						LEFT JOIN tbl_deal_main d ON sc.deal_id = d.deal_id
						WHERE v.vendor_id = '".$vendor_id."'
						ORDER BY sc.round_id DESC
						LIMIT 0,1";
			$query 	= $this->db->query($sql);
		
			$data 	= $query->row_array();
			
			$year	=	(date("Y",time())+543);
			$year	=	substr($year,2);
					
			$deal_name				=	$data["deal_name"];
			$vendor_logo				=	$data["vendor_logo"];
			$location 					= 	$data["vendor_address"];
			$fine_print 				= 	$data["deal_main_detail"];
			$deal_main_condition = 	$data["deal_main_condition"];
			$vendor_email 			= 	$data["vendor_email"];
			$vendor_website 		= 	$data["vendor_website"];
			$mem_name				=	"คุณ xxxxxxxxxxx xxxxxxxxxxxxx";
			$member_id				=	$year."0000xx";
			$coupon					=	"1";
			
			$coupon_c					=	"0000".rand("1000","9999");
						
			$coupon_price 			=	"00".rand("1000","9999")."00";
			$barcode 					= $coupon_c.$coupon_price;
						
			$voucher_number 		= 	$vendor_id."-0000xx";
			$order_id					=	$year.date("m",time())."0000xx";
			$redemption_code		=	rand("1111","9999");
			$product_name 			= 	$data["product_name"];
			$product_detail 			= 	$data["product_detail"];
			$coupon_can_use 		= 	$data["deal_start"];
			$coupon_expire 			= 	$data["deal_expile"];
				
			$coupon_can_use_full	=	$this->thai_date(strtotime(date_format(date_create($coupon_can_use),"Y-m-d")));   
			$coupon_expire_full	=	$this->thai_date(strtotime(date_format(date_create($coupon_expire),"Y-m-d")));   
					
			unset($coupon_data);
			
					$image1 = " ../../assets/images/company_logo.png";
					$pdf->Image($image1, $pdf->GetX(), $pdf->GetY(), 30);
					
					$Line_V = " ../../assets/images/Line_Vertical.png";
					$pdf->Image($Line_V, 100, 0, 1.6);
					
					$Line_H = " ../../assets/images/Line_H.png";
					$pdf->Image($Line_H, 0, 105, 180);
					
					// กำหนดฟอนต์
					$pdf->SetFont('angsana','',11);
					// พิมพ์ข้อความลงเอกสาร
					$pdf->setXY( 10, 33  );
					//$pdf->MultiCell( 70  , 4 , iconv( 'UTF-8','cp874' , $product_detail),0,'L' );
					
					$pdf->SetFont('angsana','',9);
					$pdf->Ln(3);
					$pdf->MultiCell( 70 , 4 , iconv( 'UTF-8','cp874' , $deal_name."   # ".$product_name));
					
					$pdf->setXY( 10, 59  );
					$pdf->MultiCell( 0  , 0 , iconv( 'UTF-8','cp874' , 'PURCHASED BY:') );
					
					$pdf->setXY( 10, 69  );
					$pdf->MultiCell( 0  , 0 , iconv( 'UTF-8','cp874' , 'VOUCHER NUMBER:' ) );
					
					$pdf->setXY( 40, 69  );
					$pdf->MultiCell( 0  , 0 , iconv( 'UTF-8','cp874' , 'ORDER ID:' ) );
					
					$pdf->SetFont('angsana','',11);
					$pdf->setXY( 10, 81  );
					$pdf->MultiCell( 0  , 0 , iconv( 'UTF-8','cp874' , 'CUSTOMER ID:' ) );
					
					$pdf->setXY( 40, 81  );
					$pdf->MultiCell( 0  , 0 , iconv( 'UTF-8','cp874' , 'REDEMPTION CODE:' ) );
					
					$pdf->SetFont('angsana','',11);
					$pdf->setXY( 10, 63  );
					$pdf->MultiCell( 0  , 0 , iconv( 'UTF-8','cp874' , $mem_name) );
					
					$pdf->SetFont('angsana','',15);
					$pdf->setXY( 10, 73  );
					$pdf->MultiCell( 0  , 0 , iconv( 'UTF-8','cp874' , $voucher_number) );
					
					$pdf->setXY( 40, 73  );
					$pdf->MultiCell( 0  , 0 , iconv( 'UTF-8','cp874' , $order_id) );
					
					$pdf->SetFont('angsana','',13);
					$pdf->setXY( 10, 85  );
					$pdf->MultiCell( 0  , 0 , iconv( 'UTF-8','cp874' , $member_id ) );
					
					$pdf->setXY( 40, 85  );
					$pdf->MultiCell( 0  , 0 , iconv( 'UTF-8','cp874' , $redemption_code) );
					
					// วาดรูปกรอกสี่เหลี่ยม
					$pdf->SetDrawColor(195,195,195);
					$pdf->SetLineWidth(0.2835);
					$pdf->Rect(107, 19, 70, 23 , 'D');
					
					if(!empty($barcode))
					{
						$pdf->Code128(116,22,$barcode,52,11);
						$pdf->SetFont('angsana','',10);
					
						$pdf->setXY( 156, 35);
						$pdf->MultiCell( 0  , 0 , iconv( 'UTF-8','cp874' , 'BARCODE' ) );
					
						$pdf->setXY( 148, 38);
						$pdf->MultiCell( 0  , 0 , iconv( 'UTF-8','cp874' , $barcode ) );
					}
					
					$pdf->SetFont('angsana','',10);
					$pdf->setXY( 110, 48 );
					$pdf->MultiCell( 0  , 0 , iconv( 'UTF-8','cp874' , 'สงวนสิทธิ์ไม่คืนเงินสำหรับคูปองที่ไม่ได้ใช้งานในระยะเวลา' ) );
					
					$pdf->SetFont('angsana','',11);
					$pdf->setXY( 110, 55 );
					$pdf->MultiCell( 0  , 0 , iconv( 'UTF-8','cp874' , 'VALID FROM:' ) );
					
					$pdf->SetFont('angsana','',20);
					$pdf->SetTextColor(255, 0, 0);
					$pdf->setXY( 109, 60 );
					$pdf->MultiCell( 0  , 0 , iconv( 'UTF-8','cp874' , $coupon_can_use_full.' to '.$coupon_expire_full) );
					
					// วาดรูปกรอกสี่เหลี่ยม
					$pdf->SetDrawColor(195,195,195);
					$pdf->SetLineWidth(0.2835);
					$pdf->Rect(107, 68, 70,31 , 'D');
					
					$pdf->SetFont('angsana','',14);
					$pdf->SetTextColor(0, 0, 0);
					$pdf->setXY(130, 71 );
					$pdf->MultiCell( 0  , 0 , iconv( 'UTF-8','cp874' , 'Need Assistance?' ) );
					
					$pdf->SetFont('angsana','',9);
					$pdf->setXY(116, 76);
					$pdf->MultiCell( 0  , 0 , iconv( 'UTF-8','cp874' , 'Call Thebestdeal1 : 02 938 4399 | Email : info@thebestdeal1.com' ) );
					
					$image2 = " ../../assets/images/thebestdeal1.png";
					$pdf->Image($image2, 123, 79, 15);
					
					$image3 = " ../../assets/images/facebook.png";
					$pdf->Image($image3, 147, 79, 15);
					
					$pdf->SetFont('angsana','',10);
					$pdf->setXY(121, 95 );
					$pdf->MultiCell( 0  , 0 , iconv( 'UTF-8','cp874' , 'Thebestdeal1.com' ) );
					
					$pdf->SetFont('angsana','',10);
					$pdf->setXY(149, 95);
					$pdf->MultiCell( 0  , 0 , iconv( 'UTF-8','cp874' , 'Facebook' ) );
					
					/*	
				 	$pdf->SetFont('angsana','',10);
					$pdf->setXY( 10, 100  );
					$pdf->MultiCell( 0  , 0 , iconv( 'UTF-8','cp874' , '--------------------------------------------------------------------------------------------------------------------------------------------') ); 
					 */
					
					$pdf->SetFont('angsana','B',14);
					$pdf->setXY( 8, 110);
					$pdf->MultiCell( 0  , 0 , iconv( 'UTF-8','cp874' , 'Fine Print:') );
					
					$pdf->SetFont('angsana','B',14);
					$pdf->setXY(105, 110);
					$pdf->MultiCell( 0  , 0 , iconv( 'UTF-8','cp874' , 'Location:') );
					
					$pdf->SetFont('angsana','',12);
					$pdf->setXY(105, 140);
					$pdf->MultiCell( 0  , 0 , iconv( 'UTF-8','cp874' , 'Email :') );
					
					$pdf->SetFont('angsana','',12);
					$pdf->setXY(115, 140);
					$pdf->MultiCell( 0  , 0 , iconv( 'UTF-8','cp874' , $vendor_email) );
					
					$pdf->SetFont('angsana','',12);
					$pdf->setXY(105, 145);
					$pdf->MultiCell( 0  , 0 , iconv( 'UTF-8','cp874' , 'Website :') );
					
					$pdf->SetFont('angsana','',12);
					$pdf->setXY(118, 145);
					$pdf->MultiCell( 0  , 0 , iconv( 'UTF-8','cp874' , $vendor_website) );
					
					$fine_print = $this->clear_text_editor($fine_print);
					
					$pdf->SetFont('angsana','',11);
					$pdf->setXY( 8, 115);
					$pdf->MultiCell( 90  , 5 , iconv( 'UTF-8','cp874//TRANSLIT//IGNORE' , $fine_print) ,0,'L');
					
					$location = $this->clear_text_editor($location);
					
					$pdf->SetFont('angsana','',11);
					$pdf->setXY( 105, 113);
					$pdf->MultiCell( 90  , 5 , iconv( 'UTF-8','cp874//TRANSLIT//IGNORE' ,$location) ,0,'L');
					
					$pdf->SetFont('angsana','B',14);
					$pdf->setXY(105, 161);
					$pdf->MultiCell( 0  , 0 , iconv( 'UTF-8','cp874' , 'Other:') );
					
					$deal_main_condition = $this->clear_text_editor($deal_main_condition);
					
					$pdf->SetFont('angsana','',11);
					$pdf->setXY( 105, 165);
					$pdf->MultiCell( 90  , 5 , iconv( 'UTF-8','cp874//TRANSLIT//IGNORE' ,$deal_main_condition) ,0,'L');
					
					unlink($_SERVER["DOCUMENT_ROOT"]."/assets/media/vendor_pdf/".$vendor_id.".pdf");
					$pdf->Output($_SERVER["DOCUMENT_ROOT"]."/assets/media/vendor_pdf/".$vendor_id.".pdf","F"); 
					
					chmod($_SERVER["DOCUMENT_ROOT"]."/assets/media/vendor_pdf/".$vendor_id.".pdf",0777);
	}
	
	public function check_email()
	{
		
		$email	=	$this->input->post('member_email');
		$member_email_old	=	$this->input->post('member_email_old');
		$action_status	=	$this->input->post('action_status');
		
		$this->load->model('member_profile');
		
		if(!$this->member_profile->has_email($email))
		{
			if($email)
			echo "true";
		}else{
			if($action_status == "insert")
				echo "0";
			else {
				if($email == $member_email_old)
					echo "true";
				else 
					echo "0";
			}
		}
	}
	
	public function check_username_admin()
	{
		$txt_user	=	$this->input->post('txt_user');
		$txt_user_old	=	$this->input->post('txt_user_old');
		$action_status	=	$this->input->post('action_status');
		
		$this->db->select('admin_id');
		$query = $this -> db -> get_where("tbl_admin", array("admin_user" => $txt_user));
		
		if($query->num_rows()>0)
		{
			if($action_status == "insert")
				echo "0";
			else {
				if($txt_user == $txt_user_old)
					echo "true";
				else 
					echo "0";
			}
		}else{
			echo "true";
		}
	}
	
	public function check_vendor_email()
	{
		$email			=	$this->input->post('vendor_email');
		$vendor_id		=	$this->input->post('vendor_id');
		
		$this->load->model('vendor_profile');
		
		if(!$this->vendor_profile->has_email($email,$vendor_id))
		{
			echo "true";
		}else{
			echo "0";
		}
	}
	public function update_buy_count_tool($deal_id)
	{
		$this->load->model('deal_main');
		$this->deal_main->update_buy_count($deal_id);
	}
	
	public function iwantit($sub_page = '', $row_id = '') {
		$this->check_admin_login();
		//start config
		$page_title = ":: ผู้ที่ต้องการดีล ::";
		$page_header = ":: ผู้ที่ต้องการดีล ::";

		$base_table = "tbl_iwantit";
		$base_table_main = "tbl_deal_main";
		$base_url = "/mybackoffice/iwantit";
		$base_menu = "ผู้ที่ต้องการดึลนี้อีก";
		$base_pk = 'iwantit_id';
		$base_table_ref = 'deal_id';

		$deal_id = $this -> input -> post('deal_id');
		$email = $this -> input -> post('email');
		$iwantit_status = $this -> input -> post('iwantit_status');
		$d_now = date("Y-m-d H:i:s");
		
		if($sub_page == 'insert'){
				$data = array('deal_id' => $deal_id, 'email' => $email, 'iwantit_create' => $d_now);
		}else{
				$data = array('deal_id' => $deal_id, 'email' => $email);
		}
		//end config

		$this -> generate_iwantit_page($sub_page, $row_id, $page_title, $page_header, $base_table, $base_table_main, $base_table_ref, $base_url, $base_menu, $base_pk, $data);
	}
	
	private function generate_iwantit_page($sub_page, $row_id, $page_title, $page_header, $base_table, $base_table_main, $base_table_ref, $base_url, $base_menu, $base_pk, $data) {
		$view_data = array();

		switch ($sub_page) {
			case 'insert_form' :
			
				$view_data['action_status']	=	"insert";
				$view_data['page_action'] = $base_url . '/insert/';
				$view_data['manage_title'] = "เพิ่มข้อมูล " . $base_menu;
					
				if($base_table_main=="tbl_deal_main")
				{
					$this->db->order_by("deal_id","ASC");
				}
				$query = $this -> db -> get($base_table_main);
				$view_data[$base_table_main] = $query -> result_array();

				$this -> page_data["content"] = $this -> load -> view($base_url . '/form.php', $view_data, true);
				break;

			case 'update_form' :
				$query = $this -> db -> get_where($base_table, array($base_pk => $row_id));
				$view_data = $query -> row_array();
				
				$view_data['action_status']	=	"update";
				$view_data['page_action'] 	= $base_url . '/update/' . $row_id;
				$view_data['manage_title'] = "แก้ไขข้อมูล " . $base_menu;

				$query = $this -> db -> get($base_table_main);
				$view_data[$base_table_main] = $query -> result_array();

				$this -> page_data["content"] = $this -> load -> view($base_url . '/form.php', $view_data,true);
				
				break;

			case 'insert' :
				$this -> db -> insert($base_table, $data);
				$this->xlog_admin->save_log($this->admin_id,"2101");
				echo "<script>window.location.href='" . $base_url . "'</script>";
				unset($data);
				return 0;
				break;

			case 'update' :
				$this -> db -> where($base_pk, $row_id);
				$this -> db -> update($base_table, $data);
				$this->xlog_admin->save_log($this->admin_id,"2102");
				unset($data);
				echo "<script>window.location.href='" . $base_url . "'</script>";
				return 0;
				break;

			case 'delete' :
				$this -> db -> where($base_pk, $row_id);
				$this -> db -> delete($base_table);
				$this->xlog_admin->save_log($this->admin_id,"2103");
				echo "<script>window.location.href='" . $base_url . "'</script>";
				return 0;
				break;
			case 'view_data':
				$query = $this -> db -> get_where($base_table, array($base_pk => $row_id));
				$view_data = $query -> row_array();
				
				$view_data['action_status']	=	"view";
				$view_data['page_action'] 	= 	$base_url . '/view/';
				$view_data['manage_title'] = 	"แสดงข้อมูล " . $base_menu;
					
				if($base_table_main=="tbl_deal_main")
				{
					$this->load->model('deal_main');
					$view_data["deal_data"]	=	$this->deal_main->get_deal_by_id($view_data["deal_id"]);
				}
				
				$this -> page_data["content"] = $this -> load -> view($base_url . '/view.php', $view_data, true);
			break;
			default :
				$view_data = array();
				$this->load->model('iwantit');
				
				$view_data[$base_table] = $this->iwantit->get_iwantit_all();

				$this -> page_data["content"] = $this -> load -> view($base_url . '/main.php', $view_data, true);

				break;
		}

		$this -> page_data["page_title"] = $page_title;
		$this -> page_data["page_header"] = $page_header;
		$this -> render -> page_render($this -> page_data);

		unset($view_data);
	}

	public function free_ads($sub_page = '', $row_id = '') 
	{
		$this->check_admin_login();
		//start config
		$page_title 		= ":: ติดต่อลงโฆษณาธุรกิจ ::";
		$page_header 	= ":: ติดต่อลงโฆษณาธุรกิจ ::";

		$base_table 		= "tbl_free_ads";
		$base_url 			= "/mybackoffice/free_ads";
		$base_menu 		= "ติดต่อลงโฆษณาธุรกิจ";
		$base_pk 			= "free_ads_id";

		$d_now 			= date("Y-m-d H:i:s");
		
		$this -> generate_free_ads_page($sub_page, $row_id, $page_title, $page_header, $base_table, $base_url, $base_menu, $base_pk);
	}
	
	private function generate_free_ads_page($sub_page, $row_id, $page_title, $page_header, $base_table, $base_url, $base_menu, $base_pk) 
	{
		$view_data 	= array();
		$data			=	$this->input->post();
		$data["ip"]		=	$this->input->ip_address();
		
		unset($data["submit"]);	
		
		switch ($sub_page) {
			case 'insert_form' :
			
				$view_data['action_status']	=	"insert";
				$view_data['page_action'] = $base_url . '/insert/';
				$view_data['manage_title'] = "เพิ่มข้อมูล " . $base_menu;
				
				$this -> page_data["content"] = $this -> load -> view($base_url . '/form.php', $view_data, true);
				break;

			case 'update_form' :
				$query = $this -> db -> get_where($base_table, array($base_pk => $row_id));
				$view_data = $query -> row_array();
								
				$view_data['action_status']	=	"update";
				$view_data['page_action'] 	= $base_url . '/update/' . $row_id;
				$view_data['manage_title'] = "แก้ไขข้อมูล " . $base_menu;

				$this -> page_data["content"] = $this -> load -> view($base_url . '/form.php', $view_data,true);
				
				break;

			case 'insert' :
				$this -> db -> insert($base_table, $data);
				$this->xlog_admin->save_log($this->admin_id,"2141");
				echo "<script>window.location.href='" . $base_url . "'</script>";
				unset($data);
				return 0;
				break;

			case 'update' :
				$this -> db -> where($base_pk, $row_id);
				$this -> db -> update($base_table, $data);
				$this->xlog_admin->save_log($this->admin_id,"2142");
				unset($data);
				echo "<script>window.location.href='" . $base_url . "'</script>";
				return 0;
				break;

			case 'delete' :
				$this -> db -> where($base_pk, $row_id);
				$this -> db -> delete($base_table);
				$this->xlog_admin->save_log($this->admin_id,"2143");
				echo "<script>window.location.href='" . $base_url . "'</script>";
				return 0;
				break;
				
			case 'view_data':
				$query = $this -> db -> get_where($base_table, array($base_pk => $row_id));
				$view_data = $query -> row_array();
				
				$view_data['action_status']	=	"view";
				$view_data['page_action'] 	= 	$base_url . '/view/';
				$view_data['manage_title'] = 	"แสดงข้อมูล " . $base_menu;
					
				$this -> page_data["content"] = $this -> load -> view($base_url . '/view.php', $view_data, true);
			break;
			default :
				$view_data = array();
				$this->load->model('free_ads');
				
				$view_data[$base_table] = $this->free_ads->get_free_ads();

				$this -> page_data["content"] = $this -> load -> view($base_url . '/main.php', $view_data, true);

				break;
		}

		$this -> page_data["page_title"] = $page_title;
		$this -> page_data["page_header"] = $page_header;
		$this -> render -> page_render($this -> page_data);

		unset($view_data);
	}
	public function user_admin($sub_page = '', $row_id = '') {
		$this->check_admin_login();
		//start config
		$page_title = ":: พนักงานขาย ::";
		$page_header = ":: พนักงานขาย ::";

		$base_table = "tbl_admin";
		$base_url = "/mybackoffice/user_admin/";
		$base_menu = "ผู้ดูแลระบบ";
		$base_pk = 'admin_id';

		$admin_user 		= $this -> input -> post('txt_user');
		$admin_name 	= $this -> input -> post('admin_name');
		$admin_status 	= $this -> input -> post('admin_status');
		$admin_type 		= $this -> input -> post('admin_type');
		
		
		// password เข้ารหัส base64
		$pwd = $this -> input -> post('admn_pwd');
		$admin_pwd =  base64_encode($pwd);
	
		$d_now = date("Y-m-d H:i:s");
	
		if($sub_page == 'insert'){
			$data = array(	'admin_user' => $admin_user, 
									'admn_pwd' => $admin_pwd, 
									'admin_name' => $admin_name, 
									'admin_status' => $admin_status, 
									'admin_type' => $admin_type, 
									'admin_create' => $d_now, 
									'admin_modify' => $d_now);
		}else{
			$data = array(	'admin_user' => $admin_user, 
									'admn_pwd' => $admin_pwd, 
									'admin_name' => $admin_name, 
									'admin_status' => $admin_status, 
									'admin_type' => $admin_type, 
									'admin_modify' => $d_now);
		}
		//end config

		$this -> generate_page($sub_page, $row_id, $page_title, $page_header, $base_table, $base_url, $base_menu, $base_pk, $data);
	}
	public function show_deal_sell() 
	{
		$this->check_admin_login();
		//start config
		$base_table_ref = array();
		
		$page_title = ":: การขายดีล ::";
		$page_header = ":: การขายดีล ::";

		$base_url = "/mybackoffice/sell_deal";
		$base_menu = "ข้อมูลการขายดีล";

		$view_data = array();
		
		$sql	=	"	SELECT vd.vendor_id,
									vd.vendor_status,
									vd.vendor_name, 
									vd.deal_id,
									vd.deal_name, 
									vd.deal_buy_time_start, 
									vd.deal_buy_time_end,
									r.round_start,
									r.round_end, 
									vd.deal_start, 
									vd.deal_expile, 
									vd.product_discount_per
						FROM view_deal_sell vd
						LEFT JOIN tbl_deal_round r ON vd.deal_id	=	r.deal_id
						GROUP BY vd.round_id,vd.product_id
					";
		$sql	.=	"	ORDER BY vd.vendor_name";
		$query = $this->db->query($sql);
		
		$sell_product_data =  $query->result_array();
		
		$deal_sell_data		=	array();
		$vendor_data		=	array();
		//init value
		foreach($sell_product_data as $product)
		{
				$index	=	$product["deal_id"];
				
				$round_data	=	array();
				
				$sql				=	"	SELECT round_start,round_end 
											FROM tbl_deal_round
											WHERE deal_id = '".$index."'
											ORDER BY round_id DESC
											LIMIT 0,1
										";
				$query = $this->db->query($sql);

 	 			$round_data 	= $query->row_array(); 
 	 				
 	 			$sql				=	"	SELECT 	MIN( vd.product_price ) AS product_price, 
														MIN( vd.product_total_price ) AS the_best_deal_price 
											FROM view_deal_sell vd
											LEFT JOIN tbl_deal_round r ON vd.deal_id	=	r.deal_id
											WHERE r.deal_id = '".$index."'
										";
				$query = $this->db->query($sql);

 	 			$price_data 	=  $query->row_array(); 
 	 			
 	 			$sql				=	"	SELECT 	vd.order_id
											FROM view_deal_sell vd
											LEFT JOIN tbl_deal_round r ON vd.deal_id	=	r.deal_id
											WHERE r.deal_id = '".$index."'
											GROUP BY vd.round_id,vd.product_id
										";
				$query = $this->db->query($sql);
 	 			$nOrder 		= $query->num_rows();
 	 			
				$sql				=	"	SELECT 	vd.coupon_id
											FROM view_deal_sell vd
											LEFT JOIN tbl_deal_round r ON vd.deal_id	=	r.deal_id
											WHERE r.deal_id = '".$index."'
											GROUP BY vd.round_id,vd.product_id
										";
				$query = $this->db->query($sql);
				$nCoupon 		= $query->num_rows();
			
				$deal_sell_data[$index]	=	$product;
				$deal_sell_data[$index]["product_price"]			=	$price_data["product_price"];
				$deal_sell_data[$index]["the_best_deal_price"]	=	$price_data["the_best_deal_price"];
				$deal_sell_data[$index]["round_start"]				=	$round_data["round_start"];
				$deal_sell_data[$index]["round_end"]				=	$round_data["round_end"];
				$deal_sell_data[$index]["nOrder"]					=	$nOrder;
				$deal_sell_data[$index]["nCoupon"]					=	$nCoupon;
				$deal_sell_data[$index]["summary"]					=	$nCoupon*$price_data["the_best_deal_price"];
				
				$vendor_data	[$product["vendor_id"]]		=	$product["vendor_name"];
		}
		
		//cal order coupon and summary
		
		/*foreach($sell_product_data as $product)
		{			
			$index	=	$product["deal_id"];
			
			$deal_sell_data[$index]["nOrder"]		+=	$product["num_order"];
			$deal_sell_data[$index]["nCoupon"]		+=	$product["num_coupon"];	
			$deal_sell_data[$index]["summary"]	+=	$product["num_coupon"]*$product["the_best_deal_price"];
		}*/
			
		$view_data["deal_sell_data"] 	= $deal_sell_data;
		$view_data["vendor_data"]		= $vendor_data;
		
		$this -> page_data["content"] = $this -> load -> view($base_url . '/main.php', $view_data, true);
		
		unset($deal_sell_data);
		
		$this -> page_data["page_title"] = $page_title;
		$this -> page_data["page_header"] = $page_header;
		$this -> render -> page_render($this -> page_data);

		unset($view_data);
	}
	
	public function show_product_sell($deal_id="") 
	{
		$this->check_admin_login();
		//start config
		$base_table_ref = array();
		
		$page_title = ":: การขายแคมเปญ ::";
		$page_header = ":: การขายแคมเปญ ::";

		$base_url = "/mybackoffice/sell_product";
		$base_menu = "ข้อมูลการขายแคมเปญ";

		$view_data = array();
		
		$sql	=	"	SELECT vd.vendor_id,
									vd.vendor_status,
									vd.vendor_name, 
									vd.deal_id,
									vd.deal_name, 
									vd.product_name,
									vd.deal_buy_time_start, 
									vd.deal_buy_time_end,
									r.round_start,
									r.round_end, 
									vd.deal_start, 
									vd.deal_expile, 
									vd.product_discount_per,
									MIN( vd.product_price ) AS product_price, 
									MIN( vd.product_total_price ) AS the_best_deal_price, 
									COUNT( DISTINCT vd.order_id ) AS nOrder, 
									COUNT( DISTINCT vd.coupon_id ) AS nCoupon
						FROM view_deal_sell vd
						LEFT JOIN tbl_deal_round r ON vd.deal_id	=	r.deal_id
					";
		if(!empty($deal_id))
		$sql	.=	"	WHERE vd.deal_id = '".$deal_id."'";
		$sql	.=	"	GROUP BY vd.round_id,vd.product_id";
		$sql	.=	"	ORDER BY vd.vendor_name";
		$query = $this->db->query($sql);
		$sell_product_data =  $query->result_array();
			
		$vendor_data		=	array();
		//init value
		foreach($sell_product_data as $product)
		{
				$vendor_data	[$product["vendor_id"]]		=	$product["vendor_name"];
		}
		
		$view_data["vendor_data"] 			= $vendor_data;
		$view_data["sell_product_data"] 		= $sell_product_data;
		
		$this -> page_data["content"] = $this -> load -> view($base_url . '/main.php', $view_data, true);
		
		unset($deal_sell_data);
		
		$this -> page_data["page_title"] = $page_title;
		$this -> page_data["page_header"] = $page_header;
		$this -> render -> page_render($this -> page_data);

		unset($view_data);
	}
	
	public function show_vendor_sell($vendor_id="") 
	{
		$this->check_admin_login();
		//start config
		$base_table_ref = array();
		
		$page_title = ":: รายได้ของร้านค้า ::";
		$page_header = ":: รายได้ของร้านค้า ::";

		$base_url = "/mybackoffice/sell_vendor";
		$base_menu = "รายได้ของร้านค้า";

		$view_data = array();
		
		$sql	=	"	SELECT vd.vendor_id,
									vd.vendor_status,
									vd.vendor_name, 
									vd.vendor_pay_type,
									vd.deal_id,
									vd.deal_name, 
									vd.product_name,
									vd.product_mrd,
									vd.deal_buy_time_start, 
									vd.deal_buy_time_end, 
									r.round_id,
									r.round_start,
									r.round_end,
									r.payment_status, 
									vd.deal_start, 
									vd.deal_expile, 
									vd.product_discount_per,
									MIN( vd.product_price ) AS product_price, 
									MIN( vd.product_total_price ) AS the_best_deal_price, 
									COUNT( DISTINCT vd.order_id ) AS nOrder, 
									COUNT( DISTINCT vd.coupon_id ) AS nCoupon
						FROM view_deal_sell vd
						LEFT JOIN tbl_deal_round r ON vd.deal_id	=	r.deal_id
					";
		/*
		if(!empty($vendor_id))
		$sql	.=	"	WHERE vd.vendor_id = '".$vendor_id."'";
		*/
		$sql	.=	"	GROUP BY vd.round_id,vd.product_id";
		$sql	.=	"	ORDER BY vd.vendor_name";
		$query = $this->db->query($sql);
		$sell_product_data =  $query->result_array();
			
		$vendor_data		=	array();
		//init value
		foreach($sell_product_data as $product)
		{
				$vendor_data	[$product["vendor_id"]]		=	$product["vendor_name"];
		}
		
		$view_data["vendor_data"] 			= $vendor_data;
		$view_data["sell_product_data"] 		= $sell_product_data;
		$view_data["vendor_id"]					=	$vendor_id;
		
		$this -> page_data["content"] = $this -> load -> view($base_url . '/main.php', $view_data, true);
		
		unset($deal_sell_data);
		
		$this -> page_data["page_title"] = $page_title;
		$this -> page_data["page_header"] = $page_header;
		$this -> render -> page_render($this -> page_data);

		unset($view_data);
	}
	public function send_email_to_vendor($vendor_id)
	{
		$sql	=	"	SELECT sc.deal_start,
									sc.deal_expile,
									sc.round_start,
									sc.round_end,
									v.vendor_id,
									v.vendor_name,
									v.vendor_contact_fname,
									v.vendor_contact_sname,
									v.vendor_pwd,
									v.vendor_email,
									v.vendor_address,
									v.vendor_website,
									v.vendor_logo,
									v.vendor_map,
									v.vendor_about_us,
									v.vendor_pay_type
						FROM view_sell_coupon sc
						LEFT JOIN tbl_vendor_profile v ON sc.vendor_id	=	v.vendor_id
						WHERE v.vendor_id = '".$vendor_id."'";
		$query = $this->db->query($sql);
		
		$view_data 	= $query->row_array();
		$view_data["vendor_pwd"]	=	base64_decode($view_data["vendor_pwd"]);
		
		$email	=	$view_data["vendor_email"];
		//$email	=	"ududee@msn.com";
		//$email	=	"light_lay@hotmail.com";
	
		$this->create_ex_coupon($vendor_id);

		$this->load->library('email');
			
		$this->email->from('sale@thebestdeal1.com', 'TheBestDeal1');
		$this->email->to($email);
		$this->email->subject("TheBestDeal1 Merchant Dashboard - ".$view_data["vendor_name"]);
		
		$body	=	$this -> load -> view('mail/mail_merchant_dashboard.php',$view_data, true);					
		$this->email->message($body);	
		
		$this->email->attach($_SERVER["DOCUMENT_ROOT"]."/assets/media/vendor_pdf/".$vendor_id.".pdf");
	
		$this->email->send();
		
		 echo $email." ";
		 echo "send complete ".date("m-d-Y H:i:s",time());
	}
	public function send_email_news_letter()
	{
		$this->check_admin_login();
		
		$this->load->model('deal_main');
	
		$view_data	=	array();
		$view_data["deal_set"]	=	$this->deal_main->get_active_deal_last_modify();
		
		if(sizeof($view_data["deal_set"])>0)
		{
			$this->load->model('member_profile');
			$sent_to		=	$this->member_profile->get_member_news_letter();
			
			$this->load->library('email');
			
			$this->email->newline = "\r\n";
			$this->email->crlf = "\n";
			
			$subject	=	"ดีลสุดพิเศษ ราคาถูกที่สุด รอคุณอยู่ ดีลเด่นประจำสัปดาห์‏";
			foreach($sent_to as $mail_data)
			{
				//$email	=	"light_lay@hotmail.com";
				//$email	=	"ududee@msn.com";
				$email	=	$mail_data["member_email"];
				$body	=	$this -> load -> view('mail/mail_news.php', $view_data, true);	
				$body	=	str_replace("#email_code#",base64_encode($email),$body);
							
				$this->email->from('news@thebestdeal1.com', 'TheBestDeal Newsletter');
				$this->email->subject($subject);
				$this->email->message($body);	
			
				$this->email->to($email);
				$this->email->send();
				
				//echo $email."<br/>";
			}
			echo "\nsend complete";
			//echo $body;
		}
	}
	public function popup_shop_payment($round_id,$status)
	{
		$view_data["round_id"]		=	$round_id;
		$view_data["status"]			=	$status;
		$this -> load -> view('mybackoffice/sell_vendor/popup_shop_payment.php',$view_data);
	}
	public function update_shop_payment($round_id,$status)
	{
		$sql		=	"UPDATE tbl_deal_round SET payment_status = '".$status."' WHERE round_id = '".$round_id."'";	
		$query 	= $this->db->query($sql);
	}
}
?>