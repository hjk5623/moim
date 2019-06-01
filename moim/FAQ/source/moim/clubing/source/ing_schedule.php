<?php
include $_SERVER['DOCUMENT_ROOT']."/moim/lib/db_connector.php";

$data= array();
$sql = "SELECT * FROM club WHERE club_open='yes'";
$statement= $conn->prepare($sql);
$statement-> execute();
$result= $statement->get_result();
foreach($result as $row){
  $club_schedule= $row["club_schedule"];
  // $schedule= $club_schedule.substr(0,8);
  $schedule= substr($club_schedule,0,8);
  $data[]= array(
    'title' =>$row['club_name'],
    'url'   =>'http://localhost/moim_13/clubing/source/ing_view.php?club_num='.$row["club_num"],
    'start' =>"20$schedule"
  );
}
echo json_encode($data);
?>
