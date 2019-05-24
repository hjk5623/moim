<?php
include $_SERVER['DOCUMENT_ROOT']."./moim/lib/db_connector.php";
include $_SERVER['DOCUMENT_ROOT']."/moim/lib/create_table.php";

$sql="SELECT * from `agit` where agit_num=7;";
$result = mysqli_query($conn,$sql);
if (!$result) {
  alert_back('Error: ' . mysqli_error($conn));
}
$row = mysqli_fetch_array($result);
$agit_content = $row['agit_content'];
$agit_content=htmlspecialchars_decode($agit_content);
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
       <?=$agit_content?>
    </div>
  </body>
</html>
