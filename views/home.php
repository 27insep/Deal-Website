		<noscript>
			<link rel="stylesheet" type="text/css" href="/assets/css/noscript.css" />
		</noscript>
		<script>
			function time_counter(id, h, m, s) {
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
			function run_buy_count(id,max)
			{
				var st	=	0;
				if(max>10)	
					st	=	max-10;
				setInterval(function() {
					if(st<max)	st++;
					$("#buy_cout_" + id).html(st);
				}, 50);
			}
		</script>	
	<?=css_asset('slide/demo.css');?>
	<?=css_asset('slide/style.css');?> 
<div class="header">
	<div class="wrapper">
                <div id="ei-slider" class="ei-slider">
                    <ul class="ei-slider-large">
                   	<? foreach($slide as $image){?>
                        <li>
                            <?if(!empty($image["link"])){?>
                            <a target="_blank" href="<?=$image["link"]?>">
                            <? } ?>
                            	<?echo image_asset($image["large"], '', array('alt'=>$image["title"]));?>
                            <?if(!empty($image["link"])){?>
                            </a>
                            <? } ?>
                            <div class="ei-title">
                                <h2><?=$image["title"]?></h2>
                                <h2><?=$image["name"]?></h2>
                            </div>
                        </li>
                        <? } ?>
                    </ul><!-- ei-slider-large -->
                    <ul class="ei-slider-thumbs">
                        <li class="ei-slider-element">Current</li>
                        <? foreach($slide as $image){?>
                        <li><a href="#"><?=$image["name"]?></a><?echo image_asset($image["thumbs"], '', array('alt'=>$image["title"]));?></li>
                        <? } ?>
                    </ul><!-- ei-slider-thumbs -->
                </div><!-- ei-slider -->
            </div><!-- wrapper -->
        </div>
        <script type="text/javascript">
            $(function() {
                $('#ei-slider').eislideshow({
					easing		: 'easeOutExpo',
					titleeasing	: 'easeOutExpo',
					titlespeed	: 1200,
					autoplay : true,
					slideshow_interval:10000
                });
            });
        </script>
        <div id ="deal_category_show">
        	<div id="deal_category_header">
        		<h2><?=$category_name?></h2>
        		<div id="search_box">
        			ค้นหา :
        			<input type="text" name="keyword" id="keyword" value="" />
        			<img src="/assets/images/search_bt.png" onclick="search_deal()" />
        		</div>
        	</div>
        	<div id="deal_category_main">
        		<? 
        		//print_r($deal_data);
        		foreach($deal_data as $deal)
        		{
        			if(empty($deal["deal_buy_count"])) $deal["deal_buy_count"]	=	0;
        			if($deal["deal_price_show"]>0||$deal["deal_special"]==1){
        			$view_link	=	"/category/deal/".$deal["deal_id"]."/".urlencode($deal["deal_name"]);
        			?>
        		<div class="deal_box" id="deal_box_<?=$deal["deal_id"]?>">
        			<div class="deal_image">
        				 <a href="<?=$view_link?>" target="_blank" title="<?=$deal["deal_name"]?>" alt="<?=$deal["deal_name"]?>">
        				 	<img src="/assets/images/<?=$deal["deal_index_image"]?>" alt="<?=$deal["deal_name"]?> ราคาพิเศษ <?=number_format($deal["deal_price_show"])?> บาท" title="/assets/images/<?=$deal["deal_index_image"]?>" alt="<?=$deal["deal_name"]?> ราคาพิเศษ <?=number_format($deal["deal_price_show"])?> บาท" />
        				 </a>
        			</div>
        			<div class="deal_detail">
        				<a title="<?=$deal["deal_name"]?>" alt="<?=$deal["deal_name"]?>" href="<?=$view_link?>" target="_blank"><div class="deal_name"><?=$deal["deal_name"]?></div></a>
        				<div class="deal_intro">
        					<?=$deal["deal_intro"]?>
        				</div>
        				<div class="deal_info">
        					<div class="deal_price">฿<?=number_format($deal["deal_price_show"])?></div>
        					<div class="deal_button">
        						<?if($deal["deal_special"] == "1"){?>
        							<?if($login){?>
        								<a class="can_click bt_buy" onclick="get_deal_special('<?=$deal["deal_id"]?>')" title="<?=$deal["deal_name"]?>" alt="<?=$deal["deal_name"]?>"><!--<?echo image_asset("font_buy_button.png", '', array('alt'=>"สั่งซื้อ"));?>--></a>
        							<?}else{?>
        								<a class="fancybox fancybox.ajax bt_buy" href="/shopping/login_for_specail_deal/<?=$deal["deal_id"]?>" title="<?=$deal["deal_name"]?>" alt="<?=$deal["deal_name"]?>"><!--<?echo image_asset("font_buy_button.png", '', array('alt'=>"สั่งซื้อ"));?>--></a>
        							<? }?>
        						<?}else{?>
        						<a class="fancybox fancybox.ajax bt_buy" href="/shopping/popup_order/<?=$deal["deal_id"]?>/<?=base64_encode($deal["deal_name"])?>" title="<?=$deal["deal_name"]?>" alt="<?=$deal["deal_name"]?>"><!--<?echo image_asset("font_buy_button.png", '', array('alt'=>"สั่งซื้อ"));?>--></a>
        						<?}?>
        						<a href="<?=$view_link?>" target="_blank" class="bt_view" title="<?=$deal["deal_name"]?>" alt="<?=$deal["deal_name"]?>"><!--<?echo image_asset("font_view_button.png", '', array('alt'=>"ดูรายละเอียด"));?>--></a>
        					</div>
        					<div class="deal_count_box">
        						<div class="deal_off">
        							<div class="small_text_1">ลด</div>
        							<div class="big_text_1"><?=$deal["deal_percent_off"]?>%</div>
        						</div>
        						<div class="deal_buy">
        							<div class="small_text_1">ซื้อแล้ว</div>
        							<div class="big_text_1" id="buy_cout_<?=$deal["deal_id"]?>"></div>
        							<script type="text/javascript">
        								run_buy_count(<?=$deal["deal_id"]?>,<?=$deal["deal_buy_count"]?>);
        							</script>
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
        				<div class="deal_share">
        					<div>Social Share :</div>
        					<div><fb:like href="http://www.thebestdeal1.com<?=$view_link?>" send="false" layout="button_count" width="100" show_faces="false"></fb:like></div>
        					<div class="tweet_button">
        						<a href="https://twitter.com/share" class="twitter-share-button" data-url="http://www.thebestdeal1.com/<?=$view_link?>" data-size="100" data-text="<?=$deal["deal_name"]?> : ฿<?=number_format($deal["deal_price_show"])?>" data-lang="en">Tweet</a>
        					</div>
        					<!-- Place this tag where you want the +1 button to render. -->
							<!--
								<div class="g-plusone" data-size="medium" data-annotation="inline" data-width="200" href="http://www.thebestdeal1.com/<?=$view_link?>"></div>
							-->
        				</div>
        			</div>
        		</div>
        		<? }} ?>
        	</div>
        	<div id="page_navigator"><?=$page_navigator?></div>
        </div>
        <div id="fb_like_box">
        	<iframe src="//www.facebook.com/plugins/likebox.php?href=http%3A%2F%2Fwww.facebook.com%2Fthebestdeal1&amp;width=940&amp;height=290&amp;show_faces=true&amp;colorscheme=light&amp;stream=false&amp;border_color&amp;header=true&amp;appId=398382723561868" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:940px; height:290px;" allowTransparency="true"></iframe>
        </div>
<!-- Place this tag after the last +1 button tag. -->
<!--
<script type="text/javascript">
  (function() {
    var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
    po.src = 'https://apis.google.com/js/plusone.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
  })();
</script>
-->
<!-- Twitter -->
<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="https://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
<script>
	$('.fancybox').fancybox({'ajax':{cache	: false}});
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
	function search_deal()
	{
			$.ajax({
				 type: "POST",
				 cache: false,
				 data:"keyword="+$("#keyword").val(),
  				 url: "/category/finddeal/"
			}).done(function( msg ) {
				$("#deal_category_show").html(msg);
			});
	}
</script>