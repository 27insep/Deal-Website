<div class="menu_add_box">
	<a href="/mybackoffice/province/insert_form">เพิ่มข้อมูล</a>
</div>
<div>
	<table cellpadding="0" cellspacing="1" border="0" class="display" id="show_data" width="100%">
		<thead>
			<th width="10px">ลำดับ</th>
			<th width="400px" align="left">ชื่อจังหวัด</th>
			<th width="10px">สถานะ</th>
			<th width="150px">เครื่องมือ</th>
		</thead>
		<? 
		$i 		=	0;
		foreach($tbl_province_data as $data){?>
			<tr>
				<td align="center"><?=++$i?></td>
				<td align="left"><?=$data["province_name"]?></td>
				<td align="center">
			   	<?if($data["province_status"]==1){
			   			echo image_asset('/icon/active.png', '', array('alt'=>'active','title'=>'active'));
					}else{
						echo image_asset('/icon/inactive.png', '', array('alt'=>'not active','title'=>'not active'));
					}
				?>		
			   	</td>
				<td align="center">
					<a href="/mybackoffice/province/view_data/<?=$data["province_id"]?>"><?=image_asset('/icon/info.png', '', array('alt'=>'รายละเอียด','title'=>'รายละเอียด'));?></a> |
					<a href="/mybackoffice/province/update_form/<?=$data["province_id"]?>"><?=image_asset('/icon/edit.png', '', array('alt'=>'แก้ไข','title'=>'แก้ไข'));?></a> |
					<a href="/mybackoffice/province/delete/<?=$data["province_id"]?>" onclick="if(confirm('ต้องการลบข้อมูลจังหวัด<?=$data["province_name"]?> ?')){return true;}else{return false;};">
							<?=image_asset('/icon/delete.png', '', array('alt'=>'ลบข้อมูล','title'=>'ลบข้อมูล'));?>
					</a>
				</td>
			</tr>
		<? } ?>
	</table>
</div>
<script type="text/javascript" charset="utf-8">
$(document).ready(function() {
		$('#show_data').dataTable();
});
</script>