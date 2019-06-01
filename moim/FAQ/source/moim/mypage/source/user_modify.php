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
    <link rel="stylesheet" href="../../css/modal_alert.css">
    <script type="text/javascript" src="../../js/modal_alert.js"></script>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css" integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">

  </head>
  <body>
    <div id="myModal" class="modal">
      <div class="modal-content" id="modal-content">

       </div>
     </div>
    <?php
    include $_SERVER['DOCUMENT_ROOT']."/moim/mypage/lib/user_menu.php";
    ?>
    <?php
      if(isset($_SESSION['userid'])){
        $userid = $_SESSION['userid'];
      }else{
        $userid = "";
      }
      $sql="SELECT * FROM `membership` where `id`='$userid';";

      $result = mysqli_query($conn, $sql) or die(mysqli_error($conn));

      $row = mysqli_fetch_array($result);

      $phone = $row['phone'];

      $phone = explode("-", $phone);

      $address = $row['address'];

      $address = explode("/", $address);

      $email = $row['email'];

      $email = explode("@", $email);
     ?>
     <div class="inputdiv">
       <h1 class="h1_modify">정보수정</h1>
       <form name="member_form" action="user_query.php?mode=modify" method="post" class="signup_form">
         <input type="hidden" id="flag_name" value="true">
         <input type="hidden" id="flag_passwd" value="true">
         <input type="hidden" id="flag_passwd_check" value="true">
         <input type="hidden" id="flag_phone1" value="true">
         <input type="hidden" id="flag_phone2" value="true">
         <input type="hidden" id="flag_phone3" value="true">
         <input type="hidden" id="flag_address" value="true">
         <input type="hidden" id="flag_email" value="true">
         <div class="inputbox">
           <h3>아이디</h3>
           <input type="text" name="id" id="id" readOnly class="input1" autocomplete="off" required="" value=<?=$row['id']?>>
           <br><br><br>
           <hr>
         </div>

         <div class="inputbox">
           <h3>이름</h3>
           <input type="text" name="name" id="name" class="input1" autocomplete="off" required="" value=<?=$row['name']?>>
           <br>
           <span id="span_name"></span><br><br>
           <hr>
         </div>

         <div class="inputbox">
           <h3>비밀번호</h3>
           <input type="password" name="passwd" id="passwd" class="input1" required="" value=<?=$row['passwd']?>>
           <br>
           <span id="span_passwd"></span><br><br>
           <hr>
         </div>

         <div class="inputbox">
           <h3>비밀번호 확인</h3>
           <input type="password" name="passwd_check" id="passwd_check" class="input1" required="" value=<?=$row['passwd']?>>
           <br>
           <span id="span_passwd_check"></span><br><br>
           <hr>
         </div>

         <div class="inputbox2">
           <h3>휴대폰 번호</h3>
           <!-- <select name="phone1" id="phone1"> <option value="010">010</option> </select> -->
           <input type="number" name="phone1" id="phone1" class="input_phone" value="<?=$phone[0]?>" readonly>
           <input type="number" name="phone2" id="phone2" class="input_phone" value="<?=$phone[1]?>">
           <input type="number" name="phone3" id="phone3" class="input_phone" value="<?=$phone[2]?>"><br>
           <span id="span_phone"></span><br>
           <hr>
         </div>

         <div class="inputbox3">
           <h3>주소</h3>
           <input type="text" name="address1" id="address1" class="input1" readonly onclick="execDaumPostcode()" placeholder="address" value="<?=$address[1]?>">
           <input type="text" name="address2" id="address2" placeholder="우편번호" class="address2" readonly value="<?=$address[0]?>">
           <input type="text" name="address3" id="address3" class="address3" autocomplete="off" value="<?=$address[2]?>"><br>
           <span id="span_address"></span><br>
           <hr>
         </div>

         <div class="inputbox4">
           <h3>이메일</h3>
           <input type="text" name="email1" id="email1" class="email1" placeholder="EMAIL" value="<?=$email[0]?>" readonly> @
           <select class="" name="email2" id="email2" class="email2" disabled="true">
             <option value="<?=$email[1]?>"><?=$email[1]?></option>
             <option value="naver.com">naver.com</option>
             <option value="gmail.com">gmail.com</option>
             <option value="daum.net">daum.net</option>
           </select><br><br>
           <input type="button" name="button0" id="button0" value="이메일수정" class="button1">
           <input type="hidden" name="button1" id="button1" value="인증번호받기" class="button1"><br>
           <span id="email_success"></span>
           <input type="hidden" name="code" id="code_text" class="code">
           <input type="hidden" value="인증하기" id="code_button">
           <span id="set_time"></span>
           <span id="span_email"></span>
           <hr>
         </div>
         <div class="inputbox5">
           <input type="button" name="button2" id="button2" value="수정하기">
         </div>
       </form>
     </div>
  </body>
</html>
