<?php
include $_SERVER['DOCUMENT_ROOT']."/moim/lib/db_connector.php";

?>

<?php
$schedule = array();
$year = $_POST["year"];
$month = $_POST["month"];
if($month<=9){
  $month="0".$month;
}
$sql = "select * from club where club_start like '$year-$month%'";
$result = mysqli_query($conn, $sql) or die("실패원인12 " . mysqli_error($conn));
$row_count= mysqli_num_rows($result);
   for($i=0; $i<$row_count; $i++){
      $row = mysqli_fetch_array($result);
      $num = $row['club_num'];
      $club_name= $row['club_name'];
      $club_start=$row['club_start'];
      $club_start=explode("-",$club_start);
      if($club_start[2]<=9){
        $club_start[2]=substr($club_start[2],1);
      }
      $schedule[$i]=$club_start[2]."/".$club_name."/$num";
      echo $schedule[$i].",";
   }

?>
