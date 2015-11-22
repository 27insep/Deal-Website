<div id="main_popup_box">
<div id="login_popup">
	<div id="login_popup_header">สมัครสมาชิก</div>
	<div id="regis_popup_main">
		<div id="regis_box">
			<div id="regis_text">สมัครสมาชิกด้วยอีเมล์</div>
			<a href="/customer/signup"><div id="regis_button_email"></div></a>
			<div id="comment_text">สมัครใช้บริการ Thebestdeal1.com ด้วยอีเมล์ของคุณ</div>
		</div>
		<div id="regis_box1">
			<div id="regis_text">สมักครสมาชิกด้วย Facebook</div>
			<div id="regis_button_facebook" onclick='login();'></div>
			<div id="comment_text">สมัครใช้บริการ Thebestdeal1.com ง่ายยิ่งขึ้น ด้วย Login ของ Facebook</div>
		</div>
		
	</div>
</div> 
</div>
<script>
		function forget_password(responseText, statusText, xhr, $form)
 		{
 			if(responseText==1)
 			{
 				alert("ส่งรหัสผ่านใหม่ไปยังอีเมล์ของคุณแล้ว");
 			}else{
 				alert("ไม่พบ Email Address นี้ในระบบ");
 			} 
 		}
 		$('#popup_forget_form').ajaxForm(
 			{ 	
 				success: forget_password
 			} 
 		);
 </script>