<?php
if (!isset($_SESSION)) {
  session_start();
}
include $_SERVER['DOCUMENT_ROOT']."/moim/lib/db_connector.php";
$today = date("Y-m-d");
$sql = "SELECT * FROM club where club_open = 'no' and club_end >= '$today' order by club_hit desc LIMIT 3;";
$result = mysqli_query($conn, $sql) or die("실패원인12 " . mysqli_error($conn));
$row_count= mysqli_num_rows($result);

?>
<!DOCTYPE html>
<html lang="ko" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, user-scalable=no">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css" integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script type="text/javascript" src="./js/calender.js"></script>
    <title>TEAM PROJECT</title>
    <link rel="stylesheet" href="./css/calender.css">
    <link rel="stylesheet" href="./css/reset.css">
    <link rel="stylesheet" href="./css/header.css">
    <link rel="stylesheet" href="./css/slider.css">
    <link rel="stylesheet" href="./css/promotion.css">
    <link rel="stylesheet" href="./css/promotion_two.css">
    <link rel="stylesheet" href="./css/container_test.css">
    <link rel="stylesheet" href="./css/service.css">
    <link rel="stylesheet" href="./css/footer.css">
    <link rel="stylesheet" href="./css/upbutton.css">
    <link rel="stylesheet" href="./css/message_modal.css">
    <script type="text/javascript" src="./js/upbtn.js"></script>
    <script type="text/javascript" src="./js/slide_menu.js"></script>
    <script type="text/javascript" src="./js/main_menu.js"></script>
    <script type="text/javascript" src="./js/message.js"></script>
    <link rel="stylesheet" href="./css/modal_alert.css">
    <script type="text/javascript" src="./js/modal_alert.js"></script>
    <script type="text/javascript">
    function message_form(){
     var popupX = (window.screen.width/2)-(600/2);
     var popupY = (window.screen.height/2)-(600/2);
     window.open('./message/source/msg.php','','left='+popupX+',top='+popupY+', width=550, height=600, status=no, scrollbars=no');
   }
   window.onclick = function(event) {
     var modal = document.getElementById('myModal');
       if (event.target == modal) {
           modal.style.display = "none";
       }
   };
   </script>

  </head>
  <body>
    <div id="wrap">
      <header class="header_top cfixed">
        <!-- <h1 class="head_logo"><a href="./mainpage.php">Mo,im</a></h1> -->
        <div id="mySlidenav" class="sidenav">
          <a href="#" class="closeside" onclick="closeNav()">&times;</a>
          <?php
            if(isset($_SESSION['username'])){
              echo "<a >".$_SESSION['username']."님 안녕하세요</a>";
            }
           ?>
          <br>
          <?php
            if(isset($_SESSION['username'])){
              if ($_SESSION['username']!='admin' && !(empty($_SESSION['username']))) {
                echo '<a href="./mypage/source/user_check.php">MY PAGE</a>';
              }else {
                echo "";
              }
            }
          ?>
          <a href="./club_list/source/list.php">CLUB LIST</a>
          <!-- <a href="#">VIEW PLACE</a> -->
          <a href="./faq/source/faq_list.php">BOARD</a>
          <a href="#" onclick="calendar_choice()">CALENDER</a>
          <?php
            if(isset($_SESSION['username'])){
              if (!(($_SESSION['username'])=='admin') && !(empty($_SESSION['username']))) {
                echo '<a href="#" id="message_btn" onclick="open_modal()">MESSAGE</a>';
              }
            }
          ?>
          <form name="msg_form" action="./message/source/msg_query.php?mode=send" method="post">
            <div class="modal_message">
              <div class="content_modal">
                <h1>Send Message</h1>
                <!-- <input type="text" name="" value="" placeholder="관리자"><br> -->
                <?php
                  if($_SESSION['userid']=="admin" || $_SESSION['userid']=="notice_id"){
                    echo "<input type='text' value='$send_id' name='receive_id' readonly>";
                  }else{
                     echo "<input type='text' value='admin' name='receive_id' readonly>";
                  }
                ?>
                <textarea name="msg_content" id="msg_content" rows="8" cols="40" placeholder="메세지를 적어주세요."></textarea>
                <!-- <a href="#">SEND</a> -->
                <button type="button" name="button" onclick="send_message()">SEND</button>
              </div>
              <div class="hide fas fa-times" onclick="hide_modal()"></div>
              <div class="fas fa-envelope-open message_form" id="message_form" onclick="message_form()"></div>
            </div>
          </form>
        </div>


        <!-- <div class="simple_modal" id="modal_id">
          <div class="modal_content">
            <span class="closeBtn">&times;</span>
          </div>
        </div>
        <script>
         var modal = document.getElementById('modal_id');
         var modalBtn = document.getElementById('message_form');
         var closeBtn = document.getElementsByClassName('closeBtn')[0];

         modalBtn.addEventListener('click', openmodal);
         closeBtn.addEventListener('click', closemodal);
         window.addEventListener('click', clickOutside);

         function openmodal(){
           modal.style.display='block';
         }
         function closemodal(){
           modal.style.display='none';
         }
         function clickOutside(e){
           if (e.target == modal) {
             modal.style.display='none';
           }
         }
        </script> -->
        <nav>
          <div class="menu_icon">
            <i class="fas fa-bars fa-2x"></i>
          </div>
          <a href="mainpage.php">
          <div class="logo">
            Mo,im
          </div>
          </a>
          <div class="menu">
            <ul>
              <li><a href="#" class="openNav" onclick="openNav()">MENU</a></li>
              <?php
              if(!isset($_SESSION['userid'])){
                echo ('<li><a href="./member/source/flagcheck.php">SIGN UP</a></li>');
              }

               ?>
              <?php
              if(!isset($_SESSION['userid'])){

              }else{
                echo ('<li><a href="#" onclick="message_form();">MESSAGE</a></li>');
              }
               ?>

              <?php
              if(!isset($_SESSION['userid'])){
                echo ('<li><a href="./login/source/login.php">LOG IN</a></li>');
              }else{
                echo ('<li><a href="./login/source/logout.php">LOG OUT</a></li>');
              }
              //관리자로그인시 화면상단에 ADMIN 생성
              if(isset($_SESSION['userid']) && $_SESSION['userid']=="admin"){
                echo ('<li><a href="./admin/source/admin_member.php">ADMIN</a></li>');
              }
             ?>
            </ul>
          </div>

        </nav>
        <!-- <span class="menu-toggle-btn">
          <span></span>
          <span></span>
          <span></span>
        </span> -->
      </header>
      <!-- <article class="slider">
        <img src="./img/main03.jpg" alt="">
      </article> -->


      <section class="content">
        <section class="display-section">
          <div class="container">
            <h2 class="sec-tit">Social Mo,im</h2>
            <p class="desc">취향과 취미가 통하는 곳, 사람과 사람을 통하는 곳, 다양한 분야의 사람들과 <br>
              삶과 경험, 생각을 나누고 그 여정을 떠날 수 있는 곳.
            </p>
          </div>
        </section>
        <div id="myModal_c" class="modal_c">
          <div class="modal-content_c" id="modal-content_c">

           </div>
         </div>
        <div id="myModal" class="modal">
          <div class="modal-content" id="modal-content">

           </div>
         </div>
        <br>
        <br>
        <br>
        <section class="promotion_section">
          <div class="about_area">
            <h1>Popular Mo,im TOP3</h1>
            <div class="about_box">
            <?php
              while ($row = mysqli_fetch_array($result)) {
             ?>
             <div class="about_box_img">
               <h3><?=$row['club_name']?></h3>
               <a href="./club_list/source/view.php?club_num=<?=$row['club_num']?>" class="img_link">
                 <img class="top_place" src="./admin/data/<?=$row['club_image_copied']?>" alt="">
                 <p><?=$row['club_intro']?></p>
               </a>
             </div>
             <?php
              }
              ?>
              </div>
            </div>
        </section>

        <hr class="divider">
        <section class="promotion_section_two">
          <h1>Ongoing Mo,im</h1>
          <div class="grid_contain">
              <?php
              $today = date("Y-m-d", time());
              if ((!empty($_GET['mode']))&&(isset($_GET['mode']))) {  //카테고리별 모임들
                $sql = "select * from club where club_category='$mode' and club_open = 'no' and club_end >= '$today' order by club_hit desc";
                $result = mysqli_query($conn, $sql) or die(mysqli_error($conn));
                $count=mysqli_num_rows($result);
              }else{  //전체 모임들
                $sql = "select * from club where club_open = 'no' and club_end >= '$today' order by club_hit desc";
                $result = mysqli_query($conn, $sql) or die(mysqli_error($conn));
                $count=mysqli_num_rows($result);
              }
              for($i=0;$i<$count;$i++){
                $row= mysqli_fetch_array($result);
                $club_num= $row['club_num'];
                $club_name=$row['club_name'];
                $club_image_copied=$row['club_image_copied'];
                $club_intro=$row['club_intro'];
                ?>
            <div class="grid_box">
              <a href="./club_list/source/view.php?club_num=<?=$club_num?>" id="">
                <img class="top-place-two" src="./admin/data/<?=$club_image_copied?>">
                <h2><?=$club_name?></h2>
                <p><?=$club_intro?></p>
              </a>
            </div>
              <?php
            }
            ?>
          </div>
        </section>
       <hr class="divider">
      </section>
    </div>
    <div class="container_test">
      <div class="box">
        <div class="imgbx">
          <img src="./img/business01.jpg" alt="">
        </div>
        <div class="contentbx">
          <h3>LOVE</h3>
          <p>Tis better to have loved and lost, than never to have loved at all.There is always some madness in love. But there is also always some reason in madness.
            Love, free as air at sight of human ties, Spreads his light wings, and in a moment flies.Love asks me no questions, and gives me endless support.
            We come to love not by finding a perfect person, but by learning to see an imperfect person perfectly.The way to love anything is to realize that it might be lost.
          </p>
        </div>
      </div>
      <div class="box">
        <div class="imgbx">
          <img src="./img/business02.jpg" alt="">
        </div>
        <div class="contentbx">
          <h3>COURAGE</h3>
          <p>Miracles happen to only those who believe in them.Think like a man of action and act like man of thought.Courage is very important. Like a muscle, it is strengthened by use.
            Life is the art of drawing sufficient conclusions from insufficient premises.By doubting we come at the truth.A man that has no virtue in himself, ever envies virtue in others.
            In the morning of life, work; in the midday, give counsel; in the evening, pray.Painless poverty is better than embittered wealth.
          </p>
        </div>
      </div>
      <div class="box">
        <div class="imgbx">
          <img src="./img/business03.jpg" alt="">
        </div>
        <div class="contentbx">
          <h3>HOPE</h3>
          <p>Where there is a will there is a way.Think of the end before you begin.Ability is decided by one's own effort.Faithfulness makes all things possible.
            Faith without deeds is useless.The regret after not doing something is bigger than that of doing something.Try your best rather than be the best.
            Today, which was proved to be fruitless, is the day that the dead in the past was longing for.
          </p>
        </div>
      </div>
    </div>

    <div class="services">
      <h1>Mo,im Introduce</h1>
      <div class="cen">
        <div class="service">
          <i class="fas fa-battery-empty"></i>
          <h2>First</h2>
          <p>Mo,im의 의미는 취향과 취미가 통하고, 사람과 사람이 통하는 곳으로 남녀노소 누구나 즐길 수 있는 공간입니다.</p>
        </div>
        <div class="service">
          <i class="fas fa-battery-quarter"></i>
          <h2>Second</h2>
          <p>Mo,im은 각자 다른 다양한 분야의 사람들이 모여 하나의 모임을 만들고, 같이 활동하며 즐길 수 있는 공간입니다.</p>
        </div>
        <div class="service">
          <i class="fas fa-battery-half"></i>
          <h2>Third</h2>
          <p>Mo,im은 다른 성격, 다른 생각을 가졌지만 하나의 모임 안에서 생각을 나누고 강한 유대관계를 만들 수 있는 공간입니다.</p>
        </div>
        <div class="service">
          <i class="fas fa-battery-three-quarters"></i>
          <h2>Fourth</h2>
          <p>Mo,im은 단결,'뭉침'을 순화한 단합이 이루어져 하나의 모임을 만들 수 있는 공간입니다.</p>
        </div>
        <div class="service">
          <i class="fas fa-battery-full"></i>
          <h2>Fifth</h2>
          <p>Mo,im은 힘겨운 하루를 보내고 쉴 수 있는 공간, 위로를 받을 수 있는 공간입니다.</p>
        </div>
        <div class="service">
          <i class="fas fa-bell"></i>
          <h2>Sixth</h2>
          <p>Mo,im은 삶과 경험을 나누고 또 하나의 인생을 배워갈 수 있는 공간입니다.</p>
        </div>
      </div>

    </div>

    <footer>
      <div class="footer">
        <div class="footer_content">
          <div class="footer_section about">
            <h1 class="footer_logo"><span>Mo</span>,im</h1>
            <p>The meaning of this page is that people of various inclination can make one thing in common, share one another and make a hobby.</p>
            <div class="contact">
              <span><i class="fas fa-phone"></i>02-1111-1111</span><br><br>
              <span><i class="far fa-envelope"></i>admin@moim.com</span>
            </div>
            <div class="socials">
              <a href="#"><i class="fab fa-facebook fa-2x"></i></a>
              <a href="#"><i class="fab fa-instagram fa-2x"></i></a>
              <a href="#"><i class="fab fa-twitter fa-2x"></i></a>
              <a href="#"><i class="fab fa-youtube fa-2x"></i></a>
            </div>
          </div>
          <div class="footer_section links">
            <h2>Quick Links</h2>
            <br>
            <ul>
              <li><a href="#">HOME</a></li>
              <li><a href="#">MYPAGE</a></li>
              <li><a href="#">ABOUT</a></li>
              <li><a href="#">QNA</a></li>
              <li><a href="#">FAQ</a></li>
              <li><a href="#">MEMO</a></li>
              <li><a href="#">CLUB LIST</a></li>
              <li><a href="#">SIGN UP</a></li>
            </ul>
          </div>
          <div class="footer_section contact_form">
            <h2>Contact Us</h2>
            <br>
          </div>
        </div><!--footer_content-->
        <div class="footer_bottom">
          &copy;www.moim.com | Designed by WebApp 5 class YoungMinTeam
        </div><!--footer_bottom-->
      </div><!--end of footer-->
    </footer>
    </div>
    <a href="#" class="gotobtn"><i class="fas fa-arrow-up"></i></a>
  </body>
</html>
