<div class="menu_add_box">
	<? if(!isset($vendor_id)){?>
		<a href="/mybackoffice/deal_main/insert_form">เพิ่มข้อมูล</a>
	<? }else{?>
		<a href="/mybackoffice/deal_main/insert_form/0/<?=$vendor_id?>">เพิ่มข้อมูล</a>
	<? } ?>
</div>
<br>
<?if(isset($vendor)){?>
<div class="div_head">
		<div class="head_deal">ชื่อร้านค้า &nbsp; : &nbsp;  <?=$vendor["vendor_name"]?></div>
</div>
<?}?>
<br>
<div class="clear">
	เริ่มขาย : <input id="start_date" name="start_date" value="" class="datePicker" /> &nbsp;จนถึงวันที่ &nbsp;<input id="end_date" name="end_date" value="" class="datePicker" />&nbsp;&nbsp; | &nbsp;&nbsp;สถานะ :
	 <select id="deal_status">
		<option value="2">ทั้งหมด</option>
		<option value="1">Open</option>
		<option value="0">Close</option>	
	</select>
	| &nbsp;&nbsp;หมวดหลัก :
	<select id="cat_id" onchange="load_sub_cat()">
		<option value="0">ทั้งหมด</option>	
		<?
			foreach ($cat_data as $key => $value) {
		?>
			<option value="<?=$value["cat_id"]?>"><?=$value["cat_name"]?></option>	
		<?
			}
		?>
	</select>
	| &nbsp;&nbsp;หมวดย่อย :
	<select id="show_sub_cat">
		<option value="0">ทั้งหมด</option>	
	</select>
