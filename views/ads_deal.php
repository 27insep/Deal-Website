<div id="main_inner">
    <div id="main_inner_header">
        <h3>โฆษณา กับ เดอะ เบสท์ ดีล ฟรี</h3>
    </div>
    
    <div id="main_inner_body_other">
    <form id="free_ads_form" name="free_ads_form" method="post" action="/home/save_free_ads">
    	<table id="Table_01" width="910" border="0" cellpadding="0" cellspacing="0">
            <tr>
                <td>
                	<img src="/assets/images/ads_deal_01.jpg"  width="910" height="312" alt=""/>
                </td>
            </tr>
            <tr>
                <td width="910" height="320" background="/assets/images/ads_deal_02.jpg">
                	<div style="width:480px ;height:320px; background:#fff;margin:0 0 0 37px">
                		<iframe width="480" height="320" src="http://www.youtube.com/embed/nmhL8aDZBm0?autoplay=1" frameborder="0" allowfullscreen></iframe>
                    </div>
                </td>
            </tr>
            <tr>
                <td>
                    <img src="/assets/images/ads_deal_03.jpg" width="910" height="164" alt=""></td>
            </tr>
            <tr>
                <td width="910" height="305" background="/assets/images/ads_deal_04.jpg" valign="middle">
                	<div style="width:480px ;height:305px;margin:0 0 0 45px">
                    	<table width="90%" align="center" cellpadding="5" cellspacing="5" border="0" style="font-size:14px">
                        	<tr>
                            	<td align="right" style="padding:5px">ชื่อธุรกิจ/ร้านค้า/บริษัท</td>
                              <td align="left" style="padding:5px"><input type="text" class="textbox" name="vendor_name" id="vendor_name"/></td>
                            </tr>
                            <tr>
                            	<td align="right" style="padding:5px">ชื่อ-นามสกุล</td>
                              <td align="left" style="padding:5px"><input type="text" class="textbox" name="contact_name" id="contact_name"/></td>
                            </tr>
                            <tr>
                            	<td align="right" style="padding:5px">เว็บไซต์ http://</td>
                              <td align="left" style="padding:5px"><input type="text" class="textbox" name="website" id="website"/></td>
                            </tr>
                            <tr>
                            	<td align="right" style="padding:5px">อีเมล์</td>
                              <td align="left" style="padding:5px"><input type="text" class="textbox" name="contact_email" id="contact_email"/></td>
                            </tr>
                            <tr>
                            	<td align="right" style="padding:5px">โทรศัพท์</td>
                              <td align="left" style="padding:5px"><input type="text" class="textbox" name="contact_phone" id="contact_phone"/></td>
                            </tr>
                            <tr>
                            	<td align="right" style="padding:5px;font-size:11px">พิมพ์ตัวอักษรที่แสดงในภาพ<br /><?=$capcha?></td>
                              	<td align="left" style="padding:5px;font-size:11px"><input type="text" class="textbox" name="capcha" id="capcha"/></td>
                            </tr>
                            <tr>
                            	<td align="right" style="padding:5px"><input type="submit" class="orange_button" value="บันทึก" style="border:0;width:100px;height:39px;border-radius:5px" /></td>
                                <td align="left" style="padding:5px"><input type="reset" class="orange_button" value="ยกเลิก" style="border:0;width:100px;height:39px;border-radius:5px" /></td>
                            </tr>
                        </table>
                    </div>
                </td>
            </tr>
            <tr>
                <td>
                    <img src="/assets/images/ads_deal_05.jpg" width="910" height="231" alt=""></td>
            </tr>
            <tr>
                <td>
                    <img src="/assets/images/ads_deal_06.jpg" width="910" height="758" alt=""></td>
            </tr>
            <tr>
                <td>
                    <img src="/assets/images/ads_deal_07.jpg" width="910" height="71" alt=""></td>
            </tr>
        </table>
        </form>
    </div>
</div>
<script type="text/javascript">
 	$(document).ready(function() {  
 		function do_save_free_ads(responseText, statusText, xhr, $form)
 		{
 			if(responseText!=1)
 			{
 				$( "#dialog" ).html(responseText);
 				$( "#dialog" ).dialog({ title: "แจ้งเตือน" });
 			}else{
 				$( "#dialog" ).html("ได้รับข้อมูลเรียบร้อยแล้วค่ะ <br/>ทางเราจะรีบดำเนินการติดต่อกลับ <br/>เพื่อเป็นพันธมิตรทางธุรกิจกันค่ะ <br/>ขอบคุณค่ะ");
 				$( "#dialog" ).dialog(
 					{ 	
 						title: "ข้อความ", 
 						close: function( event, ui ) 
 						{
 							window.location.href	=	"/";
 						}
 					}
 				);
 			}
 		}
 		$('#free_ads_form').ajaxForm(
 			{ 	
 				success: do_save_free_ads
 			} 
 		); 
  	});
</script>
