<form name="free_ads_form" id="free_ads_form" method="post" action="<?=$page_action?>">
<div style="padding: 25px;">
	<span class="header_title"><?=$manage_title?></span>
	<div style="float: right"><a href="/mybackoffice/free_ads/">กลับสู่หน้าหลัก</a></div>
	<br/><br/>
	<table border="0" cellpadding="5">
		<tr>
			<td>ชื่อธุรกิจ/ร้านค้า/บริษัท</td>
			<td><input type="text" value="<?if(isset($vendor_name)){ echo $vendor_name;}?>" name="vendor_name" id="vendor_name"/></td>
		</tr>
		<tr>
			<td>ชื่อ-นามสกุล</td>
			<td><input type="text" value="<?if(isset($contact_name)){ echo $contact_name;}?>" name="contact_name" id="contact_name"/></td>
		</tr>
		<tr>
			<td>เว็บไซต์ http://</td>
			<td><input type="text" value="<?if(isset($website)){ echo $website;}?>" name="website" id="website"/></td>
		</tr>
		<tr>
			<td>อีเมล์</td>
			<td><input type="text" value="<?if(isset($contact_email)){ echo $contact_email;}?>" name="contact_email" id="contact_email"/></td>
		</tr>
		<tr>
			<td>เบอร์โทรศัพท์</td>
			<td><input type="text" value="<?if(isset($contact_phone)){ echo $contact_phone;}?>" name="contact_phone" id="contact_phone"/></td>
		</tr>
		<tr>
			<td>สถานะ</td>
			<td>
				<input type="radio" name="contact_status" id="contact_status" value="1" <?if(!isset($contact_status)||$contact_status==1){ ?> checked="checked" <?}?>/> ติดต่อแล้ว
				<input type="radio" name="contact_status" id="contact_status" value="0" <?if(isset($contact_status)&&$contact_status==0){ ?>checked="checked" <?}?>/> ยังไม่ได้ติดต่อ
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
    	$("#free_ads_form").validate({
   	rules: {
   		contact_email: {
     	required:true,
     	email:true,
     }
     ,vendor_name :{
		required:true
	}
	 ,contact_name :{
		required:true
	}
	 ,contact_phone :{
		required:true
	}
   },
   messages: {
     contact_email: {
     	required:"กรุณาระบุข้อมูลอีเมลค่ะ",
     	email:"รูปแบบอีเมลไม่ถูกต้องค่ะ",
     }
     ,vendor_name :{
		required:"กรุณาระบุข้อมูลชื่อธุรกิจ/ร้านค้า/บริษัท"
	}
	,contact_name :{
		required:"กรุณาระบุข้อมูลชื่อ-นามสกุล"
	}
	,contact_phone :{
		required:"กรุณาระบุข้อมูลเบอร์โทรศัพท์"
	}
   }
});
  });
</script>