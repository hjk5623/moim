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
                  // document.getElementById('address2').value = data.zonecode; //5자리 새우편번호 사용
                  document.getElementById('user_rent_info').value = fullAddr;


              }
          }).open();
      }
    </script>
  </head>
  <body onload="textarea_edit()">
    <form name="user_form" action="./user_query.php?mode=insert" method="post" enctype="multipart/form-data">
      <table id="table1" border="1">
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
          <td><input type="text" name="user_category"></td>
        </tr>
        <tr>
          <td>대관정보</td>
          <td><input type="text" id="user_rent_info" name="user_rent_info" onclick="execDaumPostcode()"></td>
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
