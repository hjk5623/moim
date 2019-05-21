<?php
session_start();
include $_SERVER['DOCUMENT_ROOT']."/moim/lib/create_table.php"; //club_DB 생성
include $_SERVER['DOCUMENT_ROOT']."/moim/lib/db_connector.php";

$mode="";

if(isset($_GET['club_num'])){
  $club_num=$_GET['club_num'];
}else{
  $club_num="";
  echo "<script>alert('실패');</script>";
}
if(isset($_SESSION['userid'])){
  $userid=$_SESSION['userid'];
}else{
  $userid="";
}
if(isset($_GET['club_category'])){
  $club_category=$_GET['club_category'];
}else{
  $club_category="";
}

$sql = "select * from club where club_num=$club_num";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_array($result);

$club_name = $row['club_name'];
$club_price = $row['club_price'];
$club_content =$row['club_content'];
$club_content=htmlspecialchars_decode($club_content);
$club_rent_info =$row['club_rent_info'];
$club_to =$row['club_to'];
$club_apply =$row['club_apply'];
$club_start =$row['club_start'];
$club_end =$row['club_end'];
$club_schedule =$row['club_schedule'];
$hit= $row['club_hit']+1;
$club_image_copied=$row['club_image_copied'];
$club_file_name=$row['club_file_name'];
$club_file_copied=$row['club_file_copied'];

//클릭한 상품의 조회수 업데이트
$sql= "update club set club_hit=$hit where club_num=$club_num";
mysqli_query($conn, $sql) or die(mysqli_error($conn));

//중복 결제를 막기위한 구매테이블과 클럽테이블의 이너조인
$sql= "select * from buy Inner join club on buy.buy_club_num = club.club_num where club_name='$club_name' and buy_id = '$userid'";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_array($result);

$buy_club_num = $row['buy_club_num'];
$buy_id = $row['buy_id'];

//카트에 중복담기 x
$sql= "select * from cart Inner join club on cart.cart_club_num = club.club_num where club_name='$club_name' and cart_id = '$userid'";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_array($result);

$cart_club_num=$row['cart_club_num'];
$cart_id=$row['cart_id'];

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
         var club_num = document.getElementById('club_num').value;
         var buy_id = document.getElementById('buy_id').value;
         var buy_club_num = document.getElementById('buy_club_num').value;


         if (id=="") {
           alert("로그인이 필요합니다.");
         }else if((buy_club_num==club_num)&&(id==buy_id)){
           alert("결제된 모임입니다. 다시 확인하여 주십시오.");
         }else{
         location.href="./payment.php?club_num=<?=$club_num?>&club_name=<?=$club_name?>&club_price=<?=$club_price?>&id=<?=$userid?>";
        }
       }
       function cart_page(){
         var id = document.getElementById('userid').value;
         var club_num = document.getElementById('club_num').value;
         var cart_club_num = document.getElementById('cart_club_num').value;
         var cart_id = document.getElementById('cart_id').value;
         <?php
         create_table($conn,'cart');
          ?>
         if ((cart_id==id)&&(cart_club_num==club_num)) {
           alert("이미 등록하셨습니다.");
         }else{
           alert("찜 등록되었습니다.");
           location.href="./query.php?mode=<?=$mode="cart"?>&id=<?=$userid?>&club_num=<?=$club_num?>";
         }
       }
       function del_check(){
         var result=confirm("삭제하시겠습니까?");
         if(result){
           window.location.href='./query.php?mode=<?=$mode="delete"?>&club_num=<?=$club_num?>';
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
         <li><a href="./list.php">CLUB LIST</a></li>
         <li><a href="#">INTRO</a></li>
         <li><a href="#">MY PAGE</a></li>
         <li><a href="#">HOME</a></li>
         <li><a href="#">HOME</a></li>
       </ul>
     </nav>
     <section class="sec1"></section>
     <section>
       <img src="../../admin/data/<?=$club_image_copied?>" width="350px" height="400px">
       <div class=""><b>모임명:<?=$club_name?></b></div>
       <div class=""><b>가격:<?=$club_price?></b></div>
       <div class=""><b>신청인원:<?=$club_apply?>/<?=$club_to?></b></div>
       <input type="hidden" id="userid" value="<?=$userid?>">
       <input type="hidden" id="buy_id" value="<?=$buy_id?>">
       <input type="hidden" id="buy_club_num" value="<?=$buy_club_num?>">
       <input type="hidden" id="club_num" value="<?=$club_num?>">
       <input type="hidden" id="cart_club_num" value="<?=$cart_club_num?>">
       <input type="hidden" id="cart_id" value="<?=$cart_id?>">
       <div class=""><button type="button" name="button1" onclick="buy_page()">구매하기</button><button type="button"  name="button2" onclick="cart_page()">카트담기</button></div>
       <div class=""><b>내용:<?=$club_content?></b></div>
       <div class=""><b>대관정보:<?=$club_rent_info?></b></div>
       <div class=""><b>세부사항:
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
           }
          ?>
       </b></div>
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

 <div id="">
   <a href="./list.php">목록 |</a>
   <?php
    if ($_SESSION['userid']=="admin") {
      echo ('<a href="../../admin/source/admin_club_create2.php?mode=update&club_num='.$club_num.'">수정 |</a>&nbsp;');
      echo ('<span onclick="del_check()">삭제 |</span>&nbsp;');
      echo ('<a href="../../admin/source/admin_club_create2.php">모임 만들기</a>');
    }

    ?>
  </div>
     </section>
   </body>
 </html>
