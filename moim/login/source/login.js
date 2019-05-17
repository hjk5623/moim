$(document).ready(function() {
  $("#find_btn_passwd").click(function(event) {
    var id = document.getElementById("id");
    var email = document.getElementById("email");
    var find_span = document.getElementById("find_span");
    if (id.value.length === 0) {
      find_span.innerHTML="아이디를 입력해주세요";
      return false;
    }else if (email.value.length === 0) {
      find_span.innerHTML="이메일을 입력해주세요";
      return false;
    }
    $.ajax({
      url: '../../PHPmailer/email.php?mode=find_passwd',
      type: 'POST',
      data: {id: $("#id").val(), email:$("#email").val()}
    })
    .done(function(result) {
      console.log(result);
      var json_obj = $.parseJSON(result);
      if(json_obj[0].passwd=="실패"){
        find_span.style.color="red";
        find_span.innerHTML="<p>비밀번호 조회 결과<br><br>입력하신 정보와 일치하는 정보가 없습니다.<br>다시 검색해 주세요.</p>";
      }else{
        find_span.style.color="rgb(4, 21, 101)";
        find_span.innerHTML="<p>비밀번호 조회 결과<br><br>임시비밀번호를 이메일로 발송했습니다.<br><br>로그인후 비밀번호 수정하세요.</p>";
      }
    })
    .fail(function() {
      console.log("error");
    })
    .always(function() {
      console.log("complete");
    });
  });

  $("#find_btn_id").click(function(event) {
    var name = document.getElementById("name");
    var phone = document.getElementById("phone");
    var find_span = document.getElementById("find_span");
    if (name.value.length === 0) {
      find_span.innerHTML="이름을 입력해주세요";
      return false;
    }else if (phone.value.length === 0) {
      find_span.innerHTML="전화번호를 입력해주세요";
      return false;
    }
    $.ajax({
      url: './login_query.php?mode=find_id',
      type: 'POST',
      data: {name: $("#name").val(), phone:$("#phone").val()}
    })
    .done(function(result) {
      console.log(result);
      var json_obj = $.parseJSON(result);
      if(json_obj[0].id=="실패"){
        find_span.style.color="red";
        find_span.innerHTML="<p>아이디 조회 결과<br><br>입력하신 정보와 일치하는 아이디가 없습니다.<br>다시 검색해 주세요.</p>";
      }else{
        find_span.style.color="rgb(4, 21, 101)";
        find_span.innerHTML="<p>아이디 조회 결과<br><br>고객님의 아이디는 아래와 같습니다.<br><br>"+json_obj[0].id+"</p>";
      }
    })
    .fail(function() {
      console.log("error");
    })
    .always(function() {
      console.log("complete");
    });
  });
  //id 패턴검사 및 중복검사
  $("#login_btn").click(function(event) {
    var id = document.getElementById("id");
    var passwd = document.getElementById("passwd");
    var login_span = document.getElementById("login-span");
    if (id.value.length === 0) {
      login_span.innerHTML="아이디를 입력해주세요";
      id.value = "";
      return false;
    }else if (passwd.value.length === 0) {
      login_span.innerHTML="비밀번호를 입력해주세요";
      return false;
    }
    $.ajax({
      url: './login_query.php',
      type: 'POST',
      data: {id: $("#id").val(), passwd:$("#passwd").val()}
    })
    .done(function(result) {
      console.log(result);
      var json_obj = $.parseJSON(result);
      if(json_obj[0].id=="성공"){
        location.href="../../mainpage.php";
      }else{
        login_span.innerHTML=json_obj[0].id;
      }
    })
    .fail(function() {
      console.log("error");
    })
    .always(function() {
      console.log("complete");
    });
  });
<<<<<<< HEAD
});//ready

function kakao_check(res){
    $.ajax({
      url: './login_query.php?mode=kakao_check',
      type: 'POST',
      data: {kakao_id: JSON.stringify(res.id)}
    })
    .done(function(result) {
      console.log(result);
      var json_obj = $.parseJSON(result);
      if(json_obj[0].kakao_id=="성공"){
        location.href="../../mainpage.php?profile="+JSON.stringify(res.properties.profile_image);
      }else{
        document.login_form.submit();
      }
    })
    .fail(function() {
      console.log("error");
    })
    .always(function() {
      console.log("complete");
    });
}

function google_check(profile){
    $.ajax({
      url: './login_query.php?mode=google_check',
      type: 'POST',
      data: {google_id: profile.getId()}
    })
    .done(function(result) {
      console.log(result);
      var json_obj = $.parseJSON(result);
      if(json_obj[0].google_id=="성공"){
        location.href="../../mainpage.php?profile="+profile.getImageUrl();
      }else{
        document.login_form.submit();
      }
    })
    .fail(function() {
      console.log("error");
    })
    .always(function() {
      console.log("complete");
    });
}
=======
});
>>>>>>> 58f8c141919c6cc87c613dfbd5bb4315bce3f910