</div>
<div>
	<table cellpadding="0" cellspacing="1" border="0" class="display" id="show_data" width="100%">
		<thead>
			<th width="80">รูปภาพ</th>
			<th>ชื่อดีล</th>
			<th width="50">ราคา</th>
			<th>ส่วนลด</th>
			<th>วันที่กำหนดเริ่มขาย</th>
			<th>วันที่กำหนดปิดการขาย</th>
			<th>รอบวันที่เปิดขาย</th>
			<th>รอบวันที่ปิดขาย</th>
			<th>จำนวนรอบการขาย</th>
			<th>ร้านค้า</th>
			<th>หมวดหลัก</th>
			<th>หมวดย่อย</th>
			<th>คำสั่งซื้อ</th>
			<th>คูปอง</th>
			<th>status</th>
			<th>cat_id</th>
			<th>sub_cat_id</th>
			<th>สถานะ</th>
			<th width="90">การจัดการ</th>
		</thead>
		<?
			foreach($deal_data as $deal)
			{
				$index	=	$deal["deal_id"];
		?>
			<tr>
				<td align="center"><?=image_asset($deal["deal_index_image"], '', array('alt'=>$deal["deal_name"],'title'=>$deal["deal_name"],'width'=>'120','height'=>'82'));?></td>
				<td><?if(isset($deal["deal_name"])) echo $deal["deal_name"];?></td>
				<td align="center"><? echo "฿ ".number_format($deal["deal_price_show"]);?></td>
				<td align="center"><? echo $deal["deal_percent_off"];?>%</td>
				<td align="center"><? if(isset($deal_option[$index]["now_round_start"])){echo date("d/m/Y",strtotime($deal_option[$index]["now_round_start"]));}?></td>
				<td align="center"><? if(isset($deal_option[$index]["now_round_end"])){echo date("d/m/Y",strtotime($deal_option[$index]["now_round_end"]));}?></td>
				<td align="center"><? if(isset($deal["deal_buy_time_start"])){echo date("d/m/Y",strtotime($deal["deal_buy_time_start"]));}?></td>
				<td align="center"><?  if(isset($deal["deal_buy_time_end"])){echo date("d/m/Y",strtotime($deal["deal_buy_time_end"]));}?></td>
				<td align="center"><?if(isset($deal["deal_reopen"])) echo $deal["deal_reopen"]?></td>
				<td align="center"><? if(isset($deal["vendor_name"])) echo $deal["vendor_name"];?></td>
				<td align="center"><? if(isset($cat_data[$deal["cat_id"]]["cat_name"])) echo $cat_data[$deal["cat_id"]]["cat_name"];?></td>
				<td align="center"><? if(isset($sub_cat_data[$deal["sub_cat_id"]]["sub_cat_name"])) echo $sub_cat_data[$deal["sub_cat_id"]]["sub_cat_name"];?></td>
				<td align="center" style="color:#0000FF;cursor: pointer;" onclick="window.location.href = '/mybackoffice/deal_order/main/0/0/<?=$deal["deal_id"]?>/2'"><?if(isset($deal_option[$index]["now_order"])){?><?=$deal_option[$index]["now_order"]?><?}?></td>
				<td align="center" style="color:#0000FF;cursor: pointer;" onclick="window.location.href = '/mybackoffice/coupon_manage/main/0/<?=$deal["deal_id"]?>/2'"><?if(isset($deal_option[$index]["now_coupon"])){?><?=$deal_option[$index]["now_coupon"]?><?}?></td>
				<td><?=$deal["deal_status"]?></td>
				<td><?=$deal["cat_id"]?></td>
				<td><?=$deal["sub_cat_id"]?></td>
				<td align="center""><?if($deal["deal_status"]==1){
			   			echo image_asset('/icon/active.png', '', array('alt'=>'active','title'=>'active'))." open";
					}else{
						echo image_asset('/icon/inactive.png', '', array('alt'=>'not active','title'=>'not active'))." close";
					}
				?>	</td>
				<td>
					<a href="/category/deal_preview/<?=$deal["deal_id"]?>/<?=urlencode($deal["deal_name"])?>/" target="_blank"><?=image_asset('/icon/info.png', '', array('alt'=>'รายละเอียด','title'=>'รายละเอียด'));?></a> |
					<a href="/mybackoffice/deal_main/update_form/<?=$deal["deal_id"]?>/<?if(isset($vendor_id)) echo $vendor_id;?>"><?=image_asset('/icon/edit.png', '', array('alt'=>'แก้ไข','title'=>'แก้ไข'));?></a> |
					<a href="/mybackoffice/deal_gallery/<?=$deal["deal_id"]?>"><?=image_asset('/icon/add_gallery.png', '', array('alt'=>'เพิ่มรูปในแกลลอรี่','title'=>'เพิ่มรูปในแกลลอรี่'));?></a> <br/>
					<a href="/mybackoffice/deal_slide/<?=$deal["deal_id"]?>"><?=image_asset('/icon/add_slide.png', '', array('alt'=>'เพิ่มรูปในสไลด์','title'=>'เพิ่มรูปในสไลด์'));?></a> |
					<a href="/mybackoffice/deal_product/main/0/<?=$deal["deal_id"]?>"><?=image_asset('/icon/note.png', '', array('alt'=>'voucher','title'=>'ข้อมูลแคมเปญ'));?></a> |
					<?if($admin_type!=3){?> 
					<a href="/mybackoffice/deal_main/delete/<?=$deal["deal_id"]?>/<?if(isset($vendor_id)) echo $vendor_id;?>" onclick="if(confirm('ต้องการลบแคมเปญ <?=$deal["deal_name"]?> ?')){return true;}else{return false;};">
							<?=image_asset('/icon/delete.png', '', array('alt'=>'ลบข้อมูล','title'=>'ลบข้อมูล'));?>
					</a>
					<?}?>
					<!--
					<a href="/mybackoffice/deal_order/main/0/0/<?=$deal["deal_id"]?>/2"><?=image_asset('/icon/order.png', '', array('alt'=>'ใบสั่งซื้อ','title'=>'ใบสั่งซื้อ'));?></a> |
					<a href="/mybackoffice/coupon_manage/main/0/<?=$deal["deal_id"]?>/2"><?=image_asset('/icon/info.png', '', array('alt'=>'คูปอง','title'=>'คูปอง'));?></a>
					-->
				</td>
		</tr>		
		<?
			}
		?>
	</table>
