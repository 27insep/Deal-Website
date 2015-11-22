<form name="iwantit_form" id="iwantit_form" method="post" action="<?=$page_action?>">
<div style="padding: 25px;">
	<span class="header_title"><?=$manage_title?></span>
	<div style="float: right"><a href="/mybackoffice/iwantit/">กลับสู่หน้าหลัก</a></div>
	<br/><br/>
	<table border="0" cellpadding="5">
		<tr>
			<td>อีเมล์</td>
			<td><input type="text" value="<?if(isset($email)){ echo $email;}?>" name="email" id="email"/></td>
		</tr>
		<tr>
			<td>ดีล</td>
			<td>
				<select id="deal_id" name="deal_id">
					<option value="">- - - กรุณาเลือกหมวดการดีล - - -</option>
				<? foreach($tbl_deal_main as $data){
						if(isset($deal_id) && $deal_id == $data["deal_id"]){?>	
							<option value="<?=$data["deal_id"]?>" selected><?=$data["deal_name"]?></option>
				<? 		}else{ ?>
							<option value="<?=$data["deal_id"]?>"><?=$data["deal_name"]?></option>
				<? 		}
					} ?>
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
    	$("#iwantit_form").validate({
   	rules: {
   		email: {
     	required:true,
     	email:true,
     },
     deal_id :{
		required:true
	}
   },
   messages: {
     email: {
     	required:"กรุณาระบุข้อมูลอีเมลค่ะ",
     	email:"รูปแบบอีเมลไม่ถูกต้องค่ะ",
     },
     deal_id :{
		required:"กรุณาเลือกดีล"
	}
   }
});
  });
</script>