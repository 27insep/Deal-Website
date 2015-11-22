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
     function load_shop_data(type)
	{
		var vendor_id	=	$("#vendor_id").val();
		if(vendor_id!="")
		{
			$.getJSON('/mybackoffice/load_shop_data/'+vendor_id+"/"+type, function(data) {
  			$.each(data, function(key, val) {
  				$("#pic_map").remove();
  				if(key=="deal_map")
  				{
  					$("#show_map").html('<img src="/assets/images/'+val+'" width="300" height="220"/><input size="35" type="hidden" name="show_deal_map" id="show_deal_map" value="'+val+'" />');
  				}else if(key=="deal_aboutus_detail"||key=="deal_address")
  				{
  					tinymce.get(key).setContent(val);
  				}else{
    				$("#"+key).val(val);
    			}
 	 		});
		});
		}else{
			alert("กรุณาเลือกร้านค้าก่อนค่ะ !");
		}
	}
	function clear_shop_data()
	{
		$("#show_map img").remove();
		$("#show_map input").remove();
		tinymce.get("deal_aboutus_detail").setContent("");
		tinymce.get("deal_address").setContent("");
		$("#deal_email").val("");
		$("#deal_website").val("");
		$("#deal_aboutus_detail").val("");
		$("#show_map").html("");
		$("#pic_map").remove();
	}
