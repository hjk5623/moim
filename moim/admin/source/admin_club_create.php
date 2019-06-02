<?php
session_start();
include $_SERVER['DOCUMENT_ROOT']."./moim/lib/db_connector.php";
$mode="clubinsert";
$checked="";
//
$club_num=$club_name= $club_content= $club_category= $club_price= $club_to= $club_rent_info= $club_start=$club_end=$club_schedule="";
$club_rent_info[0]=$club_rent_info[1]=$club_intro="";
$user_num="";
$schedule_count=0;
$schedule="";

if(isset($_GET['mode']) && $_GET['mode'] == "update"){
  $mode="update";
  $club_num = $_GET['club_num'];

  $sql="SELECT * from `club` where club_num='$club_num';";
  $result = mysqli_query($conn,$sql);
  if (!$result) {
    die('Error: ' . mysqli_error($conn));
  }
  $row=mysqli_fetch_array($result);
  $club_name= $row['club_name'];
  $club_content=$row['club_content'];
  $club_content=htmlspecialchars_decode($club_content);
  $club_category = $row['club_category']; //요리
  $club_price = $row['club_price'];

  $club_to= $row['club_to'];
  $club_rent_info = $row['club_rent_info'];
  $club_rent_info=explode("/", $club_rent_info);
  $club_start = $row['club_start'];
  $club_end = $row['club_end'];
  $club_schedule= $row['club_schedule'];
  $club_intro= $row['club_intro'];

  $schedule = explode("," ,$club_schedule);

  $schedule_count = count($schedule);


  //사진
  $club_image_name = $row['club_image_name'];
  $club_image_copied= $row['club_image_copied'];

  //첨부파일
  $club_file_name= $row['club_file_name'];
  $club_file_copied= $row['club_file_copied'];
  $club_file_type= $row['club_file_type'];

  $image_info = getimagesize("../data/".$club_image_copied);
  $image_width = $image_info[0];
  $image_height = $image_info[1];
  $image_type = $image_info[2];
  if($image_width>600) $image_width=600;

}else if(isset($_GET['mode']) && $_GET['mode'] == "request_create"){
  $mode="request_create";
  $user_num = $_GET['user_num'];


  $sql="SELECT * from `user_club` where user_num='$user_num';";
  $result = mysqli_query($conn,$sql);
  if (!$result) {
    die('Error: ' . mysqli_error($conn));
  }
  $row=mysqli_fetch_array($result);
  $club_content=$row['user_content'];
  $club_name=$row['user_name'];
  $club_content=htmlspecialchars_decode($club_content);
  $club_category  = $row['user_category']; //요리
  $club_price = $row['user_price'];

  $club_to= $row['user_to'];
  $club_rent_info = $row['user_rent_info'];
  $club_rent_info=explode("/", $club_rent_info);

  $club_start = $row['user_start'];
  $club_end = $row['user_end'];
  $club_schedule= $row['user_schedule'];
  $club_intro= $row['user_intro'];


    $schedule = explode("," ,$club_schedule);
    // var_dump($schedule);

    $schedule_count = count($schedule);



  //사진
  $club_image_name= $row['user_image_name'];
  $club_image_copied= $row['user_image_copied'];

  //첨부파일
  $club_file_name= $row['user_file_name'];
  $club_file_copied= $row['user_file_copied'];
  $club_file_type= $row['user_file_type'];

  $image_info = getimagesize("../../mypage/data/".$club_image_copied);
  $image_width = $image_info[0];
  $image_height = $image_info[1];
  $image_type = $image_info[2];
  if($image_width>600) $image_width=600;
}


