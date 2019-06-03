<?php
session_start();
include $_SERVER['DOCUMENT_ROOT']."./moim/lib/db_connector.php";
$mode="agit_create";  //default는 agit_create
$checked="";

$agit_num=$agit_name=$agit_code=$agit_conent="";
$user_num=$agit_rent_info[0]=$agit_rent_info[1]="";

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
  $club_category = $row['club_category'];
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
  <script type="text/javascript" src="../js/admin_agit_create.js"></script>
  <link rel="stylesheet" href="../../css/modal_alert.css">
  <script type="text/javascript" src="../../js/modal_alert.js"></script>
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css" integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">
  <link href="https://cdn.rawgit.com/dubrox/Multiple-Dates-Picker-for-jQuery-UI/master/jquery-ui.multidatespicker.css" rel="stylesheet"/><!--날짜다중선택 -->
  <script src="https://cdn.rawgit.com/dubrox/Multiple-Dates-Picker-for-jQuery-UI/master/jquery-ui.multidatespicker.js"></script><!--날짜다중선택 -->
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
      echo  "<h2 id='h2'><big><strong>아지트수정</strong></big></h2>";
      }else{
       echo  "<h2 id='h2'><big><strong>아지트등록</strong></big></h2>";

      }
       ?>
      <form name="tx_editor_form" id="tx_editor_form" action="./admin_query.php?mode=<?=$mode?>" method="post" enctype="multipart/form-data" accept-charset="utf-8">
        <div id="write_form">
          <!--수정시에 agit_num 전송-->
          <input type="hidden" name="club_num" value="<?=$agit_num?>">
          <!--모임이름, 모집정원, 모집시작일 ,모집종료일, 가격  -->
          <table class="club_create2_table">
            <tr>
              <td>아지트이름</td>
              <td colspan="2"><input type="text" name="agit_name" value="<?=$agit_name?>" id="agit_name" onkeyup="write_agit();"></td>
            </tr>
            <tr>
              <td>아지트코드</td>
              <td colspan="2"><input type="text" name="agit_code" value="<?=$agit_code?>" id="agit_code" placeholder="예시:hongdae--seoul"></td>
            </tr>
            <tr>
              <td id="write_td">아지트주소</td>
              <td><input id="address1" type="text" name="agit_rent_info1" value="<?=$agit_rent_info[0]?>" onclick="execDaumPostcode()" size="45" placeholder="주소"></td>
              <td><input id="address2" type="text" name="agit_rent_info2" value="<?=$agit_rent_info[1]?>" readonly></td>
            </tr>

            <tr>
              <td>사진 [gif,jpeg,png파일]</td>
              <td colspan="2"><br>
                <div class="img_wrap">
                  <img id="img1" >
                  <img id="img2" >
                  <img id="img3" >
                  <img id="img4" >
                </div>
                <input type="file" name="upfile[]" id="upfile1" value="" accept="image/gif,image/jpeg,image/png"  onchange="handleImgFileSelect(event,'img1')">
                <input type="file" name="upfile[]" id="upfile2" value="" accept="image/gif,image/jpeg,image/png"  onchange="handleImgFileSelect(event,'img2')"><br><br>
                <input type="file" name="upfile[]" id="upfile3" value="" accept="image/gif,image/jpeg,image/png"  onchange="handleImgFileSelect(event,'img3')">
                <input type="file" name="upfile[]" id="upfile4" value="" accept="image/gif,image/jpeg,image/png"  onchange="handleImgFileSelect(event,'img4')">
              </td>
            </tr>
              <td colspan="3">아지트소개</td>
            </tr>
            <tr>
              <td colspan="3">
                <textarea name="content" id="content" rows="10" cols="80">
                  <?php echo "$agit_conent  " ?>
                </textarea>
                <script type="text/javascript">
                  CKEDITOR.replace('content');
                </script>
              </td>
            </tr>
            <tr>
              <td colspan="3" style="text-align:right">
                <input type="button" name="" value="list" onclick="location.href='./admin_agit_list.php'" >
                <input type="button" id="agit_submit" value="submit">
              </td>
            </tr>
          </table>
      </form>
    </div><!--end of write_form -->
  </div><!-- end of wrap -->
  </div> <!-- end of col2 -->
</body>

</html>
