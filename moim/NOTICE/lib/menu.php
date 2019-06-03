<?php
if(!isset($_SESSION)){
session_start();

}
 ?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="../css/top_menu.css">
    <link rel="stylesheet" href="../../css/modal_alert.css">
    <script type="text/javascript" src="../../js/modal_alert.js"></script>
    <script type="text/javascript" src="../../js/message.js"></script>
    <link rel="stylesheet" href="../../css/message_modal.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css" integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
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
        <a href="../../mainpage.php">
        <h2>Mo,im</h2>
        </a>
      </div>
      <div class="menubar">
        <ul>

          <li><a href="../../faq/source/faq_list.php">FAQ</a></li>
          <li><a href="../../qna/source/qna_list.php">QNA</a></li>
          <li><a href="../../notice/source/notice_list.php">NOTICE</a>
            <?php
              if($_SESSION['userid']=="admin"){
                echo ('<li><a href="#" onclick="message_form();">MESSAGE</a></li>');
              }else{
                echo ('<li><a href="#" onclick="open_modal();">MESSAGE</a></li>');
              }
             ?>
            <?php
              if(!isset($_SESSION['userid'])){
                echo ('<li><a href="../../login/source/login.php">LOG IN</a></li>');
              }else{
                echo ('<li><a href="../../login/source/logout.php">LOG OUT</a></li>');
              }
             ?>
        </ul>

      </div>
    </nav>
    <slider>
      <slide><p>BOARD PAGE</p></slide>
      <slide><p>FAQ</p></slide>
      <slide><p>QNA</p></slide>
      <slide><p>NOTICE</p></slide>
    </slider>
  </body>
</html>
