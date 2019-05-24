<?php
session_start();
 include $_SERVER['DOCUMENT_ROOT']."/moim/lib/db_connector.php";
 include $_SERVER['DOCUMENT_ROOT']."/moim/lib/create_table.php";
create_table($conn, 'club');
create_table($conn, 'club_ripple');

 if(isset($_GET["club_num"])){
   $club_num= $_GET["club_num"];
 }else{
   $club_num= "";
 }

  if(!empty($club_num) && isset($club_num)){
    $sql = "select * from club where club_num='$club_num'";
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
  $club_intro= $row['club_intro'];

  $sql= "update club set club_hit=$club_hit where club_num=$club_num";
  mysqli_query($conn, $sql) or die(mysqli_error($conn));

?>
<!DOCTYPE html>
<html lang="ko" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>clubing list- 보미</title>
    <link rel="stylesheet" href="../css/club.css">
    <link rel="stylesheet" href="../css/club_view.css">
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
    <section class="club_view_sec">
      <div class="club_view"> <!---->
        <div class="club_info">
          <div class="club_img">
            <div class="club_view_name"><b><?=$club_name?></b></div>
            <img src="../img/clubing01.jpg" width="500px" height="400px"><!--테스트 후 아래것으로 교체하기-->
            <!-- <img src="../../admin/data/<?=$club_image_copied?>" width="500px" height="400px"> -->
          </div>
          <div class="club_div">
             <div class="club_view_price"><b>가격:<?=$club_price?>원</b></div>
             <div class="club_view_apply"><b>신청인원:<?=$club_apply?>/<?=$club_to?>명</b></div>
             <div class=""><b>신청기간:<?=$club_start?>~<?=$club_end?></b></div>
             <div class=""><b>모임날짜:<?=$club_schedule?></b></div>
             <div class=""><b>장소:<?=$club_rent_info?></b></div>
             <div class="club_view_intro"><b><?=$club_intro?></b></div>
           </div>
        </div><!--club_info-->
        <hr class="divider">

        <div class="club_view_content"><b><?=$club_content?></b></div>
        <div class="club_view_copied"><b>세부사항:
        <?php
          //1. 해당된 가입자이고, 파일이 있으면 파일명,사이즈,실제위치 정보확인
          if(!empty($_SESSION['userid'])&&!empty($club_file_copied)){
            $mode="download";
            $file_path= "../../admin/data/$club_file_copied";
            $file_size= filesize($file_path);

            //2. 업로드된 이름을 보여주고 [저장] 할것인지 선택
            echo ("
            $club_file_name ($file_size Byte)
            <a href='query.php?mode=$mode&club_num=$club_num'>저장</a>
            ");
          }//end of if
        ?>
      </b></div> <!--end of club_view_copied-->
      <?php
      $club_rent_info=explode("/",$club_rent_info);
      $address=$club_rent_info[0];
      ?>
      <hr class="divider">
      <div class="club_view_map">
        <div class="place">
          <p>장소</p>
        </div>
        <!-- <p style="margin-top:12px"> -->
            <!-- <em class="link">
            <a href="javascript:void(0);" onclick="window.open('http://fiy.daum.net/fiy/map/CsGeneral.daum', '_blank', 'width=981, height=650')">
            혹시 주소 결과가 잘못 나오는 경우에는 여기에 제보해주세요.
          </a>
        </em>  -->
         <!-- </p> -->
        <div id="map"></div>
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
    </div><!--club_view_map-->
    </section> <!--end of club_view_sec-->

    <div class="ripple"> <!--임시 클래스명임. 바꿀겁니다-->
      <p class="ss_title">후기</p>
      <!-- 후기 입력폼 -->
      <form name="ripple_form" action="ing_query.php?mode=c_insert_ripple&club_num=<?=$club_num?>" method="post">
      <!-- <form name="ripple_form" method="post"> -->
        <div id="ripple_insert">
          <div id="ripple_textarea">
            <textarea name="c_ripple_content" id="c_ripple_content" placeholder="후기를 작성해주세요."></textarea>
            <button type="submit" name="button" id="ripple_btn">후기 등록</button>
          </div>
        </div><!--end of ripple_insert  -->
      </form>
        <div> <!-- 작성된 후기를 보여주는 부분 -->
          <ul>
            <!-- <li class="col-md-6 col-md-offset-3 results"></li> -->
            <li class="results"></li>
            <!-- 후기작성자만 (자기글)삭제버튼이 보임 & 관리자는 모든 후기 삭제가능 -->

          </ul>
          <div>
            <button type="button" class="btn btn-default" id="loadmorebtn" name="button">더 보기</button>
          </div>
        </div>
        <input type="hidden" id="hidden_num" value="<?=$club_num?>">
        <script type="text/javascript"> <!--후기 더보기-->

          var hidden_num = $("#hidden_num").val();
          var mypage= 1;
          mycontent(mypage);
          $('#loadmorebtn').click(function(event) {
            mypage++;
            mycontent(mypage);
          });
          function mycontent(mypage){
            $.post('loadmore.php?club_num='+hidden_num, {page: mypage}, function(data) {
              if(data.trim().length==0){
                $('#loadmorebtn').text("더보기").hide()
              }
              $('.results').append(data)
              // $("html, body").animate({scrollTop: $('#loadmorebtn').offset().tap}, 800)
            })
          }//end of mycontent
        </script>

    </div> <!-- end of ripple -->
       </section>

       <section class="bmt-section" id="sec4">
         <div class="pt1">
         <p class="title_large">모든 모임 보기</p>
         </div>
         <div class="pt2 btm20">
         <p class="p2_desc_text">진행 중인 모든 모임을 보여줍니다.</p>
         </div>
       </section>

       <section class="scroll-sec promotion-section-two">
         <div class="img-table about-box-two"> <!--여기서부터 목록-->
           <div class="about-area-two">
             <h2></h2>
           <!-- <ul id="ullist" class="place-list-two"> -->
           <ul class="place-list-two">
             <?php
             if(!empty($mode)&&isset($mode)){
               $sql = "SELECT * FROM club WHERE club_category='$mode' and club_open='yes' ORDER BY club_hit desc";
             }else{
               $sql = "SELECT * FROM club WHERE club_open='yes' ORDER BY club_hit desc";
             }
               $result= mysqli_query($conn, $sql) or die(mysqli_error($conn));
               $row_count= mysqli_num_rows($result);
               for($i=1; $i<=$row_count; $i++){
                 $row= mysqli_fetch_array($result);
                 $club_num= $row['club_num'];
                 $club_name= $row['club_name'];
                 // $club_image_name= $row['club_image_name'];
                 $club_image_copied=$row['club_image_copied'];
                 $club_intro=$row['club_intro'];

                 $row_length= 150;

                 if (strlen($club_intro) > $row_length) {
                   $club_intro = substr($club_intro, 0 , $row_length).'<br>.....';
                 }
             ?>
             <li>
               <a href="./ing_view.php?club_num=<?=$club_num?>" id="">
                 <img class="top-place-two" src="../../admin/data/<?=$club_image_copied?>">
                 <h3><?=$club_name?></h3>
                 <p class="txt-two"><?=$club_intro?></p>
                 <span class="view-two">더보기</span>
               </a>
             </li>
                   <!-- <li class="btm2_item noshow">
                     <div class="container">
                       <div class="box">
                         <img src="../img/<?=$club_image_name?>" class="btm2_image">
                       </div>
                         <a href="./ing_view.php?club_num=<?=$club_num?>" class="club_info">
                         <div class="inner">
                           <h4 class="btm2_head">다양한 스킨</h4>
                         </div>
                         <p class="btm2_desc"><?=$club_name?></p>
                       </a>
                     </div>
                   </li> -->
             <?php
                 }
             ?>
           </ul>
         </div><!--end of about-area-two-->
       </div><!--end of about-box-two-->
        </div><!--end of club_view-->
       </section><!--end of scroll-sec-->
     </div><!--end of club_view-->
  </body>
</html>
