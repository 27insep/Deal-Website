<br/>
<div class="menu_add_box">
		<a href="/mybackoffice/home_slide/insert_form">เพิ่มรูปภาพ</a>
</div>
<div>
	<span class="header_title">รูปภาพสไลด์โปรโมชั่น</span>
</div>
<br/>
<div>
	<? 
	if(sizeof($promotion)<1)
	{
		?>
		<center><h3>ยังไม่มีข้อมูลรูปภาพค่ะ หากต้องการเพิ่มรูปภาพ <a href="/mybackoffice/home_slide/insert_form">คลิ๊กที่นี้</a> ค่ะ</h3></center>
		<?
	}else{
		foreach($promotion as $item){
	?>
			<?
			if($item["promotion_status"]==1)
			{
				$show_active	= "แสดง";
				$add_class = "active";
			}else{
				$show_active = "ไม่แสดง";
				$add_class = "not_active";
			}
		?>
		<div class="gallery_photo <?=$add_class?>">
			<div style="float: left;">
			<?=$show_active?>
			</div>
			<div style="float: right;" onclick="remove_pic('<?=$item["promotion_id"]?>','<?=$item["pic_path"]?>')">
				<?=image_asset('/icon/delete.png', '', array('alt'=>'ลบข้อมูล','title'=>'ลบรูปภาพ'));?>
			</div>
			<div style="float: right;margin: 0 5px 0 0" onclick="edit_pic('<?=$item["promotion_id"]?>')">
				<?=image_asset('/icon/edit.png', '', array('alt'=>'ลบข้อมูล','title'=>'ลบรูปภาพ'));?>
			</div>
			<div style="clear: both;padding: 5px 0 0 0;">
				<img src="/assets/images/<?=$item["pic_path"]?>" width="150" height="59" onclick="edit_pic('<?=$item["promotion_id"]?>')" class="can_click" />
			</div>
		</div>
	<? 
		} 
	}
	?>
</div>
<script>
	function remove_pic(id,path)
	{
		if(confirm('ต้องการลบรูปภาพดังกล่าว ?')){
			$.ajax({
				 type: "POST",
  				 url: "/mybackoffice/home_slide/delete",
  				 data: { pic_id: id, pic_path:path }
			}).done(function( msg ) {
				alert("ทำการลบรูปภาพเรียบร้อยแล้วค่ะ");
				window.location.href	=	'/mybackoffice/home_slide';
			});
		}
	}
	function edit_pic(promotion_id)
	{
		window.location.href	=	'/mybackoffice/home_slide/update_form/'+promotion_id;
	}
</script>