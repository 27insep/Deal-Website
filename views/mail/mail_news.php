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
img{
	border:none;
}
a{
	text-decoration:none;
}
a:hover{
	text-decoration:underline;
}
.bt_view {
	width: 90px;
	height: 37px;
	display: block;
	background: url(http://www.thebestdeal1.com/assets/images/font_view_button.png) center top;
}
.bt_view:hover {
background: url(http://www.thebestdeal1.com/assets/images/font_view_button.png) center bottom;
}
a.txtsub{
	color:#ff481a;
}
a:hover.txtsub{
	text-decoration:underline
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
		<td align="center" width="800" style="padding:20px;">
        <span style="font-size:24px;color:#ff481a">ดีลเด่นวันนี้</span><br /><br />ดีลราคาถูกสุด โรงแรม ที่พัก อาหาร  ท่องเที่ยว อีกมากมาย ราคาถูกใจใช่เลยที่ <a href="http://www.thebestdeal1.com">www.thebestdeal1.com</a><br />
เพิ่มอีเมล news@thebestdeal1.com ไว้ใน contact ของคุณ เพื่อไม่พลาดดีลสุดพิเศษของเรา
 
        </td>
	</tr>
	<tr>
    	<td align="center">
        
        	<table width="95%" cellpadding="0" cellspacing="2">
        		<?php 
        		foreach($deal_set as $deal){
        			$view_link	=	"http://www.thebestdeal1.com/category/deal/".$deal["deal_id"]."/".urlencode($deal["deal_name"]);	
        		?>
            	<tr>
                	<td>
                    <table width="100%" bgcolor="#f8f8f8" cellpadding="5">
                        <tr>
                            <td width="40%" bgcolor="#ffffff">
                            <a href="<?php echo $view_link;?>"><img src="http://www.thebestdeal1.com/assets/images/<?php echo $deal["deal_index_image"]?>" width="300" height="200" /></a>
                            </td>
                            <td width="40%" valign="top" align="left">
                                <span style="font-size:18px;color:#c00000"><a href="<?php echo $view_link;?>"><?php echo $deal["deal_name"]?></a></span><br />
                              	<?php echo $deal["deal_intro"]?>
                            </td>
                            <td width="20%" bgcolor="#f3f3f3">
                                <table width="100%" height="100%" cellpadding="0" cellspacing="5">
                                    <tr>
                                        <td style="border-bottom:1px dashed #999" height="100">
                                        <span style="font-size:16px;color:#ff481a">ราคา <span style="font-size:18px"><?php echo number_format($deal["deal_price_show"])?></span> บาท</span>
                                        <br />
                                        <span style="font-size:18px;">ส่วนลด <?php echo $deal["deal_percent_off"]?>%</span><br /><br />
                                        </td>
                                    </tr>
                                    <tr>
                                        <td align="center" height="80">
                                            <a href="<?php echo $view_link;?>" target="_blank"><img src="http://www.thebestdeal1.com/assets/images/font_view_button_2.png" width="90px" height="37px"/></a>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                    
                    </td>
                </tr>
				<?php }?>
            </table>
            
        </td>
    </tr>
    <tr>
    	<td align="center" style="padding:10px">        	คุณได้รับอีเมลล์ฉบับนี้เนื่องจากคุณได้ทำการลงทะเบียนกับทาง <a href="http://www.thebestdeal1.com">www.TheBestDeal1.com</a><br />
หากประสงค์ไม่ต้องการรับข่าวสารจากทางเรา, <a class="txtsub" href="http://www.thebestdeal1.com/customer/unsubscript/#email_code#">คุณสามารถคลิกยกเลิกได้ตลอดเวลา</a>
<br />
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