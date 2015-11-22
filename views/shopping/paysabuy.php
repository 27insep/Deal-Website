<form method="post" action="https://www.PAYSBUY.com/paynow.aspx?cs=true" id="paysabuy_form">
<input type="hidden" name="psb" value="psb">
<input type="hidden" name="biz" value="oratai_aoun@hotmail.com">
<input type="hidden" name="inv" value="<?=$order_id?>">
<input type="hidden" name="itm" value="<?=$product?>">
<input type="hidden" name="amt" value="<?=$amount?>">
<input type="hidden" name="reqURL" value="http://www.thebestdeal1.com/shopping/paysabuy_callback/<?=$order_id?>">
<input type="hidden" name="postURL" value="http://www.thebestdeal1.com/shopping/shopping_thankyou/<?=$order_id?>">
<!--
<input type="image" src="https://www.PAYSBUY.com/images/p_click2pay.gif" border="0" name="submit" alt="Make payments with PAYSBUY - it's fast, free and secure!">
-->
</form >
<script>
	document.getElementById("paysabuy_form").submit();
</script>