<!DOCTYPE html>
<html lang="ko" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="http://dmaps.daum.net/map_js_init/postcode.v2.js"></script>
    <script type="text/javascript" src="./member_form.js"></script>
    <link rel="stylesheet" href="../css/flagcheck.css">

    <link rel="stylesheet" href="../../css/modal_alert.css">
    <script type="text/javascript" src="../../js/modal_alert.js"></script>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css" integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">
  </head>
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
  <body>
    <div id="myModal" class="modal">
      <div class="modal-content" id="modal-content">

       </div>
     </div>
    <form name="flagcheck_form" action="./member_form.php" method="post">
      <input type="hidden" name="kakao_id" value="<?=$kakao_id?>">
      <input type="hidden" name="google_id" value="<?=$google_id?>">
    </form>
    <input type="hidden" id="flag_checkbox1" value="false">
    <input type="hidden" id="flag_checkbox2" value="false">
    <div class="inputdiv">
    <h1>MO,IM</h1>
    <table class="table1" align="center">
      <tr>
        <td>이용약관</td>
      </tr>
      <tr>
        <td>
          <textarea name="name" rows="8" cols="80" class="flag_texta">
제 1조(목적)
이 약관은 ‘WepApp6’(이하 “회사”)가 제공하는 ‘Mo,im’(이하 “서비스”)과 관련하여, 회사와 이용고객 간에 서비스 이용조건 및 절차, 회사와 회원 간의 권리, 의무 및 기타 필요 사항을 규정함을 목적으로 합니다.

제 2조(용어의 정리)
1) 사이트회사가 운영하는 www.moim.com을 말합니다.
2) 고객사이트에 접속하는 모든 이용자를 말합니다. 
3) 회원회사에서 제공하는 유료 서비스를 받는 모든 이용자를 말합니다.
4) 게시물고객이 서비스를 이용함에 있어 서비스 상에 게시한 부호ㆍ문자ㆍ음성ㆍ음향ㆍ화상ㆍ동영상 등의 정보 형태의 글, 사진, 동영상 및 각종 파일과 링크 등을 의미합니다.
5) 시즌회원이 유료 서비스를 받는 기간을 의미합니다.
          </textarea>
        </td>
      </tr>
      <tr id="tr1">
        <td><input type="checkbox" name="check1" id="check1"><label for="check1"><span id="span1">위 사항에 준수합니다.<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;약관에 동의하세요.</span></label> </td>
      </tr>
    </table>
    <table class="table1" align="center">
      <tr>
        <td>이용약관</td>
      </tr>
      <tr>
        <td>
          <textarea name="name" rows="8" cols="80" class="flag_texta">
제 1조(목적)
이 약관은 ‘WepApp6’(이하 “회사”)가 제공하는 ‘Mo,im’(이하 “서비스”)과 관련하여, 회사와 이용고객 간에 서비스 이용조건 및 절차, 회사와 회원 간의 권리, 의무 및 기타 필요 사항을 규정함을 목적으로 합니다.

제 2조(용어의 정리)
1) 사이트회사가 운영하는 www.moim.com을 말합니다.
2) 고객사이트에 접속하는 모든 이용자를 말합니다. 
3) 회원회사에서 제공하는 유료 서비스를 받는 모든 이용자를 말합니다.
4) 게시물고객이 서비스를 이용함에 있어 서비스 상에 게시한 부호ㆍ문자ㆍ음성ㆍ음향ㆍ화상ㆍ동영상 등의 정보 형태의 글, 사진, 동영상 및 각종 파일과 링크 등을 의미합니다.
5) 시즌회원이 유료 서비스를 받는 기간을 의미합니다.
          </textarea>
        </td>
      </tr>
      <tr id="tr1">
        <td><input type="checkbox" name="check2" id="check2" ><label for="check2"><span id="span2" >위 사항에 준수합니다.<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;약관에 동의하세요.</span></label> </td>
      </tr>
    </table>
    <table class="table1" align="center">
      <tr>
        <td>이용약관</td>
      </tr>
      <tr>
        <td>
          <textarea name="name" rows="8" cols="80" class="flag_texta">
제 1조(목적)
이 약관은 ‘WepApp6’(이하 “회사”)가 제공하는 ‘Mo,im’(이하 “서비스”)과 관련하여, 회사와 이용고객 간에 서비스 이용조건 및 절차, 회사와 회원 간의 권리, 의무 및 기타 필요 사항을 규정함을 목적으로 합니다.

제 2조(용어의 정리)
1) 사이트회사가 운영하는 www.moim.com을 말합니다.
2) 고객사이트에 접속하는 모든 이용자를 말합니다. 
3) 회원회사에서 제공하는 유료 서비스를 받는 모든 이용자를 말합니다.
4) 게시물고객이 서비스를 이용함에 있어 서비스 상에 게시한 부호ㆍ문자ㆍ음성ㆍ음향ㆍ화상ㆍ동영상 등의 정보 형태의 글, 사진, 동영상 및 각종 파일과 링크 등을 의미합니다.
5) 시즌회원이 유료 서비스를 받는 기간을 의미합니다.
          </textarea>
        </td>
      </tr>
      <tr id="tr1">
        <td><input type="checkbox" name="check3" id="check3"><label for="check3"><span id="span3">위 사항에 준수합니다.<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;약관에 동의하세요.</span></label> </td>
      </tr>
    </table>
  </div>
  </body>
</html>
