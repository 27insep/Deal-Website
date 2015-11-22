<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns:fb="http://ogp.me/ns/fb#">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<script type="text/javascript" src="/assets/js/jquery.printElement.min.js"></script>
</head>
<body>
<div id="receipt_print">
	<link rel="stylesheet" type="text/css" href="/assets/css/receipt.css" />
			<div class="receipt_box">
					<div class="company_box">
							<div><?=image_asset('../../assets/images/company_logo.png');?></div>
							<div class="address_1">บริษัท เดอะ เบสท์ ดีล จำกัด</div>
							<div class="address_2">เลขที่  12/14  ปากทางลาดพร้าว แขวงจอมพล เขตจตุจักร กรุงเทพฯ  10900</div>
							<div class="address_2">โทรศัพท์: 02-938-4399   แฟกซ์ : 02-938-4399</div>
							<div class="address_2">อีเมล์ :info@thebestdeal1.com</div>
							<div class="address_2">เลขที่ประจำตัวผู้เสียภาษี : 0105555180399</div>
					</div> <!-- end class="company_box" -->
					<div class="acknow_box">
								<div class="acknow2">ใบสั่งซื้อ #<?=$order_data["order"]["order_id"]?></div>
								<div class="acknow_detail">เลขที่ใบสั่งซื้อ (REF. 1) : <?=$order_data["order"]["order_id"]?></div>
								<div class="acknow_detail">เลขที่ลูกค้า (REF. 2) : <?=$order_data["order"]["mem_id"]?></div>
								<div class="acknow_detail">วันที่สั่งซื้อ :  
								<?
										$th_date	=	$this->convert_date->show_thai_date(date("Y-m-d",strtotime($order_data["order"]["order_date"])));
										if(!empty($th_date))
											echo $th_date;
						 		?>
						 		<span>เวลา : </span> <?=date("H:i:s",strtotime($order_data["order"]["order_date"]));?> น.
								</div>
					</div><!-- end class="acknow_box" -->
			</div>
			<div class="pay_box">
					<div class="acknow_addr">ที่อยู่สำหรับเรียกเก็บเงิน</div>
			</div>
			<div class="acknow_cus"><?=$order_data["order"]["member_name"]." ".$order_data["order"]["member_sname"]?></div>
			<div class="acknow_cus2"><?=$order_data["order"]["member_address"]." ".$order_data["order"]["city_name"]?></div>
			<div class="acknow_cus2"><?=$order_data["order"]["province_name"]." ".$order_data["order"]["member_zipcode"]?></div>
					
			<div class="acknow_payment">วิธีการชำระเงิน</div>
			<div class="payment">
					<?=$payment?>
			</div>
			<div class="acknow_order">รายการที่สั่งซื้อ :</div>
			<div class="acknow_table">
					<div class="acknow_row_head">
							<div class="acknow_column_head1">ชื่อสินค้า</div>
							<div class="acknow_column_head2">ราคา</div>
							<div class="acknow_column_head2">จำนวน</div>
							<div class="acknow_column_head2">รวม</div>
					</div><!-- end  class="acknow_row_head"-->
					<? 	$total = 0;
							foreach($order_data["order_detail"] as $detail){?>
					<div class="acknow_row">
							<div class="acknow_column1"><b><?=$detail["product_name"]?></b> &nbsp;# <?=$detail["product_name"]?></div>
							<div class="acknow_column2">฿<?=number_format ($detail["product_total_price"], 2)?></div>
							<div class="acknow_column2"><?=$detail["product_qty"]?></div>
							<div class="acknow_column2">฿<?=number_format (($detail["product_total_price"] * $detail["product_qty"]), 2)?></div>
					</div><!-- end  class="acknow_row"-->
					<? $total = $total+($detail["product_total_price"] * $detail["product_qty"]); }?>
					<div class="acknow_row_head">
							<div class="acknow_column_total">รวมทั้งหมด</div>
							<div class="acknow_total">฿<?=number_format ($total, 2)?></div>
					</div>
			</div><!-- end class="acknow_table"-->
</div><!-- end id="receipt_print"-->
<div align="center" class="clear"><input type="button" value="พิมพ์หน้านี้" onclick="print_page()" style="cursor: pointer;"/></div>
<br/>
<script>
	function print_page()
	{
		//window.print();
		//$('#print_button').hide();
		$("#receipt_print").printElement(
            {
            overrideElementCSS:[
		'receipt.css',
		{ href:'/assets/css/receipt.css',media:'print'}]
            });
	}
</script>
</body>
</html>