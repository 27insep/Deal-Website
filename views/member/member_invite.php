<style type="text/css" media="screen">
  #custom-tweet-button a {
    display: block;
    background: url('/assets/images/twitter_invite.jpg');
    height: 33px;
    width: 193px;
    float: left;
  }
</style>
<div id="main_inner">
	<div id="member_header">คำเชิญของฉัน</div>
	<div id="member_main_box">
	<div id="member_main_box_left">
		<div id="my_invite_main">
			<h2>เชื่อมต่อและแบ่งบันกับเพื่อนๆ ผ่านทาง Facebook หรือ Twitter ของคุณ</h2>
			<br/>
			<div id="invite_button">
				<div>
				<? $fb_link	=	"https://www.facebook.com/dialog/feed?app_id=458358780877780&"
 		 								."link=http://www.thebestdeal1.com/customer/signup/".$member_id."&"
  										."picture=http://www.thebestdeal1.com/assets/images/company_logo.png&"
  										."name=Thebestdeal1.com&"
  										."display=popup&"
  										."caption=แนะนำสมาชิก&"
  										."description=เว็บดีลอันดับหนึ่งในใจหลายๆคน%20thebestdeal1.com&"
  										."redirect_uri=https://mighty-lowlands-6381.herokuapp.com";
  				?>
				<a href="#" onclick="popitup('<?=$fb_link?>')">
					<?echo image_asset('facebook_invite.jpg', '', array('alt'=>'ส่งคำเชิญทาง Facebook ของคุณ'));?>
				</a>
				</div>
				<div id="custom-tweet-button">
					<a href="https://twitter.com/share?url=http%3A%2F%2Fwww.thebestdeal1.com%2Fcustomer%2Fsignup%2Fpages%2F<?=$member_id?>" target="_blank"></a>
				</div>
			</div>
		</div>
	</div>
	<div id="member_main_box_right">
			<?=$right_sec?>
	</div>
	</div>
</div>
<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
<script>
	$('.fancybox').fancybox();
</script>
<script language="javascript" type="text/javascript">
function popitup(url) {
	newwindow=window.open(url,'name','height=300,width=420');
	if (window.focus) {newwindow.focus()}
	return false;
}
</script>