</script>
<?php echo form_open_multipart($page_action,array('id' => 'deal_main_form','name'=>'deal_main_form','method'=>'post'));?>
<div style="margin: 25px;">
	<span class="header_title"><?=$manage_title?></span>
		<? if(!isset($vendor_id)){?>
		<div style="float: right"><a href="/mybackoffice/deal_main">กลับสู่หน้าหลัก</a></div>
	<? }else{?>
		<div style="float: right"><a href="/mybackoffice/deal_main/main/0/<?=$vendor_id?>">กลับสู่หน้าหลัก</a></div>
	<? } ?>
	<br/>
	<table border="0" cellpadding="5">
		<tr>
			<td>ร้านขายดีล</td>
			<td>
				<select name="vendor_id" id="vendor_id">
					<option value="">- - - กรุณาเลือกร้านค้า - - -</option>
				<?
					foreach($tbl_vendor_profile as $vendor)
					{
				?>
					<option value="<?=$vendor["vendor_id"]?>" <?if(isset($vendor_id)&&$vendor_id==$vendor["vendor_id"]){ ?>selected="selected"<?}?>><?=$vendor["vendor_name"]?></option>
				<?
					}
				?>
				</select>
			</td>
		</tr>
		<tr>
			<td>หมวดหมู่หลัก</td>
			<td>
				<select id="cat_id" name="cat_id" onchange="load_sub_cat()">
					<option value="">- - - กรุณาเลือกหมดวสินค้าหลัก - - -</option>
				<? 
				foreach($tbl_category_main as $data){
							
						if($cat_id == $data["cat_id"]){
							
							?>	
							<option value="<?=$data["cat_id"]?>" selected="selected"><?=$data["cat_name"]?></option>
				<? 		}else{ ?>
							<option value="<?=$data["cat_id"]?>"><?=$data["cat_name"]?></option>
				<? 		}
					} ?>
				</select>
			</td>
		</tr>
		<tr>
			<td>หมวดหมู่ย่อย</td>
			<td>
				<div id="show_sub_cat">
				<select id="sub_cat_id" name="sub_cat_id">
					<option value="">- - - กรุณาเลือกหมดวสินค้าย่อย - - -</option>
				</select>
				</div>
			</td>
		</tr>
			<tr>
			<td>ชื่อดีล</td>
			<td><input type="text" size="50" value="<?if(isset($deal_name)){ echo $deal_name;}?>" name="deal_name" id="deal_name" /></td>
		</tr>
		<tr>
			<td valign="top">รายละเอียดอย่างย่อ</td>
			<td>
				<textarea name="deal_intro" id="deal_intro" class="mceEditor">
					<?if(isset($deal_intro)){ echo $deal_intro;}?>
				</textarea>
			</td>
		</tr>
		<? if($action=="insert"){?>
		<tr>
			<td>วันที่กำหนดเริ่มขาย</td>
			<td class="show_date">
				<input type="text" class="datepicker" value="" name="round_start" id="round_start" /> 
			</td>
		</tr>
		<tr>
			<td class="show_date">
				วันที่กำหนดปิดการขาย
			</td>
			<td>
				<input type="text" class="datepicker" value="" name="round_end" id="round_end" />
			</td>
		</tr>
		<?}else{?>
		<?if(isset($round_history)&&sizeof($round_history)>0){?>
		<tr>
			<td>ประวัติรอบการเปิดขายดีล</td>
			<td class="show_date">
				<? foreach($round_history as $round){?>
				<div>
					<? echo date("d/m/Y",strtotime($round["round_start"]));?> ถึง 
					<? echo date("d/m/Y",strtotime($round["round_end"]));?>
				</div>
				<? } ?>
			</td>
		</tr>
		<?}?>
		<tr>
			<td>วันที่กำหนดเริ่มขาย</td>
			<td class="show_date">
				<input type="text" class="datepicker" value="<?if(isset($round_start)&&!empty($round_start)){ echo date("d/m/Y",strtotime($round_start));}?>" name="round_start" id="round_start" /> 
		</tr>
		<tr>	
			<td>วันที่กำหนดปิดการขาย</td>
			<td class="show_date"> 
				<input type="text" class="datepicker" value="<?if(isset($round_end)&&!empty($round_end)){ echo date("d/m/Y",strtotime($round_end));}?>" name="round_end" id="round_end" />
				<input type="hidden" name="round_action" id="round_action" value="<?=$round_action?>" />
				<?if($round_action=="update"){?>
					<input type="hidden" name="round_id" id="round_id" value="<?=$round_id?>" />
				<?}?>
			</td>
		</tr>
		<?}?>
		<tr>
			<td>รอบวันที่เปิดขาย</td>
			<td class="show_date">
				<input type="text" class="datepicker" value="<?if(isset($deal_buy_time_start)){ echo date("d/m/Y",strtotime($deal_buy_time_start));}?>" name="deal_buy_time_start" id="deal_buy_time_start" />
			</td>
		</tr>
		<tr>
			<td>รอบวันที่ปิดขาย</td>
			<td class="show_date">
			<input type="text" class="datepicker" value="<?if(isset($deal_buy_time_end)){ echo date("d/m/Y",strtotime($deal_buy_time_end));}?>" name="deal_buy_time_end" id="deal_buy_time_end" />
			</td>
		</tr>
		<tr>
			<td>เปิดใหม่อัตโนมัติ</td>
			<td>
				<select name="deal_reopen" id="del_reopen">
					<? for($i=0;$i<11;$i++){?>
						<option value="<?=$i?>" <?if(isset($deal_reopen) && $deal_reopen == $i){?>selected="selected"<?}?>><?=$i?></option>
					<? } ?>
				</select>
				รอบ
			</td>
		</tr>
		<tr>
			<td>เริ่มใช้คูปองได้วันที่</td>
			<td class="show_date">
				<input type="text" class="datepicker" value="<?if(isset($deal_start)){ echo date("d/m/Y",strtotime($deal_start));}?>" name="deal_start" id="deal_start" />
			</td>
		</tr>
		<tr>
			<td>คูปองหมดอายุวันที่</td>
			<td class="show_date">
			<input type="text" class="datepicker" value="<?if(isset($deal_expile)){ echo date("d/m/Y",strtotime($deal_expile));}?>" name="deal_expile" id="deal_expile" />
			</td>
		</tr>
		<tr>
			<td>รูปภาพ</td>
			<td>
				<?if(isset($deal_index_image)){ ?>
					<img src="/assets/images/<?=$deal_index_image?>" width="360" height="245"/>
					<br/>
				<? } ?>
				<span style="color: #FF0000;"> ขนาดรูปภาพที่เหมาะสม กว้าง 360px สูง 245px</span><br/>
				<input type="file" name="deal_index_image" id="deal_index_image" size="44" />
				
			</td>
		</tr>
		<tr>
			<td>โปรโมชั่นจากเว็บสุ่มผู้โชคดี</td>
			<td>
				<input type="radio" value="1" name="deal_special" id="deal_special" <?if(isset($deal_special)&&$deal_special==1){ ?>checked="checked"<?}?> /> ใช่
				<input type="radio" value="0" name="deal_special" id="deal_special" <?if(!isset($deal_special)||$deal_special==0){ ?>checked="checked"<?}?> /> ไม่ใช่
			</td>
		</tr>
		<tr>
			<td>ประเภทดีล</td>
			<td>
				<input type="radio" value="1" name="deal_recomment" id="deal_recomment" <?if(isset($deal_recomment)&&$deal_recomment==1){ ?>checked="checked"<?}?> /> ดีลเด่นวันนี้
				<input type="radio" value="0" name="deal_recomment" id="deal_recomment" <?if(!isset($deal_recomment)||$deal_recomment==0){ ?>checked="checked"<?}?> /> ดีลปกติ
			</td>
		</tr>
		<tr>
			<td>สถานะ</td>
			<td>
				<input type="radio" value="1" name="deal_status" id="deal_status" <?if(isset($deal_status)&&$deal_status==1){ ?>checked="checked"<?}?> /> แสดง
				<input type="radio" value="0" name="deal_status" id="deal_status" <?if(!isset($deal_status)||$deal_status==0){ ?>checked="checked"<?}?> /> ไม่แสดง
			</td>
		</tr>
		<tr>
			<td valign="top">ไฮไลท์</td>
			<td><textarea class="mceEditor" name="deal_hilight_detail" id="deal_hilight_detail" style="width:100%"><?if(isset($deal_hilight_detail)){ echo $deal_hilight_detail;}?></textarea></td>
		</tr>
		<tr>
			<td valign="top">รายละเอียด (Print Fine)</td>
			<td><textarea class="mceEditor" name="deal_main_detail" id="deal_main_detail" style="width:100%"><?if(isset($deal_main_detail)){ echo $deal_main_detail;}?></textarea></td>
		</tr>
		<tr>
			<td valign="top">รายละเอียดเพิ่มเติม (Other)</td>
			<td><textarea class="mceEditor" name="deal_main_condition" id="deal_main_condition" style="width:100%"><?if(isset($deal_main_condition)){ echo $deal_main_condition;}?></textarea></td>
		</tr>
		<tr>
			<td>นำข้อมูลมาจาก</td>
			<td>
				<input type="radio" name="data_form" id="data_form" onclick="clear_shop_data()" checked="checked"/> ข้อมูลใหม่
				<input type="radio" name="data_form" id="data_form" onclick="load_shop_data(1)"/> ข้อมูลร้านค้า
				<input type="radio" name="data_form" id="data_form" onclick="load_shop_data(2)"/> ข้อมูลดีลที่ผ่านมา
			</td>
		</tr>
		<tr>
			<td valign="top" class="tb_H">เกี่ยวกับเรา</td>
			<td><textarea class="mceEditor" name="deal_aboutus_detail" id="deal_aboutus_detail" style="width:100%"><?if(isset($deal_aboutus_detail)){ echo $deal_aboutus_detail;}?></textarea></td>
		</tr>
		<tr>
			<td valign="top" class="tb_H">ที่อยู่</td>
			<td><textarea class="mceEditor" name="deal_address" id="deal_address" style="width:100%" rows="10"><?if(isset($deal_address)){ echo $deal_address;}?></textarea></td>
		</tr>
		<tr>
			<td class="tb_H">อีเมล</td>
			<td><input size="35" type="text" value="<?if(isset($deal_email)){ echo $deal_email;}?>" name="deal_email" id="deal_email" /><div class="text_red">*Ex. info@thebestdeal1.com หากต้องการใส่หลายเว็บไซด์ให้คันด้วย ,</div></td>
		</tr>
		<tr>
			<td class="tb_H">เว็บไซต์</td>
			<td><input size="35" type="text" value="<?if(isset($deal_website)){ echo $deal_website;}?>" name="deal_website" id="deal_website" /><div class="text_red">*Ex. thebestdeal1.com หากต้องการใส่หลายเว็บไซด์ให้คันด้วย ,</div></td>
		</tr>
		<tr>
			<td class="tb_H">แผนที่ร้านค้า</td>
			<td><div id="show_map"></div>
				<?if(isset($deal_map)){ ?>
					<img id="pic_map" src="/assets/images/<?=$deal_map?>" width="300" height="220"/>
					<br/>
				<? } ?>
				<span style="color: #FF0000;"> ขนาดรูปภาพที่เหมาะสม กว้าง 550px สูง 400px</span><br/>
				<input size="35" type="file" name="deal_map" id="deal_map" size="44" />
			</td>
		</tr>
		<tr>
			<td valign="top" class="tb_H">Meta Tag Keywords :</td>
			<td><textarea name="deal_meta_keyword" id="deal_meta_keyword" rows="5" cols="75"><?if(isset($deal_meta_keyword)){ echo $deal_meta_keyword;}?></textarea></td>
		</tr>
		<tr>
			<td valign="top" class="tb_H">Meta Tag Description :</td>
			<td><textarea name="deal_meta_description" id="deal_meta_description" rows="5" cols="75"><?if(isset($deal_meta_keyword)){ echo $deal_meta_keyword;}?></textarea></td>
		</tr>
		<tr>
			<td></td>
			<td><input name="submit" id="submit" type="submit" value="บันทึกข้อมูล" /></td>
		</tr>
	</table>
