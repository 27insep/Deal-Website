<style>
table
{
border-collapse:collapse;
}
table, td, th
{
border:1px solid black;
}
</style>
<h2>Voucher list</h2>
	<table cellpadding="0" cellspacing="0" border="1" class="display" id="show_data" width="770px">
		<thead style="font-size: 12px;">
			<th align="center">ลำดับ</th>
			<th>เลขที่คูปอง</th>
			<th>บาร์โค๊ด</th>
			<th>รหัสลูกค้า</th>
			<th>ชื่อ-นามสกุล</th>
			<th>วันที่ใช้</th>
			<th>status</th>
			<th>สถานะการใช้</th>
		</thead>
		<? 
		$i=0;
		foreach($coupon_data as $data){?>
		<tr style="font-size: 12px;">
			<td align="center"><?=++$i?></td>
			<td align="center"><?=$data["voucher_number"]?></td>
			<td align="center"><?=$data["barcode"]?></td>
			<td align="center"><?=$data["member_id"]?></td>
			<td width="150px"  align="center"><?=$data["member_name"]." ".$data["member_sname"]?></td>
			<td align="center"><?=$data["coupon_use_date"]!=""?date("d/m/Y",strtotime($data["coupon_use_date"])):"";?></td>
			<td align="center"><?=$data["coupon_status"]?></td>
			<td align="center">
			<? if($data["coupon_status"]==2){?>
					USED
			<?}else{?>
					NOT USED
			<?}?>
			</td>
		</tr>
		<? } ?>
	</table>
	<div style="width: 770px;font-size: 0.5em;padding: 10px 0;text-align: right;">
		<a href="javascript:window.print();">Print this document</a>
	</div>