<?
function show_date($date)
{
	$date	=	date("d/m/Y",strtotime($date));
	return $date;
}
?>
<div class="menu_add_box"></div>
<div class="clear">
	<? 
		//$today	=	date("d/m/Y",time());
		$today	=	"";
	?>
	<table width="100%" border="0">
		<tr>
			<td>ร้านค้า :</td>
			<td>
					<select id="vendor_id" name="vendor_id">
							<option value="0">ทั้งหมด</option>
							<? foreach($vendor_data as $index=>$vendor){?>
								<option value="<?=$index?>"><?=$vendor?></option>	
							<?}?>
					</select>
			</td>
			<td>สถานะร้านค้า</td>
			<td>
					<select id="vendor_status" name="vendor_status">
						<option value="0">ทั้งหมด</option>
						<option value="1">Active</option>
						<option value="2">Not Active</option>	
					</select> 
			</td>
		</tr>
		<tr>
			<td>วันที่กำหนดเริ่มขาย : </td>
			<td><input id="st_buy_start_date" name="st_buy_start_date" value="<?=$today?>" class="datePicker" /> &nbsp;ถึงวันที่ &nbsp;<input id="st_buy_end_date" name="st_buy_end_date" value="<?=$today?>" class="datePicker" /></td>
			<td>วันปิดขาย : </td>
			<td> <input id="end_buy_start_date" name="end_buy_start_date" value="<?=$today?>" class="datePicker" /> &nbsp;ถึงวันที่ &nbsp;<input id="end_buy_end_date" name="end_buy_end_date" value="<?=$today?>" class="datePicker" /></td>
		</tr>
		<tr>
			<td>วันเริ่มใช้คูปอง : </td>
			<td> <input id="st_coupon_start_date" name="st_coupon_start_date" value="<?=$today?>" class="datePicker" /> &nbsp;ถึงวันที่ &nbsp;<input id="st_coupon_end_date" name="st_coupon_end_date" value="<?=$today?>" class="datePicker" /></td>
			<td>วันหมดอายุคูปอง : </td>
			<td>	<input id="end_coupon_start_date" name="end_coupon_start_date" value="<?=$today?>" class="datePicker" /> &nbsp;ถึงวันที่ &nbsp;<input id="end_coupon_end_date" name="end_coupon_end_date" value="<?=$today?>" class="datePicker" /></td>
		</tr>
	</table>
