<form name="admin_form" id="admin_form" method="post" action="<?=$page_action?>">
<div style="padding: 25px;">
	<span class="header_title"><?=$manage_title?></span>
	<div style="float: right"><a href="/mybackoffice/user_admin">กลับสู่หน้าหลัก</a></div>
	<br/><br/>
	<table border="0" cellpadding="5">
		<tr>
			<td>ชื่อผู้ใช้</td>
			<td>
				<input type="text" value="<?if(isset($admin_user)){ echo $admin_user;}?>" name="txt_user" id="txt_user"/>
				<input type="hidden" value="<?=$action_status?>" name="action_status" id="action_status"/>
				<input type="hidden" value="<?if(isset($admin_user)){ echo $admin_user;}?>" name="txt_user_old" id="txt_user_old"/>
				</td>
		</tr>
		<tr>
			<td>รหัสผ่าน</td>
			<td><input type="password" value="<?if(isset($admn_pwd)){ echo base64_decode($admn_pwd);}?>" name="admn_pwd" id="admn_pwd" />
			</td>
		</tr>
		<tr>
			<td>ยืนยันรหัสผ่าน</td>
			<td><input type="password" value="<?if(isset($admn_pwd)){ echo base64_decode($admn_pwd);}?>" name="admin_confirm_pwd" id="admin_confirm_pwd" /></td>
		</tr>
		<tr>
			<td>ชื่อ - นามสกุล</td>
			<td><input type="text" value="<?if(isset($admin_name)){ echo $admin_name;}?>" name="admin_name" id="admin_name"  size="30px"/></td>
		</tr>
		<tr>
			<td>กลุ่มผู้ใช้งาน</td>
			<td>
				<select name="admin_type" id="admin_type">
					<option value="">- - - กรุณาเลือกกลุ่มผู้ใช้งาน - - -</option>
					<option value="1" <? if(isset($admin_type) && $admin_type == '1'){echo 'selected';}?>>ผู้ดูแลระบบ</option>
					<option value="2" <? if(isset($admin_type) && $admin_type == '2'){echo 'selected';}?>>ผู้จัดการ</option>
					<option value="3" <? if(isset($admin_type) && $admin_type == '3'){echo 'selected';}?>>พนักงาน</option>
				</select>
			</td>
		</tr>
		<tr>
			<td>สถานะ</td>
			<td>
				<select name="admin_status" id="admin_status">
					<option value="1" <? if(isset($admin_status) && $admin_status == '1'){echo 'selected';}?>>Active</option>
					<option value="0" <? if(isset($admin_status) && $admin_status == '0'){echo 'selected';}?>>Not Active</option>
				</select>
			</td>
		</tr>
		<tr>
			<td></td>
			<td><input type="submit" value="บันทึกข้อมูล" /></td>
		</tr>		
	</table>
</div>
</form>
<script>
 $(document).ready(
  	function(){
  		$("#admin_form").validate({
		   		rules: {
				   			txt_user: {
					     	required:true,
					     	remote: {
				        	url: "/mybackoffice/check_username_admin",
				        	type: "post",
				        	data: {
				          		txt_user: function() {return $("#txt_user").val();} , 
				          		txt_user_old: function() {return $("#txt_user_old").val();},
				          		action_status: function() {return $("#action_status").val();}
				        	}
				      		}
					     }
		   			 		 ,admn_pwd: {
						       required: true,
						       minlength: 6
						     },
						     admin_confirm_pwd:
						     {
						     	required: true,
						     	equalTo: "#admn_pwd"
						     }
		   			 		, admin_name :{
						    	required:true
						    }
						    ,admin_type :
						    {
						    	required:true
						    }
		   		},
		   		messages: {
				   			 txt_user: {
						     	required:"กรุณาระบุ  Username  ค่ะ",
						     	remote: "Username ดังกล่าวมีในระบบแล้วค่ะ"
						     }
						     ,admn_pwd: {
						       required: "กรุณาระบุรหัสผ่านค่ะ",
						       minlength:"รหัสผ่านต้องมากกว่า 6 ตัวอักษรค่ะ"
						     }
						     ,admin_confirm_pwd:
						     {
						     	required:  "กรุณาระบุยื่นยันรหัสผ่านค่ะ",
						     	equalTo : "ยื่นยันรหัสผ่านไม่ถูกต้องค่ะ"
						     }
						      ,admin_name :{
						    	required:"กรุณาระบุชื่อผู้ดูแลระบบค่ะ"
						    }
						     ,admin_type :{
						    	required:"กรุณาระบุกลุ่มผู้ใช้งานค่ะ"
						    }
		   		}
   		});
  	});
</script>