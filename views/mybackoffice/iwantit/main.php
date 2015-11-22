<div class="menu_add_box">
	<a href="/mybackoffice/iwantit/insert_form">เพิ่มข้อมูล</a>
</div>
<div>
	<table cellpadding="0" cellspacing="1" border="0" class="display" id="show_data" width="100%">
		<thead>
			<th width="10px">ลำดับ</th>
			<th width="50px" align="left">รหัสดีล</th>
			<th width="250px" align="left">ชื่อดีล</th>
			<th width="200px" align="left">อีเมล์</th>
			<th width="150px" align="center">วันที่แจ้งอยากซื้อ</th>
			<th width="150px" align="center">วันที่ส่งเมล์แจ้ง</th>
			<th width="150px">สถานะการส่งเมล์</th>
			<th width="120px">เครื่องมือ</th>
		</thead>
		<? 
		$i 		=	0;
		foreach($tbl_iwantit as $data){?>
			<tr>
				<td align="center"><?=++$i?></td>
				<td align="center"><?=$data["deal_id"]?></td>
				<td align="left"><?=$data["deal_name"]?></td>
				<td align="left"><?=$data["email"]?></td>
				<td align="center"><?=date_format(date_create($data["iwantit_create"]),"d/m/Y H:i:s");?></td>
				<td align="center"><?if($data["sendemail_date"] != "0000-00-00 00:00:00")echo date_format(date_create($data["sendemail_date"]),"d/m/Y H:i:s");?></td>
				<td align="center">
			   	<?if($data["iwantit_status"]==1){
			   			echo"ส่งแล้ว";
					}else{
						echo"ยังไม่ส่ง";
					}
				?>		
			   	</td>
				<td align="center">
					<a href="/mybackoffice/iwantit/view_data/<?=$data["iwantit_id"]?>"><?=image_asset('/icon/info.png', '', array('alt'=>'รายละเอียด','title'=>'รายละเอียด'));?></a> |
					<a href="/mybackoffice/iwantit/update_form/<?=$data["iwantit_id"]?>"><?=image_asset('/icon/edit.png', '', array('alt'=>'แก้ไข','title'=>'แก้ไข'));?></a> |
					<a href="/mybackoffice/iwantit/delete/<?=$data["iwantit_id"]?>" onclick="if(confirm('ต้องการลบข้อมูลผู้ที่ต้องการดีล  ใช่หรือไม่ ?')){return true;}else{return false;};">
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