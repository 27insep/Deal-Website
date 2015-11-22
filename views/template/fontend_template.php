<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns:fb="http://ogp.me/ns/fb#">
<head>
	<title><?=$page_data['page_title']?></title>
	<? if(isset($page_data['deal'])){$deal=$page_data['deal'];}?>
	<? if(isset($deal["deal_meta_keyword"])&&!empty($deal["deal_meta_keyword"])){?>
	<meta name="keywords" content="<?=$deal["deal_meta_keyword"]?>">
	<?}?>
	<? if(isset($deal["deal_meta_description"])&&!empty($deal["deal_meta_description"])){?>
	<meta name="description" content="<?=$deal["deal_meta_description"]?>">
	<?}?><meta name="robots" content="INDEX,FOLLOW" />
	<meta name="author" content="THE BEST DEAL CO., LTD., Thailand" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta http-equiv="Cache-control" content="no-cache">
	<!-- get css -->
	<? foreach($stylesheets as $stylesheet): ?>
  		<?= css_asset($stylesheet); ?>    
	<? endforeach; ?>
			<!-- get js -->
	<? foreach($javascripts as $javascript): ?>
  		<?= js_asset($javascript); ?>
	<? endforeach; ?>
</head>
<body>
	<div id="fb-root"></div>
	<script>
		function check_new_user(fb_email)
   		{
   			$.ajax({
				 type: "POST",
  				 url: "/member/fb_login/",
  				 data: { email:fb_email }
			}).done(function( msg ) {
					window.location.reload();
			});
   		}
  		// Additional JS functions here
  		window.fbAsyncInit = function() {
    	FB.init({
      		appId      : '474459182626342', // App ID
      		channelUrl : '//www.thebestdeal1.com/home/channel/', // Channel File
      		status     : true, // check login status
      		cookie     : true, // enable cookies to allow the server to access the session
      		xfbml      : true  // parse XFBML
    	});

    	// Additional init code here
  		};
		// logs the user in the application and facebook
	function login(){
		FB.getLoginStatus(function(r){
     	if(r.status === 'connected'){
            //window.location.href = 'fbconnect.php';
            FB.api('/me', function(response) {
       			var	email		=	response.email;
       			check_new_user(email);
     		});
     	}else{
        	FB.login(function(response) {
                if(response.authResponse) {
              //if (response.perms) 
                   	FB.api('/me', function(response) {
       					var	email		=	response.email;
       					check_new_user(email);
     				});
            } else {
              // user is not logged in
            }
     },{scope:'email'}); // which data to access from user profile
 }
});
}
  		// Load the SDK Asynchronously
 	 	(function(d){
    		var js, id = 'facebook-jssdk', ref = d.getElementsByTagName('script')[0];
     		if (d.getElementById(id)) {return;}
     		js = d.createElement('script'); js.id = id; js.async = true;
     		js.src = "//connect.facebook.net/en_US/all.js";
    		ref.parentNode.insertBefore(js, ref);
   		}(document));
		</script>
		<div id="container">
			<div id="warpper">	
				<div id="header">
					<div id="header_top_sec">
					<div id="header_left_sec">
						<a href="/index.php" title="รวมโรงแรมและที่พักในหัวหิน กระบี่ ภูเก็ต ดีลราคาถูก ดีลราคาพิเศษ บุฟเฟ่ต์โรงแรม"><?echo image_asset('company_logo.png', '', array('alt'=>'รวมโรงแรมและที่พักในหัวหิน กระบี่ ภูเก็ต ดีลราคาถูก ดีลราคาพิเศษ บุฟเฟ่ต์โรงแรม'));?></a>
					</div>
					<div id="header_right_sec">
						<div id="top_bar">
							<?=$page_data["print_top_bar"];?>
						</div>
					</div>
					</div>
					<div id="top_menu">
						<a href="/" alt="ดีลเด่นวันนี้" title="ดีลเด่นวันนี้" class="menu_box <? if(isset($page_id)&&$page_id=="a"){ echo "active";}?>">
							<?echo image_asset("upload/category_icon/1.png", '', array('alt'=>'ดีลเด่นวันนี้'));?>
							<span>ดีลเด่นวันนี้</span>
						</a>
						<!--
						<a href="/category/show" alt="ดีลทั้งหมด" title="ดีลทั้งหมด" class="menu_box <? if(isset($page_id)&&$page_id=="b"){ echo "active";}?>">
							<?echo image_asset("upload/category_icon/2.png", '', array('alt'=>'ดีลทั้งหมด'));?>
							<span>ดีลทั้งหมด</span>
						</a>
						-->
						<? foreach($page_data["category_data"] as $category_data){?>
						<a href="/category/show/<?=$category_data["cat_name"]?>/<?=$category_data["cat_id"]?>" alt="<?=$category_data["cat_name"]?>" title="<?=$category_data["cat_name"]?>" class="menu_box <? if(isset($page_id)&&$category_data["cat_id"]==$page_id){ echo "active";}?>">
							<?echo image_asset($category_data["cat_icon"], '', array('alt'=>''.$category_data["cat_name"].''));?>
							<span><?=$category_data["cat_name"]?></span>
						</a>
						<?}?>
                        
						<a href="/home/howtobuy" alt="วิธีการสั่งซื้อ" title="วิธีการสั่งซื้อ" class="menu_box <? if(isset($page_id)&&$page_id=="d"){ echo "active";}?>">
							<?echo image_asset("upload/category_icon/12.png", '', array('alt'=>'วิธีการสั่งซื้อ'));?>
							<span>วิธีการสั่งซื้อ</span>
						</a>
                        
						<a href="/home/howtopay" alt="วิธีการชำระเงิน" title="วิธีการชำระเงิน" class="menu_box <? if(isset($page_id)&&$page_id=="c"){ echo "active";}?>">
							<?echo image_asset("upload/category_icon/10.png", '', array('alt'=>'วิธีการชำระเงิน'));?>
							<span>วิธีการชำระเงิน</span>
						</a>
						
						<a href="/home/adsdeal" alt="โฆษณาฟรีกับเรา" title="โฆษณาฟรีกับเรา" class="menu_box <? if(isset($page_id)&&$page_id=="d"){ echo "active";}?>">
							<?echo image_asset("upload/category_icon/11.png", '', array('alt'=>'โฆษณาฟรีกับเรา'));?>
							<span>โฆษณาฟรีกับเรา</span>
						</a>
					</div>
					<?php if(isset($sub_menu_data)){?>
                    <div class="submenu">
                    		
                    	<?php if($show_arrow){?>
                    	<a id="prev_sub_menu" class="subL" href="#"><?echo image_asset("subleft.png");?></a>
                    	<?php } ?>
                    	<div class="submenu_mask">
                    		<div class="submenu_text">
                    			<ul class="subC">
                    				<?php foreach($sub_menu_data as $sub_menu){?>
                        				<li><a href="<?php echo $sub_menu["sub_menu_link"];?>" alt="<?php echo $sub_menu["sub_menu_name"];?>" title="<?php echo $sub_menu["sub_menu_name"];?>"><?php echo $sub_menu["sub_menu_name"];?></a></li>
                        			<?php } ?>
                        		</ul>
                        	</div>
                        </div>
                        <?php if($show_arrow){?>
                    	<a id="next_sub_menu" class="subR" href="#"><?echo image_asset("subright.png");?></a>
                    	<?php }?>
                    		
                    </div>
                    <?php } ?>
				</div>
			<div id="main">
				<?=$page_data["content"];?>
			</div>
			</div>
			<div id="footer">
				<div id="footer_warpper">
					<div id="footer_main">
					<div id="footer_left_sec">
						<div class="footer_box">
							<div class="footer_box_header">หมวดหมู่ดีล</div>
							<div class="footer_box_cat">
							<div class="footer_box_cat_main">
								- <a href="/" alt="ดีลทั้งหมด" title="ดีลทั้งหมด">ดีลทั้งหมด</a>
							</div>
							</div>
							<? foreach($page_data["category_data"] as $category_data){?>
							<div class="footer_box_cat">
							<div class="footer_box_cat_main">
								- <a href="/category/show/<?=urlencode($category_data["cat_name"])?>/<?=$category_data["cat_id"]?>" alt="<?=$category_data["cat_name"]?>" title="<?=$category_data["cat_name"]?>"><?=$category_data["cat_name"]?></a>
							</div>
							</div>
							<?}?>
						</div>
						<div class="footer_box">
							<div class="footer_box_header">ดีลขายดี</div>
							<? foreach($page_data["best_sell_deal"] as $deal){
								if($deal["deal_price_show"]>0){
								?>
								<div class="footer_deal_box">
									<div class="footer_deal_box_name">
										- <a href="/category/deal/<?=$deal["deal_id"]?>/<?=urlencode($deal["deal_name"])?>" alt="<?=$deal["deal_name"]?> <?=number_format($deal["deal_price_show"])?> บาท" title="<?=$deal["deal_name"]?> ราคาพิเศษ <?=number_format($deal["deal_price_show"])?> บาท"><?=$deal["deal_name"]?></a>
									</div>
									<div class="footer_deal_box_show">
										<?=number_format($deal["deal_price_show"])?> บาท | ส่วนลด <?=$deal["deal_percent_off"]?> %
									</div>
								</div>
							<?}}?>
						</div>
						<div class="footer_box">
							<div class="footer_box_header">ดีลมาใหม่</div>
							<? 
								foreach($page_data["new_deal"] as $deal){
								if($deal["deal_price_show"]>0){
							?>
								<div class="footer_deal_box">
									<div class="footer_deal_box_name">
										- <a href="/category/deal/<?=$deal["deal_id"]?>/<?=urlencode($deal["deal_name"])?>" alt="<?=$deal["deal_name"]?> <?=number_format($deal["deal_price_show"])?> บาท" title="<?=$deal["deal_name"]?> ราคาพิเศษ <?=number_format($deal["deal_price_show"])?> บาท"><?=$deal["deal_name"]?></a>
									</div>
									<div class="footer_deal_box_show">
										<?=number_format($deal["deal_price_show"])?> บาท | ส่วนลด <?=$deal["deal_percent_off"]?> %
									</div>
								</div>
							<?}}?>
						</div>
					</div>
					<div id="footer_right">
						<div id="footer_logo"><?echo image_asset('company_logo.png', '', array('alt'=>'รวมโรงแรมและที่พักในหัวหิน กระบี่ ภูเก็ต ดีลราคาถูก ดีลราคาพิเศษ','width'=>110));?></div>
						<div id="footer_address"><b>เดอะ เบสท์  ดีล</b><br />
						<b>ที่อยู่ : </b>เลขที่  12/14  ปากทางลาดพร้าว <br />
						(ซอย MRT พหลโยธินทางออกที่2) แขวงจอมพล เขตจตุจักร กรุงเทพฯ  10900
