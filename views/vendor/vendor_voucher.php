<style type="text/css">
.dataTables_filter {
     display: none;
}
</style> 
<div id="voucher_search" align="center">
	<table id="show_search_voucher" border="0" width="770px" background="#f4f4f4">
		<tr>
			<td rowspan="2"><?echo  image_asset('search_topic.png', '');?></td>
			<td align="right">เลขที่คูปอง : </td>
			<td><input type="text" id="voucher_number" name="voucher_number" value="<?=$voucher_number?>"/></td>
			<td align="right">เลขที่ลูกค้า : </td>
			<td><input type="text" id="member_name" name="member_name" value="<?=$member_name?>"/></td>
			<td rowspan="2" style="cursor: pointer;" id="search_button">
				<img id="search_button" class="can_click" src="/assets/images/search_button.png" onclick="search_coupon()"/></td>
		</tr>
		<tr>
			<td align="right">สถานะการใช้ :</td>
			<td><select name="voucher_status" id="voucher_status">
					<option value="">ทุกสถานะ</option>
					<option value="2" <? if($voucher_status==2) echo 'selected="selected"';?>>ใช้แล้ว</option>	
					<option value="1" <? if($voucher_status==1) echo 'selected="selected"';?>>ยังไม่ได้ใช้</option>
				</select></td>
			<td colspan="2"></td>
		</tr>
	</table>
</div>
<br>
<form target="_blank" name="export_view" id="export_view" method="post" action="/vendor/export_view">
<input type="hidden" name="product_id" id="product_id" value="<?=$product_id?>" />
<div align="right">
	<select id="export" name="export">	
    	<option value="">--------------Action----------------</option>
     	<optgroup label="--------------Print----------------">		
     		<option value="print_selected">Print Selected</option>
       		<option value="print_all">Print All</option>
    	</optgroup>
  		<optgroup label="--------------Export-------------">
      		<option value="excel_selected">Export Selected To Excel</option>
       		<option value="excel_all">Export All To Excel</option>
    	</optgroup>                                                            
	</select>
	<input type="submit" name="action" id="action" value="Action" />
</div>
<div class="clear">
	<table cellpadding="0" cellspacing="1" border="0" class="display" id="show_data" width="770px">
		<thead style="font-size: 12px;">
			<th align="center"><input type="checkbox" id="check_all" name="check_all" /></th>
			<th align="center">ลำดับ</th>
			<th>เลขที่คูปอง</th>
			<th>บาร์โค๊ด</th>
			<th>รหัสลูกค้า</th>
			<th>ชื่อ-นามสกุล</th>
			<th>วันที่ใช้</th>
			<th>status</th>
			<th>สถานะการใช้</th>
		</thead>
		<? 
		$i=0;
		foreach($coupon_data as $data){?>
		<tr style="font-size: 12px;">
			<th align="center"><input type="checkbox" id="row_id[<?=$i?>]" name="row_id[<?=$i?>]" class="check_row" value="<?=$data["coupon_id"]?>"/></th>
			<td align="center"><?=++$i?></td>
			<td  align="center"><?=$data["voucher_number"]?></td>
			<td  align="center"><?=$data["barcode"]?></td>
			<td align="center"><?=$data["member_id"]?></td>
			<td width="150px"  align="center"><?=$data["member_name"]." ".$data["member_sname"]?></td>
			<td align="center"><?if($data["coupon_use_date"]!="" && $data["coupon_use_date"]!="0000-00-00 00:00:00")echo date("d/m/Y",strtotime($data["coupon_use_date"]));else echo "";?></td>
			<td align="center"><?=$data["coupon_status"]?></td>
			<td align="center">
			<? if($data["coupon_status"]==2){?>
					<img id="icon_<?=$data["coupon_id"]?>" class="can_click" src="/assets/images/used_button.png" onclick="change_status(1,<?=$data["coupon_id"]?>)"/>
			<?}else{?>
					<img id="icon_<?=$data["coupon_id"]?>" class="can_click" src="/assets/images/not_used_button.png" onclick="change_status(2,<?=$data["coupon_id"]?>)"/>
			<?}?>
			</td>
		</tr>
		<? } ?>
		</table>
</div>
</form>
<script>	
      $('#check_all').click(function (event) {

           var selected = this.checked;
           // Iterate each checkbox
           $(':checkbox').each(function () {    this.checked = selected; });

       });
  var oTable = $('#show_data').dataTable({
	    "bLengthChange": false,
	    "aoColumnDefs": [ { "bVisible": false,  "aTargets": [7] }]
  });
    
	function change_status(status,coupon_id)
	{
		$.ajax({
  			url: "/coupon/change_status_coupon/"+status+"/"+coupon_id,
			}).done(function( msg ) {
  				if(status==2)
  					$("#icon_"+coupon_id).attr("src","/assets/images/used_button.png");
  				if(status==1)
  					$("#icon_"+coupon_id).attr("src","/assets/images/not_used_button.png");
  				oTable.fnDraw();
  		});	
	}
	
	function reload_voucher()
	{
			var product_id			=	$("#product_deal").val();
			var voucher_number	=	$("#voucher_number").val();
			var name					=	$("#member_name").val();
			var voucher_status	=	$("#voucher_status").val();
		
			$.ajax({
  				url: "/vendor/show_voucher/"+product_id,
  				type: "POST",
  				data:{ coupon_id: voucher_number, member_name: name,coupon_status:voucher_status }
			}).done(function( msg ) {
  				$("#vender_deal_box").html(msg);
  			});
  			
  			$("#vender_over_view").removeClass("current");
  			$("#vender_voucher").addClass("current");
	}
	
	$.fn.dataTableExt.afnFiltering.push(
    function( oSettings, aData, iDataIndex ) {
    	var voucher_number 		= $("#voucher_number").val();
    	var voucher_number_data = "";
    	var vn_b = false;
    	
    	voucher_number_data 	= aData[2];
    	
    	if (voucher_number_data.indexOf(voucher_number) != -1)
    			vn_b = true;
    			
    	var member_name 		= $("#member_name").val();
    	var member_id_data = "";
    	var mid = false;
    	var pos = false;
    	
    	member_id_data 	= aData[4];
    	
    	if (member_id_data.indexOf(member_name) != -1)
    			mid = true;
    	
    	var voucher_status	= $("#voucher_status").val();
    	var voucher_status_data = "";
    	var vs_b = false;
    	
    	voucher_status_data 	= aData[7];
    	
    	if ((voucher_status_data == voucher_status) || voucher_status == "" )
    			vs_b = true;
    	
    	 if(voucher_number == "" && member_name == "" && voucher_status == "")
    	 		return true;	
    	 else if((((member_name != "" && (mid)) || (voucher_number != "" && vn_b)) || (voucher_number == "" && member_name == "" ))&& vs_b)
    	 		return true;
        else
       			return false;
    });
		
	$("#voucher_status").change(
		function(){
			oTable.fnDraw();
		});
	
	function search_coupon()
	{
		oTable.fnDraw();
	}
</script>