</div>
</form>
<script>
	function load_sub_cat()
	{
		var cat_id	=	$("#cat_id").val();
		$.ajax({
  			url: "/category/get_sub_category/"+cat_id,
  			cache: false
		}).done(function( html ) {
  			$("#show_sub_cat").html(html);
		});
	}
<? if(!empty($cat_id)){?>
			$.ajax({
  			url: "/category/get_sub_category/<?=$cat_id?>/<?=$sub_cat_id?>",
  			cache: false
		}).done(function( html ) {
  			$("#show_sub_cat").html(html);
		});
<?}?>
 $(document).ready(
  	function(){
  		  $( ".datepicker" ).datepicker({
      		showOn: "button",
      		buttonImage: "/assets/images/carlender.gif",
      		buttonImageOnly: true,
      		changeMonth: true,
      		changeYear: true,
      		dateFormat: "dd/mm/yy"
    	});
    	$("#deal_main_form").validate({
   	rules: {
     // simple rule, converted to {required:true}
     vendor_id:{
     	required:true
     }
     ,cat_id: {
     	required:true
     }
    ,sub_cat_id :{
    	required:true
    }
	,deal_name :{
		required:true
	}
	,deal_intro :{
		required:true
	}
	<? if($action=="insert"){?>
	,deal_index_image :{
		required:true
	}
	<? } ?>
	<? if($round_action!="update"){?>
	,round_start:
	{
		required:true
	}
	,round_end:
	{
		required:true
	}
	<? } ?>
	,deal_price_show :{
		required:true,
		number:true
	}
	,deal_buy_time_start :{
		required:true
	}
	,deal_buy_time_end :{
		required:true
	}
	,deal_start :{
		required:true
	}
	,deal_expile :{
		required:true
	}
	,deal_buy_count:
	{
		required:true,
		number:true
	}
	,deal_percent_off:
	{
		required:true,
		number:true
	}
	,deal_hilight_detail:
	{
		required:true
	}
	,deal_aboutus_detail:
	{
		required:true
	}
	,deal_main_detail:
	{
		required:true
	}
	,deal_address :{
		required:true
	}
   },
   messages: {
   	vendor_id: {
     	required:"กรุณาเลือกร้านค้าค่ะ"
    },
     cat_id: {
     	required:"กรุณาเลือกหมดวหมู่หลักค่ะ"
     }
    ,sub_cat_id :{
    	required:"กรุณาเลือกหมดวหมู่ย่อยค่ะ"
    }
	,deal_name :{
		required:"กรุณาระบุชื่อดีลค่ะ"
	}
	,deal_intro :{
		required:"กรุณาระบุรายละเอียดดีลค่ะ"
	}
	<? if($action=="insert"){?>
	,deal_index_image :{
		required:"กรุณาเลือกรูปดีลค่ะ"
	}
	<? } ?>
	<? if($round_action!="update"){?>
	,round_start:
	{
		required:"กรุณาระบุวันเริ่มรอบการขายดีลค่ะ"
	}
	,round_end:
	{
		required:"กรุณาระบุวันสิ้นสุดรอบการขายดีลค่ะ"
	}
	<? } ?>
	,deal_price_show :{
		required:"กรุณาระบุราคาที่แสดงค่ะ",
		number:"กรุณาระบุเฉพาะตัวเลขค่ะ"
	}
	,deal_buy_time_start :{
		required:"กรุณาระบุวันเริ่มเปิดขายค่ะ"
	}
	,deal_buy_time_end :{
		required:"กรุณาระบุวันสิ้นสุดการขายค่ะ"
	}
	,deal_start :{
		required:"กรุณาระบุวันเริ่มใช้คูปองได้ค่ะ"
	}
	,deal_expile :{
		required:"กรุณาวันหมดอายุคูปองค่ะ"
	}
	,deal_buy_count:
	{
		required:"กรุณาระบุจำนวนที่ขายไปค่ะ",
		number:"กรุณาระบุเฉพาะตัวเลขค่ะ"
	}
	,deal_percent_off:
	{
		required:"กรุณาระบุจำนวนส่วนลดค่ะ",
		number:"กรุณาระบุเฉพาะตัวเลขค่ะ"
	}
	,deal_hilight_detail:
	{
		required:"กรุณาระบุข้อความไฮไลน์ค่ะ"
	}
	,deal_aboutus_detail:
	{
		required:"กรุณาระบุข้อมูลเกี่ยวกับเราค่ะ"
	}
	,deal_main_detail:
	{
		required:"กรุณาระบุรายละเอียดดีลค่ะ"
	}
	,deal_address :{
		required:"กรุณาระบุที่อยู่ค่ะ"
	}
   }
});
});
</script>