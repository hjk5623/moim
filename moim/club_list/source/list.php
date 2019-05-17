<?php
  session_start();
  include $_SERVER['DOCUMENT_ROOT']."/moim/lib/create_table.php"; //club_DB 생성
  include $_SERVER['DOCUMENT_ROOT']."/moim/lib/db_connector.php";
  create_table($conn,'club');

  if(isset($_GET['mode'])){
    $mode=$_GET['mode'];
  }else{
    $mode="";
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
        <li><a href="./list.php">CLUB LIST</a></li>
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
      모임 카테고리
      <ul>
        <li><a href="./list.php">전체</a></li>
        <li><a href="./list.php?mode=영화">영화</a></li>
        <li><a href="./list.php?mode=문학">문학</a></li>
        <li><a href="./list.php?mode=요리">요리</a></li>
        <li><a href="./list.php?mode=음악">음악</a></li>
        <li><a href="./list.php?mode=술">술</a></li>
        <li><a href="./list.php?mode=세미나">세미나</a></li>
        <li><a href="./list.php?mode=축구">축구</a></li>
        <li><a href="./list.php?mode=농구">농구</a></li>
      </ul>
    </section>

    <section>
      <?php
      $today = date("Y-m-d", time());
      if (isset($mode)&& $_GET['mode']) {
        $sql = "select * from club where club_category='$mode' and club_open = 'no' and club_end >= '$today' order by club_hit desc";
        $result = mysqli_query($conn, $sql) or die(mysqli_error($conn));
        $count=mysqli_num_rows($result);
      }else{
        $sql = "select * from club where club_open = 'no' and club_end >= '$today' order by club_hit desc";
        $result = mysqli_query($conn, $sql) or die(mysqli_error($conn));
        $count=mysqli_num_rows($result);
      }
        for($i=0;$i<$count;$i++){
          $row= mysqli_fetch_array($result);
          $club_num= $row['club_num'];
          $club_name=$row['club_name'];
          $club_image_name_0=$row['club_image_name'];
          $club_image_copyied=$row['club_image_copyied'];
          ?>
        <a href="./view.php?club_num=<?=$club_num?>" id="">
        <img src="../../img/<?=$club_image_copyied?>" width="350px" height="400px">
        </a>
        <div class=""><b><?=$club_name?></b></div>
        <?php
        }

        ?>
    </section>
  </body>
</html>
