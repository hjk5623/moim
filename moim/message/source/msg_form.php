<?php
session_start();
$id = $_SESSION['userid'];
$name = $_SESSION['username'];
$send_id="";
if(isset($_GET["send_id"])){
  $send_id=$_GET["send_id"];
}
?>
 <!DOCTYPE html>
 <html>
 <head>
 <meta charset="UTF-8">
 <link rel="stylesheet" href="../css/msg.css">
 <title>보내짐</title>
  </head>
  <body>
    <div class="form_div">
     <form action="./msg_query.php?mode=send" method="Post">
       <div class="form_send_div">
         <div>
           <?php
         if($_SESSION['userid']=="admin" || $_SESSION['userid']=="notice_id"){
           echo $send_id."님 에게";
         }else{
            echo $send_id."님 에게";
         }
          ?>
         </div>
         <hr>
          <textarea name="msg_content" rows="9" cols="57"></textarea>
      </div>
      <hr>
       <div class="form_btn">
         <button type="text">보내기</button>
       </div>
     </form>
   </div>

  </body>
 </html>
