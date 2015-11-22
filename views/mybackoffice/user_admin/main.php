<div class="menu_add_box">
	<a href="/mybackoffice/user_admin/insert_form">เพิ่มข้อมูล</a>
</div>
<div class="clear">
	สถานะ : 
	<select id="admin_status">
		<option value="0">ทั้งหมด</option>
		<option value="1">active</option>
		<option value="2">not active</option>
	</select>
	กลุ่มผู้ใช้ : 
	<select id="admin_type">
		<option value="0">ทั้งหมด</option>
		<option value="1">ผู้ดูแลระบบ</option>
		<option value="2">ผู้จัดการ</option>
		<option value="3">พนักงาน</option>
	</select>
	<? 
		$today	=	date("d/m/Y",time());
	?>
	วันที่เพิ่มข้อมูล : <input id="start_date" name="start_date" value="" class="datePicker" /> ถึง <input id="end_date" name="end_date" value="<?=$today?>" class="datePicker" />  
</div>
<div>
	<table cellpadding="0" cellspacing="1" border="0" class="display" id="show_data" width="100%">
		<thead>
			<th>ลำดับ</th>
			<th>Username</th>
			<th>ชื่อ-นามสกุล</th>
			<th>กลุ่ม</th>
			<th>วันที่เพิ่มข้อมูล</th>
			<th>admin_status</th>
			<th>admin_type</th>
			<th>วันที่แก้ไขข้อมูล</th>
			<th>สถานะ</th>
			<th>เครื่องมือ</th>
		</thead>
		<? 
		$i 		=	0;
		$admin_type	=	array("1"=>"ผู้ดูแลระบบ","2"=>"ผู้จัดการ","3"=>"พนักงาน");
		
		foreach($tbl_admin as $data){?>
			<tr>
				<td align="center"><?=++$i?></td>
				<td align="left"><?=$data["admin_user"]?></td>
				<td align="center"><?=$data["admin_name"]?></td>
				<td align="center"><?=$admin_type[$data["admin_type"]]?></td>
				<td align="center"><?=date("d/m/Y H:i:s",strtotime($data["admin_create"]));?></td>
				<td align="center"><?=$data["admin_status"]?></td>
				<td align="center"><?=$data["admin_type"]?></td>
				<td align="center"><?=date("d/m/Y H:i:s",strtotime($data["admin_modify"]));?></td>
				<td align="center">
					   	<?if($data["admin_status"]==1){
					   			echo image_asset('/icon/active.png', '', array('alt'=>'active','title'=>'active'));
							}else{
								echo image_asset('/icon/inactive.png', '', array('alt'=>'not active','title'=>'not active'));
							}
						?>		
					   	</td>
				<td align="center">
					<a href="/mybackoffice/user_admin/view_data/<?=$data["admin_id"]?>"><?=image_asset('/icon/info.png', '', array('alt'=>'รายละเอียด','title'=>'รายละเอียด'));?></a> |
					<a href="/mybackoffice/log_admin/<?=$data["admin_id"]?>"><?=image_asset('/icon/find.png', '', array('alt'=>'ประวัติการใช้งาน','title'=>'ประวัติการใช้งาน'));?></a> |
					<a href="/mybackoffice/user_admin/update_form/<?=$data["admin_id"]?>"><?=image_asset('/icon/edit.png', '', array('alt'=>'แก้ไข','title'=>'แก้ไข'));?></a> |
					<a href="/mybackoffice/user_admin/delete/<?=$data["admin_id"]?>" onclick="if(confirm('ต้องการลบข้อมูลผู้ใช้งานระบบ  ใช่หรือไม่ ?')){return true;}else{return false;};">
							<?=image_asset('/icon/delete.png', '', array('alt'=>'ลบข้อมูล','title'=>'ลบข้อมูล'));?>
					</a>
				</td>
			</tr>
		<? } ?>
	</table>
</div>
<script type="text/javascript" charset="utf-8">
		var oTable =  $('#show_data').dataTable({
    	"aoColumns": [null,null,null,null,null,{ "bVisible": false },{ "bVisible": false },null,null,null]
    });
/* Custom filtering function which will filter data in column four between two values */
$.fn.dataTableExt.afnFiltering.push(
    function( oSettings, aData, iDataIndex ) {
        var st_date 		= $("#start_date").val();
        var end_date 	= $("#end_date").val();
        var regis_date 	= aData[4];
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
        
       	var check_admin_status		=	false;
       	var status							= aData[5];
        var admin_status				= $("#admin_status").val();
        
        if(admin_status==0)
        {
        	check_admin_status	=	true;
        }else{
        	 if(admin_status==status)
        	 {
        	 	check_admin_status	=	true;
        	 }else{
        	 	check_admin_status	=	false;
        	 }
        }
        
        var check_admin_type		=	false;
       	var type							= aData[6];
        var admin_type					= $("#admin_type").val();
        
        if(admin_type==0)
        {
        	check_admin_type	=	true;
        }else{
        	 if(admin_type==type)
        	 {
        	 	check_admin_type	=	true;
        	 }else{
        	 	check_admin_type	=	false;
        	 }
        }
        
        if(check_date_range&&check_admin_status&&check_admin_type)
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
    	
	$("#admin_status").change(
		function(){
			oTable.fnDraw();
		}
	);
    $("#admin_type").change(
		function(){
			oTable.fnDraw();
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
    function delete_data(row_id,add_text)
	{
		if(confirm('ต้องการลบข้อมูลมาชิก  '+add_text))
		{
			$.ajax({
	  			type: "POST",
	  			url: '/mybackoffice/member_profile/delete/'+row_id
				}).done(function( msg ) {
						alert("ทำการลบข้อมูลเรียบร้อยแล้วค่ะ !");
						oTable.fnDeleteRow(document.getElementById("row_"+row_id));
						//window.location.href='/mybackoffice/member_profile/';
						return true;
			});	
			}else{
				return false;
			}
	}
</script>