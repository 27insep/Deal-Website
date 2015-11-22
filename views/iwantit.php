<div id="main_popup_box" >
    <div id="login_popup">
        <div id="login_popup_header">ไม่อยากพลาดข้อเสนอดีลสุดพิเศษอีกแล้ว</div>
        <div id="login_popup_want">
			<form name="iwantit_form" id="iwantit_form" method="post" action="../../shopping/add_iwantit">
            	<div id="login_form_want">
                	<input name="iwantit_email" id="iwantit_email" type="text" />
                	<input type="hidden" name="deal_id" id="deal_id" value="<?=$deal_id?>">
                	<div style="padding: 10px 0 3px 20px;float: left"><?=$capcha?></div>
					<div style="padding: 10px 0 0 0;"><input type="text"  name="capcha" id="capcha" /></div>
                    <input name="" type="submit" class="orange_button" value="คลิก" />
                </div>
            </form>
        </div>
    </div> 
</div>

<script>
	
	function iwantit_compleate(responseText, statusText, xhr, $form)
	{
 			if(responseText==1){
 				alert("บันทึกข้อมูลเรียบร้อยแล้วค่ะ !!!");
 				window.location.href = './<?=$deal_id?>'; 
 			}else {
 				alert(responseText);
 			}
 		}
 		$('#iwantit_form').ajaxForm({ 	
 				success: iwantit_compleate
 			} ); 
</script>