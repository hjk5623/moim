$(document).ready(function() {
  //id 패턴검사 및 중복검사
  $("#id").focusout(function(event) {
    document.getElementById("flag_id").value="false";
    var id = document.getElementById("id");
    var span_id = document.getElementById("span_id");
    var idpattern = /^[a-zA-Z0-9]{6,8}$/;
    if (id.value.length === 0) {
      $("#span_id").css('color', 'red');
      span_id.innerHTML="아이디를 입력해주세요(영문,숫자 6~8자리)";
      id.value = "";
      return false;
    }else if (!(idpattern.test(id.value))) {
      $("#span_id").css('color', 'red');
      span_id.innerHTML="아이디를 입력해주세요.영문,숫자 6~8자리";
      id.value = "";
      return false;
    }
    $.ajax({
      url: 'member_query.php?mode=id_check',
      type: 'POST',
      data: {id: $("#id").val()}
    })
    .done(function(result) {
      console.log(result);
      var json_obj = $.parseJSON(result);
      span_id.innerHTML=json_obj[0].id;
       $("#idspan").text(json_obj[0].id);
      if(json_obj[1].row==1){
        $("#id").val("");
        $("#span_id").css('color', 'red');
      }else{
        $("#span_id").css('color', 'blue');
        document.getElementById("flag_id").value="true";
      }
    })
    .fail(function() {
      console.log("error");
    })
    .always(function() {
      console.log("complete");
    });
  });
  //이름 검사
  $("#name").focusout(function(event) {
    document.getElementById("flag_name").value="false";
    var name = document.getElementById("name");
    var span_name = document.getElementById("span_name");
    var namepattern = /^[가-힣\x20]{2,6}$/;
    if (name.value.length === 0) {
      $("#span_name").css('color', 'red');
      span_name.innerHTML="이름을 입력해주세요(한글 2~6자리)";
      name.value = "";
      return false;
    }else if (!(namepattern.test(name.value))) {
      $("#span_name").css('color', 'red');
      span_name.innerHTML="이름을 입력해주세요(한글 2~6자리)";
      name.value = "";
      return false;
    }else{
      span_name.innerHTML="";
      document.getElementById("flag_name").value="true";
    }
  });
  //패스워드검사
  $("#passwd").focusout(function(event) {
    document.getElementById("flag_passwd").value="false";
    var passwd = document.getElementById("passwd");
    var span_passwd = document.getElementById("span_passwd");
    var passwdpattern = /(?=.*\d{1,10})(?=.*[~`!@#$%\^&*()-+=]{1,10})(?=.*[a-zA-Z]{1,10}).{8,20}$/;
    if (passwd.value.length === 0) {
      $("#span_passwd").css('color', 'red');
      span_passwd.innerHTML="패스워드를 입력하세요(특수문자,숫자,문자 모두조합 8~20자리)";
      passwd.value = "";
      return false;
    }else if (!(passwdpattern.test(passwd.value))) {
      $("#span_passwd").css('color', 'red');
      span_passwd.innerHTML="패스워드을 입력해주세요(특수문자,숫자,문자 모두조합 8~20자리)";
      passwd.value = "";
      return false;
    }else{
      span_passwd.innerHTML="";
      document.getElementById("flag_passwd").value="true";
    }
  });
  //패스워드 확인검사
  $("#passwd_check").focusout(function(event) {
    document.getElementById("flag_passwd_check").value="false";
    var passwd = document.getElementById("passwd");
    var passwd_check = document.getElementById("passwd_check");
    var span_passwd_check = document.getElementById("span_passwd_check");

    if (passwd_check.value.length === 0) {
      $("#span_passwd_check").css('color', 'red');
      span_passwd_check.innerHTML="패스워드를 확인하세요.";
      passwd_check.value = "";
      return false;
    }else if (passwd.value!=passwd_check.value) {
      $("#span_passwd_check").css('color', 'red');
      span_passwd_check.innerHTML="패스워드가 같지 않습니다.";
      passwd_check.value = "";
      return false;
    }else{
      span_passwd_check.innerHTML="";
      document.getElementById("flag_passwd_check").value="true";
    }
  });
  //핸드폰번호 중간자리 검사
  $("#phone2").focusout(function(event) {
    document.getElementById("flag_phone2").value="false";
    var phone2 = document.getElementById("phone2");
    if (phone2.value.length === 0) {
      $("#span_phone").css('color', 'red');
      span_phone.innerHTML="전화번호 중간자리를 입력하세요";
      phone2.value = "";
      return false;
    }else if (phone2.value.length!=4) {
      $("#span_phone").css('color', 'red');
      span_phone.innerHTML="전화번호 중간자리 4자리를 입력해주세요";
      phone2.value = "";
      return false;
    }else{
      span_phone.innerHTML="";
      document.getElementById("flag_phone2").value="true";
    }
  });
  //핸드폰번호 마지막자리 검사
  $("#phone3").focusout(function(event) {
    document.getElementById("flag_phone3").value="false";
    var phone3 = document.getElementById("phone3");
    if (phone3.value.length === 0) {
      $("#span_phone").css('color', 'red');
      span_phone.innerHTML="전화번호 마지막자리를 입력하세요";
      phone3.value = "";
      return false;
    }else if (phone3.value.length!=4) {
      $("#span_phone").css('color', 'red');
      span_phone.innerHTML="전화번호 마지막자리 4자리를 입력해주세요";
      phone3.value = "";
      return false;
    }else{
      span_phone.innerHTML="";
      document.getElementById("flag_phone3").value="true";
    }
  });
  //주소 검사
  $("#address3").focusout(function(event) {
    document.getElementById("flag_address").value="false";
    var address1 = document.getElementById("address1");
    var address2 = document.getElementById("address2");
    var address3 = document.getElementById("address3");
    if (address3.value.length === 0 || address2.value.length === 0 || address1.value.length === 0) {
      $("#span_address").css('color', 'red');
      span_address.innerHTML="주소를 입력해주세요";
      return false;
    }else{
      span_address.innerHTML="";
      document.getElementById("flag_address").value="true";
    }
  });
  //이메일 인증
  $("#button1").click(function(event) {
    count=10;
    document.getElementById('set_time').style.color="red";
    document.getElementById('set_time').style.fontSize="10px";
    var email1 = document.getElementById("email1");
    var email2 = document.getElementById("email2");
    var emailpattern= /^[0-9a-zA-Z~!@#$%^&*()]+$/;
    if (email1.value.length === 0) {
      $("#span_email").css('color', 'red');
      span_email.innerHTML="이메일을 입력해주세요";
      email1.value = "";
      return false;
    } else if (!(emailpattern.test(email1.value))) {
      $("#span_email").css('color', 'red');
      span_email.innerHTML="이메일 형식이 잘못되었습니다.";
      email1.value = "";
      return false;
    }
    if(email2.value=="이메일을 선택하세요"){
      $("#span_email").css('color', 'red');
      span_email.innerHTML="이메일을 선택해주세요";
      return false;
    }else{
      span_email.innerHTML="";
    }
    $.ajax({
      url: '../../PHPmailer/email.php?mode=send_code',
      type: 'POST',
      data: {
        email1: $("#email1").val(),
        email2: $("#email2").val()
      }
    })
    .done(function(result) {
      console.log(result);
      var json_obj = $.parseJSON(result);
      code=json_obj[0].code;
      console.log(code);
      document.getElementById("code_text").setAttribute('type','text');
      document.getElementById("code_button").setAttribute('type','button');
      document.getElementById("button1").setAttribute('type','hidden');
      myFunction();
    })
    .fail(function() {
      console.log("error");
    })
    .always(function() {
      console.log("complete");
    });
  });
  //인증하기버튼
  $("#code_button").click(function(event) {
    document.getElementById("flag_email").value="false";
    var input_code = document.getElementById("code_text");
    if(code==input_code.value){
      code="";
      document.getElementById("code_text").setAttribute('type','hidden');
      document.getElementById("code_button").setAttribute('type','hidden');
      document.getElementById("button1").setAttribute('type','hidden');
      document.getElementById("email1").readOnly=true;
      document.getElementById("email2").disabled=true;
      document.getElementById('set_time').style.color="blue";
      document.getElementById('set_time').innerHTML="인증성공";
      document.getElementById("flag_email").value="true";
      clearTimeout(myVar);
    }else{
      modal_alert("알림","인증 실패");
    }
  });

  //포커스 인
  $("#id").focusin(function(event) {
    document.getElementById("span_id").innerHTML="";
  });
  $("#name").focusin(function(event) {
    document.getElementById("span_name").innerHTML="";
  });
  $("#passwd").focusin(function(event) {
    document.getElementById("span_passwd").innerHTML="";
  });
  $("#passwd_check").focusin(function(event) {
    document.getElementById("span_passwd_check").innerHTML="";
  });
  $("#phone2").focusin(function(event) {
    document.getElementById("span_phone").innerHTML="";
  });
  $("#phone3").focusin(function(event) {
    document.getElementById("span_phone").innerHTML="";
  });
  $("#address1").focusin(function(event) {
    document.getElementById("span_address").innerHTML="";
  });
  $("#address3").focusin(function(event) {
    document.getElementById("span_address").innerHTML="";
  });
  $("#email1").focusin(function(event) {
    document.getElementById("span_email").innerHTML="";
  });
  $("#email2").focusin(function(event) {
    document.getElementById("span_email").innerHTML="";
  });

  //가입하기버튼
  $("#button2").click(function(event) {
    if(document.getElementById("flag_id").value!="true"){
      modal_alert("알림","아이디를 확인해주세요");
      return;
    }else if(document.getElementById("flag_name").value!="true"){
      modal_alert("알림","이름을 확인해주세요");
      return;
    }else if(document.getElementById("flag_passwd").value!="true"){
      modal_alert("알림","비밀번호를 확인해주세요");
      return;
    }else if(document.getElementById("flag_passwd_check").value!="true"){
      modal_alert("알림","비밀번호를 확인해주세요");
      return;
    }else if(document.getElementById("flag_phone2").value!="true"){
      modal_alert("알림","전화번호를 확인해주세요");
      return;
    }else if(document.getElementById("flag_phone3").value!="true"){
      modal_alert("알림","전화번호를 확인해주세요");
      return;
    }else if(document.getElementById("flag_address").value!="true"){
      modal_alert("알림","주소를 확인해주세요");
      return;
    }else if(document.getElementById("flag_email").value!="true"){
      modal_alert("알림","이메일 인증을 해주세요");
      return;
    }
    document.getElementById("email2").disabled=false;
    document.member_form.submit();
  });

  $("#check1").click(function(event) {
    var check1 = document.getElementById("check1");
    var span1 = document.getElementById("span1");
    document.getElementById("flag_checkbox1").value="false";
    if (check1.checked==true){
      $("#span1").css('color', 'black');
      $("#span1").html("위 사항에 준수합니다.");
      document.getElementById("flag_checkbox1").value="true";
    }else{
      $("#span1").css('color', 'red');
      $("#span1").html("위 사항에 준수합니다.<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;약관에 동의하세요");
    }
  });
  $("#check2").click(function(event) {
    var check2 = document.getElementById("check2");
    var span2 = document.getElementById("span2");
    document.getElementById("flag_checkbox2").value="false";
    if (check2.checked==true){
      $("#span2").css('color', 'black');
      $("#span2").html("위 사항에 준수합니다.");
      document.getElementById("flag_checkbox2").value="true";
    }else{
      $("#span2").css('color', 'red');
      $("#span2").html("위 사항에 준수합니다.<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;약관에 동의하세요");
    }
  });
  $("#check3").click(function(event) {
    var flag_checkbox1 = document.getElementById("flag_checkbox1");
    var flag_checkbox2 = document.getElementById("flag_checkbox2");
    if(flag_checkbox1.value=="false" || flag_checkbox2.value=="false"){
      modal_alert("알림","모든약관에 동의주세요");
      document.getElementById("check3").checked=false;
    }else{
      document.flagcheck_form.submit();
    }
  });
});//ready

//이메일 시간계산
function myFunction() {
    var sec=count;

    document.getElementById('set_time').innerHTML="("+sec+"초)";

    if(!count){
      document.getElementById('set_time').style.fontSize="10px";
      document.getElementById('set_time').style.color="red";
      document.getElementById('set_time').innerHTML="시간초과 재인증필요";
      document.getElementById("button1").setAttribute('type','button');
      document.getElementById("code_text").setAttribute('type','hidden');
      document.getElementById("code_button").setAttribute('type','hidden');
      code="";
      return ;
    }
    count--;
    myVar = setTimeout(myFunction, 1000);
}

//주소 API
function execDaumPostcode() {/* 폼은 다음 주소찾기 빌리면서 입력값은 여기서 받고 처리하네?  */
    new daum.Postcode({
        oncomplete: function(data) {
            // 팝업에서 검색결과 항목을 클릭했을때 실행할 코드를 작성하는 부분.

            // 각 주소의 노출 규칙에 따라 주소를 조합한다.
            // 내려오는 변수가 값이 없는 경우엔 공백('')값을 가지므로, 이를 참고하여 분기 한다.
            var fullAddr = ''; // 최종 주소 변수
            var extraAddr = ''; // 조합형 주소 변수

            // 사용자가 선택한 주소 타입에 따라 해당 주소 값을 가져온다.
            if (data.userSelectedType === 'R') { // 사용자가 도로명 주소를 선택했을 경우
                fullAddr = data.roadAddress;

            } else { // 사용자가 지번 주소를 선택했을 경우(J)
                fullAddr = data.jibunAddress;
            }

            // 사용자가 선택한 주소가 도로명 타입일때 조합한다.
            if(data.userSelectedType === 'R'){
                //법정동명이 있을 경우 추가한다.
                if(data.bname !== ''){
                    extraAddr += data.bname;
                }
                // 건물명이 있을 경우 추가한다.
                if(data.buildingName !== ''){
                    extraAddr += (extraAddr !== '' ? ', ' + data.buildingName : data.buildingName);
                }
                // 조합형주소의 유무에 따라 양쪽에 괄호를 추가하여 최종 주소를 만든다.
                fullAddr += (extraAddr !== '' ? ' ('+ extraAddr +')' : '');
            }

            // 우편번호와 주소 정보를 해당 필드에 넣는다.
            document.getElementById('address2').value = data.zonecode; //5자리 새우편번호 사용
            document.getElementById('address1').value = fullAddr;

            // 커서를 상세주소 필드로 이동한다.
            document.getElementById('address3').value ="";
            document.getElementById('address3').focus();
        }
    }).open();
}
