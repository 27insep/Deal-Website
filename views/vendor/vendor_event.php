<div id="vendor_dashboard_main">
<div id="vendor_dashboard_header">
	<div id="vendor_dashboard_header_text">
		<div>Merchant Dashboard</div>
		<div id="marchant_name"><?=$vendor_name?>,<?=$this->convert_date->show_thai_date(date("Y-m-d",time()))?></div>
	</div>
</div>
<div id="vendor_dashboard_menu">
	<div id="vendor_dashboard_menu_inner">
		<div id="vendor_dashboard_left"><a href="/vendor/vendor_deal"><span>My Events</span></a> | <a href="/vendor/vendor_profile">My Profile</a> | <a href="/vendor/vendor_account">Change Password</a></div>
		<div id="vendor_dashboard_right"><span>สวัสดี คุณ <?=$vendor_contact_fname?> <?=$vendor_contact_sname?></span> | <span style="color: #FFFFFF;" onclick="do_logout()">Log Out</span></div>
	</div>
</div>
<!--
<form id="vendor_form" action="/vendor/vendor_save_profile" method="post">
-->
<div id="vendor_main">
	<div id="vendor_inner_main">
	<div id="vendor_main_topic"><div>My Event</div></div>
	<div id="vendor_deal_main">
	<span>ดีล : </span><select id="vendor_deal" onchange="load_summary()">
			<option value="">ดีลทั้งหมด</option>
		<? foreach($deal_data as $data){?>
			<option value="<?=$data["deal_id"]?>"><?=$data["deal_name"]?> &nbsp;<?=date("dmY",strtotime($data["round_start"]))?></option>
		<? }?>
	</select>
	</div>
	<div id="vendor_deal_product">
	<span>แคมเปญ : </span><select id="product_deal" onchange="load_box()">
					<option value="">กรุณาเลือกแคมเปญ</option>
				</select>
	</div>
	<div class="clear">
		<div id="vender_over_view" class="ven_dor_tab_menu current" onclick="load_box()">แคมเปญ</div>
		<div id="vender_voucher" class="ven_dor_tab_menu hidebox" onclick="load_voucher()">คูปอง</div>
	</div>
	<div id="vender_deal"><?=$over_view?></div>
	</div>
</div>
<!--
</form>
-->
</div>
<div id="vendor_dashboard_footer"></div>
<script type="text/javascript">
	function load_summary()
	{
		var deal_id	=	$("#vendor_deal").val();
		$.ajax({
  			url: "/vendor/show_product/"+deal_id,
		}).done(function( msg ) {
  				$("#product_deal").html(msg);
  				load_box();
  	});
	}
	function load_box()
	{
		var product_id	=	$("#product_deal").val();
		var deal_id		=	$("#vendor_deal").val();
		
		$.ajax({
  			url: "/vendor/show_sumary_deal/"+deal_id+"/"+product_id,
  			cache: false,
			}).done(function( msg ) {
  				$("#vender_deal").html(msg);
  			});
  			if(product_id==0)
  			{	
  				$("#vender_voucher").addClass("hidebox");
  			}else{
  				$("#vender_voucher").removeClass("hidebox");
  			}
  			$("#vender_over_view").addClass("current");
  			$("#vender_voucher").removeClass("current");
	}
	function load_voucher()
	{
		var product_id	=	$("#product_deal").val();
		if(product_id==0)
  			{	
  				$("#vender_voucher").addClass("hidebox");
  			}else{
  				$("#vender_voucher").removeClass("hidebox");
  			}
			$.ajax({
  				url: "/vendor/show_voucher/"+product_id,
  				cache: false,
			}).done(function( msg ) {
  				$("#vender_deal").html(msg);
  			});
  			
  			$("#vender_over_view").removeClass("current");
  			$("#vender_voucher").addClass("current");
	}
	function do_logout()
	{
		$.ajax({
  			url: "/vendor/vendor_logout",
		}).done(function( msg ) {
  			 	$( "#dialog" ).html("ทำการออกจากระบบเรียบร้อยแล้วค่ะ");
 				$( "#dialog" ).dialog(
 					{ 
 						title: "ข้อความ",
 						close: function( event, ui ) 
 						{
 							window.location.href = "/vendor/";
 						},
 						buttons: [ { text: "ตกลง", click: function() { $( this ).dialog( "close" ); } } ]
 					});
		});
	}
	/*
	   	$(document).ready(function() {  
 		function show_status(responseText, statusText, xhr, $form)
 		{
 			if(responseText==1)
 			{
 				$( "#dialog" ).html("ทำการบันทึกข้อมูลเรียบร้อยแล้วค่ะ");
 				$( "#dialog" ).dialog(
 					{ 
 						title: "ข้อความ",
 					}
 				);
 			}else{
 				$( "#dialog" ).html("ไม่สามารถบันทึกข้อมูลได้");
 				$( "#dialog" ).dialog({ title: "แจ้งเตือน" });
 			} 
 		}
 		$('#vendor_form').ajaxForm(
 			{ 	
 				success: show_status
 			} 
 		); 
  	});
  	*/
</script>