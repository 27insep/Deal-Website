<div class="menu_add_box"></div>
<div class="clear">
	<select id="coupon_create">
		<option value="0">ทั้งหมด</option>
		<option value="1">วันที่ออกคูปอง</option>
		<option value="2">วันที่ใช้คูปอง</option>	
	</select>  &nbsp; &nbsp; |&nbsp&nbsp
	<? 
		$today	=	date("d/m/Y",time());
		if(!empty($filter_id))	$today	=	"";
	?>
	เริ่มวันที่ : <input id="start_date" name="start_date" value="<?=$today?>" class="datePicker" /> &nbsp;ถึงวันที่ &nbsp;<input id="end_date" name="end_date" value="<?=$today?>" class="datePicker" />&nbsp;&nbsp; | &nbsp;&nbsp;
	<select id="coupon_status">
		<option value="0">สถานะการใช้งานทั้งหมด</option>
		<option value="2">ใช้แล้ว</option>
		<option value="1">ยังไม่ได้ใช้</option>	
	</select> 
</div>
<div>
	<table cellpadding="0" cellspacing="1" border="0" class="display" id="show_data" width="100%">
		<thead>
			<th width="120px;">ร้านค้า</th>
			<th width="120px;">แคมเปญ</th>
			<th width="120px;">หมายเลข<br/>คูปอง</th>
			<th width="120px;">เลขบารโค้ด</th>
			<th width="120px;">หมายเลขสั่งซื้อ</th>
			<th width="120px;">รหัสลูกค้า</th>
			<th width="150px;">ชื่อลูกค้า</th>
			<th width="150px;">รหัสยืนยัน</th>
			<th width="100px;">วันที่ออก</th>
			<th width="100px;">วันที่ใช้</th>
			<th width="100px;">วันที่หมดอายุ</th>
			<th width="100px;">สถานะ</th>
			<th width="90px;">สถานการใช้</th>
			<th width="90px;">พิมพ์</th>
		</thead>
		<? 
		$i=0;
		foreach($coupon_data as $data){?>
		<tr>
			<td align="center" class="deal_link"><a href="/mybackoffice/vendor_profile/view_data/<?=$data["vendor_id"]?>" target="_blank"><?=$data["vendor_name"]?></a></td>
			<td align="center" class="deal_link"><a href="/category/deal_preview/<?=$data["deal_id"]?>/".urlencode($data["deal_name"])." target=" _blank"><?=$data["deal_name"]?></a></td>
			<td align="center"><?=$data["voucher_number"]?></td>
			<td align="center"><?=$data["barcode"]?></td>
			<td align="center" class="deal_link"><a href="/mybackoffice/deal_order/view_data/<?=$data["order_id"]?>/<?=$data["mem_id"]?>" target="_blank"><?=$data["order_id"]?></a></td>
			<td align="center" class="deal_link"><a href="/mybackoffice/member_profile/view_data/<?=$data["mem_id"]?>" target="_blank"><?=$data["mem_id"]?></a></td>
			<td align="center" class="deal_link"><a href="/mybackoffice/member_profile/view_data/<?=$data["mem_id"]?>" target="_blank"><?=$data["member_name"]." ".$data["member_sname"]?></a></td>
			<td align="center"><?=$data["redemption_code"]?></td>
			<td align="center"><?=$data["coupon_create_time"]!=""?date("d/m/Y",strtotime($data["coupon_create_time"])):"";?></td>
			<td align="center"><?=$data["coupon_use_date"]!=""?date("d/m/Y",strtotime($data["coupon_use_date"])):"";?></td>
			<td align="center"><?=$data["coupon_expire"]!=""?date("d/m/Y",strtotime($data["coupon_expire"])):"";?></td>
			<td align="center"><?=$data["coupon_status"]?></td>
			<td align="center">
			<? 
				if($data["coupon_status"]==2)
				{
			?>
					<img id="icon_<?=$data["coupon_id"]?>" class="can_click" src="/assets/images/used_button.png" onclick="change_status(1,<?=$data["coupon_id"]?>)"/>
			<?
				}else{
			?>
					<img id="icon_<?=$data["coupon_id"]?>" class="can_click" src="/assets/images/not_used_button.png" onclick="change_status(2,<?=$data["coupon_id"]?>)"/>
			<?
				}
			?>
			</td>
			<td align="center"><a href="/mybackoffice/print_coupon/<?=$data["deal_id"]?>/<?=$data["coupon_id"]?>/<?=$data["member_id"]?>" target="_blank"><img src="/assets/images/merchant/vendor_print.png" border="0"/></a></td>
		</tr>
		<? } ?>
	</table>
