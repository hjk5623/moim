function buy_page(){
  var id = document.getElementById('userid').value;
  var club_num = document.getElementById('club_num').value;
  var buy_id = document.getElementById('buy_id').value;
  var buy_club_num = document.getElementById('buy_club_num').value;
  var club_to = document.getElementById('club_to').value;
  var club_apply = document.getElementById('club_apply').value;
  var club_name = document.getElementById('club_name').value;
  var club_price = document.getElementById('club_price').value;


  if (id=="") {  // 비 로그인 시
    modal_alert("알림","로그인이 필요합니다.");
  }else if((buy_club_num==club_num)&&(id==buy_id)){  //중복 결제할 경우
    modal_alert("알림","결제된 모임입니다. <br> 다시 확인하여 주십시오.");
  }else if(club_to<=club_apply){ //신청인원이 다 찼을 경우
    modal_alert("알림","마감되었습니다");
  }else{
    modal_alert_cancle("알림","결제하시겠습니까?","./payment.php?club_num="+club_num+"&club_name="+club_name+"&club_price="+club_price+"&id="+id);
 }
}

function cart_page(){
  var id = document.getElementById('userid').value;
  var club_num = document.getElementById('club_num').value;
  var cart_club_num = document.getElementById('cart_club_num').value;
  var cart_id = document.getElementById('cart_id').value;

  if ((cart_id==id)&&(cart_club_num==club_num)) {   //중복으로 카트담기 할 경우
    modal_alert("알림","이미 등록하셨습니다.");
  }else if(!id){   //비 로그인 시
    modal_alert("알림","로그인이 필요합니다.");
  }else{
    modal_alert("알림","찜 등록되었습니다.","./query.php?mode=cart&id="+id+"&club_num="+club_num);
  }
}
function del_check(){   //모임을 삭제 하는 경우
  modal_alert_cancle("알림","삭제하시겠습니까?","./query.php?mode=delete&club_num="+club_num);
}
