<div id="main_inner">
	<div id="member_header">คูปองของฉัน</div>
	<form  name="coupon_form" action="/member/my_coupon" method="post" enctype="multipart/form-data">
	<div class="member_filter">
		<select name="coupon_status"  onchange="this.form.submit();">
		<option value="0" <? if($coupon_status == "0" || $coupon_status == "") echo 'selected'?>>ทั้งหมด</option>
		<option value="1" <? if($coupon_status == "1") echo 'selected'?>>ถูกต้อง</option>
		<option value="2" <? if($coupon_status == "2") echo 'selected'?>>กำลังหมดอายุ</option>	
		<option value="3" <? if($coupon_status == "3") echo 'selected'?>>หมดอายุ</option>	
	</select>
	</div>
	</form>
	<div id="member_main_box">
		<div id="member_main_box_left">
			<? if($have_coupon){?>
			<? foreach($coupon_data["order"] as $order){ ?>
					<div class="coupon_relate_box">
						<div class="coupon_relate_box_name"><?=$order["deal_name"]?></div>
						<div class="coupon_relate_box_date"><span class="colBlue">วันที่สั่งซื้อ</span> &nbsp;<span class="colOran"><?=date_format(date_create($order["order_date"]),"d-m-Y");?> </span>&nbsp;&nbsp;<span class="colBlue">วันที่หมดอายุ</span> &nbsp;<span class="colOran"><?=date_format(date_create($order["deal_expile"]),"d-m-Y")?></span></div>
						<div class="coupon_detail"><?=image_asset($order["deal_index_image"], '', array('alt'=>$order["deal_name"]));?></div>
						<div class="coupon_head1">หมายเลขคำสั่งซื้อ</div>
						<div class="coupon_head">คูปอง # </div>
						<div class="coupon_head">ได้รับ คูปอง</div>
						<div class="coupon_head">สถานะ</div>
						<div class="coupon_head"><!--ของขวัญ --></div>
						<? 
							$i=0;
							foreach($coupon_data["coupon"] as $coupon){
							  if($order["order_id"] == $coupon["order_id"] && $order["deal_id"] == $coupon["deal_id"]) {
							  	if($i == 0) { ?>
							  		<div class="coupon_row">
											<div  class="coupon_column1"><a href="/member/my_orderDetail/<?=$coupon["order_id"]?>"><?=$coupon["order_id"]?></a></div>
											<div  class="coupon_column"><?=$coupon["coupon_id"]?></div>
											<div  class="coupon_column"><a href="/member/print_coupon/<?=$coupon["deal_id"] ?>/<?=$coupon["coupon_id"] ?>"  target="_bllank">พิมพ์</a></div>
											<div  class="coupon_column"><a href="/member/my_coupon/<?=$page?>/<?=$coupon["coupon_id"]?>/<? if($coupon["coupon_status"] == 1 ) echo 2; else echo 1; ?>">
											<? if ($coupon["coupon_status"]=='1') echo "ยังไม่ได้ใช้"; else echo "ใช้แล้ว";?></a></div>
											<div  class="coupon_column"><!--ส่ง--></div>
									</div>
						<? }else{?>
								<div class="coupon_row">
										<div  class="coupon_column1"></div>
										<div  class="coupon_column"><?=$coupon["coupon_id"]?></div>
										<div  class="coupon_column"><a href="/member/print_coupon/<?=$coupon["deal_id"] ?>/<?=$coupon["coupon_id"] ?>"  target="_bllank">พิมพ์</a></div>
										<div  class="coupon_column"><a href="/member/my_coupon/<?=$page?>/<?=$coupon["coupon_id"]?>/<? if($coupon["coupon_status"] == 1 ) echo 2; else echo 1; ?>">
										<? if ($coupon["coupon_status"]=='1') echo "ยังไม่ได้ใช้"; else echo "ใช้แล้ว";?></a></div>
										<div  class="coupon_column"><!--ส่ง--></div>
								</div>
						<?}$i++; }}?>
						<!--
						<div class="commentText">โพสต์ความคิดเห็นและอัตราการให้ของคุณ</div>
						-->
					</div>
			<?} ?>
			<div id="page_navigator"><?=$page_navigator?></div>
			<? }else{?>
			<div id="no_data">ยังไม่มีข้อมูลคูปองของคุณค่ะ !</div>
			<? }?>
			</div>
		<div id="member_main_box_right">
			<?=$right_sec?>
		</div>
</div>
</div>