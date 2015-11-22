<form name="vendor_form" id="vendor_form" method="post" action="<?=$page_action?>">
<div style="padding: 25px;">
	<span class="header_title"><?=$manage_title?></span>
	<div style="float: right"><a href="/mybackoffice/vendor_profile/">กลับสู่หน้าหลัก</a></div>
	<br/><br/>
	<table border="0" cellpadding="5" cellspacing="1" class="tb_form" width="800">
		<tr>
			<td class="tb_H" width="100">อีเมล</td>
			<td><?if(isset($vendor_email)){ echo $vendor_email;}?></td>
		</tr>
		<tr>
			<td class="tb_H">รหัสผ่าน</td>
			<td><?if(isset($vendor_pwd)){ echo base64_decode($vendor_pwd);}?></td>
		</tr>
		<tr>
			<td class="tb_H">ชื่อร้านขายดีล</td>
			<td><?if(isset($vendor_name)){ echo $vendor_name;}?></td>
		</tr>
		<tr>
			<td class="tb_H">ชื่อผู้ติดต่อ</td>
			<td><?if(isset($vendor_contact_fname)){ echo $vendor_contact_fname;}?></td>
		</tr>
		<tr>
			<td class="tb_H">นามสกุลผู้ติดต่อ</td>
			<td><?if(isset($vendor_contact_sname)){ echo $vendor_contact_sname;}?></td>
		</tr>
		<tr>
			<td valign="top" class="tb_H">ที่อยู่</td>
			<td width="350px"><?if(isset($vendor_address)){ echo $vendor_address;}?></td>
		</tr>
		<tr>
			<td class="tb_H">เว็บไซต์</td>
			<td><?if(isset($vendor_website)){ echo $vendor_website;}?></td>
		</tr>
		<tr>
			<td class="tb_H">โลโก้ร้านค้า</td>
			<td>
				<?if(isset($vendor_logo)){ ?>
					<img src="/assets/images/<?=$vendor_logo?>" width="200" height="65"/>
					<br/>
				<? } ?>
			</td>
		</tr>
		<tr>
			<td class="tb_H">แผนที่ร้านค้า</td>
			<td>
				<?if(isset($vendor_map)){ ?>
					<img src="/assets/images/<?=$vendor_map?>" width="550" height="400"/>
				<? } ?>
			</td>
		</tr>
		<tr>
			<td class="tb_H" valign="top">เกี่ยวกับร้านค้า</td>
			<td><?if(isset($vendor_about_us)){ echo $vendor_about_us;}?></td>
		</tr>
		<tr>
			<td class="tb_H">สถานะ</td>
			<td>
					<? if(isset($vendor_status) && $vendor_status == '1'){?>Active<?}?>
					<? if(isset($vendor_status) && $vendor_status == '0'){?>Not Active<? }?>
			</td>
		</tr>
		<tr>
			<td class="tb_H">การจ่ายรายได้</td>
			<td>
					<? if(isset($vendor_pay_type) && $vendor_pay_type == '1'){?>หมดเขตการขายดีล 7 วัน โอนให้ 50% และ  หมดเขตการคูปอง 7 วัน โอนให้ 50%<?}?>
					<? if(isset($vendor_pay_type) && $vendor_pay_type == '2'){?>หมดเขตการขายดีล 7 วัน โอนให้ 70% และ หมดเขตการคูปอง 7 วัน โอนให้ 30%<?}?>
					<? if(isset($vendor_pay_type) && $vendor_pay_type == '3'){?>หมดเขตการขายดีล 20 วัน โอนให้ 100%<?}?>
			</td>
		</tr>
		<? if($admin_type!=3){?>
		<tr>
			<td class="tb_H">พนักงานขาย</td>
			<td>
					<? foreach($admin_data as $data){?>
						<? if(isset($admin_id) && $admin_id == $data["admin_id"]){echo $data["admin_name"];}?>
					<? } ?>
			</td>
		</tr>
		<?}?>
		<tr>
			<td valign="top" class="tb_H">บันทึกช่วยจำ</td>
			<td><?if(isset($vendor_memo)){ echo $vendor_memo;}?></td>
		</tr>
	</table>
</div>
</form>