</div>
						<div id="footer_map">
                        	<!--<a href="/assets/images/map.jpg" target="_blank"><?echo image_asset('company_map.png', '', array('alt'=>'The Best Deal One'));?></a>-->
                            <b>สอบถามดีล แจ้งปัญหา แนะนำ-ติชม : </b><br />
                            โทร. 02-938-4399  แฟกซ์. 02-938-4399<br />
                            (จันทร์-เสาร์ 9.00 - 18.00 น.)<br />
								สายด่วน. 089-671-7007<br />
                             <br />
                             <b>ฝ่ายบริการลูกค้า:</b> <a href="mailto:support@thebestdeal1.com">support@thebestdeal1.com</a><br />
                             <b>ฝ่ายขายติดต่อลงดีล:</b> <a href="mailto:sale@thebestdeal1.com">sale@thebestdeal1.com</a>

                        </div>
					</div>
					</div>
					<div id="footer_menu">
						<div id="footer_menu_left">
							<div>
								<a href="/home/aboutus/">เกี่ยวกับเรา</a> |
								<a href="/home/contactus/">ติดต่อเรา</a> |
								<a href="/home/condition/">เงื่อนไขและข้อตกลง</a> |
								<a href="/home/salecondition/">เงื่อนไขการขาย</a> |
								<a href="/home/policy/">นโยบายความเป็นส่วนตัว</a> | 
								<a href="/home/howtopay">วิธีการชำระเงิน</a> 
							</div>
							<div>
								Company Registration : 010-5555-180-399 Tax Identification : 010-5555-180-399 <br />© 2013 THE BEST DEAL CO., LTD. All Rights Reserved. <iframe src="/truehitsstat.php?pagename=<?=$_SERVER["REQUEST_URI"]?>" width="14" height="17"
