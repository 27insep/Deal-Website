<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller {
	protected $layout = 'template/fontend_template.php';
	
	protected $stylesheets = array(

    	'slide/demo.css',
    	'slide/style.css',
    	'base.css',
    	'blitzer/jquery-ui.css',
    	'fancybox/jquery.fancybox.css?v=2.1.4',
    	'fancybox/helpers/jquery.fancybox-buttons.css?v=1.0.5',
    	'fancybox/helpers/jquery.fancybox-thumbs.css?v=1.0.7'
  	);
	
  	protected $javascripts = array(
  		'jquery.min.js',
  		'jquery.eislideshow.js',
  		'jquery.easing.1.3.js',
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
		$this->load->library('gen_captcha');
		$this->load->database();
		
		$this->load->model('category_main');
		$this->load->model('deal_main');
  	}
	public function aboutus()
	{
		$this->page_data["page_title"]	=	"เกี่ยวกับเรา";
		$this->page_data["deal"]			=	array(	"deal_meta_keyword"=>"โรงแรมและที่พักหัวหิน,โรงแรมและที่พักกระบี่,โรงแรมและที่พักภูเก็ต",
																		"deal_meta_description"=>"รวมดีลโรงแรมและที่พักราคาถูกสุดในสามโลกลด50-90% โรงแรมและที่พักหัวหิน โรงแรมและที่พักกระบี่ โรงแรมและที่พักภูเก็ต โรงแรมและที่พักชลบุรี โรงแรมและที่พักกาญจนบุรี โรงแรมและที่พักประจวบคีรีขันธ์ โรงแรมและที่พักเชียงใหม่ โรงแรมและที่พักเชียงราย โรงแรมและที่พักเพชรบุรี โรงแรมและที่พักราชบุรี โรงแรมและที่พักจันทบุรี โรงแรมและที่พักตราด บุฟเฟ่ต์โรงแรม บุฟเฟ่ต์นานาชาติ บุฟเฟ่ต์ญี่ปุ่น");
		$this->page_data["content"]		=	$this -> load -> view('about_us.php','', true);
		
    	$this->render->fontend_page_render($this->page_data);
	}
	
	public function logout()
	{
		$this->page_data["page_title"]	=	"The Best Deal One :: เกี่ยวกับเรา";
			
		$this->page_data["content"]		=	$this -> load -> view('member/member_logout.php','', true);
		
    	$this->render->fontend_page_render($this->page_data);
	}
	
	public function fb_test()
	{
		$this->page_data["page_title"]	=	"The Best Deal One :: test facebook";
			
		$this->page_data["content"]		=	$this -> load -> view('fb.php','', true);
		
    	$this->render->fontend_page_render($this->page_data);
	}
	public function condition()
	{
		$this->page_data["page_title"]	=	"เงื่อนไขและข้อตกลง";
		$this->page_data["deal"]				=	array(	"deal_meta_keyword"=>"โรงแรมและที่พักหัวหิน,โรงแรมและที่พักกระบี่,โรงแรมและที่พักภูเก็ต",
																			"deal_meta_description"=>" รวมดีลโรงแรมและที่พักราคาถูกสุดในสามโลกลด50-90% โรงแรมและที่พักหัวหิน โรงแรมและที่พักกระบี่ โรงแรมและที่พักภูเก็ต โรงแรมและที่พักชลบุรี โรงแรมและที่พักกาญจนบุรี โรงแรมและที่พักประจวบคีรีขันธ์ โรงแรมและที่พักเชียงใหม่ โรงแรมและที่พักเชียงราย โรงแรมและที่พักเพชรบุรี โรงแรมและที่พักราชบุรี โรงแรมและที่พักจันทบุรี โรงแรมและที่พักตราด บุฟเฟ่ต์โรงแรม บุฟเฟ่ต์นานาชาติ บุฟเฟ่ต์ญี่ปุ่น");
		
		$this->page_data["content"]		=	$this -> load -> view('condition.php','', true);
		
    	$this->render->fontend_page_render($this->page_data);
	}
	public function salecondition()
	{
		$this->page_data["page_title"]	=	"เงื่อนไขการขาย";
		$this->page_data["deal"]				=	array(	"deal_meta_keyword"=>"โรงแรมและที่พักหัวหิน,โรงแรมและที่พักกระบี่,โรงแรมและที่พักภูเก็ต",
																			"deal_meta_description"=>"รวมดีลโรงแรมและที่พักราคาถูกสุดในสามโลกลด50-90% โรงแรมและที่พักหัวหิน โรงแรมและที่พักกระบี่ โรงแรมและที่พักภูเก็ต โรงแรมและที่พักชลบุรี โรงแรมและที่พักกาญจนบุรี โรงแรมและที่พักประจวบคีรีขันธ์ โรงแรมและที่พักเชียงใหม่ โรงแรมและที่พักเชียงราย โรงแรมและที่พักเพชรบุรี โรงแรมและที่พักราชบุรี โรงแรมและที่พักจันทบุรี โรงแรมและที่พักตราด บุฟเฟ่ต์โรงแรม บุฟเฟ่ต์นานาชาติ บุฟเฟ่ต์ญี่ปุ่น");			
		$this->page_data["content"]		=	$this -> load -> view('salecondition.php','', true);
		
    	$this->render->fontend_page_render($this->page_data);	
	}
	public function policy()
	{
		$this->page_data["page_title"]	=	"นโยบายความเป็นส่วนตัว";
		$this->page_data["deal"]				=	array(	"deal_meta_keyword"=>"โรงแรมและที่พักหัวหิน,โรงแรมและที่พักกระบี่,โรงแรมและที่พักภูเก็ต",
																			"deal_meta_description"=>"รวมดีลโรงแรมและที่พักราคาถูกสุดในสามโลกลด50-90% โรงแรมและที่พักหัวหิน โรงแรมและที่พักกระบี่ โรงแรมและที่พักภูเก็ต โรงแรมและที่พักชลบุรี โรงแรมและที่พักกาญจนบุรี โรงแรมและที่พักประจวบคีรีขันธ์ โรงแรมและที่พักเชียงใหม่ โรงแรมและที่พักเชียงราย โรงแรมและที่พักเพชรบุรี โรงแรมและที่พักราชบุรี โรงแรมและที่พักจันทบุรี โรงแรมและที่พักตราด บุฟเฟ่ต์โรงแรม บุฟเฟ่ต์นานาชาติ บุฟเฟ่ต์ญี่ปุ่น");			
	
			
		$this->page_data["content"]		=	$this -> load -> view('policy.php','', true);
		
    	$this->render->fontend_page_render($this->page_data);	
	
	}
	public function iwantit_pop()
	{
		$this->page_data["page_title"]	=	"The Best Deal One ::  I Want It";
			
		$this -> load -> view('iwantit.php');
		
    	$this->render->fontend_page_render($this->page_data);	
	
	}
	public function register_pop()
	{
		$this->page_data["page_title"]	=	"The Best Deal One ::  Register";
			
		$this -> load -> view('register.php');
		
    	$this->render->fontend_page_render($this->page_data);	
	
	}
	public function howtopay()
	{
		$this->page_data["page_title"]	=	"วิธีการชำระเงิน";
		$this->page_data["deal"]			=	array(	"deal_meta_keyword"=>"โรงแรมและที่พักหัวหิน, โรงแรมและที่พักกระบี่, โรงแรมและที่พักภูเก็ต",
																		"deal_meta_description"=>"description: รวมดีลโรงแรมและที่พักราคาถูกสุดในสามโลกลด50-90% โรงแรมและที่พักหัวหิน โรงแรมและที่พักกระบี่ โรงแรมและที่พักภูเก็ต โรงแรมและที่พักชลบุรี โรงแรมและที่พักกาญจนบุรี โรงแรมและที่พักประจวบคีรีขันธ์ โรงแรมและที่พักเชียงใหม่ โรงแรมและที่พักเชียงราย โรงแรมและที่พักเพชรบุรี โรงแรมและที่พักราชบุรี โรงแรมและที่พักจันทบุรี โรงแรมและที่พักตราด บุฟเฟ่ต์โรงแรม บุฟเฟ่ต์นานาชาติ บุฟเฟ่ต์ญี่ปุ่น");
		$this->page_data["content"]		=	$this -> load -> view('howtopay.php','', true);
		
    	$this->render->fontend_page_render($this->page_data);	
	
	}
	public function howtobuy()
	{
		$this->page_data["page_title"]	=	"วิธีการสั่งซื้อ";
		$this->page_data["deal"]			=	array(	"deal_meta_keyword"=>"โรงแรมและที่พักหัวหิน, โรงแรมและที่พักกระบี่, โรงแรมและที่พักภูเก็ต",
																		"deal_meta_description"=>"description: รวมดีลโรงแรมและที่พักราคาถูกสุดในสามโลกลด50-90% โรงแรมและที่พักหัวหิน โรงแรมและที่พักกระบี่ โรงแรมและที่พักภูเก็ต โรงแรมและที่พักชลบุรี โรงแรมและที่พักกาญจนบุรี โรงแรมและที่พักประจวบคีรีขันธ์ โรงแรมและที่พักเชียงใหม่ โรงแรมและที่พักเชียงราย โรงแรมและที่พักเพชรบุรี โรงแรมและที่พักราชบุรี โรงแรมและที่พักจันทบุรี โรงแรมและที่พักตราด บุฟเฟ่ต์โรงแรม บุฟเฟ่ต์นานาชาติ บุฟเฟ่ต์ญี่ปุ่น");
		$this->page_data["content"]		=	$this -> load -> view('howtobuy.php','', true);
		
    	$this->render->fontend_page_render($this->page_data);	
	}
	public function contactus()
	{
		$cap = $this->gen_captcha->get_captcha(rand(11111,99999));
       	// store image html code in a variable
      	$view_data['capcha'] = $cap['image'];
              
        // store the captcha word in a session
       	$this->session->set_userdata('word', $cap['word']);
		
		$this->page_data["page_title"]	=	"ติดต่อเดอะเบสท์ดีล แผนที่เดอะเบสท์ดีลวัน";
		$this->page_data["deal"]			=	array(	"deal_meta_keyword"=>"โรงแรมและที่พักหัวหิน,โรงแรมและที่พักกระบี่,โรงแรมและที่พักภูเก็ต",
																		"deal_meta_description"=>"รวมดีลโรงแรมและที่พักราคาถูกสุดในสามโลกลด50-90% โรงแรมและที่พักหัวหิน โรงแรมและที่พักกระบี่ โรงแรมและที่พักภูเก็ต โรงแรมและที่พักชลบุรี โรงแรมและที่พักกาญจนบุรี โรงแรมและที่พักประจวบคีรีขันธ์ โรงแรมและที่พักเชียงใหม่ โรงแรมและที่พักเชียงราย โรงแรมและที่พักเพชรบุรี โรงแรมและที่พักราชบุรี โรงแรมและที่พักจันทบุรี โรงแรมและที่พักตราด บุฟเฟ่ต์โรงแรม บุฟเฟ่ต์นานาชาติ บุฟเฟ่ต์ญี่ปุ่น");					
		$this->page_data["content"]		=	$this -> load -> view('contact_us.php',$view_data, true);
		
    	$this->render->fontend_page_render($this->page_data);	
	}
	
	public function adsdeal()
	{
		 // load codeigniter captcha helper
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

		$this->page_data["page_title"]	=	"โฆษณา กับ เดอะ เบสท์ ดีล ฟรี";
		$this->page_data["deal"]			=	array(	"deal_meta_keyword"=>"โรงแรมและที่พักหัวหิน,โรงแรมและที่พักกระบี่,โรงแรมและที่พักภูเก็ต",
																		"deal_meta_description"=>"รวมดีลโรงแรมและที่พักราคาถูกสุดในสามโลกลด50-90% โรงแรมและที่พักหัวหิน โรงแรมและที่พักกระบี่ โรงแรมและที่พักภูเก็ต โรงแรมและที่พักชลบุรี โรงแรมและที่พักกาญจนบุรี โรงแรมและที่พักประจวบคีรีขันธ์ โรงแรมและที่พักเชียงใหม่ โรงแรมและที่พักเชียงราย โรงแรมและที่พักเพชรบุรี โรงแรมและที่พักราชบุรี โรงแรมและที่พักจันทบุรี โรงแรมและที่พักตราด บุฟเฟ่ต์โรงแรม บุฟเฟ่ต์นานาชาติ บุฟเฟ่ต์ญี่ปุ่น");					
		$this->page_data["content"]		=	$this -> load -> view('ads_deal.php',$view_data, true);
		
    	$this->render->fontend_page_render($this->page_data);	
	}
	/*
	public function test_page()
	{
		$this -> load -> view('mail/mail_news.php');
	}
	*/
	public function channel()
	{
		echo ' <script src="//connect.facebook.net/en_US/all.js"></script>';
	}
	
	public function contact_us()
	{
			$email =	$this->input->post('email');
			$contact_name =	$this->input->post('contact_name');
			$topic =	$this->input->post('topic');
			$detail =	$this->input->post('detail');
			$contact_name =	$this->input->post('contact_name');
			$tel =	$this->input->post('tel');
			$capcha =	$this->input->post('capcha');
			
			if($topic == "")
				echo "-  กรุณาระบุเรื่องค่ะ<br><br>";
			
			if($detail == "")
				echo "-  กรุณาระบุรายละเอียดค่ะ<br><br>";
			
			if($contact_name == "")
				echo "-  กรุณาระบุชื่อ - นามสกุลผู้ติดต่อค่ะ<br><br>";
			
			if(empty($email))
				echo "-  กรุณาระบุข้อมูลอีเมลค่ะ<br><br>";
			
			$regex = '/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/'; 
			if (!preg_match($regex, $email)) {
	     		echo "-  รูปแบบอีเมลไม่ถูกต้องค่ะ<br><br>";
			}	 
			
			if(empty($tel))
				echo "-  กรุณาระบุข้อมูลเบอร์โทรศัพท์ค่ะ<br><br>";
			
			if($tel < 10)
				echo "-  ข้อมูลเบอร์โทรศัพท์ไม่ถูกต้องค่ะ<br><br>";
			
			if(empty($capcha))
			{
				echo "-  กรุณาระบุรหัสความปลอดภัยค่ะ<br><br>";
				return 0;
			}else{
				if($capcha!=$this->session->userdata('word'))
				{
					echo "-  ขออภัย รหัสความปลอดภัยไม่ถูกต้องค่ะ<br>";
					return 0;
				}
			}
			
			$this->load->library('email');
			$this->load->library('convert_date');
			
			$subject = "ติดต่อสอบถาม – เรื่อง ".$topic;
			$d_now = date("Y-m-d H:i:s");
			
			$this->email->from($email);
			$this->email->to('support@thebestdeal1.com'); 
			//$this->email->to('katty__it2005@hotmail.com'); 
			$this->email->subject($subject);
			
			$msg		=	"<br/>".
							"<b>ติดต่อสอบถาม</b><br/><br/>".
							"<b>เรื่อง : </b>".$topic."<br/>".
							"<b>รายละเอียด : </b>".$detail." <br/><br/>".
							"<b>ชื่อ-นามสกุล : </b>".$contact_name." <br/>".
							"<b>อีเมล์ : </b>".$email." <br/>".
							"<b>โทรศัพท์ : </b>".$tel." <br/>".
							"ติดต่อเข้ามาในวันที่ ".$this->convert_date->show_thai_date($d_now)." เวลา ".date("H:i:s",strtotime($d_now))." น.<br/><br/>";
							
			$view_data["content"]	=	$msg;
			
			$body	=	$this -> load -> view('template/email_template.php',$view_data, true);					
			$this->email->message($body);	
	
			$this->email->send();
			echo 1;
	}
	public function save_free_ads()
	{
			$send_data 	=	$this->input->post();
			$error			=	"";
			
			if($send_data["vendor_name"] == "")
				$error	.=	 "-  ชื่อร้านค้า<br><br>";
			
			if($send_data["contact_name"] == "")
				$error	.=	 "- ชื่อผู้ติดต่อ<br><br>";
			
			if(empty($send_data["contact_email"]))
				$error	.=	 "-  อีเมลติดต่อ<br><br>";
			
			$regex = '/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/'; 
			if (!preg_match($regex, $send_data["contact_email"])) {
	     		$error	.=	 "-  รูปแบบอีเมลติดต่อไม่ถูกต้อง<br><br>";
			}	 
			
			if(empty($send_data["contact_phone"]))
				$error	.=	 "-  เบอร์โทรศัพท์<br><br>";
			
			if($send_data["contact_phone"] < 10)
				$error	.=	 "-  ข้อมูลเบอร์โทรศัพท์ไม่ถูกต้อง<br><br>";
			
			if(empty($send_data["capcha"]))
			{
				$error	.=	 "-  รหัสความปลอดภัย<br><br>";
			}else{
				if($send_data["capcha"]!=$this->session->userdata('word'))
				{
					$error	.=	 "-  รหัสความปลอดภัยไม่ถูกต้อง<br>";
				}
			}
			
			if(!empty($error))
			{
				echo "กรุณาตรวจสอบข้อมูลต่อไปนี้ค่ะ<br/>".$error;
				return 0;
				exit;
			}else{
				
				$this->load->model("free_ads");
				
				unset($send_data["capcha"]);
				//unset($send_data["capcha"]);
				$send_data["ip"]		=	$this->input->ip_address();
				
				$this->free_ads->add_free_ads($send_data);
				
				$this->load->library('email');
				$this->load->library('convert_date');
			
				$subject = "ติดต่อลงโฆษณาดีล – เรื่อง ".$send_data["vendor_name"];
				$d_now = date("Y-m-d H:i:s");
			
				$this->email->from($send_data["contact_email"]);
				$this->email->to('sale@thebestdeal1.com'); 
				//$this->email->to('light_lay@hotmail.com'); 
				$this->email->subject($subject);
			
				$msg		=	"<br/>".
								"<b>ติดต่อสอบถาม</b><br/><br/>".
								"<b>ชื่อธุรกิจ/ร้านค้า/บริษัท :</b>".$send_data["vendor_name"]."<br/>".
								"<b>ชื่อ-นามสกุล :</b>".$send_data["contact_name"]." <br/><br/>".
								"<b>อีเมล์ :</b>".$send_data["contact_email"]." <br/>".
								"<b>โทรศัพท์ :</b>".$send_data["contact_phone"]." <br/>".
								"<b>เว็บไซต์ :</b>".$send_data["website"]." <br/><br/>".
								"ติดต่อเข้ามาในวันที่ ".$this->convert_date->show_thai_date($d_now)." เวลา ".date("H:i:s",strtotime($d_now))." น.<br/><br/>";
				$view_data["content"]	=	$msg;
			
				$body	=	$this -> load -> view('template/email_template.php',$view_data, true);					
				$this->email->message($body);	
	
				$this->email->send();
				echo 1;
		}
	}
}


/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */