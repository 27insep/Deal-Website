<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?=$page_data['page_title']?></title>
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
<div id="warper">
    <div id="header">
        <div id="header_inner">
            <h1><a href="/mybackoffice/logout">ออกจากระบบ</a></h1>
        </div>
    </div>
    <div id="container">
       	<div id="admin_navigator">
        	<ul id="admin_menu" class="left-menu_section">
        	<? foreach($page_data['page_menu'] as $menu){ ?>
            	<li><a href="<?=$menu["link"]?>"><?=$menu["name"]?></a></li>
       	 	<? } ?>	
        	</ul>
       	</div>
       	<div id="admin_header_section">
            <h1><?=$page_data['page_header']?></h1>
        </div>
        <div id="admin_view">
            <?=$page_data['content']?>
        </div>
    </div>
    <div id="admin_footer_section">
    	<div>© 2013 THE BEST DEAL CO., LTD. All Rights Reserved.</div>
    </div>
</div>
</body>
</html>