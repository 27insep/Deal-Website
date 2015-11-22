<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Customer extends CI_Controller {
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
		$this->load->database();
		
		$this->load->model('member_profile');
  	}
	public function index()
	{
		
	}
	
	public function signup($ref_id="")
	{
		$this->page_data["page_title"]	=	"สมัครสมาชิกซื้อโรงแรมและที่พัก หัวหิน กระบี่ ภูเก็ต ทุกดีลราคาถูกสุดในสามโลก";
		$this->page_data["deal"]			=	array(	"deal_meta_keyword"=>"โรงแรมและที่พักหัวหิน,โรงแรมและที่พักกระบี่,โรงแรมและที่พักภูเก็ต",
																		"deal_meta_description"=>"รวมดีลโรงแรมและที่พักราคาถูกสุดในสามโลกลด50-90% โรงแรมและที่พักหัวหิน โรงแรมและที่พักกระบี่ โรงแรมและที่พักภูเก็ต โรงแรมและที่พักชลบุรี โรงแรมและที่พักกาญจนบุรี โรงแรมและที่พักประจวบคีรีขันธ์ โรงแรมและที่พักเชียงใหม่ โรงแรมและที่พักเชียงราย โรงแรมและที่พักเพชรบุรี โรงแรมและที่พักราชบุรี โรงแรมและที่พักจันทบุรี โรงแรมและที่พักตราด บุฟเฟ่ต์โรงแรม บุฟเฟ่ต์นานาชาติ บุฟเฟ่ต์ญี่ปุ่น");              
      	// load codeigniter captcha helper
      	$this->load->helper('captcha');

      	$vals = array(
      		'word'	 => rand(11111,99999),
           	'img_path' => $_SERVER["DOCUMENT_ROOT"].'/assets/images/captcha/',
          	'img_url' => 'http://www.thebestdeal1.com/assets/images/captcha/',
          	'font_path'	 => $_SERVER["DOCUMENT_ROOT"].'/fonts/SIXTY.TTF',
          	'img_width' => '250',
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

		$view_data["ref_id"]					=	$ref_id;
		
		$this->page_data["content"]		=	$this -> load -> view('signup/signup_form.php',$view_data, true);
    	$this->render->fontend_page_render($this->page_data);
	}
	public function signup_thankyou($value='')
	{
		$this->page_data["page_title"]	=	"The Best Deal One :: สร้างบัชญีผู้ใช้ใหม่";
		$this->page_data["content"]		=	$this -> load -> view('signup/signup_complete.php', '', true);
    	$this->render->fontend_page_render($this->page_data);
	}
	public function create_user()
	{
		$email						=	$this->input->post('email');
		$password					=	$this->input->post('password');
		$subscript					=	$this->input->post('subscript');
		$confirm_password		=	$this->input->post('confirm_password');
		$ref_id						=  $this->input->post('ref_id');
		$acept_condition			=	$this->input->post('acept_condition');
		$know_from				=	$this->input->post('know_from');
		$capcha						=	$this->input->post('capcha');
		$member_name			=	$this->input->post('member_name');
		$member_sname			=	$this->input->post('member_sname');
		$member_mobile			=	$this->input->post('member_mobile');	
		
		if($acept_condition!=1)
		{
			echo "กรุณายอมรับเงื่อนไขการใช้งานก่อนทำการสมัครค่ะ";
			return 0;
		}
		
		if(empty($email))
		{
			echo "กรุณาระบุข้อมูลอีเมลค่ะ";
			return 0;
		}else{
			if($this->member_profile->has_email($email))
			{
				echo "อีเมลนี้ ได้ทำการสมัครสมาชิกแล้วค่ะ";
				return 0;
			}
		}
		
		$regex = '/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/'; 
		if (!preg_match($regex, $email)) {
     		echo "รูปแบบอีเมลไม่ถูกต้องค่ะ";
			return 0;
		}	 
		
		if(empty($member_name))
		{
			echo "กรุณาระบุชื่อของท่านค่ะ";
			return 0;
		}
		
		if(empty($member_sname))
		{
			echo "กรุณาระบุข้อมูลนามสกุลของท่านค่ะ";
			return 0;
		}
		
		if(empty($member_mobile))
		{
			echo "กรุณาระบุข้อมูลเบอร์ติดต่อของท่านค่ะ";
			return 0;
		}
		
		if(empty($password))
		{
			echo "กรุณาระบุข้อมูลรหัสผ่านค่ะ";
			return 0;
		}
		
		if(strlen($password)<6||strlen($password)>15)
		{
			echo "รหัสผ่านต้องมีความยาว 6-15 ตัวอักษรค่ะ";
			return 0;
		}
		
		if(empty($confirm_password))
		{
			echo "กรุณายืนยันรหัสผ่านค่ะ";
			return 0;
		}else{
			if($password!=$confirm_password)
			{
				echo "การยืนยันรหัสผ่านไม่ถูกต้องค่ะ";
				return 0;	
			}
		}
		
		if(empty($know_from))
		{
			echo "กรุณาระบุว่าท่านทราบเว็บไซต์เราจากไหน ค่ะ";
			return 0;
		}
		
		if(empty($capcha))
		{
			echo "กรุณาระบุรหัสความปลอดภัยค่ะ";
			return 0;
		}else{
			if($capcha!=$this->session->userdata('word'))
			{
				echo "ขออภัย รหัสความปลอดภัยไม่ถูกต้องค่ะ";
				return 0;
			}
		}

		$this->member_profile->add_user($email,$password,$subscript,$ref_id,$know_from,$member_name,$member_sname,$member_mobile);
		
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
		
		//send mail to back office
		$this->email->from('support@thebestdeal1.com', 'TheBestDeal1');
		$this->email->to('member@thebestdeal1.com'); 
		$this->email->subject('"welcome to thebestdeal1"');
		$this->email->message($body);	
		$this->email->send();
	
		//echo $this->email->print_debugger();
		echo 1;
	}	
	
	public function forget_password_email()
	{
		$email						=	$this->input->post('member_email');
		$capcha						=	$this->input->post('capcha');
		
		if(empty($email))
		{
			echo "กรุณาระบุข้อมูลอีเมลค่ะ";
			return 0;
		}else{
				$regex = '/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/'; 
				if (!preg_match($regex, $email)) {
		     		echo "รูปแบบอีเมลไม่ถูกต้องค่ะ";
					return 0;
				}else{
					if(empty($capcha))
					{
						echo "กรุณาระบุรหัสความปลอดภัยค่ะ";
						return 0;
					}else{
						if($capcha!=$this->session->userdata('word'))
						{
							echo "ขออภัย รหัสความปลอดภัยไม่ถูกต้องค่ะ";
							return 0;
						}else{
							
								$this->load->model('member_profile');
								$member_data	=	$this->member_profile->get_member_profile_by_email($email);	
								
								if(sizeof($member_data) > 0)
								{
										$this->load->library('email');
						
										$this->email->from('support@thebestdeal1.com', 'TheBestDeal1');
										$this->email->to($email); 
										//$this->email->to('katty__it2005@hotmail.com'); 
										$this->email->subject('The Best Deal 1 : แจ้งข้อมูลรหัสผ่านของท่าน');
										
										/*$msg		=	"<br/><br/>".
														"ข้อมูลการเข้าใช้งานระบบของท่านคือ<br/><br/>".
														"อีเมลของท่านคือ ".$email." <br/>".
														"รหัสผ่านของท่านคือ ".base64_decode($member_data["member_pwd"])."<br/><br/>";*/
										$msg =	"<br/><br/>".
														"<font color='#FF9900' size='4'>Hi &nbsp; ".$member_data["member_name"]." &nbsp; ".$member_data["member_sname"]."</font><br/><br/>".
														"You can change your password within 24 hours using this link:<br/>".
														"<a href='http://www.thebestdeal1.com/customer/forget_password_changepass/".base64_encode($member_data["member_id"])."'".
														"<font color='#0099FF'>http://www.thebestdeal1.com/customer/forget_password_changepass/".base64_encode($member_data["member_id"])."</font></a><br/><br/>".
														"If you have any question feel free to contact us at <font color='#0099FF'> support@thebestdeal1.com </font>or by phone at  02-938-4399<br/><br/>".
														"Thank You.<br/>".
														"<div style='color:red; font-weight: bold;'>Thebestdeal1 team</div><br/><br/>";
														
										$view_data["content"]	=	$msg;
										
										$body	=	$this -> load -> view('template/email_template.php',$view_data, true);					
										$this->email->message($body);	
								
										$this->email->send();
										echo 1;
								}else{
									echo "ไม่พบอีเมล์นี้ในระบบ กรุณาตรวจสอบค่ะ";
								}	
						}
					}
				}	 
		}
	}

	public function forget_password_changepass($member="")
	{
		$page_title = ":: เปลี่ยนรหัสผ่าน ::";
		$page_header = ":: เปลี่ยนรหัสผ่าน ::";
		
		if($member != "")
			$view_data["member_id"] = base64_decode($member);
		
		$this->page_data["content"]		=	$this -> load -> view('member/member_forget_changepass.php',$view_data,true);
		$this -> page_data["page_title"] 		= $page_title;
		$this -> page_data["page_header"] = $page_header;
    	$this->render->fontend_page_render($this->page_data);
	}
	
	public function change_pass()
	{
		 $pwd = $this -> input -> post('pwd');
		 $member_id = $this -> input -> post('member_id');
		 
		 $member_pwd =  base64_encode($pwd);
		 
		 $this->member_profile->update_changepwd($member_id,$member_pwd);
		 
		 $member_data	=	$this->member_profile->get_member_profile_by_id($member_id);	
								
		if(sizeof($member_data) > 0)
		{
			$this->load->library('email');
						
			$this->email->from('support@thebestdeal1.com', 'TheBestDeal1');
			$this->email->to($member_data["member_email"]); 
			$this->email->subject('The Best Deal 1 : แจ้งข้อมูลรหัสผ่านของท่าน');
										
			$msg =	"<br/><br/>".
			"<font color='#FF9900' size='4'>สวัสดีค่ะคุณ &nbsp; ".$member_data["member_name"]." &nbsp; ".$member_data["member_sname"]."</font><br/><br/>".
			"ขอต้อนรับสู่  Thebestdeal1.com<br/><br/>".
			"คลิกที่นี่เพื่อ <a href='www.thebestdeal1.com' target='_blank'><font color='#0099FF'>เข้าสู่ระบบ</font></a> ด้วยข้อมูลข้างล่าง : <br/>".
			"อีเมล์ : ".$member_data["member_email"]."<br/><br/>".
			"หากคุณมีคำถามหรือข้อสงสัยใดๆ สามารถติดต่อเราได้ที่ <font color='#0099FF'> support@thebestdeal1.com </font> หรือที่หมายเลขโทรศัพท์  02-938-4399<br/><br/>".
			"ขอบพระคุณค่ะ.<br/>".
			"<div style='color:red; font-weight: bold;'>ทีมงานเดอะเบสดีลวัน</div><br/><br/>";
														
			$view_data["content"]	=	$msg;
										
			$body	=	$this -> load -> view('template/email_template.php',$view_data, true);					
			$this->email->message($body);	
								
			$this->email->send();
			echo 1;
		}
	}
	public function unsubscript($email_code)
	{
		$email	=	base64_decode($email_code);
		$this->member_profile->unsubscript($email);
		
		$this->page_data["page_title"]	=	"The Best Deal One :: ยกเลิกการรับข่าวสาร";
		$this->page_data["content"]		=	$this -> load -> view('mail/unsubscript.php', '', true);
    	$this->render->fontend_page_render($this->page_data);
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */