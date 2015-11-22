<?
				function thai_date($time)
				{
					    global $thai_month_arr;  
						
						$thai_month_arr=array(  
							    "0"=>"",  
							    "1"=>"มกราคม",  
							    "2"=>"กุมภาพันธ์",  
							    "3"=>"มีนาคม",  
							    "4"=>"เมษายน",  
							    "5"=>"พฤษภาคม",  
							    "6"=>"มิถุนายน",   
							    "7"=>"กรกฎาคม",  
							    "8"=>"สิงหาคม",  
							    "9"=>"กันยายน",  
							    "10"=>"ตุลาคม",  
							    "11"=>"พฤศจิกายน",  
							    "12"=>"ธันวาคม"                    
						);  
				
					    $thai_date_return=  "&nbsp;".date("j",$time);  
					    $thai_date_return.= "&nbsp;".$thai_month_arr[date("n",$time)];  
					    $thai_date_return.= "&nbsp;".(date("Y",$time)+543);  
					    return $thai_date_return;  
				}  
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns:fb="http://ogp.me/ns/fb#">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Thebestdeal1 : แบบฟอร์มการชำระเงิน</title>
	<style>
		body
		{
			font-size: 0.8em;
		}
	</style>
</head>
<body>
	<?
		$nNumber	=	str_replace(".","",$order["order_summary"]);
		
		$fill_zero	=	8-strlen($nNumber);
		
		for($i=0;$i<$fill_zero;$i++)
		{
			$nNumber	=	"0".$nNumber;
		}
		
		$lotus_barcode	=	"010555518039901".$order["order_id"].$member_id.date("dmY",strtotime($order["order_date"])+((60*60*24)*7)).$nNumber;
	?>

<table width="700" cellpadding="0" cellspacing="0" border="0" style="padding:25px;border:15px solid #333333">
	<tr>
    	<td>
        	<table width="700" cellpadding="0" cellspacing="0" border="0" style="padding-bottom:15px;">
            	<tr>
                	<td align="left"><?echo image_asset('company_logo.png', '');?></td>
                    <td align="right"><?echo image_asset('logo_lotus.jpg', '');?></td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
    	<td>
        	แบบฟอร์มชำระเงินด้านล่างนี้จะถูกส่งไปยังอีเมลของคุณ กรุณาพิมพ์หน้านี้เพื่อนำไปใช้ชำระเงินผ่าน Tesco Lotus ทุกสาขา กรุณาชำระด้วยเงินสด ค่าบริการ 7 บาทต่อครั้ง
        </td>
    </tr>
    <tr>
    	<td>&nbsp;</td>
    </tr>
    <tr>
    	<td>
        	<table border="0" width="100%" style="padding:15px; border:1px solid #333; ">
            	<tr>
                	<td align="center">
                    <img src="http://www.barcodesinc.com/generator/image.php?code=<?=$lotus_barcode?>&style=164&type=C128B&width=300&height=65&xres=1&font=2"/>
                	</td>
                </tr>
                <tr>
                	<td>
                    	<table cellpadding="0" cellspacing="0" width="95%" border="0" align="center">
                        <tr>
                            <td align="left" width="150px">รหัสอ้างอิง :</td>
                            <td align="left"> <?=$lotus_barcode?></td>
                        </tr>
                        <tr>
                            <td align="left">ราคารวม :</td>
                            <td align="left"> <?=number_format($order["order_summary"])?> บาท</td>
                        </tr>
                        </table>
                    </td>
                </tr>
				
			</table>
        </td>
    </tr>
    <tr>
    	<td>&nbsp;</td>
    </tr>
    <tr>
    	<td>
        	<table border="0" width="100%" align="center" cellpadding="0" cellspacing="0" style="border-bottom: 1px dashed #333333;padding: 0 0 10px 0;">
            	<tr>
					<td align="left">กรุณาชำระเงินผ่าน Tesco Lotus ภายในวันที่ <?=thai_date(strtotime($order["order_date"])+((60*60*24)*7))?> หลังจากนั้นท่านจะไม่สามารถใช้แบบฟอร์มนี้ได้</td>
				</tr>
			</table>
        </td>
    </tr>
    <tr>
    	<td>
        	<table cellpadding="0" cellspacing="0" border="0" style="padding:15px 0 0">
            	<tr>
                	<td>ทาง Thebestdeal1.com จะทำการออกคูปองให้ลูกค้าที่ทำการชำระเงินผ่าน Tesco Lotus ภายใน 1 - 2 วัน โดยนับจากเวลาที่ทำการชำระเงินแล้วเสร็จ ลูกค้าจะได้รับอีเมลเพื่อแจ้งให้ทราบเมื่อระบบทำการออกคูปองให้เรียบร้อยแล้ว </td>
                </tr>
                <tr><td>&nbsp;</td></tr>
                <tr>
                	<td>
                    	<table border="1" width="80%" align="center" cellpadding="0" cellspacing="0" bordercolor="#AAAAAA">
                            <tr>
                                <td align="left">เลขที่ใบสั่งขาย :</td>
                                <td align="left">&nbsp;<?=$order["order_id"]?></td>
                            </tr>
                            <tr>
                                <td align="left">วันที่สั่งซื้อ :</td>
                                <td align="left"><?=thai_date(strtotime($order["order_date"]))?></td>
                            </tr>
                            <? foreach($order_detail as $item){?>
                            <tr>
                                <td align="left">รหัสร้านค้า :</td>
                                <td align="left">&nbsp;<?echo $item["vendor_id"]; ?></td>
                            </tr>
                            <tr>
                                <td align="left" valign="top">รายละเอียด :</td>
                                <td align="left">&nbsp;<?echo $item["product_name"];?></td>
                            </tr>
                            <? }?>
                        </table>
                    </td>
                </tr>
                <tr><td>&nbsp;</td></tr>
                <tr>
                	<td>ดูข้อมูลเพิ่มเติมการชำระเงินผ่านทาง Tesco Lotus ได้ที่นี้<a href="http://www.thebestdeal1.com/home/howtopay" target="_blank">http://www.thebestdeal1.com/home/howtopay</a></td>
                </tr>
            </table>
        </td>
    </tr>
    <tr><td>&nbsp;</td></tr>
    <tr>
    	<td align="center"><a href="http://www.thebestdeal1.com/shopping/payment_form/3/<?=$order["order_id"]?>/1"><input id="print_button" type="button"  value="พิมพ์หน้านี้" style="cursor: pointer;font-size: 1em;padding: 5px;" /></a></td>
    </tr>
</table>
</body>
</html>