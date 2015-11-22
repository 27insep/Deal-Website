<form name="category_sub_form" id="category_sub_form" method="post" action="<?=$page_action?>">
<div style="padding: 25px;">
	<span class="header_title"><?=$manage_title?></span>
	<div style="float: right"><a href="/mybackoffice/iwantit/">กลับสู่หน้าหลัก</a></div>
	<br/><br/>
	<table border="0" cellpadding="5">
		<tr>
			<td>รหัสดีล</td>
			<td><?if(isset($deal_data["deal_id"])) echo $deal_data["deal_id"]; else echo "-";?>
			</td>
		</tr>
		<tr>
			<td>ชื่อดีล</td>
			<td><?if(isset($deal_data["deal_name"])) echo $deal_data["deal_name"]; else echo "-";?>
			</td>
		</tr>
		<tr>
			<td>อีเมล์</td>
			<td><?if(isset($email)){ echo $email;}?></td>
		</tr>
		<tr>
			<td>วันที่แจ้งอยากซื้อ</td>
			<td><?=date_format(date_create($iwantit_create),"d/m/Y H:i:s");?></td>
		</tr>
		<tr>
			<td>วันที่ส่งเมล์แจ้ง</td>
			<td><?if($sendemail_date != "0000-00-00 00:00:00")echo date_format(date_create($sendemail_date),"d/m/Y H:i:s");?></td>
		</tr>
		<tr>
			<td>สถานะการส่งเมล์</td>
			<td>
					<? if(isset($iwantit_status) && $iwantit_status == '1'){?>ส่งแล้ว<?}?>
					<? if(isset($iwantit_status) && $iwantit_status == '0'){?>ยังไม่ส่ง<? }?>
			</td>
		</tr>
	</table>
</div>
</form>