<?php
include $_SERVER['DOCUMENT_ROOT']."/moim/lib/session_call.php";
include $_SERVER['DOCUMENT_ROOT']."./moim/lib/db_connector.php";
?>
<!DOCTYPE html>
<html lang="ko" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
    <link rel="stylesheet" type="text/css" href="../css/user_modify.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="http://dmaps.daum.net/map_js_init/postcode.v2.js"></script>
    <script type="text/javascript" src="../js/user.js"></script>
  </head>
  <body>
    <?php
    include $_SERVER['DOCUMENT_ROOT']."/moim/mypage/lib/user_menu.php";
    ?>
    <?php
      if(isset($_SESSION['userid'])){
        $userid = $_SESSION['userid'];
      }else{
        $userid = "";
      }
      $sql="SELECT id FROM `membership` where `id`='$userid';";

      $result = mysqli_query($conn, $sql) or die(mysqli_error($conn));

      $row = mysqli_fetch_array($result);


     ?>
     <div class="inputdiv">
       <h1 class="h1_modify">정보수정</h1>
       <form name="member_form" action="user_query.php?mode=check" method="post" class="signup_form">
         <input type="hidden" id="flag_passwd" value="true">
         <div class="inputbox">
           <h3>아이디</h3>
           <input type="text" name="id" id="id" readOnly class="input1" autocomplete="off" required="" value=<?=$row['id']?>>
           <br><br>
           <hr>
         </div>
         <div class="inputbox">
           <h3>비밀번호</h3>
           <input type="password" name="passwd" id="passwd" class="input1" required="" value="">
           <br>
           <span id="span_passwd"></span><br>
           <hr>
         </div>
         <div class="inputbox5">
           <input type="button" name="button2" id="modify_btn" value="확인">
         </div>
         <br><br><br><br><br><br><br><br><br><br>
       </form>
     </div>
  </body>
</html>
