<?php echo form_open_multipart($page_action,array('id' => 'deal_gallery_form','name'=>'deal_gallery_form','method'=>'post'));?>
<div style="margin: 25px;">
	<span class="header_title">เพิ่มรูปภาพของดีล : <?echo $deal_name;?></span>
	<div style="float: right"><a href="/mybackoffice/deal_gallery/<?=$deal_id?>">กลับสู่หน้าหลัก</a></div>
	<br/><br/><br/>
	<div align="center">
	<table border="0" cellpadding="5">
		<? for($i=0;$i<10;$i++){?>
		<tr>
			<td>รูปภาพที่ <? echo ($i+1); ?></td>
			<td>
				<input type="file" name="gallary_image_<?echo ($i+1);?>" id="gallary_image_<?echo ($i+1);?>" size="44" /><span style="color: #FF0000;"> ขนาดรูปภาพที่เหมาะสม กว้าง 625px สูง 345px</span>
			</td>
		</tr>
		<? } ?>
		<tr>
			<td></td>
			<td><input name="submit" id="submit" type="submit" value="บันทึกข้อมูล" /></td>
		</tr>
	</table>
	</div>
</form>
</div>