frameborder="0" marginheight="0" marginwidth="0" scrolling="no"></iframe>
							</div>
						</div>
						<div id="footer_menu_right">
							<div>Visit Us :</div>  
							<div>
								<a href="http://www.facebook.com/TheBestDeal1"><?echo image_asset('facebook_logo.png', '', array('alt'=>'Facebook'));?></a>
								<a href="https://twitter.com/HOTEL_BUFFETS/"><?echo image_asset('twitter_logo.png', '', array('alt'=>'Twister'));?></a>
								<!--<a href=""><?echo image_asset('google_logo.png', '', array('alt'=>'Google'));?></a>-->
                                <a href="http://instagram.com/thebestdeal2555?ref=badge"><?echo image_asset('instagram_logo.png', '', array('alt'=>'Instagram'));?></a>
								<a href="https://www.youtube.com/user/TheBestDeal1"><?echo image_asset('youtube_logo.png', '', array('alt'=>'Youtube'));?></a>
							</div>
						</div>
					</div>
                    <div id="footer_bottom">
                    	<img src="/assets/images/icon_verisign.jpg" />
                        | ยินดีรับบัตรเครดิต
                        <img src="/assets/images/icon_visa.jpg" />
                        <img src="/assets/images/icon_master.jpg" />
                        <img src="/assets/images/icon_jcb.jpg" /> 
                        | ชำระเงินผ่านช่องทาง
                        <img src="/assets/images/icon_bank.jpg" /><img src="/assets/images/icon_cs.jpg" /><img src="/assets/images/icon_scbeasy.jpg" />
                    </div>
				</div>
			</div>
		</div>
		<div id="dialog"></div>
