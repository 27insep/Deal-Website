ลำดับ,เลขที่คูปอง,บาร์โค๊ด,รหัสลูกค้า,ชื่อ-นามสกุล,วันที่ใช้,สถานะการใช้<? echo "\n"?>
<? $i=0;foreach($coupon_data as $data){?>
<?=++$i?>,<?=$data["voucher_number"]?>,'<?=$data["barcode"]?>,<?=$data["member_id"]?>,<?=$data["member_name"]." ".$data["member_sname"]?>,<?=$data["coupon_use_date"]!=""?date("d/m/Y",strtotime($data["coupon_use_date"])):"";?>,<? if($data["coupon_status"]==2){?>USED<?}else{?>NOT USED<?}?><? echo "\n"?>
<? } ?>