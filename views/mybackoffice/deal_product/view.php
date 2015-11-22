<form name="vendor_form" id="vendor_form" method="post" action="<?=$page_action?>">
<div style="padding: 25px;">
	<span class="header_title"><?=$manage_title?></span>
	<div style="float: right"><a href="/mybackoffice/deal_product/">กลับสู่หน้าหลัก</a></div>
	<br/><br/>
	<table border="0" cellpadding="5" cellspacing="1" class="tb_form">
		<tr>
			<td class="tb_H">ชื่อร้านค้า</td>
			<td><?if(isset($vendor_name)){ echo $vendor_name;}?></td>
		</tr>
		<tr>
			<td class="tb_H">ดีลหลัก</td>
			<td><?if(isset($deal_name)){ echo $deal_name;}?></td>
		</tr>
		<tr>
			<td class="tb_H">ชื่อแคมเปญ</td>
			<td><?if(isset($product_name)){ echo $product_name;}?></td>
		</tr>
		<tr>
			<td class="tb_H">รายละเอียดแคมเปญ</td>
			<td><?if(isset($product_detail)){ echo $product_detail;}?></td>
		</tr>
		<tr>
			<td class="tb_H">ราคาปกติ</td>
			<td><?if(isset($product_price)){ echo $product_price;}else{echo "0";}?> &nbsp;&nbsp;บาท</td>
		</tr>
		<tr>
			<td class="tb_H">ราคาเดอะเบสดีลวัน</td>
			<td><?if(isset($product_total_price)){ echo $product_total_price;}else{echo "0";}?> &nbsp;&nbsp;บาท</td>
		</tr>
		<tr>
			<td valign="top" class="tb_H">ภาษี</td>
			<td><?if(isset($product_include_vat)){if($product_include_vat==7)echo "รวมภาษี  7%  แล้ว"; else echo "ยังไม่รวมภาษี";}?></td>
		</tr>
		<tr>
			<td class="tb_H">ส่วนลด (%)</td>
			<td><?if(isset($product_discount_per)){ echo $product_discount_per;}else{echo "0";}?></td>
		</tr>
		<tr>
			<td class="tb_H">จำนวนคูปองทั้งหมด</td>
			<td><?if(isset($product_in_store)){ echo $product_in_store;}else{echo "0";}?></td>
		</tr>
		<tr>
			<td class="tb_H">สามารถซื้อได้ต่อคน</td>
			<td><?if(isset($product_limit)){ echo $product_limit;}else{echo "0";}?></td>
		</tr>
		<tr>
			<td class="tb_H">เดอะเบสดีล MDR (%)</td>
			<td><?if(isset($product_mrd)){ echo $product_mrd;}?></td>
		</tr>
		<tr>
			<td class="tb_H">สถานะ</td>
			<td>
					<? if(isset($product_status) && $product_status == '1'){?>เปิดการใช้งาน<?}?>
					<? if(isset($product_status) && $product_status == '0'){?>หยุดชั่วคราว<? }?>
					<? if(isset($product_status) && $product_status == '2'){?>คูปองหมด<? }?>
			</td>
		</tr>
	</table>
</div>
</form>