<script type="text/javascript">
 	$(document).ready(function() {  
 		var slide_sub	=	0;
 		<?
 		$max_slide	=	0; 
 		if(isset($sub_menu_data))
 		{
 			$max_slide	=	(int)(sizeof($sub_menu_data)/7);
 		}
 		?>
 		var max_slide	=	<?=$max_slide?>;
	$( "#prev_sub_menu" ).click(function() {
		var slide	=	800;
		$( ".submenu_text" ).animate({ "left": "+="+slide+"px" }, "fast" );
		slide_sub--;
		checkSlide();
	});
	$( "#next_sub_menu" ).click(function(){
		var slide	=	800;
		$( ".submenu_text" ).animate({ "left": "-="+slide+"px" }, "fast" );
		slide_sub++;
		checkSlide();
	});
	function checkSlide()
	{
		if(slide_sub<1)
		{
			$("#prev_sub_menu").hide();
		}else{
			$("#prev_sub_menu").show();
		}
		if(slide_sub>=max_slide)
		{
			$("#next_sub_menu").hide();
		}else{
			$("#next_sub_menu").show();
		}
	}
	checkSlide();
 		function show_member_menu(responseText, statusText, xhr, $form)
 		{
 			if(responseText==0)
 			{
 				$( "#dialog" ).html("ชื่อผู้ใช้ หรือ รหัสผ่านไม่ถูกต้อง<br/>กรุณาตรวจสอบค่ะ !!!");
 				$( "#dialog" ).dialog({ title: "แจ้งเตือน" });
 			}else if(responseText==1){
 				$( "#dialog" ).html("กรุณากรอกรหัสความปลอดภัยค่ะ !!!");
 				$( "#dialog" ).dialog({ title: "แจ้งเตือน" });
 				$( "#cha" ).show();
 			}else if(responseText==2){
 				window.location.href = "http://www.thebestdeal1.com/";
 			}else if(responseText==3){
 				$( "#dialog" ).html("กรุณากรอกรหัสความปลอดภัย !!!");
 				$( "#dialog" ).dialog({ title: "แจ้งเตือน" });
 			}else if(responseText==4){
 				$( "#dialog" ).html("รหัสความปลอดภัยไม่ถูกต้อง !!!");
 				$( "#dialog" ).dialog({ title: "แจ้งเตือน" });
 			}else {
 				$( "#cha" ).hide();
 				$( "#dialog" ).html("ทำการเข้าสู่ระบบเรียบร้อยแล้วค่ะ");
 				$( "#dialog" ).dialog(
 					{ 
 						title: "ข้อความ",
 						close: function( event, ui ) 
 						{
 							window.location.reload();
 						},
 						buttons: [ { text: "ตกลง", click: function() { $( this ).dialog( "close" ); } } ] 
 					});
 			} 
 		}
 		$('#login_form').ajaxForm(
 			{ 	
 				success: show_member_menu
 			} 
 		); 
  	});
</script>
</body>
</html>