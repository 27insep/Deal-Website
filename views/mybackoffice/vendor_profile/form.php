<script  type="text/javascript">
	tinyMCE.init({
        // General options
        mode : "specific_textareas",
        editor_selector : "mceEditor",
        theme : "advanced",
        plugins : "autolink,lists,spellchecker,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template",

        // Theme options
        theme_advanced_buttons1 : "bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,|,bullist,numlist,|,outdent,indent,blockquote,|,formatselect,fontsizeselect,|,undo,redo,|",
        theme_advanced_buttons2 : "cut,copy,paste,link,unlink,|,image,media,|,forecolor,backcolor,|,preview",
        theme_advanced_toolbar_location : "top",
        theme_advanced_toolbar_align : "left",
        theme_advanced_statusbar_location : "bottom",
        theme_advanced_resizing : true,

        // Skin options
        skin : "o2k7",
        skin_variant : "silver",

        // Example content CSS (should be your site CSS)
        content_css : "css/example.css",

        // Drop lists for link/image/media/template dialogs
        template_external_list_url : "template_list.js",
        external_link_list_url : "link_list.js",
        external_image_list_url : "image_list.js",
        media_external_list_url : "media_list.js",
        file_browser_callback : "ajaxfilemanager",

        // Replace values for the template plugin
        template_replace_values : {
                username : "Some User",
                staffid : "991234"
        }
});
        function ajaxfilemanager(field_name, url, type, win) {
                var ajaxfilemanagerurl = "/assets/js/tiny_mce/plugins/ajaxfilemanager/ajaxfilemanager.php";
                var view = 'detail';
                switch (type) {
                        case "image":
                        view = 'thumbnail';
                                break;
                        case "media":
                                break;
                        case "flash": 
                                break;
                        case "file":
                                break;
                        default:
                                return false;
                }
                tinyMCE.activeEditor.windowManager.open({
                    url: "/assets/js/tiny_mce/plugins/ajaxfilemanager/ajaxfilemanager.php?view=" + view,
                    width: 782,
                    height: 440,
                    inline : "yes",
                    close_previous : "no"
                },{
                    window : win,
                    input : field_name
                });         
        }
