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
p{
	margin:0;
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
        <span style="font-size:24px;color:#ff481a">เรียน  <?=$vendor_name?></span><br /><br /> 
        <span style="color:#ff481a">TheBestDeal1.com</span> มีความยินดีที่จะแจ้งให้ทราบว่าทางทีมงานได้สร้างระบบ  Merchant Dashboard เพื่อใช้ตรวจสอบการสั่งซื้อคูปอง 
 <!--รวมถึงได้แนบเอกสารตัวอย่างของคูปอง ที่ลูกค้าจะนำไปใช้--> เราพร้อมสร้างสรรค์สิ่งใหม่ๆอยู่เสมอ เพื่อการพัฒนาการบริการให้ดีขึ้น เรายินดีรับข้อเสนอแนะเพิ่มเติมจากคุณ 
และขอขอบคุณสำหรับความไว้วางใจในการร่วมงานกับ <span style="color:#ff481a">TheBestDeal1</span>
<br />
        </td>
	</tr>
    <tr>
    	<td align="center">
        	<span style="font-size:18px;color:#ff481a">Merchant Dashboard</span><br />
            <table width="750" cellpadding="10" cellspacing="1" border="0" bgcolor="#f8f8f8">
            	<tr>
                	<td width="113" bgcolor="#ff481a" style="color:#fff;font-weight:bold" align="right">Username :</td>
                  <td width="107"><?=$vendor_email?></td>
                  <td width="227" align="right" bgcolor="#FFFFFF"><b>วันที่เปิด-ปิดขายดีล :</b></td>
                    <td width="218" bgcolor="#FFFFFF"> <?=$this->convert_date->show_thai_date($round_start)?> – <?=$this->convert_date->show_thai_date($round_end)?></td>
                </tr>
                <tr>
                	<td width="113" bgcolor="#ff481a" style="color:#fff;font-weight:bold" align="right">Password :</td>
                  <td width="107"><?=$vendor_pwd?></td>
                  <td align="right" bgcolor="#FFFFFF"><b>วันเริ่มต้น-สิ้นสุดการใช้ Voucher(คูปอง) :</b></td>
                    <td bgcolor="#FFFFFF"> <?=$this->convert_date->show_thai_date($deal_start)?> –  <?=$this->convert_date->show_thai_date($deal_expile)?></td>
                </tr>
                <tr>
                	<td width="113" bgcolor="#ff481a" style="color:#fff;font-weight:bold" align="right">หมายเลขร้านค้า :</td>
                  <td width="107"><?=$vendor_id?></td>
                  <td align="right" bgcolor="#FFFFFF"><b>ลิงค์สำหรับใช้งาน  :</b></td>
                    <td bgcolor="#FFFFFF"><a href="http://www.thebestdeal1.com/vendor/">http://www.thebestdeal1.com/vendor/</a></td>
                </tr>
            </table><br />
        </td>
    </tr>
    <tr>
    	<td style="padding-left:25px;font-size:11px">
			<b style="color:#F00">ข้อแนะนำเพิ่มเติม</b>
			<br />
            <span>
            1. เก็บ Voucher(คูปอง) ไว้ และให้ลูกค้าลงลายเซ็นต์เพื่อเป็นหลักฐาน
            <br />
            2. ชี้แจงพนักงานของท่าน เกี่ยวกับรายละเอียดของโปรโมชั่นอย่างครบถ้วน
            <br />
            3. ดูแลลูกค้า <span style="color:#ff481a">TheBestDeal1 </span>ตามมาตรฐานของทางร้าน เพื่อสร้างความประทับใจและสร้างความรู้สึกให้อยากกลับไปใช้ซ้ำ
            <br />
            4. จัดเตรียมคู่สายโทรศัพท์และเจ้าหน้าที่อย่างเพียงพอ เพื่อรองรับการติดต่อและการนัดหมายล่วงหน้าจากลูกค้า
            <br />
            5. ตอบคำถามของลูกค้าใน TheBestDeal1 Merchant Dashboard  ซึ่งเป็นช่องทางในการติดต่อสื่อสารกับลูกค้าจำนวนมากในคราวเดียว
            <br />
            6. เก็บใบเสร็จของร้านค้า แนบกับ Voucher(คูปอง) เพื่อเป็นประโยชน์ในการวิเคราะห์ข้อมูลทางการตลาดในอนาคต 
			</span>
      </td>
    </tr>
	<tr>
		<td width="800" style="padding:25px;">
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