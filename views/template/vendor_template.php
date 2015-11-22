<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta http-equiv="Cache-control" content="no-cache">
<title>:: ยินดีต้อนรับ ::</title>
<!-- get css -->
<? foreach($stylesheets as $stylesheet): ?>
  <?= css_asset($stylesheet); ?>    
<? endforeach; ?>

<!-- get js -->
<? foreach($javascripts as $javascript): ?>
  <?= js_asset($javascript); ?>
<? endforeach; ?>

</head>
<body>
<div id="container">
	<?=$page_data['content']?>
</div>
<div id="dialog"></div>
</body>
</html>