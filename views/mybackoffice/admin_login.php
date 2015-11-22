<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>: . Admin Zone : .</title>
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
<div id="warper">
<div id="header">
	<div id="header_inner">
  	</div>
 </div>
<div id="vendor_login_header"></div>
<form name="admin_login_form" id="admin_login_form" method="post" action="/mybackoffice/admin_login">
	<div id="admin_login_head"></div>
	<div id="admin_login_detail">
		<div id="admin_user"><div class="admin_user_txt">Username</div><input type="text" name="admin_username" id="admin_username" value="<?if(isset($admin_data["admin_user"])) echo $admin_data["admin_user"];?>" size="41"/></div>
		<div id="admin_pwd"><div class="admin_user_txt">Password</div><input type="password" name="admin_password" id="admin_password" value="<?if(isset($admin_data["admn_pwd"])) echo $admin_data["admn_pwd"];?>" size="41"/></div>
		
	</div>
	<div id="admin_login_footer">
    	<div id="rb"><input type="checkbox" name="remeberme" value="1"> remember me</div>
		<div><input type="image" id="admin_img_login" src="/assets/images/admin/admin_btn_login.png" width="200px"/></div>
    </div> 
	    <div id="dialog"></div>
</form>
<script type="text/javascript">
 	$(document).ready(function() {  
 		function show_admin_zone(responseText, statusText, xhr, $form)
 		{
 			if(responseText==0)
 			{
 				$( "#dialog" ).html("ชื่อผู้ใช้ หรือ รหัสผ่านไม่ถูกต้อง<br/>กรุณาตรวจสอบค่ะ !");
 				$( "#dialog" ).dialog({ title: "แจ้งเตือน" });
 			}else if(responseText==1){
 				$( "#dialog" ).html("ทำการเข้าสู่ระบบเรียบร้อยแล้วค่ะ");
 				$( "#dialog" ).dialog(
 					{ 
 						title: "ข้อความ",
 						close: function( event, ui ) 
 						{
 							window.location.href = "/mybackoffice/member_profile";
 						},
 						buttons: [ { text: "ตกลง", click: function() { $( this ).dialog( "close" ); } } ] 
 					});
 			}
 		}
 		$('#admin_login_form').ajaxForm(
 			{ 	
 				success: show_admin_zone
 			} 
 		); 
  	});
</script>
    <div id="admin_footer_section">
    	<div>Copyright @ 2004 - 2010 TheBestDeal.COM All Right Reserved including text, graphics, interfaces and design thereof are all rights reserved.</div>
    </div>
</div>

</body>
</html>