<?php
session_start();
 include $_SERVER['DOCUMENT_ROOT']."/moim/lib/db_connector.php";
 include $_SERVER['DOCUMENT_ROOT']."/moim/lib/create_table.php";
create_table($conn, 'club');
create_table($conn, 'club_ripple');

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
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title></title>
    <link rel="stylesheet" href="../css/club.css">
    <link href="https://fonts.googleapis.com/css?family=Noto+Sans+KR" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
    <script>
      var startHeightMin=788; //트리거 시작 스크롤 위치
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
          if (jQuery(window).scrollTop() >= ((jQuery(document).height() - jQuery(window).height()) - jQuery('#startdiv').innerHeight())-100) {
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

  <?php
  if(!empty($no) && isset($no)){
    $sql = "select * from club where club_num='$no'";
  }
  $result = mysqli_query($conn, $sql) or die(mysqli_error($conn));
  $row= mysqli_fetch_array($result);

  $club_num= $row['club_num'];
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
  $club_rent_info= explode("/",$club_rent_info);
  $address= $club_rent_info[0];
  $sql= "update club set club_hit=$club_hit where club_num=$no";
  mysqli_query($conn, $sql) or die(mysqli_error($conn));
  ?>

  <div id="intd_warp">
    <div class="sline"></div>
    <br>
    <br>
    <br>
    <br>
    <div class="titles">
      <p class="title_large"><?=$club_name?></p> <!--모임이름-->
      <img src="../img/<?=$club_image_name?>" alt="" class="title-img"> <!--모임이미지-->
    </div>
    <div class="">
      <?php
      if(!empty($_SESSION['userid']) && $_SESSION['userid']==="admin"){ ?>
        <button type="button" name="button">수정</button>
        <button type="button" name="button" onclick="location.href='ing_query.php?mode=c_delete&no=<?=$club_num?>'">삭제</button>
      <?php } ?>
    </div>
    <section id="sec1" class="bmt-section bmt-section--no-border">
    <div class="pt2 ">
    <ul class="btm_list">
          <li class="btm_item">
            <h4 class="btm_head">모임 특징</h4>
            <p class="btm_desc">모임특징샘플입니다. 이 모임은 여행을 하는 모임입니다.</p>
          </li>
          <li class="btm_item">
            <h4 class="btm_head">모집 기간</h4>
            <p class="btm_desc"><?=$club_start?> ~ <?=$club_end?></p>
          </li>
          <li class="btm_item">
            <h4 class="btm_head">가격</h4>
            <p class="btm_desc"><?=$club_price?></p>
          </li>
        </ul>
    </div>
    </section>

    <section class="bmt-section ">
      <div class="pt1">
      <p class="title_large">상세 정보</p>
      </div>
      <div class="pt2">
      <p class="p2_desc_text"><?=$club_name?>의 상세 정보입니다.</p>
      </div>

      <div class="ss_left"  id="startdiv">
        <p class="ss_title"><?=$club_name?>의 첫번째 특징</p>
        <p class="ss_desc"><?=$club_name?>의 첫번째 특징은 남녀노소 모집을 하고 있고 일상에서 벗어나 각자의 취미와 장점을 드러내어
        사람들과 공유할 수 있습니다.</p>

        <p class="ss_title mgt30"><?=$club_name?>의 두번째 특징</p>
        <p class="ss_desc"><?=$club_name?>의 두번째 특징은 자유로운 시간에 즐길 수 있고 퇴근 시간 및 주말에도 함께 즐길 수 있습니다.</p>
      </div>
      <div id="map" style="width:700px;height:350px;"></div>
      <script type="text/javascript" src="//dapi.kakao.com/v2/maps/sdk.js?appkey=9a321e1b83ba2a8b469c05bab1c41988&libraries=services"></script>
      <script>
      var mapContainer = document.getElementById('map'), // 지도를 표시할 div
      mapOption = {
       center: new daum.maps.LatLng(33.450701, 126.570667), // 지도의 중심좌표
       level: 3 // 지도의 확대 레벨
      };
     // 지도를 생성합니다
      var map = new daum.maps.Map(mapContainer, mapOption);
    // 주소-좌표 변환 객체를 생성합니다
      var geocoder = new daum.maps.services.Geocoder();
     // 주소로 좌표를 검색합니다
      geocoder.addressSearch('<?=$address?>', function(result, status) {
       // 정상적으로 검색이 완료됐으면
      if (status === daum.maps.services.Status.OK) {
        var coords = new daum.maps.LatLng(result[0].y, result[0].x);
        // 결과값으로 받은 위치를 마커로 표시합니다
        var marker = new daum.maps.Marker({
          map: map,
          position: coords
        });
        // 인포윈도우로 장소에 대한 설명을 표시합니다
        var infowindow = new daum.maps.InfoWindow({
          content: '<div style="width:150px;text-align:center;padding:6px 0;">모임장소</div>'
        });
        infowindow.open(map, marker);
        // 지도의 중심을 결과값으로 받은 위치로 이동시킵니다
        map.setCenter(coords);
       }
     });
   </script>
 </div>
 <div class="">
   <p class="ss_title">후기</p>
   <?php
     $sql="SELECT * FROM `club_ripple` WHERE c_parent_num='$club_num'";
     $ripple_result = mysqli_query($conn,$sql);
     while($ripple_row= mysqli_fetch_array($ripple_result)){
       $c_ripple_num= $ripple_row['c_ripple_num'];
       $c_parent_num= $club_num;
       $c_ripple_name= $ripple_row['c_ripple_name'];
       $c_ripple_date= $ripple_row['c_ripple_date'];
       $c_ripple_content= $ripple_row['c_ripple_content'];
       $c_ripple_content= str_replace("\n", "<br>", $c_ripple_content);
       $c_ripple_content= str_replace(" ", "&nbsp;", $c_ripple_content);
   ?>
     <div id="ripple_title">
       <ul>
         <li><?=$c_ripple_name."&nbsp;&nbsp;".$c_ripple_date?></li>
         <li id="del_btn">
           <button type="button" name="button" onclick="location.href='ing_query.php?mode=c_delete_ripple&no=<?=$no?>&name=<?=$c_ripple_name?>&c_ripple_num=<?=$c_ripple_num?>'">삭제</button>
         </li>
       </ul>
     </div>
     <div id="c_ripple_content">
       <?=$c_ripple_content?>
     </div>
   <?php
     }//end of while
   ?>
   <form name="ripple_form" action="ing_query.php?mode=c_insert_ripple&no=<?=$no?>" method="post">
     <!-- <input type="hidden" name="parent" value="<?=$q_num?>"> -->
     <div id="ripple_insert">
       <div id="ripple_textarea"><textarea name="c_ripple_content" rows="3" cols="80"></textarea></div>
       <div id="ripple_button"><button type="submit" name="button">후기 등록</button></div>
     </div><!--end of ripple_insert  -->
   </form>
 </div>
    </section>

    <section class="bmt-section" id="sec4">
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
            $sql = "select * from club order by club_hit desc";
            $result = mysqli_query($conn, $sql) or die(mysqli_error($conn));
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
                      <a href="#" class="club_info">
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
              mysqli_close($conn);
          ?>

        </ul>
      </div>
    </section>
  </div>

    <section class="sec1"></section>
    <section class="sec2">
      <!-- <h1>모집 모임1</h1>
      <p>안녕하세요 모집 모임 1 소개 샘플입니다.</p> -->
    </section>
    <section class="sec3">
      <!-- <ul>
        <li><a href="ing_list.php">전체</a></li>
        <li><a href="ing_list.php?mode=clothe">글쓰기</a></li>
        <li><a href="ing_list.php?mode=cosmetics">요리</a></li>
        <li><a href="ing_list.php?mode=acc">영화</a></li>
        <li><a href="ing_list.php?mode=travel">미술</a></li>
      </ul> -->
    </section>
  </body>
</html>
