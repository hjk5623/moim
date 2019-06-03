function open_modal(){
  var modal = document.getElementsByClassName("modal_message")[0];
  modal.style.bottom = "20px";
}
function hide_modal(){
  var modal = document.getElementsByClassName("modal_message")[0];
  modal.style.bottom = "-400px";
}
function send_message(){
  if($("#msg_content").val()==""){
    modal_alert("알림","메세지를 입력하세요.");
    return;
  }
  modal_alert_cancle("알림","메세지를 보내시겠습니까?","send");
}
