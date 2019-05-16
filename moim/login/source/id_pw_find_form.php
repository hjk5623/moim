<!DOCTYPE html>
<html lang="ko" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
    <link rel="stylesheet" href="../css/login.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css">
    <script type="text/javascript" src="./login.js"></script>
  </head>
  <body>
    <?php
      if(isset($_GET["mode"])&& $_GET["mode"]=="find_id"){
    ?>
        <div class="login-box">
          <div class="login-form">
            <h1><b>ID</b>/PASSWORD</h1>
           <input class="txtb" type="text" name="name" id="name" placeholder="Username">
           <input class="txtb" type="tel" name="phone" id="phone" placeholder="010-1111-1111">
           <input class="login-btn" id="find_btn_id" type="button" name="" value="Find">
           <span id="find_span">
           </span>
           <hr>
           <ul class="find-ul">
             <li><a href="./login.php">로그인</a></li>
             <li><a href="./id_pw_find_form.php?mode=find_passwd">비밀번호찾기</a></li>
           </ul>
         </div>
       </div>
      <?php
        }else{
      ?>
        <div class="login-box">
          <div class="login-form">
            <h1>ID/<b>PASSWORD</b></h1>
           <input class="txtb" type="text" name="id" id="id" placeholder="UserID">
           <input class="txtb" type="email" name="email" id="email" placeholder="asd123@naver.com">
           <input class="login-btn" id="find_btn_passwd" type="button" name="" value="Find">
           <span id="find_span">
           </span>
           <hr>
           <ul class="find-ul">
             <li><a href="./login.php">로그인</a></li>
             <li><a href="./id_pw_find_form.php?mode=find_id">아이디찾기</a></li>
           </ul>
         </div>
       </div>
      <?php
        }
       ?>
  </body>
</html>
