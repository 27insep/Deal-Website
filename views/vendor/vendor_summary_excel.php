<?php
header("Content-Type: application/vnd.ms-excel");
header('Content-Disposition: attachment; filename="สรุปรายได้ของสินค้า.xls"');# ชื่อไฟล์ 
?>
<html xmlns:o="urn:schemas-microsoft-com:office:office"
xmlns:x="urn:schemas-microsoft-com:office:excel"
xmlns="http://www.w3.org/TR/REC-html40">
<HTML>
<HEAD>
<meta http-equiv="Content-type" content="text/html;charset=tis-620" />
</HEAD>

<BODY>
<?if(sizeof($total_sale["sell_coupon"])>0){?>
<?foreach($total_sale["sell_coupon"] as $total){?>
	<?
		$nCoupon = "";
		foreach($total_sale["nCoupon"] as $coupon){
			if($total["product_key"] == $coupon["product_key"])
				$nCoupon = $coupon["n"];
	}?>
<?
	$total_summary =  $nCoupon * $total["sell_price"];
	$commission_bestdeal		=	($total_summary*$total["product_mrd"])/100;
	$commision_vat	=	$commission_bestdeal*0.07;
	$you_revenues	=	$commission_bestdeal+$commision_vat;
	$vendor_revenues	=	$total_summary-$you_revenues;
	$wht = $commission_bestdeal * 0.03;
	$vendor_sum = $vendor_revenues + $wht;
?>
<table>
	<tr>
		<td align="right">ชื่อแคมเปญ : </td>
		<td><?=$total["product_name"]?></td>
		<td  align="right">รวมเป็นจำนวนเงิน : </td>
		<td><?=number_format($total_summary,2,".",",")?>  	บาท</td>
	</tr>
	<tr>
		<td  align="right" width="500px">วันที่กำหนดเริ่มขาย : </td>
		<td><?if(isset($total["round_start"])) echo $this->convert_date->show_thai_date($total["round_start"]); else echo "-";?></td>
		<td align="right">เดอะเบสดีล MDR(%)/คูปอง : </td>
		<td><?=number_format($total["product_mrd"],2,".",",")?>  %</td>
	</tr>
	<tr>
		<td align="right">วันที่กำหนดปิดการขาย : </td>
		<td><?if(isset($total["round_end"])) echo $this->convert_date->show_thai_date($total["round_end"]); else echo "-";?></td>
		<td align="right">คอมมิชชั่นเดอะเบสดีล : </td>
		<td><?=number_format($commission_bestdeal,2,".",",")?></td>
	</tr>
	<tr>
		<td align="right">วันเริ่มใช้คูปอง : </td>
		<td><?if(isset($total["deal_start"])) echo $this->convert_date->show_thai_date($total["deal_start"]); else echo "-";?></td>
		<td align="right">Vat 7% (คอมมิชชั่นเดอะเบสดีล) :  </td>
		<td><?=number_format($commision_vat,2,".",",")?>  	บาท</td>
	</tr>
	<tr>
		<td align="right">วันหมดอายุคูปอง : </td>
		<td><?if(isset($total["deal_expile"])) echo $this->convert_date->show_thai_date($total["deal_expile"]); else echo "-";?></td>
		<td align="right">รวมค่าตอบแทนเดอะเบสดีล : </td>
		<td><?=number_format($you_revenues,2,".",",")?>  	บาท</td>
	</tr>
	<tr>
		<td align="right">ราคาปกติ รวม Vat แล้ว : </td>
		<td><?=number_format($total["price_include_vat"],2,".",",")?>  	บาท</td>
		<td align="right">ร้านค้าได้ : </td>
		<td><?=number_format($vendor_revenues,2,".",",")?>  	บาท</td>
	</tr>
	<tr>
		<td align="right">ราคาเดอะเบสดีล : </td>
		<td><?=number_format($total["product_total_price"],2,".",",")?>  	บาท</td>
		<td align="right">ร้านค้า WHT3%  : </td>
		<td><?=number_format($wht,2,".",",")?>  	บาท</td>
	</tr>
	<tr>
		<td align="right">จำนวนที่ขายคูปอง : </td>
		<td align="left"><?=$nCoupon?></td>
		<td align="right">รวมยอดร้านค้าได้  : </td>
		<td><?=number_format($vendor_sum,2,".",",")?>  	บาท</td>
	</tr>
</table>
<?}}?>

</BODY>
</HTML>