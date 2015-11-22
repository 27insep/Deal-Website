<?if($show_login_box){?>
<div id="main_popup_box" >
<div id="login_popup">
	<div id="login_popup_header">กรุณาเข้าสู่ระบบก่อนค่ะ !</div>
	<div id="login_popup_main">
		<form id="popup_login_form" name="popup_login_form" action="/member/login" method="post">
		<div id="login_popup_box_left">
			<div class="popup_topic_text">อีเมล</div>
			<div><input type="text" name="login_name" id="login_name" value="" /></div>
			<div class="popup_topic_text">รหัสผ่าน</div>
			<div><input type="password" name="login_pwd" id="login_pwd" value=""/></div>
			<div class="popup_text"><input type="checkbox" name="remeberme" id="rememerme" value="1" /> จดจำฉันไว้?</div>
			<div><input type="image" name="submit" id="submit" src="/assets/images/login_popup_button.png"/></div>
		</div>
		</form>
		<div id="login_popup_box_right">
			<div>เข้าสู่ระบบผ่านเฟสบุ๊ค</div>
			<div><?=image_asset('fb_login_big_button.png', '', array('alt'=>'เข้าสู่ระบบผ่านเฟสบุ๊ค','onclick'=>'login();','class'=>'can_click'));?></div>
		</div>
	</div>
	<div id="login_popup_footer">
		<div id="footer_topic_text">
			<div><span>คุณยังไม่เป็นสมาชิก !</span></div>
			<div>รับข้อเสนอและอภิสิทธิ์เฉพาะสำหรับสมาชิก</div>
			<div>สามารถ <a href="/customer/signup">สมัครสมาชิก</a> ได้ทุกวัน ฟรีไม่มีค่าใช้จ่าย</div>
		</div>
		<div class="popup_footer_box"><a href="/customer/signup">ลงทะเบียน</a></div>
		<div class="popup_footer_box"><a href="/customer/signup/forget_password">ลืมรหัสผ่าน</a></div>
	</div>
</div> 
</div>
<script>
	 		function login_compleate(responseText, statusText, xhr, $form)
 		{
 			if(responseText==0)
 			{
 				alert("ชื่อผู้ใช้ หรือ รหัสผ่าไม่ถูกต้อง \nกรุณาตรวจสอบค่ะ !");
 			}else{
					$("#main_popup_box").remove();
					$("#shopping_popup").css("display","block");
					$("#top_bar").load("/member/load_top_menu");
 			} 
 		}
 		$('#popup_login_form').ajaxForm(
 			{ 	
 				success: login_compleate
 			} 
 		); 
</script>
<div id="shopping_popup" style="display: none;">
<? }else{?>
<div id="shopping_popup">
<? }?>
	<div id="shopping_popup_header"><?=$deal_name?></div>
	<div id="shopping_popup_main">
		<? 
		$inCart	=	array();
		foreach($cart as $item)
		{
			$inCart[$item["id"]]	=	$item["qty"];	
		}
		foreach($product_data as $product){
			$product_qty	=	0;
			$product_id	=	$product["product_id"];
			if(isset($inCart[$product_id]))
			{
				$product_qty	=	$inCart[$product_id];
			}
		?>
		<div class="shopping_popup_box">
			<div class="shopping_product_detail">
				<div id="product_<?=$product["product_id"]?>_name"><?=$product["product_name"]?></div>
				<div id="product_<?=$product["product_id"]?>_detail"><?=$product["product_detail"]?></div>
			</div>
			<div class="shopping_product_sniper">
				<? if($product["product_in_store"]>0){?>
				<input id="sniper_<?=$product["product_id"]?>" class="spinner" name="sniper_<?=$product["product_id"]?>" value="<?=$product_qty?>" />
				<?}?>
			</div>
			<div class="shopping_product_price">฿<span id="product_price_<?=$product["product_id"]?>"><?=number_format($product["product_total_price"])?></span></div>
			<div class="shopping_product_order">
				<? if($product["product_in_store"]>0){?>
					<span class="can_click" onclick="add2cart('<?=$product["product_id"]?>')"><?echo image_asset('add2cart.png', '', array('alt'=>'สั่งซื้อ'));?></span>
				<? }else{ ?>
					<span><?echo image_asset('sold_out.png', '', array('alt'=>'หมดแล้ว'));?></span>
				<? } ?>
			</div>
			<div class="shopping_cancel_order">
				<span onclick="remove2cart('<?=$product["product_id"]?>')"><?echo image_asset('payment/del.png', '', array('alt'=>'ยกเลิก'));?></span>
			</div>
		</div>
		<? } ?>
	</div>
	<div id="shopping_popup_footer">
		จำนวนสิ้นค้าในตระกล้า <span id="total_item"><?=$total_item?></span> ชิ้น
		<div id="payment_box" style="float: right;<? if(empty($total_item)){?>display: none;<? } ?>">
		<a onclick="close_overlay()" style="display: block; float: left;"><?echo image_asset('shop_deal_button.png', '', array('alt'=>'ช็อปดีลต่อ'));?></a>
		<a href="/shopping" style="margin: 0 0 0 10px;display: block; float: left;"><?echo image_asset('payment_button.png', '', array('alt'=>'ชำระเงิน'));?></a>
		</div>
	</div>
