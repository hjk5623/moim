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
 <title>보내짐</title>
  </head>
  <body>
   <div id="head">
     <h1>Message Send</h1>
   </div>
   <hr>

   <form action="./msg_query.php?mode=send" method="Post">
     <div>
       <div>
         <?php
       if($_SESSION['userid']=="admin" || $_SESSION['userid']=="notice_id"){
         echo "<b>상대방 아이디</b> : <input type='text' size='12px;' value='$send_id' name='receive_id' readonly>";
       }else{
          echo "<b>상대방 아이디</b> : <input type='text' size='12px;' value='admin' name='receive_id' readonly>";
       }
        ?>

       </div>
        <b>보내는 메세지</b> <br> <textarea name="msg_content" rows="10" cols="57"></textarea>
    </div>
   <br>
     <div>
       <button type="text" style="border: 0px; width: 150px; padding: 0px; height: 30px;">보내기</button>
     </div>
   </form>

  </body>
 </html>
