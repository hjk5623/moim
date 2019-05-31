<?php
if(!isset($_SESSION)){
session_start();

}
 ?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="../css/top_menu.css">
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

          <li><a href="../../faq/source/faq_list.php">FAQ</a></li>
          <li><a href="../../qna/source/qna_list.php">QNA</a></li>
          <li><a href="../../notice/source/notice_list.php">NOTICE</a>
          <li><a href="#" onclick="message_form();">MESSAGE</a></li>
            <?php
              if(!isset($_SESSION['userid'])){
                echo ('<li><a href="../../login/source/login.php">LOG IN</a></li>');
              }else{
                echo ('<li><a href="../../login/source/logout.php">LOG OUT</a></li>');
              }
             ?>
        </ul>
      </div>
    </nav>
  </body>
</html>
