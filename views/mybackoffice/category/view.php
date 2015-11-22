<form name="category_form" id="category_form" method="post" action="<?=$page_action?>">
<div style="padding: 25px;">
	<span class="header_title"><?=$manage_title?></span>
	<div style="float: right"><a href="/mybackoffice/category/">กลับสู่หน้าหลัก</a></div>
	<br/><br/>
	<table border="0" cellpadding="5">
		<tr>
			<td>ชื่อหมวดการดีล</td>
			<td><?if(isset($cat_name)){ echo $cat_name;}?></td>
		</tr>
		<tr>
			<td>สถานะ</td>
			<td>
					<? if(isset($cat_status) && $cat_status == '1'){?>Active<?}?>
					<? if(isset($cat_status) && $cat_status == '0'){?>Not Active<? }?>
			</td>
		</tr>
	</table>
</div>
</form>