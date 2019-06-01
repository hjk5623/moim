<?php
if(!isset($_SESSION)){
session_start();

}
 ?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="../css/admin.css">
    <title></title>
  </head>
  <body>
    <nav>
      <div class="brand">
        <a href="../../mainpage.php">
        <h2>Mo,im</h2>
        </a>
      </div>
      <div class="menubar">
        <ul>
          <?php
            // if(!isset($_SESSION['userid'])){
            //   echo ('<li><a href="../../login/source/login.php">LOG IN</a></li>');
            // }else{
            //   echo ('<li><a href="../../login/source/logout.php">LOG OUT</a></li>');
            // }
            ?>
          <li><a href="admin_member.php">회원관리</a></li>
          <li><a href="admin_sales.php">통계</a>
          </li>
          <li><a href="admin_club_create.php">모임등록</a>
            <ul>
              <li><a href="admin_club_list.php">모임목록</a></li>
              <li><a href="admin_club_create.php">모임등록양식</a></li>
            </ul>
          </li>
          <li><a href="admin_club_accept.php">모임개설승인</a></li>
          <li><a href="admin_request_list.php">신청모임관리</a></li>
          <li><a href="admin_agit_create.php">아지트등록</a>
            <ul>
              <li><a href="admin_agit_list.php">아지트목록</a></li>
              <li><a href="admin_agit_create.php">아지트등록양식</a></li>
            </ul>
          </li>
          <li><a href="admin_refund.php">환불관리</a></li>
          <li><a href="#" onclick="message_form();">문의</a></li>

      </div>
    </nav>
    <slider>
      <slide><p>THIS</p></slide>
      <slide><p>IS</p></slide>
      <slide><p>ADMIN</p></slide>
      <slide><p>PAGE</p></slide>
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
