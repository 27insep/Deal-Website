<script>
			function time_counter(id, h, m, s) {
				if(h+m+s<=0){
					$("#time_" + id).html("00:00:00");
				}else{
				setInterval(function() {
					s--;
					if(h+m+s<=0)
					{
						$("#deal_box_" + id).remove();
					}
					if (s < 0) {
						s = 59;
						m--;
					}
					if (m < 0) {
						m = 59;
						h--;
					}
					var show_time = "";

					if (h < 10)
					{
						show_time += "0" + h;
					}else{
						show_time += h;
					}
					show_time +=	":";
					if (m < 10)
					{
						show_time += "0" + m;
					}else{
						show_time += m;
					}
					show_time +=	":";
					if (s < 10)
					{
						show_time += "0" + s;
					}else{
						show_time += s;
					}
					$("#time_" + id).html(show_time);
					show_time	=	null;
				}, 1000);
				}
			}
			function run_buy_count(id,max)
			{
				var st	=	0;
				setInterval(function() {
					if(st<max)	st++;
					$("#buy_cout_" + id).html(st);
				}, 50);
			}
		</script>	
<div id="main_inner">
	<div id="show_deal_top_box">
		<div id="slide_deal_detail">	
			<?=image_asset($deal["deal_index_image"], '', array('alt'=>$deal["deal_name"]));?>
		</div>
		<div id="show_deal_info">
			<div class="deal_name"><?=$deal["deal_name"]?></div>
        				<div class="deal_intro">
        					<?=$deal["deal_intro"]?>
        				</div>
        				<? $view_link	=	"/category/deal/".$deal["deal_id"]."/".urlencode($deal["deal_name"]);?>
        				<div class="deal_share">
        					<div>Social Share :</div>
        					<div><fb:like href="http://www.thebestdeal1.com/<?=$view_link?>" send="false" layout="button_count" width="100" show_faces="false"></fb:like></div>
        					<div class="tweet_button">
        						<a href="https://twitter.com/share" class="twitter-share-button" data-url="http://www.thebestdeal1.com/<?=$view_link?>" data-size="100" data-text="<?=$deal["deal_name"]?> : ฿<?=number_format($deal["deal_price_show"])?>" data-lang="en">Tweet</a>
        					</div>
        					<!-- Place this tag where you want the +1 button to render. -->
							<!--<div class="g-plusone" data-size="medium" data-annotation="inline" data-width="200" href="http://www.thebestdeal1.com/<?=$view_link?>"></div>-->
        				</div>
        				<div class="deal_info">
        					<div class="deal_price">฿<?=number_format($deal["deal_price_show"])?></div>
        					<?if($deal["deal_special"] == "1"){?>
        							<? if($deal["deal_buy_time_end"] > date('Y-m-d H:s:i',time())){?>
		        							<?if($login){?>
		        								<a class="can_click" onclick="get_deal_special('<?=$deal["deal_id"]?>')"><div id="order_button" class="orange_button">สั่งซื้อ</div><!--<?echo image_asset("font_buy_button.png", '', array('alt'=>"สั่งซื้อ"));?>--></a>
		        							<?}else{?>
		        								<a class="fancybox fancybox.ajax" href="/shopping/login_for_specail_deal/<?=$deal["deal_id"]?>"><div id="order_button" class="orange_button">สั่งซื้อ</div></a>
		        							<? } ?>
		        					<?}else{?>
		        							<a class="fancybox fancybox.ajax" href="/shopping/popup_iwantit/<?=$deal["deal_id"]?>/<?=base64_encode($deal["deal_name"])?>"><div id="order_button" class="purple_button">อยากซื้อดีลนี้อีก</div></a>
		        					<?}?>
        						<?}else{?>
        							<? if($deal["deal_buy_time_end"] > date('Y-m-d H:s:i',time())){?>
        									<a class="fancybox fancybox.ajax" href="/shopping/popup_order/<?=$deal["deal_id"]?>/<?=base64_encode($deal["deal_name"])?>"><div id="order_button" class="orange_button">สั่งซื้อ</div></a>
        							<?}else{?>
        									<a class="fancybox fancybox.ajax" href="/shopping/popup_iwantit/<?=$deal["deal_id"]?>/<?=base64_encode($deal["deal_name"])?>"><div id="order_button" class="purple_button">อยากซื้อดีลนี้อีก</div></a>
        						<?}}?>
        				</div>
        				<div class="deal_count_box">
        						<div class="deal_off">
        							<div class="small_text_1">ลด</div>
        							<div class="big_text_1"><?=$deal["deal_percent_off"]?>%</div>
        						</div>
        						<div class="deal_buy">
        							<div class="small_text_1">ซื้อแล้ว</div>
        							<div class="big_text_1"><?=$deal["deal_buy_count"]?></div>
        						</div>
        						<div class="deal_time">
        							<div class="small_text_1">เวลาที่เหลือ</div>
        								<?
        									$time_diff	=	(strtotime($deal["deal_buy_time_end"])+(60*60*24))-time();
											
											
        									$has_day	=	(int)($time_diff/(60*60*24));
								
        									if($has_day>1)
        									{
        										echo '<div class="big_text_1">'.$has_day." วัน".'</div>';
        									}else{
        										echo '<div id="time_'.$deal["deal_id"].'"></div>';
												$has_sec	=	$time_diff%60;
												$has_min	=	$time_diff/60%60;
												$has_hour =	$time_diff/60/60%24;
												
												if($has_sec<0)	$has_sec	=	0;
												if($has_min<0)	$has_min	=	0;
												if($has_hour<0)	$has_hour	=	0;
												?>
												<script type="text/javascript">
													time_counter('<?=$deal["deal_id"]?>',<?=$has_hour?>,<?=$has_min?>,<?=$has_sec?>);
												</script>
												<?
											}
        								?>
        					</div>
        			</div>
		</div>
	</div>
	<div id="show_deal_main_box">
			<div id="show_deal_sub_menu">
				<div class="sub_menu m1 current" onmouseover="show_content(1)"><div>ไฮไลท์</div></div>
				<div class="sub_menu m2" onmouseover="show_content(2)"><div>เกี่ยวกับเรา</div></div>
				<div class="sub_menu m3" onmouseover="show_content(3)"><div>รายละเอียด</div></div>
				<div class="sub_menu m4" onmouseover="show_content(4)"><div>แกลเลอรี่</div></div>
				<div class="sub_menu m5" onmouseover="show_content(5)"><div>ติดต่อเรา</div></div>
			</div>
			<div id="show_highlight" class="show_deal_content"><?=$deal["deal_hilight_detail"]?></div>
			<div id="show_about_us" class="show_deal_content hide"><?=$deal["deal_aboutus_detail"]?></div>
			<div id="show_deal_detail" class="show_deal_content hide"><?=$deal["deal_main_detail"]?><?=$deal["deal_main_condition"]?></div>
			<div id="show_gallery" class="show_deal_content hide">
				<?
					if(isset($deal_gallery)){
						foreach($deal_gallery as $item)
						{
					?>
						<div style="float: left; margin: 5px;"><a class="fancybox" rel="group1" href="/assets/images/<?=$item["pic_path"]?>"><img src="/assets/images/<?=$item["pic_path"]?>" width="200px" height="120px" /></a></div>
					<?}}?>
			</div>
			<style>
				#contact_us_left
				{
					float: left;
					margin:20px;
					width:500px
				}
				#contact_us_right
				{
					width: 300px;
					height: 220px;
					margin:20px;
					float: right;
				}
			</style>
			<div id="show_contact_us" class="show_deal_content hide">
				<div id="contact_us_left">
					<? if(!empty($deal["deal_address"])){?>
					<div class="uline"><b>สถานที่ตั้ง</b></div>
					<div><?=$deal["deal_address"]?></div>
					<br/>
					<? } ?>
					<? if(!empty($deal["deal_email"])){?>
					<div class="uline"><b>อีเมล</b></div>
					<div><a href="mailto:<?=$deal["deal_email"]?>"><?=$deal["deal_email"]?></a></div>
					<br/>
					<? }?>
					<? if(!empty($deal["deal_website"])){?>
					<div class="uline"><b>เว็บไซด์</b></div>
					<div><a href="http://www.<?=$deal["deal_website"]?>">www.<?=$deal["deal_website"]?></a></div>
					<? } ?>
				</div>
				<div id="contact_us_right"><a class="fancybox" href="/assets/images/<?=$deal["deal_map"]?>"><img width="300" height="220" src="/assets/images/<?=$deal["deal_map"]?>"/></a></div>
			</div>
	</div>
	<? if(sizeof($relate_deal)>0){?>
	<div id="show_deal_relate_box">
		<div id="show_deal_relate_box_header">
		ดีลราคาถูก ที่เปิดดูล่าสุด
		</div>
		<div id="show_deal_relate_box_main">
			<? 
			foreach($relate_deal as $deal){
				$link	=	"/category/deal/".$deal["deal_id"]."/".urlencode($deal["deal_name"]);
			?>
			<div class="deal_relate_box">
				<div class="deal_relate_box_name"><a alt="<?=$deal["deal_name"]?>" title="<?=$deal["deal_name"]?>" href="<?=$link?>" class="deal_relate_box_infoR" style="color: #FFFFFF"><?=$deal["deal_name"]?></a></div>
				<div class="deal_relate_box_img">
					<a alt="<?=$deal["deal_name"]?> ราคาพิเศษ <?=number_format($deal["deal_price_show"])?> บาท" title="<?=$deal["deal_name"]?> ราคาพิเศษ <?=number_format($deal["deal_price_show"])?> บาท" href="<?=$link?>" class="deal_relate_box_infoR">
						<?echo image_asset($deal["deal_index_image"], '', array('alt'=>$deal["deal_name"]." ราคาพิเศษ ".number_format($deal["deal_price_show"])." บาท",'title'=>$deal["deal_name"]." ราคาพิเศษ ".number_format($deal["deal_price_show"])." บาท"));?>
					</a>
				</div>
				<div class="deal_relate_box_intro"><?=$deal["deal_intro"]?></div>
				<div class="deal_relate_box_info">
					<div class="deal_relate_box_infoL">฿<?=number_format($deal["deal_price_show"])?></div>
					<a href="<?=$link?>" class="deal_relate_box_infoR">ดูรายละเอียด</a>
				</div>
			</div>
			<? } ?>
		</div>
	</div>
	<? }?>
