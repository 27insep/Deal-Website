<div class="menu_add_box">
	<a href="/mybackoffice/member_profile/insert_form">เพิ่มข้อมูล</a>
</div>
<div class="clear">
	<? 
		$today	=	date("d/m/Y",time());
	?>
	วันที่สมัคร : <input id="start_date" name="start_date" value="<?=$today?>" class="datePicker" /> ถึง <input id="end_date" name="end_date" value="<?=$today?>" class="datePicker" /> 
	 | คำสั่งซื้อ : 
	<select id="buy_status">
		<option value="2">ทั้งหมด</option>
		<option value="1">มีการซื้อ</option>
		<option value="0">ไม่มีการซื้อ</option>	
	</select> 
</div>
<div>
	<table cellpadding="0" cellspacing="1" border="0" class="display" id="show_data" width="100%">
		<thead>
			<th width="50px">รหัสสมาชิก</th>
			<th width="80px">ชื่อ-นามสกุล</th>
			<th width="40px">อีเมล</th>
			<th width="30px">เบอร์ติดต่อ</th>
			<th width="30px">สมัคร</th>
			<th width="30px">คำสั่งซื้อ</th>
			<th width="30px">คูปอง</th>
			<th width="100px">เครื่องมือ</th>
		</thead>
	</table>
</div>
<script type="text/javascript" charset="utf-8">
    function send_password(member_id)
    {
    	$.ajax({
  			type: "POST",
  			url: '/mybackoffice/member_profile/send_password/'+member_id
			}).done(function( msg ) {
					alert("แจ้งรหัสผ่านเรียบร้อยแล้วค่ะ !");
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
        
       	var check_buy_status		=	false;
       	var nOrder		= aData[5];
        var buy_status	= $("#buy_status").val();
        
        if(buy_status==2)
        {
        	check_buy_status	=	true;
        }else
        {
        	 if((buy_status==1&&nOrder!=0)||(buy_status==0&&nOrder==0))
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
	var oTable = $('#show_data').dataTable(
		{
			"bProcessing": true,
			"bServerSide": true,
			"sAjaxSource": "/mybackoffice/all_member_data/",
			"sPaginationType": "full_numbers",
			"iDisplayLength": 20,
			"fnServerData": function ( sSource, aoData, fnCallback ) {
			/* Add some extra data to the sender */
			aoData.push( { "name": "start_date", "value": $("#start_date").val() } );
			aoData.push( { "name": "end_date", "value": $("#end_date").val() } );
			aoData.push( { "name": "buy_status", "value": $("#buy_status").val() } );
				$.getJSON( sSource, aoData, function (json) { 
					/* Do whatever additional processing you want on the callback, then tell DataTables */
					fnCallback(json)
				} );
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
    	
	$("#buy_status").change(
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
	if(confirm('ต้องการข้อมูลสมาชิก  '+add_text))
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