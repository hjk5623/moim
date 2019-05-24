<?php
include $_SERVER['DOCUMENT_ROOT']."/moim/lib/db_connector.php";

if(isset($_GET['mode'])){
  $mode=$_GET['mode'];
}else{
  $mode="";
}

if (!(empty($_GET['mode']))&&(isset($_GET['mode']))){
  $sql= "select * from agit where agit_name = '$mode'";
  $result = mysqli_query($conn, $sql);
  $row = mysqli_fetch_array($result);

  $agit_num=$row['agit_num'];
  $agit_name=$row['agit_name'];
  $agit_address=$row['agit_address'];
  $agit_content=$row['agit_content'];
  $agit_content=htmlspecialchars_decode($agit_content);
  $agit_image_copied=$row['agit_image_copied'];
  $agit_code=$row['agit_code'];
}else{
  echo "<script>alert('잘못된 접근입니다.');</script>";
  exit;
}
 ?>
<!DOCTYPE html>
<html lang="ko" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
    <link rel="stylesheet" href="../css/user_agit_popup.css">
    <script type="text/javascript">
      function look(agit){
        window.open('https://www.wework.com/ko-KR/buildings/'+agit);
        close();
      }
    </script>
  </head>
  <body>
    <div class="agit_layer">
      <div class="agitBg"></div>
      <div class="agit_h1">
        <h1 class="ctxt"><?=$agit_name?></h1>
      </div>
      <hr class="divider">
      <div class="agit_info">
      <div class="agit_img">
        <img src="../../admin/data/<?=$agit_image_copied?>" width="500px" height="400px">
      </div>
      <div class="agit_content">
        <h3><?=$agit_content?></h3>
      </div>
      <div class="">
        <h3>장소 : <?=$agit_address?></h3>
      </div>
      <?php
      $agit_address=explode("/",$agit_address);
      $address=$agit_address[0];
      ?>
    </div>
      <div class="agit_map">
        <hr class="divider">
        <div class="club_view_map">

          <!-- <p style="margin-top:12px"> -->
              <!-- <em class="link">
              <a href="javascript:void(0);" onclick="window.open('http://fiy.daum.net/fiy/map/CsGeneral.daum', '_blank', 'width=981, height=650')">
              혹시 주소 결과가 잘못 나오는 경우에는 여기에 제보해주세요.
            </a>
          </em>  -->
           <!-- </p> -->
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
      </div><!--club_view_map-->
      </div>

      <hr class="divider">

      <div class="agit_btn">
        <p><a href="#" onclick="look('<?=$agit_code?>');" class="agit_look">자세히 보기</a></p>
      </div>
    </div>
  </body>
</html>