</div>
<script type="text/javascript">
	function show_content(num)
	{
		$(".show_deal_content").addClass("hide");
		$(".sub_menu").removeClass("current");
		if(num==1)
		{
			$(".m1").addClass("current");
			$("#show_highlight").removeClass("hide");
		}
		if(num==2)
		{
			$(".m2").addClass("current");
			$("#show_about_us").removeClass("hide");
		}
		if(num==3)
		{
			$(".m3").addClass("current");
			$("#show_deal_detail").removeClass("hide");
		}
		if(num==4)
		{
			$(".m4").addClass("current");
			$("#show_gallery").removeClass("hide");
		}
		if(num==5)
		{
			$(".m5").addClass("current");
			$("#show_contact_us").removeClass("hide");	
		}
	}
</script>
<!-- Place this tag after the last +1 button tag. -->
<script type="text/javascript">
  (function() {
    var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
    po.src = 'https://apis.google.com/js/plusone.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
  })();
</script>
<!-- Twitter -->
<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="https://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
<script>
	$('.fancybox').fancybox();
</script>

<script>
	function get_deal_special(deal_id)
	{
		/*	$(document).ready(function() {  
				$( "#dialog" ).html("กรุณาเข้าสู่ระบบ ก่อนทำการซื้อดีลค่ะ");
 					$( "#dialog" ).dialog({ 
 						title: "แจ้งเตือน",
 						buttons: [ { text: "ตกลง", click: function() { $( this ).dialog( "close" ); } } ] 
 					});
 		});*/
			$.ajax({
				 type: "POST",
  				 url: "/shopping/generate_coupon/"+deal_id
			}).done(function( msg ) {
				if(msg=="กรุณาระบุข้อมูลของท่านให้ครบถ้วน <br><br> ก่อนทำการสั่งซื้อค่ะ"){
					$( "#dialog" ).html(msg);
 					$( "#dialog" ).dialog({ 
 						title: "ข้อความ",
 						close: function( event, ui ) {window.location.href = 'http://www.thebestdeal1.com/member/special/'+deal_id},
 						buttons: [ { text: "ตกลง", click: function() { $( this ).dialog( "close" ); } } ] 
 					});
 				}else{
 					$( "#dialog" ).html(msg);
 					$( "#dialog" ).dialog({ 
 						title: "ข้อความ",
 						buttons: [ { text: "ตกลง", click: function() { $( this ).dialog( "close" ); } } ] 
 					});
 				}	
			});
	}
</script>
		<noscript>
			<link rel="stylesheet" type="text/css" href="/assets/css/noscript.css" />
		</noscript>
<script>
	$('.fancybox').fancybox({'ajax':{cache	: false}});
</script>