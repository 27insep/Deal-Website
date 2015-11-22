<div id="main_inner">
	<div id="member_header"><?=$head_title?></div>
	<div id="member_main_box">
		<div id="member_main_box_left">
		<form name="member_profile" id="member_profile" action="/member/save_profile" method="post">
		<div class="section_box">
		<div id="member_profile_main_box_left_header">
			แก้ไขข้อมูลส่วนตัว <span>[รหัสสมาชิก <?=$member_data["member_id"]?>]</span>
		</div>
		<div class="row">
			<div class="clear_float">ชื่อ<span class="text_red">*</span></div><div>นามสกุล<span class="text_red">*</span></div>
			<div><input type="text" name="member_name" id="member_name" value="<?=$member_data["member_name"]?>"></div>
			<div><input type="text" name="member_sname" id="member_sname" value="<?=$member_data["member_sname"]?>">
						<input type="hidden" name="deal_id" id="deal_id" value="<?if(isset($deal_id))echo $deal_id;?>"></div>
		</div>
		<div class="row">
			<div>เลขประจำตัวประชาชน</div><div>หมายเลขโทรศัพท์มือถือ<span class="text_red">*</span></div>
			<div><input type="text" name="member_ssn" id="member_ssn" maxlength="13" value="<?=$member_data["member_ssn"]?>" onkeyup="isNumber(this)"/></div>
			<div><input type="text" name="member_mobile" id="member_mobile" maxlength="10" value="<?=$member_data["member_mobile"]?>" onkeyup="isNumber(this)"/></div>
		</div>
		<div class="row">
			<div class="clear_float">วันเกิด</div>
			<? 
				$member_birth_date	=	"";
				$date_check	=	explode("-",$member_data["member_birth_date"]);
				
				if((int)$date_check[0]!=0&&(int)$date_check[1]!=0&&(int)$date_check[2]!=0)
				{
					 $member_birth_date	= date("d/m/Y",strtotime($member_data["member_birth_date"]));
				}
			?>
			<div class="clear_float"><input type="text" name="member_birth_date" id="member_birth_date" value="<?=$member_birth_date?>"></div>
			<div>เพศ : &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				<input type="radio" value="1" name="member_gendar" id="member_gendar" <? if($member_data["member_gendar"]==1){?>checked="checked"<?}?>/> ชาย &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				<input  type="radio" value="2" name="member_gendar" id="member_gendar" <? if($member_data["member_gendar"]==2){?>checked="checked"<?}?> /> หญิง
			</div>
		</div>
		<div class="section_box_foot">
			<div><input type="checkbox" name="subscript" value="1" id="subscript" <?if($member_data["subscript_email"]==1){?>checked="checked"<?}?>/> รับข่าวสารทางอีเมล</div>
		</div>
		<div>
		</div>
		</div>
		<div class="section_box">
			<div id="member_profile_main_box_left_header">
				แก้ไขข้อมูลที่อยู่
			</div>
			<div class="row">
				<div>ที่อยู่</div>
				<div class="clear_float" style="600px"><textarea name="member_address" id="member_address" rows="5" cols="72"><?=$member_data["member_address"]?></textarea></div>
			</div>
			<div class="row">
				<div class="clear_float">เขต/อำเภอ</div><div>จังหวัด</div>
				<div><input type="text" name="city_name" id="city_name" value="<?=$member_data["city_name"]?>"></div>
				<div>
					<select name="province_id" id="province_id">
							<option value="">--- กรุณาเลือกจังหวัด ---</option>
						<? foreach($province_data as $province){?>
							<option <? if($member_data["province_id"]==$province["province_id"]){?>selected="selected"<?}?> value="<?=$province["province_id"]?>"><?=$province["province_name"]?></option>
						<? } ?>
					</select>
				</div>
			</div>
			<div class="row">
				<div class="clear_float">รหัสไปษณีย์</div>
				<div class="clear_float"><input type="text" name="member_zipcode" maxlength="5" id="member_zipcode" value="<?=$member_data["member_zipcode"]?>" onkeyup="isNumber(this)"></div>
			</div>
		<div class="section_box_foot">
			<input type="image" src="/assets/images/save_button.png" />
		</div>
		</div>
		</form>
		</div>
		<div id="member_main_box_right">
			<?=$right_sec?>
		</div>
	</div>
