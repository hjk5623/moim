<?php
session_start();

include $_SERVER['DOCUMENT_ROOT']."./moim/lib/db_connector.php";
include $_SERVER['DOCUMENT_ROOT']."/moim/lib/create_table.php";

if(isset($_GET["agit_num"]) && !empty($_GET["agit_num"])){
  $agit_num=test_input($_GET["agit_num"]);

  $sql="SELECT * from `agit` where agit_num='$agit_num';";
  $result = mysqli_query($conn,$sql);
  if (!$result) {
    die('Error: ' . mysqli_error($conn));
  }
  $row=mysqli_fetch_array($result);
  $agit_name = $row['agit_name'];
  $agit_content = $row['agit_content'];
  $agit_content=htmlspecialchars_decode($agit_content);
  $agit_address = $row['agit_address'];

  //사진
  $agit_image_name = $row['agit_image_name'];
  $agit_image_copied= $row['agit_image_copied'];

  $image_info = getimagesize("../data/".$agit_image_copied);
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
          <td>아지트이름</td>
            <td colspan="2"><input type="text" name="club_name" value="<?=$agit_name?>" readonly> </td>
          </tr>
          <tr>
            <td id="write_td">아지트주소</td>
            <td><input id="address1" type="text" name="club_rent_info1" value="<?=$agit_address?>" size="45" readonly></td>
          </tr>
          <tr>
            <td>아지트대표이미지</td>
            <td colspan="2">
             <?php
              echo "<img src='../data/$agit_image_copied' width='$image_width'>";
              ?>
            </td>
          </tr>
          <tr>
            <td colspan="3">내용</td>
          </tr>
          <tr>
            <td colspan="3">
                  <?php echo "$agit_content" ?>
            </td>
          </tr>
          <tr>
            <td colspan="3" style="text-align:right">
                <a href="./admin_agit_list.php"><button type="button" name="button">list</button></a>
                <a href="./admin_club_create2.php?mode=update&club_num=<?=$club_num?>"><button type="button" name="button">edit</button></a>
            </td>
          </tr>
          </table>
        </div><!--end of write_form -->
      </div>
  </div> <!-- end of wrap -->
</body>

</html>