</div>
<div>
	<?
		$nOrder		=	0;
		$nCoupon	=	0;
		$summary	=	0; 
	?>
	<table cellpadding="0" cellspacing="1" border="0" class="display" id="show_data" width="100%">
		<thead>
			<th>ร้านค้า</th>
			<th>ดีล</th>
			<th>แคมเปญ</th>
			<th>วันที่กำหนดเริ่มขาย</th>
			<th>วันที่กำหนดปิดการขาย</th>
			<th>วันเริ่มใช้คูปอง</th>
			<th>วันหมดอายุคูปอง</th>
			<th>ราคาปกติรวม Vat แล้ว</th>
			<th>ราคาเดอะเบสดีล</th>
			<th>ส่วนลด</th>
			<th>ราคาจากลด</th>
			<th>จำนวนสั่งซื้อ</th>
			<th>คูปอง</th>
			<th>รวมเป็นจำนวนเงิน</th>
			<th>vendor_status</th>
			<th>vendor_id</th>
			<th>summary</th>
			<th>num_order</th>
			<th>num_coupon</th>
		</thead>
		<? 
		$i=0;
		foreach($sell_product_data as $data){?>
		<tr>
			<td><?=$data["vendor_name"]?></td>
			<td><?=$data["deal_name"]?></td>
			<td><?=$data["product_name"]?></td>
			<td align="center"><?=show_date($data["round_start"])?></td>
			<td align="center"><?=show_date($data["round_end"])?></td>
			<td align="center"><?=show_date($data["deal_start"])?></td>
			<td align="center"><?=show_date($data["deal_expile"])?></td>
			<td align="center"><?=number_format($data["product_price"])?></td>
			<td align="center"><?=number_format($data["the_best_deal_price"])?></td>
			<td align="center"><?=$data["product_discount_per"]?>%</td>
			<td align="center"><?=number_format($data["product_price"]-($data["product_price"]*($data["product_discount_per"]/100)))?></td>
			<td align="center"><?=number_format($data["nOrder"])?></td>
			<td align="center"><?=number_format($data["nCoupon"])?></td>
			<td align="center"><?=number_format($data["nCoupon"]*$data["the_best_deal_price"])?></td>
			<td><?=$data["vendor_status"]?></td>
			<td><?=$data["vendor_id"]?></td>
			<td align="center"><?=$data["nCoupon"]*$data["the_best_deal_price"]?></td>
			<td align="center"><?=$data["nOrder"]?></td>
			<td align="center"><?=$data["nCoupon"]?></td>
		</tr>
		<?
			$nOrder		+=	$data["nOrder"];
			$nCoupon	+=	$data["nCoupon"];
			$summary	+=	$data["nCoupon"]*$data["the_best_deal_price"]; 
		} 
		?>
		<tfoot>
 			<tr>
 			<th></th>
 			<th></th>
 			<th></th>
 			<th></th>
 			<th></th>
 			<th></th>
 			<th></th>
 			<th></th>
 			<th></th>
 			<th></th>
   			<th align="right">รวม</th>
			<th align="center"><span id="nOrder"><?=number_format($nOrder)?></span></th>
			<th align="center"><span id="nCoupon"><?=number_format($nCoupon)?></span></th>
			<th align="center"><span id="nSummary"><?=number_format($summary)?></span></th>
			<th></th>
			<th></th>
			<th></th>
			<th></th>
			<th></th>
 			</tr>
		</tfoot>
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
    function( oSettings, aData, iDataIndex ) 
    {
    	var st_buy_start_date 	= $("#st_buy_start_date").val();
        var st_buy_end_date 		= $("#st_buy_end_date").val();
        var round_start 			= aData[2];
        var check_buy_date		=	false;
        
        st_buy_start_date	=	str2date(st_buy_start_date);
        st_buy_end_date	=	str2date(st_buy_end_date);
        round_start			=	str2date(round_start);
        
        if ( st_buy_start_date == "" && st_buy_end_date == "" )
        {
            check_buy_date =	true;
        }
        else if ( st_buy_start_date == "" && round_start <= st_buy_end_date )
        {
            check_buy_date =	 true;
        }
        else if ( st_buy_start_date <= round_start && "" == st_buy_end_date )
        {
            check_buy_date = true;
        }
        else if ( st_buy_start_date <= round_start && round_start <= st_buy_end_date )
        {
            check_buy_date = true;
        }
        
        var end_buy_start_date 		= $("#end_buy_start_date").val();
        var end_buy_end_date 		= $("#end_buy_end_date").val();
        var round_end 					= aData[3];
        var check_buy_end			=	false;
        
        end_buy_start_date	=	str2date(end_buy_start_date);
        end_buy_end_date		=	str2date(end_buy_end_date);
        round_end					=	str2date(round_end);
        
        if ( end_buy_start_date == "" && end_buy_end_date == "" )
        {
            check_buy_end =	true;
        }
        else if ( end_buy_start_date == "" && round_end <= end_buy_end_date )
        {
            check_buy_end =	 true;
        }
        else if ( end_buy_start_date <= round_end && "" == end_buy_end_date )
        {
            check_buy_end = true;
        }
        else if ( end_buy_start_date <= round_end && round_end <= end_buy_end_date )
        {
            check_buy_end = true;
        }
        
        var st_coupon_start_date 		= $("#st_coupon_start_date").val();
        var st_coupon_end_date 		= $("#st_coupon_end_date").val();
        var coupon_start 					= aData[4];
        var check_coupon_st				=	false;
        
        st_coupon_start_date		=	str2date(st_coupon_start_date);
        st_coupon_end_date		=	str2date(st_coupon_end_date);
        coupon_start					=	str2date(coupon_start);
        
        if ( st_coupon_start_date == "" && st_coupon_end_date == "" )
        {
            check_coupon_st =	true;
        }
        else if ( st_coupon_start_date == "" && coupon_start <= st_coupon_end_date )
        {
            check_coupon_st =	 true;
        }
        else if ( st_coupon_start_date <= coupon_start && "" == st_coupon_end_date )
        {
            check_coupon_st = true;
        }
        else if ( st_coupon_start_date <= coupon_start && coupon_start <= st_coupon_end_date )
        {
            check_coupon_st = true;
        }
        
        var end_coupon_start_date 	= $("#end_coupon_start_date").val();
        var end_coupon_end_date 		= $("#end_coupon_end_date").val();
        var coupon_end 					= aData[5];
        var check_coupon_end			=	false;
        
        end_coupon_start_date	=	str2date(end_coupon_start_date);
        end_coupon_end_date	=	str2date(end_coupon_end_date);
        coupon_end					=	str2date(coupon_end);
        
        if ( end_coupon_start_date == "" && end_coupon_end_date == "" )
        {
            check_coupon_end =	true;
        }
        else if ( end_coupon_start_date == "" && coupon_end <= end_coupon_end_date )
        {
            check_coupon_end =	 true;
        }
        else if ( end_coupon_start_date <= coupon_end && "" == end_coupon_end_date )
        {
            check_coupon_end = true;
        }
        else if ( end_coupon_start_date <= coupon_end && coupon_end <= end_coupon_end_date )
        {
            check_coupon_end = true;
        }
        
        var check_vendor		=	false;
       	var vendor_id			= aData[15];
        var vendor_sel			= $("#vendor_id").val();
        
        if(vendor_sel==0)
        {
        	check_vendor	=	true;
        }else{
        	 if(vendor_sel==vendor_id)
        	 {
        	 	check_vendor	=	true;
        	 }else{
        	 	check_vendor	=	false;
        	 }
        }
        
        var check_vendor_status		=	false;
       	var vendor_status					= aData[14];
        var vendor_status_sel			= $("#vendor_status").val();
        
        if(vendor_status_sel==0)
        {
        	check_vendor_status	=	true;
        }else{
        	 if(vendor_status_sel==vendor_status)
        	 {
        	 	check_vendor_status	=	true;
        	 }else{
        	 	check_vendor_status	=	false;
        	 }
        }
        
        if(check_buy_date&&check_vendor&&check_vendor_status&&check_buy_end&&check_coupon_st&&check_coupon_end)
        {
        	return true;
        }else{
        	return false;
        }
    }
);
	$("#vendor_status").change(
		function(){
			oTable.fnDraw();
		}
	);
	$(".datePicker").blur(
		function(){
			oTable.fnDraw();
		}
	);
	$("#vendor_id").change(
		function(){
			oTable.fnDraw();
		}
	);
    var oTable = $('#show_data').dataTable({
    	"sDom": 'T<"clear">lfrtip',
    	"sScrollX": "2000px",
		"oTableTools": {
			"sSwfPath": "/assets/js/tabletool/swf/copy_csv_xls_pdf.swf",
			"aButtons": [
				{
					"sExtends": "xls",
					"sButtonText": "บันทึกเป็น Excel",
					"mColumns": [0, 1, 2, 3, 4,5,6,7,8,9,10,11,12]
				}
			]
		},
    	"aoColumns": [null,null,null,null,null,null,null,null,null,null,null,null,null,null,{ "bVisible": false },{ "bVisible": false },{ "bVisible": false },{ "bVisible": false },{ "bVisible": false }] ,
    	"fnFooterCallback": function( nFoot, aData, iStart, iEnd, aiDisplay ) {
    		
    		var nOrder		=	0;
    		var nCoupon		=	0;
    		var nSummary	=	0;
    		
    		 for ( var i=iStart ; i<iEnd ; i++ )
            {
                nOrder 		+= 	parseInt(aData[aiDisplay[i]][17]);
                nCoupon 	+= 	parseInt(aData[aiDisplay[i]][18]);
                nSummary += 	parseFloat(aData[aiDisplay[i]][16]);
            }
     	 	$("#nOrder").html(addCommas(nOrder));
     	 	$("#nCoupon").html(addCommas(nCoupon));
     	 	$("#nSummary").html(addCommas(nSummary));
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
    	function addCommas(str) {
    	var amount = new String(str);
    	amount = amount.split("").reverse();

    	var output = "";
    	for ( var i = 0; i <= amount.length-1; i++ ){
        	output = amount[i] + output;
        	if ((i+1) % 3 == 0 && (amount.length-1) !== i)output = ',' + output;
    	}
    	return output;
	}
</script>