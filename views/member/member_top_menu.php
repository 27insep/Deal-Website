<div id="member_menu">
	<div class="menu"><a href="/shopping/"><?echo image_asset('shopping_cart.jpg', '', array('alt'=>'ตระกล้าของฉัน'));?></a></div>
	<div class="menu"><a class="fancybox fancybox.ajax" href="../../../../member/popup_changepass"><?echo image_asset("my_coupon.jpg", '', array('alt'=>"เปลี่ยนรหัสผ่าน"));?></a></div>
	<div id="last_login_status">สวัสดีค่ะ คุณเข้าสู่ระบบครั้งสุดท้าย<br/>เมื่อ 
		<?
		$th_date	=	$this->convert_date->show_thai_date(date("Y-m-d",strtotime($last_login)));
		if(!empty($th_date))
			echo $th_date." ".date("H:i:s",strtotime($last_login));
		?>
	</div>
	<div><a href="#" onclick="do_logout()"><?echo image_asset('logout_button.png', '', array('alt'=>'ออกจากระบบ'));?></a></div>
	<div id="sub_top_menu" class="clear_float">
		<div><a href="/member">โปรไฟล์ของฉัน</a></div>
		<div><a href="/member/my_order">คำสั่งซื้อของฉัน</a></div>
		<div><a href="/member/my_coupon">คูปองของฉัน</a></div>
		<div><a href="/member/my_invite">คำเชิญของฉัน</a></div>

	</div> 
</div>
<script type="text/javascript">
	function do_logout()
	{
		window.location.href = "/member/logout";
		/*
		$.ajax({
  			url: "/member/logout",
		}).done(function( msg ) {
				window.location.href = "/";
  			 	$( "#dialog" ).html("ทำการออกจากระบบเรียบร้อยแล้วค่ะ");
 				$( "#dialog" ).dialog(
 					{ 
 						title: "ข้อความ",
 						buttons: [ { text: "ตกลง", click: function() { $( this ).dialog( "close" ); } } ]
 					});
 				
		});*/
	}
</script>