</div>
<script type="text/javascript" charset="utf-8">
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
    	
/* Custom filtering function which will filter data in column four between two values */
$.fn.dataTableExt.afnFiltering.push(
    function( oSettings, aData, iDataIndex ) {
    	var st_date 		= $("#start_date").val();
        var end_date 	= $("#end_date").val();
         var coupon_create	= $("#coupon_create").val();
    	
    	var coupon_create_time = "";
         var coupon_use_date = "";
    	
    	 if(coupon_create == '0')
         {
        	coupon_create_time 	= aData[8];
        	coupon_use_date 	= aData[9];
        }
        else if(coupon_create == '1')
        	coupon_create_time 	= aData[8];
        else 	
       		coupon_use_date = aData[9];
    	
    	var check_coupon_create_time	=	false;
        var check_coupon_use_date	=	false;
        
        st_date		=	str2date(st_date);
        end_date	=	str2date(end_date);
        coupon_create_time	=	str2date(coupon_create_time);
        coupon_use_date	=	str2date(coupon_use_date);
        
        if(coupon_create_time != "")
        {
	        if ( st_date == "" && end_date == "" )
	        {
	            check_coupon_create_time =	true;
	        }
	        else if ( st_date == "" && coupon_create_time <= end_date )
	        {
	            check_coupon_create_time =	 true;
	        }
	        else if ( st_date < coupon_create_time && "" == end_date )
	        {
	            check_coupon_create_time = true;
	        }
	        else if ( st_date <= coupon_create_time && coupon_create_time <= end_date )
	        {
	            check_coupon_create_time = true;
	        }
        }
        
      if(coupon_use_date != "")
        {
        	if ( st_date == "" && end_date == "" )
	        {
	            check_coupon_use_date =	true;
	        }
	        else if ( st_date == "" && coupon_use_date <= end_date )
	        {
	            check_coupon_use_date =	 true;
	        }
	        else if ( st_date < coupon_use_date && "" == end_date )
	        {
	            check_coupon_use_date = true;
	        }
	        else if ( st_date <= coupon_use_date && coupon_use_date <= end_date )
	        {
	            check_coupon_use_date = true;
	        }
        }
        
        
       	var check_coupon_status	=	false;
       	var status		= aData[11];
        var coupon_status	= $("#coupon_status").val();
      
        if(coupon_status==0)
        {
        	check_coupon_status	=	true;
        }else
        {
        	 if((coupon_status==status))
        	 {
        	 	check_coupon_status	=	true;
        	 }else{
        	 	check_coupon_status	=	false;
        	 }
        }
        
         if((check_coupon_create_time || check_coupon_use_date) && check_coupon_status)
       		return true;
       else
       		return false;
   			//return check_coupon_status;
    }
);


    var oTable = $('#show_data').dataTable({
    	"aoColumnDefs": [
            { "bVisible": false,  "aTargets": [ 11 ] }
        ]
    });
	function change_status(status,coupon_id)
	{
		$.ajax({
  			url: "/coupon/change_status_coupon/"+status+"/"+coupon_id,
			}).done(function( msg ) {
  				if(status==2)
  				{
  					$("#icon_"+coupon_id).attr("src","/assets/images/used_button.png");
  				}
  				if(status==1)
  				{
  					$("#icon_"+coupon_id).attr("src","/assets/images/not_used_button.png");
  				}
  		});	
	}
	
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
    
		$("#coupon_create").change(
		function(){
			oTable.fnDraw();
		}
	);
	
	$("#coupon_status").change(
		function(){
			oTable.fnDraw();
		}
	);
	
</script>