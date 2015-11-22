<div class="menu_add_box">
	<a href="/mybackoffice/user_admin/insert_form">เพิ่มข้อมูล</a>
</div>
<div>
	<table cellpadding="0" cellspacing="1" border="0" class="display" id="show_data" width="100%">
		<thead>
			<th width="50px">ลำดับ</th>
			<th width="50px">Username</th>
			<th width="100px">ชื่อ-นามสกุล</th>
			<th width="30px">วันที่เพิ่มข้อมูล</th>
			<th width="30px">วันที่แก้ไขข้อมูล</th>
			<th width="30px">สถานะ</th>
			<th width="100px">เครื่องมือ</th>
		</thead>
		<? 
		$i 		=	0;
		foreach($tbl_admin as $data){?>
			<tr>
				<td align="center"><?=++$i?></td>
				<td align="left"><?=$data["admin_user"]?></td>
				<td align="center"><?=$data["admin_name"]?></td>
				<td align="center"><?=date("d/m/Y H:i:s",strtotime($data["admin_create"]));?></td>
				<td align="center"><?=date("d/m/Y H:i:s",strtotime($data["admin_modify"]));?></td>
				<td align="center">
					   	<?if($data["admin_status"]==1){
					   			echo image_asset('/icon/active.png', '', array('alt'=>'active','title'=>'active'));
							}else{
								echo image_asset('/icon/inactive.png', '', array('alt'=>'not active','title'=>'not active'));
							}
						?>		
					   	</td>
				<td align="center">
					<a href="/mybackoffice/user_admin/view_data/<?=$data["admin_id"]?>"><?=image_asset('/icon/info.png', '', array('alt'=>'รายละเอียด','title'=>'รายละเอียด'));?></a> |
					<a href="/mybackoffice/user_admin/update_form/<?=$data["admin_id"]?>"><?=image_asset('/icon/edit.png', '', array('alt'=>'แก้ไข','title'=>'แก้ไข'));?></a> |
					<a href="/mybackoffice/user_admin/delete/<?=$data["admin_id"]?>" onclick="if(confirm('ต้องการลบข้อมูลผู้ใช้งานระบบ  ใช่หรือไม่ ?')){return true;}else{return false;};">
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

    function delete_data(row_id,add_text)
	{
		if(confirm('ต้องการลบข้อมูลมาชิก  '+add_text))
		{
			$.ajax({
	  			type: "POST",
	  			url: '/mybackoffice/member_profile/delete/'+row_id
				}).done(function( msg ) {
						alert("ทำการลบข้อมูลเรียบร้อยแล้วค่ะ !");
						oTable.fnDeleteRow(document.getElementById("row_"+row_id));
						//window.location.href='/mybackoffice/member_profile/';
						return true;
			});	
			}else{
				return false;
			}
	}
</script>