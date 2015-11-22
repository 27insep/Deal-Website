<div class="menu_add_box">
	<? if(!isset($deal_id)){?>
		<a href="/mybackoffice/deal_product/insert_form"  target="_blank">เพิ่มข้อมูล</a>
	<? }else{?>
		<a href="/mybackoffice/deal_product/insert_form/0/<?=$deal_id?>"  target="_blank">เพิ่มข้อมูล</a>
	<? } ?>
</div>
<br>
<?if(isset($vendor)){?>
<div class="div_head">
		<div class="head_shop">ชื่อร้านค้า &nbsp; : &nbsp;  <?=$vendor["vendor_name"]?></div>
		<div class="head_deal">ชื่อดีล &nbsp; : &nbsp;  <?=$vendor["deal_name"]?></div>
</div>
<?}?>
<br>
<div class="clear">สถานะ :
	<select id="products_status">
		<option value="3">ทั้งหมด</option>
		<option value="1">เปิดการใช้งาน</option>
		<option value="0">หยุดชั่วคราว</option>
		<option value="2">คูปองหมด</option>
	</select>
</div>
<div>
	<table cellpadding="0" cellspacing="1" border="0" class="display" id="show_data" width="100%">
		<thead>
			<th width="200px">วันที่เพิ่มแคมเปญ</th>
			<th width="150px">ชื่อร้านค้า</th>
			<th width="250px">ชื่อดีล</th>
			<th width="300px">ชื่อแคมเปญ</th>
			<th width="150px">ราคาสุทธิ (บาท)</th>
			<th width="100px">status</th>
			<th width="100px">สถานะ</th>
			<th width="100px">คูปองทั้งหมด</th>
			<th width="100px">จำนวนคงเหลือ</th>
			<th width="150px">การจัดการ</th>
		</thead>
		<? 
		foreach($deal_product as $data){?>
			<tr>
				<td align="center"><?=date("d/m/Y H:i:s",strtotime($data["product_create"]));?></td>
				<td align="center"  class="deal_link"><a href="/mybackoffice/vendor_profile/view_data/<?=$data["vendor_id"]?>" target="_blank"><?=$data["vendor_name"]?></a></td>
				<td align="center"  class="deal_link"><a href=/category/deal_preview/<?=$data["deal_id"]?>/<?=urlencode($data["deal_name"])?>" target='_blank'><?=$data["deal_name"]?></a></td>
				<td align="center"><?=$data["product_name"]?></td>
				<td align="center"><?=number_format($data["product_total_price"],2,'.',',')?></td>
				<td align="center"><?=$data["product_status"]?></td>
				<td align="center"><? if($data["product_status"]==1) echo "เปิดการใช้งาน";if($data["product_status"]==0) echo "หยุดชั่วคราว";if($data["product_status"]==2) echo "คูปองหมด";?></td>
				<td align="center">
				<? 
						$nCoupon = 0;
					foreach($coupon as $c){?>
					<?if($data["product_id"] == $c["product_id"])
								$nCoupon =  $c["nCoupon"]+$data["product_in_store"];
					?>
				<?}	
					if($nCoupon == 0)
						$nCoupon = $nCoupon + $data["product_in_store"];
					echo $nCoupon;?>
				</td>
				<td  align="center"><?=$data["product_in_store"]?></td>
				<td align="center">
					<a href="/mybackoffice/deal_product/view_data/<?=$data["product_id"]?>/<?=$data["deal_id"]?>"><?=image_asset('/icon/info.png', '', array('alt'=>'รายละเอียด','title'=>'รายละเอียด'));?></a> |
					<?if(isset($deal_id)){?>
							<a href="/mybackoffice/deal_product/update_form/<?=$data["product_id"]?>/<?=$data["deal_id"]?>"><?=image_asset('/icon/edit.png', '', array('alt'=>'แก้ไข','title'=>'แก้ไข'));?></a> |
							<a href="/mybackoffice/deal_product/delete/<?=$data["product_id"]?>/<?=$data["deal_id"]?>" onclick="if(confirm('ต้องการลบแคมเปญ <?=$data["product_name"]?> ?')){return true;}else{return false;};">
									<?=image_asset('/icon/delete.png', '', array('alt'=>'ลบข้อมูล','title'=>'ลบข้อมูล'));?>
							</a> |
					<?}else{?>
							<a href="/mybackoffice/deal_product/update_form/<?=$data["product_id"]?>"><?=image_asset('/icon/edit.png', '', array('alt'=>'แก้ไข','title'=>'แก้ไข'));?></a> |
							<a href="/mybackoffice/deal_product/delete/<?=$data["product_id"]?>" onclick="if(confirm('ต้องการลบแคมเปญ <?=$data["product_name"]?> ?')){return true;}else{return false;};">
									<?=image_asset('/icon/delete.png', '', array('alt'=>'ลบข้อมูล','title'=>'ลบข้อมูล'));?>
							</a> |
					<?}?>
					<a href="/mybackoffice/deal_order/main/0/0/<?=$data["product_id"]?>/3"><?=image_asset('/icon/order.png', '', array('alt'=>'ใบสั่งซื้อ','title'=>'ใบสั่งซื้อ'));?></a> |
					<a href="/mybackoffice/coupon_manage/main/0/<?=$data["product_id"]?>/3"><?=image_asset('/icon/info.png', '', array('alt'=>'คูปอง','title'=>'คูปอง'));?></a>
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				</td>
			</tr>
		<? } ?>
	</table>
</div>
<script type="text/javascript" charset="utf-8">
$.fn.dataTableExt.afnFiltering.push(
    function( oSettings, aData, iDataIndex ) {
    	var check_products_status		=	false;
       	var status		= aData[5];
        var products_status	= $("#products_status").val();
        
        if(products_status==3)
        {
        	check_products_status	=	true;
        }else {
        	 if(products_status==status)
        	 	check_products_status	=	true;
        }
        
        return check_products_status;
 });
 
 var oTable = $('#show_data').dataTable({
 	 	"aaSorting": [[ 0, "desc" ]],
    	"aoColumnDefs": [
            { "bVisible": false,  "aTargets": [5] }
        ]
    });
    
	$("#products_status").change(
		function(){
			oTable.fnDraw();
		}
	);
</script>