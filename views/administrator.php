<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Administrator extends CI_Controller {
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
	public function __construct() 
	{
		parent::__construct();
		// Your own constructor code
		//config page rend
		
		$params = array('layout' => $this -> layout, 'stylesheets' => $this -> stylesheets, 'javascripts' => $this -> javascripts);
		$this->load->library('render', $params);
		$this->load->library('convert_date');
		$this->load->library('session');
		
		$this->load->database();
		$this->load->helper(array('form', 'url'));
		$this->load->model('admin_profile');
		$this->load->model('coupon_main');
		$this -> page_data["page_menu"] = $this -> get_admin_menu();
		
		$this->admin_id =	$this->session->userdata('admin_id');
	}

	protected function get_admin_menu() 
	{
		$menu = array();
		$menu[0]["name"] = "ข้อมูลสมาชิก";
		$menu[0]["link"] = "/administrator/member_profile";
		
		$menu[1]["name"] = "ข้อมูลผู้ขายดีล";
		$menu[1]["link"] = "/administrator/vendor_profile";
		
		$menu[2]["name"] = "ข้อมูลดีล";
		$menu[2]["link"] = "/administrator/deal_main";

		$menu[3]["name"] = "ข้อมูลแคมเปญ";
		$menu[3]["link"] = "/administrator/deal_product";

		$menu[4]["name"] = "ข้อมูลการสั่งซื้อ";
		$menu[4]["link"] = "/administrator/deal_order";
	
		$menu[5]["name"] = "ข้อมูลคูปอง";
		$menu[5]["link"] = "/administrator/coupon_manage";
		
		$menu[6]["name"] = "ข้อมูลจังหวัด";
		$menu[6]["link"] = "/administrator/province";
	
		$menu[7]["name"] = "ข้อมูลหมวดหมู่หลัก";
		$menu[7]["link"] = "/administrator/category";
		
		$menu[8]["name"] = "ข้อมูลหมวดหมู่ย่อย";
		$menu[8]["link"] = "/administrator/category_sub";
		
		$menu[9]["name"] = "สไลด์โปรโมชั่น";
		$menu[9]["link"] = "/administrator/home_slide";
		
		$menu[10]["name"] = "ผู้ที่ต้องการดีล";
		$menu[10]["link"] = "/administrator/iwantit";
		
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
				
				$this->admin_id		=	$admin_data["admin_id"];
				unset($admin_data);
	
				if($remeberme)
				{
					$cookie = array(
    				'name'   => 'admin_auto_login_id',
    				'value'  =>$this->admin_id,
    				'expire' => (60*60*24*30),
    				'domain' => '',
    				'path'   => '/',
    				'prefix' => '',
   	 				'secure' => TRUE
					);
					$this->input->set_cookie($cookie);
				}
				$this->session->set_userdata('admin_id',$this->admin_id);
				//$this->xlog_vendor_login->save_log($this->admin_id,1);
				
				echo "1";
			}else{
				echo "0";
			}
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
				<script>window.location.href = "/administrator";</script>
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
				$view_data['manage_title'] = "เพิ่มข้อมูล " . $base_menu;

				$this -> page_data["content"] = $this -> load -> view($base_url . '/form.php', $view_data, true);
				break;

			case 'update_form' :
				$query = $this -> db -> get_where($base_table, array($base_pk => $row_id));
				$view_data = $query -> row_array();

				$view_data['page_action'] = $base_url . '/update/' . $row_id;
				$view_data['manage_title'] = "แก้ไขข้อมูล " . $base_menu;
				$this -> page_data["content"] = $this -> load -> view($base_url . '/form.php', $view_data, true);
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
				
				$this->load->model('vendor_profile');
				$vendor_id		=	$this->vendor_profile->get_next_vendor_id();
				
				$upload_path							=	'vendor/logo/'.($vendor_id%10);
				$input_name							=	"vendor_logo";
				
				if(!empty($_FILES[$input_name]["type"]))
				{
					$type_image							=	explode("/",$_FILES[$input_name]["type"]);
				
					$file_name								= 	$vendor_id.".".$type_image[1];
				
					$this->do_upload($upload_path,$file_name,$input_name);
			
					$data["vendor_logo"]				=	"";
					$data["vendor_logo"]				=	'upload/vendor/logo/'.($vendor_id%10).'/'.$file_name;
				}
				
				$upload_path							=	'vendor/map/'.($vendor_id%10);
				$input_name							=	"vendor_map";
				if(!empty($_FILES[$input_name]["type"]))
				{
					$type_image							=	explode("/",$_FILES[$input_name]["type"]);
				
					$file_name								= 	$vendor_id.".".$type_image[1];
				
					$this->do_upload($upload_path,$file_name,$input_name);
					$data["vendor_map"]				=	"";
					$data["vendor_map"]				=	'upload/vendor/map/'.($vendor_id%10).'/'.$file_name;
				}
				$data["vendor_id"]					=	$vendor_id;
				$data["vendor_create"]			=	date("Y-m-d H:i:s",time());	
				
				$this -> db -> insert($base_table, $data);
				echo "<script>window.location.href='" . $base_url . "'</script>";
				unset($data);
				return 0;
				break;

			case 'update' :
				$vendor_id	=	$row_id;
				
				$input_name	=	"vendor_logo";
					
				if(!empty($_FILES[$input_name]["type"]))
				{
					$upload_path							=	'vendor/logo/'.($vendor_id%10);
					$type_image							=	explode("/",$_FILES[$input_name]["type"]);
				
					$file_name								= 	$vendor_id.".".$type_image[1];
				
					$this->do_upload($upload_path,$file_name,$input_name);
					
					$data["vendor_logo"]				=	"";
					$data["vendor_logo"]				=	'upload/vendor/logo/'.($vendor_id%10).'/'.$file_name;
				}
				
				$input_name	=	"vendor_map";
				
				if(!empty($_FILES[$input_name]["type"]))
				{
					$upload_path							=	'vendor/map/'.($vendor_id%10);
					$type_image							=	explode("/",$_FILES[$input_name]["type"]);
					$file_name								= 	$vendor_id.".".$type_image[1];
				
					$this->do_upload($upload_path,$file_name,$input_name);
					
					$data["vendor_map"]				=	"";
					$data["vendor_map"]				=	'upload/vendor/map/'.($vendor_id%10).'/'.$file_name;
				}
				
				$this -> db -> where($base_pk, $row_id);
				$this -> db -> update($base_table, $data);
				unset($data);
				echo "<script>window.location.href='" . $base_url . "'</script>";
				return 0;
				break;

			case 'delete' :
				$this->load->model('vendor_profile');
				$this->vendor_profile->delete_vendor_profile($row_id);
				echo "<script>window.location.href='" . $base_url . "'</script>";
				return 0;
				break;
			case 'view_data':
				$query = $this -> db -> get_where($base_table, array($base_pk => $row_id));
				$view_data = $query -> row_array();
				
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
			case 'send_password':
				$query = $this -> db -> get_where($base_table, array($base_pk => $row_id));
				$view_data = $query -> row_array();
				
				$email	=	$view_data["vendor_email"];
				
				$this->load->library('email');

				$this->email->from('info@thebestdeal1.com', 'info@thebestdeal1');
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
			default :
				$view_data = array();
				$this->load->model('vendor_profile');
				
				$view_data[$base_table] = $this->vendor_profile->get_all_vendor_profile();

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

				$query = $this -> db -> get($base_table_main);
				$view_data[$base_table_main] = $query -> result_array();

				$this -> page_data["content"] = $this -> load -> view($base_url . '/form.php', $view_data,true);
				
				break;

			case 'insert' :
				$this -> db -> insert($base_table, $data);
				$email			=	$data["member_email"];
				$password		=	base64_decode($data["member_pwd"]);
				
				$this->load->library('email');

				$this->email->from('info@thebestdeal1.com', 'info@thebestdeal1');
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
	
				echo "<script>window.location.href='" . $base_url ."insert_form';</script>";
				unset($data);
				return 0;
				break;

			case 'update' :
				$this -> db -> where($base_pk, $row_id);
				$this -> db -> update($base_table, $data);
				unset($data);
				echo "<script>window.location.href='" . $base_url ."update_form/".$row_id."';</script>";
				return 0;
				break;

			case 'delete' :
				$this -> db -> where($base_pk, $row_id);
				$this -> db -> delete($base_table);
				
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
							
						$mbirthday 	= mktime(0, 0, 0, $bmonth, $bday, ($byear-543)); 
						$mnow 			= mktime(0, 0, 0, $tmonth, $tday, $tyear );
						$mage 			= ($mnow - $mbirthday);
				
						$u_y		=	date("Y", $mage)-1970;
						$u_m	=	date("m",$mage)-1;
						$u_d		=	date("d",$mage)-1;
					
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

				$this->email->from('info@thebestdeal1.com', 'info@thebestdeal1');
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
		$view_data["javascripts"]	=	$this->javascripts;
		$login_form	=	$this -> load -> view('administrator/admin_login.php',$view_data);
	}

	public function member_profile($sub_page = '', $row_id = '') {
		$this->check_admin_login();
		//start config
		$page_title = ":: Member Profile ::";
		$page_header = ":: Member Profile ::";

		$base_table = "tbl_member_profile";
		$base_table_main = "tbl_province_data";
		$base_url = "/administrator/member_profile/";
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
	
		if($sub_page == 'insert'){
			$data = array('member_name' => $member_name, 'member_sname' => $member_sname, 'member_email' => $member_email, 
			'member_pwd' => $member_pwd, 'member_gendar' => $member_gendar, 'member_birth_date' => $member_birth_date,
			'member_ssn' => $member_ssn, 'member_mobile' => $member_mobile, 'member_address' => $member_address,
			'city_name' => $city_name, 'province_id' => $province_id, 'member_zipcode' => $member_zipcode,
			 'subscript_email' => $subscript_email, 'member_regis_time' => $d_now, 'member_regis_ip' => $ipaddress,
			 'member_update_time' => $d_now, 'register_email' => $register_email);
		}else{
			$data = array('member_name' => $member_name, 'member_sname' => $member_sname, 'member_email' => $member_email, 
			'member_pwd' => $member_pwd, 'member_gendar' => $member_gendar, 'member_birth_date' => $member_birth_date,
			'member_ssn' => $member_ssn, 'member_mobile' => $member_mobile, 'member_address' => $member_address,
			'city_name' => $city_name, 'province_id' => $province_id, 'member_zipcode' => $member_zipcode,
			 'subscript_email' => $subscript_email,'member_update_time' => $d_now, 'register_email' => $register_email);
		}
		//end config

		$this -> generate_member_page($sub_page, $row_id, $page_title, $page_header, $base_table, $base_table_main, $base_table_ref, $base_status_ref, $base_url, $base_menu, $base_pk, $data);
	}

	public function vendor_profile($sub_page = '', $row_id = '') {
		$this->check_admin_login();
		//start config
		$page_title 		= ":: ข้อมูลร้านขายดีล ::";
		$page_header 	= ":: ข้อมูลร้านขายดีล ::";

		$base_table 			= "tbl_vendor_profile";
		$base_table_main 	= "tbl_province_data";
		$base_url 				= "/administrator/vendor_profile";
		$base_menu 			= "Vendor Profile";
		$base_pk 				= 'vendor_id';
		$base_table_ref 	= 'province_id';
		$base_status_ref 	= 'province_status';
		
		$d_now = date("Y-m-d H:i:s"); 

		$vendor_email = $this -> input -> post('vendor_email');
		
		// password เข้ารหัส base64
		$pwd = $this -> input -> post('vendor_pwd');
		$member_pwd =  base64_encode($pwd);
	
		$vendor_logo = $this -> input -> post('vendor_logo');
		$vendor_name = $this -> input -> post('vendor_name');
		$vendor_contact_fname = $this -> input -> post('vendor_contact_fname');
		$vendor_contact_sname = $this -> input -> post('vendor_contact_sname');
		$vendor_address = $this -> input -> post('vendor_address');
		$vendor_status = $this -> input -> post('vendor_status');
		$vendor_website = $this -> input -> post('vendor_website');
		$vendor_map = $this -> input -> post('vendor_map');
		$vendor_about_us = $this -> input -> post('vendor_about_us');
		$d_now = date("Y-m-d H:i:s");
		
		$data = array('vendor_email' => $vendor_email, 'vendor_pwd' => $member_pwd, 'vendor_logo' => $vendor_logo, 
			'vendor_name' => $vendor_name, 'vendor_contact_fname' => $vendor_contact_fname, 'vendor_contact_sname' => $vendor_contact_sname,
			'vendor_address' => $vendor_address, 'vendor_status' => $vendor_status, 'vendor_website' => $vendor_website,
			'vendor_map' => $vendor_map, 'vendor_about_us' => $vendor_about_us
			, 'vendor_create' => $d_now,'vendor_modify' => $d_now);
		
		unset($data["vendor_confirm_pwd"]);
		$this -> generate_vendor_page($sub_page, $row_id, $page_title, $page_header, $base_table, $base_table_main, $base_table_ref, $base_status_ref, $base_url, $base_menu, $base_pk, $data);
	}

	public function province($sub_page = '', $row_id = '') {
		$this->check_admin_login();
		//start config
		$page_title = ":: Province Management ::";
		$page_header = ":: Province Management ::";

		$base_table = "tbl_province_data";
		$base_url = "/administrator/province";
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
		$page_title = ":: Category Management ::";
		$page_header = ":: Category Management ::";

		$base_table = "tbl_category_main";
		$base_url = "/administrator/category";
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
		$page_title = ":: Sub Category Management ::";
		$page_header = ":: Sub Category Management ::";

		$base_table = "tbl_category_sub";
		$base_table_main = "tbl_category_main";
		$base_url = "/administrator/category_sub";
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

public function deal_main($sub_page = '', $row_id = '',$vendor_id="") {
	$this->check_admin_login();
		//start config
		$base_table_ref = array();
		
		$page_title 		= ":: จัดการข้อมูลแคมเปญ ::";
		$page_header 	= ":: จัดการข้อมูลแคมเปญ ::";

		$base_table = "tbl_deal_main";
		$base_table_ref[0]["tb"] 	= "tbl_category_main";
		$base_table_ref[1]["tb"]  	= "tbl_category_sub";
		$base_table_ref[2]["tb"]  	= "tbl_vendor_profile";
		
		$base_url 		= "/administrator/deal_main";
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
		$base_url 		= "/administrator/deal_gallery/".$deal_id;
		$base_menu 	= "แกลลอรี่";
		$base_pk = 'pic_id';
		
		$this->load->model("deal_main");
		
		$view_data 	= array();
		$view_data	=	$this->deal_main->get_deal_by_id($deal_id);
		
		switch ($sub_page) {
			case 'insert_form' :
				$view_data['page_action'] 	=	$base_url.'/insert/';
				$view_data['manage_title'] = 	"เพิ่มข้อมูล " . $base_menu;
				
				$this -> page_data["content"] = $this -> load -> view('/administrator/deal_gallery/form.php', $view_data, true);
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
				//echo "<script>window.location.href='" . $base_url . "'</script>";
				echo 1;
				return 0;
				break;
			
			default :
				$query = $this -> db -> get_where($base_table,array("deal_id"=>$deal_id));
				$view_data["deal_gallery"] = $query -> result_array();
				
				$this -> page_data["content"] = $this -> load -> view('/administrator/deal_gallery/main.php', $view_data, true);
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
		$base_url 		= "/administrator/deal_slide/".$deal_id;
		$base_menu 	= "สไลด์";
		$base_pk = 'pic_id';
		
		$this->load->model("deal_main");
		
		$view_data 	= array();
		$view_data	=	$this->deal_main->get_deal_by_id($deal_id);
		
		switch ($sub_page) {
			case 'insert_form' :
				$view_data['page_action'] 	=	$base_url.'/insert/';
				$view_data['manage_title'] = 	"เพิ่มข้อมูล " . $base_menu;
				
				$this -> page_data["content"] = $this -> load -> view('/administrator/deal_slide/form.php', $view_data, true);
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
						
						$data["deal_id"]						=	$deal_id;
						$data["pic_path"]					=	'upload/'.$upload_path.'/'.$file_name;
						$data["pic_order"]					=	$nPic;
									
						$this -> db -> insert($base_table, $data);
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
				//echo "<script>window.location.href='" . $base_url . "'</script>";
				echo 1;
				return 0;
				break;
			
			default :
				$query = $this -> db -> get_where($base_table,array("deal_id"=>$deal_id));
				$view_data["deal_slide"] = $query -> result_array();
				
				$this -> page_data["content"] = $this -> load -> view('/administrator/deal_slide/main.php', $view_data, true);
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

		$page_title 		= ":: จัดการข้อมูลสไลด์โปโมชั่น ::";
		$page_header 	= ":: จัดการข้อมูลสไลด์โปโมชั่น ::";

		$base_table 	= "tbl_promotion_slide";
		$base_url 		= "/administrator/home_slide";
		$base_menu 	= "โปรโมชั่น";
		$base_pk = 'promotion_id';
		
		switch ($sub_page) {
			case 'insert_form' :
				$view_data['page_action'] 	=	$base_url.'/insert/';
				$view_data['manage_title'] = 	"เพิ่มข้อมูล " . $base_menu;
				$view_data['action']			=	"insert";
				
				$this -> page_data["content"] = $this -> load -> view('/administrator/home_slide/form.php', $view_data, true);
				break;
			case 'update_form' :
				$query = $this -> db -> get_where($base_table, array($base_pk => $row_id));
				$view_data = $query -> row_array();
				
				$view_data['page_action'] 	=	$base_url.'/update/'.$row_id;
				$view_data['manage_title'] = 	"แก้ไขข้อมูล " . $base_menu;
				$view_data['action']			=	"update";
				
				$this -> page_data["content"] = $this -> load -> view('/administrator/home_slide/form.php', $view_data, true);
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
				//echo "<script>window.location.href='" . $base_url . "'</script>";
				echo 1;
				return 0;
				break;
			
			default :
				$this->db->order_by('promotion_status desc,pic_order asc'); 
				$query = $this -> db -> get($base_table);
				
				$view_data["promotion"] = $query -> result_array();
				
				$this -> page_data["content"] = $this -> load -> view('/administrator/home_slide/main.php', $view_data, true);
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
		$page_title 		= ":: จัดการข้อมูลสินค้า ::";
		$page_header 	= ":: จัดการข้อมูลสินค้า ::";

		$base_table 			= "tbl_deal_product";
		$base_table_main 	= "tbl_deal_main";
		$base_url 				= "/administrator/deal_product";
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
					$view_data["deal_id"]				= $deal_id;
				
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
				$view_data 	= $this->deal_product->get_product_by_product_id($row_id);
			
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
				unset($data["submit"]);
				
				$this -> db -> insert($base_table, $data);
				
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
				
				if(empty($deal_id))
				{
					$view_data["deal_product"] 	= $this->deal_product->get_product_all();
				}else{
					$view_data["deal_product"] 	= $this->deal_product->get_product_by_deal_id($deal_id);
					$view_data["deal_id"]				= $deal_id;
				}
				
				$this -> page_data["content"] = $this -> load -> view($base_url . '/main.php', $view_data, true);

				break;
		}

		$this -> page_data["page_title"] = $page_title;
		$this -> page_data["page_header"] = $page_header;
		$this -> render -> page_render($this -> page_data);

		unset($view_data);
}

private function generate_order_page($sub_page, $row_id,$status, $page_title, $page_header, $base_url, $base_menu) {
		$view_data = array();

		switch ($sub_page) {
			case 'coupon' :
				$st  = substr($status, 0,1);
				$d_now = date("Y-m-d H:i:s");
				if ($st == 2) // เปลี่ยนสถานะเป็นชำระเงินเรียบร้อยแล้ว
				{
					$this->load->model("deal_order");
					$this->load->model("member_orderdetail");
					
					$pre_receive_id	=	$this->deal_order->get_pre_receive_id();
					$payment  = substr($status, 1,1);
					$data = array('o.order_status' => $st,
												'o.order_modify' => $d_now,
												'o.order_pay_date' => $d_now,
												'o.payment_type' => $payment,
												'o.receipt_id' => $pre_receive_id);
					$this -> db -> where('o.order_id', $row_id);
					$this -> db -> update('tbl_deal_order o', $data);
					
					$order_data	=	$this->deal_order->get_order_by_id($row_id);
					
					$order_id		=	$order_data["order_id"];
					$member_id	=	$order_data["mem_id"];
					
					$this->load->library('email');

					
					$view_data["order"]					=	$this->member_orderdetail->ShowOrderDetail($order_id,$member_id);
					$view_data["order_date"]			=	$this->convert_date->show_thai_date($view_data["order"]["order"]["order_date"])." เวลา ".date("H:i:s",strtotime($view_data["order"]["order"]["order_date"]))." น.";
				
					$member_email 	=	$view_data["order"]["member"]["member_email"];
					
					$this->email->from('info@thebestdeal1.com');
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
				}else{  // เปลี่ยนสถานะเป็นคืนเงิน หรือ ยกเลิก
					$data = array('o.order_status' => $status,'o.order_modify' => $d_now);
					
					$this -> db -> where('o.order_id', $row_id);
					$this -> db -> update('tbl_deal_order o', $data);
				}
				unset($data);
				
				$this->db->select('o.order_id,o.mem_id,od.deal_id,od.product_id,d.deal_start,d.deal_expile,od.product_qty,od.product_id');
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
						
						$data = array('mem_id' => $coupon["mem_id"], 'order_id' => $coupon["order_id"], 'deal_id' => $coupon["deal_id"],
						'product_id' => $coupon["product_id"], 'coupon_can_use' => $coupon["deal_start"],
						'coupon_expire' =>$coupon["deal_expile"],'voucher_number' =>$voucher_number,
						'redemption_code' =>$redemption_code,'coupon_status' => '1', 'coupon_create_time' => $d_now);
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
				echo "<script>window.location.href='" . $base_url . "'</script>";
				return 0;
				break;
				
				case 'delete' :
				
					$d_now = date("Y-m-d H:i:s");
					$data = array('order_status' => '0','order_modify' => $d_now);
					
					$this -> db -> where('order_id', $row_id);
					$this -> db -> update('tbl_deal_order', $data);
					
					echo "<script>window.location.href='" . $base_url . "'</script>";
				
				return 0;
				break;
		case 'view_data':
				$this->load->model('member_orderDetail');
				$content_data["order_data"]		=	$this->member_orderDetail->ShowOrderDetail($row_id,$status);
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
		
				$this->page_data["content"]		=	$this -> load -> view('administrator/deal_order/admin_orderDetail.php',$content_data,true);
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
				$view_data["deal_order"]		=	$this->member_orderDetail->ShowOrderMember('');
				$view_data["sub_page"] = "";
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
		$this -> load -> view('administrator/deal_order/popup_payment.php',$view_data);
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
				
				foreach($base_table_ref as $tbrf){		
						$this -> db -> where($tbrf['status'], '1');
						$query = $this -> db -> get($tbrf['tb']);
						$view_data[$tbrf['tb']] = $query -> result_array();
				}
				
				$this->db->order_by("province_name","ASC");
				$query = $this -> db -> get("tbl_province_data");
				$view_data["tbl_province_data"] = $query -> result_array();
				
				$this -> page_data["content"] = $this -> load -> view($base_url . '/form.php', $view_data, true);
				break;

			case 'insert' :
				unset($data["submit"]);
				unset($data["data_form"]);
				
				$this->load->model("deal_main");
				$data["deal_id"]						=	$this->deal_main->get_deal_id();	
				$deal_id								=	$data["deal_id"];	

				$data["deal_buy_time_start"]	=	$this->get_db_date($data["deal_buy_time_start"]);
				$data["deal_buy_time_end"]	=	$this->get_db_date($data["deal_buy_time_end"]);
				$data["deal_start"]					=	$this->get_db_date($data["deal_start"]);
				$data["deal_expile"]				=	$this->get_db_date($data["deal_expile"]);
				$data["deal_create"]				=	date("Y-m-d H:i:s",time());
				$data["deal_modify"]				=	date("Y-m-d H:i:s",time());
				
				$upload_path							=	'deal/'.($deal_id%10).'/'.$deal_id;
				$input_name							=	"deal_index_image";
				
				if(!empty($_FILES[$input_name]["type"]))
				{
					$type_image							=	explode("/",$_FILES[$input_name]["type"]);
					$file_name								= 	"deal_index_image.".$type_image[1];
				
					$this->do_upload($upload_path,$file_name,$input_name);
				
					$data["deal_index_image"]		=	'upload/deal/'.($deal_id%10).'/'.$deal_id.'/'.$file_name;
				}
				
				$input_name							=	"deal_map";
				
				if(!empty($_FILES[$input_name]["type"]))
				{
					$type_image							=	explode("/",$_FILES[$input_name]["type"]);
					$file_name								= 	"deal_map.".$type_image[1];
				
					$this->do_upload($upload_path,$file_name,$input_name);
				
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
				echo "<script>window.location.href='" . $base_url ."/main/0/".$vendor_id. "'</script>";
				unset($data);
				return 0;
				break;

			case 'update' :
				unset($data["submit"]);
				unset($data["data_form"]);
				
				$data["deal_buy_time_start"]	=	$this->get_db_date($data["deal_buy_time_start"]);
				$data["deal_buy_time_end"]	=	$this->get_db_date($data["deal_buy_time_end"]);
				$data["deal_start"]					=	$this->get_db_date($data["deal_start"]);
				$data["deal_expile"]				=	$this->get_db_date($data["deal_expile"]);
				$data["deal_modify"]				=	date("Y-m-d H:i:s",time());
				
				$deal_id								=	$row_id;	
				
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
						$this->do_upload($upload_path,$file_name,$input_name);
				
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
				unset($data);
				echo "<script>window.location.href='" . $base_url ."/main/0/".$vendor_id. "'</script>";
				return 0;
				break;

			case 'delete' :
				$this -> db -> where($base_pk, $row_id);
				$this -> db -> delete($base_table);
				echo "<script>window.location.href='" . $base_url ."/main/0/".$vendor_id. "'</script>";
				return 0;
				break;

			default :
				$view_data = array();
				$this->load->model('deal_main');
				$this->load->model('category_main');
				$this->load->model('vendor_profile');
				
				if(!empty($vendor_id))
				{
					$view_data["deal_data"]		=	$this->deal_main-> get_deal_by_vendor_id($vendor_id);
					$view_data["vendor_id"]		=	$vendor_id;
				}else{
					$view_data["deal_data"]		=	$this->deal_main->get_all_deal();
				}
				
				$view_data["cat_data"]			= $this->category_main->get_all_category();
				$view_data["vendor_data"]		= $this->vendor_profile->get_all_vendor_profile();
						
				$this -> page_data["content"] = $this -> load -> view($base_url . '/main.php', $view_data, true);

				break;
		}

		$this -> page_data["page_title"] = $page_title;
		$this -> page_data["page_header"] = $page_header;
		$this -> render -> page_render($this -> page_data);

		unset($view_data);
	}

	public function deal_order($sub_page = '', $row_id = '',$senddata='',$start_date='',$end_date='',$buy_status='') 
	{
		$this->check_admin_login();
		//start config
		$base_table_ref = array();
		
		$page_title 	= ":: ข้อมูลการสั่งซื้อ ::";
		$page_header = ":: ข้อมูลการสั่งซื้อ ::";

		$base_url = "/administrator/deal_order";
		$base_menu = "ข้อมูลการสั่งซื้อ";
		
		//end config
		$this -> generate_order_page($sub_page, $row_id,$senddata, $page_title, $page_header, $base_url, $base_menu);
	}
	
	
	private function generate_coupon_page($sub_page, $row_id, $page_title, $page_header, $base_url, $base_menu) {
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

	public function coupon_manage($sub_page = '', $row_id = '') {
		$this->check_admin_login();
		//start config
		$base_table_ref = array();
		
		$page_title = ":: Coupon  Management ::";
		$page_header = ":: Coupon  Management ::";

		$base_url = "/administrator/coupon_manage";
		$base_menu = "ข้อมูลคูปอง";

		$view_data = array();

		switch ($sub_page) {
				default :
				$this->load->model('member_coupon');
				$view_data["coupon_data"]		=		$this->member_coupon->get_all_coupon();
				
				$this -> page_data["content"] = $this -> load -> view($base_url . '/main.php', $view_data, true);
				break;
		}

		$this -> page_data["page_title"] = $page_title;
		$this -> page_data["page_header"] = $page_header;
		$this -> render -> page_render($this -> page_data);

		unset($view_data);
	}
	
	private function do_upload($upload_path,$file_name,$input_name,$resize=array(),$thumb=array())
	{
		$target_path = $_SERVER["DOCUMENT_ROOT"]."/assets/images/upload/".$upload_path."/";

		if(!is_dir($target_path))
		{
			mkdir($target_path);
			chmod($target_path,0777);
		}
		$target_path = $target_path.$file_name; 

		move_uploaded_file($_FILES[$input_name]['tmp_name'], $target_path);
		chmod($target_path,0777);
		
		if(sizeof($thumb)>0)
		{
			$config['image_library'] 	= 'gd2';
			$config['source_image'] 	= $target_path;
			$config['new_image'] 		= $_SERVER["DOCUMENT_ROOT"]."/assets/images/upload/".$thumb["save_path"]."/".$thumb["pic_name"];
			$config['create_thumb'] 	= TRUE;
			$config['maintain_ratio'] 	= TRUE;
			$config['width'] 	= $thumb["width"];
			$config['height'] = $thumb["height"];

			$this->load->library('image_lib', $config);

			$this->image_lib->resize();
		}			
		if(sizeof($resize)>0)
		{
			$config['image_library'] 	= 'gd2';
			$config['source_image'] 	= $target_path;
			$config['new_image'] 		= $_SERVER["DOCUMENT_ROOT"]."/assets/images/upload/".$resize["save_path"]."/".$resize["pic_name"];
			$config['width'] 				= $resize["width"];
			$config['height'] 			= $resize["height"];
			$config['master_dim']		=	'height';
			
			$this->load->library('image_lib', $config);

			$this->image_lib->resize();
		}	
	}
	public function logout()
	{
			$cookie = array(
    				'name'   => 'auto_login_id',
    				'value'  =>$this->member_id,
    				'expire' => (time()-10),
    				'domain' => '',
    				'path'   => '/',
    				'prefix' => '',
   	 				'secure' => TRUE
			);
			$this->input->set_cookie($cookie);
			$this->session->unset_userdata('admin_id');
			$this->session->unset_userdata('back_page');
			echo '
			<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
			<html xmlns:fb="http://ogp.me/ns/fb#">
			<head>
				<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
				<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
				<meta http-equiv="Cache-control" content="no-cache">
			</head>
			<body>
				<script>window.location.href = "/administrator";</script>
			</body>
			</html>
			';
	}
	public function print_coupon($deal_id,$coupon_id,$member_id)
	{
		$this->check_admin_login();
		
		$this->load->model('coupon_main');
		
		$this->page_data["page_title"]	=	"The Best Deal One ::คูปอง";
		
		$coupon							= $this->coupon_main->get_coupon($member_id,$deal_id,$coupon_id);
		
		$coupon_data["deal_id"]			=	$deal_id;
		$coupon_data["deal_name"]	=	$coupon["deal_main"]["deal_name"];
		$coupon_data["fine_print"] 		= $coupon["deal_main"]["deal_main_detail"];
		$coupon_data["vendor_logo"]	=	$coupon["deal_main"]["vendor_logo"];
		$coupon_data["location"] 		= $coupon["deal_main"]["location"];
		$coupon_data["deal_main_condition"] = $coupon["deal_main"]["deal_main_condition"];
		$coupon_data["mem_name"]	=	$coupon["member"]["member_name"]."   ".$coupon["member"]["member_sname"];
		$coupon_data["member_id"]	=	$coupon["member"]["member_id"];
		$coupon_data["barcode"]		=	$coupon["coupon"]["barcode"];
		$coupon_data["coupon_id"]		=	$coupon["coupon"]["coupon_id"];
		$coupon_data["voucher_number"] = $coupon["coupon"]["voucher_number"];
		$coupon_data["order_id"]		=	$coupon["coupon"]["order_id"];
		$coupon_data["redemption_code"]	=	$coupon["coupon"]["redemption_code"];
		$coupon_data["product_name"] 		= $coupon["coupon"]["product_name"];
		$coupon_data["product_detail"] 		= $coupon["coupon"]["product_detail"];
		$coupon_data["coupon_can_use"] 	= $coupon["coupon"]["coupon_can_use"];
		$coupon_data["coupon_expire"] 		= $coupon["coupon"]["coupon_expire"];
	
		$this -> load -> view('member/printcoupon.php',$coupon_data);
	}
	public function check_email()
	{
		
		$email	=	$this->input->post('member_email');
		$this->load->model('member_profile');
		
		if(!$this->member_profile->has_email($email))
		{
			echo "true";
		}else{
			echo "0";
		}
	}
	public function check_vendor_email()
	{
		$email	=	$this->input->post('vendor_email');
		$this->load->model('vendor_profile');
		
		if(!$this->vendor_profile->has_email($email))
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
		$page_title = ":: I Want It Management ::";
		$page_header = ":: I Want It Management ::";

		$base_table = "tbl_iwantit";
		$base_table_main = "tbl_deal_main";
		$base_url = "/administrator/iwantit";
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
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
?>