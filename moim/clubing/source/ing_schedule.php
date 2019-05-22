<?php
include $_SERVER['DOCUMENT_ROOT']."/moim/lib/db_connector.php";
?>

<?php
$schedule = array();
$year = $_POST["year"];
$year = substr($year,2); // ex) 2019를 19로 자름
$month = $_POST["month"];
if($month<=9){
  $month="0".$month;
}
$sql = "SELECT * FROM club WHERE club_open='yes' and club_schedule like '$year-$month%'";
$result = mysqli_query($conn, $sql) or die("실패원인12 " . mysqli_error($conn));
$row_count= mysqli_num_rows($result);
   for($i=0; $i<$row_count; $i++){
      $row = mysqli_fetch_array($result);
      $club_num = $row['club_num'];
      $club_name= $row['club_name'];
      $club_schedule= $row['club_schedule']; //ex) 19-05-12, 19-05-19, 19-05-26

      $club_schedule= substr($club_schedule,0,7); // ex) 19-05-12 => 모임 시작일만 자름
      $club_schedule= explode("-",$club_schedule); // -를 기준으로 나눈다
      $schedule[$i]= $club_schedule[2]."/".$club_name."/$club_num"; // $club_schedule[2]= 일
      echo $schedule[$i].",";
   }

?>
