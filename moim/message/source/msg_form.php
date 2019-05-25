<?php
session_start();
$id = $_SESSION['userid'];
$name = $_SESSION['username'];
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

         <b>상대방 아이디</b> : <input type="text" size="12px;" name="receive_id">
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
