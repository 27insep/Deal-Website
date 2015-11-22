<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns:fb="http://ogp.me/ns/fb#">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link rel="stylesheet" type="text/css" href="/assets/css/receipt.css" />
	<script type="text/javascript" src="/assets/js/jquery.printElement.min.js"></script>
</head>
<body>
			<?
				function thai_date($time)
				{
					    global $thai_month_arr;  
						
						$thai_month_arr=array(  
							    "0"=>"",  
							    "1"=>"มกราคม",  
							    "2"=>"กุมภาพันธ์",  
							    "3"=>"มีนาคม",  
							    "4"=>"เมษายน",  
							    "5"=>"พฤษภาคม",  
							    "6"=>"มิถุนายน",   
							    "7"=>"กรกฎาคม",  
							    "8"=>"สิงหาคม",  
							    "9"=>"กันยายน",  
							    "10"=>"ตุลาคม",  
							    "11"=>"พฤศจิกายน",  
							    "12"=>"ธันวาคม"                    
						);  
				
					    $thai_date_return=  " &nbsp;".date("j",$time);  
					    $thai_date_return.= " &nbsp;".$thai_month_arr[date("n",$time)];  
					    $thai_date_return.= " &nbsp;".(date("Y",$time));  
					    return $thai_date_return;  
				}  
			?>
<div id="receipt">
<div class="receipt_box">
		<div class="company_box">
			<div><?=image_asset('../../assets/images/company_logo.png');?></div>
			<div class="address_1">บริษัท เดอะ เบสท์ ดีล จำกัด</div>
			<div class="address_2">เลขที่  12/14  ปากทางลาดพร้าว แขวงจอมพล เขตจตุจักร กรุงเทพฯ  10900</div>
			<div class="address_2">โทรศัพท์: 02-938-4399   แฟกซ์ : 02-938-4399</div>
			<div class="address_2">อีเมล์ :info@thebestdeal1.com</div>
			<div class="address_2">เลขที่ประจำตัวผู้เสียภาษี : 0105555180399</div>
		</div>
		<div class="acknow_box">
					<div class="acknow">ใบเสร็จรับเงิน / ใบส่งสินค้า</div>
					<div class="acknow_detail">เลขที่ใบเสร็จ/เลขที่ใบส่งสินค้า : <?if(isset($order_data["order"]["receipt_id"] ))echo $order_data["order"]["receipt_id"];?></div>
					<div class="acknow_detail">เลขที่ใบสั่งซื้อ (REF. 1) : <?=$order_data["order"]["order_id"]?></div>
					<div class="acknow_detail">เลขที่ลูกค้า (REF. 2) : <?=$order_data["order"]["mem_id"]?></div>
					<div class="acknow_detail">วันที่ :  
					<?
					 		$eng_date=strtotime(date_format(date_create($order_data["order"]["order_pay_date"]),"Y-m-d"));   
							echo thai_date($eng_date);  
			 		?>
					</div>
				</div>
		</div>
		<div class="pay_box">
				<div class="acknow_addr">ที่อยู่สำหรับเรียกเก็บเงิน</div>
		</div>
		<div class="acknow_cus"><?=$order_data["order"]["member_name"]." ".$order_data["order"]["member_sname"]?></div>
		<div class="acknow_cus2"><?=$order_data["order"]["member_address"]." ".$order_data["order"]["city_name"]?></div>
		<div class="acknow_cus2"><?=$order_data["order"]["province_name"]." ".$order_data["order"]["member_zipcode"]?></div>
		
		<div class="acknow_payment">วิธีการชำระเงิน</div>
		<div class="payment">
			<?
				if($order_data["order"]["payment_type"] == "1")
					echo "ชำระเงินผ่านธนาคารกสิกรไทย";
				elseif($order_data["order"]["payment_type"] == "2")
					echo "ชำระเงินผ่านธนาคารไทยพาณิชย์";
				elseif($order_data["order"]["payment_type"] == "3")
					echo "ชำระเงินผ่านธนาคารกรุงเทพ";
				elseif($order_data["order"]["payment_type"] == "4")
					echo "ชำระเงินผ่านธนาคารกรุงศรีอยุธยา";
				elseif($order_data["order"]["payment_type"] == "5")
					echo "ชำระเงินผ่านเคาน์เตอร์เซอร์วิส";
				elseif($order_data["order"]["payment_type"] == "6")
					echo "ชำระเงินผ่านเทสโก้ โลตัส";
				elseif($order_data["order"]["payment_type"] == "7")
					echo "ชำระเงินออนไลน์";
				elseif($order_data["order"]["payment_type"] == "8")
					echo "No Payment Required";
			?>
		</div>
		<div class="acknow_order">รายการที่ออกใบเสร็จ / ใบส่งสินค้า :</div>
		<div class="acknow_table">
				<div class="acknow_row_head">
						<div class="acknow_column_head1">ชื่อสินค้า</div>
						<div class="acknow_column_head2">ราคา</div>
						<div class="acknow_column_head2">จำนวน</div>
						<div class="acknow_column_head2">รวม</div>
				</div>
				<? 	$total = 0;
						foreach($order_data["order_detail"] as $detail){?>
				<div class="acknow_row">
						<div class="acknow_column1"><?=$detail["product_name"]?></div>
						<div class="acknow_column2">฿<?=number_format ($detail["product_total_price"], 2)?></div>
						<div class="acknow_column2"><?=$detail["product_qty"]?></div>
						<div class="acknow_column2">฿<?=number_format (($detail["product_total_price"] * $detail["product_qty"]), 2)?></div>
				</div>
				<? $total = $total+($detail["product_total_price"] * $detail["product_qty"]); }?>
				<div class="acknow_row_head">
						<div class="acknow_column_total">รวมทั้งหมด</div>
						<div class="acknow_total">฿<?=number_format ($total, 2)?></div>
				</div>
		</div>
</div>
<div align="center" class="clear"><input type="button" value="พิมพ์หน้านี้" onclick="print_page()" style="cursor: pointer;"/></div>
<br/>
<script>
	function print_page()
	{
		//window.print();
		//$('#print_button').hide();
		$("#receipt").printElement(
            {
            overrideElementCSS:[
		'receipt.css',
		{ href:'/assets/css/receipt.css',media:'print'}]
            });
	}
</script>
</body>
</html>