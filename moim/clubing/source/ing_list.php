<?php
session_start();
 include $_SERVER['DOCUMENT_ROOT']."/moim/lib/db_connector.php";
 include $_SERVER['DOCUMENT_ROOT']."/moim/lib/create_table.php";

create_table($conn, 'club');

$mode= (isset($_GET["mode"])) ? $_GET["mode"] : "";
?>

<!DOCTYPE html>
<html lang="ko" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>clubing list- 보미</title>
    <link rel="stylesheet" href="../css/club.css">
    <link href="https://fonts.googleapis.com/css?family=Noto+Sans+KR" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
    <script type="text/javascript" src="../js/menu.js"></script>
    <script>
      var startHeightMin=0; //트리거 시작 스크롤 위치
      var itemHeight=100; // 아이템별 높이
      var itemMax=0; //현재 표시 아이템수
      var itemLimit=0; // 모든 아이템 수
      jQuery(window).scroll(function() {
      itemLimit=jQuery('.btm2_item').length; // 모든 아이템수 btm2_item css class 가 표시될 객채 li
      if(itemMax > itemLimit){ //표시 아이템 수가 모든 아이템수보다 높으면 작동 하지 말아야..
          return;
      }
      cehcksc();
      });
      function cehcksc(){
      //#startdiv 는 해당 객채를 지나가면 작동을 한다 알맞게 변경 (트리거)
          if (jQuery(window).scrollTop() >= ((jQuery(document).height() - jQuery(window).height()) - jQuery('#startdiv').innerHeight())) {
                //console.log(jQuery(window).scrollTop()); // startHeightMin 찾기
              var docHeight=jQuery(window).scrollTop() - startHeightMin;
              var itemLength=Math.floor(docHeight/itemHeight); // 스크롤 위치에서 시작 스크롤 위치를 -,출력할 아이템수를 설정
              if(itemMax<itemLength){ // 수가 낮아 졌을때는 표시 안함
                  itemMax=itemLength; // itemMax 갱신
                  jQuery('.btm2_item').each(function(index,item){ //btm2_item
                      if((itemMax-1) >= index){
                          if(jQuery(this).css("display") == "none"){
                              jQuery(this).fadeIn(2000);
                          }
                      }
                  });
              }
            }
        }
    </script>
    <script>
    function call_clubing(){
      location.replace("./ing_list.php#top_list_div");
    }

    function call_clublist(){
      location.replace("../../club_list/source/list.php#top_list_div");
    }
    </script>
  </head>
  <body>
    <nav class="top_nav">
      <div class="brand">
        <a href="../../mainpage.php">
        <h2>Mo,im</h2>
        </a>
      </div>
      <ul>
        <li><a href="../../club_list/source/list.php">CLUB LIST</a></li>
        <li><a href="../../faq/source/faq_list.php">BOARD</a></li>
        <li><a href="#" onclick="message_form();">MESSAGE</a></li>
        <?php
        if(isset($_SESSION['userid'])){
          echo "<li><a href='../../mypage/source/user_check.php'>MY PAGE</a></li>";
        }
         ?>
        <?php
        if(!isset($_SESSION['userid'])){
          echo ('<li><a href="../../login/source/login.php">LOG IN</a></li>');
        }else{
          echo ('<li><a href="../../login/source/logout.php">LOG OUT</a></li>');
        }
        ?>
      </ul>
    </nav>

    <section class="sec1"></section>

    <div class="sub_menu">
      <div class="sub_menubar">
        <a href="ing_list.php">전체</a>
        <a href="ing_list.php?mode=글쓰기">글쓰기</a>
        <a href="ing_list.php?mode=요리">요리</a>
        <a href="ing_list.php?mode=영화">영화</a>
        <a href="ing_list.php?mode=미술">미술</a>
        <a href="ing_list.php?mode=사진">사진</a>
        <a href="ing_list.php?mode=디자인">디자인</a>
        <a href="ing_list.php?mode=경제/경영">경제/경영</a>
        <a href="ing_list.php?mode=취미생활&기타">취미생활&기타</a>
        <a href="ing_list.php?mode=calendar" id=cal_click>달력</a>
      </div>
    </div> <!--end of sub_menu-->

    <?php
    if(isset($mode) && $mode==="calendar"){
      include $_SERVER['DOCUMENT_ROOT']."/moim/clubing/source/ing_calendar.php";
    }
    ?>

    <div id="top_list_div">
      <div class="top_list" id="startdiv">
        <div class="top_list_btn">
          <a href="#" onclick="call_clublist()" class="btn club_list_btn">모집중인 모임</a>
          <a href="#" onclick="call_clubing()" class="btn clubing_btn">진행중인 모임</a>
        </div>
        <div class="gallery_h2"></div>
      </div>
    </div>

    <section class="gallery" id="gallery_id">
      <?php
      $today= substr(date("Y-m-d"),2); //오늘날짜를 19-05-27 형태로 만든다.
      if(!empty($mode)&&isset($mode)){
        //카테고리를 선택한 경우
        $sql = "SELECT * FROM club WHERE club_category='$mode' and club_open='yes' and SUBSTRING(`club_schedule`,-8,8) > '$today' ORDER BY club_hit desc";
      }else{
        //전체보기
        $sql = "SELECT * FROM club WHERE club_open='yes' and SUBSTRING(`club_schedule`,-8,8) > '$today' ORDER BY club_hit desc";
      }
      $result= mysqli_query($conn, $sql) or die(mysqli_error($conn));
      $row_count= mysqli_num_rows($result);
      for($i=1; $i<=$row_count; $i++){
        $row= mysqli_fetch_array($result);
        $club_num= $row['club_num'];
        $club_name= $row['club_name'];
        $club_category= $row['club_category'];
        $club_image_copied=$row['club_image_copied'];
        $club_intro=$row['club_intro'];

        $row_length= 150;

        if (strlen($club_intro) > $row_length) {
          $club_intro = substr($club_intro, 0 , $row_length).'<br>.....';
      }
      ?>
      <figure class="gallery_item noshow btm2_item">
        <a href="./ing_view.php?club_num=<?=$club_num?>&mode=<?=$club_category?>" id="">
          <img src="../../admin/data/<?=$club_image_copied?>" alt="" class="gallery_image">
          <h3><?=$club_name?></h3>
          <figcaption class="gallery_image_caprion"><?=$club_intro?></figcaption>
        </a>
      </figure>
      <?php
    } //end of for
      ?>
    </section><!--end of gallery-->
  </body>
</html>
