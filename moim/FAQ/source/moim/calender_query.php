<?php
session_start();
include $_SERVER['DOCUMENT_ROOT']."/moim/lib/db_connector.php";

if(isset($_GET["mode"]) && $_GET["mode"]=="modal_calendar"){
  $schedule = array();
  $year = $_POST["year"];
  $year = substr($year,2); // ex) 2019를 19로 자름
  $month = $_POST["month"];
  if($month<=9){
    $month="0".$month;
  }
  $agit_name = $_POST["agit_name"];
  $sql = "SELECT * FROM club WHERE club_rent_info like '%/$agit_name'";
  $result = mysqli_query($conn, $sql) or die("실패원인12 " . mysqli_error($conn));
  $row_count= mysqli_num_rows($result);
     for($i=0; $i<$row_count; $i++){
        $row = mysqli_fetch_array($result);
        $club_num = $row['club_num'];
        $club_name= $row['club_name'];
        $club_schedule= $row['club_schedule']; //ex) 19-05-12, 19-05-19, 19-05-26
        $club_open = $row['club_open'];


        // $club_schedule= substr($club_schedule,0,8); // ex) 19-05-12 => 모임 시작일만 자름
        // $club_schedule= explode("-",$club_schedule); // -를 기준으로 나눈다
        // if($club_schedule[2]<=9){
        //   $club_schedule[2]= substr($club_schedule[2],1);
        // }
        $schedule[$i]= $club_schedule."/".$club_name."/".$club_num."/".$club_open;  //$club_schedule[2]= 일
        if($i==$row_count-1){
          echo $schedule[$i];
        }else{
          echo $schedule[$i]."&";
        }
     }
}
 ?>
