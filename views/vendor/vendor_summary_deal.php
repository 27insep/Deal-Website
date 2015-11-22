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
<div id="vender_deal_box">
<div id="explore2excel"><a href="/vendor/export_excel/<?=$total["deal_id"]?>/<?=$total["product_key"]?>/" target="_bllank"><!--|| ส่งออกไฟล์ Excel ||--></a></div>

<div class="clear" style="width:740px">
	<div style="margin:0 0 10px; clear: both;"><span>ชื่อแคมเปญ : &nbsp;</span> <?=$total["product_name"]?></div>
	 <div><span>รวมเป็นจำนวนเงิน : &nbsp;</span><?=number_format($total_summary,2,".",",")?>  	บาท</div>
    <div class="clear"><span>วันที่กำหนดเริ่มขาย : &nbsp;</span><?if(isset($total["round_start"])) echo $this->convert_date->show_thai_date($total["round_start"]); else echo "-";?></div>
    <div><span>เดอะเบสดีล MDR(%)/คูปอง : </span><?=number_format($total["product_mrd"],2,".",",")?>  %</div>
    <div class="clear"><span>วันที่กำหนดปิดการขาย : &nbsp;</span><?if(isset($total["round_end"])) echo $this->convert_date->show_thai_date($total["round_end"]); else echo "-";?></div>
    <div><span>คอมมิชชั่นเดอะเบสดีล : &nbsp;</span><?=number_format($commission_bestdeal,2,".",",")?>  	บาท</div>
    <div class="clear"><span>วันเริ่มใช้คูปอง : &nbsp;</span><?if(isset($total["deal_start"])) echo $this->convert_date->show_thai_date($total["deal_start"]); else echo "-";?></div>
	<div><span>Vat 7% (คอมมิชชั่นเดอะเบสดีล) :  &nbsp;</span><?=number_format($commision_vat,2,".",",")?>  	บาท</div>
    <div class="clear"><span>วันหมดอายุคูปอง : &nbsp;</span><?if(isset($total["deal_expile"])) echo $this->convert_date->show_thai_date($total["deal_expile"]); else echo "-";?></div>
    <div><span>รวมค่าตอบแทนเดอะเบสดีล : &nbsp;</span><?=number_format($you_revenues,2,".",",")?>  	บาท</div>
    <div class="clear"><span>ราคาปกติ รวม Vat แล้ว : &nbsp;</span><?=number_format($total["price_include_vat"],2,".",",")?>  	บาท</div>
    <div><span>ร้านค้าได้ : &nbsp;</span><?=number_format($vendor_revenues,2,".",",")?>  	บาท</div>
    <div class="clear"><span>ราคาเดอะเบสดีล : &nbsp;</span><?=number_format($total["product_total_price"],2,".",",")?>  	บาท</div>
    <div><span>ร้านค้า WHT3%  : &nbsp;</span><?=number_format($wht,2,".",",")?>  	บาท</div>
    <div class="clear"><span>จำนวนที่ขายคูปอง : &nbsp;</span><?=$nCoupon?></div>
    <div><span>รวมยอดร้านค้าได้  : &nbsp;</span><?=number_format($vendor_sum,2,".",",")?>  	บาท</div>
</div>
<div id="show_deal"><a href="/category/deal/<?=$total["deal_id"]?>/<?=$total["deal_name"]?>/" target="_bllank"><!--|| ดูข้อมูลดีล ||--></a></div>
</div>
<br>
<?}}?>
