<?php session_start(); ?>
<!DOCTYPE html>
<html lang="ko" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
    <link rel="stylesheet" type="text/css" href="../css/member.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="http://dmaps.daum.net/map_js_init/postcode.v2.js"></script>
    <script type="text/javascript" src="./member_form.js"></script>
  </head>
  <body>
    <?php
      $kakao_id="";
      $google_id="";
      if(isset($_POST["kakao_id"])){
        $kakao_id = $_POST["kakao_id"];
      }
      if(isset($_POST["google_id"])){
        $google_id = $_POST["google_id"];
      }
     ?>
     <div class="inputdiv">
       <form name="member_form" action="member_query.php?mode=insert" method="post" class="signup_form">
         <!-- <input type="hidden" id="flag_checkbox" value="false"> -->
         <input type="hidden" id="flag_id" value="false">
         <input type="hidden" id="flag_name" value="false">
         <input type="hidden" id="flag_passwd" value="false">
         <input type="hidden" id="flag_passwd_check" value="false">
         <input type="hidden" id="flag_phone1" value="false">
         <input type="hidden" id="flag_phone2" value="false">
         <input type="hidden" id="flag_phone3" value="false">
         <input type="hidden" id="flag_address" value="false">
         <input type="hidden" id="flag_email" value="false">
         <input type="hidden" name="kakao_id" value="<?=$kakao_id?>">
         <h1>SIGN UP</h1>

         <div class="inputbox">
           <input type="text" name="id" id="id" class="input1" autocomplete="off" required=""><label>USERID</label>
           <br>
           <span id="span_id"></span><br><br>
         </div>

         <div class="inputbox">
           <input type="text" name="name" id="name" class="input1" autocomplete="off" required=""><label>USERNAME</label>
           <br>
           <span id="span_name"></span><br><br>
         </div>

         <div class="inputbox">
           <input type="password" name="passwd" id="passwd" class="input1" required=""><label>PASSWORD</label>
           <br>
           <span id="span_passwd"></span><br><br>
         </div>

         <div class="inputbox">
           <input type="password" name="passwd_check" id="passwd_check" class="input1" required=""><label>CHECK PASSWORD</label>
           <br>
           <span id="span_passwd_check"></span><br><br>
         </div>

         <div class="inputbox2">
           <select name="phone1" id="phone1"> <option value="010">010</option> </select>
           <input type="number" name="phone2" id="phone2" class="input_phone">
           <input type="number" name="phone3" id="phone3" class="input_phone"><br>
           <span id="span_phone"></span><br>
         </div>

         <div class="inputbox3">
           <input type="text" name="address1" id="address1" class="input1" readonly onclick="execDaumPostcode()" placeholder="ADDRESS" >
           <input type="text" name="address2" id="address2" placeholder="우편번호" class="address2" readonly>
           <input type="text" name="address3" id="address3" class="address3" autocomplete="off"><br>
           <span id="span_address"></span><br>
         </div>

         <div class="inputbox4">
           <input type="text" name="email1" id="email1" class="email1" placeholder="EMAIL"> @
           <select class="" name="email2" id="email2" class="email2">
             <option value="이메일을 선택하세요">이메일을 선택하세요</option>
             <option value="naver.com">naver.com</option>
             <option value="gmail.com">gmail.com</option>
             <option value="daum.net">daum.net</option>
           </select>
           <input type="button" name="button1" id="button1" value="인증번호받기" class="button1"><br>
           <span id="email_success"></span>
           <input type="hidden" name="code" id="code_text" class="code">
           <input type="hidden" value="인증하기" id="code_button">
           <span id="set_time"></span>
           <span id="span_email"></span>
         </div>
         <div class="inputbox5">
           <input type="button" name="button2" id="button2" value="가입하기">
         </div>
       </form>
     </div>
  </body>
</html>
