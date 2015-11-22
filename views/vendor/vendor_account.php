<div id="vendor_dashboard_main">
<div id="vendor_dashboard_header">
	<div id="vendor_dashboard_header_text">
		<div>Merchant Dashboard</div>
		<div id="marchant_name"><?=$vendor_name?>,<?=$this->convert_date->show_thai_date(date("Y-m-d",time()))?></div>
	</div>
</div>
<div id="vendor_dashboard_menu">
	<div id="vendor_dashboard_menu_inner">
		<div id="vendor_dashboard_left"><a href="/vendor/vendor_deal">My Events</a> | <a href="/vendor/vendor_profile">My Profile</a> | <a href="/vendor/vendor_account"><span>Change Password</span></a></div>
		<div id="vendor_dashboard_right"><span>สวัสดี คุณ <?=$vendor_contact_fname?> <?=$vendor_contact_sname?></span> | <span style="color: #FFFFFF;" onclick="do_logout()">Log Out</span></div>
	</div>
</div>

<form id="vendor_form" action="/vendor/vendor_change_password" method="post">
<div id="vendor_main">
	<div id="vendor_inner_main">
	<div id="vendor_main_topic"> &nbsp;เปลี่ยนรหัสผ่าน</div>
	<div id="vendor_body">
		<div>อีเมล :</div><div><?=$vendor_email?></div>
		<div class="clear">รหัสผ่านเดิม : </div><div><input type="password"  name="vendor_password" id="vendor_password" /></div>
		<div class="clear">รหัสผ่านใหม่ : </div><div><input type="password"  name="vendor_new_password" id="vendor_new_password" /></div>
		<div class="clear">ยื่นยันรหัสผ่านใหม่ : </div><div><input type="password" name="vendor_confirm_password" id="vendor_confirm_password" /></div>
	</div>	
	<div id="vendor_main_footer">
		<input type="submit" name="submit" id="submit" value="เปลียนรหัสผ่าน" />
	</div>
	</div>
</div>
</form>
</div>
<div id="vendor_dashboard_footer"></div>
<script type="text/javascript">
	function do_logout()
	{
		$.ajax({
  			url: "/vendor/vendor_logout",
		}).done(function( msg ) {
  			 	$( "#dialog" ).html("ทำการออกจากระบบเรียบร้อยแล้วค่ะ");
 				$( "#dialog" ).dialog(
 					{ 
 						title: "ข้อความ",
 						close: function( event, ui ) 
 						{
 							window.location.href = "/vendor/";
 						},
 						buttons: [ { text: "ตกลง", click: function() { $( this ).dialog( "close" ); } } ]
 					});
 				
		});
	}
	   	$(document).ready(function() {  
 		function show_status(responseText, statusText, xhr, $form)
 		{
 			if(responseText==1)
 			{
 				$( "#dialog" ).html("ทำการบันทึกข้อมูลเรียบร้อยแล้วค่ะ");
 				$( "#dialog" ).dialog(
 					{ 
 						title: "ข้อความ",
 					}
 				);
 			}else if(responseText==0){
 				$( "#dialog" ).html("รหัสผ่านเดิมไม่ถูกต้อง กรุณาตรวจสอบค่ะ");
 				$( "#dialog" ).dialog({ title: "แจ้งเตือน" });
 			} else if(responseText==2){
 				$( "#dialog" ).html("ยืนยันรหัสผ่านใหม่ไม่ถูกต้อง กรุณาตรวจสอบค่ะ");
 				$( "#dialog" ).dialog({ title: "แจ้งเตือน" });
 			}else{
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