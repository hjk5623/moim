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
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title></title>
    <link rel="stylesheet" href="../css/club.css">
    <link href="https://fonts.googleapis.com/css?family=Noto+Sans+KR" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
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

  <section class="sec10"></section>

  <div id="intd_warp">
    <div class="sline">
      <ul>
        <li><a href="ing_list.php">전체</a></li>
        <li><a href="ing_list.php?mode=write">글쓰기</a></li>
        <li><a href="ing_list.php?mode=cook">요리</a></li>
        <li><a href="ing_list.php?mode=movie">영화</a></li>
        <li><a href="ing_list.php?mode=art">미술</a></li>
      </ul>
    </div>

    <section class="bmt-section" id="startdiv">
      <div class="pt1">
      <p class="title_large">모든 모임 보기</p>
      </div>
      <div class="pt2 btm20">
      <p class="p2_desc_text">진행 중인 모든 모임을 보여줍니다.</p>
      </div>
    </section>

    <section class="scroll-sec">
      <div class="img-table">
        <ul id="ullist">

          <?php
            $sql= "select * from club order by club_hit desc";
            $result= mysqli_query($conn, $sql) or die(mysqli_error($conn));
            $row_count= mysqli_num_rows($result);
            for($i=1; $i<=$row_count; $i++){
              $row= mysqli_fetch_array($result);
              $club_num= $row['club_num'];
              $club_name= $row['club_name'];
              $club_image_name= $row['club_image_name'];
          ?>
                <li class="btm2_item noshow">
                  <div class="container">
                    <div class="box">
                      <img src="../img/<?=$club_image_name?>" class="btm2_image">
                    </div>
                      <a href="./ing_view.php?no=<?=$club_num?>" class="club_info">
                      <div class="inner">
                        <h4 class="btm2_head">다양한 스킨</h4>
                      </div>
                      <p class="btm2_desc"><?=$club_name?></p>
                      <!-- <div class="details">
                        <div class="content">
                        <h2>모임1의 이름</h2>
                        <p>모임1의 정보입니다.간단한 정보와 이름, 특징을 나타내는 곳입니다.</p>
                        </div>
                      </div> -->
                    </a>
                  </div>
                </li>
          <?php
              }
          ?>

        </ul>
      </div>
    </section>
  </div>
  </body>
</html>
