<div id="main_inner">
    <div id="member_header">ตะกร้าของฉัน</div>
	<?
	if(sizeof($cart_data)==0){
	?>
	<div id="not_have_item"> ยังไม่มีสินค้าในตระกล้าสินค้าค่ะ !</div>
	<?
		return;	
	}
	?>
    <form name="order_form" id="order_form" method="post" action="/shopping/checkout">
    <div class="o">
    	<div id="pay_tbH">
        	<ul>
            	<li id="pDeal" class="pay_tb_borR">&nbsp;&nbsp;&nbsp;&nbsp;ดีลในตระกล้า</li>
                <li id="pPrice" class="pay_tb_borLR">ราคา</li>
                <li id="pNumber" class="pay_tb_borLR">จำนวน</li>
                <li id="pDiscount" class="pay_tb_borLR">ส่วนลด</li>
                <li id="pTotal" class="pay_tb_borLR">รวม</li>
                <li id="pDel" class="pay_tb_borL">ลบ</li>
            </ul>
        </div>
        <? 
        $summary_all	=	0;
		$nRow				=	0;
        foreach($cart_data as $item)
        {
        	$summary	= ($item["price"]*$item["qty"]);
			
        ?>
        <div id="product_<?=$item["id"]?>" class="pay_tbC">
        	<input name="order[<?=$item["id"]?>][deal_id]" type="hidden" id="order_<?=$item["id"]?>_deal_id" value="<?=$item["deal"]["deal_id"]?>" />
        	<ul>
            	<li id="pDeal" class="pay_tb_borR">
                <span class="pay_fL"><?echo image_asset($item["deal"]["deal_index_image"], '', array('alt'=>$item["deal"]["deal_name"],'width'=>'130px','height'=>'100px'));?></span>
                <span class="pay_fR"><?=$item["product"]['product_name']?></span>
                <span class="pay_fR_detail"><?=$item["product"]['product_detail']?></span>
                </li>
                <li id="pPrice" class="pay_tb_borLR">฿<?=number_format($item["price"])?><span class="hidden_price"><?=$item["price"]?></span></li>
                <li id="pNumber" class="pay_tb_borLR">
                	<input name="order[<?=$item["id"]?>][qty]" class="spinner" id="spinner_<?=$item["id"]?>" value="<?=number_format($item["qty"])?>" />
                </li>
                <li id="pDiscount" class="pay_tb_borLR"><?=$item["deal"]["deal_percent_off"]?> %</li>
                <li id="pTotal" class="pay_tb_borLR"><span id="pTotal_<?=$nRow++?>">฿<?=number_format($summary)?></span></li>
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
        <div class="clear">
        <div id="pay_condition">
        	<input type="checkbox" name="accept_condition" id="accept_condition" value="1"/> <span>ยอมรับ<a href="/home/salecondition/" target="_blank">เงื่อนไขการขาย</a></span>
        	<div>กรุณากดยอมรับ<a href="/home/salecondition/" target="_blank">เงื่อนไขการขาย</a> และข้อกำหนด <br/>ที่ทาง Thebestdeal1 ได้กำหนดไว้ ก่อนทำการสั่งซื้อค่ะ</div>
        </div>
        <div id="pay_solution">
        	<div><span>ช่องทางการชำระเงิน</span></div>
        	<div><input type="radio" name="how2pay" id="how2pay" value="1"/>ชำระเงินที่ธนาคาร</div>
        	<div><input type="radio" name="how2pay" id="how2pay" value="2"/>ชำระเงินผ่านเคาน์เตอร์เซอร์วิส</div>
        	<div><input type="radio" name="how2pay" id="how2pay" value="3"/>ชำระเงินผ่าน Tesco Lotus</div>
        	<div><input type="radio" name="how2pay" id="how2pay" value="4"/>ชำระเงินออนไลน์</div>
        </div>
        </div>
        <div class="pay_btsec">
            <input type="submit" value="สั่งซื้อ" class="pay_bt fR" />
        </div>
    </div>
    <input id="pre_order_id" name="pre_order_id" value="<?=$pre_order_id?>" type="hidden"/>
    </form>
</div>
<a style="display:none" id="show_payment_bank_form" class="fancybox fancybox.ajax" href="/shopping/payment_form/1/<?=$pre_order_id?>">-</a>
<a style="display:none" id="show_payment_couter_service_form" class="fancybox fancybox.ajax" href="/shopping/payment_form/2/<?=$pre_order_id?>">-</a>
<a style="display:none" id="show_payment_lotus_form" class="fancybox fancybox.ajax" href="/shopping/payment_form/3/<?=$pre_order_id?>">-</a>
<script>
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
		
			if(summary>0)
			{
				summary = addCommas(summary);
				$("#show_summary").html("฿"+summary);
			}else{
				$("#show_summary").html("฿0");
			}
	}
	function remove_row(row_id,id)
	{
		update_summary();
		
		$.ajax({
  			type: "POST",
  			url: "/shopping/remove_from_cart/",
  			data: { product_id: id }
			}).done(function( msg ) {
  				//$( "#dialog" ).html("เพิ่มสิ้นค้าลงในตระกล้าเรียบร้อยแล้วค่ะ");
 				//$( "#dialog" ).dialog({ title: "ข้อความ" });
 				$("#total_item").html(msg);
 				alert("ยกเลิกการสั่งซื้อเรียบร้อยแล้วค่ะ !");
		});
		$( "#sniper_"+id ).spinner("value",0);
		
		
		$("#"+row_id).remove();
	}
	  $(function() {
    var spinner = $( ".spinner" ).spinner({ 
    	min: 1,
    	stop: function( event, ui ) 
    	{
    		update_summary();
    	} 
    });
 		function show_order_compleate(responseText, statusText, xhr, $form)
 		{
 			if(responseText==1)
 			{
 				$( "#dialog" ).html("ทำการเข้าสั่งซื้อเรียบร้อยแล้วค่ะ");
 				$( "#dialog" ).dialog(
 					{ 
 						title: "ข้อความ",
 						close: function( event, ui ) 
 						{
 							
 							if($("#how2pay:checked").val()==1)
 							{
 								 $("#show_payment_bank_form").trigger('click');
 							}
 							if($("#how2pay:checked").val()==2)
 							{
 								 $("#show_payment_couter_service_form").trigger('click');
 							}
 							if($("#how2pay:checked").val()==3)
 							{
 								 $("#show_payment_lotus_form").trigger('click');
 							}
 							if($("#how2pay:checked").val()==4)
 							{
 								window.location.href = '/member/my_order';
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
 			}else if ($("#how2pay:checked").val() == undefined)
 			{
 				$( "#dialog" ).html("คุณยังไม่ได้ทำการเลิอกวิธีการชำระเงินค่ะ !!");
 				$( "#dialog" ).dialog({ title: "แจ้งเตือน" });
 				return false;
 			}else{
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
$('.fancybox').fancybox({
	'onClosed':function (){
		alert("pass");
		window.location.href = '/member/my_order';
	}
});
</script>