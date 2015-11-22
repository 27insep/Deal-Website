<div id="main_popup_box">
<div id="login_popup">
	<div id="login_popup_header">ลืมรหัสผ่าน</div>
	<div id="chagepass_popup_main">
		<form id="popup_forget_form" name="popup_forget_form" action="/customer/forget_password_email" method="post">
		<div id="forget_text">กรุณาใส่ที่อยู่อีเมล์ของคุณด้านล่างและเราจะส่งอีเมล์ที่มีลิงค์เพื่อรีเซตรหัสผ่านของคุณ</div>
		<div id="forget_txt_email">กรุณากรอกอีเมล</div>
		<div id="forget_email"><input type="text" id="member_email" name="member_email" class="in_mtxt"/></div>
		<div style="padding: 15px 10px 0 20px;float: left"><?=$capcha?></div>
		<div style="padding: 13px 0 0 20px"><input type="text" class="in_stxt" name="capcha" /></div>
		<div id="forget_click"><input type="submit" id="forget_button" value="" /></div>
		</form>
	</div>
	<div id="forget_popup_footer">
		<div id="footer_topic_text">
			<div><span>คุณยังไม่เป็นสมาชิก !</span></div>
			<div>รับข้อเสนอและอภิสิทธิ์เฉพาะสำหรับสมาชิก</div>
			<div>สามารถ <a href="/customer/signup">สมัครสมาชิก</a> ได้ทุกวัน ฟรีไม่มีค่าใช้จ่าย</div>
		</div>
		<div class="popup_footer_box"><a href="/customer/signup">ลงทะเบียน</a></div>
	</div>
</div> 
</div>
<script>
		function forget_password(responseText, statusText, xhr, $form)
 		{
 			if(responseText==1)
 			{
 				alert("ส่งรหัสผ่านใหม่ไปยังอีเมล์ของคุณแล้ว");
 				window.location.href = 'http://www.thebestdeal1.com';
 			}else{
 				alert(responseText);
 			} 
 		}
 		$('#popup_forget_form').ajaxForm(
 			{ 	
 				success: forget_password
 			} 
 		);
 </script>