</script>
<?php echo form_open_multipart($page_action,array('id' => 'vendor_form','name'=>'vendor_form','method'=>'post'));?>
<div style="padding: 25px;">
	<span class="header_title"><?=$manage_title?></span>
	<div style="float: right"><a href="/mybackoffice/vendor_profile/">กลับสู่หน้าหลัก</a></div>
	<br/><br/>
	<table border="0" cellpadding="5" cellspacing="1" class="tb_form">
		<tr>
			<td class="tb_H">อีเมล</td>
			<td>
				<input type="text" size="35" value="<?if(isset($vendor_email)){ echo $vendor_email;}?>" name="vendor_email" id="vendor_email"/>
			</td>
		</tr>
		<tr>
			<td class="tb_H">รหัสผ่าน</td>
			<td>
				<input type="password" maxlength="16" size="35" value="<?if(isset($vendor_pwd)){ echo base64_decode($vendor_pwd);}?>" name="vendor_pwd" id="vendor_pwd" />
				<input type="button" value="Random Password" name="random_password" id="random_password" onclick="random_pass ()" />
			</td>
		</tr>
		<tr>
			<td class="tb_H">ยืนยันรหัสผ่าน</td>
			<td><input type="password" maxlength="16" size="35" value="<?if(isset($vendor_pwd)){ echo base64_decode($vendor_pwd);}?>" name="vendor_confirm_pwd" id="vendor_confirm_pwd" /></td>
		</tr>
		<tr>
			<td class="tb_H">ชื่อร้านขายดีล</td>
			<td><input type="text" size="35" value="<?if(isset($vendor_name)){ echo $vendor_name;}?>" name="vendor_name" id="vendor_name" /></td>
		</tr>
		<tr>
			<td class="tb_H">ชื่อผู้ติดต่อ</td>
			<td><input type="text" size="35" value="<?if(isset($vendor_contact_fname)){ echo $vendor_contact_fname;}?>" name="vendor_contact_fname" id="vendor_contact_fname" /></td>
		</tr>
		<tr>
			<td class="tb_H">นามสกุลผู้ติดต่อ</td>
			<td><input type="text" size="35" value="<?if(isset($vendor_contact_sname)){ echo $vendor_contact_sname;}?>" name="vendor_contact_sname" id="vendor_contact_sname" /></td>
		</tr>
		<tr>
			<td valign="top" class="tb_H">ที่อยู่ (ข้อมูลติดต่อ)</td>
			<td><textarea name="vendor_address" id="vendor_address" class="mceEditor" cols="75" rows="5"/><?if(isset($vendor_address)){ echo $vendor_address;}?></textarea></td>
		</tr>
		<tr>
			<td class="tb_H">เว็บไซต์</td>
			<td><input size="35" type="text" value="<?if(isset($vendor_website)){ echo $vendor_website;}else{echo "http://";}?>" name="vendor_website" id="vendor_website" /></td>
		</tr>
		<tr>
			<td class="tb_H">โลโก้ร้านค้า</td>
			<td>
				<?if(isset($vendor_logo)){ ?>
					<img src="/assets/images/<?=$vendor_logo?>" width="200" height="65"/>
					<br/>
				<? } ?>
				<span style="color: #FF0000;"> ขนาดรูปภาพที่เหมาะสม กว้าง 200px สูง 65px</span><br/>
				<input type="file" name="vendor_logo" id="vendor_logo" size="44" />
			</td>
		</tr>
		<tr>
			<td class="tb_H">แผนที่ร้านค้า</td>
			<td>
				<?if(isset($vendor_map)){ ?>
					<img src="/assets/images/<?=$vendor_map?>" width="550" height="400"/>
					<br/>
				<? } ?>
				<span style="color: #FF0000;"> ขนาดรูปภาพที่เหมาะสม กว้าง 550px สูง 400px</span><br/>
				<input size="35" type="file" name="vendor_map" id="vendor_map" size="44" />
			</td>
		</tr>
		<tr>
			<td class="tb_H">เกี่ยวกับร้านค้า</td>
			<td><textarea name="vendor_about_us" id="vendor_about_us" class="mceEditor"><?if(isset($vendor_about_us)){ echo $vendor_about_us;}?></textarea></td>
		</tr>
		<tr>
			<td class="tb_H">สถานะ</td>
			<td>
				<select name="vendor_status" id="vendor_status">
					<option value="1" <? if(isset($vendor_status) && $vendor_status == '1'){echo 'selected';}?>>Active</option>
					<option value="0" <? if(isset($vendor_status) && $vendor_status == '0'){echo 'selected';}?>>Not Active</option>
				</select>
			</td>
		</tr>
		<tr>
			<td class="tb_H">การจ่ายรายได้</td>
			<td>
				<select name="vendor_pay_type" id="vendor_pay_type">
					<option value="">- - - กรุณาเลือกวิธีการจ่ายรายได้ - - -</option>
					<option value="1" <? if(isset($vendor_pay_type) && $vendor_pay_type == '1'){echo 'selected';}?>>หมดเขตการขายดีล 7 วัน โอนให้ 50% และ  หมดเขตการคูปอง 7 วัน โอนให้ 50%</option>
					<option value="2" <? if(isset($vendor_pay_type) && $vendor_pay_type == '2'){echo 'selected';}?>>หมดเขตการขายดีล 7 วัน โอนให้ 70% และ หมดเขตการคูปอง 7 วัน โอนให้ 30%</option>
					<option value="3" <? if(isset($vendor_pay_type) && $vendor_pay_type == '3'){echo 'selected';}?>>หมดเขตการขายดีล 20 วัน โอนให้ 100%</option>
					<option value="4" <? if(isset($vendor_pay_type) && $vendor_pay_type == '4'){echo 'selected';}?>>หมดเขตการขายดีล 20 วัน โอนให้ 90% และ หมดเขตการคูปอง 7 วัน โอนให้ 10%</option>
					<option value="5" <? if(isset($vendor_pay_type) && $vendor_pay_type == '5'){echo 'selected';}?>>หมดเขตการขายดีล 7 วัน โอนให้ 80% และ  หมดเขตการคูปอง 2 ปี โอนให้ 20%</option>
				</select>
			</td>
		</tr>
		<? if($admin_type!=3){?>
		<tr>
			<td class="tb_H">พนักงานขาย</td>
			<td>
				<select name="admin_id" id="admin_id">
					<option value="">- - - กรุณาเลือกพนักงาน - - -</option>
					<? foreach($admin_data as $data){?>
						<option value="<?=$data["admin_id"]?>" <? if(isset($admin_id) && $admin_id == $data["admin_id"]){echo 'selected';}?>><?=$data["admin_name"]?></option>
					<? } ?>
				</select>
			</td>
		</tr>
		<?}?>
		<tr>
			<td valign="top" class="tb_H">บันทึกช่วยจำ</td>
			<td><textarea name="vendor_memo" id="vendor_memo" cols="75" rows="5"/><?if(isset($vendor_memo)){ echo $vendor_memo;}?></textarea></td>
		</tr>
		<tr>
			<td class="tb_F"></td>
			<td class="tb_F"><input type="submit" value="บันทึกข้อมูล" /></td>
		</tr>
	</table>
