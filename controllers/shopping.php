<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Shopping extends CI_Controller {
	protected $layout = 'template/fontend_template.php';
	
	protected $stylesheets = array(
    	'slide/demo.css',
    	'slide/style.css',
    	'base.css',
    	'payment.css',
    	'blitzer/jquery-ui.css',
    	'fancybox/jquery.fancybox.css?v=2.1.4',
    	'fancybox/helpers/jquery.fancybox-buttons.css?v=1.0.5',
    	'fancybox/helpers/jquery.fancybox-thumbs.css?v=1.0.7'
  	);
	
  	protected $javascripts = array(
  		'jquery.js',
  		'jquery.form.js',
		'jquery-ui.min.js',
		'jquery.mousewheel-3.0.6.pack.js',
		'fancybox/jquery.fancybox.js?v=2.1.4',
		'fancybox/helpers/jquery.fancybox-buttons.js?v=1.0.5',
		'fancybox/helpers/jquery.fancybox-thumbs.js?v=1.0.7',
		'fancybox/helpers/jquery.fancybox-media.js?v=1.0.5'
  	);
	
	protected $page_data 	= 	array();
	
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
		$this->load->library('cart');
		
		$this->load->database();
		
		$this->load->model('member_profile');
		$this->load->model('member_order');
		$this->load->model('member_orderdetail');
		$this->load->model('deal_product');
		$this->load->model('deal_main');
		$this->load->model('deal_order');
		$this->load->model('coupon_main');
  	}
	function reload_cart()
	{
		$member_id =	$this->session->userdata('member_id');
		if(empty($member_id))
		{
			exit;
			return 0;
		}else{
			$data	=	$this->input->post();
			
			$cart_data				=	array();
			$shopping_cart_data	=	array();
			$shopping_cart_data	=	$this->cart->contents();
			
			ksort($shopping_cart_data);
			
			$i	=	0;
			foreach($shopping_cart_data as $item)
			{
				$cart_data[$i]	=	$item;
				$cart_data[$i]['product']	=	$this->deal_product->get_product_by_product_id($item['id']);
				$cart_data[$i]['deal']		=	$this->deal_main->get_deal_cart_by_id($cart_data[$i]['product']['deal_id']);

				//print_r($cart_data[$i]['product']);
				//echo "<br/>----------------------------------------<br/>";
				$i++;
			}
			
			$view_data["cart_data"]				=	$cart_data;
			$view_data["pre_order_id"]			=	$this->deal_order->get_pre_oreder_id($member_id);
			$view_data["test"]					=	$data["test"];
			
			$this -> load -> view('shopping/shopping_cart_detail.php',$view_data);
		}
	}
	public function index($test="")
	{
		$member_id =	$this->session->userdata('member_id');
		if(empty($member_id))
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
			
		if($this->member_profile->check_profile($member_id))
		{
			$this->page_data["page_title"]	=	"The Best Deal One :: ตระกล้าสินค้า";
		
			$cart_data	=	array();
			$i	=	0;
			foreach($this->cart->contents() as $item)
			{
				$cart_data[$i]	=	$item;
				$cart_data[$i]['product']	=	$this->deal_product->get_product_by_product_id($item['id']);
				$cart_data[$i]['deal']		=	$this->deal_main->get_deal_cart_by_id($cart_data[$i]['product']['deal_id']);
				$i++;
			}
			
			$view_data["cart_data"]				=	$cart_data;
			$view_data["pre_order_id"]			=	$this->deal_order->get_pre_oreder_id($member_id);
			$view_data["test"]					=	$test;
			
			$this->page_data["content"]		=	$this -> load -> view('shopping/shopping_cart.php',$view_data, true);
    		$this->render->fontend_page_render($this->page_data);
		}else{
			$this->load->model('coupon_main');
			$this->load->model('member_order');
			$this->load->model('province_data');
			
			$this->page_data["page_title"]	=	"The Best Deal One :: ตระกล้าสินค้า";
			$content_data["head_title"]			=	"กรุณาระบุโปรไฟล์ของท่าน ให้ครบก่อนเลือกเมนูตระกล้าสินค้า หรือทำการชำระเงินค่ะ";
			
			$content_data["member_main_menu"]		=	$this -> load -> view('member/member_main_menu.php','', true);
			$content_data["member_data"]				=	$this->member_profile->get_member_profile_by_id($member_id);
			
			$view_data["expile_soon"]			=	$this->coupon_main->get_coupon_expile_soon($member_id);
			$view_data["wait_payment"]		=	$this->member_order->get_waitting_payment($member_id);
			$content_data["right_sec"]			=	$this->load->view('member/member_right_sec.php',$view_data,true);
			$content_data["province_data"]	=	$this->province_data->get_all_province();
			
			$this->page_data["content"]					= $this->load->view('member/member_profile.php',$content_data,true);
    	
    		$this->render->fontend_page_render($this->page_data);
		}
	}
	public function add_to_cart()
	{
		$product_id		=	$this->input->post("product_id");
		$product_num	=	$this->input->post("product_qty");
		$product_price	=  $this->input->post("product_price");

		 $data = array(
               'id'      => $product_id,
               'qty'     => $product_num,
               'price'   => $product_price,
               'name'    => $product_id
            );

		$this->cart->insert($data);
		
		echo $this->cart->total_items();
	}
	public function remove_from_cart()
	{
			$product_id		=	$this->input->post("product_id");
			$cart_data	=	array();
			
			$remove_row	=	"";
			
			foreach($this->cart->contents() as $item)
			{
				if($item["id"]==$product_id)
				{
					$remove_row	=	$item["rowid"];
				}
			}
			if(!empty($remove_row))
			{
				$data = array(
               		'rowid' => $remove_row,
               		'qty'   => 0
            	);

				$this->cart->update($data);
				$nCart	=	$this->cart->total_items();
				if(!empty($nCart))
				{
					echo $nCart;
				}else{
					echo 0;
				}
			}
	}
	public function popup_order($deal_id,$deal_name)
	{
		$member_id =	$this->session->userdata('member_id');
		
		/*if(!empty($member_id))
		{*/
			$view_data["product_data"] 		=	$this->deal_product->get_product_by_deal_id($deal_id);
			$view_data["deal_name"] 			= base64_decode($deal_name);	
			$view_data["total_item"] 			=  $this->cart->total_items();
			$view_data["cart"]						= $this->cart->contents();
			$view_data["show_login_box"]	=	true;
			
			if(!empty($member_id))
			$view_data["show_login_box"]	=	false;
			$this -> load -> view('shopping/shopping_order.php',$view_data);
		/*}
		else{
			$view_data["deal_id"] 			= $deal_id;
			$view_data["deal_name"] 		= base64_decode($deal_name);	

			$this -> load -> view('member/member_popup_login.php',$view_data);
		}*/
	}

	public function popup_iwantit($deal_id,$deal_name)
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
		
		$view_data['deal_id'] = $deal_id;
		$this -> load -> view('iwantit.php',$view_data);
		unset($view_data);
	}
	
	public function add_iwantit()
	{
			$this->load->model('iwantit');
			$iwantit_email	=	$this->input->post("iwantit_email");
			$deal_id	=	$this->input->post("deal_id");
			$capcha	=	$this->input->post("capcha");

			if(empty($iwantit_email))
			{
				echo "กรุณาระบุข้อมูลอีเมลค่ะ";
			}else{
				$regex = '/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/'; 
				if (!preg_match($regex, $iwantit_email)) {
		     		echo "รูปแบบอีเมลไม่ถูกต้องค่ะ";
				}else{
					if(empty($capcha))
					{
						echo "กรุณาระบุรหัสความปลอดภัยค่ะ";
					}else{
						$this->iwantit->add_iwantit($iwantit_email,$deal_id);
						
						$this->load->library('email');
						
						$this->email->from($iwantit_email); 
						$this->email->to('order@thebestdeal1.com'); 
						$this->email->subject('ลูกค้าต้องการซื้อดีลนี้อีก');
						
					   $deal	=	$this->deal_main->get_deal_by_id($deal_id);	
								
						$d_now = date("Y-m-d H:i:s");
						
						$msg =	"<br/><br/>".
										"<b>ดีลที่ต้องการ : </b>".$deal["deal_name"]."<br/><br/>".
										"<b>อีเมล์ของผู้ที่ต้องการดีลนี้ : </b>".$iwantit_email."<br/><br/>".
										"<b>วันที่ : </b>".$d_now."<br/><br/>";
														
										$view_data["content"]	=	$msg;
										
										$body	=	$this -> load -> view('template/email_template.php',$view_data, true);					
										$this->email->message($body);	
								
										$this->email->send();				
						echo 1;
					}
				}
			}
	}
	
	public function checkout()
	{
		$get_data		=	$this->input->post();
		$member_id 	=	$this->session->userdata('member_id');
		
		$product_set	=	array();
		$deal_set		=	array();
		
		foreach($get_data["order"] as $product_id=>$order)
		{
			$product_set[$product_id]["qty"] 		=	$order["qty"];
			$product_set[$product_id]["deal_id"] 	=	$order["deal_id"];
			$deal_set[$order["deal_id"]] 				=	$order["deal_id"];
		}
		
		if($this->deal_product->check_store($product_set))
		{
			$price_summary	=	$this->deal_product->get_summary_price_by_product_set($product_set);
			
			$pay_type	=	0;
			
			
			switch($get_data["how2pay"])
			{
				case 1:
					if($get_data["select_bank"]==1)
					{
						$pay_type	=	1;
					}
					if($get_data["select_bank"]==2)
					{
						$pay_type	=	2;
					}
					if($get_data["select_bank"]==3)
					{
						$pay_type	=	3;
					}
					if($get_data["select_bank"]==4)
					{
						$pay_type	=	4;
					}
				break;
				case 2:
					$pay_type	=	5;
				break;
				case 3:
					$pay_type	=	6;
				break;
				case 4:
					$pay_type	=	7;
				break;
				case 5:
					$pay_type	=	7;
				break;
			}

			$pre_order_id	=	$this->deal_order->get_pre_oreder_id($member_id);
			
			$this->deal_order->add_order($member_id,$product_set,$price_summary,$pre_order_id,$pay_type);
			$order_id	=	$pre_order_id;
			$this->cart->destroy();
	
			foreach($deal_set as $deal)
			{
				$this->deal_main->update_buy_count($deal);
			}
			
			$this->load->library('email');
			
			$member_email 	=	$this->session->userdata('member_email');

			$this->email->from('support@thebestdeal1.com', 'TheBestDeal1');
			$this->email->to($member_email); 
			$this->email->subject('TheBestDeal1.com - คำสั่งซื้อหมายเลข '.$order_id);
		
			//$order_id		=	$order_id;
		
			$view_data["recomment_deal"]	=	$this->deal_main->get_recomment_deal(3);
			$view_data["order"]					=	$this->member_orderdetail->ShowOrderDetail($order_id,$member_id);
			$view_data["order_date"]			=	$this->convert_date->show_thai_date($view_data["order"]["order"]["order_date"])." เวลา ".date("H:i:s",strtotime($view_data["order"]["order"]["order_date"]))." น.";
	
			$this->load->model('member_orderDetail');
			$content_data							=	array();
			$content_data["order_data"]		=	$this->member_orderDetail->ShowOrderDetail($order_id,$member_id);
		
			switch($pay_type)
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
				/*
				case 7:
					$view_data["payment"] = $this -> load -> view('how2pay/online.php',$content_data,true);
				break;
				*/
				case 7:
					$view_data["payment"] = $this -> load -> view('how2pay/credit.php',$content_data,true);
				break;
			}
		
			$body		=	$this -> load -> view('mail/mail_payment.php',$view_data,true);
	
			$this->email->message($body);	

			$this->email->send();
			
			//send email 2 backoffice
			$this->email->from('support@thebestdeal1.com', 'TheBestDeal1');
			$this->email->to('order@thebestdeal1.com'); 
			$this->email->subject('TheBestDeal1.com - คำสั่งซื้อหมายเลข '.$order_id);
			$this->email->message($body);	
			$this->email->send();
			 
			if($pay_type==6)
			{
				$this->email->subject('TheBestDeal1.com - แบบฟอร์มการชำระเงินสำหรับคำสั่งซื้อเลขที่ '.$order_id);
				
				$data									=	$this->member_orderdetail->ShowOrderDetail($order_id,$member_id);

				$lotus_data["order"]				=	$data['order']	;
				$lotus_data["order_detail"]		=	$data['order_detail'];
				$lotus_data["close_type"]		=	1;
				$lotus_data["member_id"]		=	$member_id;
		
				$body		=	$this -> load -> view('shopping/shopping_payment_lotus_table.php',$lotus_data,true);
	
				$this->email->message($body);	

				$this->email->send();
			 				
			}
			echo $order_id;
		}else{
			echo 0;
		}
	}
	public function payment_form($payment_type,$order_id,$auto_print="")
	{
		$member_id =	$this->session->userdata('member_id');
		//echo $member_id."-------------";
		$view_data	=	array();
		$view_data["stylesheets"]		=	array('base.css','payment.css');
		$data									=	$this->member_orderdetail->ShowOrderDetail($order_id,$member_id);

		$view_data["order"]				=	$data['order']	;
		$view_data["order_detail"]		=	$data['order_detail'];
		$view_data["close_type"]		=	1;
		$view_data["member_id"]		=	$member_id;
		
		if(!empty($auto_print))
		{
			$view_data["auto_print"]		=	1;	
		}
		
		switch($payment_type)
		{
			case 1 :
				$this -> load -> view('shopping/shopping_payment_bank_form.php',$view_data);
			case 2 :
			break;
			case 3 :
				$this -> load -> view('shopping/shopping_payment_lotus_form.php',$view_data);
			break;
		}
	}
	/*
	public function payment_form_test_2($payment_type,$order_id)
	{
		$member_id =	$this->session->userdata('member_id');
		//echo $member_id."-------------";
		$view_data	=	array();
		//$view_data["stylesheets"]		=	array('base.css','payment.css');
		$data									=	$this->member_orderdetail->ShowOrderDetail($order_id,$member_id);

		$view_data["order"]				=	$data['order']	;
		$view_data["order_detail"]		=	$data['order_detail'];
		$view_data["close_type"]		=	1;
		$view_data["member_id"]		=	$member_id;
		
		switch($payment_type)
		{
			case 1 :
				$this -> load -> view('shopping/shopping_payment_bank_table.php',$view_data);
			case 2 :
			break;
			case 3 :
				$this -> load -> view('shopping/shopping_payment_lotus_table.php',$view_data);
			break;
		}
	}
	*/
	public function show_payin()
	{
		$view_data	=	array();
		$view_data["stylesheets"]		=	array('base.css','payment.css');
		$this -> load -> view('shopping/shopping_payment_bank_form.php',$view_data);
	}
	public function how2pay()
	{
		$pay_type		=	$this->input->post("pay_type");
		
		switch($pay_type)
		{
			case 1:
				$this -> load -> view('how2pay/kbank.php');
			break;
			case 2:
				$this -> load -> view('how2pay/scbbank.php');
			break;
			case 3:
				$this -> load -> view('how2pay/bblbank.php');
			break;
			case 4:
				$this -> load -> view('how2pay/ksbank.php');
			break;
			case 5:
				$this -> load -> view('how2pay/counter_service.php');
			break;
			case 6:
				$this -> load -> view('how2pay/tesco_lotus.php');
			break;
			case 7:
				$this -> load -> view('how2pay/online.php');
			break;
			case 8:
				$this->load->library('session');
				$session_id = $this->session->userdata('session_id');
				
				$view_data	=	array();
				
				$view_data["org_id"]							=	"1snn5n9w";
				$view_data["session_id"]					=	$session_id;
				$view_data["merchant_id"]					=	"kr950210724";
				
				$this -> load -> view('how2pay/credit.php',$view_data);
			break;
		}
	}
	public function shopping_thankyou($order_id)
	{
			$member_id =	$this->session->userdata('member_id');
			
			$order_data	=	$this->deal_order->get_order_by_id($order_id);
			
			if((sizeof($order_data)>0)&&($order_data["mem_id"]==$member_id))
			{
				$this->page_data["page_title"]	=	"The Best Deal One :: เราได้รับคำสั่งซื้อของคุณแล้ว";
				$content_data["head_title"]			=	"เราได้รับคำสั่งซื้อของคุณแล้ว";
				
				$view_data["recomment_deal"]	=	$this->deal_main->get_recomment_deal(3);
				
				$view_data["member_id"]			=	$order_data["mem_id"];
				$view_data["order_id"]				=	$order_data["order_id"];
				$view_data["payment_type"]		=	$order_data["payment_type"];
				$this->page_data["content"]		=	$this -> load -> view('shopping/shopping_thank.php',$view_data, true);
			
    			$this->render->fontend_page_render($this->page_data);
			}else{
				$this->page_data["page_title"]	=	"The Best Deal One :: พบข้อผิดพลาด";
				$content_data["head_title"]			=	"พบข้อผิดพลาด";
				
				$view_data["msg"]						=	"ไม่พบข้อมูลที่ต้องการค่ะ !";
				$this->page_data["content"]		=	$this -> load -> view('error.php',$view_data, true);
				$this->render->fontend_page_render($this->page_data);
			}
	}	
	public function login_for_specail_deal($deal_id)
	{
		$view_data["show_login_box"]	=	true;
		$view_data["deal_id"] = $deal_id;
		$this -> load -> view('shopping/shopping_special.php',$view_data);
	}
	public function generate_coupon($deal_id="")
	{
			$member_id 	=	$this->session->userdata('member_id');
			
			if($deal_id != "")
			{
			$deal 			= $this->deal_main->get_deal_by_id($deal_id);
			
			if($deal["deal_special"]!="1")
			{
				echo "ขออภัยดีลตังกล่าวไม่ได้ร่วมรายการค่ะ";
				
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
				return 0;
			}elseif($deal["deal_buy_time_end"] < date('Y-m-d H:s:i',time())){
				echo "ไม่สามารถทำการสั่งซื้อได้ <br><br> เนื่องจากดีลนี้หมดอายุแล้วค่ะ";
			}else{
					if(!empty($member_id))
					{
						 $mem_profile = $this->member_profile->get_member_profile_by_id($member_id);
						   
						   if(!empty($mem_profile["member_name"]) && !empty($mem_profile["member_sname"]))
						   {
									$pre_order_id	=	$this->deal_order->get_pre_oreder_id($member_id);
									$product = $this->deal_main->get_product_special($deal_id,$member_id);
									
									if($product != ""){
											$product_set	=	array();
											$product_set[$product]["qty"] =	1;
											$product_set[$product]["deal_id"] =	$deal_id;
											
											
										 	$this->deal_order->add_order($member_id, $product_set ,0, $pre_order_id, 8,1);
										 	
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
											
											
											$data = array('mem_id' => $member_id, 'order_id' => $pre_order_id, 'deal_id' => $deal_id,
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
				
											echo "ระบบทำการสั่งซื้อสินค้าเรียบร้อยแล้วค่ะ <br> เลขที่ใบสั่งซื้อ ".$pre_order_id;
								}else{
									echo "การสั่งซื้อดีลนี้สามารถซื้อได้ 1 สิทธิ์ต่อคนเท่านั้นค่ะ";
								} // end if($product != "")
						}else{
							echo "กรุณาระบุข้อมูลของท่านให้ครบถ้วน <br><br> ก่อนทำการสั่งซื้อค่ะ";
						} // end  if(!empty($mem_profile["member_name"]) && !empty($mem_profile["member_sname"]))
				}else{
					echo "กรุณาเข้าสู่ระบบ <br><br> ก่อนทำการสั่งซื้อค่ะ";
				} // end if(!empty($member_id)) 
		}
		}else{
				echo "กรุณาเข้าสู่ระบบ <br><br> ก่อนทำการสั่งซื้อค่ะ";
			}
	}
	public function paysabuy($order_id)
	{
		$view_data["order_id"]	=	$order_id;
		
		$this->db->select('order_id,order_summary');
		$this->db->from("tbl_deal_order");
		$this->db->where_in('order_id',$order_id);
		$query		=	$this->db->get();
		$order		=	$query->row_array();
		
		$sql		=	"	SELECT p.product_name 
							FROM tbl_deal_product p,tbl_deal_order_detail od
							WHERE od.product_id = p.product_id 
							AND od.order_id =	'".$order_id."'";
		$query = $this->db->query($sql);
		$set_product		=	$query->result_array();
		
		$product	=	"";
		foreach($set_product as $item)
		{
			$product	=	$item["product_name"].",";
		}
		
		$view_data["amount"]	=	$order["order_summary"];
		$view_data["product"]	=	$product;
		
		$this -> load -> view('shopping/paysabuy.php',$view_data);
	}
	public function paysabuy_callback($order_id)
	{
		//echo $order_id;
		$this -> load -> view('shopping/paysabuy.php');
	}
	public function krungsri_form()
	{
		$this -> load -> view('krungsri_creditcard/payment_form.php');
	}
	private function sign ($params) {
		$secretKey	=	"0083165bf32449a4a5cbb1ba16a0914bbf8362c0fa3649ea94da3eb006d734eec1ed58cb139b4def83a3c40b3de96e792207f439e7894da6b651f15592c8d44971716cf2676340afbc4e4e18cbe9d9fd7efa905a032a4a96af562fd6bb78ca2e7d40b636309d4922bc7ebe3ea47cec138ceb42c7f16c4f8dbd202aa55ed282a7";
  		return $this->signData($this->buildDataToSign($params), $secretKey);
	}

	private function signData($data, $secretKey) {
    	return base64_encode(hash_hmac('sha256', $data, $secretKey, true));
	}

	private function buildDataToSign($params) {
        $signedFieldNames = explode(",",$params["signed_field_names"]);
        foreach ($signedFieldNames as &$field) {
           $dataToSign[] = $field . "=" . $params[$field];
        }
        return $this->commaSeparate($dataToSign);
	}

	private function commaSeparate ($dataToSign) {
    	return implode(",",$dataToSign);
	}
	public function krungsri_credit($order_id)
	{
		$this->load->library('session');
		
		$this->db->select('order_id,mem_id,order_summary');
		$this->db->from("tbl_deal_order");
		$this->db->where_in('order_id',$order_id);
		$query		=	$this->db->get();
		$order		=	$query->row_array();
		
		$this->db->select('member_id,member_pwd,member_name,member_sname,member_email,member_mobile,member_regis_time');
		$this->db->from("tbl_member_profile");
		$this->db->where_in('member_id',$order["mem_id"]);
		$query					=	$this->db->get();
		$member_data		=	$query->row_array();
		
		$this->db->select('order_id,mem_id,order_summary');
		$this->db->from("tbl_deal_order");
		$this->db->where_in('mem_id',$order["mem_id"]);
		$query		=	$this->db->get();
		
		$list_order	=	$query->result_array();
		
		$new_purchase	=	"NO";
		if(sizeof($list_order)==1)
		{
			$new_purchase	=	"YES";	
		}
		 
		$regis_time	=	strtotime($member_data["member_regis_time"]);
		$profile_age	=	(time()-$regis_time)/60/60/24;
		
		$session_id 	= $this->session->userdata('session_id');
		
		$params											=	array();
		$params["access_key"]						=	"ee6133240ffb364e8b7670f64a1f353a";
		$params["profile_id"]							=	"0724T01";
		$params["transaction_uuid"]				=	uniqid();
		$params["signed_field_names"]			=	"access_key,profile_id,transaction_uuid,signed_field_names,unsigned_field_names,signed_date_time,locale,transaction_type,reference_number,amount,currency,device_fingerprint_id,consumer_id,bill_to_company_name,customer_ip_address";			
		
		$params["unsigned_field_names"]		=	"merchant_defined_data1,merchant_defined_data2,merchant_defined_data3,merchant_defined_data4,merchant_defined_data5,merchant_defined_data6,merchant_defined_data7,merchant_defined_data8,merchant_defined_data9,merchant_defined_data10";
		$params["signed_date_time"]				=	gmdate("Y-m-d\TH:i:s\Z");
		$params["locale"]								=	"en";
		$params["transaction_type"]				=	"sale";
		$params["reference_number"]			=	$order_id;
		$params["amount"]							=	$order["order_summary"];
		$params["currency"]							=	"THB";
		$params["device_fingerprint_id"]			=	$session_id;
		
		$params["consumer_id"]					=	$member_data["member_id"];
		$params["bill_to_company_name"]		=	"thebestdeal1";
		$params["customer_ip_address"]			=	$_SERVER["REMOTE_ADDR"];
		
		$params["merchant_defined_data1"]	=	$member_data["member_mobile"];
		$params["merchant_defined_data2"]	=	(int)$profile_age;
		$params["merchant_defined_data3"]	=	$new_purchase;
		$params["merchant_defined_data4"]	=	"Web";
		
		$params["merchant_defined_data5"]	=	"first name";
		$params["merchant_defined_data6"]	=	"last name";
		
		$params["merchant_defined_data7"]	=	sizeof($list_order)-1;
		$params["merchant_defined_data8"]	=	$member_data["member_email"];
		$params["merchant_defined_data9"]	=	md5(base64_decode($member_data["member_pwd"]));
		$params["merchant_defined_data10"]	=	"th";
		
		$view_data["sign"]		=	$this->sign($params);
		$view_data["params"]	=	$params;
		
		$view_data["device_fingerprint_id"]		=	$session_id;

		$view_data["org_id"]							=	"1snn5n9w";
		$view_data["session_id"]					=	$session_id;
		$view_data["merchant_id"]					=	"kr950210724";
		
		$this -> load -> view('shopping/krungsri_credit.php',$view_data);	
	}
}
/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */