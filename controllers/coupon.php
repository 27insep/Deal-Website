<?php
	define('FPDF_FONTPATH','fonts/');
	include_once($_SERVER["DOCUMENT_ROOT"] .'/main/libraries/code128.php');
	
if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class Coupon extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		
		$this->load->helper('url');
		$this->load->library('convert_date');
		//$this->load->library('pdfcrowd');
		$this->load->model('coupon_main');
		$this->load->database();
	}
	
	function index() 
	{	
		$this->printPDF();
	}
	function change_status_coupon($status,$coupon_id)
	{
		$this->coupon_main->update_coupon_status($status,$coupon_id);
		echo 1;
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
	function clear_text_editor($text)
	{
		$text = str_replace('&nbsp;',' ',$text);
		$text = str_replace('&bull;',"•",$text);
		$text = str_replace('&ndash;','-',$text);
		$text = str_replace('&amp;','&',$text);
		$text = str_replace("<br />","\n",$text);
		$text	= strip_tags($text);
		
		return $text;
	}
	
	function printPDF($member_id="",$deal_id="",$coupon_id="")
	{
			$pdf=new PDF_Code128();
			 
			// เพิ่มฟอนต์ภาษาไทยเข้ามา ตัวธรรมดา กำหนด ชื่อ เป็น angsana
			$pdf->AddFont('angsana','','angsa.php');
			 
			// เพิ่มฟอนต์ภาษาไทยเข้ามา ตัวหนา  กำหนด ชื่อ เป็น angsana
			$pdf->AddFont('angsana','B','angsab.php');
			 
			$pdf->AddFont('angsana','I','angsai.php');
			$pdf->AddFont('angsana','BI','angsaz.php');
			 
			//สร้างหน้าเอกสาร
			$pdf->AddPage();
			 
			 if($coupon_id != "")	
			{
					$coupon_data	=	$this->coupon_main->get_coupon($member_id,$deal_id,$coupon_id);
					
					$deal_name	=	$coupon_data["deal_main"]["deal_name"];
					$vendor_logo	=	$coupon_data["deal_main"]["vendor_logo"];
					$location = $coupon_data["deal_main"]["location"];
					$fine_print = $coupon_data["deal_main"]["deal_main_detail"];
					$deal_main_condition = $coupon_data["deal_main"]["deal_main_condition"];
					$vendor_email 		= $coupon_data["deal_main"]["vendor_email"];
					$vendor_website = $coupon_data["deal_main"]["vendor_website"];
					$mem_name	=	$coupon_data["member"]["member_name"]."   ".$coupon_data["member"]["member_sname"];
					$member_id	=	$coupon_data["member"]["member_id"];
					$coupon	=	$coupon_data["coupon"]["coupon_id"];
					$barcode =	$coupon_data["coupon"]["barcode"];
					$voucher_number = $coupon_data["coupon"]["voucher_number"];
					$order_id	=	$coupon_data["coupon"]["order_id"];
					$redemption_code	=	$coupon_data["coupon"]["redemption_code"];
					$product_name = $coupon_data["coupon"]["product_name"];
					$product_detail = $coupon_data["coupon"]["product_detail"];
					$coupon_can_use = $coupon_data["coupon"]["coupon_can_use"];
					$coupon_expire = $coupon_data["coupon"]["coupon_expire"];
				
					$coupon_can_use_full=$this->thai_date(strtotime(date_format(date_create($coupon_can_use),"Y-m-d")));   
					$coupon_expire_full=$this->thai_date(strtotime(date_format(date_create($coupon_expire),"Y-m-d")));   
					
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
					$pdf->MultiCell( 70  , 4 , iconv( 'UTF-8','cp874' , $product_detail),0,'L' );
					
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
					
				/*	$pdf->SetFont('angsana','',10);
					$pdf->setXY( 10, 100  );
					$pdf->MultiCell( 0  , 0 , iconv( 'UTF-8','cp874' , '--------------------------------------------------------------------------------------------------------------------------------------------') ); */
					
					
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
					

					$pdf->Output();
		}
	}
}

?>