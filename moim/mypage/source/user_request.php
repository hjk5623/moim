<?php
include $_SERVER['DOCUMENT_ROOT']."/moim/lib/session_call.php";
include $_SERVER['DOCUMENT_ROOT']."/moim/lib/db_connector.php";
?>
<!DOCTYPE html>
<html lang="ko" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.8.18/themes/base/jquery-ui.css" />
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
    <script src="//code.jquery.com/ui/1.8.18/jquery-ui.min.js"></script>
    <script src="http://dmaps.daum.net/map_js_init/postcode.v2.js"></script>
    <script src="//cdn.ckeditor.com/4.11.4/standard/ckeditor.js"></script>
    <script type="text/javascript" src="../js/user.js"></script>
    <link rel="stylesheet" type="text/css" href="../css/user_request.css">
    <link href="https://cdn.rawgit.com/dubrox/Multiple-Dates-Picker-for-jQuery-UI/master/jquery-ui.multidatespicker.css" rel="stylesheet"/><!--날짜다중선택 -->
    <script src="https://cdn.rawgit.com/dubrox/Multiple-Dates-Picker-for-jQuery-UI/master/jquery-ui.multidatespicker.js"></script><!--날짜다중선택 -->

    <style>
      /*datepicer 버튼 롤오버 시 손가락 모양 표시*/
      .ui-datepicker-trigger{cursor: pointer;}

      /*datepicer input 롤오버 시 손가락 모양 표시*/
      .hasDatepicker{cursor: pointer;}

      a{color:#000;}

.modal {
 display: none; /* Hidden by default */
 position: fixed; /* Stay in place */
 z-index: 10; /* Sit on top */
 left: 0;
 top: 0;
 width: 100%; /* Full width */
 height: 100%; /* Full height */
 overflow: auto; /* Enable scroll if needed */
 background-color: rgb(0,0,0); /* Fallback color */
 background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
}

/* Modal Content/Box */
.modal-content {

 background-color: #fefefe;
 margin: 15% auto; /* 15% from the top and centered */
 padding: 20px;
 border: 1px solid #888;
 width: 50%; /* Could be more or less, depending on screen size */
}
/* The Close Button */
.close {
 color: #aaa;
 float: right;
 font-size: 28px;
 font-weight: bold;
}
.close:hover,
.close:focus {
 color: black;
 text-decoration: none;
 cursor: pointer;
}



    </style>
    <script type="text/javascript">

    $(function() {
      $('#datepicker3').multiDatesPicker({
        minDate: 0, //오늘부터 선택
        dateFormat: 'y-mm-dd',
        club_schedule_cal: '#datepicker3',
        showButtonPanel: true,
        closeText: '닫기'
      });
    })
    </script>
    <script type="text/javascript">
      ///datepocler의 옵션을 설정
      $.datepicker.setDefaults({
        dateFormat: 'yy-mm-dd',
        prevText: '이전 달',
        nextText: '다음 달',
        monthNames: ['1월', '2월', '3월', '4월', '5월', '6월', '7월', '8월', '9월', '10월', '11월', '12월'],
        dayNames: ['일', '월', '화', '수', '목', '금', '토'], //달력의 요일 부분 텍스트
        dayNamesMin: ['일', '월', '화', '수', '목', '금', '토'], //달력의 요일 부분 Toottip 텍스트
        showMonthAfterYear: true, //년도 먼저 나오고, 뒤에 월 표시
        yearSuffix: '년', //달력의 년도 부분 뒤에 붙는 텍스트
      });
      // 출발일 입력칸은 input 태그의 text 타입이지만 이곳을 클릭하면 datepicker가 작동된다.
      // $("#datepicker1 , #datepicker2").datepicker 라고 input 객체를 datepicker 로 사용하겠다고 선언되어있기때문에
      $(function() {
        $("#datepicker1 , #datepicker2").datepicker({
          minDate: 0, //오늘부터 선택
          showButtonPanel: true,
          closeText: '닫기'
        });
      });

      $(document).ready(function() {

        var user_schedule = new Array();

        $("#datepicker2").change(function(event) {
          var start_date = $("#datepicker1").val().replace(/-/gi,"");
          var end_date = $("#datepicker2").val().replace(/-/gi,"");
          if(start_date>=end_date){
            alert("마감일 선택이 잘못 되었습니다.");
            var end_date = $("#datepicker2").val("");
          }
        });


        $("#select_month").change(function(event) {
          var lastDay = ( new Date( $("#select_year").val(), $("#select_month").val(), 0) ).getDate();
          $("#select_day").html("<option value='일'>일</option>");
          for(i=1;i<=lastDay;i++){
            $("#select_day").append("<option value='"+i+"'>"+i+"</option>");
          }

        });

        $("#schedule_btn").click(function(event) {
          var select_month="";
          var select_day="";
          var end_date = $("#datepicker2").val().replace(/-/gi,"");
          if($("#datepicker1").val()=="" || $("#datepicker2").val()==""){
            alert("모집시작일 및 종료일을 선택하세요");
            return;
          }
          if($("#select_year").val()=="" || $("#select_month").val()=="" || $("#select_day").val()=="일"){
            alert("날짜를 선택해주세요");
            return;
          }
          select_year = $("#select_year").val();
          select_month = $("#select_month").val();
          select_day = $("#select_day").val();
          if($("#select_month").val() < 10){
            select_month = "0"+$("#select_month").val();
          }
          if($("#select_day").val() < 10){
            select_day = "0"+$("#select_day").val();
          }

          var select_date= select_year+select_month+select_day;
          if(select_date<=end_date){
            alert("모집 마감일보다 빠를 수 없습니다.");
            return;
          }
          select_year = $("#select_year").val().substr(2);
          select_date = select_year+"-"+select_month+"-"+select_day;

          for(i=0; i<$("span[name=select_span]").length; i++){
            if($.trim($("span[name=select_span]:eq("+i+")").text()) == select_date){
              alert("같은 날짜를 추가할 수 없습니다.");
              return;
            }
          }

          if($("span[name=select_span]").length % 10 == 0){
            $("#date_td").append("<br><span class='select_span' name='select_span'>"+select_date+"<span>");
          }else{
            $("#date_td").append("<span class='select_span' name='select_span'>&nbsp;&nbsp;&nbsp;&nbsp;"+select_date+"<span>");
          }

          for(i=0; i<$("span[name=select_span]").length; i++){
            user_schedule[i] = $.trim($("span[name=select_span]:eq("+i+")").text()).replace(/-/gi,"");
          }
          if(user_schedule.length != 0){
            user_schedule.sort();
          }
          for(i=0; i<user_schedule.length; i++){
            user_year = user_schedule[i].substring(0,2)+"-";
            user_month = user_schedule[i].substring(2,4)+"-";
            user_day = user_schedule[i].substring(4,6);
            user_schedule[i]=user_year+user_month+user_day;
          }
          $("#user_schedule").val(user_schedule);
        });

        $(document).on("click",".select_span",function(){
          var user_schedule = new Array();
          var n = $('.select_span').index(this);
          $(".select_span:eq("+n+")").remove();

          for(i=0; i<$("span[name=select_span]").length; i++){
            user_schedule[i] = $.trim($("span[name=select_span]:eq("+i+")").text()).replace(/-/gi,"");
          }
          if(user_schedule.length != 0){
            user_schedule.sort();
          }
          for(i=0; i<user_schedule.length; i++){
            user_year = user_schedule[i].substring(0,2)+"-";
            user_month = user_schedule[i].substring(2,4)+"-";
            user_day = user_schedule[i].substring(4,6);
            user_schedule[i]=user_year+user_month+user_day;
          }
          $("#user_schedule").val(user_schedule);

        });

      });
    </script>
  </head>
  <body>
    <div id="myModal" class="modal">
     <div class="modal-content">
       <span class="close">&times;</span>
       <h1 id="modal_name"></h1>

       <h3>장소 : <span id="modal_address"></span></h3>

       <img src="" id="modal_img1">
       <img src="" id="modal_img2">
       <img src="" id="modal_img3">
       <img src="" id="modal_img4">

       <h3>내용 :<span id="modal_content"></span></h3>

     <div class="agit_btn">
       <a href="#" id="modal_a">자세히 보기</a>
     </div>
   </div>
</div>


    <?php
    include $_SERVER['DOCUMENT_ROOT']."/moim/mypage/lib/user_menu.php";
    ?>
    <div class="table_request_div">
      <h1 class="h1_request">모임만들기</h1>
      <hr>

    <form name="user_form" action="./user_query.php?mode=insert" method="post" enctype="multipart/form-data">
      <input type="hidden" name="user_schedule" id="user_schedule">
      <table id="table_request" class="table_request">
        <tr>
          <td>모임명</td>
          <td><input type="text" name="user_name" id="user_name" placeholder="모임명을 입력해주세요."></td>
        </tr>
        <tr>
          <td>모집 시작일</td>
          <td><input type="text" name="user_start" id="datepicker1" autocomplete="off" placeholder="모집 시작일을 설정해주세요."></td>
        </tr>
        <tr>
          <td>모집 종료일</td>
          <td><input type="text" name="user_end" id="datepicker2" autocomplete="off" placeholder="모집 종료일을 설정해주세요."></td>
        </tr>
        <tr>
          <td>모임 일정</td>
          <td id="date_td">
            <!-- <input type="text" name="user_schedule" id="datepicker3" autocomplete="off" placeholder="모임일정을 설정해주세요."> -->
            <select class="select_year" id="select_year" name="">
              <option value="">년도</option>
              <?php
              for($i=2019;$i<=2030;$i++){
              ?>
              <option value="<?=$i?>"><?=$i?></option>
              <?php
              }
              ?>
            </select>
            <select class="select_month" id="select_month" name="">
              <option value="">월</option>
              <?php
              for($i=1;$i<=12;$i++){
              ?>
              <option value="<?=$i?>"><?=$i?></option>
              <?php
              }
              ?>
            </select>
            <select class="select_day" id="select_day" name="">
              <option value="">일</option>
            </select>
            <button type="button" name="button" id="schedule_btn">추가</button>
          </td>
        </tr>
        <tr>
          <td>모집인원</td>
          <td><input type="number" name="user_to" id="user_to" placeholder="모집인원을 설정해주세요."></td>
        </tr>
        <tr>
          <td>분야</td>
          <td>
            <select class="user_category" name="user_category" id="user_category">
              <option value="선택">선택</option>
              <option value="글쓰기">글쓰기</option>
              <option value="놀이">놀이</option>
              <option value="영화">영화</option>
              <option value="미술">미술</option>
              <option value="사진">사진</option>
              <option value="디자인">디자인</option>
              <option value="취미생활/기타">취미생활/기타</option>
            </select>
          </td>
        </tr>
        <tr>
          <td>아지트</td>
          <td class="agit">
            <select class="user_rent_info" name="user_rent_info" id="select_value">
              <option value="선택">선택</option>
            <?php
              $sql = "select * from agit;";
              $result = mysqli_query($conn, $sql) or die(mysqli_error($conn));
              $count=mysqli_num_rows($result);
              for($i=0;$i<$count;$i++){
                $row= mysqli_fetch_array($result);
                $agit_name=$row['agit_name'];
                $agit_address=$row['agit_address'];
                ?>
                <option value="<?=$agit_address?>"><?=$agit_name?></option>
                <?php
              }
                 ?>
            </select>
            <button type="button" class="agit_btn">정보보기</button>
          </td>
        </tr>
        <tr>
          <td>가격</td>
          <td><input type="number" name="user_price" id="user_price" placeholder="가격을 설정해주세요."></td>
        </tr>
        <tr>
          <td>이미지</td>
          <td><input type="file" name="user_image" id="user_image"></td>
        </tr>
        <tr>
          <td>증빙서류</td>
          <td><input type="file" name="user_file" id="user_file"></td>
        </tr>
        <tr>
          <td>간단 소개</td>
          <td><textarea name="user_intro" id="user_intro" rows="8" cols="80" placeholder="간단한 소개를 작성해주세요(100자 내외)"></textarea></td>
        </tr>
        <tr>
          <td colspan="2"><textarea name="user_content" id="user_content" rows="8" cols="80"></textarea></td>
          <script type="text/javascript">
            CKEDITOR.replace('user_content');
          </script>
        </tr>
        <tr>
          <td colspan="2">
            <input type="button" onclick="user_request_check()" value="제출">
            <input type="reset" name="" value="초기화">
          </td>
        </tr>
      </table>
    </form>
    </div>
  </body>
</html>
<script type="text/javascript">
var modal = document.getElementById('myModal');

$(".agit_btn").click(function() {
  var select_value = document.getElementById('select_value').value;
  if(select_value=="선택") {
    alert("아지트를 선택하세요.");
  }else{
    $.ajax({
      url: 'user_query.php?mode=agit_modal',
      type: 'POST',
      data: {
        agit_name : $("#select_value").val()
      }
    })
    .done(function(result) {
      console.log("success");
      var json_obj=$.parseJSON(result);
      $("#modal_name").html(json_obj[0].agit_name);
      $("#modal_address").html(json_obj[0].agit_address);
      modal_content = json_obj[0].agit_content.replace(/\*\*\*/gi, " ");
      $("#modal_content").html(modal_content);
      $("#modal_a").prop('target','_blank');
      $("#modal_a").prop('href', 'https://www.wework.com/ko-KR/buildings/'+json_obj[0].agit_code);
      $("#modal_img1").prop('src', '../../admin/data/'+json_obj[0].agit_image_copied0);
      $("#modal_img2").prop('src', '../../admin/data/'+json_obj[0].agit_image_copied1);
      $("#modal_img3").prop('src', '../../admin/data/'+json_obj[0].agit_image_copied2);
      $("#modal_img4").prop('src', '../../admin/data/'+json_obj[0].agit_image_copied3);

      $("#modal_img1").prop('width', '600');
      $("#modal_img2").prop('width', '600');
      $("#modal_img3").prop('width', '600');
      $("#modal_img4").prop('width', '600');
      modal.style.display="block";

    })
    .fail(function() {
      console.log("error");
    })
    .always(function() {
      console.log("complete");
    });

    // Get the <span> element that closes the modal
  var span = document.getElementsByClassName("close")[0];

  // When the user clicks on the button, open the modal
  // btn.onclick = function() {
  //     modal.style.display = "block";
  // }

  // When the user clicks on <span> (x), close the modal
  span.onclick = function() {
      modal.style.display = "none";
  }

  // When the user clicks anywhere outside of the modal, close it
  window.onclick = function(event) {
      if (event.target == modal) {
          modal.style.display = "none";
      }
  }
}
});
</script>
