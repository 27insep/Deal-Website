<div id="top_bar_left_sec" style="font-size: 0.9em"><a class="fancybox fancybox.ajax" href="/member/popup_register" title="สมัครสมาชิก คลิกที่นี่" alt="สมัครสมาชิก คลิกที่นี่">คลิกสมัครสมาชิก</a> | เข้าสู่ระบบ</div>
		<div id="top_bar_right_sec">
			<form id="login_form" name="login_form" action="/member/login" method="post">
			<div> 
				<input type="text" name="login_name" id="login_name" value="ระบุอีเมลที่สมัคร" size="12" onBlur="checkValue(this,this.defaultValue)" onFocus="clearValue(this,this.defaultValue)" />
				<input type="password" name="login_pwd" id="login_pwd" value="" size="10"/>
				<input type="image" src="/assets/images/bt_login.png" id="login_button" /> หรือ 
				<img src="/assets/images/fb_login_big_button.png" class="can_click" onclick='login();'/>
			</div>
            <div class="capt_login">
                <div style="float: left;width:230px;display: none;" id="cha"><?=$capcha?> <input type="text" class="in_logintxt" name="capcha_login" /></div>
                <div style="float: left;width:220px;">
                <label><input type="checkbox" name="remeberme" id="rememerme" value="1"  alt="เข้าสู่ระบบอัตโนมัติ" title="เข้าสู่ระบบอัตโนมัติ"/> เข้าสู่ระบบอัตโนมัติ</label> | 
				<a class="fancybox fancybox.ajax" href="/member/popup_forget_password" alt="ลืมรหัสผ่าน คลิกที่นี่" title="ลืมรหัสผ่าน คลิกที่นี่">ลืมรหัสผ่าน</a>
            	</div>
			</div>
			</form>
		</div>

<script>
	$('.fancybox').fancybox({'ajax':{cache	: false}});
</script>
<script type="text/javascript">
function clearValue(obj,text)
{
if ( obj.value == text ) obj.value = '';
}
function checkValue(obj,text)
{
if ( obj.value == '' ) obj.value = text;
}
</script>