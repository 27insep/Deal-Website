<div id="vendor_dashboard_main">
<div id="vendor_dashboard_header">
	<div id="vendor_dashboard_header_text">
		<div>Merchant Dashboard</div>
	</div>
</div>
<div id="vendor_dashboard_menu">
</div>

<form id="vendor_form" action="/vendor/vendor_reset_password" method="post">
<div id="vendor_main">
	<div id="vendor_inner_main">
	<div id="vendor_main_topic"> &nbsp;เปลี่ยนรหัสผ่าน</div>
	<div id="vendor_body">
		<div class="clear">รหัสผ่านใหม่ : </div><div><input type="password"  name="vendor_new_password" id="vendor_new_password" /></div>
		<input type="hidden"  name="vendor_id" id="vendor_id" value="<?=$link?>" />
		<div class="clear">ยื่นยันรหัสผ่านใหม่ : </div><div><input type="password" name="vendor_confirm_password" id="vendor_confirm_password" /></div>
	</div>	
	<div id="vendor_main_footer">
		<input type="submit" name="submit" id="submit" value="เปลียนรหัสผ่าน" style="height:28px;"/>
	</div>
	</div>
</div>
</form>
</div>
<div id="vendor_dashboard_footer"></div>
<script type="text/javascript">
	   	$(document).ready(function() {  
 		function show_status(responseText, statusText, xhr, $form)
 		{
 			if(responseText==1)
 			{
 				$( "#dialog" ).html("ทำการบันทึกข้อมูลเรียบร้อยแล้วค่ะ");
 				$( "#dialog" ).dialog(
 					{ 
 						title: "ข้อความ",
 						close: function( event, ui ) 
 						{
 							window.location.href = "/vendor";
 						},
 						buttons: [ { text: "ตกลง", click: function() { $( this ).dialog( "close" ); } } ] 
 					}
 				);
 			}else if(responseText==2){
 				$( "#dialog" ).html("ยืนยันรหัสผ่านใหม่ไม่ถูกต้อง กรุณาตรวจสอบค่ะ");
 				$( "#dialog" ).dialog({ title: "แจ้งเตือน" });
 			}else if(responseText==3){
 				$( "#dialog" ).html("รหัสผ่านใหม่ต้องมีอย่างน้อย 6 ตัวอักษร กรุณาตรวจสอบค่ะ");
 				$( "#dialog" ).dialog({ title: "แจ้งเตือน" });
 			}
 		}
 		$('#vendor_form').ajaxForm(
 			{ 	
 				success: show_status
 			} 
 		); 
  	});
</script>