<?php
session_start();
include $_SERVER['DOCUMENT_ROOT']."/moim/lib/db_connector.php";

if(isset($_GET['club_num'])){
  $club_num=$_GET['club_num'];
}else{
  $club_num="";
  echo "<script>alert('실패');</script>";
}

if(isset($_GET['club_category'])){
  $mode=$_GET['club_category'];
}else{
  $mode="";
}

var_dump($userid);
$sql = "select * from club where club_num=$club_num";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_array($result);

$club_name = $row['club_name'];
$club_price = $row['club_price'];
$club_content =$row['club_content'];
$club_rent_info =$row['club_rent_info'];
$club_to =$row['club_to'];
$club_apply =$row['club_apply'];
$club_start =$row['club_start'];
$club_end =$row['club_end'];
$club_schedule =$row['club_schedule'];
$hit= $row['club_hit']+1;
$club_image_name_0=$row['club_image_name'];
$club_image_copyied=$row['club_image_copyied'];

//클릭한 상품의 조회수 업데이트
$sql= "update club set club_hit=$hit where club_num=$club_num";
mysqli_query($conn, $sql) or die(mysqli_error($conn));

 ?>
 <!DOCTYPE html>
 <html lang="ko" dir="ltr">
   <head>
     <meta charset="utf-8">
     <link rel="stylesheet" href="../css/club.css">
     <title></title>
     <script type="text/javascript">
       function buy_page(){
         var id = document.getElementById('userid').value;
         if (id=="") {
           alert("로그인이 필요합니다.");
         }else{
           location.href="./payment.php?club_num=<?=$club_num?>&club_name=<?=$club_name?>&club_price=<?=$club_price?>&id=<?=$userid?>";
         }
       }
       function cart_page(){
         alert("찜 등록되었습니다.");
         location.href="../../mypage/source/user_cart.php?club_image=<?=$image?>&club_name=<?=$club_name?>&club_to=<?=$club_to?>&club_apply=<?=$club_apply?>&club_price=<?=$club_price?>&id=<?=$userid?>";
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
         <li><a href="./list.php">CLUB LIST</a></li>
         <li><a href="#">INTRO</a></li>
         <li><a href="#">MY PAGE</a></li>
         <li><a href="#">HOME</a></li>
         <li><a href="#">HOME</a></li>
       </ul>
     </nav>
     <section class="sec1"></section>
     <section>
       <img src="../../img/<?=$club_image_copyied?>" width="350px" height="400px">
       <div class=""><b>모임명:<?=$club_name?></b></div>
       <div class=""><b>가격:<?=$club_price?></b></div>
       <div class=""><b>신청인원:<?=$club_apply?>/<?=$club_to?></b></div>
       <input type="hidden" id="userid" value="<?=$userid?>">
       <div class=""><button type="button" name="button" onclick="buy_page()">구매하기</button><button type="button"  name="button" onclick="cart_page()">카트담기</button></div>
       <div class=""><b>내용:<?=$club_content?></b></div>
       <div class=""><b>대관정보:<?=$club_rent_info?></b></div>
       <?php
       $club_rent_info=explode("/",$club_rent_info);
       $address=$club_rent_info[0];
       ?>
       <div class="">
         <p style="margin-top:-12px">
           <!-- <em class="link">
           <a href="javascript:void(0);" onclick="window.open('http://fiy.daum.net/fiy/map/CsGeneral.daum', '_blank', 'width=981, height=650')">
           혹시 주소 결과가 잘못 나오는 경우에는 여기에 제보해주세요.
         </a>
       </em>  -->
     </p>
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
     </section>
   </body>
 </html>
