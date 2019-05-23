<?php
  session_start();
  include $_SERVER['DOCUMENT_ROOT']."/moim/lib/create_table.php"; //club_DB 생성
  include $_SERVER['DOCUMENT_ROOT']."/moim/lib/db_connector.php";

  if(isset($_SESSION['userid'])){
    $userid=$_SESSION['userid'];
  }else{
    $userid="";
  }

  if(isset($_GET['mode'])){
    $mode=$_GET['mode'];
  }else{
    $mode="";
  }

$row_length= 150;

 ?>
<!DOCTYPE html>
<html lang="ko" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
    <link rel="stylesheet" href="../css/club.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script type="text/javascript" src="../js/menu.js"></script>
  </head>
  <body>
    <nav class="top_nav">
      <div class="brand">
        <a href="../../mainpage.php">
        <h2>Mo,im</h2>
        </a>
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

    <div class="sub_menu">
      <div class="sub_menubar">
          <a href="./list.php">전체</a>
          <a href="./list.php?mode=영화">영화</a>
          <a href="./list.php?mode=문학">문학</a>
          <a href="./list.php?mode=요리">요리</a>
          <a href="./list.php?mode=음악">음악</a>
          <a href="./list.php?mode=술">술</a>
          <a href="./list.php?mode=세미나">세미나</a>
          <a href="./list.php?mode=축구">축구</a>
          <a href="./list.php?mode=농구">농구</a>
      </div>
    </div>


    <section class="promotion-section-two">
      <div class="about-area-two">
        <h2></h2>
        <div class="about-box-two">
          <ul class="place-list-two">
            <?php
            $today = date("Y-m-d", time());
            if (!(empty($_GET['mode']))&&(isset($_GET['mode']))){
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
              $club_image_copied=$row['club_image_copied'];
              $club_intro=$row['club_intro'];

              if (strlen($club_intro) > $row_length) {
                $club_intro = substr($club_intro, 0 , $row_length).'<br>.....';
              }
              ?>
            <li>
              <a href="./view.php?club_num=<?=$club_num?>" id="">
                <img class="top-place-two" src="../../admin/data/<?=$club_image_copied?>">
                <h3><?=$club_name?></h3>
                <p class="txt-two"><?=$club_intro?></p>
                <span class="view-two">더보기</span>
              </a>
            </li>
              <?php
            }

            ?>

          </ul>
        </div>
        </div>
    </section>
  </body>
</html>
