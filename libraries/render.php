<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Render {
    protected $layout;
	protected $stylesheets = array();
  	protected $javascripts = array();
  	
  	public function __construct($params)
   	{
      	// Your own constructor code
        $this->set_layout($params['layout']);
		$this->set_stylesheets($params['stylesheets']);
		$this->set_javascript($params['javascripts']);
  	}
	   
  	public function page_render($page_data=array()) 
  	{
  		$CI =& get_instance();
		
    	$view_data = array(
      	'page_data' => $page_data,
      	'stylesheets' => $this->get_stylesheets(),
      	'javascripts' => $this->get_javascripts()
	  	);
		
    	$CI->load->view($this->layout,$view_data);
  	}
	
	public function fontend_page_render($page_data=array())
	{
		$CI =& get_instance();
		$CI ->load->database();
		
		$CI->load->model('category_main');
		$CI->load->model('deal_main');
		$CI->load->model('xlog_member_login');
		
		$CI->load->library('session');
		
		$page_data["category_data"]		=	$CI->category_main->get_active_category();
		$page_data["best_sell_deal"]		=	$CI->deal_main->get_deal_best_sell();
		$page_data["new_deal"]			=	$CI->deal_main->get_deal_new();
		
		$show_login_form	=	true;
		
		$member_id	=	$CI->session->userdata('member_id');
		
		if(empty($member_id))
		{
			$member_id	=	$CI->input->cookie("auto_login_id");	
			if(!empty($member_id))
			{
				$CI->session->set_userdata('member_id',$member_id);
				$CI->xlog_member_login->save_log($member_id,1);
				$show_login_form	=	false;	
			}	
		}else{
			$show_login_form	=	false;	
		}
		
		if($show_login_form)
		{
			$CI->load->helper('captcha');

		   $vals = array(
		      		'word'	 => rand(11111,99999),
		           	'img_path' => $_SERVER["DOCUMENT_ROOT"].'/assets/images/captcha/',
		          	'img_url' => 'http://www.thebestdeal1.com/assets/images/captcha/',
		          	'font_path'	 => $_SERVER["DOCUMENT_ROOT"].'/fonts/SIXTY.TTF',
		          	'img_width' => '96',
		          	'img_height' => 20,
		          	'border' => 0, 
		        	'expiration' => 7200
		      	);
		    
		    // create captcha image
		    $cap = create_captcha($vals);
				
		     // store image html code in a variable
		     $content_data['capcha'] = $cap['image'];
				
		    // store the captcha word in a session
		    $CI->session->set_userdata('word_login', $cap['word']);
			
			$page_data["print_top_bar"]		= $CI->load->view('login_form',$content_data,true);
		}else{
			$view_data["last_login"]				= $CI->session->userdata('member_last_login');
			$page_data["print_top_bar"]		= $CI->load->view('member/member_top_menu',$view_data,true);
		}
		
		$this->page_render($page_data) ;
	}
	
	public function set_layout($layout)
	{
		$this->layout = $layout;
	}
	
	public function set_stylesheets($stylesheets)
	{
		$this->stylesheets = $stylesheets;
	}
	
	public function set_javascript($javascripts)
	{
		$this->javascripts = $javascripts;
	}
	
	protected function get_stylesheets() {
    	return $this->stylesheets;
  	}

  	protected function get_javascripts() {
    	return $this->javascripts;
  	}
  
}

/* End of file Someclass.php */