<div id="main_inner">
    <div id="main_inner_header">
        <h3>ตั้งรหัสผ่านใหม่</h3>
    </div>
    <div id="main_inner_body_other" style="height:290px" align="center" class="bg_col">
    	
        <div style="padding:50px;margin:30px auto 0;width:500px">
            <form name="member_changepass" id="member_changepass" action="/customer/change_pass" method="post">
            <table cellpadding="0" cellspacing="5" border="0">
                <tr>
                    <td align="right">รหัสผ่านใหม่<span class="text_red">*</span> : &nbsp;&nbsp;</td>
                  <td><input class="in_mtxt" type="password" name="pwd" id="pwd">
                  		   <input  type="hidden" name="member_id" value="<?=$member_id?>">
                  </td>
                </tr>
                <tr>
                    <td></td>
                    <td class="col999" style="font-size:12px">ต้องมีอย่างน้อย 8 ตัวอักษร</td>
                </tr>
                <tr>
                    <td align="right">ยืนยันรหัสผ่านใหม่<span class="text_red">*</span> : &nbsp;&nbsp;</td>
                  <td><input class="in_mtxt" type="password" name="pwd_confirm" id="pwd_confirm"></td>
                </tr>
                <tr>
                	<td colspan="2" align="center"><br /><input type="image" src="/assets/images/save_button.png"></td>
                </tr>
            </table>
            </form>
        </div>
    	
    </div>
</div>

 <script>
 $(document).ready(function() {  
 	function validate_pwd()
 	{
 		var err	=	"";
    		if($("#pwd").val()=="")
    		{
    			err+=	"- กรุณากรอกรหัสผ่าน<br/><br/>";
    		}
    		
    		if($("#pwd").val().length<8)
    		{
    			err+=	"- รหัสผ่านต้องมีอย่างน้อย 8 ตัวอักษร<br/><br/>";
    		}
    		
    		if($("#pwd_confirm").val()=="")
    		{
    			err+="- กรุณายืนยันรหัสผ่าน<br/><br/>";
    		}
    		
    		if($("#pwd").val()!=$("#pwd_confirm").val())
    		{
    			err+="- รหัสผ่านไม่ตรงกัน<br/>";
    		}
    		
    	    if(err.length>0)
    		{
    			$( "#dialog" ).html(err);
    			$( "#dialog" ).css("text-align","left");
    			$( "#dialog" ).css("padding","15px 25px");
 				$( "#dialog" ).dialog({ title: "แจ้งเตือน" });
    			return false;
    		}else{
    			return true;
    		}
 	}
 	
 	 function show_status(responseText, statusText, xhr, $form)
	 {
	 		if(responseText==1)
 			{
 				$( "#dialog" ).html("ทำการเปลี่ยนรหัสผ่านเรียบร้อยแล้วค่ะ");
 				$( "#dialog" ).css("text-align","center");
    			$( "#dialog" ).css("padding","25px");
    			$( "#dialog" ).dialog({
 					title: "ข้อความ",
 				    close: function( event, ui ) 
 				    {
 							window.location.href = "http://www.thebestdeal1.com/";
 					 },
 					buttons: [ { text: "ตกลง", click: function() { $( this ).dialog( "close" ); } } ] 
 				});
 			}
	 }
 
 	$('#member_changepass').ajaxForm(
 			{ 	
 				beforeSubmit:  validate_pwd,
 				success: show_status
 			} 
 		);
 });
 

</script>