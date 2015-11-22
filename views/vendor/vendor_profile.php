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
<div id="vendor_dashboard_main">
<div id="vendor_dashboard_header">
	<div id="vendor_dashboard_header_text">
		<div>Merchant Dashboard</div>
		<div id="marchant_name"><?=$vendor_name?>,<?=$this->convert_date->show_thai_date(date("Y-m-d",time()))?></div>
	</div>
</div>
<div id="vendor_dashboard_menu">
	<div id="vendor_dashboard_menu_inner">
		<div id="vendor_dashboard_left"><a href="/vendor/vendor_deal">My Events</a> | <a href="/vendor/vendor_profile"><span>My Profile</span></a> | <a href="/vendor/vendor_account">Change Password</a></div>
		<div id="vendor_dashboard_right"><span>สวัสดี คุณ <?=$vendor_contact_fname?> <?=$vendor_contact_sname?></span> | <span style="color: #FFFFFF;" onclick="do_logout()">Log Out</span></div>
	</div>
</div>

<form id="vendor_form" action="/vendor/vendor_save_profile" method="post">
<div id="vendor_main">
	<div id="vendor_inner_main">
	<div id="vendor_main_topic"><div>My Profile</div></div>	
	<div id="vendor_body">
		<div class="vendor_title">ข้อมูลทั่วไป</div>
		<div>ชื่อผู้ให้บริการ :</div><div>ซื่อผู้ติดต่อ :</div><div>นามสกุลผู้ติดต่อ :</div>
		<div><input type="text" value="<?=$vendor_name?>" name="vendor_name" id="vendor_name" /></div>
		<div><input type="text" value="<?=$vendor_contact_fname?>" name="vendor_contact_fname" id="vendor_contact_fname" /></div>
		<div><input type="text" value="<?=$vendor_contact_sname?>" name="vendor_contact_sname" id="vendor_contact_sname"/></div>
		<div>อีเมลติดต่อ :</div><!--<div>เบอร์โทรศัพท์ :</div><div>เบอร์แฟกซ์ :</div>-->
		<div>
			<input type="hidden" value="<?=$vendor_email?>" name="vendor_email" id="vendor_email"/>
			<?=$vendor_email?>
		</div>
		<!--
		<div><input maxlength="10" type="text" value="<?=$vendor_phone?>" name="vendor_phone" id="vendor_phone" onkeyup="isNumber(this)"/></div>
		<div><input maxlength="10" type="text" value="<?=$vendor_fax?>" name="vendor_fax" id="vendor_fax" onkeyup="isNumber(this)"/></div>-->
        <div class="vendor_title" style="padding-top:10px">ข้อมูลที่อยู่</div>
		<div style="clear:both;width:750px;padding-left:0;margin-top:0">
            <!--<div style="clear: both">ที่อยุ่ :</div>-->
        </div>
	</div>	
	<div id="vendor_addr">
		<div style="clear: both;margin-left: 10px;margin-bottom: 30px;">
	            	<textarea name="vendor_address" id="vendor_address" class="mceEditor"><?if(isset($vendor_address)){ echo $vendor_address;}?></textarea>
		</div>
	</div>
	<div id="vendor_main_footer">
		<input type="submit" name="submit" id="submit" value="save" />
	</div>
	</div>
</div>
</form>
</div>
<div id="vendor_dashboard_footer"></div>
<script type="text/javascript">
	function do_logout()
	{
		$.ajax({
  			url: "/vendor/vendor_logout",
		}).done(function( msg ) {
  			 	$( "#dialog" ).html("ทำการออกจากระบบเรียบร้อยแล้วค่ะ");
 				$( "#dialog" ).dialog(
 					{ 
 						title: "ข้อความ",
 						close: function( event, ui ) 
 						{
 							window.location.href = "/vendor/";
 						},
 						buttons: [ { text: "ตกลง", click: function() { $( this ).dialog( "close" ); } } ]
 					});
 				
		});
	}
	   function isNumber(field) { 
        	var re = /^[0-9-'.'-',']*$/; 
        	if (!re.test(field.value)) { 
            	//alert('Value must be all numberic charcters, including "." or "," non numerics will be removed from field!'); 
            	field.value = field.value.replace(/[^0-9-'.'-',']/g,""); 
        	} 
    	} 

		function validate_vendor_profile()
    	{
    		var err	=	"";
    		if($("#vendor_name").val()=="")
    		{
    			err+=	"- ชื่อผู้ให้บริการ<br/>";
    		}
    		if($("#vendor_contact_fname").val()=="")
    		{
    			err+=	"- ซื่อผู้ติดต่อ<br/>";
    		}
    		if($("#vendor_contact_sname").val()=="")
    		{
    			err+="- นามสกุลผู้ติดต่อ<br/>";
    		}
    		if($("#vendor_phone").val()=="")
    		{
    			err+="- เบอร์โทรศัพท์<br/>";
    		}
    		if($("#vendor_phone").val().length<9)
    		{
    			err+="- เบอร์โทรศัพท์ไม่ถูกต้อง<br/>";
    		}
    			if($("#vendor_fax").val()=="")
    		{
    			err+="- เเบอร์แฟกซ์<br/>";
    		}
    		if($("#vendor_fax").val().length<9)
    		{
    			err+="- เบอร์แฟกซ์ไม่ถูกต้อง<br/>";
    		}
    		if(err.length>0)
    		{
    			err	=	"กรุณากรอกข้อมูลต่อไปนี้ค่ะ<br/>"+err;
    			$( "#dialog" ).html(err);
    			$( "#dialog" ).css("text-align","left");
    			$( "#dialog" ).css("padding","15px 25px");
 				$( "#dialog" ).dialog({ title: "แจ้งเตือน" });
    			return false;
    		}else{
    			return true;;	
    		}
    	}
    	
	   	$(document).ready(function() {  
 		function show_status(responseText, statusText, xhr, $form)
 		{
 			if(responseText==1)
 			{
 				$( "#dialog" ).html("ทำการบันทึกข้อมูลเรียบร้อยแล้วค่ะ");
 				$( "#dialog" ).dialog(
 					{ 
 						title: "ข้อความ",
 					}
 				);
 			}else{
 				$( "#dialog" ).html("ไม่สามารถบันทึกข้อมูลได้");
 				$( "#dialog" ).dialog({ title: "แจ้งเตือน" });
 			} 
 		}
 		$('#vendor_form').ajaxForm(
 			{ 	
 				beforeSubmit:  validate_vendor_profile,
 				success: show_status
 			} 
 		); 
  	});
</script>