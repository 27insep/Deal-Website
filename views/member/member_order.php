<div id="main_inner">
	<div id="member_header">คำสั่งซื้อของฉัน</div>
	<form  name="oder_status_form" action="/member/my_order" method="post" enctype="multipart/form-data">
	 <div id="fill_status">
			 <select name="search_status" onchange="this.form.submit();">
			 	<option value="" <? if($fill_staus == "") echo 'selected'?>>ทั้งหมด</option>
			 	<option value="1" <? if($fill_staus == "1") echo 'selected'?>>รอการชำระเงิน</option>
			 	<option value="2" <? if($fill_staus == "2") echo 'selected'?>>ชำระเงินแล้ว</option>
			 	<option value="3" <? if($fill_staus == "3") echo 'selected'?>>คืนเงิน</option>
			 	<option value="0" <? if($fill_staus == "0") echo 'selected'?>>ยกเลิกแล้ว</option>
			 </select>
		 </div>
		</form>
	<div id="member_main_box">
	<? if($have_order){ ?>
	<div class="order_relate_box">
		 <div class="divTable">
		<div class="order_box">
				<div class="order_head1">หมายเลขคำสั่งซื้อ</div>
				<div class="order_head2">แคมเปญ</div>
				<div class="order_head3">วันที่สั่งซื้อ</div>
				<div class="order_head4">รวม</div>
				<div class="order_head5">สถานะ</div>
		</div>
		<? 
			$i=1;
			$order_old = "";
			foreach($member_data as $key => $order){
				$last_key = end(array_keys($member_data));
				if($key != $last_key)
					$order_next = $member_data[$key+1]["order_id"];
				else
					$order_next = "";
				
				if($order_old != $order["order_id"]) $i++;
				if($i%2 == 0) { ?>
					<div class="divRow1">
						<div class="order_detail1"><? if(($order_old != $order["order_id"])) echo $order["order_id"];?></div>
						<div class="order_detail2"><b><?=$order["deal_name"]?></b> &nbsp;# <?=$order["product_name"]?></div>
						<div class="order_detail3"><? if(($order_old != $order["order_id"])) echo date_format(date_create($order["order_date"]),"d/m/Y");?></div>
						<div class="order_detail4"><? if(($order_old != $order["order_id"])) echo number_format ($order["order_summary"],2);?></div>
						<div class="order_detail5">
							<? 
									if(($order_old != $order["order_id"]))
									{
										 if ($order["order_status"]=='1') echo 'รอการชำระเงิน<br/><br/>'.
										 '<a class="fancybox fancybox.ajax" href="/shopping/payment_form/1/'.$order["order_id"].'">'.image_asset("payment/icon_bank.png").'</a>';
										 //'<a class="fancybox fancybox.ajax" href="/shopping/payment_form/3/'.$order["order_id"].'">'.image_asset("payment/icon_lotus.png").'</a>';
										 //'<a class="fancybox fancybox.ajax" href="/shopping/paysabuy/'.$order["order_id"].'">'.image_asset("payment/icon_cs.png").'</a>';
										 //'<a class="fancybox fancybox.ajax" href="/shopping/payment_form/4/'.$order["order_id"].'">'.image_asset("payment/icon_online.png").'</a>'; 
										 if ($order["order_status"]=='2')	echo "ชำระเงินแล้ว";
										 if ($order["order_status"]=='0')	echo "ยกเลิก";
									}
							?>
						</div>
						<div class="order_detail6"><? if(($order_old != $order["order_id"])){?><a href="/member/my_orderDetail/<?=$order["order_id"]?>">รายละเอียด</a><? }?></div>
							<? if ($order["order_status"]=='1' && $order["order_id"] != $order_next){?>
						<div  class="meg_payment">ขอขอบคุณสำหรับการสั่งซื้อ กรุณาชำระเงินภายใน 24 ชั่วโมงหลังทำการสั่งซื้อ หากไม่ชำระเงินภายใน</div>
						<div  class="meg_payment1">เวลาที่กำหนด ระบบจะทำการยกเลิกคำสั่งซื้อของท่านโดยอัตโนมัติ ยกเลิกคำสั่งซื้อของคุณกรณากด 
						<a href="/member/my_orderstatus/<?=$order["order_id"]?>/0">ที่นี่</a></div><? }?>
					</div>
				<? }else{?>
					<div class="divRow2">
						<div class="order_detail1"><? if(($order_old != $order["order_id"])) echo $order["order_id"];?></div>
						<div class="order_detail2"><b><?=$order["deal_name"]?></b> &nbsp;# <?=$order["product_name"]?></div>
						<div class="order_detail3"><? if(($order_old != $order["order_id"])) echo date_format(date_create($order["order_date"]),"d/m/Y");?></div>
						<div class="order_detail4"><? if(($order_old != $order["order_id"])) echo number_format ($order["order_summary"],2);?></div>
						<div class="order_detail5">
							<? 
									if(($order_old != $order["order_id"]))
									{
										 if ($order["order_status"]=='1') echo 'รอการชำระเงิน<br/><br/>'.
										 '<a class="fancybox fancybox.ajax" href="/shopping/payment_form/1/'.$order["order_id"].'">'.image_asset("payment/icon_bank.png").'</a>';
										 //'<a class="fancybox fancybox.ajax" href="/shopping/payment_form/3/'.$order["order_id"].'">'.image_asset("payment/icon_lotus.png").'</a>';
										 //'<a class="fancybox fancybox.ajax" href="/shopping/paysabuy/'.$order["order_id"].'">'.image_asset("payment/icon_cs.png").'</a>';
										 //'<a class="fancybox fancybox.ajax" href="/shopping/payment_form/4/'.$order["order_id"].'">'.image_asset("payment/icon_online.png").'</a>'; 
										 if ($order["order_status"]=='2')	echo "ชำระเงินแล้ว";
										 if ($order["order_status"]=='0')	echo "ยกเลิก";
									}
							?>
						</div>
						<div class="order_detail6"><? if(($order_old != $order["order_id"])){?><a href="/member/my_orderDetail/<?=$order["order_id"]?>">รายละเอียด</a><? }?></div>
						<? if ($order["order_status"]=='1' && $order["order_id"] != $order_next){?>
						<div  class="meg_payment">ขอขอบคุณสำหรับการสั่งซื้อ กรุณาชำระเงินภายใน 24 ชั่วโมงหลังทำการสั่งซื้อ หากไม่ชำระเงินภายใน</div>
						<div  class="meg_payment1">เวลาที่กำหนด ระบบจะทำการยกเลิกคำสั่งซื้อของท่านโดยอัตโนมัติ ยกเลิกคำสั่งซื้อของคุณกรณากด 
						<a href="/member/my_orderstatus/<?=$order["order_id"]?>/0">ที่นี่</a></div><? }?>
					</div>
				<?}
								$order_old =$order["order_id"]; 
				}
				?>
	</div>
	<div id="page_navigator"><?=$page_navigator?></div>
	</div>
	<?
	}else{
	?>
	<h4 style="width: 300px; float: left;">คุณยังไม่ได้ทำการสั่งซื้อใดๆค่ะ !</h4>
	<?
				}
	?>

	<div id="member_main_box_right">
			<?=$right_sec?>
	</div>
	</div>
</div>
<script>
	$('.fancybox').fancybox();
</script>