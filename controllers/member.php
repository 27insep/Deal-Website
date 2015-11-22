<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Member extends CI_Controller {
	protected $layout = 'template/fontend_template.php';
	
	protected $stylesheets = array(

    	'slide/demo.css',
    	'slide/style.css',
    	'base.css',
    	'receipt.css',
    	'blitzer/jquery-ui.css',
    	'member.css',
    	'fancybox/jquery.fancybox.css?v=2.1.4',
    	'fancybox/helpers/jquery.fancybox-buttons.css?v=1.0.5',
    	'fancybox/helpers/jquery.fancybox-thumbs.css?v=1.0.7'
  	);
	
  	protected $javascripts = array(
  		'jquery.min.js',
  		'jquery.validate.js',
  		'jquery.form.js',
		'jquery-ui.min.js',
		'jquery.mousewheel-3.0.6.pack.js',
		'fancybox/jquery.fancybox.js?v=2.1.4',
		'fancybox/helpers/jquery.fancybox-buttons.js?v=1.0.5',
		'fancybox/helpers/jquery.fancybox-thumbs.js?v=1.0.7',
		'fancybox/helpers/jquery.fancybox-media.js?v=1.0.5'
  	);
	
	protected $page_data 	= 	array();
	protected $member_id;
	protected $admin_id;
	
	public function __construct()
   	{
    	parent::__construct();
      	// Your own constructor code
      	//config page rend
		$params = array(
			'layout' => $this->layout, 
			'stylesheets' => $this->stylesheets,
			'javascripts'=>$this->javascripts
		);
		
		$this->load->library('render', $params);
		$this->load->library('convert_date');
		$this->load->library('session');
		
		$this->load->database();
		
		$this->load->model('category_main');
		$this->load->model('deal_order');
		$this->load->model('deal_main');
		$this->load->model('member_profile');
		$this->load->model('xlog_member_login');
		$this->load->model('coupon_history_main');
		$this->load->model('member_order');
		$this->load->model('coupon_main');
		$this->load->model('member_orderDetail');
		$this->load->model('member_receipt');
		$this->load->model('province_data');
		
		$this->member_id =	$this->session->userdata('member_id');
		$this->admin_id =	$this->session->userdata('admin_id');
  	}
	private function check_login()
	{
		//echo $this->member_id."-----------------";
		if(empty($this->member_id)&&empty($this->admin_id))
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
				<script>window.location.href = "/";</script>
			</body>
			</html>
			';
			exit;
			return 0;
		}
	}
	
	public function popup_changepass()
	{
		$this -> load -> view('member/member_popup_changepass.php');
	}
	
	public function popup_forget_password()
	{
		$this->load->helper('captcha');

      	$vals = array(
      		'word'	 => rand(11111,99999),
           	'img_path' => $_SERVER["DOCUMENT_ROOT"].'/assets/images/captcha/',
          	'img_url' => 'http://www.thebestdeal1.com/assets/images/captcha/',
          	'font_path'	 => $_SERVER["DOCUMENT_ROOT"].'/fonts/SIXTY.TTF',
          	'img_width' => '150',
          	'img_height' => 30,
          	'border' => 0, 
        	'expiration' => 7200
      	);
    
       	// create captcha image
      	$cap = create_captcha($vals);
		
       	// store image html code in a variable
      	$view_data['capcha'] = $cap['image'];
		
		 // store the captcha word in a session
       	$this->session->set_userdata('word', $cap['word']);

		$this -> load -> view('member/member_popup_forget_password.php',$view_data);
	}

	public function popup_register()
	{
		$this -> load -> view('member/member_popup_register.php');
	}
	
	private function  get_default_content()
	{
		$content_data	=	array();
		$content_data["member_main_menu"]		=	$this -> load -> view('member/member_main_menu.php','', true);
		$content_data["head_title"]	=	"โปรไฟล์ของฉัน";
		
		$view_data["expile_soon"]		=	$this->coupon_main->get_coupon_expile_soon($this->member_id);
		$view_data["wait_payment"]	=	$this->member_order->get_waitting_payment($this->member_id);
		
		$content_data["right_sec"]		=	$this->load->view('member/member_right_sec.php',$view_data,true);
		return $content_data;
	}
	public function index()
	{
		$this->special();
	}
	public function special($deal_id="")
	{
		$this->check_login();

		$this->page_data["page_title"]	=	"The Best Deal One :: โปรไฟล์ของฉัน";
	
		$content_data =	$this->get_default_content();
		$content_data["member_data"]		=	$this->member_profile->get_member_profile_by_id($this->member_id );
		$content_data["province_data"]		=	$this->province_data->get_all_province();
		$content_data["deal_id"] = $deal_id;
			
		$this->page_data["content"]			= $this->load->view('member/member_profile.php',$content_data,true);
    	
    	$this->render->fontend_page_render($this->page_data);
	}
	public function my_order($page="",$status="",$pre_order_id="",$payment_type="")
	{
		$fill_status			=	$this->input->post('search_status');
		if($fill_status == null)
			$fill_status = "";
		
		if(!empty($status))
			$fill_status = $status;
		
		$this->check_login();
		
		$this->page_data["page_title"]	=	"The Best Deal One :: คำสั่งซื้อของฉัน";
		
		$per_page		=	10;
		
		if(empty($page))
		{
			$st = 0;
		}else{
			$st	=	($page-1)*$per_page;
		}
		
		$total_active_order	=	$this->member_order->get_total_active_order($this->member_id,$fill_status);
		
		if($st>=$total_active_order)
			$st = 0;
		
		if ($total_active_order%$per_page == 0)
			$max_page			=	(int)($total_active_order/$per_page);
		else 
			$max_page			=	(int)($total_active_order/$per_page)+1;
		
		//echo $total_active_deal;
		$nevigotor_page		=	"<div>หน้า : </div>";
		
		for($i=1;$i<=$max_page;$i++)
		{
			$nevigotor_page		.=	'<a href="/member/my_order/'.$i.'">'.$i.'</a>';
		}
		
		$order_data  = $this->member_order->get_active_order($this->member_id,$st,$per_page,$fill_status);
		
		$content_data								=	$this->get_default_content();
	
		if(sizeof($order_data)!=0)
		{
			$order_id = "";
			foreach ($order_data as $order) {
				if($order_id != "")
					$order_id .= ",".$order["order_id"];
				else
					$order_id = $order["order_id"];
			}
			$content_data["pre_order_id"]			=	$pre_order_id;	
			$content_data["payment_type"]		=	$payment_type;	
			$content_data["member_data"]		=	$this->member_order->showorder($order_id);
			$content_data["member_id"] 			= $this->member_id;
			$content_data["page_navigator"]		=	$nevigotor_page;
			$content_data["have_order"]			=	true;
		}else{
			$content_data["have_order"]			=	false;
		}
		
		$content_data["page"] = $page;
		$content_data["status"] = $status;
		$content_data["pre_order_id"] = $pre_order_id;

		$content_data["fill_staus"] = $fill_status;
		$this->page_data["content"]			=	$this -> load -> view('member/member_order.php',$content_data,true);
    	$this->render->fontend_page_render($this->page_data);
	}
	
	public function my_orderstatus($order_id,$upStatus)
	{
			if($upStatus != "")
				$this->member_order->status_cancel($order_id,$upStatus);
			$this->my_order();
	}
	
	public function my_orderdetail($order_id="")
	{
		$this->check_login();
		$this->page_data["page_title"]	=	"The Best Deal One :: รายละเอียดคำสั่งซื้อของฉัน";
		
		$content_data							=	$this->get_default_content();
		$content_data["order_data"]		=	$this->member_orderDetail->ShowOrderDetail($order_id,$this->member_id);
		
		switch($content_data["order_data"]["order"]["payment_type"])
		{
			case 0:
				$content_data["payment"] = "";
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
			case 8:
				$content_data["payment"] = "No Payment Required";
			break;
		}

		$this->page_data["content"]		=	$this -> load -> view('member/member_orderDetail.php',$content_data,true);
    	$this->render->fontend_page_render($this->page_data);
	}
	
	public function print_coupon($deal_id="",$coupon_id="")
	{
		$this->check_login();
		
		$this->page_data["page_title"]	=	"The Best Deal One ::คูปอง";
		
		$content_data					=	$this->get_default_content();
		$coupon							= $this->coupon_main->get_coupon($this->member_id,$deal_id,$coupon_id);
		
		$coupon_data["deal_id"]			=	$deal_id;
		$coupon_data["deal_name"]	=	$coupon["deal_main"]["deal_name"];
		$coupon_data["fine_print"] 		= $coupon["deal_main"]["deal_main_detail"];
		$coupon_data["vendor_logo"]	=	$coupon["deal_main"]["vendor_logo"];
		$coupon_data["location"] 		= $coupon["deal_main"]["location"];
		$coupon_data["deal_main_condition"] = $coupon["deal_main"]["deal_main_condition"];
		$coupon_data["vendor_email"] 		= $coupon["deal_main"]["vendor_email"];
		$coupon_data["vendor_website"] = $coupon["deal_main"]["vendor_website"];
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

	/*
   public function printcoupon($deal_id="",$coupon_id="",$member_id="")
	{	
		if ($this->session->userdata('admin_id') == "")
			$this->check_login();
		else
			$this->member_id = $member_id;
		
		$this->page_data["page_title"]	=	"The Best Deal One ::คูปอง";
		
		$content_data							=	$this->get_default_content();
		$coupon							= $this->coupon_main->get_coupon($this->member_id,$deal_id,$coupon_id);
		
		$coupon_data["deal_name"]	=	$coupon["deal_main"]["deal_name"];
		$coupon_data["fine_print"] = $coupon["deal_main"]["deal_main_detail"];
		$coupon_data["vendor_logo"]	=	$coupon["deal_main"]["vendor_logo"];
		$coupon_data["location"] = $coupon["deal_main"]["location"];
		$coupon_data["deal_main_condition"] = $coupon["deal_main"]["deal_main_condition"];
		$coupon_data["mem_name"]	=	$coupon["member"]["member_name"]."   ".$coupon["member"]["member_sname"];
		$coupon_data["member_id"]=	$coupon["member"]["member_id"];
		$coupon_data["barcode"]=	$coupon["coupon"]["barcode"];
		$coupon_data["coupon_id"]=	$coupon["coupon"]["coupon_id"];
		$coupon_data["voucher_number"] = $coupon["coupon"]["voucher_number"];
		$coupon_data["order_id"]	=	$coupon["coupon"]["order_id"];
		$coupon_data["redemption_code"]	=	$coupon["coupon"]["redemption_code"];
		$coupon_data["product_name"] = $coupon["coupon"]["product_name"];
		$coupon_data["product_detail"] = $coupon["coupon"]["product_detail"];
		$coupon_data["coupon_can_use"] = $coupon["coupon"]["coupon_can_use"];
		$coupon_data["coupon_expire"] = $coupon["coupon"]["coupon_expire"];
	
		$this -> load -> view('member/printcoupon.php',$coupon_data);
	}
	*/	
	public function my_receipt($order_id="")
	{
		$this->check_login();
		
		$this->page_data["page_title"]	=	"The Best Deal One :: ใบเสร็จรับเงิน";
		
		$content_data							=	$this->get_default_content();
		$content_data["order_data"]		=	$this->member_receipt->showreceipt($order_id);
	
		$this -> load -> view('member/member_receipt.php',$content_data);
		 
	}

	public function my_docorder($order_id="")
	{
		$this->check_login();
		$this->page_data["page_title"]	=	"The Best Deal One :: ใบสั่งซื้อ";
		
		$content_data							=	$this->get_default_content();
		$content_data["order_data"]		=	$this->member_receipt->showreceipt($order_id);
		
		switch($content_data["order_data"]["order"]["payment_type"])
		{
			case 0:
				$content_data["payment"] = "";
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
			case 8:
				$content_data["payment"] = "No Payment Required";
			break;
		}
		
		$this -> load -> view('member/member_docorder.php',$content_data);
	}
	
	public function my_coupon($page='',$upStatus='',$data='')
	{
		$fill_status =	$this->input->post('coupon_status');
		echo $fill_status;
		if($fill_status == null)
			$fill_status = "";
		
		$this->check_login();
		
		if($upStatus != "")
		{
				$this->coupon_history_main->coupon_updateStatus($upStatus,$data);
		}
		$this->page_data["page_title"]	=	"The Best Deal One :: คูปองของฉัน";
		
		$per_page  =	5;
		
		if(empty($page))
		{
			$st = 0;
		}else{
			$st	=	($page-1)*$per_page;
		}
		
		$total_active_order	=	$this->coupon_history_main->get_total_active_coupon($this->member_id);
		
		if($st>=$total_active_order)
			$st = 0;
		
		if ($total_active_order%$per_page == 0)
			$max_page			=	(int)($total_active_order/$per_page);
		else 
			$max_page			=	(int)($total_active_order/$per_page)+1;
		
		//echo $total_active_deal;
		$nevigotor_page		=	"<div>หน้า : </div>";
		
		for($i=1;$i<=$max_page;$i++)
		{
			$nevigotor_page		.=	'<a href="/member/my_coupon/'.$i.'">'.$i.'</a>';
		}

		$order_data  = $this->coupon_history_main->get_active_coupon($this->member_id,$st,$per_page);
		
		$order_id = "";
		foreach ($order_data as $order) {
			if($order_id != "")
				$order_id .= ",".$order["order_id"];
			else
				$order_id = $order["order_id"];
		}
		
		if($page == "")
			$page = 1;
		
		$content_data							=	$this->get_default_content();
		
		if(!empty($order_id))
		{
			$content_data["coupon_data"]		=	$this->coupon_history_main->coupon_history($order_id,$fill_status);
			if($content_data["coupon_data"]["total_rows"] > 0)
				$have_coupon	=	true;
			else 
				$have_coupon	=	false;
		}else{
			$have_coupon	=	false;
		}
		$content_data["have_coupon"]	=	$have_coupon;
		$content_data["page_navigator"]		=	$nevigotor_page;
		$content_data["page"] = $page;
		$content_data["coupon_status"] = $fill_status;
		$this->page_data["content"]		=	$this -> load -> view('member/member_coupon.php',$content_data,true);
		
    	$this->render->fontend_page_render($this->page_data);
	}
	public function my_invite()
	{
		$this->check_login();
		
		$this->page_data["page_title"]	=	"The Best Deal One :: คำเชิญของฉัน";
		$content_data							=	$this->get_default_content();
		$content_data["member_id"]		=	$this->member_id;
		$this->page_data["content"]		=	$this -> load -> view('member/member_invite.php',$content_data, true);
	
    	$this->render->fontend_page_render($this->page_data);
	}
	public function activate_user($activate_code)
	{
			$activate			=	base64_decode($activate_code);
			$activate_data	=	explode(",",$activate);
			
			$this->page_data["page_title"]	=	"The Best Deal One :: ยื่นยันอีเมล";
			
			if($this->do_login($activate_data[0],$activate_data[1],"sytem"))
			{
				$this->member_profile->activate_user($this->member_id);
			}else{
				return 0;
				exit;
			}
			
			$this->page_data["content"]		=	$this -> load -> view('signup/signup_activate.php','', true);
    		$this->render->fontend_page_render($this->page_data);
	}
	public function fb_login()
	{
		$email	=	$this->input->post('email');
		if(!$this->member_profile->has_email($email))
		{
				$ref_id			=	"";
				$password		=	rand(100000,999999);
				$subscript		=	1;
				
				$this->member_profile->add_user($email,$password,$subscript,$ref_id);
		
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
				
				$password	=	base64_encode($password);
				
				$this-> do_login($email,$password);
		}else{
			$member_data	=	$this->member_profile->get_member_profile_by_email($email);
			$password			=	base64_decode($member_data["member_pwd"]);
			
			$this->do_login($email,$password);
		}
		echo 1;
	}
	public function login()
	{
		$email			=	$this->input->post('login_name');
		$password		=	$this->input->post('login_pwd');
		$capcha_login		    =	$this->input->post('capcha_login');
		
		echo $this->do_login($email,$password,$capcha_login);
	}
	
	public function chagepwd()
	{
		$this->check_login();
		$pwd_new		=	$this->input->post('txt_new');
		$pwd_confirm		=	$this->input->post('txt_confirm');
		$pwd_old		=	$this->input->post('txt_old');
		$password_new		=	base64_encode($pwd_new);
		$password_old	=	base64_encode($pwd_old);
		
		if ($pwd_confirm != $pwd_new)
			return "2";
		
		$check_pwd	=  $this->member_profile->check_password($this->member_id,$password_old);
		
		if($check_pwd == true){
			$this->member_profile->update_changepwd($this->member_id,$password_new);
			return "1";
		}
		else {
			return "0";
		}
	}
	
	private function do_login($email,$password,$capcha)
	{
		$password		=	base64_encode($password);
		$member_data	=  $this->member_profile->get_member_profile_by_login($email,$password);
		
		if($this->session->userdata('login_3') == 3)
		{
			if(empty($capcha)){
				 return "3";
			}else{
				 if($capcha!=$this->session->userdata('word_login')&&$capcha!='sytem')
				 	 return "4";
				 else 
				 	$this->session->set_userdata('login_3',0);
			}
		}
		
		if(sizeof($member_data)>0)
		{
			$remeberme					=	$this->input->post('remeberme');
			$this->member_id			=	$member_data["member_id"];
			$member_last_login		=	$member_data["member_last_login"];
			unset($member_data);
			
			if($remeberme)
			{
				$cookie = array(
    				'name'   => 'auto_login_id',
    				'value'  =>$this->member_id	,
    				'expire' => (60*60*24*30),
    				'domain' => '',
    				'path'   => '/',
    				'prefix' => '',
   	 				'secure' => TRUE
				);
				$this->input->set_cookie($cookie);
			}

			$this->session->set_userdata('member_id',$this->member_id);
			$this->session->set_userdata('member_email',$email);
			$this->session->set_userdata('member_last_login',$member_last_login);
			
			$this->xlog_member_login->save_log($this->member_id,1);
			
			$deal_id =	$this->input->post('deal_id');
			if ($deal_id != "")
			{
				$deal 			= $this->deal_main->get_deal_by_id($deal_id);
				if($deal["deal_special"]!="1")
				{
						$this->load->library('user_agent');
						$agent	=	"";
						if ($this->agent->is_browser())
						{
		   	 				$agent = $this->agent->browser().' '.$this->agent->version();
						}
						elseif ($this->agent->is_robot())
						{
		    				$agent = $this->agent->robot();
						}
						elseif ($this->agent->is_mobile())
						{
		    				$agent = $this->agent->mobile();
						}
						else
						{
		   					 $agent = 'Unidentified User Agent';
						}
		
						$log_data	=	array(
							"log_code"=>"1002",
							"log_detail"=>$agent." : member = ".$member_id." / ".$deal_id,
							"log_time"=>date("Y-m-d H:i:s")
						);
						$this -> db -> insert("error_log", $log_data);
						
						exit;
						return 5; 
				}else{
						$mem_profile = $this->member_profile->get_member_profile_by_id($this->member_id);
						if(!empty($mem_profile["member_name"]) && !empty($mem_profile["member_sname"]))
						{
								$pre_order_id	=	$this->deal_order->get_pre_oreder_id($this->member_id);
								$product = $this->deal_main->get_product_special($deal_id,$this->member_id);
								
										if($product != ""){
											
											$product_set	=	array();
											$product_set[$product]["qty"] =	1;
											$product_set[$product]["deal_id"] =	$deal_id;
											$deal = $this->deal_main->get_deal_by_id($deal_id);
										 	$this->deal_order->add_order($this->member_id, $product_set ,0, $pre_order_id, 8,1);
											$this->deal_main->update_buy_count($deal_id);
											$d_now = date("Y-m-d H:i:s");
											
										if(strlen($product)<6)
											{
													$product_id = $product;
													for($j=strlen($product);$j<6;$j++)
														$product_id = "0". $product_id;
											}	
											$qty_product 	= $this->coupon_main->get_product_qty($product_id);
														
											if(strlen($qty_product)<6)
											{
													$qty = $qty_product;
													for($j=strlen($qty_product);$j<6;$j++)
														$qty = "0". $qty;
											}
												
											if(strlen($qty_product)<6)
											{
													$qty = $qty_product;
													for($j=strlen($qty_product);$j<6;$j++)
														$qty = "0". $qty;
											}
											
											$voucher_number = $product_id."-".$qty;
											$redemption_code = rand(1000,9999);
											
											
											$data = array('mem_id' => $this->member_id, 'order_id' => $pre_order_id, 'deal_id' => $deal_id,
																		'product_id' => $product, 'coupon_can_use' => $deal["deal_start"],
																		'coupon_expire' =>$deal["deal_expile"],'voucher_number' =>$voucher_number,
																		'redemption_code' =>$redemption_code,'coupon_status' => '1', 'coupon_create_time' => $d_now);
																		$this -> db -> insert('tbl_coupon', $data);
																		
											$this->db->select('coupon_id');
											$this->db->from("tbl_coupon");
											$this->db->order_by("coupon_id", "desc"); 
											$query		=	$this->db->get();
											$nCoupon	=	$query->row_array();
											$nRow		=	$nCoupon["coupon_id"]+1;
											
											$fill_zero	=	8-strlen($nRow);
											for($i=0;$i<$fill_zero;$i++)
											{
												$nRow	=	"0".$nRow;
											}
						
											$barcode	=	$nRow."00000000";
											
											$data = array(
				               					'barcode' => $barcode
				            				);
											$this->db->where('coupon_id', $nCoupon["coupon_id"]);
											$this->db->update('tbl_coupon', $data);
											
											return "4";
								}else{
									return "2";
								} //end else  $product != ""
						} // end if(!empty($mem_profile["member_name"]) && !empty($mem_profile["member_sname"]))
						else
								return $deal_id;
				} // end else $special = 1 
			}else // login ปกติ
					return "5";
		}else{  // ถ้า login ผิด
			$login_count	= $this->session->userdata('login_3');
			
			if ($login_count == 2){  // login ผิด 3 ครั้ง
				$this->session->set_userdata('login_3',$login_count+1);
				return "1";
			}
			else{ // login ผิด ไม่ถึง 3 ครั้ง
				$this->session->set_userdata('login_3',$login_count+1);
				return "0";
			}
		}
	}
	public function save_profile()
	{
		$this->check_login();
		
		$member_name			= $this->input->post("member_name");
		$member_sname		= $this->input->post("member_sname");
		$member_gendar		= $this->input->post("member_gendar");
		$member_birth_date	= $this->input->post("member_birth_date");
		$member_ssn			= $this->input->post("member_ssn");
		$member_mobile		= $this->input->post("member_mobile");
		$subscript					=	$this->input->post("subscript");
		$member_address		= $this->input->post("member_address");
		$city_name				= $this->input->post("city_name");
		$province_id				= $this->input->post("province_id");
		$member_zipcode		= $this->input->post("member_zipcode");
	    $deal_id		= $this->input->post("deal_id");
			
		if($subscript!=1)
				$subscript	=	0;		
		
		$this->member_profile->update_profile($this->member_id,$member_name,$member_sname,$member_gendar,$member_birth_date,$member_ssn,$member_mobile,$subscript,$member_address,$city_name,$province_id,$member_zipcode);
	
		if($deal_id != "")
		{
			$deal 			= $this->deal_main->get_deal_by_id($deal_id);

				if($deal["deal_special"]!="1")
				{
						$this->load->library('user_agent');
						$agent	=	"";
						if ($this->agent->is_browser())
						{
		   	 				$agent = $this->agent->browser().' '.$this->agent->version();
						}
						elseif ($this->agent->is_robot())
						{
		    				$agent = $this->agent->robot();
						}
						elseif ($this->agent->is_mobile())
						{
		    				$agent = $this->agent->mobile();
						}
						else
						{
		   					 $agent = 'Unidentified User Agent';
						}
		
						$log_data	=	array(
							"log_code"=>"1002",
							"log_detail"=>$agent." : member = ".$this->member_id." / ".$deal_id,
							"log_time"=>date("Y-m-d H:i:s")
						);
						$this -> db -> insert("error_log", $log_data);
						
						echo "5";
				}else{
						$pre_order_id	=	$this->deal_order->get_pre_oreder_id($this->member_id);
						$product = $this->deal_main->get_product_special($deal_id,$this->member_id);
						 
								if($product != ""){
									
									$product_set	=	array();
									$product_set[$product]["qty"] =	1;
									$product_set[$product]["deal_id"] =	$deal_id;
									$deal = $this->deal_main->get_deal_by_id($deal_id);
								 	$this->deal_order->add_order($this->member_id, $product_set ,0, $pre_order_id, 8,1);
									$this->deal_main->update_buy_count($deal_id);
									$d_now = date("Y-m-d H:i:s");
									
								if(strlen($product)<6)
									{
											$product_id = $product;
											for($j=strlen($product);$j<6;$j++)
												$product_id = "0". $product_id;
									}	
									$qty_product 	= $this->coupon_main->get_product_qty($product_id);
												
									if(strlen($qty_product)<6)
									{
											$qty = $qty_product;
											for($j=strlen($qty_product);$j<6;$j++)
												$qty = "0". $qty;
									}
										
									if(strlen($qty_product)<6)
									{
											$qty = $qty_product;
											for($j=strlen($qty_product);$j<6;$j++)
												$qty = "0". $qty;
									}
									
									$voucher_number = $product_id."-".$qty;
									$redemption_code = rand(1000,9999);
									
									
									$data = array('mem_id' => $this->member_id, 'order_id' => $pre_order_id, 'deal_id' => $deal_id,
																'product_id' => $product, 'coupon_can_use' => $deal["deal_start"],
																'coupon_expire' =>$deal["deal_expile"],'voucher_number' =>$voucher_number,
																'redemption_code' =>$redemption_code,'coupon_status' => '1', 'coupon_create_time' => $d_now);
																$this -> db -> insert('tbl_coupon', $data);
																
									$this->db->select('coupon_id');
									$this->db->from("tbl_coupon");
									$this->db->order_by("coupon_id", "desc"); 
									$query		=	$this->db->get();
									$nCoupon	=	$query->row_array();
									$nRow		=	$nCoupon["coupon_id"]+1;
									
									$fill_zero	=	8-strlen($nRow);
									for($i=0;$i<$fill_zero;$i++)
									{
										$nRow	=	"0".$nRow;
									}
				
									$barcode	=	$nRow."00000000";
									
									$data = array(
		               					'barcode' => $barcode
		            				);
		
									$this->db->where('coupon_id', $nCoupon["coupon_id"]);
									$this->db->update('tbl_coupon', $data);
									
									echo 2;
						}else{
							echo 3;
						}
				}// end else $deal["deal_special"]="1"
		}else{	
			echo 1;
		}
	}
	public function logout()
	{
		$this->check_login();
		
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
			$this->session->unset_userdata('member_id');
			$this->session->unset_userdata('login_3');
			$this->xlog_member_login->save_log($this->member_id,2);
			echo '
			<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
			<html xmlns:fb="http://ogp.me/ns/fb#">
			<head>
				<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
				<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
				<meta http-equiv="Cache-control" content="no-cache">
			</head>
			<body>
				<script>window.location.href = "/member/logout_susses";</script>
			</body>
			</html>
			';
			//echo 1;
	}
	
	public function logout_susses()
	{
		$page_title = ":: ออกจากระบบ ::";
		$page_header = ":: ออกจากระบบ ::";
		
		$this->page_data["content"]		=	$this -> load -> view('member/member_logout.php','',true);
		$this -> page_data["page_title"] 		= $page_title;
		$this -> page_data["page_header"] = $page_header;
    	$this->render->fontend_page_render($this->page_data);
		
		header("refresh: 30; ../index.php");
	}
	
	public function load_top_menu()
	{
		$view_data["last_login"]	= $this->session->userdata('member_last_login');
		$this -> load -> view('member/member_top_menu.php',$view_data);
	}
	
	public function newpass()
	{
		$this->page_data["page_title"]	=	"ตั้งรหัสผ่านใหม่";
		$this->page_data["deal"]			=	array(	"deal_meta_keyword"=>"โรงแรมและที่พักหัวหิน,โรงแรมและที่พักกระบี่,โรงแรมและที่พักภูเก็ต",
																		"deal_meta_description"=>"รวมดีลโรงแรมและที่พักราคาถูกสุดในสามโลกลด50-90% โรงแรมและที่พักหัวหิน โรงแรมและที่พักกระบี่ โรงแรมและที่พักภูเก็ต โรงแรมและที่พักชลบุรี โรงแรมและที่พักกาญจนบุรี โรงแรมและที่พักประจวบคีรีขันธ์ โรงแรมและที่พักเชียงใหม่ โรงแรมและที่พักเชียงราย โรงแรมและที่พักเพชรบุรี โรงแรมและที่พักราชบุรี โรงแรมและที่พักจันทบุรี โรงแรมและที่พักตราด บุฟเฟ่ต์โรงแรม บุฟเฟ่ต์นานาชาติ บุฟเฟ่ต์ญี่ปุ่น");
		$this->page_data["content"]		=	$this -> load -> view('member/member_forget_changepass.php','', true);
		
    	$this->render->fontend_page_render($this->page_data);
	}
	

}
