<div id="main_inner">
    <div id="main_inner_header">
        <h3>ติดต่อเรา</h3>
    </div>
    <form id="contact" name="contact" method="post" action="/home/contact_us">
    <div id="main_inner_body_other">
    	<div id="main_inOL">
        	<div id="main_inOLbg">
            	<h1>บริษัท เดอะ เบสท์ ดีล จำกัด</h1>
                <p>เลขที่  12/14  ปากทางลาดพร้าว (ซอย MRT พหลโยธินทางออกที่2) แขวงจอมพล เขตจตุจักร กรุงเทพฯ  10900<br />โทรศัพท์. 02-938-4399   แฟกซ์  02-938-4399</p>
                <h1>ข้อมูลติดต่อ</h1>
                <p>
                	<b class="col48c">เรื่อง :</b><br /><input type="text" name="topic" id="topic" class="in_txt" /><br />
                    <b class="col48c">รายละเอียด :</b><br /><textarea name="detail" id="detail" class="in_txta"></textarea><br />
                </p>
                <div class="dot">
                	<table width="400" border="0" cellpadding="0" cellspacing="0">
                    	<tr>
                        	<td align="left" width="110"><b class="col48c">ชื่อ-นามสกุล :</b></td>
                            <td align="left"><input type="text" name="contact_name" id="contact_name" class="in_mtxt" /></td>
                        </tr>
                        <tr>
                        	<td align="left" width="110"><b class="col48c">อีเมล์ :</b></td>
                            <td align="left"><input type="text" name="email" id="email" class="in_mtxt" size="36" /></td>
                        </tr>
                        <tr>
                        	<td align="left" width="110"><b class="col48c">โทรศัพท์ :</b></td>
                            <td align="left"><input type="text"  name="tel" id="tel" class="in_mtxt" onkeyup="isNumber(this)"/></td>
                        </tr>
                    </table>
                </div>
                  <div class="dot">
                	<table width="400" border="0" cellpadding="0" cellspacing="0">
                    	<tr>
                        	<td align="left"><b class="col48c">เช็คความปลอดภัย :</b><br /><div style="padding: 8px 0"><?=$capcha?></div></td>
                            <td align="left"><b class="col48c">กรอกตัวอักษร :</span><br /><div style="padding: 8px 0"><input type="text" class="in_stxt" name="capcha" /></div></td>
                        </tr>
                    </table>
                </div>
            </div>
            <input type="submit" class="bt_contact" value="Send" />
        </div>
        <div id="main_inOR"><a class="fancybox" rel="group1" href="/assets/images/map.jpg"><img src="/assets/images/map.jpg" /></a></div>
    </div>
    </form>
</div>
<script type="text/javascript">
 	$(document).ready(function() {  
 		function do_contact_us(responseText, statusText, xhr, $form)
 		{
 			if(responseText!=1)
 			{
 				$( "#dialog" ).html(responseText);
 				$( "#dialog" ).css("text-align","left");
    			$( "#dialog" ).css("padding","15px 25px");
 				$( "#dialog" ).dialog({ title: "แจ้งเตือน" });
 			}else{
 				$( "#dialog" ).html("ขอบคุณที่ใช้บริการค่ะ");
 				$( "#dialog" ).dialog({
 					title: "ข้อความ",
 					close: function( event, ui ) {window.location.href = 'http://www.thebestdeal1.com'},
 					buttons: [ { text: "ตกลง", click: function() { $( this ).dialog( "close" ); } } ] 
 				});
 			}
 		}
 		$('#contact').ajaxForm(
 			{ 	
 				success: do_contact_us
 			} 
 		); 
  	});
  	
  	function isNumber(field) { 
        	var re = /^[0-9-'.'-',']*$/; 
        	if (!re.test(field.value)) { 
            	field.value = field.value.replace(/[^0-9-'.'-',']/g,""); 
        	} 
    	} 
</script>
<script>
	$('.fancybox').fancybox({'ajax':{cache	: false}});
</script>
