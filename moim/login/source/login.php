<!DOCTYPE html>
<html lang="ko" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
    <link rel="stylesheet" href="../css/login.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css">
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src="https://developers.kakao.com/sdk/js/kakao.min.js"> </script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://apis.google.com/js/platform.js?onload=init" async defer></script>
    <script type="text/javascript" src="./login.js"></script>
    <script type="text/javascript">
      Kakao.init('1a120857fe2f360c70c0e2e8d7850759');
      function loginWithKakao() {
        Kakao.Auth.loginForm({
         success: function(authObj) {
           Kakao.API.request({
            url: '/v1/user/me',
            success: function(res) {
               $("#id").val(JSON.stringify(res.kaccount_email));
               $("#kakao_id").val(JSON.stringify(res.id));
               console.log( JSON.stringify(res.id));
               console.log( JSON.stringify(res.kaccount_email));
               console.log(JSON.stringify(res.properties.nickname));
               console.log(JSON.stringify(res.properties.profile_image));
               kakao_check(res);
            },
            fail: function(error) {
              alert(JSON.stringify(error))
            }
          });
        },
        fail: function(err) {
        }

      });
    };
    </script>
    <script>
    window.gauth ="";
    function init(){
      console.log('init');
      gapi.load('auth2', function() {
        console.log('auth2');
        //window로 사용하면서 전역변수로 선언
        window.gauth = gapi.auth2.init({
          client_id:'554036038504-upk1ho1ilonl6h431ltemj31ah7ikbb7.apps.googleusercontent.com'
        });
        gauth.then(function(){
          console.log('googleAuth success');
        }, function(){
          console.log('googleAuth fail');
        });
      });
    }
    function google_login(){
      gauth.signIn().then(function(){
        console.log('gauth.signIn()');
        getprofile();
      });
    }
    function getprofile(){
      if(gauth.isSignedIn.get()){
        profile = gauth.currentUser.get().getBasicProfile(); //프로필 정보를 가져온다.
        console.log('ID: ' + profile.getId());
        console.log('Full Name: ' + profile.getName());
        console.log('Given Name: ' + profile.getGivenName());
        console.log('Family Name: ' + profile.getFamilyName());
        console.log('Image URL: ' + profile.getImageUrl());
        console.log('Email: ' + profile.getEmail());
        $("#google_id").val(profile.getId());
        google_check(profile);
        gauth.disconnect();
      }
    }
    </script><!-- end of init -->
  </head>
  <body>
    <div class="login-box">
      <div class="login-form">
        <h1>LOG IN</h1>
        <form name="login_form" action="../../member/source/member_form.php" method="post">
          <input type="hidden" name="kakao_id" id="kakao_id" value="">
          <input type="hidden" name="google_id" id="google_id" value="">
          <input class="txtb" type="text" name="id" id="id" placeholder="UserID">
          <input class="txtb" type="password" name="passwd" id="passwd" placeholder="Password">
          <input class="login-btn" id="login_btn" type="button" name="" value="Login">
          <input class="kakao-btn" type="button" onclick="loginWithKakao()" value="Kakao">
          <input class="google-btn" type="button" onclick="google_login()" value="Google">
        </form>
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
