<?php
session_start();

include $_SERVER['DOCUMENT_ROOT']."./moim/lib/db_connector.php";
include $_SERVER['DOCUMENT_ROOT']."/moim/lib/create_table.php";



if(isset($_GET["club_num"]) && !empty($_GET["club_num"])){
  $club_num=test_input($_GET["club_num"]);

  $sql="SELECT * from `club` where club_num='$club_num';";
  $result = mysqli_query($conn,$sql);
  if (!$result) {
    die('Error: ' . mysqli_error($conn));
  }
  $row=mysqli_fetch_array($result);
  $club_name = $row['club_name'];
  $club_content = $row['club_content'];

  $club_content=htmlspecialchars_decode($club_content);

  $club_category = $row['club_category'];
  $club_price = $row['club_price'];
  $club_price=number_format($club_price);
  $club_to = $row['club_to'];
  $club_rent_info = $row['club_rent_info'];
  $club_start = $row['club_start'];
  $club_end = $row['club_end'];
  $club_schedule = $row['club_schedule'];
  $club_intro = $row['club_intro'];

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
  <link rel="stylesheet" href="../css/admin_club_create_view.css">
  <style media="screen">
      table {
        margin: 0 auto;
        width: 800px;
      }

  </style>
  <script type="text/javascript">

  </script>

  <title></title>
</head>

<body>
  <?php
  include $_SERVER['DOCUMENT_ROOT']."/moim/admin/source/admin.php";
  ?>
    <div class="body">
    <h2>모임내용</h2>
      <hr class="memberlist_hr">
      <form name="tx_editor_form" id="tx_editor_form" action="./admin_query.php?mode=clubinsert" method="post" enctype="multipart/form-data" accept-charset="utf-8">
        <div id="write_form"  style="margin-top:100px;">
          <!--모임이름, 모집정원, 모집시작일 ,모집종료일, 가격  -->
        <table class="create_view_table">
          <tr>
          <td>모임이름</td>
            <td colspan="2">
              <?=$club_name?>
             </td>
          </tr>
          <tr>
            <td id="write_td">카테고리</td>
            <td colspan="2">
              <?=$club_category?>
            </td>
          </tr>
          <tr>
            <td id="write_td">모임장소</td>
            <td><?=$club_rent_info?></td>
          </tr>
          <tr>
            <td id="write_td">모집정원</td>
            <td colspan="2"><input type="number" name="club_to" value="<?=$club_to?>" readonly></td>
          </tr>
          <tr>
            <td>모집시작일</td>
            <td colspan="2">
              <?=$club_start?>
            </td>
          </tr>
          <tr>
            <td>모집종료일</td>
            <td colspan="2">
              <?=$club_end?>
            </td>
          </tr>
          <tr>
            <td>가격</td>
            <td colspan="2">
              <?=$club_price?> 원
            </td>
          </tr>
          <tr>
            <td>모임일정</td>
            <td colspan="2">
              <?=$club_schedule?>
            </td>
          </tr>
          <tr>
            <td>모임대표이미지</td>
            <td colspan="2">
             <?php
              echo "<img src='../data/$club_image_copied' width='$image_width'>";
              ?>
            </td>
          </tr>
          <tr>

            <td align="center" >모임세부사항</td>
            <?php
             $file_path = "../data/".$club_file_copied;
             $file_size = filesize($file_path);
             ?>
             <td>
              <img src="../img/attach_file.png" alt="" width="18px" height="15px;"> 첨부파일 : <?=$club_file_name?> (<?=$file_size?> Byte)&nbsp;&nbsp;&nbsp;
              <a href='download.php?mode=download_c&club_num=<?=$club_num?>'>[저장]</a>
            </td>
          </tr>
            <tr>
              <td>간단소개</td>
              <td colspan="2">
                  <?=$club_intro?>
              </td>
            </tr>
          <tr>
            <td colspan="3">내용</td>
          </tr>
          <tr>
            <td colspan="3">
                  <?php echo "$club_content" ?>
            </td>
          </tr>
          <tr>
            <td colspan="3" style="text-align:right">
                <a href="./admin_club_list.php"><button type="button" name="button">list</button></a>
                <a href="./admin_club_create2.php?mode=update&club_num=<?=$club_num?>"><button type="button" name="button">edit</button></a>
            </td>
          </tr>
          </table>
        </div><!--end of write_form -->
      </div>
  </div> <!-- end of wrap -->
</body>

</html>