?>
<!DOCTYPE html>
<html lang="ko" dir="ltr">
<head>
  <meta charset="utf-8">
  <link rel="stylesheet" href="//code.jquery.com/ui/1.8.18/themes/base/jquery-ui.css" />
  <script src="//ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
  <script src="//code.jquery.com/ui/1.8.18/jquery-ui.min.js"></script>
  <script src="http://dmaps.daum.net/map_js_init/postcode.v2.js"></script>
  <script src="//cdn.ckeditor.com/4.11.4/standard/ckeditor.js"></script><!--위지윅에디터 -->
  <script type="text/javascript" src="../js/admin_club_create_form.js"></script>
  <link rel="stylesheet" type="text/css" href="../css/admin_club_create.css">
  <link rel="stylesheet" href="../../css/modal_alert.css">
  <script type="text/javascript" src="../../js/modal_alert.js"></script>
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css" integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">

  <script type="text/javascript">
    //datepocler의 옵션을 설정
    $.datepicker.setDefaults({
      dateFormat: 'yy-mm-dd',
      prevText: '이전 달',
      nextText: '다음 달',
      monthNames: ['1월', '2월', '3월', '4월', '5월', '6월', '7월', '8월', '9월', '10월', '11월', '12월'],
      dayNames: ['일', '월', '화', '수', '목', '금', '토'], //달력의 요일 부분 텍스트
      dayNamesMin: ['일', '월', '화', '수', '목', '금', '토'], //달력의 요일 부분 Toottip 텍스트
      showMonthAfterYear: true, //년도 먼저 나오고, 뒤에 월 표시
      yearSuffix: '년' //달력의 년도 부분 뒤에 붙는 텍스트
    });
    // 출발일 입력칸은 input 태그의 text 타입이지만 이곳을 클릭하면 datepicker가 작동된다.
    //$("#datepicker1 , #datepicker2").datepicker 라고 input 객체를 datepicker 로 사용하겠다고 선언되어있기때문에
    $(function() {
      $("#datepicker1 , #datepicker2").datepicker({
        minDate: 0, //오늘부터 선택
        showButtonPanel:true,
        closeText: '닫기'
      });
    });
    //주소 API
    function execDaumPostcode() {
      /* 폼은 다음 주소찾기 빌리면서 입력값은 여기서 받고 처리하네?  */
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
          if (data.userSelectedType === 'R') {
            //법정동명이 있을 경우 추가한다.
            if (data.bname !== '') {
              extraAddr += data.bname;
            }
            // 건물명이 있을 경우 추가한다.
            if (data.buildingName !== '') {
              extraAddr += (extraAddr !== '' ? ', ' + data.buildingName : data.buildingName);
            }
            // 조합형주소의 유무에 따라 양쪽에 괄호를 추가하여 최종 주소를 만든다.
            fullAddr += (extraAddr !== '' ? ' (' + extraAddr + ')' : '');
          }
          // 우편번호와 주소 정보를 해당 필드에 넣는다.
          // document.getElementById('address2').value = data.zonecode; //5자리 새우편번호 사용
          document.getElementById('address1').value = fullAddr;
          document.getElementById('address1').readOnly = true ;

          // 커서를 상세주소 필드로 이동한다.
          document.getElementById('address2').value = "";
          document.getElementById('address2').focus();
        }
      }).open();
    }

    function select_box(){
      var agit =$('#agit_category option:selected').val();
      var agit_addr = agit.split("/");
      if(agit=="아지트선택"){
        $('#address1_1').attr('name','club_rent_info1_1');
        $('#address1').prop('type','text');
        $('#address1_1').prop('type','hidden');
        $('#address2').val("");
        $('#address2').attr('readOnly',false);
      }else{
        $('#address1').prop('type','hidden');
        $('#address1_1').prop('type','text');
        $('#address1_1').val(agit_addr[0]);
        $('#address1_1').attr('readOnly',true);
        $('#address1_1').attr('name','club_rent_info1');
        $('#address2').val(agit_addr[1]);
        $('#address2').attr('readOnly',true);
        $("#span_address").html("");
      }

  }

  // 모임일정등록_ select box 에서 선택하면 추가되는 방식으로
  $(document).ready(function() {
    var mode ="<?=$mode?>";
    var count=<?=$schedule_count?>;
    var category="<?=$club_category?>";

    var club_schedule = new Array();

    if(mode =="update" ||mode == "request_create"){
      var schedule= new Array();
      if(schedule != undefined){
        schedule=<?php echo json_encode($schedule)?>;
        // alert(schedule[0]);
        for(i=0;i<count;i++){
          $("#date_td").append("<br><span class='select_span' name='select_span'>"+schedule[i]+"<span>");
          club_schedule[i]=schedule[i];
        }
        $("#club_schedule").val(club_schedule);
      }
      $("#club_category").val(category).attr("selected","selected");
      $("#flag_club_name").val("true");

    }


    $("#datepicker2").change(function(event) {
    var start_date = $("#datepicker1").val().replace(/-/gi,"");
    var end_date = $("#datepicker2").val().replace(/-/gi,"");
      if(start_date>=end_date){
        modal_alert("알림","마감일 선택이 잘못 되었습니다.");
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
        modal_alert("알림","모집시작일 및 종료일을 선택하세요");
        return;
      }
      if($("#select_year").val()=="" || $("#select_month").val()=="" || $("#select_day").val()=="일"){
        modal_alert("알림","날짜를 선택해주세요");
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
        modal_alert("알림","모집 마감일보다 빠를 수 없습니다.");
        return;
      }
        select_year = $("#select_year").val().substr(2);
        select_date = select_year+"-"+select_month+"-"+select_day;
        for(i=0; i<$("span[name=select_span]").length; i++){
          if($.trim($("span[name=select_span]:eq("+i+")").text()) == select_date){
            modal_alert("알림","같은 날짜를 추가할 수 없습니다.");
            return;
          }
        }

    if($("span[name=select_span]").length % 10 == 0){
      $("#date_td").append("<br><span class='select_span' name='select_span'>"+select_date+"<span>");
    }else{
      $("#date_td").append("<span class='select_span' name='select_span'>&nbsp;&nbsp;&nbsp;&nbsp;"+select_date+"<span>");
    }

    for(i=0; i<$("span[name=select_span]").length; i++){
      club_schedule[i] = $.trim($("span[name=select_span]:eq("+i+")").text()).replace(/-/gi,"");
    }
    if(club_schedule.length != 0){
      club_schedule.sort();
    }
    for(i=0; i<club_schedule.length; i++){
      user_year = club_schedule[i].substring(0,2)+"-";
      user_month = club_schedule[i].substring(2,4)+"-";
      user_day = club_schedule[i].substring(4,6);
      club_schedule[i] = user_year + user_month+user_day;
    }
    $("#club_schedule").val(club_schedule);
    var aa =  $("#club_schedule").val();
    console.log(aa);
  });

  $(document).on("click",".select_span",function(){
    var club_schedule = new Array();
    var n = $('.select_span').index(this);
    $(".select_span:eq("+n+")").remove();

    for(i=0; i<$("span[name=select_span]").length; i++){
      club_schedule[i] = $.trim($("span[name=select_span]:eq("+i+")").text()).replace(/-/gi,"");
    }
    if(club_schedule.length != 0){
      club_schedule.sort();
    }
    for(i=0; i<club_schedule.length; i++){
      user_year = club_schedule[i].substring(0,2)+"-";
      user_month = club_schedule[i].substring(2,4)+"-";
      user_day = club_schedule[i].substring(4,6);
      club_schedule[i]=user_year+user_month+user_day;
    }
    $("#club_schedule").val(club_schedule);

    });

  }); // end of document.ready()


  function request_send_email(num){
    console.log(num);
    $.ajax({
      url: '../../PHPmailer/email.php?mode=request_approve',  //이용자가 신청한 모임을 등록하면 해당 이용자에게 메일을 전송
      type: 'POST',
      data: {
        user_num: num
      }
    }) .done(function(result) {
      console.log(result);
      document.tx_editor_form.submit();
    })
    .fail(function() {
      console.log("error");
    })
    .always(function() {
      console.log("complete");
    });
  }



  </script>
  <title></title>
