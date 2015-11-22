<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class gen_captcha {
  	public function __construct()
   	{
      	// Your own constructor code
    }
	public function get_captcha($word)
	{
		$CI =& get_instance();
		
		$CI->load->helper('captcha');
			
			$vals = array(
      		'word'	 => $word,
           	'img_path' => $_SERVER["DOCUMENT_ROOT"].'/assets/images/captcha/',
          	'img_url' => 'http://www.thebestdealone.local/assets/images/captcha/',
          	'font_path'	 => $_SERVER["DOCUMENT_ROOT"].'/fonts/SIXTY.TTF',
          	'img_width' => '120',
          	'img_height' => 30,
          	'border' => 0, 
        	'expiration' => 7200
      	);
		
		// create captcha image
      	$cap = create_captcha($vals);
		
		return $cap;
	}
}
?>