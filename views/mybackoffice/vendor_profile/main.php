<div class="menu_add_box">
	<a href="/mybackoffice/vendor_profile/insert_form">เพิ่มข้อมูล</a>
</div>
<div class="clear">
	<? $today	=	date("d/m/Y",time());?>
	วันที่สมัคร : <input id="start_date" name="start_date" value="<?=$today?>" class="datePicker" /> ถึง <input id="end_date" name="end_date" value="<?=$today?>" class="datePicker" /> 
	 | คำสั่งซื้อ : 
	<select id="status">
		<option value="2">ทั้งหมด</option>
		<option value="1">ใช้งานได้</option>
		<option value="0">ไม่สามารถใช้งานได้</option>	
	</select> 
</div>
<div>
	<table cellpadding="0" cellspacing="1" border="0" class="display" id="show_data" width="100%">
		<thead>
			<th>ลำดับ</th>
			<th>ชื่อร้านขายดีล</th>
			<th>อีเมล</th>
			<th>เบอร์ติดต่อ</th>
			<!--<th>วันที่เปิดใช้</th>-->
			<th width="100px">แก้ไขล่าสุด</th>
			<th>คำสั่งซื้อ</th>
			<th>คูปอง</th>
			<th>รายได้</th>
			<th>สถานะ</th>
			<th>สถานะ</th>
			<th>เครื่องมือ</th>
		</thead>
		<? 
		$i 		=	0;
		foreach($tbl_vendor_profile as $data){?>
			<tr id="row_<?=$data["vendor_id"]?>">
				<td align="center"><?=++$i?></td>
				<td align="center"><?=$data["vendor_name"]?></td>
				<td align="center"><?=$data["vendor_email"]?></td>
				<td align="center"><?=$data["vendor_phone"]?></td>
				<!--<td align="center"><?=date("d/m/Y H:i:s",strtotime($data["vendor_create"]));?></td>-->
				<td align="center"><?=date("d/m/Y H:i:s",strtotime($data["vendor_modify"]));?></td>
				<td align="center"><a href='/mybackoffice/deal_order/main/0/0/<?=$data["vendor_id"]?>/1'><?=number_format($other_data[$data["vendor_id"]]["nOrder"])?></a></td>
				<td align="center"><a href='/mybackoffice/coupon_manage/main/0/<?=$data["vendor_id"]?>/1'><?=number_format($other_data[$data["vendor_id"]]["nCoupon"])?></a></td>
				<td align="center"><a><?=number_format($other_data[$data["vendor_id"]]["nIncome"])?></a></td>
				<td align="center"><?=$data["vendor_status"]?></td>
				<td align="center">
			   	<?if($data["vendor_status"]==1){
			   			echo image_asset('/icon/active.png', '', array('alt'=>'active','title'=>'active'));
					}else{
						echo image_asset('/icon/inactive.png', '', array('alt'=>'not active','title'=>'not active'));
					}
				?>		
			   	</td>
				<td align="center">
					<a href="/mybackoffice/vendor_profile/view_data/<?=$data["vendor_id"]?>"><?=image_asset('/icon/info.png', '', array('alt'=>'รายละเอียด','title'=>'รายละเอียด'));?></a> |
					<a href="/mybackoffice/vendor_profile/update_form/<?=$data["vendor_id"]?>"><?=image_asset('/icon/edit.png', '', array('alt'=>'แก้ไข','title'=>'แก้ไข'));?></a> | 
					<a href="/mybackoffice/deal_main/main/0/<?=$data["vendor_id"]?>"><?=image_asset('/icon/campaign.png', '', array('alt'=>'ดีล','title'=>'ดีล'));?></a> <br/>
					<a href="#" onclick="send_password('<?=$data["vendor_id"]?>')"><?=image_asset('/icon/send_password.png', '', array('alt'=>'แจ้งรหัสผ่าน','title'=>'แจ้งรหัสผ่าน'));?></a> |
					<a href="#" onclick="reset_password('<?=$data["vendor_id"]?>')"><?=image_asset('/icon/reset_password.png', '', array('alt'=>'รีเซ็ตรหัสผ่าน','title'=>'รีเซ็ตรหัสผ่าน'));?></a> |
					<a href="#" onclick="send_email_to_vendor('<?=$data["vendor_id"]?>')"><?=image_asset('/icon/email.png', '', array('alt'=>'ส่งอีเมลแจ้งเปิดใช้งานหลังบ้าน','title'=>'ส่งอีเมลแจ้งเปิดใช้งานหลังบ้าน'));?></a><br/>
					<a href="/mybackoffice/show_vendor_sell/<?=$data["vendor_id"]?>" target="_blank"><?=image_asset('/icon/view.png', '', array('alt'=>'รายได้ของร้านค้า','title'=>'รายได้ของร้านค้า'));?></a> 
					<?if($admin_type!=3){?>
					 | <a href="#" onclick="delete_data('<?=$data["vendor_id"]?>','<?=$data["vendor_name"]?>')">
							<?=image_asset('/icon/delete.png', '', array('alt'=>'ลบข้อมูล','title'=>'ลบข้อมูล'));?>
					</a>
					<?}?>
				</td>
			</tr>
		<? } ?>
	</table>
</div>
<script type="text/javascript" charset="utf-8">
    function send_password(vendor_id)
    {
    	//alert(vendor_id);
    	$.ajax({
  			type: "POST",
  			url: '/mybackoffice/vendor_profile/send_password/'+vendor_id
			}).done(function( msg ) {
					alert("แจ้งรหัสผ่านเรียบร้อยแล้วค่ะ !");
		});
    }
    
    function reset_password(vendor_id)
    {
    	//alert(vendor_id);
    	$.ajax({
  			type: "POST",
  			url: '/mybackoffice/vendor_profile/reset_password/'+vendor_id
			}).done(function( msg ) {
					alert("ส่งอีเมล์การเปลี่ยนรหัสผ่านเรียบร้อยแล้วค่ะ !");
		});
    }
    
	function send_email_to_vendor(vendor_id)
    {
    	//alert(vendor_id);
    	$.ajax({
  			type: "POST",
  			url: '/mybackoffice/send_email_to_vendor/'+vendor_id
			}).done(function( msg ) {
					alert("ส่ง E-Mail เรียบร้อยแล้วค่ะ !");
		});
    }
	
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
        
       	var check_status		=	false;
       	var status					= aData[6];
        var show_status		= $("#status").val();
        
        if(show_status==2)
        {
        	check_buy_status	=	true;
        }else
        {
        	 if((show_status==status))
        	 {
        	 	check_buy_status	=	true;
        	 }else{
        	 	check_buy_status	=	false;
        	 }
        }
        
        if(check_date_range&&check_buy_status)
        {
        	return true;
        }else{
        	return false;
        }
    }
);
    var oTable = $('#show_data').dataTable( {
		"aoColumns": [  null, null,null, null,null, null,null, null,{ "bVisible":    false },null,null] 
		} );
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
    	
	$("#status").change(
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
	if(confirm('ต้องการลบร้านค้า  '+add_text))
	{
		$.ajax({
  			type: "POST",
  			url: '/mybackoffice/vendor_profile/delete/'+row_id
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