<div id="how2pay_box">
	<div id="how2pay_account">
		<div>Bank Name: ธนาคารกสิกรไทย</div>
		<div>Account Name: THE BEST DEAL CO., LTD.
        <br />หมายเลขบัญชี:  730-1-01493-1
        <br />Company Code : 33316
        <br />Service Code : BESTDEAL
		</div>	
		<div>Sort code: </div>
	</div>
	<? if(!isset($not_show_detail)){?>
	<div>รายละเอียด:</div>
	<div id="how2pay_logo">
		<?echo image_asset('bank_logo/kbank_logo.jpg');?>
	</div>
	<div class="clear">
		<br/>
		<div>เนื่องจากบริษัท เดอะ เบสท์ ดีล จำกัด ได้ปรับปรุงระบบการชำระเงินผ่าน ธนาคารกสิกรไทยโดยสามารถเลือกชำระผ่าน 4 ช่องทางดังต่อไปนี้</div>
		<br/>
		<div>
		<ul>
  			<li>ATM   **  ดูรายละเอียดเพิ่มเติม <a target="_blank" href="/assets/media/bank_payment/k_bank_atm.pdf">คลิกที่นี่</a></li>
  			<li>ชำระผ่านเคาน์เตอร์ธนาคาร (ตัวอย่างใบ Pay-in กรุณา <a id="show_payment_bank_form" class="fancybox fancybox.ajax" href="/shopping/show_payin">คลิกที่นี่</a>)</li>
  			<li>อินเทอร์เน็ต</li>
  			<li>ทางโทรศัพท์ (K-Contact Center)   **  ดูรายละเอียดเพิ่มเติม <a target="_blank" href="/assets/media/bank_payment/k_phone.pdf">คลิกที่นี่</a></li>
		</ul>
		</div>
		<br/>
		<div>เงื่อนไข :</div>
		<br/>
		<div>กรุณาชำระเงินภายใน 24 ชั่วโมงนับหลังทำการสั่งซื้อ หากไม่ชำระเงินภายในเวลาที่กำหนดระบบจะยกเลิกคำสั่งซื้อของท่านโดยอัตโนมัติบริษัทฯขอสงวนสิทธิในการรับชำระ และออกคูปอง</div>
		<br/>
		<div>ลูกค้าจะได้รับคูปองภายใน 1-2 วันทำการหลังจากที่บริษัทฯได้ตรวจสอบเรียบร้อยแล้ว</div>
		<br/>
		<div>ค่าบริการ 10-30 บาทต่อ 1 รายการ ขึ้นอยู่กับธนาคาร หรือสาขาต่างจังหวัด</div>
 		<br/>
 		<div>* ทั้งนี้เพื่อความสะดวกของลูกค้า จึงไม่จำเป็นต้องแฟกซ์ใบโอนเงินมาให้กับทางบริษัท</div>
	</div>
	<? }?>
</div>