</div>
</form>
<script>
  	function random_pass () {
   		var passwd = '';
 	 	var chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
  		for (i=1;i<8;i++) {
    		var c = Math.floor(Math.random()*chars.length + 1);
    		passwd += chars.charAt(c)
	 	}
		document.getElementById('vendor_pwd').value = passwd;
		document.getElementById('vendor_confirm_pwd').value = passwd;
	}
  $(document).ready(
  	function(){
    	$("#vendor_form").validate({
   	rules: {
     // simple rule, converted to {required:true}
     // compound rule
     vendor_email: {
     	required:true,
     	email:true,
     	remote: {
        	url: "/mybackoffice/check_vendor_email",
        	type: "post",
        	data: {
          		vendor_email: function() 
          		{
            		return $("#vendor_email").val();
          		}
          		<?if(isset($vendor_id)){?>
          		,
          		vendor_id:<?=$vendor_id?>
          		<?}?>
        	}
      	}
     }
     ,vendor_pwd: {
       required: true,
       minlength: 6
     },
     vendor_confirm_pwd:
     {
     	required: true,
     	equalTo: "#vendor_pwd"
     }
    ,vendor_name :{
    	required:true
    }
	,vendor_contact_fname :{
		required:true
	}
	,vendor_contact_sname :{
		required:true
	}
	,vendor_address :{
		required:true
	}
	,vendor_city :{
		required:true
	}
	,province_id :{
		required:true
	}
	,vendor_zipcode :{
		required:true,
		number:true
	}
	,vendor_pay_type :{
		required:true,
	}
	<? if($admin_type!=3){?>
	,admin_id :{
		required:true,
	}
	<?}?>
   },
   messages: {
    vendor_email: {
     	required:"กรุณาระบุข้อมูลอีเมลค่ะ",
     	email:"รูปแบบอีเมลไม่ถูกต้องค่ะ",
     	remote:"มีผู้ใช้อีเมลนี้แล้ว" 
     }
     <? if($action_status=="insert"){?>
     ,vendor_pwd: {
       required: "กรุณาระบุรหัสผ่านค่ะ",
       minlength:"รหัสผ่านต้องมากกว่า 6 ตัวอักษรค่ะ"
     },
     vendor_confirm_pwd:
     {
     	required:  "กรุณาระบุยื่นยันรหัสผ่านค่ะ",
     	equalTo : "ยื่นยันรหัสผ่านไม่ถูกต้องค่ะ"
     }
     <? }?>
     ,vendor_name :{
    	required:"กรุณาระบุชื่อร้านค้าค่ะ"
    }
	,vendor_contact_fname :{
		required:"กรุณาระบุชื่อผู้ติดต่อค่ะ"
	}
	,vendor_contact_sname :{
		required:"กรุณาระบุนามสกุลผู้ติดต่อค่ะ"
	}
	,vendor_address :{
		required:"กรุณาระบุที่อยู่ค่ะ"
	}
	,vendor_city :{
		required:"กรุณาระบุเมืองค่ะ"
	}
	,province_id :{
		required:"กรุณาระบุจังหวัดค่ะ"
	}
	,vendor_zipcode :{
		required:"กรุณาระบุรหัสไปษณีย์ค่ะ",
		number:"กรุณาระบุเฉพาะตัวเลขค่ะ"
	}	
	,vendor_pay_type :{
		required: "กรุณาระบุประเภทการจ่ายรายได้"
	}
	<? if($admin_type!=3){?>
	,admin_id :{
		required:"กรุณาระบุพนักงานขาย"
	}
	<?}?>
   }
});
  });
</script>