<div id="cart_detail">
    <div id="member_header">ตะกร้าของฉัน</div>
	<?
	if(sizeof($cart_data)==0){
	?>
	<div id="not_have_item">คุณยังไม่มีสินค้าในตระกล้าสินค้าค่ะ !</div>
	</div>
	<?
		return;	
	}
	?>
    <form name="order_form" id="order_form" method="post" action="/shopping/checkout">
    <div id="main_cart" class="o">
    	<div id="pay_tbH">
        	<ul>
            	<li id="pDeal" class="pay_tb_borR">&nbsp;&nbsp;&nbsp;&nbsp;ดีลในตระกล้า</li>
                <li id="pPrice" class="pay_tb_borLR">ราคา</li>
                <li id="pNumber" class="pay_tb_borLR">จำนวน</li>
                <!--
                <li id="pDiscount" class="pay_tb_borLR">ส่วนลด</li>
                -->
                <li id="pTotal" class="pay_tb_borLR">รวม</li>
                <li id="pDel" class="pay_tb_borL">ลบ</li>
            </ul>
        </div>
        <? 
        $summary_all	=	0;
		$nRow				=	0;
        foreach($cart_data as $item)
        {
        	//print_r($item);
        	$summary	= ($item["product"]['product_total_price']*$item["qty"]);
        ?>
        <div id="product_<?=$item["id"]?>" class="pay_tbC">
        	<input name="order[<?=$item["id"]?>][deal_id]" type="hidden" id="order_<?=$item["id"]?>_deal_id" value="<?=$item["product"]["deal_id"]?>" />
        	<ul>
            	<li id="pDeal" class="pay_tb_borR">
                <span class="pay_fL"><?echo image_asset($item["product"]["deal_index_image"], '', array('alt'=>$item["product"]["deal_name"],'width'=>'130px','height'=>'100px'));?></span>
                <span class="pay_fR"><?=$item["product"]['product_name']?></span>
                <span class="pay_fR_detail"><?=$item["product"]['product_detail']?></span>
                </li>
                <li id="pPrice" class="pay_tb_borLR">฿<?=number_format($item["product"]['product_total_price'])?><span class="hidden_price"><?=$item["product"]['product_total_price']?></span></li>
                <li id="pNumber" class="pay_tb_borLR">
                	<input name="order[<?=$item["id"]?>][qty]" class="spinner" id="spinner_<?=$item["id"]?>" value="<?=number_format($item["qty"])?>"/>
                </li>
                <!--
                <li id="pDiscount" class="pay_tb_borLR"><?=$item["product"]["deal_percent_off"]?> %</li>
                -->
                <li id="pTotal" class="pay_tb_borLR"><span id="pTotal_<?=$nRow++?>">฿<?=number_format($summary)?></span><span id="product_price_<?=$item["id"]?>" style="display:none;"><?=$summary?></span></li>
                <li id="pDel" class="pay_tb_borL">
                	<img class="can_click" src="/assets/images/payment/del.png" onclick="remove_row('product_<?=$item["id"]?>',<?=$item["id"]?>)" />
                </li>
            </ul>
        </div>
        <? 
        		$summary_all+= $summary;
			} 
		?>
        <div id="pay_total">
            <div>
            	<div class="ttL">รวมทั้งหมด</div>
                <div class="ttR ttA" id="show_summary">฿<?=number_format($summary_all)?><input type="hidden" name="price_summary" id="price_summary" value="<?=$summary_all?>" /></div>
            </div>
        </div>
        <div id="check_out_butt">
        		<div>
               	 	<a href="/" ><?echo image_asset('shop_deal_button.png', '', array('alt'=>'ช็อปดีลต่อ'));?></a>
                	<span class="can_click"  onclick="show_confirm_payment()"><?echo image_asset('payment_button.png', '', array('alt'=>'ชำระเงิน'));?></span>
        		</div>
        </div>
        <div id="confirm_payment">
        <div class="clear">
        <div id="pay_condition">
        	<input type="checkbox" name="accept_condition" id="accept_condition" value="1"/> <span>ยอมรับ<a href="/home/salecondition/" target="_blank">เงื่อนไขการขาย</a></span>
        	<div>กรุณากดยอมรับ<a href="/home/salecondition/" target="_blank">เงื่อนไขการขาย</a> และข้อกำหนด <br/>ที่ทาง TheBestDeal1.com ได้กำหนดไว้ ก่อนทำการสั่งซื้อค่ะ</div>
        </div>
        <div id="pay_solution">
        	<div><span>ช่องทางการชำระเงิน</span></div>
        	<div><input type="radio" name="how2pay" id="how2pay_cs" value="2" onclick="load_how2pay(5)"/>ชำระเงินผ่านเคาน์เตอร์เซอร์วิส</div>
        	<!--<div><label><input type="radio" name="how2pay" id="how2pay" value="3" onclick="load_how2pay(6)" checked="checked"/>ชำระเงินผ่าน Tesco Lotus</label></div>-->
        	<!--
        	<div><input type="radio" name="how2pay" id="how2pay" value="4" onclick="load_how2pay(7)"/>ชำระเงินออนไลน์</div>
        	-->
        	<div><label><input type="radio" name="how2pay" id="how2pay_bk" value="1" onclick="load_how2pay_bank()"/>ชำระเงินผ่านธนาคารต่างๆ </label>
        	<select id="select_bank" name="select_bank" onchange="load_how2pay_bank()">
        		<option value="1">ธนาคารกสิกรไทย</option>
        		<option value="2">ธนาคารไทยพาณิชย์</option>
        		<option value="3">ธนาคารกรุงเทพ</option>
        		<option value="4">ธนาคารกรุงศรีอยุธยา</option>
        	</select>	
        	</div>
        </div>
        </div>
        <div id="how2pay_bank"></div>
        <div class="pay_btsec">
            <input id="order_submit" style="display: block;float: left;" type="submit" value="สั่งซื้อ" class="pay_bt fR" />
        </div>
        </div>
    </div>
    <input id="pre_order_id" name="pre_order_id" value="<?=$pre_order_id?>" type="hidden"/>
    </form>
