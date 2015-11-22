<form name="province_form" id="province_form" method="post" action="<?=$page_action?>">
<div style="padding: 25px;">
	<span class="header_title"><?=$manage_title?></span>
	<div style="float: right"><a href="/mybackoffice/province/">กลับสู่หน้าหลัก</a></div>
	<br/><br/>
	<table border="0" cellpadding="5">
		<tr>
			<td>ชื่อจังหวัด</td>
			<td><?if(isset($province_name)){ echo $province_name;}?></td>
		</tr>
		<tr>
			<td>สถานะ</td>
			<td>
					<? if(isset($province_status) && $province_status == '1'){?>Active<?}?>
					<? if(isset($province_status) && $province_status == '0'){?>Not Active<? }?>
			</td>
		</tr>
	</table>
</div>
</form>