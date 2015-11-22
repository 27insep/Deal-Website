<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns:fb="http://ogp.me/ns/fb#">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link rel="stylesheet" type="text/css" href="/assets/css/coupon.css" />
<style>
	@media print
  	{
  		.print
  		{
  			display: none;
  		}
  	}
</style>
</head>
<body> 
	<?
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
				
					    $thai_date_return=  "&nbsp;".date("j",$time);  
					    $thai_date_return.= "&nbsp;".$thai_month_arr[date("n",$time)];  
					    $thai_date_return.= "&nbsp;".(date("Y",$time));  
					    return $thai_date_return;  
				}  
			?>
    <div class="print" id="coupon_print"><span style="cursor: pointer" onclick="print_page();"><?echo image_asset('bt_pdf.png', '', array('alt'=>'พิมพ์'));?></span></div>
	<div class="print"><a href="/coupon/printPDF/<?=$member_id?>/<?=$deal_id?>/<?=$coupon_id?>"><?echo image_asset('bt_print.png', '', array('alt'=>'บันทึกเป็น PDF'));?></a></div>
	<div id="print_zone" style="clear: both;">
    <div class="h_Sec">
    	<div class="printcoupon_box">
            <div class="image_logo"><?=image_asset('../../assets/images/company_logo.png');?></div>
            <div class="deal_box"><?=$product_detail?></div>
            <div class="product_box"><b><?=$deal_name?></b> &nbsp;# <?=$product_name?></div>
            <div class="purchased">PURCHASED BY :</div>
            <div class="mem_name"><?=$mem_name?></div>
            <div class="voucher">VOUCHER NUMBER :</div>
            <div class="order_id">ORDER ID:</div>
            <div class="voucher_data"><?=$voucher_number?></div>
            <div class="order_id_data"><?=$order_id?></div>
            <div class="voucher">CUSTOMER ID :</div>
            <div class="order_id">REDEMPTION CODE :</div>
            <div class="voucher_data"><?=$member_id?></div>
            <div class="order_id_data"><?=$redemption_code?></div>
        </div>
		<div class="detail_box">
            <div class="logo"></div>
            <div class="barcode_box" style="padding: 0 10px;"><img src="http://www.barcodesinc.com/generator/image.php?code=<?=$barcode?>&style=164&type=C128B&width=280&height=100&xres=1&font=5"/></div>
            <div class="coupon_time_head">สงวนลิขสิทธิ์ไม่คืนเงินสำหรับคูปองที่ไม่ได้ใช้ภายในระยะเวลา</div>
            <div class="valid">VALID  FROM:</div>
            <?
                        $coupon_can_use_full=strtotime(date_format(date_create($coupon_can_use),"Y-m-d"));   
                        $coupon_expire=strtotime(date_format(date_create($coupon_expire),"Y-m-d"));   
                 ?>
            <div class="coupon_time"><?=thai_date($coupon_can_use_full)?> &nbsp;to <?=thai_date($coupon_expire)?></div>
            <div class="qrcode_box">
                <div class="qr_text1">Need Assistance?</div>
                <div class="qr_text2">Call Thebestdeal1 : 02 938 4399 | Email : info@thebe​stdeal1.com</div>
                <div class="img1"><?=image_asset('../../assets/images/thebestdeal1.png');?></div>
                <div class="img3"><?=image_asset('../../assets/images/facebook.png');?></div>
                <div class="qr_text3">Thebestdeal1.com</div>
                <div class="qr_text4">Facebook</div>
            </div>
        </div>
    </div>
    <div class="m_Sec">
    	<div class="m_SecL">
            <div class="fine_print">Fine Print :</div>
            <div class="fine_print_detail"><?=$fine_print?></div>
        </div>
        <div class="m_SecR">
        	<div class="location_text">Location : </div>
            <div class="location"><?=$location?></div>
            <div class="location_email"><? if (isset($vendor_email)){?>Email : <?=$vendor_email; }?></div>
            <div class="location_email"><? if (isset($vendor_website)){?>Website : <?=$vendor_website; }?></div>
            <div class="other_text">Other : </div>
            <div class="other"><?=$deal_main_condition?></div>
        </div>
    	
    </div>
	</div>
<script>
	function print_page()
	{
		window.print();
	}
</script>
	
</body>
</html>