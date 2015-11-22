<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta http-equiv="Cache-control" content="no-cache">
<title>:: Login ::</title>
</head>
<body>
<div id="main_popup_box">
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
			<div><?=image_asset('fb_login_big_button.png', '', array('alt'=>'เข้าสู่ระบบผ่านเฟสบุ๊ค'));?></div>
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
<script type="text/javascript">
 		function login_compleate(responseText, statusText, xhr, $form)
 		{
 			if(responseText==0)
 			{
 				alert("ชื่อผู้ใช้ หรือ รหัสผ่านไม่ถูกต้อง \nกรุณาตรวจสอบค่ะ !");
 			}else{
 				$.ajax({
  					url: "/shopping/popup_order/<?=$deal_id?>/<?=base64_encode($deal_name)?>",
				}).done(function( msg ) {
					$("#login_popup").remove();
					$("#main_popup_box").html(msg);
					$("#top_bar").load("/member/load_top_menu");
					alert("pass");
  				});
 			} 
 		}
 		$('#popup_login_form').ajaxForm(
 			{ 	
 				success: login_compleate
 			} 
 		); 
</script>
</body>
</html>