</div>
<script type="text/javascript" charset="utf-8">
$.fn.dataTableExt.afnFiltering.push(
    function( oSettings, aData, iDataIndex ) {
        var st_date 			= $("#start_date").val();
        var end_date 		= $("#end_date").val();
        var date_status		= $("#date_status").val();
         
        var deal_open 		= aData[4];
        var deal_close 		= aData[5];

        var check_deal_date	=	false;

        if(st_date!="")
        st_date		=	str2date(st_date); 
        
        if(end_date!="")
        end_date	=	str2date(end_date);
        
        deal_open	=	str2date(deal_open);
        deal_close	=	str2date(deal_close);
        
        if(date_status==0)
        {
        	check_deal_date	=	true;
        }else {
        	if ( st_date == "" && end_date == "" ){
            	check_deal_date =	true;
        	}else if ( st_date == "" && deal_open <= end_date ){
            	check_deal_date =	 true;
        	}else if ( st_date <= deal_open && "" == end_date ){
            	check_deal_date = true;
        	}else if ( st_date <= deal_open && deal_open <= end_date ){
            	check_deal_date = true;
        	}
        }
       
     	var check_deal_status		=	false;
       	var status							= aData[14];
        var deal_status	= $("#deal_status").val();
        
        if(deal_status==2)
        {
        	check_deal_status	=	true;
        }else {
        	 if(deal_status==status)
        	 	check_deal_status	=	true;
        }
        
        var check_deal_cat	=	false;
       	var cat_name			= aData[15];
        var deal_cat			= $("#cat_id").val();
        
       if(deal_cat=="0")
        {
        	check_deal_cat		=	true;
       }else {
        	if(cat_name==deal_cat)
        	 check_deal_cat	=	true;
       }
        
        var check_deal_sub_cat		=	false;
       	var sub_cat_name			= aData[16];
        var deal_sub_cat				= $("#show_sub_cat").val();
        
       if(deal_sub_cat=="0"||deal_sub_cat=="")
        {
        	check_deal_sub_cat		=	true;
       }else {
        	if(sub_cat_name==deal_sub_cat)
        	 check_deal_sub_cat	=	true;
       }
        
       if(check_deal_date &&check_deal_status&&check_deal_cat&&check_deal_sub_cat)
       		return true;
       else
       		return false;
    }
);
 function str2date(args)
    {
    	if(args.length>1)
    	{
    		args	=	args.substring(0, 10);
        	var iDay, iMonth, iYear;
        	var arrValues;
        	arrValues = args.split("/");
        	iMonth 	= arrValues[1];
        	iDay 		= arrValues[0];
        	iYear 	= arrValues[2];

        	var newDate = new Date(iYear, iMonth, iDay);

			return newDate;
		}else{
			return "";		
		}
    }
    
    $( ".datePicker" ).datepicker({
      		showOn: "button",
      		buttonImage: "/assets/images/carlender.gif",
      		buttonImageOnly: true,
      		changeMonth: true,
      		changeYear: true,
      		dateFormat: "dd/mm/yy",
      		onClose:function()
      		{
      			oTable.fnDraw();
      		}
    	});
    	
 var oTable = $('#show_data').dataTable({
 		"sScrollX": "1500px",
    	"aoColumns": [null,null,null,null,null,null,null,null,null,null,null,null,null,null,{ "bVisible": false },{ "bVisible": false },{ "bVisible": false },null,null] ,
    });

	$("#deal_status").change(
		function(){
			oTable.fnDraw();
		}
	);
	
	$("#date_status").change(
		function(){
			oTable.fnDraw();
		}
	);
	$("#cat_id").change(
		function(){
			oTable.fnDraw();
		}
	);
	$("#show_sub_cat").change(
		function(){
			oTable.fnDraw();
		}
	);
		function load_sub_cat()
	{
		var cat_id	=	$("#cat_id").val();
		$.ajax({
  			url: "/category/get_sub_category/"+cat_id,
  			cache: false
		}).done(function( html ) {
  			$("#show_sub_cat").html(html);
  			$("#show_sub_cat :first-child").html("ทั้งหมด");
		});
	}
</script>