<div id="main_popup_box">
<div id="login_popup">
	<div id="login_popup_header">เปลี่ยนรหัสผ่าน</div>
	<form id="popup_pass_form" name="popup_pass_form" action="/member/chagepwd" method="post">
	<div id="chagepass_popup_main">
		<div id="pass_box">
			<div id="pass_old">รหัสผ่านเดิม</div>
			<div id="input_div"><input type="password" id="txt_old" name="txt_old" class="input_pass"/></div>
		</div>
		<div id="pass_box">
			<div id="pass_old">รหัสผ่านใหม่</div>
			<div id="input_div"><input type="password" id="txt_new" name="txt_new" class="input_pass"/></div>
		</div>
		<div id="pass_c">
			<div id="pass_old">ยืนยันรหัสผ่านใหม่</div>
			<div id="input_div"><input type="password" id="txt_confirm" name="txt_confirm" class="input_pass"/></div>
		</div>
	</div>
	<div id="changepass_popup_footer">
		<div id="savechange"><input type="image" name="submit" id="submit" src="/assets/images/save_button.png"/></div>
	</div>
	</form>
	
	<script type="text/javascript">
 	$(document).ready(function() {  
 		function changepass_compleate(responseText, statusText, xhr, $form)
 		{
 			if(responseText==0)
 				alert("รหัสผ่านเดิมไม่ถูกต้อง !!!");
 			else if(responseText==2)
 				alert("รหัสผ่านไม่ตรงกัน !!!");
 			else{
 				alert("เปลี่ยนรหัสผ่านเรียบร้อยแล้วค่ะ !!!");
 				window.close();
 			} 
 		}
 		$('#popup_pass_form').ajaxForm(
 			{ 	
 				success: changepass_compleate
 			} 
 		); 
  	});
</script>
</div> 