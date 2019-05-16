<?php
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
  </head>
  <body>
    모임 카테고리
    <a href="./list.php">전체</a>
    <a href="./list.php?mode=영화">영화</a>
    <a href="./list.php?mode=문학">문학</a>
    <a href="./list.php?mode=요리">요리</a>
    <a href="./list.php?mode=음악">음악</a>
    <a href="./list.php?mode=술">술</a>
    <a href="./list.php?mode=세미나">세미나</a>
    <a href="./list.php?mode=축구">축구</a>
    <a href="./list.php?mode=농구">농구</a>
    <section>
      <?php
      if (isset($mode)&& $_GET['mode']) {
        $sql = "select * from club where club_category='$mode' order by club_hit desc";
        $result = mysqli_query($conn, $sql) or die(mysqli_error($conn));
        $count=mysqli_num_rows($result);
      }else{
        $sql = "select * from club order by club_hit desc";
        $result = mysqli_query($conn, $sql) or die(mysqli_error($conn));
        $count=mysqli_num_rows($result);
      }
        for($i=0;$i<$count;$i++){
          $row= mysqli_fetch_array($result);
          $club_num= $row['club_num'];
          $club_name=$row['club_name'];
          $image=$row['club_image'];
          ?>
        <a href="./view.php?club_num=<?=$club_num?>" id="">
        <img src="../img/<?=$image?>" width="350px" height="400px">
        </a>
        <div class=""><b><?=$club_name?></b></div>
        <?php
        }

        ?>
    </section>
  </body>
</html>
