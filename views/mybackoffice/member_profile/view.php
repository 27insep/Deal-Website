<script type="text/javascript" src="/assets/js/jquery.printElement.min.js"></script>
<form name="member_form" id="member_form" method="post" action="<?=$page_action?>">
<div style="padding: 25px;">
	<span class="header_title"><?=$manage_title?></span>
	<div style="float: right">
			<a href="/mybackoffice/member_profile/view_data/<?=$member_id?>">โปรไฟล์</a>&nbsp;&nbsp;&nbsp;
			<a href="/mybackoffice/deal_order/main/0/0/<?=$member_id?>/4">คำสั่งซื้อ</a>&nbsp;&nbsp;&nbsp;
			<a href="/mybackoffice/coupon_manage/main/0/<?=$member_id?>/4">คูปอง</a>&nbsp;&nbsp;&nbsp;
			<a href="#" onclick="print_page()">พิมพ์</a>&nbsp;&nbsp;&nbsp;
			<a href="/mybackoffice/member_profile/">กลับสู่หน้าหลัก</a>
	</div>
	<br/><br/>
	<div id="print_view">
	<table border="0" cellpadding="5">
		<tr>
			<td>อีเมล</td>
			<td><?if(isset($member_email)){ echo $member_email;}?></td>
		</tr>
		<tr>
			<td>รหัสผ่าน</td>
			<td><?if(isset($member_pwd)){ echo base64_decode($member_pwd);}?></td>
		</tr>
		<tr>
			<td>ชื่อสมาชิก</td>
			<td><?if(isset($member_name)){ echo $member_name;}?></td>
		</tr>
		<tr>
			<td>นามสกุล</td>
			<td><?if(isset($member_sname)){ echo $member_sname;}?></td>
		</tr>
		<tr>
			<td>เลขประจำตัวประชาชน</td>
			<td><?if(isset($member_ssn)){ echo $member_ssn;}?></td>
		</tr>
		<tr>
			<td>เพศ</td>
			<td><?if(isset($member_gendar)){if($member_gendar == '1') echo "ชาย"; else echo "หญิง";}?>	</td>
		</tr>
		<tr>
			<td>วันเกิด</td>
			<td><?if(isset($member_birth_date)&&!empty($member_ssn)){echo $birth_day;}?>	</td>
		</tr>
		<tr>
			<td>อายุ</td>
			<td><?if(isset($age)&&!empty($member_ssn)){echo $age;}?></td>
		</tr>
		<tr>
			<td>เบอร์โทรศัพท์</td>
			<td><?if(isset($member_mobile)){ echo $member_mobile;}?></td>
		</tr>
		<tr>
			<td valign="top">ที่อยู่</td>
			<td width="350px"><?if(isset($member_address)){ echo $member_address;}?></td>
		</tr>
		<tr>
			<td>อำเภอ/เขต</td>
			<td><?if(isset($city_name)){ echo $city_name;}?></td>
		</tr>
		<tr>
			<td>จังหวัด</td>
			<td><?if(isset($province_data["province_name"])) echo $province_data["province_name"]; else echo "-";?></td>
		</tr>
		<tr>
			<td>รหัสไปรษณีย์</td>
			<td><?if(isset($member_zipcode)){ echo $member_zipcode;}?></td>
		</tr>
		<tr>
			<td>วันที่สมัคร</td>
			<td><?if(isset($member_regis_time)){echo date_format(date_create($member_regis_time),"d/m/Y H:i:s");}?>	</td>
		</tr>
		<tr>
			<td>วันที่แก้ไข</td>
			<td><?if(isset($member_update_time)){echo date_format(date_create($member_update_time),"d/m/Y H:i:s");}?>	</td>
		</tr>
		<tr>
			<td>ท่านทราบเว็บไซต์เราจาก</td>
			<td>
					<?if(isset($know_from) && $know_from == 1){?>ทราบจาก โฆษณาบนเฟสบุ๊ค<?}?>
					<?if(isset($know_from) && $know_from == 2){?>ทราบจาก โฆษณาบนเว็บไซต์ต่างๆ<?}?>
					<?if(isset($know_from) && $know_from == 3){?>ทราบจาก เพื่อนแนะนำ<?}?>
					<?if(isset($know_from) && $know_from == 4){?>ทราบจาก อีเมล์จดหมายข่าวแนะนำเว็บไซต์<?}?>
					<?if(isset($know_from) && $know_from == 5){?>ทราบจากเว็บไซต์ www.TheBestDeal1.com<?}?>
					<?if(isset($know_from) && $know_from == 6){?>ทราบจากแฟนเพจ TheBestDeal1<?}?>
					<?if(isset($know_from) && $know_from == 7){?>ค้นหาเจอใน Google.com<?}?>
					<?if(isset($know_from) && $know_from == 8){?>ค้นหาเจอใน  Search Engine อื่นๆ<?}?>
					<?if(isset($know_from) && $know_from == 9){?>ทราบจากโฆษณาบน Google.com<?}?>
					<?if(isset($know_from) && $know_from == 10){?>ทราบจากสื่อโฆษณาทางทีวี<?}?>
					<?if(isset($know_from) && $know_from == 11){?>ทราบจากสื่อโฆษณาทางหนังสือพิมพ์ นิตยสาร<?}?>
					<?if(isset($know_from) && $know_from == 12){?>ทราบจากป้ายโฆษณาตามสถานที่ต่างๆ<?}?>
    	</td>
		</tr>
		<tr>
			<td>รับข่าวสารทาง Email</td>
			<td><?if(isset($subscript_email) && $member_update_time == 0){echo "ไม่รับข่าวสาร";}else echo "รับข่าวสาร";?>	</td>
		</tr>
		<tr>
			<td colspan="2">
				<div class="menu_add_box">
					<a href="/mybackoffice/member_profile/update_form/<?=$member_id?>">แก้ไขข้อมูล</a>
				</div></td>
	</table>
	</div>
</div>
</form>
<script>
	function print_page()
	{
		$("#print_view").printElement();
	}
</script>