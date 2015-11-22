<div id="shopping_popup">
	<div id="shopping_popup_header">เลือกสถานะการชำระเงิน</div>
	<div id="payment_popup_main">
		<div class="payment_box">
			<form id="myForm" name="myForm" action="" method="post" >
			<table>
				<tr>
					<td>
						<input type="radio" value="0" name="payment_status" id="payment_status" <?if($status==0){?>checked="checked"<?}?> />
						<img src="/assets/images/icon/pay_wait.png" />
					</td>
				</tr>
				<tr>
					<td>
						<input type="radio" value="1" name="payment_status" id="payment_status" <?if($status==1){?>checked="checked"<?}?> />
						<img src="/assets/images/icon/pay_first.png"/>
					</td>
				</tr>
				<tr>
					<td>
						<input type="radio" value="2" name="payment_status" id="payment_status" <?if($status==2){?>checked="checked"<?}?> />
						<img src="/assets/images/icon/pay_complete.png"/>
					</td>
				</tr>
			</table>
			<input type="button" value="บันทึกข้อมูล" onclick="save_shop_payment()" />
			</form>
			</div>
	</div>
	<div id="payment_popup_footer"></div>
</div>
<script>
	function save_shop_payment()
	{
		var status	=	$('input[name=payment_status]:checked', '#myForm').val()
		$.ajax({
  			type: "POST",
  			url: '/mybackoffice/update_shop_payment/<?=$round_id?>/'+status
			}).done(function( msg ) {
					alert("ทำการบันทึกข้อมูลเรียบร้อยแล้วค่ะ !");
					parent.$.fancybox.close();
					if(status==0)
					{
						$("#round_img_<?=$round_id?>").attr("src","/assets/images/icon/pay_wait.png");
					}
					if(status==1)
					{
						$("#round_img_<?=$round_id?>").attr("src","/assets/images/icon/pay_first.png");
					}
					if(status==2)
					{
						$("#round_img_<?=$round_id?>").attr("src","/assets/images/icon/pay_complete.png");
					}
		});	
	}
</script>