</div>
  <script>
  	$( "#member_birth_date" ).datepicker({
      		showOn: "button",
      		buttonImage: "/assets/images/carlender.gif",
      		buttonImageOnly: true,
      		changeMonth: true,
      		changeYear: true,
      		dateFormat: "dd/mm/yy",
      		yearRange: "1900:2001"
    	});
    	function isNumber(field) { 
        	var re = /^[0-9-'.'-',']*$/; 
        	if (!re.test(field.value)) { 
            	alert('Value must be all numberic charcters, including "." or "," non numerics will be removed from field!'); 
            	field.value = field.value.replace(/[^0-9-'.'-',']/g,""); 
        	} 
    	} 

    	$(document).ready(function() {  
    	function validate_profile()
    	{
    		var err	=	"";
    		if($("#member_name").val()=="")
    		{
    			err+=	"- ชื่อ<br/>";
    		}
    		if($("#member_sname").val()=="")
    		{
    			err+="- นามสกุล<br/>";
    		}
    		/*if($("#member_ssn").val()=="")
    		{
    			err+="- เลขประจำตัวประชาชน<br/>";
    		}*/
    		
    		if($("#member_ssn").val() != "" && $("#member_ssn").val().length<13)
    		{
    			err+="- เลขประจำตัวประชาชนไม่ถูกต้อง<br/>";
    		}
    		if($("#member_mobile").val()=="")
    		{
    			err+="- หมายเลขโทรศัพท์มือถือ<br/>";
    		}
    		if($("#member_mobile").val().length!=10)
    		{
    			err+="- หมายเลขโทรศัพท์มือถือไม่ถูกต้อง<br/>";
    		}
    	/*	if($("#member_birth_date").val()=="")
    		{
    			err+="- วันเกิด<br/>";
    		}
    		if($("#member_gendar").val()=="")
    		{
    			err+="-เพศ";
    		}
    		if($("#member_address").val()=="")
    		{
    			err+=	"- ที่อยู่<br/>";
    		}
    		if($("#city_name").val()=="")
    		{
    			err+="- เขต/อำเภท<br/>";
    		}
    		if($("#province_id").val()=="")
    		{
    			err+="- จัดหวัด<br/>";
    		}
    		if($("#member_zipcode").val()=="")
    		{
    			err+="- รหัสไปษณีย์<br/>";
    		}
    		if($("#member_zipcode").val().length<5)
    		{
    			err+="- รหัสไปษณีย์ไม่ถูกต้อง<br/>";
    		}*/
    		if(err.length>0)
    		{
    			err	=	"กรุณากรอกข้อมูลต่อไปนี้ค่ะ<br/>"+err;
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
 				$( "#dialog" ).html("ทำการบันทึกข้อมูลเรียบร้อยแล้วค่ะ");
 				$( "#dialog" ).css("text-align","center");
    			$( "#dialog" ).css("padding","25px");
    			$( "#dialog" ).dialog({
 					title: "ข้อความ",
 					buttons: [ { text: "ตกลง", click: function() 
 					{ 
 						$( this ).dialog( "close" );
 						window.location.href=window.location.href; 
 					} } ] 
 				});
 				
 			}else if(responseText==2){
 				$( "#dialog" ).html("ระบบทำการสั่งซื้อสินค้าเรียบร้อยแล้วค่ะ");
 				$( "#dialog" ).css("text-align","center");
    			$( "#dialog" ).css("padding","25px");
    			$( "#dialog" ).dialog({
 					title: "ข้อความ",
 					close: function( event, ui ) {window.location.href = 'http://www.thebestdeal1.com'},
 					buttons: [ { text: "ตกลง", click: function() { $( this ).dialog( "close" ); } } ] 
 				});
 			}else if(responseText==3){
 				$( "#dialog" ).html("การสั่งซื้อดีลนี้สามารถซื้อได้ 1 สิทธิ์ต่อคนเท่านั้นค่ะ");
 				$( "#dialog" ).css("text-align","center");
    			$( "#dialog" ).css("padding","25px");
    			$( "#dialog" ).dialog({
 					title: "ข้อความ",
 					close: function( event, ui ) {window.location.href = 'http://www.thebestdeal1.com'},
 					buttons: [ { text: "ตกลง", click: function() { $( this ).dialog( "close" ); } } ] 
 				});
 			}else{
 				$( "#dialog" ).html("ไม่สามารถบันทึกข้อมูลได้");
 				$( "#dialog" ).css("text-align","center");
    			$( "#dialog" ).css("padding","25px");
 				$( "#dialog" ).dialog({ title: "แจ้งเตือน" });
 			} 
 		}
 		$('#member_profile').ajaxForm(
 			{ 	
 				beforeSubmit:  validate_profile,
 				success: show_status
 			} 
 		);
  	});
  </script>