</div>
 <script>
 function close_overlay()
 {
 	parent.$.fancybox.close();
 }
  function add2cart(id)
  {
  		var qty		=	$( "#sniper_"+id ).spinner("value");
  		if(qty>0)
  		{
  		$.ajax({
  			type: "POST",
  			url: "/shopping/add_to_cart",
  			data: { product_id: id, product_qty: qty,product_price: $("#product_price_"+id).text()  }
			}).done(function( msg ) {
  				//$( "#dialog" ).html("เพิ่มสิ้นค้าลงในตระกล้าเรียบร้อยแล้วค่ะ");
 				//$( "#dialog" ).dialog({ title: "ข้อความ" });
 				$("#total_item").html(msg);
 				
 				alert("เพิ่มสิ้นค้าลงในตระกล้าเรียบร้อยแล้วค่ะ !");
 				$("#payment_box").show();
		});
		}else{
			alert("กรุณาระบุจำนวนสินค้าด้วยค่ะ !");
		}
  }
  function remove2cart(id)
  {
  		var qty		=	$( "#sniper_"+id ).spinner("value");
  		if(qty>0)
  		{
  		$.ajax({
  			type: "POST",
  			url: "/shopping/remove_from_cart/",
  			data: { product_id: id }
			}).done(function( msg ) {
  				//$( "#dialog" ).html("เพิ่มสิ้นค้าลงในตระกล้าเรียบร้อยแล้วค่ะ");
 				//$( "#dialog" ).dialog({ title: "ข้อความ" });
 				if(msg=="")
 				{
 					 msg = 0;
 				}
 			if(msg==0)
 			{
 				 $("#payment_box").css("display","none");
 			}
 				$("#total_item").html(msg);
 				alert("ยกเลิกการสั่งซื้อเรียบร้อยแล้วค่ะ !");
		});
		$( "#sniper_"+id ).spinner("value",0);
		}
  }
  $(function() {
    var spinner = $( ".spinner" ).spinner({ min: 0 });
    <? 
    foreach($product_data as $product){
    	if($product["product_limit"]==0||$product["product_limit"]>$product["product_in_store"]){	
    ?>
    	$( "#sniper_<?=$product["product_id"]?>" ).spinner({ max: <?=$product["product_in_store"]?> });
    <? }else{?>
    	$( "#sniper_<?=$product["product_id"]?>" ).spinner({ max: <?=$product["product_limit"]?> });
    <?
		}
	}
	?>
  });
</script>