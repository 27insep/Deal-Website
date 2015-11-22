<div class="menu_add_box">
	<a href="/mybackoffice/category/insert_form">เพิ่มข้อมูล</a>
</div>
<div>
	<table cellpadding="0" cellspacing="1" border="0" class="display" id="show_data" width="100%">
		<thead>
			<th width="10px">ลำดับ</th>
			<th width="450px" align="left">ชื่อหมวดการดีล</th>
			<th width="20px">สถานะ</th>
			<th width="120px">เครื่องมือ</th>
		</thead>
		<? 
		$i 		=	0;
		foreach($tbl_category_main as $data){?>
			<tr>
				<td align="center"><?=++$i?></td>
				<td align="left"><?=$data["cat_name"]?></td>
				<td align="center">
			   	<?if($data["cat_status"]==1){
			   			echo image_asset('/icon/active.png', '', array('alt'=>'active','title'=>'active'));
					}else{
						echo image_asset('/icon/inactive.png', '', array('alt'=>'not active','title'=>'not active'));
					}
				?>		
			   	</td>
				<td align="center">
					<a href="/mybackoffice/category/view_data/<?=$data["cat_id"]?>"><?=image_asset('/icon/info.png', '', array('alt'=>'รายละเอียด','title'=>'รายละเอียด'));?></a> |
					<a href="/mybackoffice/category/update_form/<?=$data["cat_id"]?>"><?=image_asset('/icon/edit.png', '', array('alt'=>'แก้ไข','title'=>'แก้ไข'));?></a> |
					<a href="/mybackoffice/category/delete/<?=$data["cat_id"]?>" onclick="if(confirm('ต้องการลบข้อมูลหมวดการดีล<?=$data["cat_name"]?> ?')){return true;}else{return false;};">
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