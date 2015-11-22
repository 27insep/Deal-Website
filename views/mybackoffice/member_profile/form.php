<form name="member_form" id="member_form" method="post" action="<?=$page_action?>">
<div style="padding: 25px;">
	<span class="header_title"><?=$manage_title?></span>
	<div style="float: right"><a href="/mybackoffice/member_profile/">กลับสู่หน้าหลัก</a></div>
	<br/><br/>
	<table border="0" cellpadding="5">
		<tr>
			<td>อีเมล</td>
			<td>
				<input type="text" value="<?if(isset($member_email)){ echo $member_email;}?>" name="member_email" id="member_email" size="30px"/>
				<input type="hidden" value="<?=$action_status?>" name="action_status" id="action_status"/>
				<input type="hidden" value="<?if(isset($member_email)){ echo $member_email;}?>" name="member_email_old" id="member_email_old"/>
				</td>
		</tr>
		<? if($action_status=="insert"){?>
		<tr>
			<td>รหัสผ่าน</td>
			<td><input type="password" value="<?if(isset($member_pwd)){ echo base64_decode($member_pwd);}?>" name="member_pwd" id="member_pwd" />
					<input type="button" id="random_pwd" name="random_pwd"  value="Random" onclick="Random_pass()" />
			</td>
		</tr>
		<tr>
			<td>ยืนยันรหัสผ่าน</td>
			<td><input type="password" value="<?if(isset($member_pwd)){ echo base64_decode($member_pwd);}?>" name="member_confirm_pwd" id="member_confirm_pwd" /></td>
		</tr>
		<? } ?>
		<tr>
			<td>ชื่อสมาชิก</td>
			<td><input type="text" value="<?if(isset($member_name)){ echo $member_name;}?>" name="member_name" id="member_name"  size="30px"/></td>
		</tr>
		<tr>
			<td>นามสกุล</td>
			<td><input type="text" value="<?if(isset($member_sname)){ echo $member_sname;}?>" name="member_sname" id="member_sname"  size="30px"/></td>
		</tr>
		<tr>
			<td>เลขประจำตัวประชาชน</td>
			<td><input type="text" value="<?if(isset($member_ssn)){ echo $member_ssn;}?>" name="member_ssn" id="member_ssn" maxlength="13"/></td>
		</tr>
		<tr>
			<td>เพศ</td>
			<td>
						<input type="radio" name="member_gendar" id="member_gendar" value="1" <? if(isset($member_gendar) && ($member_gendar == '1')) echo 'checked' ?> checked>ชาย &nbsp;&nbsp;&nbsp;
						<input type="radio" name="member_gendar" id="member_gendar" value="2" <? if(isset($member_gendar) && $member_gendar == '2') echo 'checked' ?>>หญิง
			</td>
		</tr>
		<tr>
			<td>วันเกิด</td>
			<td>
				<?
					$m_birth = "";
					if(isset($member_birth_date)){
						$birth = explode("-",$member_birth_date);
						$d_birth = $birth[2];
						$m_birth = $birth[1];
						$y_birth = $birth[0];
					}
				?>
					<select id="d_birth" name="d_birth">
						<? for($i=1;$i<=31;$i++){ 
									if ($d_birth == $i){?>
											<option value="<?=$i?>" selected><?=$i?></option>
							  <? }else{?>
											<option value="<?=$i?>"><?=$i?></option>
								<?} }?>
					</select>	
					&nbsp;
					<select id="m_birth" name="m_birth">
						<option value="1" <? if($m_birth == '1') echo 'selected'?>>มกราคม</option>
						<option value="2" <? if($m_birth == '2') echo 'selected'?>>กุมภาพันธ์</option>
						<option value="3" <? if($m_birth == '3') echo 'selected'?>>มีนาคม</option>
						<option value="4" <? if($m_birth == '4') echo 'selected'?>>เมษายน</option>
						<option value="5" <? if($m_birth == '5') echo 'selected'?>>พฤษภาคม</option>
						<option value="6" <? if($m_birth == '6') echo 'selected'?>>มิถุนายน</option>
						<option value="7" <? if($m_birth == '7') echo 'selected'?>>กรกฎาคม</option>
						<option value="8" <? if($m_birth == '8') echo 'selected'?>>สิงหาคม</option>
						<option value="9" <? if($m_birth == '9') echo 'selected'?>>กันยายน</option>
						<option value="10" <? if($m_birth == '10') echo 'selected'?>>ตุลาคม</option>
						<option value="11" <? if($m_birth == '11') echo 'selected'?>>พฤศจิกายน</option>
						<option value="12" <? if($m_birth == '12') echo 'selected'?>>ธันวาคม</option>
					</select>	
					&nbsp;
					<select id="y_birth" name="y_birth">
						<?
						$y_birth = $y_birth + 543; 
						for($i=0;$i<=60;$i++){ 
							 $year =date("Y") + 543-$i;
							 if ($y_birth == $year){?>
											<option value="<?=$year-543;?>" selected><?=$year?></option>
							  <? }else{?>
											<option value="<?=$year-543;?>"><?=$year?></option>
							<?} }?>
					</select>	
			</td>
		</tr>
		<tr>
			<td>เบอร์โทรศัพท์</td>
			<td><input type="text" value="<?if(isset($member_mobile)){ echo $member_mobile;}?>" name="member_mobile" 
									id="member_mobile" maxlength="10"  size="20px"/></td>
		</tr>
		<tr>
			<td valign="top">ที่อยู่</td>
			<td><textarea name="member_address" id="member_address" cols="50" rows="5" /><?if(isset($member_address)){ echo $member_address;}?></textarea></td>
		</tr>
		<tr>
			<td>อำเภอ/เขต</td>
			<td><input type="text" value="<?if(isset($city_name)){ echo $city_name;}?>" name="city_name" id="city_name" /></td>
		</tr>
		<tr>
			<td>จังหวัด</td>
			<td>
				<select id="province_id" name="province_id">
					<option value="">- - - กรุณาเลือกจังหวัด - - -</option>
				<? foreach($tbl_province_data as $data){
						if(isset($province_id) && $province_id == $data["province_id"]){?>	
							<option value="<?=$data["province_id"]?>" selected><?=$data["province_name"]?></option>
				<? 		}else{ ?>
							<option value="<?=$data["province_id"]?>"><?=$data["province_name"]?></option>
				<? 		}
					} ?>
				</select>
			</td>
		</tr>
		<tr>
			<td>รหัสไปรษณีย์</td>
			<td><input type="text" value="<?if(isset($member_zipcode)){ echo $member_zipcode;}?>" name="member_zipcode" id="member_zipcode" maxlength="5"/></td>
		</tr>
		<tr>
			<td>ท่านทราบเว็บไซต์เราจาก</td>
			<td>
				<select name="know_from" id="know_from">
    	  			<option value="">- - - กรุณาระบุข้อมูล - - -</option>
					<option value="1" <?if(isset($know_from) && $know_from == 1){?> selected <?}?>>ทราบจาก โฆษณาบนเฟสบุ๊ค</option>
					<option value="2" <?if(isset($know_from) && $know_from == 2){?> selected <?}?>>ทราบจาก โฆษณาบนเว็บไซต์ต่างๆ</option>
					<option value="3" <?if(isset($know_from) && $know_from == 3){?> selected <?}?>>ทราบจาก เพื่อนแนะนำ</option>
					<option value="4" <?if(isset($know_from) && $know_from == 4){?> selected <?}?>>ทราบจาก อีเมล์จดหมายข่าวแนะนำเว็บไซต์</option>
					<option value="5" <?if(isset($know_from) && $know_from == 5){?> selected <?}?>>ทราบจากเว็บไซต์ www.TheBestDeal1.com</option>
					<option value="6" <?if(isset($know_from) && $know_from == 6){?> selected <?}?>>ทราบจากแฟนเพจ TheBestDeal1</option>
					<option value="7" <?if(isset($know_from) && $know_from == 7){?> selected <?}?>>ค้นหาเจอใน Google.com</option>
					<option value="8" <?if(isset($know_from) && $know_from == 8){?> selected <?}?>>ค้นหาเจอใน  Search Engine อื่นๆ</option>
					<option value="9" <?if(isset($know_from) && $know_from == 9){?> selected <?}?>>ทราบจากโฆษณาบน Google.com</option>
					<option value="10" <?if(isset($know_from) && $know_from == 10){?> selected <?}?>>ทราบจากสื่อโฆษณาทางทีวี</option>
					<option value="11" <?if(isset($know_from) && $know_from == 11){?> selected <?}?>>ทราบจากสื่อโฆษณาทางหนังสือพิมพ์ นิตยสาร</option>
					<option value="12" <?if(isset($know_from) && $know_from == 12){?> selected <?}?>>ทราบจากป้ายโฆษณาตามสถานที่ต่างๆ</option>
    	</select>
    	</td>
		</tr>
		<tr>
			<td>รับข่าวสารทางจากทางเว็ปไซด์</td>
			<td><input type="checkbox" name="subscript_email" id="subscript_email" value="1" <? if((isset($subscript_email) && $subscript_email == '1') || !isset($subscript_email)) echo 'checked';?>>ยอมรับข่าวสารจากทางเว็ปไซด์</td>
		</tr>
		<tr>
			<td>ส่งอีเมล์แจ้งการลงทะเบียนใช้งาน</td>
			<td><input type="checkbox" name="register_email" id="register_email" value="1" <? if((isset($register_email) && $register_email == '1') || !isset($register_email)) echo 'checked';?>>ส่งอีเมล์แจ้งการลงทะเบียนใช้งาน</td>
		</tr>
		<tr>
			<td></td>
			<td><input type="submit" value="บันทึกข้อมูล" /></td>
		</tr>
	</table>
