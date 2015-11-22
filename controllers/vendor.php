<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Vendor extends CI_Controller {
	protected $layout = 'template/vendor_template.php';
	
	protected $stylesheets = array(
		'vendor.css',
		'jquery.dataTables.css',
		'TableTools.css',
		'TableTools_JUI.css',
    	'blitzer/jquery-ui.css',
    	'fancybox/jquery.fancybox.css?v=2.1.4',
    	'fancybox/helpers/jquery.fancybox-buttons.css?v=1.0.5',
    	'fancybox/helpers/jquery.fancybox-thumbs.css?v=1.0.7'
  	);
	
  	protected $javascripts = array(
  		'jquery.min.js',
  		'jquery.form.js',
		'jquery-ui.min.js',
		'jquery.dataTables.min.js',
		'ZeroClipboard.js',
		'TableTools.min.js',
		'jquery.mousewheel-3.0.6.pack.js',
		'tiny_mce/tiny_mce.js',
		'fancybox/jquery.fancybox.js?v=2.1.4',
		'fancybox/helpers/jquery.fancybox-buttons.js?v=1.0.5',
		'fancybox/helpers/jquery.fancybox-thumbs.js?v=1.0.7',
		'fancybox/helpers/jquery.fancybox-media.js?v=1.0.5'
  	);
	
	protected $page_data 	= 	array();
	protected $vendor_id;
	
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
		$this->load->model('vendor_profile');
		$this->load->model('deal_main');
		$this->load->model('deal_product');
		$this->load->model('deal_order');
		$this->load->model('xlog_vendor_login');
		$this->load->model('member_coupon');
		$this->load->model('province_data');
		
		$this->vendor_id =	$this->session->userdata('vendor_id');
  	}
	private function check_vendor_login()
	{
		if(empty($this->vendor_id))
		{
			echo "<script>window.location.href = '/vendor';</script>";
		}
	}
	public function index()
	{
		$this -> page_data["content"]	=	$this -> load -> view('vendor/vendor_login.php','',true);
		$this -> render -> page_render($this -> page_data);
	}
	public function vendor_profile()
	{
		$this->check_vendor_login();
		
		$vendor_data		=  $this->vendor_profile->get_vendor_profile_by_id($this->vendor_id);
		$vendor_data["province_data"]	=	$this->province_data->get_all_province();
		
		$this -> page_data["content"]	=	$this -> load -> view('vendor/vendor_profile.php',$vendor_data,true);
		$this -> render -> page_render($this -> page_data);	
	}
	public function vendor_account()
	{
		$this->check_vendor_login();
		
		$vendor_data		=  $this->vendor_profile->get_vendor_profile_by_id($this->vendor_id);

		$this -> page_data["content"]	=	$this -> load -> view('vendor/vendor_account.php',$vendor_data,true);
		$this -> render -> page_render($this -> page_data);	
	}
	
	public function vendor_change_pass($link="")
	{
		$vendor_data["link"] = $link;
		$this -> page_data["content"]	=	$this -> load -> view('vendor/vendor_change_pass.php',$vendor_data,true);
		$this -> render -> page_render($this -> page_data);	
	}
	
	public function vendor_reset_password()
	{
		 $new_password			=	$this->input->post("vendor_new_password");
		$vendor_confirm_password		=	$this->input->post("vendor_confirm_password");
		 $link			=	$this->input->post("vendor_id");
		
		if(strlen($new_password) > 5){
				if($new_password == $vendor_confirm_password){
						$vendor_data["vendor_id"]		=	base64_decode($link);
						$vendor_data["vendor_pwd"]	=	base64_encode($new_password);
						$this->vendor_profile->update_verndor_profile($vendor_data);
								 
						echo 1;
				}else{// รหัสผ่านใหม่กับยืนยันไม่เท่ากัน
						echo 2;
				}
		}else{ //รหัสผ่านใหม่น้อยกว่า 6 ตัวอักษร
					echo 3;
		}		
	}
	
	public function vendor_deal()
	{
		$this->check_vendor_login();
		
		$vendor_data		=  $this->vendor_profile->get_vendor_profile_by_id($this->vendor_id);
		
		$vendor_data	["deal_data"]		=	$this ->deal_main->get_deal_by_vendor_id_round($this->vendor_id);
		$view_data["total_sale"]					=	$this->deal_main->get_total_sale_by_vendor_id($this->vendor_id);

		$vendor_data	["over_view"]		= $this -> load -> view('vendor/vendor_summary_all.php',$view_data,true);
		$this -> page_data["content"]	=	$this -> load -> view('vendor/vendor_event.php',$vendor_data,true);
		$this -> render -> page_render($this -> page_data);	
	}
	public function show_sumary_deal($deal_id="",$product_id="")
	{
		if(empty($deal_id))
		{
			$view_data["total_sale"]		=		$this->deal_main->get_total_sale_by_vendor_id($this->vendor_id);
		
			$page	=	$this -> load -> view('vendor/vendor_summary_all.php',$view_data,true);
		}else{
			$view_data["deal_data"]			=		$this->deal_main->get_vendor_deal_by_id($deal_id);		
			$view_data["total_sale"]					=		$this->deal_main->get_total_sale_by_deal_id($deal_id,$product_id);
		
			if(!empty($product_id))
			$view_data["product_data"]	=		$this->deal_product->get_product_by_product_id($product_id);
	
			$page	=	$this -> load -> view('vendor/vendor_summary_deal.php',$view_data,true);
		}
			echo $page;
	}
	
	public function export_excel($deal_id="",$product_id="")
	{
		$view_data["total_sale"]					=		$this->deal_main->get_total_sale_by_deal_id($deal_id,$product_id);

		$this -> page_data["content"]	=	$page	=	$this -> load -> view('vendor/vendor_summary_excel.php',$view_data,true);
		$this -> render -> page_render($this -> page_data);
	}
	
	public function show_voucher($product_id="")
	{
			$view_data["product_data"]		=	$this->deal_product->get_product_by_product_id($product_id);
			$view_data["voucher_number"]	=	$this->input->post("coupon_id");
			$view_data["member_name"]		= 	$this->input->post("member_name");
			$view_data["voucher_status"]		= 	$this->input->post("coupon_status");
			
			if($view_data["voucher_number"]==""&&$view_data["member_name"]	==""&&$view_data["voucher_status"]=="")
			{
				$view_data["coupon_data"]		=		$this->member_coupon->get_coupon_by_product_id($product_id);
			}else{
				$view_data["coupon_data"]		=		$this->member_coupon->get_coupon_by_fillter($product_id,$view_data["voucher_number"],$view_data["member_name"]	,$view_data["voucher_status"]	);
			}
			$view_data["product_id"]			=		$product_id;
			
			$page	=	$this -> load -> view('vendor/vendor_voucher.php',$view_data,true);
			echo $page;
	}
	public function show_product($deal_id)
	{
		$product_data	=	$this ->deal_product->get_product_by_deal_id($deal_id);
		
		if(sizeof($product_data)>0)
		{
				echo '<option value="0">ทั้งหมด</option>';
			foreach ($product_data as $key => $data) 
			{
				//echo '<option value="'.$data["product_id"].'">'.$data["product_name"]." ".date("dmY",$data["round_start"]).'</option>';
				echo '<option value="'.$data["product_id"].'">'.$data["product_name"].'</option>';
			}
		}else{
			echo '<option value="">ยังไม่มีข้อมูล</option>';
		}
	}
	public function vendor_login()
	{
		$vendor_user		=	$this->input->post('vendor_user');
		$vendor_pwd		=	base64_encode($this->input->post('vendor_pwd'));
		
		$vendor_data		=  $this->vendor_profile->get_vendor_profile_by_login($vendor_user,$vendor_pwd);
		
		if(sizeof($vendor_data)>0)
		{
			$this->vendor_id		=	$vendor_data["vendor_id"];
			unset($vendor_data);

			$this->session->set_userdata('vendor_id',$this->vendor_id);
			$this->xlog_vendor_login->save_log($this->vendor_id,1);
			
			echo "1";
		}else{
			echo "0";
		}
	}

	public function vendor_logout()
	{
		$this->check_vendor_login();
		
		$this->session->unset_userdata('vendor_id');
		$this->xlog_vendor_login->save_log($this->vendor_id,2);
		echo 1;
	}
	public function vendor_save_profile()
	{
		$this->check_vendor_login();
		
		$vendor_data["vendor_name"]				=  $this->input->post("vendor_name");
		$vendor_data["vendor_contact_fname"]	=  $this->input->post("vendor_contact_fname");
		$vendor_data["vendor_contact_sname"]	=  $this->input->post("vendor_contact_sname");
		$vendor_data["vendor_email"]					=  $this->input->post("vendor_email");
		$vendor_data["vendor_address"]				=  $this->input->post("vendor_address");
		$vendor_data["vendor_fax"]					=  $this->input->post("vendor_fax");
		$vendor_data["vendor_phone"]				=  $this->input->post("vendor_phone");
		$vendor_data["vendor_modify"]				=  date("Y-m-d H:i:s",time());

		$vendor_data["vendor_id"]	=	$this->vendor_id;	
		$this->vendor_profile->update_verndor_profile($vendor_data);
		echo 1;
	}
	public function vendor_change_password()
	{
		$this->check_vendor_login();
		
		$old_password			=	$this->input->post("vendor_password");
		$new_password			=	$this->input->post("vendor_new_password");
		$vendor_confirm_password		=	$this->input->post("vendor_confirm_password");
		
		if($this->vendor_profile->check_pwd($old_password,$this->vendor_id)){
				if(strlen($new_password) > 5){
						if($new_password == $vendor_confirm_password){
								$vendor_data["vendor_id"]		=	$this->vendor_id;	
								$vendor_data["vendor_pwd"]	=	base64_encode($new_password);
								$this->vendor_profile->update_verndor_profile($vendor_data);
								
								echo 1;
						}else{// รหัสผ่านใหม่กับยืนยันไม่เท่ากัน
								echo 2;
						}
				}else{ //รหัสผ่านใหม่น้อยกว่า 6 ตัวอักษร
					echo 3;
				}
		}else{ // ไม่มีรหัสผ่านนี้
			echo 0;
		}
	}
	
	public function get_vendor($deal_id="")
	{
		if(!empty($deal_id))
		{
			$vendor	=	$this->vendor_profile->get_vendor_profile_by_dealid($deal_id);
			if($vendor["vendor_name"] == "")
					echo "-";
			else 
					echo $vendor["vendor_name"];
		}else{
			echo "-";
		} 
	}
	
	public function export_view()
	{
			$send_data	=	$this->input->post();
			$export			=	$send_data["export"];
			$product_id	=	$send_data["product_id"];
			
			$view_data["product_data"]		=	$this->deal_product->get_product_by_product_id($product_id);
			$view_data["voucher_number"]	=	$this->input->post("coupon_id");
			$view_data["member_name"]		= 	$this->input->post("member_name");
			$view_data["voucher_status"]		= 	$this->input->post("coupon_status");
			
			if($export=="excel_all"||$export=="print_all")
			{
				$view_data["coupon_data"]		=		$this->member_coupon->get_coupon_by_product_id($product_id);
			}else{
				$view_data["coupon_data"]		=		$this->member_coupon->get_coupon_by_coupon_list($product_id,$send_data["row_id"]);
			}
			
			if($export=="print_selected"||$export=="print_all")
			{
				$page	=	$this -> load -> view('vendor/vendor_voucher_export.php',$view_data);
			}
			if($export=="excel_selected"||$export=="excel_all")
			{
				$filename	=	"voucher_list_".$product_id."\.csv";
	
				$this->output->set_header("Pragma: public");
    			$this->output->set_header("Expires: 0");
    			$this->output->set_header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
    			$this->output->set_header("Content-Type: application/force-download");
    			$this->output->set_header("Content-Type: application/octet-stream");
    			$this->output->set_header("Content-Type: application/download");
    			$this->output->set_header("Content-Disposition: attachment;filename={$filename}");
    			$this->output->set_header("Content-Transfer-Encoding: binary");
		
				$page	=	$this -> load -> view('vendor/vendor_voucher_csv.php',$view_data);
			}
	}
}