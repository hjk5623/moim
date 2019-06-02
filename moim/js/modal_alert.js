function modal_alert(msg1,msg2,msg3){
  var modal = document.getElementById('myModal');

  $("#modal-content").html("<i class='fas fa-exclamation-circle 9x'></i>");
  $("#modal-content").append("<h2>"+msg1+"</h2>");
  $("#modal-content").append("<h3>"+msg2+"</h3>");
  $("#modal-content").append("<div class='button-8' id='button-3' onclick='alert_confirm(\""+msg3+"\")'>");
  $("#button-3").append("<div class='eff-8'></div>");
  $("#button-3").append("<a href='#'><span>확인</span></a>");
  $("#modal-content").append("</div>");

  modal.style.display="block";
}

function modal_alert_cancle(msg1,msg2,msg3,msg4,msg5,msg6,msg7){
  var modal = document.getElementById('myModal');
  modal.style.display="block";

  $("#modal-content").html("<i class='fas fa-exclamation-circle 9x'></i>");
  $("#modal-content").append("<h2>"+msg1+"</h2>");
  $("#modal-content").append("<h3>"+msg2+"</h3>");
  $("#modal-content").append("<div class='button-8' id='button-3' onclick='alert_confirm(\""+msg3+"\",\""+msg4+"\",\""+msg5+"\",\""+msg6+"\",\""+msg7+"\")'>");
  $("#button-3").append("<div class='eff-8'></div>");
  $("#button-3").append("<a href='#'><span>확인</span></a>");
  $("#modal-content").append("</div>");
  $("#modal-content").append("<div class='button-8' id='button-4' onclick='alert_cancle()'>");
  $("#button-4").append("<div class='eff-8'></div>");
  $("#button-4").append("<a href='#'><span>취소</span></a>");
  $("#modal-content").append("</div>");
}

  function alert_confirm(msg3,msg4,msg5,msg6,msg7){
    var modal = document.getElementById('myModal');
    modal.style.display = "none";
    if(msg3=="history"){
      history.go(-1);
    }else if(msg3=="ajax"){
      check_delete(msg4,msg5);
    }else if(msg3=="open"){
      club_accept(msg4,msg5,msg6,msg7);
    }else if(msg3=="delete"){
      check_delete(msg4,msg5);
    }else if(msg3=="cancle"){
      user_club_refund(msg4);
    }else if(msg3=="choice"){
      check_choice();
    }else if(msg3=="ajax_request"){
      request_disapprove(msg4);
    }else if(msg3=="ajax_refund"){
      refund_submit(msg4,msg5);
    }else if(msg3!="undefined"){
      window.location.href=msg3;
    }

  }

  function alert_cancle(){
    var modal = document.getElementById('myModal');
    modal.style.display = "none";
  }
