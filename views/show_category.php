        	<div id="deal_category_header">
        		<h2>คำค้นหา : <?=$category_name?></h2>
        		<div id="search_box">
        			ค้นหา :
        			<input type="text" name="keyword" id="keyword" value="" />
        			<img src="/assets/images/search_bt.png" onclick="search_deal()" />
        		</div>
        	</div>
        	<div id="deal_category_main">
        		<? 
        		//print_r($deal_data);
        		foreach($deal_data as $deal){
        			if($deal["deal_price_show"]>0||$deal["deal_special"]==1){
        			$view_link	=	"/category/deal/".$deal["deal_id"]."/".urlencode($deal["deal_name"]);
        			?>
        		<div class="deal_box" id="deal_box_<?=$deal["deal_id"]?>">
        			<div class="deal_image">
        				 <a href="<?=$view_link?>" target="_blank" title="<?=$deal["deal_name"]?>" alt="<?=$deal["deal_name"]?>">
        				 	<?echo image_asset($deal["deal_index_image"], '', array('alt'=>$deal["deal_name"]." ราคาพิเศษ ".number_format($deal["deal_price_show"])." บาท",'title'=>$deal["deal_name"]." ราคาพิเศษ ".number_format($deal["deal_price_show"])." บาท"));?>
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