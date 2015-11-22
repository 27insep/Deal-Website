<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns:fb="http://ogp.me/ns/fb#">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Thebestdeal1 : แบบฟอร์มการชำระเงิน</title>
	<!-- get css -->
	<? foreach($stylesheets as $stylesheet): ?>
  		<?= css_asset($stylesheet); ?>    
	<? endforeach; ?>
</head>
<body>
<div id="form_payment_main">
	<div id="form_payment_logo">
		<div><?echo image_asset('company_logo.png', '');?></div>
		<div><?echo image_asset('logo_lotus.jpg', '');?></div>
	</div>
	<div class="clear">
		แบบฟอร์มชำระเงินด้านล่างนี้จะถูกส่งไปยังอีเมลของคุณ กรุณาพิมพ์หน้านี้เพื่อนำไปใช้ชำระเงินผ่าน Tesco Lotus ทุกสาขา กรุณาชำระด้วยเงินสด ค่าบริการ 7 บาทต่อครั้ง
	</div>
	<div id="form_payment_barcode">
		<?echo image_asset('ex_barcode.jpg', '');?>
		<div>
			<table border="0" width="95%" align="center">
				<tr>
					<td align="left" width="125px">รหัสอ้างอิง :</td>
					<td align="left"><?=$order["ref_code"]?></td>
				</tr>
				<tr>
					<td align="left">ราคารวม :</td>
					<td align="left"><?=number_format($order["order_summary"])?> บาท</td>
				</tr>
			</table>	
		</div>
	</div>
	<div class="clear" style="border-bottom: 1px dashed #333333;padding: 0 0 10px 0;">
		กรุณาชำระเงินผ่าน Tesco Lotus ภายในวันที่ <?=date("d m Y",(time()+(60*60*24)))?> หลังจากนั้นท่านจะไม่สามารถใช้แบบฟอร์มนี้ได้
	</div>
	<div id="form_payment_footer">
		ทาง Thebestdeal1.com จะทำการออกคูปองให้ลูกค้าที่ทำการชำระเงินผ่าน Tesco Lotus ภายใน 1 - 2 วัน โดยนับจากเวลาที่ทำการชำระเงินแล้วเสร็จ ลูกค้าจะได้รับอีเมลเพื่อแจ้งให้ทราบเมื่อระบบทำการออกคูปองให้เรียบร้อยแล้ว 
		<div>
		<table border="1" width="65%" align="center" cellpadding="0" cellspacing="0" bordercolor="#AAAAAA">
				<tr>
					<td align="left">เลขที่ใบสั่งขาย :</td>
					<td align="left"><?=$order["order_id"]?></td>
				</tr>
				<tr>
					<td align="left">วันที่สั่งซื้อ :</td>
					<td align="left"><?=date("d/m/Y",strtotime($order["order_date"]))?></td>
				</tr>
				<tr>
					<td align="left">รหัสร้านค้า :</td>
					<td align="left"><?=number_format($order["order_summary"])?> บาท</td>
				</tr>
				<tr>
					<td align="left" valign="top">รายละเอียด :</td>
					<td align="left"><? foreach($order_detail as $item){	echo $item["product_name"]."<br/>"; }?></td>
				</tr>
			</table>
		</div>	
		ดูข้อมูลเพิ่มเติมการชำระเงินผ่านทาง Tesco Lotus ได้ที่นี้<br/>
		<a href="www.thebestdealone.local/home/payment" target="_blank">www.thebestdealone.local/home/payment</a>
	</div>
	<div align="center">
		<input type="button"  value="พิมพ์หน้านี้" onclick="print_page()" style="cursor: pointer;" />
	</div>
</div>
<script>
	function print_page()
	{
		window.print();
	}
</script>
</body>
</html>