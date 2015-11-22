<link rel="stylesheet" type="text/css" href="/assets/css/receipt_admin.css" />
<div id="main_inner">
	<div id="member_main_box">
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
					    $thai_date_return.= " &nbsp;".(date("Y",$time)+543);  
					    return $thai_date_return;  
				}  
			?>
			<div class="od_head_admin">ใบสั่งซื้อ #<?=$order_data["order"]["order_id"]?></div>
			<div class="Receipt"></div>
			 <hr class="hr_admin">
			 <div id="detail_box_main">
			 	<div id="detail_box_left">
			 	<div class="detail_date_admin" style="margin-top: 0;">
			 		<div><span>บริษัท เดอะ เบสท์ ดีล จำกัด</span></div>
					<div>เลขที่  12/14  ปากทางลาดพร้าว แขวงจอมพล เขตจตุจักร กรุงเทพฯ  10900</div>
					<div><span>โทรศัพท์ :</span> 02-938-4399   <span>แฟกซ์ :</span> 02-938-4399</div>
					<div><span>อีเมล์ :</span> info@thebestdeal1.com</div>
					<div><span>เลขที่ประจำตัวผู้เสียภาษี :</span> 0105555180399</div>
			 	</div>
			 	<!--
			 	<div class="detail_date" style="margin-top: 0;">วันที่สั่งซื้อ: 
			 	<?
			 		$eng_date=strtotime(date_format(date_create($order_data["order"]["order_date"]),"Y-m-d"));   
					echo thai_date($eng_date);  
			 	?></div>
			 	-->
			 	<div class="order_member_admin">
			 		<div class="member_txt_admin">ที่อยู่สำหรับเรียกเก็บเงิน : </div>
			 		<div class="member_detail">
			 			<?=$order_data["member"]["member_name"]?>   <?=$order_data["member"]["member_sname"]?><br><?=$order_data["member"]["member_address"]?><br>
			 			<?=$order_data["member"]["city_name"]?> ,  <?=$order_data["member"]["province_name"]?> , <?=$order_data["member"]["member_zipcode"]?>
			 		</div>
			 	</div>
			 	</div>
			  	<div id="detail_box_right_admin">
					<div><span>เลขที่ใบสั่งซื้อ (REF. 1) : </span><?=$order_data["order"]["order_id"]?></div>
					<div><span>เลขที่ลูกค้า (REF. 2) : </span><?=$order_data["order"]["mem_id"]?></div>
					<div><span>วันที่สั่งซื้อ : </span>
						<? 	
							$eng_date=strtotime(date_format(date_create($order_data["order"]["order_date"]),"Y-m-d H:i:s"));   
							echo thai_date($eng_date); 
						?>
						<span>เวลา : </span> <?=date("H:i:s",$eng_date);?> น.
					</div>
			 </div>
			 </div>
			  	<div class="order_addr_admin">
			  	<div class="member_txt">วิธีการชำระเงิน : </div>
			  	<div class="div_payment">
			  		<?=$payment?>
			  	</div>
			 </div>
			 <div class="order_detail_head_admin">รายการที่สั่งซื้อ</div>
			 <hr class="hr_admin">
			 <table class="odTable_admin">
				 	<tr class="odRow_admin">
						 	<td  class="odColumn_admin1">ชื่อสินค้า</td>
						 	<td class="odColumn2">ราคา</td>
						 	<td class="odColumn2">จำนวน</td>
						 	<td class="odColumn3">ราคารวม</td>
				 	</tr>
				 	<? 
				 		$total = 0;
				 		foreach($order_data["order_detail"] as $orderdetail){ ?>
				 	<tr class="odRowData">
						 	<td class="odColumn4"><b><?=$orderdetail["deal_name"]?></b> &nbsp;# <?=$orderdetail["product_name"]?></td>
						 	<td class="odColumn5">฿<?=number_format (($orderdetail["product_total_price"]), 2)?></td>
						 	<td class="odColumn5"><?=$orderdetail["product_qty"];?></td>
						 	<td class="odColumn6">฿<?=number_format (($orderdetail["product_total_price"] * $orderdetail["product_qty"]), 2)?></td>
						 	<? $total = $total + ($orderdetail["product_total_price"] * $orderdetail["product_qty"])?>
				 	</tr>
				 	<?}?>
				 	<tr class="odRowfinal">
				 			<td class="odColumn7" colspan="3">รวมทั้งหมด</td>
						 	<td class="odColumn6">฿<?=number_format ($total,2)?></td>
				 	</tr>
				 	</table>
				 	<div align="center" style="height: 35px;line-height: 35px;vertical-align: middle;">
				 		<a class="fancybox fancybox.ajax" href="/member/my_docorder/<?=$order_data["order"]["order_id"]?>">พิมพ์ใบสั่งซื้อ</a>
						<?if($order_data["order"]["order_status"]==2){?>
						&nbsp;|&nbsp;<a class="fancybox fancybox.ajax" href="/member/my_receipt/<?=$order_data["order"]["order_id"]?>">พิมพ์ใบเสร็จรับเงิน</a>
						<? } ?>
						<br/>
					</div>
				 	 <hr class="hr_admin">
				 	<div class="textback_admin"><a href="../../../member/my_order">« กลับไปยังคำสั่งซื้อของฉัน</a></div>
	</div>
</div>
<script>
$('.fancybox').fancybox();
</script>