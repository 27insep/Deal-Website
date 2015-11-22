<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns:fb="http://ogp.me/ns/fb#">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link rel="stylesheet" type="text/css" href="/assets/css/coupon.css" />
	<script type="text/javascript" src="/assets/js/jquery.printElement.min.js"></script>
</head>
<body>
	<div class="print" id="coupon_print"><a href="#" onclick="window.print();"><?echo image_asset('bt_pdf.png', '', array('alt'=>'พิมพ์'));?></a></div>
	<div class="print"><a href="../../../../../coupon/printPDF/<?=$member_id?>/<?=$deal_id?>/<?=$coupon?>"><?echo image_asset('bt_print.png', '', array('alt'=>'บันทึกเป็น PDF'));?></a></div>
	<div class="iframe"><iframe src='../../../../../member/printcoupon/<?=$deal_id?>/<?=$coupon?>/<?=$member_id?>' scrolling=Yes width=950 height=1100  name="top_frame"></iframe>
		
	</div>
<script>
	function print_page()
	{
		//window.print();
		//$('#print_button').hide();
		$("#coupon_print").printElement(
            {
            overrideElementCSS:[
		'coupon.css',
		{ href:'/assets/css/coupon.css',media:'print'}]
            });
	}
</script>
</body>
</html>