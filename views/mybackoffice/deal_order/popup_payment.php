<div id="shopping_popup">
	<div id="shopping_popup_header">เลือกวิธีการชำระเงิน</div>
	<div id="payment_popup_main">
		<div class="payment_box">
			<table>
				<tr height="70px">
						<td width="250px">
								<a href="/mybackoffice/deal_order/coupon/<?=$order_id ?>/21" onclick="if(confirm('ต้องการปรับสถานะเลขใบสั่งซื้อ <?=$order_id?> เป็นชำระเงินแล้ว ?')){return true;}else{return false;};">
								<?=image_asset("bank_logo/kbank_logo.jpg");?></a></td>
						<td>
							<a href="/mybackoffice/deal_order/coupon/<?=$order_id ?>/24" onclick="if(confirm('ต้องการปรับสถานะเลขใบสั่งซื้อ <?=$order_id?> เป็นชำระเงินแล้ว ?')){return true;}else{return false;};">
							<?=image_asset("bank_logo/boa_logo.jpg");?></a></td>
				</tr>
				<tr height="100px">
						<td>
							 <a href="/mybackoffice/deal_order/coupon/<?=$order_id ?>/23" onclick="if(confirm('ต้องการปรับสถานะเลขใบสั่งซื้อ <?=$order_id?> เป็นชำระเงินแล้ว ?')){return true;}else{return false;};">
							 <?=image_asset("bank_logo/bbl_logo.jpg");?></a></td>
						<td>
							<a href="/mybackoffice/deal_order/coupon/<?=$order_id ?>/22" onclick="if(confirm('ต้องการปรับสถานะเลขใบสั่งซื้อ <?=$order_id?> เป็นชำระเงินแล้ว ?')){return true;}else{return false;};">
							<?=image_asset("bank_logo/scb_logo.jpg");?></a></td>
				</tr>
				<tr height="100px">
						<td colspan="2" align="center">
							<a href="/mybackoffice/deal_order/coupon/<?=$order_id ?>/25" onclick="if(confirm('ต้องการปรับสถานะเลขใบสั่งซื้อ <?=$order_id?> เป็นชำระเงินแล้ว ?')){return true;}else{return false;};">
							<?=image_asset("bank_logo/paysbuy_711.jpg");?></a></td>
				</tr>
			</table>
			</div>
	</div>
	<div id="payment_popup_footer">
	</div>
</div>
