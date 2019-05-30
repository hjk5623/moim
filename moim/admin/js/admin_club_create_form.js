$(document).ready(function() {
  //모임등록 입력검사

  //모임이름검사
  $("#club_name").focusout(function(event) {
    document.getElementById("flag_club_name").value="false";
    var club_name = document.getElementById("club_name");
    var span_club_name = document.getElementById("span_club_name");
    if (club_name.value.length === 0) {
      $("#span_club_name").css('color', 'red');
      span_club_name.innerHTML="모임이름을 입력해주세요";
      club_name.value = "";
      return false;
    }else{
      span_club_name.innerHTML="";
      document.getElementById("flag_club_name").value="true";

    }
  });

  //카테고리검사
  $("#club_category").focusout(function(event) {
    document.getElementById("flag_club_category").value="false";
    var club_category = document.getElementById("club_category");
    var span_club_category = document.getElementById("span_club_category");
    if (club_category.value === "선택") {
      $("#span_club_category").css('color', 'red');
      span_club_category.innerHTML=" 카테고리를 선택해주세요";
      club_category.value = "선택";
      return false;
    }else{
      span_club_category.innerHTML="";
      document.getElementById("flag_club_category").value="true";

    }
  });
  //주소검사
  // $("#address1").focusout(function(event) {
  //    var address1 = document.getElementById("address1");
  //    var address2 = document.getElementById("address2");
  //  var agit_category = document.getElementById("agit_category");
  //    if (address1.value.length === 0 || address2.value.length === 0) {
  //      $("#span_address").css('color', 'red');
  //      span_address.innerHTML="주소를 입력해주세요";
  //      return false;
  //    }else{
  //      span_address.innerHTML="";
  //    }
  // });
  //모집정원검사
  $("#club_to").focusout(function(event) {
    document.getElementById("flag_club_to").value="false";
    var club_to = document.getElementById("club_to");
    var span_club_to = document.getElementById("span_club_to");
    if (club_to.value.length === 0) {
      $("#span_club_to").css('color', 'red');
      span_club_to.innerHTML="모집정원을 입력해주세요";
      club_to.value = "";
      return false;
    }else{
      span_club_to.innerHTML="";
      document.getElementById("flag_club_to").value="true";
    }
  });

  //모집시작일검사
  $("#datepicker1").change(function(event) {
    document.getElementById("flag_club_start").value="false";
    var datepicker1 = document.getElementById("datepicker1");
    var span_club_start = document.getElementById("span_club_start");
    if (datepicker1.value.length === 0) {
      $("#span_club_start").css('color', 'red');
      span_club_start.innerHTML="모집시작일을 입력해주세요";
      datepicker1.value = "";
      return false;
    }else{
      span_club_start.innerHTML="";
      document.getElementById("flag_club_start").value="true";

    }
  });
  //모집종료일검사
  $("#datepicker2").change(function(event) {
    document.getElementById("flag_club_end").value="false";
    var datepicker2 = document.getElementById("datepicker2");
    var span_club_end = document.getElementById("span_club_end");
    if (datepicker2.value.length === 0) {
      $("#span_club_end").css('color', 'red');
      span_club_end.innerHTML="모집마감일을 입력해주세요";
      datepicker2.value = "";
      return false;
    }else{
      span_club_end.innerHTML="";
      document.getElementById("flag_club_end").value="true";
    }
  });
  //가격검사
  $("#club_price").focusout(function(event) {
    document.getElementById("flag_club_price").value="false";
    var club_price = document.getElementById("club_price");
    var span_club_price = document.getElementById("span_club_price");
    if (club_price.value.length === 0) {
      $("#span_club_price").css('color', 'red');
      span_club_price.innerHTML="가격을 입력해주세요";
      club_price.value = "";
      return false;
    }else{
      span_club_price.innerHTML="";
      document.getElementById("flag_club_price").value="true";
    }
  });


  //간단소개검사
  $("#club_intro").focusout(function(event) {
    document.getElementById("flag_club_intro").value="false";
    var club_intro = document.getElementById("club_intro");
    var span_club_intro = document.getElementById("span_club_intro");
    if (club_intro.value.length === 0) {
      $("#span_club_intro").css('color', 'red');
      span_club_intro.innerHTML="모임간단소개를 입력해주세요.";
      club_intro.value = "";
      return false;
    }else{
      span_club_intro.innerHTML="";
      document.getElementById("flag_club_intro").value="true";

    }
  });

    //내용검사
    $("#content").focusout(function(event) {
      document.getElementById("flag_club_content").value="false";
      var content = document.getElementById("content");
      var span_club_content = document.getElementById("span_club_content");
      if (content.value.length === 0) {
        $("#span_club_content").css('color', 'red');
        span_club_content.innerHTML="모임내용을 입력해주세요.";
        content.value = "";
        return false;
      }else{
        span_club_content.innerHTML="";
        document.getElementById("flag_club_content").value="true";

      }
    });


  //포커스 인
  $("#club_name").focusin(function(event) {
    document.getElementById("span_club_name").innerHTML="";
  });

  $("#club_category").focusin(function(event) {
    document.getElementById("span_club_category").innerHTML="";
  });

  $("#club_to").focusin(function(event) {
    document.getElementById("span_club_to").innerHTML="";
  });

  $("#datepicker1").focusin(function(event) {
    document.getElementById("span_club_start").innerHTML="";
  });

  $("#datepicker2").focusin(function(event) {
    document.getElementById("span_club_end").innerHTML="";
  });

  $("#club_price").focusin(function(event) {
    document.getElementById("span_club_price").innerHTML="";
  });

  $("#club_intro").focusin(function(event) {
    document.getElementById("span_club_intro").innerHTML="";
  });

  $("#content").focusin(function(event) {
    document.getElementById("span_club_content").innerHTML="";
  });



  // submit 버튼
  $("#submit_btn").click(function(event) {
    if(document.getElementById("flag_club_name").value!="true"){
      alert("모임이름을 확인해주세요");
      return;
    }else if(document.getElementById("flag_club_category").value!="true"){
      alert("카테고리를 확인해주세요");
      return;
    }else if(document.getElementById("flag_club_to").value!="true"){
      alert("모집정원을 확인해주세요");
      return;
    }else if(document.getElementById("flag_club_start").value!="true"){
      alert("모집시작일을 확인해주세요");
      return;
    }else if(document.getElementById("flag_club_end").value!="true"){
      alert("모집마감일을 확인해주세요");
      return;
    }else if(document.getElementById("flag_club_price").value!="true"){
      alert("가격을 확인해주세요");
      return;
    }else if(document.getElementById("flag_club_schedule").value!="true"){
      // alert("모임일정을 확인해주세요");
      // return;
    }else if(document.getElementById("flag_club_intro").value!="true"){
      alert("모임간단소개를 확인 해주세요");
      return;
    }else if(document.getElementById("flag_club_content").value!="true"){
      alert("모임 내용을 확인 해주세요");
      return;
    }
    // document.getElementById("email2").disabled=false;
    document.tx_editor_form.submit();
  });

  // $("#check1").click(function(event) {
  //   var check1 = document.getElementById("check1");
  //   var span1 = document.getElementById("span1");
  //   document.getElementById("flag_checkbox1").value="false";
  //   if (check1.checked==true){
  //     $("#span1").css('color', 'white');
  //     $("#span1").html("위 사항에 준수합니다.");
  //     document.getElementById("flag_checkbox1").value="true";
  //   }else{
  //     $("#span1").css('color', 'red');
  //     $("#span1").html("위 사항에 준수합니다.<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;약관에 동의하세요");
  //   }
  // });
  // $("#check2").click(function(event) {
  //   var check2 = document.getElementById("check2");
  //   var span2 = document.getElementById("span2");
  //   document.getElementById("flag_checkbox2").value="false";
  //   if (check2.checked==true){
  //     $("#span2").css('color', 'white');
  //     $("#span2").html("위 사항에 준수합니다.");
  //     document.getElementById("flag_checkbox2").value="true";
  //   }else{
  //     $("#span2").css('color', 'red');
  //     $("#span2").html("위 사항에 준수합니다.<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;약관에 동의하세요");
  //   }
  // });
  // $("#check3").click(function(event) {
  //   var flag_checkbox1 = document.getElementById("flag_checkbox1");
  //   var flag_checkbox2 = document.getElementById("flag_checkbox2");
  //   if(flag_checkbox1.value=="false" || flag_checkbox2.value=="false"){
  //     alert("모든약관에 동의주세요");
  //     document.getElementById("check3").checked=false;
  //   }else{
  //     document.flagcheck_form.submit();
  //   }
  // });

});//ready
