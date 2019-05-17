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
      if(isset($_POST["kakao_id"])){
        $kakao_id = $_POST["kakao_id"];
      }
     ?>
    <form name="member_form" action="member_query.php?mode=insert" method="post">
      <input type="hidden" id="flag_checkbox" value="false">
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
      <h1 align="center">회원가입</h1>
      <table class="table1" align="center">
        <tr>
          <td>이용약관</td>
        </tr>
        <tr>
          <td>
            <textarea name="name" rows="8" cols="100">
제 1조(목적)
이 약관은 ‘열정에기름붓기’(이하 “회사”)가 제공하는 ‘크리에이터 클럽’(이하 “서비스”)과 관련하여, 회사와 이용고객 간에 서비스 이용조건 및 절차, 회사와 회원 간의 권리, 의무 및 기타 필요 사항을 규정함을 목적으로 합니다.

제 2조(용어의 정리)
1) 사이트회사가 운영하는 www.passionoil.kr을 말합니다.
2) 고객사이트에 접속하는 모든 이용자를 말합니다. 
3) 회원회사에서 제공하는 유료 서비스를 받는 모든 이용자를 말합니다.
4) 게시물고객이 서비스를 이용함에 있어 서비스 상에 게시한 부호ㆍ문자ㆍ음성ㆍ음향ㆍ화상ㆍ동영상 등의 정보 형태의 글, 사진, 동영상 및 각종 파일과 링크 등을 의미합니다.
5) 시즌회원이 유료 서비스를 받는 기간을 의미합니다.
            </textarea>
          </td>
        </tr>
        <tr id="tr1">
          <td><input type="checkbox" name="check1" id="label1" onclick="checkbox()"><label for="label1"><span id="span1" >이용약관에 동의합니다.<br>동의가 필요합니다.</span></label> </td>
        </tr>
      </table>
      <br><br>
      <table align="center" class="table1">
        <tr class="tr1">
          <td colspan="2">정보입력<br><br></td>
        </tr>
        <tr>
          <td class="td1">
            아이디&nbsp;&nbsp;&nbsp;
          </td>
          <td>
            <input type="text" name="id" id="id" class="input1" autocomplete="off"><br>
          </td>
        </tr>
        <tr class="tr_id">
          <td></td>
          <td><span id="span_id"></span></td>
        </tr>
        <tr>
          <td class="td1">
            이름&nbsp;&nbsp;&nbsp;
          </td>
          <td><input type="text" name="name" id="name" class="input1" autocomplete="off"></td>
        </tr>
        <tr class="tr_name">
          <td></td>
          <td><span id="span_name"></span></td>
        </tr>
        <tr>
          <td class="td1">
            패스워드&nbsp;&nbsp;&nbsp;
          </td>
          <td><input type="password" name="passwd" id="passwd" class="input1"></td>
        </tr>
        <tr class="tr_passwd">
          <td></td>
          <td><span id="span_passwd"></span></td>
        </tr>
        <tr>
          <td class="td1">
            패스워드확인&nbsp;&nbsp;&nbsp;
          </td>
          <td><input type="password" name="passwd_check" id="passwd_check" class="input1"></td>
        </tr>
        <tr class="tr_passwd_check">
          <td></td>
          <td><span id="span_passwd_check"></span></td>
        </tr>
        <tr>
          <td class="td1">
            전화번호&nbsp;&nbsp;&nbsp;
          </td>
          <td> <select name="phone1" id="phone1"> <option value="010">010</option> </select>
            <input type="number" name="phone2" id="phone2" class="input_phone">
            <input type="number" name="phone3" id="phone3" class="input_phone">
          </td>
        </tr>
        <tr class="tr_phone">
          <td></td>
          <td><span id="span_phone"></span></td>
        </tr>
        <tr>
          <td class="td1">
            주소&nbsp;&nbsp;&nbsp;
          </td>
          <td><input type="text" name="address1" id="address1" class="input1" readonly onclick="execDaumPostcode()"></td>
        </tr>
        <tr>
          <td class="td1">
            나머지주소&nbsp;&nbsp;&nbsp;
          </td>
          <td>
            <input type="text" name="address2" id="address2" placeholder="우편번호" class="address2" readonly>
            <input type="text" name="address3" id="address3" class="address3" autocomplete="off">
          </td>
        </tr>
        <tr class="tr_address">
          <td></td>
          <td><span id="span_address"></span></td>
        </tr>
        <tr>
          <td class="td1">
            이메일&nbsp;&nbsp;&nbsp;
          </td>
          <td>
            <input type="text" name="email1" id="email1" class="email1"> @
            <select class="" name="email2" id="email2" class="email2" style="width:142px; height:23px">
              <option value="이메일을 선택하세요">이메일을 선택하세요</option>
              <option value="naver.com">naver.com</option>
              <option value="gmail.com">gmail.com</option>
              <option value="daum.net">daum.net</option>
            </select>
          </td>
        </tr>
        <tr>
          <td></td>
           <td>
             <span id="email_success"></span>
             <input type="hidden" name="code" id="code_text" class="code">
             <input type="hidden" value="인증하기" id="code_button">
             <span id="set_time"></span>
           </td>
       </tr>
        <tr class="tr_email">
          <td></td>
          <td><span id="span_email"></span></td>
        </tr>
        <tr>
          <td></td>
          <td><input type="button" name="button1" id="button1" value="인증번호받기" class="button1"></td>
        </tr>
        <tr align="center">
          <td colspan="2"><input type="button" name="button2" id="button2" value="가입하기"> </td>
        </tr>
      </table>
    </form>
    <br><br><br><br>
  </body>
</html>
