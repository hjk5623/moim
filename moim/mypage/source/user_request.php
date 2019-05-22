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
    <link rel="stylesheet" type="text/css" href="../css/user_request.css">
    <link href="https://cdn.rawgit.com/dubrox/Multiple-Dates-Picker-for-jQuery-UI/master/jquery-ui.multidatespicker.css" rel="stylesheet"/><!--날짜다중선택 -->
<script src="https://cdn.rawgit.com/dubrox/Multiple-Dates-Picker-for-jQuery-UI/master/jquery-ui.multidatespicker.js"></script><!--날짜다중선택 -->

    <style>
      /*datepicer 버튼 롤오버 시 손가락 모양 표시*/
      .ui-datepicker-trigger{cursor: pointer;}
      /*datepicer input 롤오버 시 손가락 모양 표시*/
      .hasDatepicker{cursor: pointer;}
    </style>
    <script type="text/javascript">
      function date_month(){
        alert("123");
      }
    </script>
    <script type="text/javascript">
    function textarea_edit(){
      CKEDITOR.replace('user_content');
    }
    $(function() {
      $('#datepicker3').multiDatesPicker({
        minDate: 0, //오늘부터 선택
        dateFormat: 'mm-dd',
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
    </script>
  </head>
  <body onload="textarea_edit()">
    <?php
    include $_SERVER['DOCUMENT_ROOT']."/moim/mypage/lib/user_menu.php";
    ?>
    <h1 class="h1_request">모임만들기</h1>
    <form name="user_form" action="./user_query.php?mode=insert" method="post" enctype="multipart/form-data">
      <table id="table_request" class="table_request" border="1">
        <tr>
          <td>모임명</td>
          <td><input type="text" name="user_name"></td>
        </tr>
        <tr>
          <td>모집 시작일</td>
          <td><input type="text" name="user_start" id="datepicker1" autocomplete="off"></td>
        </tr>
        <tr>
          <td>모집 종료일</td>
          <td><input type="text" name="user_end" id="datepicker2" autocomplete="off"></td>
        </tr>
        <tr>
          <td>모임 일정</td>
          <td id="date_td">
            <input type="text" name="user_schedule" id="datepicker3" autocomplete="off">
          </td>
        </tr>
        <tr>
          <td>모집인원</td>
          <td><input type="number" name="user_to"></td>
        </tr>
        <tr>
          <td>분야</td>
          <td>
            <select class="user_category" name="user_category">
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
          <td>대관정보</td>
          <td>
            <select class="user_rent_info" name="user_rent_info">
              <option value="선택">선택</option>
              <option value="대관1">대관1</option>
              <option value="대관2">대관2</option>
              <option value="대관3">대관3</option>
              <option value="대관4">대관4</option>
              <option value="대관5">대관5</option>
            </select>

          </td>
        </tr>
        <tr>
          <td>가격</td>
          <td><input type="number" name="user_price"></td>
        </tr>
        <tr>
          <td>이미지</td>
          <td><input type="file" name="user_image"></td>
        </tr>
        <tr>
          <td>증빙서류</td>
          <td><input type="file" name="user_file"></td>
        </tr>
        <tr>
          <td>간단 소개</td>
          <td><textarea name="user_intro" rows="8" cols="80"></textarea></td>
        </tr>
        <tr>
          <td colspan="2"><textarea name="user_content" id="user_content" rows="8" cols="80"></textarea></td>
        </tr>
        <tr>
          <td colspan="2">
            <input type="submit" name="" value="제출">
            <input type="reset" name="" value="초기화">
          </td>
        </tr>
      </table>
    </form>
  </body>
</html>
