<div id="vendor_login_header"></div>
<form name="vendor_login_form" id="vendor_login_form" method="post" action="/vendor/vendor_login">
<div id="login_form">
	<div id="login_form_box">
	<div>ชื่อผู้ใช้ : </div>
	<div><input type="text" name="vendor_user" id="vendor_user" value=""/></div>
	<div>รหัสผ่าน : </div>
	<div><input type="password" name="vendor_pwd" id="vendor_pwd" value=""/></div>
	<div><input type="image" src="/assets/images/merchant/Merchant_Login.png" /></div>
	</div>
</div>
</form>
<div id="vendor_login_footer">© 2013 THE BEST DEAL CO., LTD. All Rights Reserved. Company Registration : 010-5555-180-399 Tax Identification : 010-5555-180-399</div>
<script type="text/javascript">
 	$(document).ready(function() {  
 		function show_vendor_zone(responseText, statusText, xhr, $form)
 		{
 			if(responseText==0)
 			{
 				$( "#dialog" ).html("ชื่อผู้ใช้ หรือ รหัสผ่านไม่ถูกต้อง<br/>กรุณาตรวจสอบค่ะ !");
 				$( "#dialog" ).dialog({ title: "แจ้งเตือน" });
 			}else{
 				$( "#dialog" ).html("ทำการเข้าสู่ระบบเรียบร้อยแล้วค่ะ");
 				$( "#dialog" ).dialog(
 					{ 
 						title: "ข้อความ",
 						close: function( event, ui ) 
 						{
 							window.location.href = "/vendor/vendor_deal";
 						},
 						buttons: [ { text: "ตกลง", click: function() { $( this ).dialog( "close" ); } } ] 
 					});
 			} 
 		}
 		$('#vendor_login_form').ajaxForm(
 			{ 	
 				success: show_vendor_zone
 			} 
 		); 
  	});
</script>