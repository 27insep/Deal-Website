<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
	<head>
		<link type="text/css" href="/assets/css/pikachoose-classic-theme.css" rel="stylesheet" />
		<script type="text/javascript" src="/assets/js/jquery.min.js"></script>
		<script type="text/javascript" src="/assets/js/jquery.pikachoose.full.js"></script>
		<script language="javascript">
			$(document).ready(
				function (){
					var preventStageHoverEffect = function(self){
						self.wrap.unbind('mouseenter').unbind('mouseleave');
						self.imgNav.append('<a class="tray"></a>');
						self.imgNav.show();
						self.hiddenTray = true;
						self.imgNav.find('.tray').bind('click',function(){
							if(self.hiddenTray){
								self.list.parents('.jcarousel-container').animate({height:"80px"});
							}else{
								self.list.parents('.jcarousel-container').animate({height:"1px"});
							}
							self.hiddenTray = !self.hiddenTray;
						});
					}
					$("#pikame").PikaChoose({bindsFinished: preventStageHoverEffect, carousel:true});
				});
		</script>		
</head>
<body>
<div class="pikachoose-classic">
	<ul id="pikame" >
		<li><img src="/assets/images/upload/deal/3/13/deal_slide/slide_13_1366548978_1.jpeg"/></li>
		<li><img src="/assets/images/upload/deal/3/13/deal_slide/slide_13_1366548398_2.jpeg"/></li>
		<li><img src="/assets/images/upload/deal/3/13/deal_slide/slide_13_1366548398_3.jpeg"/></li>
		<li><img src="/assets/images/upload/deal/3/13/deal_slide/slide_13_1366548398_4.jpeg"/></li>
	</ul>
</div>
</body>
</html>
