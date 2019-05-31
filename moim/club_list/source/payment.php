<?php
session_start();
include $_SERVER['DOCUMENT_ROOT']."/moim/lib/db_connector.php";
include $_SERVER['DOCUMENT_ROOT']."/moim/lib/create_table.php"; //club_DB 생성

create_table($conn, 'buy');
$mode="";
if(isset($_GET['id'])){
  $userid=$_GET['id'];
}else{
  $userid="";
}
if(isset($_GET['club_num'])){
  $club_num=$_GET['club_num'];
}else{
  $club_num="";
}
if(isset($_GET['club_name'])){
  $club_name=$_GET['club_name'];
}else{
  $club_name="";
}
if(isset($_GET['club_price'])){
  $club_price=$_GET['club_price'];
}else{
  $club_price="";
}

 ?>
 <html>
 <head>
 <script type="text/javascript" src="https://service.iamport.kr/js/iamport.payment-1.1.5.js"></script>
 <!-- <script type="text/javascript" src="https://cdn.iamport.kr/js/iamport.payment-x.y.z.js"></script> -->
 	<script  src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
 <script type="text/javascript">
 function payment(){
 	var IMP = window.IMP; // 생략가능
 	IMP.init('imp47585895'); //가맹점 식별 코드

   //아래 입력된 정보는 테스트를 위한것.
   //원래는 주문자 정보를 가져와서 넣어야함.
 	IMP.request_pay({
 	    pg : 'kakaopay', //결제방식
 	    pay_method : 'card', //결제 수단
 	    merchant_uid : 'merchant_' + new Date().getTime(),
 	    name : '<?=$club_name?>', //order 테이블에 들어갈 주문명 혹은 주문 번호
 	    amount : '<?=$club_price?>', //주문 금액
 	    buyer_name : '신청번호 :<?=$club_num?>_<?=$userid?>', //구매자 이름
 	    kakaoOpenApp : true
 	}, function(rsp) {
     //callback함수
 	    if ( rsp.success ) { //결제 성공시
 	    	//[1] 서버단에서 결제정보 조회를 위해 jQuery ajax로 imp_uid 전달하기
 	    	jQuery.ajax({
 	    		url: "/payments/complete", //cross-domain error가 발생하지 않도록 주의해주세요
 	    		type: 'POST',
 	    		dataType: 'json',
 	    		data: {
 		    		imp_uid : rsp.imp_uid
 		    		//기타 필요한 데이터가 있으면 추가 전달
 	    		}
 	    	}).done(function(data) {
 	    		//[2] 서버에서 REST API로 결제정보확인 및 서비스루틴이 정상적인 경우
 	    		if ( everythings_fine ) {
 	    			var msg = '결제가 완료되었습니다.';
 	    			msg += '\n고유ID : ' + rsp.imp_uid;
 	    			msg += '\n상점 거래ID : ' + rsp.merchant_uid;
 	    			msg += '\n결제 금액 : ' + rsp.paid_amount;
 	    			msg += '카드 승인번호 : ' + rsp.apply_num;

 	    			alert(msg);

            location.href="./query.php?mode=<?=$mode="pay"?>&id=<?=$userid?>&club_num=<?=$club_num?>";

 	    		} else {
 	    			//[3] 아직 제대로 결제가 되지 않았습니다.
 	    			//[4] 결제된 금액이 요청한 금액과 달라 결제를 자동취소처리하였습니다.
 	    		}

 	    	});
         alert('구매되었습니다.'); //결제 성공시 알림창 띄워준다
         location.href="./query.php?mode=<?=$mode="pay"?>&id=<?=$userid?>&club_num=<?=$club_num?>";

 	    }else{
         var msg = '결제에 실패하였습니다.';
         msg += '에러내용 : ' + rsp.error_msg;
         alert(msg);
         alert('결제가 실패되었습니다.');
    		  location.href="./view.php?club_num=<?=$club_num?>";
 	    }//end of else

 	});
 	}
   payment();

 </script>
 </head>
 </html>
