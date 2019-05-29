<?php
  session_start();
  include $_SERVER['DOCUMENT_ROOT']."/moim/lib/db_connector.php";
  include $_SERVER['DOCUMENT_ROOT']."/moim/lib/create_table.php"; //club_DB 생성

  if(isset($_SESSION['userid'])){
    $userid=$_SESSION['userid'];
  }else{
    $userid="";
  }

  if(isset($_GET['mode'])){   // mode 카테고리
    $mode=$_GET['mode'];
  }else{
    $mode="";
  }

$row_length= 150;   //club_intro 150바이트범위 외 ... 으로 생략

 ?>
<!DOCTYPE html>
<html lang="ko" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
    <link rel="stylesheet" href="../css/club.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css" integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
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
      location.replace("../../clubing/source/ing_list.php#top_list_div");
    }

    function call_clublist(){
      location.replace("./list.php#top_list_div");
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
        <li><a href="./list.php">CLUB LIST</a></li>
        <li><a href="./faq/source/faq_list.php">BOARD</a></li>
        <li><a href="#" onclick="message_form();">MESSAGE</a></li>
        <li><a href="#">MY PAGE</a></li>
        <li><a href="#">LOG OUT</a></li>
      </ul>
    </nav>
    <section class="sec1"></section>

    <div class="sub_menu">
      <div class="sub_menubar">
          <a href="./list.php">전체</a>
          <a href="./list.php?mode=글쓰기">글쓰기</a>
          <a href="./list.php?mode=요리">요리</a>
          <a href="./list.php?mode=영화">영화</a>
          <a href="./list.php?mode=미술">미술</a>
          <a href="./list.php?mode=사진">사진</a>
          <a href="./list.php?mode=디자인">디자인</a>
          <a href="./list.php?mode=경제/경영">경제/경영</a>
          <a href="./list.php?mode=취미생활/기타">취미생활/기타</a>
      </div>
    </div>

    <div id="top_list_div">
    <div class="top_list" id="startdiv">
      <div class="top_list_btn">
      <a href="#" onclick="call_clublist()" class="btn club_list_btn">모집중인 모임</a>
      <a href="#" onclick="call_clubing()" class="btn clubing_btn">진행중인 모임</a>
      </div>
      <div class="gallery_h2">
      </div>
    </div>
    </div>

    <section class="gallery" id="gallery_id">
            <?php
            $today = date("Y-m-d", time());    //현재 날짜 (ex:2019-01-01)
            if (!(empty($_GET['mode']))&&(isset($_GET['mode']))){   //카테고리 별 모집모임
              // club 테이블의 club_num 와 cart 테이블의 cart_num가 같은 것 중에서 해당 카테고리와 club_open가 no이고 club_end가 오늘날짜보다 클 때 히트 순으로 검색한다.
              $sql = "SELECT * FROM club LEFT OUTER JOIN cart on cart.cart_club_num=club.club_num where club_category='$mode' and club_open = 'no' and club_end >= '$today' order by club_hit desc;";
              $result = mysqli_query($conn, $sql) or die(mysqli_error($conn));
              $count=mysqli_num_rows($result);
            }else{                                                    // 전체 모집모임
              // club 테이블의 club_num 와 cart 테이블의 cart_num가 같은 것 중에서 club_open가 no이고 club_end가 오늘날짜보다 클 때 히트 순으로 검색한다.
              $sql = "SELECT * FROM club LEFT OUTER JOIN cart on cart.cart_club_num=club.club_num where club_open = 'no' and club_end >= '$today' order by club_hit desc;";
              $result = mysqli_query($conn, $sql) or die(mysqli_error($conn));
              $count=mysqli_num_rows($result);
            }
            for($i=0;$i<$count;$i++){
              $row= mysqli_fetch_array($result);
              $cart_id= $row['cart_id'];
              $club_num= $row['club_num'];
              $club_name=$row['club_name'];
              $club_end=$row['club_end'];
              $club_image_copied=$row['club_image_copied'];
              $club_intro=$row['club_intro'];

              if (strlen($club_intro) > $row_length) {     //club_intro 150바이트범위 외 ... 으로 생략
                $club_intro = substr($club_intro, 0 , $row_length).'<br>.....';
              }
              ?>
            <figure class="gallery_item noshow btm2_item">
              <a href="./view.php?club_num=<?=$club_num?>" id="">
                <?php
                  if($cart_id!==$userid){    //해당된 모임에 찜클릭을 하지 않았을 경우
                 ?>
                  <img src="../../admin/data/<?=$club_image_copied?>" alt="" class="gallery_image">
                 <?php
               }else if($cart_id!=$userid&&$today>=$club_end-5){   //해당된 모임에 찜클릭을 하지 않고 마감일이 다가 올 경우
                 ?>
                 <img src="../../admin/data/<?=$club_image_copied?>" alt="" class="gallery_image">
                 <div class="">마감임박</div>
                 <?php
               }else if($cart_id==$userid&&$today>=$club_end-5){   //해당된 모임에 찜클릭을 했고 마감일이 다가 올 경우
                  ?>
                  <div class="pop">Like It!</div>
                  <img src="../../admin/data/<?=$club_image_copied?>" alt="" class="gallery_image">
                  <div class="">마감임박</div>
                  <?php
               }else{         //해당된 모임에 찜클릭만 했을 경우
                 ?>
                 <div class="pop">Like It!</div>
                 <img src="../../admin/data/<?=$club_image_copied?>" alt="" class="gallery_image">
                 <?php
                  }
                  ?>
                <h3><?=$club_name?></h3>
                <figcaption class="gallery_image_caprion"><?=$club_intro?></figcaption>
              </a>
            </figure>
              <?php
            }
            ?>
        </section>
  </body>
</html>
