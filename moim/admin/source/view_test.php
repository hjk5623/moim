<?php
include $_SERVER['DOCUMENT_ROOT']."./moim/lib/db_connector.php";
include $_SERVER['DOCUMENT_ROOT']."/moim/lib/create_table.php";

$sql="SELECT * from `club` where club_num=1;";
$result = mysqli_query($conn,$sql);
if (!$result) {
  alert_back('Error: ' . mysqli_error($conn));
}
$row = mysqli_fetch_array($result);
$club_content = $row['club_content'];
$club_content=htmlspecialchars_decode($club_content);
mysqli_close($conn);


 ?>
<!DOCTYPE html>
<html lang="ko" dir="ltr">
  <head>
    <meta charset="utf-8">

    <title></title>
  </head>
  <body>
    <div id="demo">
       <?=$club_content?>
    </div>
  </body>
</html>
