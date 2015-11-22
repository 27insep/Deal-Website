<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Category extends CI_Controller {
	protected $layout = 'template/fontend_template.php';
	
	protected $stylesheets = array(
    	'base.css',
    	'blitzer/jquery-ui.css',
    	'fancybox/jquery.fancybox.css?v=2.1.4',
    	'fancybox/helpers/jquery.fancybox-buttons.css?v=1.0.5',
    	'fancybox/helpers/jquery.fancybox-thumbs.css?v=1.0.7'
  	);
	
  	protected $javascripts = array(
  		'jquery.min.js',
  		'jquery.eislideshow.js',
  		'jquery.validate.js',
  		'jquery.easing.1.3.js',
		'jquery.form.js',
		'jquery-ui.min.js',
		'jquery.lazyload.min.js',
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
		
		$this->load->model('category_main');
		$this->load->model('category_sub');
		$this->load->model('deal_main');
  	}
	private function show_deal_by_category($cat_name="",$cat_id="",$page="")
	{
		
		$cat_data		=	explode("_", $cat_id);
		
		$cat_id			=	$cat_data[0];
		$sub_cat_id		=	"";
		$page_cat_id	=	$cat_id;
		
		if(isset($cat_data[1]))
		{
			$sub_cat_id			=	$cat_data[1];
		}	
		$sub_menu_data	=	array();
		
		if(!empty($cat_id))
		{
			$sub_cat_data		=	$this->category_sub->get_category_sub_by_category_id($cat_id);
			
			$index				=	$cat_id;
			$total_sub_active_deal									=	$total_active_deal	=	$this->deal_main->get_total_active_deal_category($cat_id);
			$sub_menu_data[$index]["sub_menu_name"]	= 	"ทั้งหมด (".$total_sub_active_deal.")";
			$sub_menu_data[$index]["sub_menu_link"]		= 	"/category/show/".$cat_name."/".$cat_id;	
			
			foreach($sub_cat_data as $sub_menu)
			{
				$index	=	$sub_menu["sub_cat_id"];
				$total_sub_active_deal									=	$this->deal_main->get_total_active_deal_sub_category($index);
				$sub_menu_data[$index]["sub_menu_name"]	= $sub_menu["sub_cat_name"]." (".$total_sub_active_deal.")";
				$sub_menu_data[$index]["sub_menu_link"]		= "/category/show/".$sub_menu["sub_cat_name"]."/".$cat_id."_".$index;	
			}
			$show_arrow	=	false;
			if(sizeof($sub_menu_data)>7)
			{
				$show_arrow	=	true;	
			}
		}	
		unset($cat_data);
		
		switch($cat_id)
		{
			case 1:
				$this->page_data["page_title"]	=	"โรงแรมและที่พักหัวหิน โรงแรมและที่พักกระบี่ โรงแรมและที่พักภูเก็ต ราคาถูกสุดที่ต้องรีบซื้อ";
				$this->page_data["deal"]			=	array(	"deal_meta_keyword"=>"โรงแรมและที่พักหัวหิน,โรงแรมและที่พักกระบี่,โรงแรมและที่พักภูเก็ต",
																			"deal_meta_description"=>"รวมดีลโรงแรมและที่พักราคาถูกสุดในสามโลกลด50-90% โรงแรมและที่พักหัวหิน โรงแรมและที่พักกระบี่ โรงแรมและที่พักภูเก็ต โรงแรมและที่พักชลบุรี โรงแรมและที่พักกาญจนบุรี โรงแรมและที่พักประจวบคีรีขันธ์ โรงแรมและที่พักเชียงใหม่ โรงแรมและที่พักเชียงราย โรงแรมและที่พักเพชรบุรี โรงแรมและที่พักราชบุรี โรงแรมและที่พักจันทบุรี โรงแรมและที่พักตราด ดีลโรงแรม ดีลที่พัก");
				
			break;
			case 2:
				$this->page_data["page_title"]	=	"บุฟเฟ่ต์โรงแรม บุฟเฟ่ต์นานาชาติ บุฟเฟ่ต์ญี่ปุ่น ดีลถูกจนเหลือเชื่อ";
				$this->page_data["deal"]			=	array(	"deal_meta_keyword"=>"บุฟเฟ่ต์โรงแรม, บุฟเฟ่ต์นานาชาติ, บุฟเฟ่ต์ญี่ปุ่น",
																			"deal_meta_description"=>"รวมดีลบุฟเฟ่ต์โรงแรม บุฟเฟ่ต์นานาชาติ บุฟเฟ่ต์ญี่ปุ่น ราคาถูกสุดในสามโลกลด50-90% ดีลถูกจนเหลือเชื่อ");
				
			break;
			case 3:
				$this->page_data["page_title"]	=	"รวมดีลสปาราคาถูก คลีนิคความงาม เสริมความงาม";
				$this->page_data["deal"]			=	array(	"deal_meta_keyword"=>"สปา,คลีนิคความงาม, คลีนิคเสริมความงาม",
																			"deal_meta_description"=>"รวมดีลสปาราคาถูก คลีนิคเสริมความงาม ราคาถูกสุดในสามโลกลด50-90% สปา คลีนิคความงามราคาถูกมาก");
				
			break;
			case 4:
				$this->page_data["page_title"]	=	"แต่งงาน ถ่ายรูปแต่งงาน เรียนพิเศษ กิจกรรมเรียนรู้";
				$this->page_data["deal"]			=	array(	"deal_meta_keyword"=>"ถ่ายรูปแต่งงาน, จัดงานแต่งงาน,เรียนต่อต่างประเทศ, เรียนพิเศษ, สอนภาษา, กิจกรรม",
																			"deal_meta_description"=>"รวมดีลถ่ายรูปแต่งงาน เรียนพิเศษ กิจกรรมเรียนรู้ ราคาถูกสุดในสามโลกลด50-90%");
				
			break;
			default:
				$this->page_data["page_title"]	=	"รวมโรงแรมและที่พักในหัวหิน กระบี่ ภูเก็ต ดีลโรงแรมราคาถูกสุด ราคาพิเศษ";
				$this->page_data["deal"]			=	array(	"deal_meta_keyword"=>"โรงแรมและที่พักหัวหิน,โรงแรมและที่พักกระบี่,โรงแรมและที่พักภูเก็ต,ดีลราคาถูก,ดีลราคาพิเศษ",
																			"deal_meta_description"=>"รวมดีลโรงแรมและที่พักราคาถูกสุดในสามโลกลด50-90% โรงแรมและที่พักในหัวหิน กระบี่ ภูเก็ต ชลบุรี กาญจนบุรี ประจวบคีรีขันธ์ เชียงใหม่ เชียงราย เพชรบุรี ราชบุรี จันทบุรี ตราด รวมบุฟเฟ่ต์โรงแรม บุฟเฟ่ต์นานาชาติ บุฟเฟ่ต์ญี่ปุ่น");
		}
		
		$slide_img	=	array();
		
		$index	=	0;

		$this->db->select("promotion_id,promotion_link,pic_path,thumb_path,pic_order,promotion_status");
		$this->db->where("promotion_status","1");	
		$this->db->order_by('pic_order asc'); 
		$query 				= $this->db->get("tbl_promotion_slide");
		$promotion_data	= $query -> result_array();
		
		foreach($promotion_data as $promotion)
		{
			$slide_img[$index]['large']		=	$promotion["pic_path"];	
			$slide_img[$index]['thumbs']	=	$promotion["thumb_path"];
			$slide_img[$index]['title']		=	'';	
			$slide_img[$index]['name']		=	'';
			$slide_img[$index]['link']			=	$promotion["promotion_link"];	
			$index++;
		}
		unset($promotion_data);
		unset($index);
		
		if(empty($cat_id))	
		{
			$cat_name		=	"ดีลทั้งหมด";
			$cat_id			=	0;
		}else{
			if(empty($sub_cat_id))
			{
				$cat_data		=	$this->category_main->get_category_data($cat_id);
				$cat_name		=	$cat_data["cat_name"];
				unset($cat_data);
			}else{
				$cat_data		=	$this->category_sub->get_sub_category_data($sub_cat_id);
				$cat_name		=	$cat_data["sub_cat_name"];
				$cat_id			=	$cat_data["cat_id"]."_".$cat_data["sub_cat_name"];
				
				$cat_data		=	$this->category_main->get_category_data($cat_id);
				$main_cat_name		=	$cat_data["cat_name"];
				
				$this->page_data["page_title"]	=	$main_cat_name." ".$cat_name;
				$this->page_data["deal"]			=	array(	"deal_meta_keyword"=>$cat_name,
																			"deal_meta_description"=>"รวมโปรโมชั่น ".$main_cat_name." ".$cat_name." ราคาถูกที่สุด รับส่วนลดสูงสุดถึง 50-90% รีบสั่งซื้อเลย");		
				unset($cat_data);
			}
		}
		
		$per_page		=	30;
		
		if(empty($page))
		{
			$st = 0;
		}else{
			$st	=	($page-1)*$per_page;
		}
		
		if(empty($sub_cat_id))
		{
			$total_active_deal	=	$this->deal_main->get_total_active_deal_category($cat_id);
		}else{
			$total_active_deal	=	$this->deal_main->get_total_active_deal_sub_category($sub_cat_id);
		}
		
		$max_page			=	(int)(($total_active_deal-1)/$per_page)+1;
		
		//echo $total_active_deal;
		$nevigotor_page		=	"<div>หน้า : </div>";
		
		for($i=1;$i<=$max_page;$i++)
		{
			$nevigotor_page		.=	'<a href="/category/show/'.$cat_name.'/'.$cat_id.'/'.$i.'">'.$i.'</a> ';
		}
		
		$content_data["slide"]						=	$slide_img;
		$content_data["category_name"]		=	$cat_name;
		if(empty($sub_cat_id))
		{
			$content_data["deal_data"]				=	$this->deal_main->get_active_deal_category($cat_id,$st,$per_page);
		}else{
			$content_data["deal_data"]				=	$this->deal_main->get_active_deal_sub_category($sub_cat_id,$st,$per_page);	
		}
		$content_data["page_navigator"]			=	$nevigotor_page;
		$content_data["page_id"]					=	"b";
		if(sizeof($sub_menu_data)>0)
		{
			$content_data["sub_menu_data"]	=	$sub_menu_data;
			$content_data["show_arrow"]			=	$show_arrow;
		}
		
		if(!empty($cat_id))
		$content_data["page_id"]				=	$page_cat_id;	
		
		$member_id =	$this->session->userdata('member_id');
		if(!empty($member_id))
		{
			$content_data["login"]	=	true;
		}else{
			$content_data["login"]	=	false;
		}
		
		$this->page_data["content"]			=	$this -> load -> view('home.php',$content_data, true);
		
    	$this->render->fontend_page_render($this->page_data);
		
	}
	public function promote($page="")
	{
		$this->page_data["page_title"]	=	"รวมโรงแรมและที่พักหัวหิน โรงแรมและที่พักกระบี่ โรงแรมและที่พักภูเก็ต ดีลราคาถูกสุด";
		
		$slide_img	=	array();
		$index	=	0;
		
		$this->db->select("promotion_id,promotion_link,promotion_name,promotion_detail,pic_path,thumb_path,pic_order,promotion_status");
		$this->db->where("promotion_status","1");	
		$this->db->order_by('pic_order asc'); 
		$query 		= $this->db->get("tbl_promotion_slide");
		$promotion_data	=	$query -> result_array();
		
		foreach($promotion_data as $promotion)
		{
			$slide_img[$index]['large']		=	$promotion["pic_path"];	
			$slide_img[$index]['thumbs']	=	$promotion["thumb_path"];
			$slide_img[$index]['title']		=	$promotion["promotion_name"];	
			$slide_img[$index]['name']		=	$promotion["promotion_detail"];
			$slide_img[$index]['link']			=	$promotion["promotion_link"];	
			$index++;
		}
		unset($promotion_data);
		
		unset($index);
		
		$sub_menu_data	=	array();
		
		$sub_cat_data		=	$this->category_sub->get_category_sub_by_category_id();
		
		/*
		$index				=	$cat_id;
		$total_sub_active_deal									=	$total_active_deal	=	$this->deal_main->get_total_active_deal_category($cat_id);
		$sub_menu_data[$index]["sub_menu_name"]	= 	"ทั้งหมด (".$total_sub_active_deal.")";
		$sub_menu_data[$index]["sub_menu_link"]		= 	"/category/show/".$cat_name."/".$cat_id;	
		*/
		
		foreach($sub_cat_data as $sub_menu)
		{
			$cat_id														=	$sub_menu["cat_id"];
			$index														=	$sub_menu["sub_cat_id"];
			$total_sub_active_deal									=	$this->deal_main->get_total_active_deal_sub_category($index);
			$sub_menu_data[$index]["sub_menu_name"]	= $sub_menu["sub_cat_name"]." (".$total_sub_active_deal.")";
			$sub_menu_data[$index]["sub_menu_link"]		= "/category/show/".$sub_menu["sub_cat_name"]."/".$cat_id."_".$index;	
		}
		$show_arrow	=	false;
		if(sizeof($sub_menu_data)>7)
		{
			$show_arrow	=	true;	
		}	
		unset($cat_data);
		
		$cat_name		=	"ดีลเด่นวันนี้";
		$cat_id			=	0;

		$per_page		=	100;
		
		if(empty($page))
		{
			$st = 0;
		}else{
			$st	=	($page-1)*$per_page;
		}
		
		$total_active_deal	=	$this->deal_main->get_total_active_deal_category($cat_id);
		$max_page			=	(int)(($total_active_deal-1)/$per_page)+1;
		
		//echo $total_active_deal;
		$nevigotor_page		=	"<div>หน้า : </div>";
		
		for($i=1;$i<=$max_page;$i++)
		{
			$nevigotor_page		.=	'<a href="/category/promote/'.$i.'">'.$i.'</a> ';
		}
		
		$content_data["slide"]						=	$slide_img;
		$content_data["category_name"]		=	$cat_name;
		$content_data["deal_data"]				=	$this->deal_main->get_best_deal($st,$per_page);
		$content_data["page_navigator"]		=	$nevigotor_page;
		$content_data["page_id"]				=	"a";	
		
		$member_id =	$this->session->userdata('member_id');
		if(!empty($member_id))
		{
			$content_data["login"]	=	true;
		}else{
			$content_data["login"]	=	false;
		}
		
		if(sizeof($sub_menu_data)>0)
		{
			$content_data["sub_menu_data"]	=	$sub_menu_data;
			$content_data["show_arrow"]			=	$show_arrow;
		}
		
		$this->page_data["content"]			=	$this -> load -> view('home.php',$content_data, true);
		$this->page_data["deal"]				=	array(	"deal_meta_keyword"=>"โรงแรมและที่พักหัวหิน,โรงแรมและที่พักกระบี่,โรงแรมและที่พักภูเก็ต,ดีลราคาถูก,ดีลราคาพิเศษ",
																		"deal_meta_description"=>"รวมดีลโรงแรมและที่พักราคาถูกสุดในสามโลกลด50-90% โรงแรมและที่พักหัวหิน โรงแรมและที่พักกระบี่ โรงแรมและที่พักภูเก็ต โรงแรมและที่พักชลบุรี โรงแรมและที่พักกาญจนบุรี โรงแรมและที่พักประจวบคีรีขันธ์ โรงแรมและที่พักเชียงใหม่ โรงแรมและที่พักเชียงราย โรงแรมและที่พักเพชรบุรี โรงแรมและที่พักราชบุรี โรงแรมและที่พักจันทบุรี โรงแรมและที่พักตราด บุฟเฟ่ต์โรงแรม บุฟเฟ่ต์นานาชาติ บุฟเฟ่ต์ญี่ปุ่น");
		

		
    	$this->render->fontend_page_render($this->page_data);
		
	}
	public function finddeal()
	{
		$keyword		=	$this->input->post("keyword");
		
		$cat_name		=	$keyword;
		$cat_id			=	0;

		$per_page		=	100;
		
		if(empty($page))
		{
			$st = 0;
		}else{
			$st	=	($page-1)*$per_page;
		}
		
		$total_active_deal	=	$this->deal_main->get_total_active_deal_keyword($keyword);
		$max_page			=	(int)(($total_active_deal-1)/$per_page)+1;
		
		//echo $total_active_deal;
		$nevigotor_page		=	"<div>หน้า : </div>";
		
		for($i=1;$i<=$max_page;$i++)
		{
			$nevigotor_page		.=	'<a href="/category/promote/'.$i.'">'.$i.'</a> ';
		}
		
		$content_data["category_name"]	=	$cat_name;
		$content_data["deal_data"]			=	$this->deal_main->get_deal_by_keyword($st,$per_page,$keyword);
		$content_data["page_navigator"]		=	$nevigotor_page;
		$content_data["page_id"]				=	"";	
		
		$member_id =	$this->session->userdata('member_id');
		if(!empty($member_id))
		{
			$content_data["login"]	=	true;
		}else{
			$content_data["login"]	=	false;
		}
		//print_r($content_data["deal_data"]);
		
		$this -> load -> view('show_category.php',$content_data);
	}
	public function index()
	{
		//$this->show_deal_by_category();
		$this->promote();
	}
	public function show($cat_name="",$cat_id="",$page="")
	{
		$this->show_deal_by_category($cat_name,$cat_id,$page);
	}
	public function deal($deal_id)
	{		
		//$content_data["deal"]					=	$this->deal_main->get_active_deal_by_id($deal_id);
		$content_data["deal"]					=	$this->deal_main->get_deal_by_id($deal_id);
	
		$cat_data									=	array("1"=>"โรงแรม-รีสอร์ท","2"=>"อาหาร","3"=>"สุขภาพ-ความงาม","4"=>"กิจกรรม");
		$this->page_data["page_title"]	=	$content_data["deal"]["deal_name"]." ".$cat_data[$content_data["deal"]["cat_id"]];
		$this->page_data["deal"]			=	array(	"deal_meta_keyword"=>$content_data["deal"]["deal_meta_keyword"],
																		"deal_meta_description"=>$content_data["deal"]["deal_meta_description"]);
		if(sizeof($content_data["deal"])<1)
		{
			exit;
		}
		$this->load->model('deal_gallery');
		$content_data["relate_deal"]		=	$this->deal_main->get_relate_deal($deal_id,4);
		$content_data["deal_gallery"]		=	$this->deal_gallery->get_gallery_by_deal_id($deal_id);
		
		$member_id =	$this->session->userdata('member_id');
		if(!empty($member_id))
		{
			$content_data["login"]	=	true;
		}else{
			$content_data["login"]	=	false;
		}
		$this->db->select("pic_path");
		$query = $this -> db -> get_where("tbl_deal_slide",array("deal_id"=>$deal_id));
		
		$content_data["deal_slide"]	=	$query -> result_array();
		
		$this->page_data["content"]		=	$this -> load -> view('show_deal.php',$content_data, true);

    	$this->render->fontend_page_render($this->page_data);
	}
	public function deal_preview($deal_id)
	{
		$this->deal($deal_id);
	}
	public function get_sub_category($cat_id="",$sub_cat="")
	{
		if(!empty($cat_id))
		{
			$sub_category_data	=	$this->category_sub->get_category_sub_by_category_id($cat_id);
			echo '<select name="sub_cat_id" id="sub_cat_id">';
			echo '<option value="">- - - กรุณาเลือกหมดวสินค้าย่อย - - -</option>';
			foreach($sub_category_data as $sub_category)
			{
				echo '<option value="'.$sub_category["sub_cat_id"].'"';
				if(!empty($sub_cat)&&$sub_cat==$sub_category["sub_cat_id"])
					echo 'selected="selected"';
				echo '>'.$sub_category["sub_cat_name"].'</option>';
			}
			echo '</select>';
		}else{
			echo '<select name="sub_cat_id" id="sub_cat_id">';
			echo '<option value="">- - - กรุณาเลือกหมดวสินค้าย่อย - - -</option>';
			echo '</select>';
		} 
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */