<?php
session_start();
include $_SERVER['DOCUMENT_ROOT']."./moim/lib/db_connector.php";
$mode="agit_create";  //default는 agit_create
$checked="";

$agit_num=$agit_name= $club_content= $club_category= $club_price= $club_to= $club_rent_info= $club_start=$club_end=$club_schedule="";
$agit_rent_info[0]=$agit_rent_info[1]=$agit_code="";
$user_num="";

if(isset($_GET['mode']) && $_GET['mode'] == "update"){
  $mode="update";
  $club_num = $_GET['club_num'];

  $sql="SELECT * from `agit` where agit_num='$agit_num';";
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
  <link rel="stylesheet" type="text/css" href="../css/admin_club_create.css">
  <link href="https://cdn.rawgit.com/dubrox/Multiple-Dates-Picker-for-jQuery-UI/master/jquery-ui.multidatespicker.css" rel="stylesheet"/><!--날짜다중선택 -->
  <script src="https://cdn.rawgit.com/dubrox/Multiple-Dates-Picker-for-jQuery-UI/master/jquery-ui.multidatespicker.js"></script><!--날짜다중선택 -->
  <script type="text/javascript">
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

          // 커서를 상세주소 필드로 이동한다.
          document.getElementById('address2').value = "";
          document.getElementById('address2').focus();
        }
      }).open();
    }
  </script>

  <title></title>
</head>

<body>
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
       echo  "<h2 id='h2'><big><strong>아지트등록</strong></big></h2>";

      }
       ?>
      <form name="tx_editor_form" id="tx_editor_form" action="./admin_query.php?mode=<?=$mode?>" method="post" enctype="multipart/form-data" accept-charset="utf-8">
        <div id="write_form">
          <!--수정시에 club_num 전송, 신청모임등록시에 user_num 전송-->
          <input type="hidden" name="club_num" value="<?=$club_num?>">
          <input type="hidden" name="user_num" value="<?=$user_num?>">
          <!--모임이름, 모집정원, 모집시작일 ,모집종료일, 가격  -->
          <table class="club_create2_table">
            <tr>
              <td>아지트이름</td>
              <td colspan="2"><input type="text" name="agit_name" value="<?=$agit_name?>"></td>
            </tr>
            <tr>
              <td>아지트코드</td>
              <td colspan="2"><input type="text" name="agit_code" value="<?=$agit_code?>" placeholder="예시:hongdae--seoul"></td>
            </tr>
            <tr>
              <td id="write_td">아지트주소</td>
              <td><input id="address1" type="text" name="agit_rent_info1" value="<?=$agit_rent_info[0]?>" onclick="execDaumPostcode()" size="45" placeholder="주소"></td>
              <td><input id="address2" type="text" name="agit_rent_info2" value="<?=$agit_rent_info[1]?>" placeholder="상세주소"></td>
            </tr>

            <tr>
              <td>사진 [gif,jpeg,png파일]</td>
              <td colspan="2">
                <input type="file" name="upimage" value="" accept="image/gif,image/jpeg,image/png">
              </td>
            </tr>
              <td colspan="3">아지트소개</td>
            </tr>
            <tr>
              <td colspan="3">
                <textarea name="content" id="content" rows="10" cols="80">
                  <?php echo "$club_content" ?>
                </textarea>
                <script type="text/javascript">
                  CKEDITOR.replace('content');
                </script>
              </td>
            </tr>
            <tr>
              <td colspan="3" style="text-align:right">
                <input type="button" name="" value="list" onclick="location.href='./admin_agit_list.php'" >
                <input type="submit" name="" value="submit">
              </td>
            </tr>
          </table>
      </form>
    </div><!--end of write_form -->
  </div><!-- end of wrap -->
  </div> <!-- end of col2 -->
</body>

</html>