<br/>
<? if(!isset($deal_id) || empty($deal_id)){?>
	<div style="float: right"><a href="/mybackoffice/deal_product/">กลับสู่หน้าหลัก</a></div>
<? }else{?>
	<div style="float: right"><a href="/mybackoffice/deal_product/main/0/<?=$deal_id?>">กลับสู่หน้าหลัก</a></div>
<? } ?>
<form name="deal_product_form" id="deal_product_form" method="post" action="<?=$page_action?>">
<div>
	<span class="header_title"><?=$manage_title?></span>
	<br/><br/>
	<table border="0">
		<? if(isset($vendor_name)){?>
		<tr class="heightForm">
			<td>ชื่อร้านค้า</td>
			<td><div id="show_vendor"><?=$vendor_name?></div></td>
		</tr>
		<?}?>
		<tr class="heightForm">
			<td>ดีล</td>
			<td>
				<select id="deal_id" name="deal_id" onchange="load_vendor_name()">
					<option value="">- - - กรุณาเลือกดีล - - -</option>
				<? foreach($tbl_deal_main as $data){
						if(isset($deal_id) && $deal_id == $data["deal_id"]){?>	
							<option selected="selected" value="<?=$data["deal_id"]?>"><?=$data["deal_name"]?></option>
				<? 		}else{ ?>
							<option value="<?=$data["deal_id"]?>"><?=$data["deal_name"]?></option>
				<? 		}
					} ?>
				</select>
			</td>
		</tr>
		<tr class="heightForm">
			<td>ชื่อแคมเปญ</td>
			<td><input type="text" size="50" value="<?if(isset($product_name)){ echo $product_name;}?>" name="product_name" id="product_name"/></td>
		</tr>
		<tr class="heightForm">
			<td valign="top">รายละเอียดแคมเปญ</td>
			<td><textarea  name="product_detail" id="product_detail" cols="75" rows="5"><?if(isset($product_detail)){ echo $product_detail;}?></textarea></td>
		</tr>
		<tr class="heightForm">
			<td>ราคาปกติ</td>
			<td><input type="text" onkeyup="isNumber(this);" value="<?if(isset($product_price)){ echo $product_price;}?>" name="product_price" id="product_price"/>  บาท</td>
		</tr>
		<tr class="heightForm">
			<td>ราคาเดอะเบสดีลวัน</td>
			<td><input type="text" onkeyup="isNumber(this);" value="<?if(isset($product_total_price)){ echo $product_total_price;}?>" name="product_total_price" id="product_total_price"/>  บาท</td>
		</tr>
		<tr class="heightForm">
			<td>ภาษี</td>
			<td>
				<input type="radio" onclick="cal_total_price()" name="product_include_vat" id="product_include_vat" value="7" <?if(isset($product_include_vat)){if($product_include_vat==7){?>checked="checked"<?}}else{?>checked="checked"<?}?>/> รวมภาษี 7% แล้ว&nbsp;&nbsp;&nbsp;
				<input type="radio" onclick="cal_total_price()" name="product_include_vat" id="product_include_vat" value="0" <?if(isset($product_include_vat)){if($product_include_vat==0){?>checked="checked"<?}}?> /> ยังไม่รวมภาษี
			</td>
		</tr>
		<tr class="heightForm">
			<td>ส่วนลด (%)</td>
			<td><input type="text" onkeyup="isNumber(this);" value="<?if(isset($product_discount_per)){ echo $product_discount_per;}?>" name="product_discount_per" id="product_discount_per"/></td>
		</tr>
		<tr class="heightForm">
			<td>จำนวนคูปองทั้งหมด</td>
			<td>
					<input type="text" onkeyup="isNumber(this)" value="<?if(isset($product_in_store)){ echo $product_in_store;}?>" name="product_in_store" id="product_in_store"/> อัน
			</td>
		</tr>
		<tr class="heightForm">
			<td>สามารถซื้อได้ต่อคน</td>
			<td>
					<input type="radio" onclick="show_instore()"  name="product_rd_limit" id="product_rd_limit" value="0" <?if(isset($product_rd_limit) || (isset($product_limit) && $product_limit == 0)){if($product_rd_limit=="0" || $product_limit == 0){?>checked="checked"<?}}else{?>checked="checked"<?}?>/> ไม่จำกัด &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					<input type="radio" onclick="show_instore()"  name="product_rd_limit" id="product_rd_limit" value="1" <?if(isset($product_rd_limit) || (isset($product_limit) && $product_limit != 0)){if($product_rd_limit=="1" || $product_limit != 0){?>checked="checked"<?}}else{?>checked="checked"<?}?>/> จำกัดที่ &nbsp;
					<input type="text" onkeyup="isNumber(this)" value="<?if(isset($product_limit)){ echo $product_limit;}?>" name="product_limit" id="product_limit"/>
			</td>
		</tr>
		<tr class="heightForm">
			<td>เดอะเบสดีล MDR (%)</td>
			<td><input type="text" onkeyup="isNumber(this);" value="<?if(isset($product_mrd)){ echo $product_mrd;}?>" name="product_mrd" id="product_mrd"/> <span class="text_red">* ระบุค่าคอมมิชชั่น</span></td> 
		</tr>
		<tr class="heightForm">
			<td>สถานะ</td>
			<td>
				<select name="product_status" id="product_status">
					<option value="1" <? if(isset($product_status) && $product_status == '1'){echo 'selected';}?>>เปิดการใช้งาน</option>
					<option value="0" <? if(isset($product_status) && $product_status == '0'){echo 'selected';}?>>หยุดชั่วคราว</option>
					<option value="2" <? if(isset($product_status) && $product_status == '2'){echo 'selected';}?>>คูปองหมด</option>
				</select>
			</td>
		</tr>
		<tr class="heightForm">
			<td></td>
			<td><input name="submit" id="submit" type="submit" value="บันทึกข้อมูล" /></td>
		</tr>
	</table>
