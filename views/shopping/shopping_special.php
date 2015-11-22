<?if($show_login_box){?>
<div id="main_popup_box" >
<div id="login_popup">
	<div id="login_popup_header">กรุณาเข้าสู่ระบบก่อนค่ะ !</div>
	<div id="login_popup_main">
		<form id="popup_login_form" name="popup_login_form" action="/member/login" method="post">
		<div id="login_popup_box_left">
			<input type="hidden" name="deal_id" id="deal_id" value="<?if(isset($deal_id)) echo $deal_id;?>" />
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
 			parent.$.fancybox.close();
 			$("#top_bar").load("/member/load_top_menu");
 			if(responseText==0)
 			{
 				$( "#dialog" ).html("ชื่อผู้ใช้ หรือ รหัสผ่านไม่ถูกต้อง <br>กรุณาตรวจสอบค่ะ !");
	 				$( "#dialog" ).dialog(
	 					{ 
	 						title: "ข้อความ",
	 						buttons: [ { text: "ตกลง", click: function() { $( this ).dialog( "close" ); } } ] 
	 					});
 				}else if(responseText==5){
 				$( "#dialog" ).html("ขออภัยดีลตังกล่าวไม่ได้ร่วมรายการค่ะ !!");
	 				$( "#dialog" ).dialog(
	 					{ 
	 						title: "ข้อความ",
	 						buttons: [ { text: "ตกลง", click: function() { $( this ).dialog( "close" ); } } ] 
	 					});
 			}else if(responseText==2){
					$("#main_popup_box").remove();
					//window.location.reload();
						$( "#dialog" ).html("การสั่งซื้อดีลนี้สามารถซื้อได้ 1 สิทธิ์ต่อคนเท่านั้นค่ะ");
		 				$( "#dialog" ).css("text-align","center");
		    			$( "#dialog" ).css("padding","25px");
		    			$( "#dialog" ).dialog({
		 					title: "ข้อความ",
		 					buttons: [ { text: "ตกลง", click: function() { $( this ).dialog( "close" ); } } ] 
		 				});
 			}else if(responseText==4){
					$("#main_popup_box").remove();
					//window.location.reload();
						$( "#dialog" ).html("ระบบทำการสั่งซื้อสินค้าเรียบร้อยแล้วค่ะ");
		 				$( "#dialog" ).css("text-align","center");
		    			$( "#dialog" ).css("padding","25px");
		    			$( "#dialog" ).dialog({
		 					title: "ข้อความ",
		 					buttons: [ { text: "ตกลง", click: function() { $( this ).dialog( "close" ); } } ] 
		 				});
 			}else {
					//$("#main_popup_box").remove();
					//window.location.reload();
					$("#main_popup_box").remove();
					$( "#dialog" ).html("กรุณาระบุข้อมูลของท่านให้ครบถ้วน <br><br> ก่อนทำการสั่งซื้อค่ะ");
	 				$( "#dialog" ).dialog(
	 					{ 
	 						title: "ข้อความ",
	 						close: function( event, ui ) 
	 						{
	 							window.location.href = 'http://www.thebestdeal1.com/member/special/'+responseText;
	 						},
	 						buttons: [ { text: "ตกลง", click: function() { $( this ).dialog( "close" ); } } ] 
	 					});
			}
 		}
 		$('#popup_login_form').ajaxForm(
 			{ 	
 				success: login_compleate
 			} 
 		); 
</script>
<? }?>