<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<style>
body{
	margin:0;
	padding:0;
	font-family:Tahoma, Geneva, sans-serif;
	font-size:12px;
	color:#333;
}
a{
	text-decoration:none;
}
a:hover{
	text-decoration:underline;
}
.tb_pay th{
	background-color:#333;
	color:#fff;
}
.tb_pay td{
	background-color:#fff;
	color:#333;
}
</style>
</head>
<body>
<!-- Save for Web Slices (mail_payment.jpg) -->
<table width="800" border="0" cellpadding="0" cellspacing="0" style="margin:0 auto">
	<tr>
		<td>
			<img src="http://www.thebestdeal1.com/assets/images/email/mail_payment_01.jpg" width="800" height="162" alt=""></td>
	</tr>
	<tr>
		<td width="800" style="padding:20px;">
        <span style="font-size:24px;color:#ff481a">สวัสดีค่ะคุณ <?=$order["member"]["member_name"]." ".$order["member"]["member_sname"];?>,</span><br /><br /> 
        ขณะนี้คูปองของท่านเสร็จเรียบร้อยแล้วท่านสามารถเข้าชมและพิมพ์ออกได้ โดยการ <a href="http://www.thebestdeal1.com/member/my_coupon" style="color:#0050ff">คลิ๊กที่นี้</a><br />

		เลขที่ใบเสร็จ/ใบแจ้งการชำระเงิน #<?=$order["order"]["receipt_id"]?> ของใบสั่งซื้อเลขที่ #<?=$order["order"]["order_id"]?><br /><br/>
        <b>วิธีการชำระเงิน :</b><br />
		<?=$payment?><br /> 
        </td>
	</tr>
	<tr>
		<td width="800" style="padding:20px;">
        	<b style="color:#0050ff">รายการสั่งซื้อสินค้า</b><br /><br />
        	<table width="700" cellpadding="10" cellspacing="1" border="0" class="tb_pay" bgcolor="#CCCCCC">
            	<tr>
                	<th align="left">ชื่อสินค้า</th>
                    <th align="center">ราคา</th>
                    <th align="center">จำนวน</th>
                    <th align="center">ราคารวม</th>
                </tr>
                <? foreach($order["order_detail"] as $item){?>
                <tr>
                	<td align="left"><b style="color:#ff481a"><?=$item["deal_name"]?>  # <?=$item["product_name"]?></b></td>
                    <td align="center">฿<?=number_format($item["product_total_price"])?></td>
                    <td align="center"><?=number_format($item["product_qty"])?></td>
                    <td align="center">฿<?=number_format($item["product_total_price"]*$item["product_qty"])?></td>
                </tr>
                <? } ?>
                <tr>
                	<td colspan="3" align="right"><b>รวมทั้งหมด</b></td>
                    <td align="center"><b>฿<?=number_format($order["order"]["order_summary"])?></b></td>
                </tr>
            </table>
            <br />หากคุณมีคำถามหรือข้อสงสัยใดๆ สามารถติดต่อเราได้ที่ info@thebestdeal1.com หรือที่หมายเลขโทรศัพท์. 02-938-4399   แฟกซ์  02-938-4399<br /><br />
            ขอบพระคุณค่ะ,<br />
			<span style="font-size:20px;color:#ff481a">ทีมงาน TheBestDeal1.com</span>
        </td>
	</tr>
	<tr>
		<td><img src="http://www.thebestdeal1.com/assets/images/email/mail_payment_05.jpg" width="800" height="14" alt=""></td>
	</tr>
	<tr>
		<td width="800">
        	<table width="800" border="0" cellpadding="0" cellspacing="0">
                <tr>
                    <td>
                        <img src="http://www.thebestdeal1.com/assets/images/email/mail_payment_09_01.jpg" width="460" height="111" alt=""></td>
                    <td width="340" height="111" style="background:#fe4819;color:#fff;"><b style="font-size:14px;">บริษัท เดอะเบสดีลวัน จำกัด</b><br />
                      <span style="font-size:12px;">ที่อยู่ : เลขที่  12/14  ปากทางลาดพร้าว <br />
                      (ซอย MRT พหลโยธินทางออกที่2) <br/>
                      แขวงจอมพล เขตจตุจักร กรุงเทพฯ  10900 <br /></span>
                      <span style="font-size:14px">------------------------------------------------------</span><br />
                      <b style="font-size:14px;">โทรศัพท์. 02-938-4399   แฟกซ์  02-938-4399</b>
                    </td>
                </tr>
            </table>
        </td>
	</tr>
    <tr>
    	<td>
        	<table width="800" height="50" border="0" cellpadding="0" cellspacing="0" style="background:#000; color:#fff;">
            	<tr>
                	<td width="535" style="padding:0 20px;font-weight:bold">© 2013, THE BEST DEAL.CO,LTD. All Rights Reserved.</td>
                    <td width="75" align="right">Visit Us :  </td>
                    <td width="190" align="right" valign="middle" style="padding:0 20px 0 0;">
                    <a href="https://www.facebook.com/TheBestDeal1"><img src="http://www.thebestdeal1.com/assets/images/email/facebook_logo.png" width="32" height="32" alt="" style="border:0"></a>&nbsp;
                    <a href="https://twitter.com/HOTEL_BUFFETS/"><img src="http://www.thebestdeal1.com/assets/images/email/twitter_logo.png" width="32" height="32" alt="" style="border:0"></a>&nbsp;
                    <a href="http://instagram.com/thebestdeal2555?ref=badge"><img src="http://www.thebestdeal1.com/assets/images/email/instagram_logo.png" width="32" height="32" alt="" style="border:0"></a>&nbsp;
                    <a href="https://www.youtube.com/user/TheBestDeal1"><img src="http://www.thebestdeal1.com/assets/images/email/youtube_logo.png" width="32" height="32" alt="" style="border:0"></a>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
<!-- End Save for Web Slices -->
</body>
</html>