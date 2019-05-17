<?php
session_start();
 include $_SERVER['DOCUMENT_ROOT']."/moim/lib/db_connector.php";
 include $_SERVER['DOCUMENT_ROOT']."/moim/lib/create_table.php";

create_table($conn, 'club');

 if(isset($_GET["no"])){
   $no= $_GET["no"];
 }else{
   $no= "";
 }
?>
<!DOCTYPE html>
<html lang="ko" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
    <link rel="stylesheet" href="../css/club.css">
  </head>
  <body>
    <nav>
      <div class="brand">
        <h2>Mo,im</h2>
      </div>
      <ul>
        <li><a href="../mainpage.php">HOME</a></li>
        <li><a href="#">LOG OUT</a></li>
        <li><a href="#">CLUB LIST</a></li>
        <li><a href="#">INTRO</a></li>
        <li><a href="#">MY PAGE</a></li>
        <li><a href="#">HOME</a></li>
        <li><a href="#">HOME</a></li>
      </ul>
    </nav>
    <section>
      <?php
      if(!empty($no) && isset($no)){
        $sql = "select * from club where club_num='$no'";
      }
      $result = mysqli_query($conn, $sql) or die(mysqli_error($conn));
      $row= mysqli_fetch_array($result);

      $club_name= $row['club_name'];
      $club_content= $row['club_content'];
      $club_category= $row['club_category'];
      $club_price= $row['club_price'];
      $club_to= $row['club_to'];
      $club_rent_info= $row['club_rent_info'];
      $club_start= $row['club_start'];
      $club_end= $row['club_end'];
      $club_apply= $row['club_apply'];
      $club_schedule= $row['club_schedule'];
      $club_hit= $row['club_hit']+1;
      $club_open= $row['club_open'];
      $club_image_name= $row['club_image_name'];
      $club_file_name= $row['club_file_name'];

      $sql= "update club set club_hit=$club_hit where club_num=$no";
      mysqli_query($conn, $sql) or die(mysqli_error($conn));
      ?>
      <a href="./ing_list.php?mode=<?=$club_category?>"><?=$club_category?></a>
      <h1><?=$club_name?></h1>
      <p>안녕하세요 <?=$club_name?>입니다</p>
      <img src="../img/<?=$club_image_name?>"><br>
      수업 시작일: <?=$club_start?><br>
      수업 종료일: <?=$club_end?><br><br>
      내용: <?=$club_content?><br>
      <img src="../img/<?=$club_image_name?>"><br>
      <img src="../img/<?=$club_image_name?>"><br>
      모임 장소: 왕십리역 2번출구
    </section>
  </body>
</html>
