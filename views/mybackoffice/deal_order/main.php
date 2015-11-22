<div class="menu_add_box"></div>
<div class="clear">
	<select id="date_status">
		<option value="0">ทั้งหมด</option>
		<option value="1">วันที่สั่งซื้อ</option>
		<option value="2">วันที่ชำระเงิน</option>	
	</select>&nbsp;&nbsp; | &nbsp;&nbsp; 
	<? 	
		$today	=	date("d/m/Y",time());
		if($filter_id!="")		$today	=	"";	
	?>
	เริ่มวันที่ : <input id="start_date" name="start_date" value="<?=$today?>" class="datePicker" /> &nbsp;ถึงวันที่ &nbsp;<input id="end_date" name="end_date" value="<?=$today?>" class="datePicker" />&nbsp;&nbsp; | &nbsp;&nbsp;
	สถานะ :
	 <select id="buy_status">
		<option value="4">ทั้งหมด</option>
		<option value="1">รอการชำระเงิน</option>
		<option value="2">ชำระเงินแล้ว</option>	
		<option value="3">คืนเงิน</option>	
		<option value="0">ยกเลิก</option>	
	</select>
	<input type="hidden" name="filter_id" id="filter_id" value="<?=$filter_id?>" />
	<input type="hidden" name="filter_type" id="filter_type" value="<?=$filter_type?>" />
	<input type="hidden" name="admin_type" id="admin_type" value="<?=$admin_type?>" />
</div>
<div>
	<table id="show_data" border="0" cellpadding="0" cellspacing="1">
			<thead>
			<th width="100px">เลขที่ใบสั่งซื้อ</th>
			<th width="80px">รหัสลูกค้า</th>
			<th width="130px">ชื่อลูกค้า</th>
			<th width="100px">ร้านค้า</th>
			<th width="200px">ดีล</th>
			<th width="80">วันที่สั่งซื้อ</th>
			<th width="90">วันที่ชำระเงิน</th>
			<th width="80px">จำนวนเงิน</th>
			<th width="80px">status</th>
			<th width="70px">สถานะ</th>
			<th width="120px">ช่องทาง<br>การชำระเงิน</th>
			<th width="120px">การจัดการ</th>
		</thead>
	</table>
</div>
<script>
	$('.fancybox').fancybox();
</script>

<script type="text/javascript" charset="utf-8">
$.fn.dataTableExt.afnFiltering.push(
    function( oSettings, aData, iDataIndex ) {
        var st_date 			= $("#start_date").val();
        var end_date 		= $("#end_date").val();
        var date_status		= $("#date_status").val();
         
         var order_date = "";
         var payment_date = "";
         
         if(date_status == '0')
         {
        	order_date 	= aData[5];
        	payment_date 	= aData[6];
        }
        else if(date_status == '1')
        	order_date 	= aData[5];
        else 	
       		payment_date = aData[6];

        var check_date_order	=	false;
        var check_date_payment	=	false;

        if(st_date!="")
        st_date		=	str2date(st_date); 
        
        if(end_date!="")
        end_date	=	str2date(end_date);
        
        order_date	=	str2date(order_date);
        payment_date	=	str2date(payment_date);
        
        if(order_date != "")
        {
	        if ( st_date == "" && end_date == "" )
	        {
	            check_date_order =	true;
	        }
	        else if ( st_date == "" && order_date <= end_date )
	        {
	            check_date_order =	 true;
	        }
	        else if ( st_date < order_date && "" == end_date )
	        {
	            check_date_order = true;
	        }
	        else if ( st_date <= order_date && order_date <= end_date )
	        {
	            check_date_order = true;
	        }
        }
      if(payment_date != "")
        {
        	if ( st_date == "" && end_date == "" )
	        {
	            check_date_payment =	true;
	        }
	        else if ( st_date == "" && payment_date <= end_date )
	        {
	            check_date_payment =	 true;
	        }
	        else if ( st_date < payment_date && "" == end_date )
	        {
	            check_date_payment = true;
	        }
	        else if ( st_date <= payment_date && payment_date <= end_date )
	        {
	            check_date_payment = true;
	        }
        }
     	var check_buy_status		=	false;
       	var status		= aData[8];
        var buy_status	= $("#buy_status").val();
        
        if(buy_status==4)
        {
        	check_buy_status	=	true;
        }else {
        	 if(buy_status==status)
        	 	check_buy_status	=	true;
        }
        
       if((check_date_order || check_date_payment) && check_buy_status)
       		return true;
       else
       		return false;
    }
);

  var oTable = $('#show_data').dataTable(
  	{
  		"sScrollX": "1300px",
  		"aoColumns": [null,null,null,null,null,null,null,null,{ "bVisible": false },null,null,null],
		"bProcessing": true,
		"bServerSide": true,
		"sAjaxSource": "/mybackoffice/all_order_data/",
		"sPaginationType": "full_numbers",
		"iDisplayLength": 20,
		"fnServerData": function ( sSource, aoData, fnCallback ) {
			/* Add some extra data to the sender */
			aoData.push( { "name": "date_status", "value": $("#date_status").val() } );
			aoData.push( { "name": "start_date", "value": $("#start_date").val() } );
			aoData.push( { "name": "end_date", "value": $("#end_date").val() } );
			aoData.push( { "name": "buy_status", "value": $("#buy_status").val() } );
			aoData.push( { "name": "filter_id", "value": $("#filter_id").val() } );
			aoData.push( { "name": "filter_type", "value": $("#filter_type").val() } );
			aoData.push( { "name": "admin_type", "value": $("#admin_type").val() } );
			
				$.getJSON( sSource, aoData, function (json) { 
					/* Do whatever additional processing you want on the callback, then tell DataTables */
					fnCallback(json)
				} );
			}
    });

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
    
    	$("#date_status").change(
		function(){
			oTable.fnDraw();
		}
	);
	
	$("#buy_status").change(
		function(){
			oTable.fnDraw();
		}
	);
</script>