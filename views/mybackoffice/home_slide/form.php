<?php echo form_open_multipart($page_action,array('id' => 'home_slide_form','name'=>'home_slide_form','method'=>'post'));?>
<div style="margin: 25px;">
	<? if($action=="insert"){?>
		<span class="header_title">เพิ่มรูปภาพโปรโมชั่น</span>
	<?}else{?>
		<span class="header_title">แก้ไขรูปภาพโปรโมชั่น</span>
	<?}?>
	<div style="float: right"><a href="/mybackoffice/home_slide/">กลับสู่หน้าหลัก</a></div>
	<br/><br/><br/>
	<div>
	<table border="0" cellpadding="5">
		<tr>
			<td width="200px" align="right" valign="top" ">รูปภาพที่</td>
			<td>
				<? if(isset($pic_path)){?>
					<img src="/assets/images/<?=$pic_path?>" width="1024" height="400" />
				<?}?>
				<br/>
				<input type="file" name="pic_path" id="pic_path" size="44" /><span style="color: #FF0000;"><br/>ขนาดรูปภาพที่เหมาะสม กว้าง 1024px สูง 400px</span>
			</td>
		</tr>
		<tr>
			<td align="right">URL</td>
			<td>
				<input type="text" value="<?if(isset($promotion_link)){ echo $promotion_link;}?>" id="promotion_link" name="promotion_link" size="50"/>
			</td>
		</tr>
		<tr>
			<td align="right">หัวข้อ</td>
			<td>
				<input type="text" value="<?if(isset($promotion_name)){ echo $promotion_name;}?>" id="promotion_name" name="promotion_name" size="50"/>
			</td>
		</tr>
		<tr>
			<td align="right" valign="top">รายละเอียด</td>
			<td>
					<textarea rows="5" cols="80" name="promotion_detail" id="promotion_detail"><?if(isset($promotion_detail)){ echo $promotion_detail;}?></textarea>
			</td>
		</tr>
		<tr>
			<td align="right">ลำดับ</td>
			<td>
				<input type="text"  value="<?if(isset($pic_order)){ echo $pic_order;}?>" name="pic_order" id="pic_order" size="3"/>
			</td>
		</tr>
		<tr>
			<td align="right">สถานะ</td>
			<td>
				<input type="radio" name="promotion_status" id="promotion_status" value="1" <?if(!isset($promotion_status)||$promotion_status==1){ ?> checked="checked" <?}?> /> แสดง
				<input type="radio" name="promotion_status" id="promotion_status"  value="0" <?if(isset($promotion_status)&&$promotion_status==0){ ?>checked="checked" <?}?>/> ไม่แสดง
			</td>
		</tr>
		<tr>
			<td></td>
			<td><input name="submit" id="submit" type="submit" value="บันทึกข้อมูล" /></td>
		</tr>
	</table>
	</div>
</form>
</div>
<script>
  $(document).ready(
  	<? if($action=="insert"){?>
  	function(){
    	$("#home_slide_form").validate({
   	rules: {
	pic_path :{
		required:true
	}
   },
   messages: {
	pic_path :{
		required:"กรุณาเลือกรูปภาพค่ะ"
	}
   }
});
<?}?>
  });
</script>