</div>
<script>
	var payment_type	=	0;
	function show_confirm_payment()
	{
		$("#check_out_butt").remove();
		$("#confirm_payment").fadeIn("slow");
		$(".pay_tb_borLR a").remove();
		$(".pay_tb_borLR input").css("display","none");
		$(".pay_tb_borLR input").each(function( index ) 
		{
    		$(this).parent().append("<span>"+$(this).val()+"</span>");
		});
		$(".pay_tb_borL").remove();
	}
	function remove_how2pay_bank()
	{
		$("#how2pay_bank div").remove();
	}
	function load_how2pay(pay_type)
	{
		payment_type=2;
		$.ajax({
  			type: "POST",
  			url: "/shopping/how2pay/",
  			data: { pay_type: pay_type}
			}).done(function( msg ) {
 				$("#how2pay_bank").html(msg);
		});
	}
	function load_how2pay_bank()
	{
		payment_type=1;
		var bank_id				=	$("#select_bank").val();
		$.ajax({
  			type: "POST",
  			url: "/shopping/how2pay/",
  			data: { pay_type: bank_id}
			}).done(function( msg ) {
 				$("#how2pay_bank").html(msg);
		});
	}
	function addCommas(str) {
    	var amount = new String(str);
    	amount = amount.split("").reverse();

    	var output = "";
    	for ( var i = 0; i <= amount.length-1; i++ ){
        	output = amount[i] + output;
        	if ((i+1) % 3 == 0 && (amount.length-1) !== i)output = ',' + output;
    	}
    	return output;
	}
	
	function add2cart(id)
  	{
  		var qty		=	$( "#spinner_"+id ).spinner("value");
  		if(qty>0)
  		{
  		$.ajax({
  			type: "POST",
  			url: "/shopping/add_to_cart",
  			data: { product_id: id, product_qty: qty,product_price: $("#product_price_"+id).text()  }
			}).done(function( msg ) {
  				//$( "#dialog" ).html("เพิ่มสิ้นค้าลงในตระกล้าเรียบร้อยแล้วค่ะ");
 				//$( "#dialog" ).dialog({ title: "ข้อความ" });
 				//$("#total_item").html(msg);
 				//alert("เพิ่มสิ้นค้าลงในตระกล้าเรียบร้อยแล้วค่ะ !");
 		});
		}else{
			alert("กรุณาระบุจำนวนสินค้าด้วยค่ะ !");
		}
  	}
  	
	function update_summary()
	{
			var spiner	=	new Array();
			var summary		=	0;
		
    		$(".spinner").each(function( index ) {
    			spiner[index]	=	$(this).val();
			});
			$(".hidden_price").each(function( index ) {
    			summary+= ($(this).text()*spiner[index]);
    			$("#pTotal_"+index).html("฿"+addCommas(($(this).text()*spiner[index])));
			});
			
			$("#price_summary").val(summary);
		
			var show_summary	=	0;
			if(summary>0)
			{
				show_summary = addCommas(summary);
				$("#show_summary").html("฿"+show_summary);
			}else{
				$("#show_summary").html("฿0");
				summary	=	0;
			}
			return summary;
	}
	function remove_row(row_id,id)
	{
		$.ajax({
  			type: "POST",
  			url: "/shopping/remove_from_cart/",
  			data: { product_id: id }
			}).done(function( msg ) {
  				//$( "#dialog" ).html("เพิ่มสิ้นค้าลงในตระกล้าเรียบร้อยแล้วค่ะ");
 				//$( "#dialog" ).dialog({ title: "ข้อความ" });
 				$("#total_item").html(msg);
 				alert("ยกเลิกการสั่งซื้อเรียบร้อยแล้วค่ะ !");
 				$( "#sniper_"+id ).spinner("value",0);
		
				$("#"+row_id).remove();
				var summary	=	update_summary();
				
				if(summary<=0)
				{
					$("#main_cart").html('<div id="not_have_item">คุณยังไม่มีสินค้าในตระกล้าสินค้าค่ะ !</div>');
				}
				reload_cart();
		});
	}
	  $(function() {
    var spinner = $( ".spinner" ).spinner({ 
    	min: 1,
    	stop: function( event, ui ) 
    	{
    		var split_name	=	$(this).attr('id').split('_');
    		update_summary();
    		add2cart(split_name[1]);
    	} 
    });
 		function show_order_compleate(responseText, statusText, xhr, $form)
 		{
 			if(responseText!=0)
 			{
 				$( "#dialog" ).html("ทำการเข้าสั่งซื้อเรียบร้อยแล้วค่ะ");
 				$( "#dialog" ).dialog(
 					{ 
 						title: "ข้อความ",
 						close: function( event, ui ) 
 						{
 							if(payment_type!=2){
								window.location.href = '/shopping/shopping_thankyou/'+responseText;
							}else{
								window.location.href = '/shopping/paysabuy/'+responseText;
							}
 						},
 						buttons: [ { text: "ตกลง", click: function() { $( this ).dialog( "close" ); } } ] 
 					}); 
 			}
 			if(responseText==0)
 			{
 				$( "#dialog" ).html("ขออภัย สินค้าบางรายการไม่เพียงพอค่ะ");
 				$( "#dialog" ).dialog(
 					{ 
 						title: "ข้อความ"
 					}
 				);
 			}
 		}
 		
 		function showRequest(formData, jqForm, options) 
 		{
 			if ($('#accept_condition:checked').val() == undefined)
 			{
 				$( "#dialog" ).html("คุณยังไม่ได้ทำการยอมรับเงื่อนไขการขาย ก่อนสั่งซื้อค่ะ !!");
 				$( "#dialog" ).dialog({ title: "แจ้งเตือน" });
 				return false;
 			}
			else if ($("#how2pay_cs:checked").val() == undefined&&$("#how2pay_bk:checked").val() == undefined)
 			{
 				$( "#dialog" ).html("คุณยังไม่ได้ทำการเลิอกวิธีการชำระเงินค่ะ !!");
 				$( "#dialog" ).dialog({ title: "แจ้งเตือน" });
 				return false;
 			}else{
 				$("input[type=submit]").attr("disabled", "disabled");
 				return true;
 			}
 		}
 		
 		$('#order_form').ajaxForm(
 			{ 	
 				beforeSubmit:  showRequest,
 				success: show_order_compleate
 			} 
 		); 
  });

	$('.fancybox').fancybox({'ajax':{cache	: false}});
	
	  $(function() {
    var spinner = $( ".spinner" ).spinner({ min: 0 });
    <? 
    foreach($cart_data as $item){
    	$product	=	$item["product"];
    	if($product["product_limit"]==0||$product["product_limit"]>$product["product_in_store"]){	
    ?>
    		$( "#spinner_<?=$product["product_id"]?>" ).spinner({ max: <?=$product["product_in_store"]?> });
    <? }else{?>
    		$( "#spinner_<?=$product["product_id"]?>" ).spinner({ max: <?=$product["product_limit"]?> });
    <?
			}
	}
	?>
  });
</script>