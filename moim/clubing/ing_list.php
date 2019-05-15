
<!DOCTYPE html>
<html lang="ko" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
    <link rel="stylesheet" href="./css/club.css">
  </head>
  <body>
    <nav>
      <div class="brand">
        <h2>Mo,im</h2>
      </div>
      <ul>
        <li><a href="#">HOME</a></li>
        <li><a href="#">LOG OUT</a></li>
        <li><a href="#">CLUB LIST</a></li>
        <li><a href="#">INTRO</a></li>
        <li><a href="#">HOME</a></li>
        <li><a href="#">HOME</a></li>
        <li><a href="#">HOME</a></li>
      </ul>
    </nav>
    <section class="sec1"><section>
    <section class="sec2">
      <ul>
        <li><a href="shopmain.php">전체</a></li>
        <li><a href="shopmain.php?mode=clothe">글쓰기</a></li>
        <li><a href="shopmain.php?mode=cosmetics">요리</a></li>
        <li><a href="shopmain.php?mode=acc">영화</a></li>
        <li><a href="shopmain.php?mode=travel">미술</a></li>
      </ul>
      <?php
      if(!empty($mode)&&isset($mode)){
        $sql = "select * from club where club_category='$mode' order by hit desc";
      }else{
        $sql = "select * from club order by hit desc";
      }
          $result = mysqli_query($con, $sql) or die(mysqli_error($con));

          for($i=1;$i<13;$i++){ //신상품 12개 정렬
            $row= mysqli_fetch_array($result);
            $club_name=$row['club_name'];
            $club_image=$row['club_image'];
    ?>
          	<a href="./list.php">
              <div>
          			<div class=""><img src="../img/<?=$image?>" width="350px" height="400px"></div>
          			<div class=""><b><?=club_name?></b></div><br>
              </div>
            </a>
      <?php
          }
      ?>
    <section>
  </body>
</html>