</head>
<body>
  <div id="myModal" class="modal">
   <div class="modal-content" id="modal-content">

    </div>
  </div>
  <?php
  include $_SERVER['DOCUMENT_ROOT']."/moim/admin/source/admin.php";
  ?>
  <div id="col2">
    <div id="write_form_title"></div>
    <div class="wrap">
      <?php
      if($mode=="update"){
      echo  "<h2 id='h2'><big><strong>모임수정</strong></big></h2>";
      }else{
       echo  "<h2 id='h2'><big><strong>모임등록</strong></big></h2>";

      }
       ?>
      <form name="tx_editor_form" id="tx_editor_form" action="./admin_query.php?mode=<?=$mode?>" method="post" enctype="multipart/form-data" accept-charset="utf-8">
        <div id="write_form">
          <input type="hidden" id="flag_club_name" value="false">
          <input type="hidden" id="flag_club_category" value="false">
          <input type="hidden" id="flag_agit_category" value="false">
          <input type="hidden" id="flag_address1" value="false">
          <input type="hidden" id="flag_address2" value="false">
          <input type="hidden" id="flag_club_to" value="false">
          <input type="hidden" id="flag_club_start" value="false">
          <input type="hidden" id="flag_club_end" value="false">
          <input type="hidden" id="flag_club_price" value="false">
          <input type="hidden" id="flag_club_schedule" value="false">
          <input type="hidden" id="flag_club_intro" value="false">
          <input type="hidden" id="flag_club_content" value="false">


          <!--수정시에 club_num 전송, 신청모임등록시에 user_num 전송-->
          <input type="hidden" name="club_num" value="<?=$club_num?>">
          <input type="hidden" name="user_num" value="<?=$user_num?>">
          <input type="hidden" name="club_schedule" id="club_schedule">
          <!--모임이름, 모집정원, 모집시작일 ,모집종료일, 가격  -->
          <table class="club_create2_table">
            <tr>
              <td>모임이름</td>
              <td colspan="2">
                <input type="text" name="club_name" id="club_name" value="<?=$club_name?>" placeholder="모임이름">
                <span id="span_club_name"></span>
              </td>
            </tr>
            <tr>
              <td id="write_td">카테고리</td>
              <td colspan="2">
                <select name="club_category" id="club_category" style="width:176px;">
                  <option value="선택">선택</option>
                  <option value="글쓰기">글쓰기</option>
                  <option value="요리">요리</option>
                  <option value="영화">영화</option>
                  <option value="미술">미술</option>
                  <option value="사진">사진</option>
                  <option value="디자인">디자인</option>
                  <option value="디자인">경제/경영</option>
                  <option value="취미생활/기타">취미생활/기타</option>
                </select>
                <span id="span_club_category"></span>
              </td>
            </tr>
            <tr>
              <td id="write_td">모임장소</td>
              <td style="width:171px">
                <select name="agit_category" id="agit_category" onchange="select_box()">
                  <option>아지트선택</option>
                  <?php
                    $sql1="SELECT `agit_name`,`agit_address` from `agit`;";
                    $result1 = mysqli_query($conn,$sql1);
                    if (!$result1) {
                      die('Error: ' . mysqli_error($conn));
                    }
                    $count=mysqli_num_rows($result1);
                    for($i=0;$i<$count;$i++){
                      $row1=mysqli_fetch_array($result1);
                    ?>
                    <option value="<?=$row1['agit_address']?>"> <?=$row1['agit_name']?></option>;
                    <?php
                    }
                   ?>
                </select>
              </td>
              <td>
                  <input id="address1" type="text" name="club_rent_info1" value="<?=$club_rent_info[0]?>" onclick="execDaumPostcode()" size="55" placeholder="주소" autocomplete="off">
                  <input id="address1_1" type="hidden" name="club_rent_info1_1" value="<?=$club_rent_info[0]?>" size="55" placeholder="주소" autocomplete="off">
                  <input id="address2" type="text" name="club_rent_info2" value="<?=$club_rent_info[1]?>" placeholder="상세주소" autocomplete="off"><br>
                  <span id="span_address"></span>
              </td>
            </tr>


            <tr>
              <td id="write_td">모집정원</td>
              <td colspan="2">
                <input type="number" name="club_to" id="club_to" value="<?=$club_to?>" autocomplete="off"  placeholder="모집정원">
                <span id="span_club_to"></span>
              </td>
            </tr>
            <tr>
              <td>모집시작일</td>
              <td colspan="2">
                <input type="text" name="club_start" value="<?=$club_start?>" id="datepicker1" autocomplete="off" placeholder="모집시작일">
                <span id="span_club_start"></span>
              </td>
            </tr>
            <tr>
              <td>모집마감일</td>
              <td colspan="2">
                <input type="text" name="club_end" value="<?=$club_end?>" id="datepicker2" autocomplete="off" placeholder="모집마감일">
                <span id="span_club_end"></span>
              </td>
            </tr>
            <tr>
              <td>가격</td>
              <td colspan="2">
                <input type="number" name="club_price" id="club_price" value="<?=$club_price?>"  placeholder="가격">
                <span id="span_club_price"></span>
              </td>
            </tr>

            <!--▼▼▼▼ 모임일정 selectbox사용  -->
            <tr>
              <td>모임 일정</td>
              <td id="date_td" colspan="2">
                <select class="select_year" id="select_year" name="" style="height:40px;">
                  <option value="">년도</option>
                  <?php
                  for($i=2019;$i<=2030;$i++){
                  ?>
                  <option value="<?=$i?>"><?=$i?></option>
                  <?php
                  }
                  ?>
                </select>
                <select class="select_month" id="select_month" name=""  style="height:40px;">
                  <option value="">월</option>
                  <?php
                  for($i=1;$i<=12;$i++){
                  ?>
                  <option value="<?=$i?>"><?=$i?></option>
                  <?php
                  }
                  ?>
                </select>
                <select class="select_day" id="select_day" name=""  style="height:40px;">
                  <option value="">일</option>
                </select>
                <button type="button" name="button" id="schedule_btn">추가</button><br><br>
                <?php
                  if($mode=="update"){
                    echo '<input type="text" name="club_schedule2" id="club_schedule2">';

                  }
                 ?>
              </td>
            </tr>

            <!--▲▲▲▲ 모임일정 selectbox사용  -->

            <tr>
              <td>사진 [gif,jpeg,png파일]</td>
              <td colspan="2">
              <?php
                if($mode=="update"){
              ?>
                <img src="../data/<?=$club_image_copied?>" width="<?=$image_width?>"><br>
                <input type="checkbox" name="del_img" value="1" id="del_img">삭제
                <input type="file" name="upimage" value=""  accept="image/gif,image/jpeg,image/png"
                    onclick="document.getElementById('del_img').checked=true; document.getElementById('del_img').disabled=true"><br>

              <?php
                }else if($mode=="request_create"){
              ?>
                <img src="../../mypage/data/<?=$club_image_copied?>" width="<?=$image_width?>"><br>
                <input type="checkbox" name="del_img" value="1" id="del_img">삭제
                <input type="file" name="upimage" value=""  accept="image/gif,image/jpeg,image/png"
                    onclick="document.getElementById('del_img').checked=true; document.getElementById('del_img').disabled=true"><br>
              <?php
                }else{
               ?>
                <input type="file" name="upimage" value="" accept="image/gif,image/jpeg,image/png">
              <?php
                }
               ?>
              </td>
            </tr>
            <tr>
              <td>모임세부사항 [첨부파일]</td>
              <td colspan="2">
                <?php
                if( ($mode=="update" || $mode="request_create")  && !empty($club_file_name)  ){
                  echo "$club_file_name 파일이 등록되어 있습니다.";

                  echo '<input type="checkbox" name="del_file" value="1" id="del_file">삭제';
                  ?>
                  <input type="file" name="upfile" value=""
                          onclick="document.getElementById('del_file').checked=true; document.getElementById('del_file').disabled=true">
              <?php
                }else{
                  echo "<input type='file' name='upfile' value=''>";
                }
              ?>

              </td>
            </tr>

            <tr>
              <td>모임간단소개</td>
              <td colspan="3">
                <textarea name="club_intro" rows="8" cols="80" id="club_intro"  placeholder="간단한 소개를 작성해주세요(100자 내외)"><?=$club_intro?></textarea>
                <span id="span_club_intro"></span>
              </td>
            </tr>
            <tr>
              <td >내용</td>
              <td colspan="2"> ✔ 제목은 [제목1], 소제목은 [제목3]으로 작성부탁드립니다. </td>
            </tr>
            <tr>
              <td colspan="3">
                <textarea name="content" id="content" rows="10" cols="80">
                  <?php echo "$club_content" ?>
                </textarea>
                <span id="span_club_content"></span>
                <script type="text/javascript">
                  CKEDITOR.replace('content');
                </script>
              </td>
            </tr>
            <tr>
              <td colspan="3" style="text-align:right">
                <input type="button" name="" value="list" onclick="location.href='./admin_club_list.php'" >
                <?php
                  if(isset($_GET['mode']) && $_GET['mode'] == "request_create"){
                ?>
                <input type="button" id="" value="submit" onclick="request_send_email(<?=$user_num?>);"></td>

                <?php
                }else if(isset($_GET['mode']) && $_GET['mode'] == "update"){
                    echo "<input type='submit' id='' name='' value='submit'></td>";
                  }else{
                    echo "<input type='button' id='submit_btn' name='' value='submit'></td>";
                  }
                 ?>

            </tr>
          </table>
      </form>
    </div><!--end of write_form -->
  </div><!-- end of wrap -->
  </div> <!-- end of col2 -->
</body>

</html>
