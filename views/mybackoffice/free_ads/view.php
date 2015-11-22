<div style="padding: 25px;">
	<span class="header_title"><?=$manage_title?></span>
	<div style="float: right"><a href="/mybackoffice/free_ads/">กลับสู่หน้าหลัก</a></div>
	<br/><br/>
	<table border="0" cellpadding="5">
		<tr>
			<td>ชื่อธุรกิจ/ร้านค้า/บริษัท</td>
			<td><?if(isset($vendor_name)){ echo $vendor_name;}?></td>
		</tr>
		<tr>
			<td>ชื่อ-นามสกุล</td>
			<td><?if(isset($contact_name)){ echo $contact_name;}?></td>
		</tr>
		<tr>
			<td>เว็บไซต์ http://</td>
			<td><?if(isset($website)){ echo $website;}?></td>
		</tr>
		<tr>
			<td>อีเมล์</td>
			<td><?if(isset($contact_email)){ echo $contact_email;}?></td>
		</tr>
		<tr>
			<td>เบอร์โทรศัพท์</td>
			<td><?if(isset($contact_phone)){ echo $contact_phone;}?></td>
		</tr>
		<tr>
			<td>สถานะ</td>
			<td>
				<?if(!isset($contact_status)||$contact_status==1){ ?> แสดง <?}?>
				<?if(isset($contact_status)&&$contact_status==0){ ?> ไม่แสดง <?}?>
			</td>
		</tr>
	</table>
</div>