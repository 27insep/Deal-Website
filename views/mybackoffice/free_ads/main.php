<div class="menu_add_box">
	<a href="/mybackoffice/iwantit/insert_form">เพิ่มข้อมูล</a>
</div>
<div>
<div class="clear">
	ช่วงวันที่บันทึก : <input id="start_date" name="start_date" value="" class="datePicker" /> &nbsp;จนถึงวันที่ &nbsp;<input id="end_date" name="end_date" value="" class="datePicker" />&nbsp;&nbsp; | &nbsp;&nbsp;สถานะ :
	 <select id="contact_status">
		<option value="2">ทั้งหมด</option>
		<option value="1">ติดต่อแล้ว</option>
		<option value="0">ยังไม่ได้ติดต่อ</option>	
	</select>
</div>
	<table cellpadding="0" cellspacing="1" border="0" class="display" id="show_data" width="100%">
		<thead>
			<th align="center">ลำดับ</th>
			<th align="center">ชื่อธุรกิจ/ร้านค้า</th>
			<th align="center">ชื่อ-นามสกุล</th>
			<th align="center">โทรศัพท์</th>
			<th align="center">อีเมล</th>
			<th align="center">เว็บไซด์</th>
			<th align="center">status</th>
			<th align="center">สถานะ</th>
			<th align="center">วันที่บันทึก</th>
			<th align="center">ไอพี</th>
			<th align="center">การจัดการ</th>
		</thead>
		<? 
		$i 		=	0;
		foreach($tbl_free_ads as $data){?>
			<tr>
				<td align="center"><?=++$i?></td>
				<td align="center"><?=$data["vendor_name"]?></td>
				<td align="center"><?=$data["contact_name"]?></td>
				<td align="center"><?=$data["contact_phone"]?></td>
				<td align="center"><?=$data["contact_email"];?></td>
				<td align="center"><?=$data["website"];?></td>
				<td align="center"><?=$data["contact_status"];?></td>
				<td align="center">
			   	<?if($data["contact_status"]==1){
			   			echo"ติดต่อแล้ว";
					}else{
						echo"ยังไม่ติดต่อ";
					}
				?>		
			   	</td>
				<td align="center"><?if($data["contact_time"] != "0000-00-00 00:00:00")echo date_format(date_create($data["contact_time"]),"d/m/Y H:i:s");?></td>
				<td align="center"><?=$data["ip"];?></td>
				<td align="center">
					<a href="/mybackoffice/free_ads/view_data/<?=$data["free_ads_id"]?>"><?=image_asset('/icon/info.png', '', array('alt'=>'รายละเอียด','title'=>'รายละเอียด'));?></a> |
					<a href="/mybackoffice/free_ads/update_form/<?=$data["free_ads_id"]?>"><?=image_asset('/icon/edit.png', '', array('alt'=>'แก้ไข','title'=>'แก้ไข'));?></a> |
					<a href="/mybackoffice/free_ads/delete/<?=$data["free_ads_id"]?>" onclick="if(confirm('ต้องการลบข้อมูลผู้ติดต่อโฆษณา  ใช่หรือไม่ ?')){return true;}else{return false;};">
							<?=image_asset('/icon/delete.png', '', array('alt'=>'ลบข้อมูล','title'=>'ลบข้อมูล'));?>
					</a>
				</td>
			</tr>
		<? } ?>
	</table>
</div>
<script type="text/javascript" charset="utf-8">
$.fn.dataTableExt.afnFiltering.push(
    function( oSettings, aData, iDataIndex ) {
        var st_date 			= $("#start_date").val();
        var end_date 		= $("#end_date").val();
         
        var contact_date 	= aData[8];

        var check_contact_date	=	false;

        if(st_date!="")
        st_date		=	str2date(st_date); 
        
        if(end_date!="")
        end_date	=	str2date(end_date);
        
        contact_date	=	str2date(contact_date);
        
        if ( st_date == "" && end_date == "" ){
            check_contact_date =	true;
        }else if ( st_date == "" && contact_date <= end_date ){
            check_contact_date =	 true;
        }else if ( st_date <= contact_date && "" == end_date ){
            check_contact_date = true;
        }else if ( st_date <= contact_date && contact_date <= end_date ){
            check_contact_date = true;
        }
       
     	var check_deal_status		=	false;
       	var status							= aData[6];
        var contact_status	= $("#contact_status").val();
        
        if(contact_status==2)
        {
        	check_deal_status	=	true;
        }else {
        	 if(contact_status==status)
        	 	check_deal_status	=	true;
        }
        
       if(check_contact_date && check_deal_status)
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
    	"aoColumns": [null,null,null,null,null,null,{ "bVisible": false },null,null,null,null] ,
    });

	$("#contact_status").change(
		function(){
			oTable.fnDraw();
		}
	);
	
	$("#contact_status").change(
		function(){
			oTable.fnDraw();
		}
	);
</script>