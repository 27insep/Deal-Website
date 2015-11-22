<form name="category_sub_form" id="category_sub_form" method="post" action="<?=$page_action?>">
<div style="padding: 25px;">
	<span class="header_title"><?=$manage_title?></span>
	<div style="float: right"><a href="/mybackoffice/category_sub/">กลับสู่หน้าหลัก</a></div>
	<br/><br/>
	<table border="0" cellpadding="5">
		<tr>
			<td>ชื่อหมวดการดีลย่อย</td>
			<td><input type="text" value="<?if(isset($sub_cat_name)){ echo $sub_cat_name;}?>" name="sub_cat_name" id="sub_cat_name"/></td>
		</tr>
		<tr>
			<td>ดีลหลัก</td>
			<td>
				<select id="cat_id" name="cat_id">
					<option value="">- - - กรุณาเลือกหมวดการดีลหลัก - - -</option>
				<? foreach($tbl_category_main as $data){
						if(isset($cat_id) && $cat_id == $data["cat_id"]){?>	
							<option value="<?=$data["cat_id"]?>" selected><?=$data["cat_name"]?></option>
				<? 		}else{ ?>
							<option value="<?=$data["cat_id"]?>"><?=$data["cat_name"]?></option>
				<? 		}
					} ?>
				</select>
			</td>
		</tr>
		<tr>
			<td>สถานะ</td>
			<td>
				<select name="sub_cat_status" id="sub_cat_status">
					<option value="1" <? if(isset($sub_cat_status) && $sub_cat_status == '1'){echo 'selected';}?>>Active</option>
					<option value="0" <? if(isset($sub_cat_status) && $sub_cat_status == '0'){echo 'selected';}?>>Not Active</option>
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
    	$("#category_sub_form").validate({
   	rules: {
	sub_cat_name :{
		required:true
	}
	,cat_id :{
		required:true
	}
   },
   messages: {
     sub_cat_name :{
    	required:"กรุณาระบุชื่อหมวดการดีลย่อยค่ะ"
    }
	,cat_id :{
		required:"กรุณาระบุหมวดการดีลหลักค่ะ"
	}
   }
});
  });
</script>