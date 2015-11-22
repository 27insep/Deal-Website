<script type="text/javascript" src="/assets/js/jquery.printElement.min.js"></script>
<div id="main_inner">
	<div id="member_header">รายละเอียดคำสั่งซื้อของฉัน</div>
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
			<div id="print_zone">
			<div id="order_logo"><?=image_asset('../../assets/images/company_logo.png');?></div>
			<div class="od_head">ใบสั่งซื้อ</div>
			<div class="Receipt"></div>
			 <hr class="hr1">
			 <div id="detail_box_main">
			 	<div id="detail_box_left">
			 	<div class="detail_date" style="margin-top: 0;">
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
			 	<div class="order_member">
			 		<div class="member_txt">ที่อยู่สำหรับเรียกเก็บเงิน : </div>
			 		<div class="member_detail">
			 			<?=$order_data["member"]["member_name"]?>   <?=$order_data["member"]["member_sname"]?><br><?=$order_data["member"]["member_address"]?><br>
			 			<?=$order_data["member"]["city_name"]?> ,  <?=$order_data["member"]["province_name"]?> , <?=$order_data["member"]["member_zipcode"]?>
			 		</div>
			 	</div>
			 	</div>
			  	<div id="detail_box_right">
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
			  	<div class="order_addr">
			  	<div class="member_txt">วิธีการชำระเงิน : </div>
			  	<div class="div_payment">
			  		<?=$payment?>
			  	</div>
			 </div>
			 <div class="order_detail_head">รายการที่สั่งซื้อ</div>
			 <hr class="hr1">
			 <table class="odTable">
				 	<tr class="odRow">
						 	<td  class="odColumn1">ชื่อสินค้า</td>
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
				 	</div>
				 	<div align="center" style="height: 35px;line-height: 35px;vertical-align: middle;">
				 		<!--<a class="fancybox fancybox.ajax" href="/member/my_docorder/<?=$order_data["order"]["order_id"]?>">พิมพ์ใบสั่งซื้อ</a>-->
				 		<span class="can_click" onclick="print_order_page()"><?=image_asset('payment/bt_print1.png');?></span>
						<?if($order_data["order"]["order_status"]==2){?>
						<a class="fancybox fancybox.ajax" href="/member/my_receipt/<?=$order_data["order"]["order_id"]?>"><?=image_asset('payment/bt_print2.png');?></a>
						<? } ?>
						<br/>
					</div>
				 	 <hr class="hr1">
				 	<div class="textback"><a href="../../../member/my_order">« กลับไปยังคำสั่งซื้อของฉัน</a></div>
	</div>
</div>
<script>
$('.fancybox').fancybox();
</script>
<script>
	function print_order_page()
	{
		//window.print();
		//$('#print_button').hide();
		$("#print_zone").printElement(
            {
            overrideElementCSS:[
		'member.css',
		{ href:'/assets/css/member.css',media:'print'}]
            });
	}
</script>