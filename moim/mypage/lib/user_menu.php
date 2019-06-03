<?php
if(!isset($_SESSION)){
  session_start();
}

 ?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="../css/user_menu.css">
    <link rel="stylesheet" href="../../css/message_modal.css">
    <script type="text/javascript" src="../../js/message.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <link rel="stylesheet" href="../../css/modal_alert.css">
    <script type="text/javascript" src="../../js/modal_alert.js"></script>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css" integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">
    <script type="text/javascript">
    function message_form(){
     var popupX = (window.screen.width/2)-(600/2);
     var popupY = (window.screen.height/2)-(600/2);
     window.open('../../message/source/msg.php','','left='+popupX+',top='+popupY+', width=550, height=600, status=no, scrollbars=no');
   }
   window.onclick = function(event) {
     var modal = document.getElementById('myModal');
       if (event.target == modal) {
           modal.style.display = "none";
       }
   };
   </script>
    <title></title>
  </head>
  <body>
    <div id="myModal" class="modal">
      <div class="modal-content" id="modal-content">

       </div>
     </div>
    <form name="msg_form" action="../../message/source/msg_query.php?mode=send" method="post">
      <div class="modal_message">
        <div class="content_modal">
          <h1>Send Message</h1>
          <!-- <input type="text" name="" value="" placeholder="관리자"><br> -->
          <?php
            if($_SESSION['userid']=="admin" || $_SESSION['userid']=="notice_id"){
              echo "<input type='text' value='$send_id' name='receive_id' readonly>";
            }else{
               echo "<input type='text' value='admin' name='receive_id' readonly>";
            }
          ?>
          <textarea name="msg_content" id="msg_content" rows="8" cols="40" placeholder="메세지를 적어주세요."></textarea>
          <!-- <a href="#">SEND</a> -->
          <button type="button" name="button" onclick="send_message()">SEND</button>
        </div>
        <div class="hide fas fa-times" onclick="hide_modal()"></div>
        <div class="fas fa-envelope-open message_form" id="message_form" onclick="message_form()"></div>
      </div>
    </form>
    <nav>
      <div class="brand">
        <a href="../../mainpage.php"><h2>Mo,im</h2></a>
      </div>
      <div class="menubar">
        <ul>
          <li><a href="./user_check.php">정보수정</a></li>
          <li><a href="./user_request.php">모임만들기</a>
            <ul>
              <li><a href="./user_request.php">모임신청</a></li>
              <li><a href="./user_apply_list.php">신청내역</a></li>
            </ul>
          </li>
          <li><a href="./user_apply.php">모임</a>
            <ul>
              <li><a href="./user_apply.php">모집중모임</a></li>
              <li><a href="./user_open.php">진행중모임</a></li>
            </ul>
          </li>
          <li><a href="./user_cart.php">위시리스트</a></li>
          <li><a href="./user_refund.php">환불내역</a></li>
          <li><a href="#" onclick="open_modal();">문의</a></li>
          <?php
            if(isset($_SESSION["userid"])){
            ?>
            <li><a href="../../login/source/logout.php">로그아웃</a></li>
          <?php
            }else{
            ?>
            <li><a href="../../login/source/login.php">로그인</a></li>
          <?php
            }
           ?>

      </div>
    </nav>
    <slider>
      <slide><p>MY PAGE</p></slide>
      <slide><p>MY PAGE</p></slide>
      <slide><p class="mypage3">MY PAGE</p></slide>
      <slide><p>MY PAGE</p></slide>
    </slider>
    <div id="container">
      <div id="subwrap">
        <div class="nav">
          <div class="detail_tabs">
            <div class="tabs_nav">
            </div><!--end of tabs_nav -->
          </div> <!--end of detail_tabs -->
        </div><!--end of nav  -->
      </div><!--end of subwrap  -->
    </div> <!--end of container  -->
  </body>
</html>
