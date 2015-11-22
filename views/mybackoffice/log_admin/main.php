<div class="clear" style="margin: 25px 0 15px 0;">
	การใช้งาน : 
	<select id="admin_action">
		<option value="0">ทั้งหมด</option>
		<? foreach($admin_log_code as $index=>$action){?>
			<option value="<?=$index?>"><?=$action?></option>
		<?}?>
	</select>
	<? 
		$today	=	date("d/m/Y",time());
	?>
	วันทีใช้งาน : <input id="start_date" name="start_date" value="" class="datePicker" /> ถึง <input id="end_date" name="end_date" value="<?=$today?>" class="datePicker" />  
</div>
<div>
	<table cellpadding="0" cellspacing="1" border="0" class="display" id="show_data" width="100%">
		<thead>
			<th>ลำดับ</th>
			<th>ชื่อผู้ใช้</th>
			<th>ชื่อ-นามสกุล</th>
			<th>การใช้งาน</th>
			<th>action type</th>
			<th>ข้อมูล</th>
			<th>วันที่ใช้งาน</th>
			<th>ไอพี</th>
		</thead>
		<? 
		$i 		=	0;
		foreach($admin_log_data as $data){?>
			<tr>
				<td align="center"><?=++$i?></td>
				<td align="center"><?=$data["admin_user"]?></td>
				<td align="center"><?=$data["admin_name"]?></td>
				<td align="center"><?=$admin_log_code[$data["action_type"]]?></td>
				<td align="center"><?=$data["action_type"]?></td>
				<td align="center"><?=$data["action_comment"]?></td>
				<td align="center"><?=date("d/m/Y H:i:s",strtotime($data["log_time"]))?></td>
				<td align="center"><?=$data["admin_ip"]?></td>
			</tr>
		<? } ?>
	</table>
</div>
<script type="text/javascript" charset="utf-8">
		var oTable =  $('#show_data').dataTable({
    	"aoColumns": [null,null,null,null,{ "bVisible": false },null,null,null]
    });
/* Custom filtering function which will filter data in column four between two values */
$.fn.dataTableExt.afnFiltering.push(
    function( oSettings, aData, iDataIndex ) 
    {
    	var st_date 		= $("#start_date").val();
        var end_date 	= $("#end_date").val();
        var regis_date 	= aData[6];
        var check_date_range	=	false;
        
        st_date		=	str2date(st_date);
        end_date	=	str2date(end_date);
        regis_date	=	str2date(regis_date);
        
        if ( st_date == "" && end_date == "" )
        {
            check_date_range =	true;
        }
        else if ( st_date == "" && regis_date <= end_date )
        {
            check_date_range =	 true;
        }
        else if ( st_date < regis_date && "" == end_date )
        {
            check_date_range = true;
        }
        else if ( st_date <= regis_date && regis_date <= end_date )
        {
            check_date_range = true;
        }
        
        var check_admin_action		=	false;
       	var action							= aData[4];
        var admin_action				= $("#admin_action").val();
        
        if(admin_action==0)
        {
        	check_admin_action	=	true;
        }else{
        	 if(admin_action==action)
        	 {
        	 	check_admin_action	=	true;
        	 }else{
        	 	check_admin_action	=	false;
        	 }
        }
        
        if(check_admin_action&&check_date_range)
        {
        	return true;
        }else{
        	return false;
        }
    }
);
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
	$("#admin_action").change(
		function(){
			oTable.fnDraw();
		}
	);
</script>