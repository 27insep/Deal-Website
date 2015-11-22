<br/>
<div class="menu_add_box">
		<a href="/mybackoffice/deal_slide/<?=$deal_id?>/insert_form">เพิ่มรูปภาพ</a>
</div>
<div>
	<span class="header_title">คลังรูปภาพสไลด์ของดีล : <?=$deal_name?></span>
</div>
<br/>
<div>
	<? 
	if(sizeof($deal_slide)<1)
	{
		?>
		<center><h3>ยังไม่มีข้อมูลรูปภาพค่ะ หากต้องการเพิ่มรูปภาพ <a href="/mybackoffice/deal_slide/<?=$deal_id?>/insert_form">คลิ๊กที่นี้</a> ค่ะ</h3></center>
		<?
	}else{
		foreach($deal_slide as $item){
	?>
		<div class="gallery_photo">
			<div class="delete_picturn" onclick="remove_pic('<?=$item["pic_id"]?>','<?=$item["pic_path"]?>')">
				<?=image_asset('/icon/delete.png', '', array('alt'=>'ลบข้อมูล','title'=>'ลบรูปภาพ'));?>
			</div>
			<img src="/assets/images/<?=$item["pic_path"]?>" width="150" height="80" />
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
  				 url: "/mybackoffice/deal_slide/<?=$deal_id?>/delete",
  				 data: { pic_id: id, pic_path:path }
			}).done(function( msg ) {
				alert("ทำการลบรูปภาพเรียบร้อยแล้วค่ะ");
				window.location.href	=	'/mybackoffice/deal_slide/<?=$deal_id?>';
			});
		}
	}
</script>