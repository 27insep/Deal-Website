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
			<td>สถานะการจ่ายเงิน</td>
			<td>
					<select id="payment_status" name="payment_status">
						<option value="">ทั้งหมด</option>
						<option value="0">รอจ่าย</option>
						<option value="1">จ่ายครั้งแรก</option>
						<option value="2">เรียบร้อย</option>	
					</select> 
			</td>
			<td></td>
			<td></td>
		</tr>
		<tr>
			<td>วันที่กำหนดเริ่มขาย : </td>
			<td><input id="st_buy_start_date" name="st_buy_start_date" value="<?=$today?>" class="datePicker" /> &nbsp;ถึงวันที่ &nbsp;<input id="st_buy_end_date" name="st_buy_end_date" value="<?=$today?>" class="datePicker" /></td>
			<td>วันเปิดขาย : </td>
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
		
		$sum_the_best_money	=	0;	
		$sum_the_best_vat			=	0;		
		$sum_the_best_sum		=	0;		
				
		$sum_vendor_money		=	0;		
		$sum_vendor_wht			=	0;	
		$sum_vendor_sum			=	0;	
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
			<th>คูปอง</th>
			<th>รวมเป็นจำนวนเงิน</th>
			<th>เดอะเบสดีล MDR(%)/คูปอง</th>
			<th>คอมมิชชั่น เดอะเบสดีล</th>
			<th>Vat7% คอมมิชชั่นเดอะเบสดีล</th>
			<th>รวมค่าตอบแทนเดอะเบสดีล</th>
			<th>ร้านค้าได้</th>
			<th>ร้านค้า WHT3%</th>
			<th>รวมยอดร้านค้าได้</th>
			<th>รูปแบบการรับรายได้</th>
			<th>จ่ายครั้งที่ 1</th>
			<th>%</th>
			<th>จ่ายครั้งที่ 2</th>
			<th>%</th>
			<th>สถานะการจ่ายเงิน</th>
			<th>vendor_status</th>
			<th>vendor_id</th>
			<th>summary</th>
			<th>num_order</th>
			<th>num_coupon</th>
			<th>payment_status</th>
			<th>การจัดการ</th>
			<th></th>
			<th></th>
			<th></th>
			<th></th>
			<th></th>
			<th></th>
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
			<? 
				$sum_money	=	$data["the_best_deal_price"]*$data["nCoupon"];
				$the_best_money	=	$sum_money*($data["product_mrd"]/100);
				$the_best_vat		= 	$the_best_money*0.07;
				$the_best_sum		=	$the_best_money+$the_best_vat;
				
				$vendor_money		=	$sum_money-($the_best_money+($the_best_money*0.07));
				$vendor_wht			=	$the_best_money*0.03;
				$vendor_sum			=	$vendor_money+$vendor_wht;
			?>
			<td align="center"><?=number_format($data["product_price"]-($data["product_price"]*($data["product_discount_per"]/100)))?></td>
			<td align="center"><?=number_format($data["nCoupon"])?></td>
			<td align="center"><?=number_format($sum_money,2,'.',',')?></td>
			<td align="center"><?=$data["product_mrd"]?>%</td>
			<td align="center"><?=number_format($the_best_money,2,'.',',')?></td>
			<td align="center"><?=number_format($the_best_vat,2,'.',',')?></td>
			<td align="center"><?=number_format($the_best_sum,2,'.',',')?></td>
			<td align="center"><?=number_format($vendor_money,2,'.',',')?></td>
			<td align="center"><?=number_format($vendor_wht,2,'.',',')?></td>
			<td align="center"><?=number_format($vendor_sum,2,'.',',')?></td>
			<td align="center">แบบที่ <?=$data["vendor_pay_type"]?></td>
			<? if($data["vendor_pay_type"]==1){?>
				<td align="center"><?=number_format(($vendor_sum/2),2,'.',',')?></td>
				<td align="center">50%</td>
				<td align="center"><?=number_format(($vendor_sum/2),2,'.',',')?></td>
				<td align="center">50%</td>
			<?}?>
			<? if($data["vendor_pay_type"]==2){?>
				<td align="center">-</td>
				<td align="center">-</td>
				<td align="center">-</td>
				<td align="center">-</td>
			<?}?>
			<? if($data["vendor_pay_type"]==3){?>
				<td align="center"><?=number_format($vendor_sum,2,'.',',')?></td>
				<td align="center">100%</td>
				<td align="center">-</td>
				<td align="center">-</td>
			<?}?>
			<? if($data["vendor_pay_type"]==4){?>
				<td align="center"><?=number_format((($vendor_sum*90)/100),2,'.',',')?></td>
				<td align="center">90%</td>
				<td align="center"><?=number_format((($vendor_sum*10)/100),2,'.',',')?></td>
				<td align="center">10%</td>
			<?}?>
			<? if($data["vendor_pay_type"]==5){?>
				<td align="center"><?=number_format((($vendor_sum*80)/100),2,'.',',')?></td>
				<td align="center">80%</td>
				<td align="center"><?=number_format((($vendor_sum*20)/100),2,'.',',')?></td>
				<td align="center">20%</td>
			<?}?>
			<td align="center">
				<a class="fancybox fancybox.ajax" href="/mybackoffice/popup_shop_payment/<?=$data["round_id"]?>/<?=$data["payment_status"]?>">
			<? 	
				if($data["payment_status"]==0)
				{
			?>
					<img id="round_img_<?=$data["round_id"]?>" src="/assets/images/icon/pay_wait.png"/>
			<?
				}
				if($data["payment_status"]==1){
			?>
				<img id="round_img_<?=$data["round_id"]?>" src="/assets/images/icon/pay_first.png"/>
			<?
				}
				if($data["payment_status"]==2) {
			?>
				<img id="round_img_<?=$data["round_id"]?>" src="/assets/images/icon/pay_complete.png"/>
			<?
				}
			?>
			</a>
			</td>
			<td><?=$data["vendor_status"]?></td>
			<td><?=$data["vendor_id"]?></td>
			<td align="center"><?=$sum_money?></td>
			<td align="center"><?=$data["nOrder"]?></td>
			<td align="center"><?=$data["nCoupon"]?></td>
			<td align="center"><?=$data["payment_status"]?></td>
			<td align="center"></td>
			<td align="center"><?=$the_best_money?></td>
			<td align="center"><?=$the_best_vat?></td>
			<td align="center"><?=$the_best_sum?></td>
			<td align="center"><?=$vendor_money?></td>
			<td align="center"><?=$vendor_wht?></td>
			<td align="center"><?=$vendor_sum?></td>
		</tr>
		<?
			$nOrder		+=	$data["nOrder"];
			$nCoupon	+=	$data["nCoupon"];
			$summary	+=	$sum_money; 

			$sum_the_best_money	+=	$the_best_money;	
			$sum_the_best_vat			+=	$the_best_vat;		
			$sum_the_best_sum		+=	$the_best_sum;		
				
			$sum_vendor_money		+=	$vendor_money;		
			$sum_vendor_wht			+=	$vendor_wht;	
			$sum_vendor_sum			+=	$vendor_sum;	
		} 
		?>
		<tfoot>
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
			<th align="center"><span id="nCoupon"><?=number_format($nCoupon)?></span></th>
			<th align="center"><span id="nSummary"><?=number_format($summary)?></span></th>
			<th></th>
			<th align="center"><span id="sum_the_best_money"><?=number_format($sum_the_best_money,2,'.',',')?></span></th>
			<th align="center"><span id="sum_the_best_vat"><?=number_format($sum_the_best_vat,2,'.',',')?></span></th>
			<th align="center"><span id="sum_the_best_sum"><?=number_format($sum_the_best_sum,2,'.',',')?></span></th>
			<th align="center"><span id="sum_vendor_money"><?=number_format($sum_vendor_money,2,'.',',')?></span></th>
			<th align="center"><span id="sum_vendor_wht"><?=number_format($sum_vendor_wht,2,'.',',')?></span></th>
			<th align="center"><span id="sum_vendor_sum"><?=number_format($sum_vendor_sum,2,'.',',')?></span></th>
			<th></th>
			<th></th>
			<th></th>
			<th></th>
			<th></th>
			<th></th>
			<th>vendor_status</th>
			<th>vendor_id</th>
			<th>summary</th>
			<th>num_order</th>
			<th>payment_status</th>
			<th></th>
			<th></th>
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
        var round_start 			= aData[3];
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
        var round_end 					= aData[4];
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
        var coupon_start 					= aData[5];
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
        var coupon_end 					= aData[6];
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
       	var vendor_id			= aData[27];
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
       	var vendor_status					= aData[26];
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
        
        var check_payment_status		=	false;
       	var payment_status					= aData[32];
        var payment_status_sel			= $("#payment_status").val();
        
        if(payment_status_sel==0)
        {
        	check_payment_status	=	true;
        }else{
        	 if(payment_status_sel==payment_status)
        	 {
        	 	check_payment_status	=	true;
        	 }else{
        	 	check_payment_status	=	false;
        	 }
        }
        
        if(check_buy_date&&check_vendor&&check_vendor_status&&check_buy_end&&check_coupon_st&&check_coupon_end&&check_payment_status)
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
	$("#payment_status").change(
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
    	"sScrollX": "3200px",
		"oTableTools": {
			"sSwfPath": "/assets/js/tabletool/swf/copy_csv_xls_pdf.swf",
			"aButtons": [
				{
					"sExtends": "xls",
					"sButtonText": "บันทึกเป็น Excel",
					"mColumns": [0, 1, 2, 3, 4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24]
				}
			]
		},
    	"aoColumns": [null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,{ "bVisible": false },{ "bVisible": false },{ "bVisible": false },{ "bVisible": false },{ "bVisible": false },{ "bVisible": false },{ "bVisible": false },{ "bVisible": false },{ "bVisible": false },{ "bVisible": false },{ "bVisible": false },{ "bVisible": false },{ "bVisible": false }] ,
    	"fnFooterCallback": function( nFoot, aData, iStart, iEnd, aiDisplay ) {
    		
    		var nOrder		=	0;
    		var nCoupon		=	0;
    		var nSummary	=	0;
    		var sum_the_best_money =	0;
			var sum_the_best_vat =	0;
			var sum_the_best_sum =	0;
			var sum_vendor_money =	0;
			var sum_vendor_wht =	0;
			var sum_vendor_sum =	0;
    		
    		 for ( var i=iStart ; i<iEnd ; i++ )
            {
                nCoupon 	+= 	parseInt(aData[aiDisplay[i]][30]);
                nSummary += 	parseFloat(aData[aiDisplay[i]][28]);
                
                sum_the_best_money	+=	parseFloat(aData[aiDisplay[i]][33]);
				sum_the_best_vat		+=	parseFloat(aData[aiDisplay[i]][34]);
				sum_the_best_sum		+=	parseFloat(aData[aiDisplay[i]][35]);
				sum_vendor_money	+=	parseFloat(aData[aiDisplay[i]][36]);
				sum_vendor_wht		+=	parseFloat(aData[aiDisplay[i]][37]);
				sum_vendor_sum		+=	parseFloat(aData[aiDisplay[i]][38]);
            }
            
     	 	$("#nCoupon").html(addCommas(nCoupon));
     	 	$("#nSummary").html(addCommas(nSummary));
     	 	$("#sum_the_best_money").html(addCommas(sum_the_best_money.toFixed(2)));
			$("#sum_the_best_vat").html(addCommas(sum_the_best_vat.toFixed(2)));
			$("#sum_the_best_sum").html(addCommas(sum_the_best_sum.toFixed(2)));
			$("#sum_vendor_money").html(addCommas(sum_vendor_money.toFixed(2)));
			$("#sum_vendor_wht").html(addCommas(sum_vendor_wht.toFixed(2)));
			$("#sum_vendor_sum").html(addCommas(sum_vendor_sum.toFixed(2)));

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
   function addCommas(nStr)
{
	nStr += '';
	x = nStr.split('.');
	x1 = x[0];
	x2 = x.length > 1 ? '.' + x[1] : '';
	var rgx = /(\d+)(\d{3})/;
	while (rgx.test(x1)) {
		x1 = x1.replace(rgx, '$1' + ',' + '$2');
	}
	return x1 + x2;
}
$('.fancybox').fancybox();
	<?
	if(!empty($vendor_id))
	{
	?>
	$("#vendor_id").val(<?=$vendor_id?>);
	oTable.fnDraw();
	<?
	}
	?>
</script>