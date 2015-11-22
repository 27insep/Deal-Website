<form name="category_sub_form" id="category_sub_form" method="post" action="<?=$page_action?>">
<div style="padding: 25px;">
	<span class="header_title"><?=$manage_title?></span>
	<div style="float: right"><a href="/mybackoffice/category_sub/">กลับสู่หน้าหลัก</a></div>
	<br/><br/>
	<table border="0" cellpadding="5">
		<tr>
			<td>ชื่อหมวดการดีลย่อย</td>
			<td><?if(isset($sub_cat_name)){ echo $sub_cat_name;}?></td>
		</tr>
		<tr>
			<td>หมวดการดีลหลัก</td>
			<td><?if(isset($cat_data["cat_name"])) echo $cat_data["cat_name"]; else echo "-";?>
			</td>
		</tr>
		<tr>
			<td>สถานะ</td>
			<td>
					<? if(isset($sub_cat_status) && $sub_cat_status == '1'){?>Active<?}?>
					<? if(isset($sub_cat_status) && $sub_cat_status == '0'){?>Not Active<? }?>
			</td>
		</tr>
	</table>
</div>
</form>