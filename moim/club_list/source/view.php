<?php
session_start();
include $_SERVER['DOCUMENT_ROOT']."/moim/lib/create_table.php"; //club_DB 생성
include $_SERVER['DOCUMENT_ROOT']."/moim/lib/db_connector.php";
create_table($conn, 'cart');
$mode="";   //mode query.php에 쓰일 cart,delete,download

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
$club_intro=$row['club_intro'];

//클릭한 상품의 조회수 업데이트
//club 테이블에 해당된 club_num일 경우 hit를 업데이트 한다.
$sql= "update club set club_hit=$hit where club_num=$club_num";
mysqli_query($conn, $sql) or die(mysqli_error($conn));

//중복 결제를 막기위한 구매테이블과 클럽테이블의 이너조인
// buy 테이블의 buy_num 와 club 테이블의 club_num 이 같은 것 중에서 해당된 club_name과 해당된 buy_id 일 경우를 검색한다.
$sql= "select * from buy Inner join club on buy.buy_club_num = club.club_num where club_name='$club_name' and buy_id = '$userid'";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_array($result);

$buy_club_num = $row['buy_club_num'];
$buy_id = $row['buy_id'];

//카트에 중복담기 x
// cart 테이블의 cart_club_num 와 club 테이블의 club_num 이 같은 것 중에서 해당된 club_name과 해당된 cart_id 일 경우를 검색한다.
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
     <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, user-scalable=no">
     <link rel="stylesheet" href="../css/club.css">
     <link rel="stylesheet" href="../css/club_view.css">
     <link href="https://fonts.googleapis.com/css?family=Do+Hyeon|Noto+Sans+KR&display=swap" rel="stylesheet">
     <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css" integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">
     <title><?=$club_name?></title>
     <!-- 구매하기 카트담기 삭제 부분 스크립트 -->
     <script type="text/javascript" src="../js/club.js"></script>
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
       <div class="club_view">
         <div class="club_info">
           <div class="club_img">
             <div class="club_view_name"><b><?=$club_name?></b></div>
             <img src="../../admin/data/<?=$club_image_copied?>" width="500px" height="400px">
           </div>
          <div class="club_div">
             <div class="club_view_price"><b>가격:<?=$club_price?>원</b></div>
             <div class="club_view_apply"><b>신청인원:<?=$club_apply?>/<?=$club_to?>명</b></div>
             <div class=""><b>신청기간:<?=$club_start?>~<?=$club_end?></b></div>
             <div class=""><b>모임날짜:<?=$club_schedule?></b></div>
             <div class=""><b>장소:<?=$club_rent_info?></b></div>
             <div class="club_view_intro"><b><?=$club_intro?></b></div>
           </div>
             <input type="hidden" id="userid" value="<?=$userid?>">
             <input type="hidden" id="buy_id" value="<?=$buy_id?>">
             <input type="hidden" id="buy_club_num" value="<?=$buy_club_num?>">
             <input type="hidden" id="club_num" value="<?=$club_num?>">
             <input type="hidden" id="cart_club_num" value="<?=$cart_club_num?>">
             <input type="hidden" id="cart_id" value="<?=$cart_id?>">
             <input type="hidden" id="club_to" value="<?=$club_to?>">
             <input type="hidden" id="club_apply" value="<?=$club_apply?>">
             <input type="hidden" id="club_name" value="<?=$club_name?>">
             <input type="hidden" id="club_price" value="<?=$club_price?>">
           <div class="club_view_btn"><button type="button" name="button1" onclick="buy_page()" class="buy_btn">구매하기</button>&nbsp;&nbsp;&nbsp;<button type="button"  name="button2" onclick="cart_page()" class="cart_btn">카트담기</button></div>
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
           }
           ?>
         </b></div>
         <?php
         $club_rent_info=explode("/",$club_rent_info);
         $address=$club_rent_info[0];
         ?>
         <hr class="divider">
         <div class="club_view_map">
           <input type="hidden" id="address" value="<?=$address?>">
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
           <script src="../../js/map.js"></script>
       </div><!--club_view_map-->

         <div class="club_view_bar">
           <a href="./list.php">목록</a>
           <?php
            if ($userid=="admin") {   // 관리자일 경우 수정 삭제 버튼생성
              echo ('<a href="../../admin/source/admin_club_create2.php?mode=update&club_num='.$club_num.'">수정</a>&nbsp;');
              echo ('<a href="#" onclick="del_check()">삭제</a>&nbsp;');
            }
            ?>
          </div>
        </div><!--club_view-->
     </section>
   </body>
 </html>
