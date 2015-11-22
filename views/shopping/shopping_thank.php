<style type="text/css" media="screen">
  #custom-tweet-button a {
    display: block;
    background: url('/assets/images/twitter_invite.jpg');
    height: 33px;
    width: 193px;
    float: left;
  }
  
  #box_deal
  {
  		border-top:1px dashed #777777;
		border-bottom:1px dashed #777777;
		padding: 10px 0;
		font-size: 1em;
		color: #FF481B; 	
		margin:0 0 20px 0;
		text-align: right;
  }
</style>
<div id="main_inner">
    <div id="member_header">ขอบคุณสำหรับคำสั่งซื้อของท่าน</div>
    <div id="thank_box">
	<div id="thank_box_topic">เราได้รับคำสั่งซื้อของคุณเล้ว</div>
	<div>เราได้รับคำสั่งซื้อของคุณแล้ว ขอขอบคุณสำหรับคำสั่งซื้อของท่าน และเราได้ยืนยันคำสั่งซื้อนี้ไปยังอีเมลของท่านแล้ว</div>
	<div><b>หมายเลขคำสั่งซื้อของท่าน :</b> <a href="/member/my_order/1/1"><span id="show_order_id"><?=$order_id?></span></a></div>
	<br/>
	<div>หากท่านชำระเงินเรียบร้อยแล้ว จะได้รับอีเมลยืนยันการออกคูปอง และพิมพ์คูปองที่ <span class="text_red">"คูปองของฉัน"</span></div>
	</div>
	<div align="center"><?echo image_asset('paywithin.jpg');?></div>
	<div id="recomment_box">
		<div><b>ดีลโดนๆ ยังมีให้เลือกอีกเยอะ เลือกช๊อปได้เลยตามใจคุณ</b></div>
		<div><span>ห้ามพลาด! ยังมีดีลสุดคุ้มอีกมากมาย Come experience more of our heart-shoping deals by yourself</span></div>
		<div id="recomment_deal">
			<? foreach($recomment_deal as $deal){?>
			<a href="/category/deal/<?=$deal["deal_id"]?>/<?=urlencode($deal["deal_name"])?>" target="_blank">
			<div class="recomment_deal_box">
				<div><?echo image_asset($deal["deal_index_image"], '', array('alt'=>"ดูรายละเอียด"));?></div>
				<div class="recomment_deal_detail"><div><?=$deal["deal_intro"]?></div></div>
			</div>
			</a>
			<? } ?>
		</div>
	</div>
			<div id="my_invite_main">
			<h2>เชื่อมต่อและแบ่งบันกับเพื่อนๆ ผ่านทาง Facebook หรือ Twitter ของคุณ</h2>
			<br/>
			<div id="invite_button">
				<div>
				<? $fb_link	=	"https://www.facebook.com/dialog/feed?app_id=458358780877780&"
 		 								."link=http://www.thebestdeal1.com/customer/signup/".$member_id."&"
  										."picture=http://www.thebestdeal1.com/assets/images/company_logo.png&"
  										."name=Thebestdeal1.com&"
  										."display=popup&"
  										."caption=แนะนำสมาชิก&"
  										."description=เว็บดีลอันดับหนึ่งในใจหลายๆคน%20thebestdeal1.com&"
  										."redirect_uri=https://mighty-lowlands-6381.herokuapp.com";
  				?>
				<a href="#" onclick="popitup('<?=$fb_link?>')">
					<?echo image_asset('facebook_invite.jpg', '', array('alt'=>'ส่งคำเชิญทาง Facebook ของคุณ'));?>
				</a>
				</div>
				<div id="custom-tweet-button">
					<a href="https://twitter.com/share?url=http%3A%2F%2Fwww.thebestdeal1.com%2Fcustomer%2Fsignup%2Fpages%2F<?=$member_id?>" target="_blank"></a>
				</div>
			</div>
		</div>
		<div id="box_deal">
			<a href="/category/"><?echo image_asset('shop_deal_button.png', '', array('alt'=>'ช็อปดีลต่อ'));?></a>&nbsp;
			<a href="/member/my_order"><?echo image_asset('order_button.png', '', array('alt'=>'คำสั่งซื้อของฉัน'));?></a>
		</div>
<a style="display:none" id="show_payment_bank_form" class="fancybox fancybox.ajax" href="/shopping/payment_form/1/<?=$order_id?>">-</a>
<a style="display:none" id="show_payment_couter_service_form" class="fancybox fancybox.ajax" href="/shopping/payment_form/2/<?=$order_id?>">-</a>
<a style="display:none" id="show_payment_lotus_form" class="fancybox fancybox.ajax" href="/shopping/payment_form/3/<?=$order_id?>">-</a>
</div>
<script>
	$('.fancybox').fancybox();
	<?
	switch($payment_type)
	{
		case 1:
		case 2:
		case 3:
		case 4:
			echo  '$("#show_payment_bank_form").trigger("click");';
		break;
		/*
		case 5:
			echo  '$("#show_payment_couter_service_form").trigger("click");';
		break;
		case 6:
			echo  '$("#show_payment_lotus_form").trigger("click");';
		break; 
		*/
	}
	?>
</script>
<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
<script language="javascript" type="text/javascript">
function popitup(url) {
	newwindow=window.open(url,'name','height=300,width=420');
	if (window.focus) {newwindow.focus()}
	return false;
}
</script>