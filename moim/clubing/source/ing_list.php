<?php
session_start();
 include $_SERVER['DOCUMENT_ROOT']."/moim/lib/db_connector.php";
 include $_SERVER['DOCUMENT_ROOT']."/moim/lib/create_table.php";

create_table($conn, 'club');

 if(isset($_GET["mode"])){
   $mode= $_GET["mode"];
 }else{
   $mode= "";
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
        <li><a href="../../mainpage.php">HOME</a></li>
        <li><a href="#">LOG OUT</a></li>
        <li><a href="#">CLUB LIST</a></li>
        <li><a href="#">INTRO</a></li>
        <li><a href="#">MY PAGE</a></li>
        <li><a href="#">HOME</a></li>
        <li><a href="#">HOME</a></li>
      </ul>
    </nav>
    <section class="sec1"></section>
    <section class="sec2">
      <h1>모집 모임1</h1>
      <p>안녕하세요 모집 모임 1 소개 샘플입니다.</p>
    </section>
    <section>
      <ul>
        <li><a href="ing_list.php">전체</a></li>
        <li><a href="ing_list.php?mode=write">글쓰기</a></li>
        <li><a href="ing_list.php?mode=cook">요리</a></li>
        <li><a href="ing_list.php?mode=movie">영화</a></li>
        <li><a href="ing_list.php?mode=art">미술</a></li>
      </ul>
    </section>
    <section>
      <?php
      if(!empty($mode)&&isset($mode)){
        $sql = "select * from club where club_category='$mode' order by club_hit desc";
      }else{
        $sql = "select * from club order by club_hit desc";
      }
          $result = mysqli_query($conn, $sql) or die(mysqli_error($conn));
          $row_count= mysqli_num_rows($result);

          for($i=1; $i<=$row_count; $i++){
            $row= mysqli_fetch_array($result);
            $club_num= $row['club_num'];
            $club_name= $row['club_name'];
            $club_image_name= $row['club_image_name'];
    ?>
          	<a href="./ing_view.php?no=<?=$club_num?>">
              <div id="list">
          			<div class=""><img src="../img/<?=$club_image_name?>"></div>
          			<div class=""><b><?=$club_name?></b></div><br>
              </div>
            </a>
      <?php
          }
      ?>
    </section>
  </body>
</html>
