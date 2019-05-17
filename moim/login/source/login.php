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
    <div class="login-box">
      <div class="login-form">
        <h1>LOG IN</h1>
        <input class="txtb" type="text" name="id" id="id" placeholder="Username">
        <input class="txtb" type="password" name="passwd" id="passwd" placeholder="Password">
        <input class="login-btn" id="login_btn" type="button" name="" value="Login">
        <input class="kakao-btn" type="button" name="" value="Kakao">
        <input class="google-btn" type="button" name="" value="Google">
        <span id="login-span"></span>
        <hr>
        <ul class="login-ul">
          <li><a href="./id_pw_find_form.php?mode=find_id">아이디찾기</a></li>
          <li><a href="./id_pw_find_form.php?mode=find_passwd">비밀번호찾기</a></li>
          <li><a href="../../member/source/member_form.php">회원가입</a></li>
        </ul>
      </div>
    </div>
  </body>
</html>