</div>
</form>
<script>
function Random_pass () {
   	var passwd = '';
 	 var chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
  	for (i=1;i<8;i++) {
    	var c = Math.floor(Math.random()*chars.length + 1);
    	passwd += chars.charAt(c)
	 }
	document.getElementById('member_pwd').value = passwd;
	document.getElementById('member_confirm_pwd').value = passwd;
}

  $(document).ready(
  	function(){
    	$("#member_form").validate({
   	rules: {
     member_email: {
     	required:true,
     	email:true,
     	remote: {
        	url: "/mybackoffice/check_email",
        	type: "post",
        	data: {
          		member_email: function() {return $("#member_email").val();},
          		member_email_old: function() {return $("#member_email_old").val();},
				action_status: function() {return $("#action_status").val();}
        	}
      }
     }
      <? if($action_status=="insert"){?>
      // compound rule
     ,member_pwd: {
       required: true,
       minlength: 6
     },
     member_confirm_pwd:
     {
     	required: true,
     	equalTo: "#member_pwd"
     }
     <? } ?>
      ,member_name :{
    	required:true
    }
    ,member_sname :{
		required:true
	}
	,member_ssn :{
		required:true,
		number:true,
		 minlength: 13
	}
	,member_mobile :{
		required:true,
		number:true,
		 minlength: 9
	}
	,member_address :{
		required:true
	}
	,city_name :{
		required:true
	}
	,province_id :{
		required:true
	}
	,member_zipcode :{
		required:true,
		minlength: 5,
		number:true
	},know_from:{
		required:true
	}
   },
   messages: {
    member_email: {
     	required:"กรุณาระบุข้อมูลอีเมลค่ะ",
     	email:"รูปแบบอีเมลไม่ถูกต้องค่ะ",
     	remote: "มีอีเมลดังกล่าวในระบบแล้วค่ะ"
     }
      <? if($action_status=="insert"){?>
     ,member_pwd: {
       required: "กรุณาระบุรหัสผ่านค่ะ",
       minlength:"รหัสผ่านต้องมากกว่า 6 ตัวอักษรค่ะ"
     }
     ,member_confirm_pwd:
     {
     	required:  "กรุณาระบุยื่นยันรหัสผ่านค่ะ",
     	equalTo : "ยื่นยันรหัสผ่านไม่ถูกต้องค่ะ"
     }
     <? }?>
      ,member_name :{
    	required:"กรุณาระบุชื่อสมาชิกค่ะ"
    }
    ,member_sname :{
		required:"กรุณาระบุนามสกุลค่ะ"
	}
	,member_ssn :{
		required:"กรุณาระบุเลขประจำตัวประชาชนค่ะ",
		minlength:"เลขประจำตัวประชาชนต้องมี 13 หลักค่ะ",
		number:"กรุณาระบุเฉพาะตัวเลขค่ะ"
	}
	,member_mobile :{
		required:"กรุณาระบุหมายเลขโทรศัพท์ค่ะ",
		number:"กรุณาระบุเฉพาะตัวเลขค่ะ",
		required:"กรุณาระบุหมายเลขโทรศัพท์ค่ะ",
		minlength:"หมายเลขโทรศัพท์ต้องมากกว่า 9 หลักค่ะ"
	}
	,member_address :{
		required:"กรุณาระบุที่อยู่ค่ะ"
	}
	,city_name :{
		required:"กรุณาระบุเมืองค่ะ"
	}
	,province_id :{
		required:"กรุณาระบุจังหวัดค่ะ"
	}
	,member_zipcode :{
		required:"กรุณาระบุรหัสไปษณีย์ค่ะ",
		minlength:"รหัสไปษณีย์ต้องมี 5 หลักค่ะ",
		number:"กรุณาระบุเฉพาะตัวเลขค่ะ"
		
	},know_from:{
		required:"กรุณาระบุท่านทราบเว็บไซต์เราจาก"
	}
   }
});
  });
</script>