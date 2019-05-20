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

  //사진
  $club_image_name = $row['club_image_name'];
  $club_image_copyied= $row['club_image_copyied'];

  //첨부파일
  $club_file_name= $row['club_file_name'];
  $club_file_copyied= $row['club_file_copyied'];
  $club_file_type= $row['club_file_type'];

  $image_info = getimagesize("../data/".$club_image_copyied);
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
  <div id="col2">
    <p id="board_title_p">&nbsp;&nbsp;</p>
    <div id="board_title_div">
    </div>
    <!--end of title -->
    <div class="clear"></div>
    <div id="write_form_title"></div>
    <div class="clear"></div>
    <div class="body">
      <form name="tx_editor_form" id="tx_editor_form" action="./admin_query.php?mode=clubinsert" method="post" enctype="multipart/form-data" accept-charset="utf-8">
        <div id="write_form"  style="margin-top:100px;">
          <!--모임이름, 모집정원, 모집시작일 ,모집종료일, 가격  -->
        <table border="1">
          <tr>
          <td>모임이름</td>
            <td colspan="2"><input type="text" name="club_name" value="<?=$club_name?>"> </td>
          </tr>
          <tr>
            <td id="write_td">카테고리</td>
            <td colspan="2">
              <input type="text" name="club_category" value="<?=$club_category?>">
            </td>
          </tr>
          <tr>
            <td id="write_td">모임장소</td>
            <td><input id="address1" type="text" name="club_rent_info1" value="<?=$club_rent_info?>" onclick="execDaumPostcode()" size="45" placeholder="주소"></td>
          </tr>
          <tr>
            <td id="write_td">모집정원</td>
            <td colspan="2"><input type="number" name="club_to" value="<?=$club_to?>"></td>
          </tr>
          <tr>
            <td>모집시작일</td>
            <td colspan="2"><input type="text" name="club_start" value="<?=$club_start?>" id="datepicker1"></td>
          </tr>
          <tr>
            <td>모집종료일</td>
            <td colspan="2"><input type="text" name="club_end" value="<?=$club_end?>" id="datepicker2"></td>
          </tr>
          <tr>
            <td>가격</td>
            <td colspan="2"><input type="text" name="club_price" value="<?=$club_price?>"></td>
          </tr>
          <tr>
            <td>수업일정</td>
            <td colspan="2"><input type="text" name="club_schedule" value="<?=$club_schedule?>"></td>
          </tr>
          <tr>
            <td>모임대표이미지</td>
            <td colspan="2">
             <?php
              echo "<img src='../data/$club_image_copyied' width='$image_width'>";
              ?>
            </td>
          </tr>
          <!-- <tr> -->
            <!-- <td>모임일정 [첨부파일]</td> -->
            <!-- <td colspan="2"><input type="file" name="upfile" value=""></td> -->
          <!-- </tr> -->
          <tr>
            <td colspan="3" style="text-align:center">내용</td>
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
    </div> <!-- end of content -->
  </div> <!-- end of wrap -->
</body>

</html>
