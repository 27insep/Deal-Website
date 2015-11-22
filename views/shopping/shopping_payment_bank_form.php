<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns:fb="http://ogp.me/ns/fb#">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Thebestdeal1 : แบบฟอร์มการชำระเงิน</title>
	<!-- get css -->
	<? foreach($stylesheets as $stylesheet): ?>
  		<?= css_asset($stylesheet); ?>    
	<? endforeach; ?>
	<script type="text/javascript" src="/assets/js/jquery.printElement.min.js"></script>
</head>
<body>
<div id="form_payment_bank_main">
	<div>
		 <?echo image_asset('pay_in.jpg', '');?>
	</div>
	<div align="center" class="clear">
		<input type="button"  value="พิมพ์หน้านี้" onclick="print_page()" style="cursor: pointer;" />
	</div>
	<br/>
</div>
<script>
	function print_page()
	{
		//window.print();
		//$('#print_button').hide();
		$("#form_payment_bank_main").printElement(
            {
            overrideElementCSS:[
		'payment.css',
		{ href:'/assets/css/payment.css',media:'print'}]
            });
	}
</script>
</body>
</html>