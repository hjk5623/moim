<?php
if(!isset($_SESSION)){
  session_start();
}
 ?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="../css/user_menu.css">
    <title></title>
  </head>
  <body>
    <nav>
      <div class="brand">
        <h2>Mo,im</h2>
      </div>
      <div class="menubar">
        <ul>
          <li><a href="./user_modify.php">정보수정</a></li>
          <li><a href="./user_request.php">모임만들기</a></li>
          <li><a href="./user_apply.php">모임</a></li>
          <!-- <li><a href="./user_open.php">CLUBING</a></li> -->
          <li><a href="./user_cart.php">위시리스트</a></li>
          <!-- <li><a href="./user_apply_list.php">개설신청내역</a></li> -->
          <li><a href="./user_refund.php">환불내역</a></li>
          <li><a href="#" onclick="message_form();">문의</a></li>
          <?php
            if(isset($_SESSION["userid"])){
            ?>
            <li><a href="../../login/source/logout.php">로그아웃</a></li>
          <?php
            }else{
            ?>
            <li><a href="../../login/source/login.php">로그인</a></li>
          <?php
            }
           ?>

      </div>
    </nav>
    <slider>
      <slide><p>MY PAGE</p></slide>
      <slide><p>MY PAGE</p></slide>
      <slide><p class="mypage3">MY PAGE</p></slide>
      <slide><p>MY PAGE</p></slide>
    </slider>
    <div id="container">
      <div id="subwrap">
        <div class="nav">
          <div class="detail_tabs">
            <div class="tabs_nav">
            </div><!--end of tabs_nav -->
          </div> <!--end of detail_tabs -->
        </div><!--end of nav  -->
      </div><!--end of subwrap  -->
    </div> <!--end of container  -->
  </body>
</html>
