<form name="category_form" id="category_form" method="post" action="<?=$page_action?>">
<div style="padding: 25px;">
	<span class="header_title"><?=$manage_title?></span>
	<div style="float: right"><a href="/mybackoffice/category/">กลับสู่หน้าหลัก</a></div>
	<br/><br/>
	<table border="0" cellpadding="5">
		<tr>
			<td>ชื่อหมวดการดีล</td>
			<td><input type="text" value="<?if(isset($cat_name)){ echo $cat_name;}?>" name="cat_name" id="cat_name"/></td>
		</tr>
		<tr>
			<td>สถานะ</td>
			<td>
				<select name="cat_status" id="cat_status">
					<option value="1" <? if(isset($cat_status) && $cat_status == '1'){echo 'selected';}?>>Active</option>
					<option value="0" <? if(isset($cat_status) && $cat_status == '0'){echo 'selected';}?>>Not Active</option>
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
    	$("#category_form").validate({
   	rules: {
	cat_name :{
		required:true
	}
   },
   messages: {
	cat_name :{
		required:"กรุณาระบุชื่อหมวดการดีลค่ะ"
	}
   }
});
  });
</script>