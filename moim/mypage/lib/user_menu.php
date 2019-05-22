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
          <li><a href="../../mainpage.php">HOME</a></li>
          <?php
            if(isset($_SESSION["userid"])){
            ?>
            <li><a href="../../login/source/logout.php">LOG OUT</a></li>
          <?php
            }else{
            ?>
            <li><a href="../../login/source/login.php">LOGIN</a></li>
          <?php
            }
           ?>
          <li><a href="./user_modify.php">MODIFY</a></li>
          <li><a href="./user_request.php">CREATE_CLUB</a></li>
          <li><a href="./user_apply.php">CLUB_LIST</a></li>
          <li><a href="./user_open.php">CLUBING</a></li>
          <li><a href="./user_cart.php">CART</a></li>
          <li><a href="">USER_CLUB</a></li>
          <li><a href="./user_refund.php">REFUND</a></li>

      </div>
    </nav>
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