</div>
</form>
<script>
	/*
	cal_total_price();
	function cal_total_price()
	{
		var price	=	parseFloat($("#product_price").val());
		
		if($("#product_include_vat:checked").val()>0)
		{
			price	=	price+(price*0.07);	
		}
		$("#total_price").html(price);
	}
	*/
    function isNumber(field) { 
        	var re = /^[0-9-'.'-',']*$/; 
        	if (!re.test(field.value)) { 
            	//alert('Value must be all numberic charcters, including "." or "," non numerics will be removed from field!'); 
            	field.value = field.value.replace(/[^0-9-'.'-',']/g,""); 
        	} 
    } 
    $("#deal_product_form").validate({
   	rules: {
     // simple rule, converted to {required:true}
     deal_id:{
     	required:true
     }
     ,product_name: {
     	required:true
     }
    ,product_detail :{
    	required:true
    }
    ,product_total_price:{
		required:true
	}
	,product_price :{
		required:true
	}
	,product_status :{
		required:true
	}
	,product_limit :{
		required:true
	}
	,product_in_store:
	{
		required:true
	}
	,product_discount_per:{
		required:true
	}
	,product_mrd:{
		required:true
	}
   },
   messages: {
     deal_id:{
     	required:"กรุณาเลือกแคมเปญ"
     }
     ,product_name: {
     	required:"กรุณาระบุชื่อแคมเปญ"
     }
    ,product_detail :{
    	required:"กรุณาระบุรายละเอียดแคมเปญ"
    }
	,product_total_price :{
		required:"กรุณาระบุราคาเดอะเบสดีลวัน"
	}
	,product_price :{
		required:"กรุณาระบุราคาปกติ"
	}
	,product_status :{
		required:"กรุณาเลือกสถานะแคมเปญ"
	}
	,product_limit :{
		required:"กรุณาระบุจำนวนการซื้อต่อคน"
	}
	,product_discount_per:{
		required:"กรุณาระบุส่วนลด (%)"
	}
	,product_mrd:{
		required:"เดอะเบสดีล MDR (%)"
	}
	,product_in_store:
	{
		required:"กรุณาระบุจำนวนคูปองทั้งหมด"
	}
   }
});

function load_vendor_name()
{
		var deal_id	=	$("#deal_id").val();
		$.ajax({
  			url: "/vendor/get_vendor/"+deal_id,
  			cache: false
		}).done(function( html ) {
  			$("#show_vendor").html(html);
		});
}

function show_instore()
{
	
	 if($('input[name=product_rd_limit]:checked').val() == "0"){
	 	$("#product_limit").val("");
	 	$("#product_limit").hide();
	 }else{
	 	$("#product_limit").show();
	 }
}

$(document).ready(function() {
	if($('input[name=product_rd_limit]:checked').val() == "0"){
	 	$("#product_limit").val("");
	 	$("#product_limit").hide();
	 }else{
	 	$("#product_limit").show();
	 }
});
</script>