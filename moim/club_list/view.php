<?php
include_once $_SERVER['DOCUMENT_ROOT']."/moim/lib/db_connector.php";

if(isset($_GET['club_num'])){
  $club_num=$_GET['club_num'];
}else{
  $club_num="";
  echo "<script>alert('실패');</script>";
}
if(isset($_GET['id'])){
  $userid=$_GET['id'];
}else{
  $userid="";
}
if(isset($_GET['club_category'])){
  $mode=$_GET['club_category'];
}else{
  $mode="";
}

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
$image =$row['club_image'];
$club_schedule =$row['club_schedule'];
$hit= $row['club_hit']+1;

//클릭한 상품의 조회수 업데이트
$sql= "update club set club_hit=$hit where club_num=$club_num";
mysqli_query($conn, $sql) or die(mysqli_error($conn));



 ?>
 <!DOCTYPE html>
 <html lang="ko" dir="ltr">
   <head>
     <meta charset="utf-8">
     <title></title>
     <script type="text/javascript">
       function buy_page(){
         var id = document.getElementById('userid').value;
         if (id=="") {
           alert("로그인이 필요합니다.");
         }else{
           location.href="../../moim/club_list/payment.php?club_num=<?=$club_num?>&club_name=<?=$club_name?>&club_price=<?=$club_price?>&id=<?=$userid?>";
         }
       }
       function cart_page(){
         alert("찜 등록되었습니다.");
         location.href="../../moim/mypage/source/user_cart.php?club_image=<?=$image?>&club_name=<?=$club_name?>&club_to=<?=$club_to?>&club_apply=<?=$club_apply?>&club_price=<?=$club_price?>&id=<?=$userid?>";
       }
     </script>
   </head>
   <body>
     <img src="../img/<?=$image?>" width="350px" height="400px">
     <div class=""><b>모임명:<?=$club_name?></b></div>
     <div class=""><b>가격:<?=$club_price?></b></div>
     <div class=""><b>신청인원:<?=$club_apply?>/<?=$club_to?></b></div>
     <input type="hidden" id="userid" value="<?=$userid?>">
     <div class=""><button type="button" name="button" onclick="buy_page()">구매하기</button><button type="button"  name="button" onclick="cart_page()">카트담기</button></div>
     <div class=""><b>내용:<?=$club_content?></b></div>
     <div class=""><b>대관정보:<?=$club_rent_info?></b></div>
   </body>
 </html>
