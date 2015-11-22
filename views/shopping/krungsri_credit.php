<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns:fb="http://ogp.me/ns/fb#">
<head>
	<title>The Best Deal One :: ตระกล้าสินค้า</title>
			<meta name="robots" content="INDEX,FOLLOW" />
	<meta name="author" content="THE BEST DEAL CO., LTD., Thailand" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta http-equiv="Cache-control" content="no-cache">
</head>
<body>
<p style="background:url(https://h.online-metrix.net/fp/clear.png?org_id=<?=$org_id?>&amp;session_id=<?=$merchant_id?><?=$session_id?>&amp;m=1)"></p>
<img src="https://h.online-metrix.net/fp/clear.png?org_id=<?=$org_id?>&amp;session_id=<?=$merchant_id?><?=$session_id?>&amp;m=2" alt="">
<object type="application/x-shockwave-flash" data="https://h.online-metrix.net/fp/fp.swf?org_id=<?=$org_id?>&amp;session_id=<?=$merchant_id?><?=$session_id?>" width="1" height="1" id="thm_fp">
<param name="movie" value="https://h.online-metrix.net/fp/fp.swf?org_id=<?=$org_id?>&amp;session_id=<?=$merchant_id?><?=$session_id?>" />
</object>
<script src="https://h.online-metrix.net/fp/check.js?org_id=<?=$org_id?>&amp;session_id=<?=$merchant_id?><?=$session_id?>" type="text/javascript"></script>
<form id="payment_form" action="https://testsecureacceptance.cybersource.com/pay" method="post">
    <?php
    	foreach($params as $name => $value) 
    	{
            echo "<input type=\"hidden\" id=\"" . $name . "\" name=\"" . $name . "\" value=\"" . $value . "\"/>\n";
        }
	?>
    <input type="hidden" id="signature" name="signature" value="<?=$sign?>"/>
</form>
<script>
	document.getElementById("payment_form").submit();
</script>
</body>
</html>