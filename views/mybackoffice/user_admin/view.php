<form name="member_form" id="member_form" method="post" action="<?=$page_action?>">
<div style="padding: 25px;">
	<span class="header_title"><?=$manage_title?></span>
	<br/><br/>
	<table border="0" cellpadding="5">
		<tr>
			<td>Username</td>
			<td><?if(isset($admin_user)){ echo $admin_user;}?></td>
		</tr>
		<tr>
			<td>Password</td>
			<td><?if(isset($admn_pwd)){ echo base64_decode($admn_pwd);}?></td>
		</tr>
		<tr>
			<td>ชื่อผู้ดูแลระบบ</td>
			<td><?if(isset($admin_name)){ echo $admin_name;}?></td>
		</tr>
		<tr>
			<td>วันที่เพิ่มข้อมูล</td>
			<td><?if(isset($admin_create)){ echo date("d/m/Y H:i:s",strtotime($admin_create));}?></td>
		</tr>
		<tr>
			<td>วันที่แก้ไขข้อมูล</td>
			<td><?if(isset($admin_modify)){ echo date("d/m/Y H:i:s",strtotime($admin_modify));}?></td>
		</tr>
		<tr>
			<td>สถานะ</td>
			<td>
					<? if(isset($admin_status) && $admin_status == '1'){?>Active<?}?>
					<? if(isset($admin_status) && $admin_status == '0'){?>Not Active<? }?>
			</td>
		</tr>
		<tr>
			<td colspan="2">
				<div class="menu_add_box">
					<a href="/mybackoffice/user_admin/update_form/<?=$admin_id?>">แก้ไขข้อมูล</a>
				</div>
			</td>
		</tr>
	</table>
</div>
</form>