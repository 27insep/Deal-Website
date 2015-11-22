<form name="province_form" id="province_form" method="post" action="<?=$page_action?>">
<div style="padding: 25px;">
	<span class="header_title"><?=$manage_title?></span>
	<div style="float: right"><a href="/mybackoffice/province/">กลับสู่หน้าหลัก</a></div>
	<br/><br/>
	<table border="0" cellpadding="5">
		<tr>
			<td>ชื่อจังหวัด</td>
			<td><input type="text" value="<?if(isset($province_name)){ echo $province_name;}?>" name="province_name" id="province_name" maxlength="50" /></td>
		</tr>
		<tr>
			<td>สถานะ</td>
			<td>
				<select name="province_status" id="province_status">
					<option value="1" <? if(isset($province_status) && $province_status == '1'){echo 'selected';}?>>Active</option>
					<option value="0" <? if(isset($province_status) && $province_status == '0'){echo 'selected';}?>>Not Active</option>
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
    	$("#province_form").validate({
   	rules: {
		province_name :{
		required:true
	}
   },
   messages: {
     province_name :{
    	required:"กรุณาระบุชื่อจังหวัดค่ะ"
    }
   }
});
  });
</script>