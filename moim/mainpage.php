<?php
session_start();

include $_SERVER['DOCUMENT_ROOT']."/moim/lib/db_connector.php";
?>
<!DOCTYPE html>
<html lang="ko" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, user-scalable=no">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css" integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <title>TEAM PROJECT</title>
    <link rel="stylesheet" href="./css/reset.css">
    <link rel="stylesheet" href="./css/header.css">
    <link rel="stylesheet" href="./css/slider.css">
    <link rel="stylesheet" href="./css/promotion.css">
    <link rel="stylesheet" href="./css/promotion_two.css">
    <link rel="stylesheet" href="./css/upbutton.css">
    <link rel="stylesheet" href="./css/container_test.css">
    <link rel="stylesheet" href="./css/service.css">
    <link rel="stylesheet" href="./css/footer.css">
    <script type="text/javascript" src="./js/slide_menu.js"></script>
    <script type="text/javascript" src="./js/upbtn.js"></script>
  </head>
  <body>
    <div id="wrap">
      <header class="header_top cfixed">
        <h1 class="head_logo"><a href="./mainpage.php">Mo,im</a></h1>
        <div id="mySlidenav" class="sidenav">
          <a href="#" class="closeside" onclick="closeNav()">&times;</a>
          <a href=""><?=$_SESSION['username']?>님 안녕하세요</a>
          <br>
          <a href="mainpage.php">HOME</a>
          <a href="./mypage/source/user_modify.php">MY PAGE</a>
          <a href="./club_list/source/list.php">CLUB LIST</a>
          <a href="./clubing/source/ing_list.php">CLUBING LIST</a>
          <a href="#">VIEW PLACE</a>
          <a href="./faq/source/faq_list.php">BOARD</a>
        </div>
        <nav>
          <ul class="head_menu">
            <li>
              <a href="#" class="openNav" onclick="openNav()">MENU</a>
            </li>
            <li><a href="./member/source/flagcheck.php">SIGN UP</a></li>
            <li><a href="./message/source/msg.php">MESSAGE</a></li>
            <?php
              if(!isset($_SESSION['userid'])){
                echo ('<li><a href="./login/source/login.php">LOG IN</a></li>');
              }else{
                echo ('<li><a href="./login/source/logout.php">LOG OUT</a></li>');
              }
              //관리자로그인시 화면상단에 ADMIN 생성
              if(isset($_SESSION['userid']) && $_SESSION['userid']=="admin"){
                echo ('<li><a href="./admin/source/admin.php">ADMIN</a></li>');
              }
             ?>
          </ul>
        </nav>
        <!-- <span class="menu-toggle-btn">
          <span></span>
          <span></span>
          <span></span>
        </span> -->
      </header>
      <article class="slider">
        <img src="./img/main03.jpg" alt="">
      </article>
      <section class="content">
        <section class="display-section">
          <div class="container">
            <h2 class="sec-tit">Social Mo,im</h2>
            <p class="desc">취향과 취미가 통하는 곳, 사람과 사람을 통하는 곳, 다양한 분야의 사람들과 <br>
              삶과 경험, 생각을 나누고 그 여정을 떠날 수 있는 곳.
            </p>
          </div>
        </section>
        <br>
        <br>
        <br>
        <section class="promotion_section">
          <div class="about_area">
            <h1>Popular Mo,im TOP3</h1>
            <div class="about_box">
              <div class="about_box_img">
                <h3>잠시, 벗어나기</h3>
                <a href="#" class="img_link">
                  <img class="top_place" src="./img/club01.jpg" alt="">
                  <p>sns와 인터넷에서 벗어나 이야기와 취미생활을 이끌어 주는 모임</p>
                </a>
              </div>
              <div class="about_box_img">
                <h3>새로운 생각, 새로운 상상</h3>
                <a href="#" class="img_link">
                  <img class="top_place" src="./img/club02.jpg" alt="">
                  <p>또다른 나의 잠재력을 이끌어 줄 수 있는 두뇌 모임</p>
                </a>
              </div>
              <div class="about_box_img">
                <h3>길었던 하루, 행복한 사람</h3>
                <a href="#" class="img_link">
                  <img class="top_place" src="./img/club05.jpg" alt="">
                  <p>지루했던 일상에서 벗어나 대화와 추억을 공유할 수 있는 사람들의 모임</p>
                </a>
              </div>
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
            <!-- <div class="grid_box">
              <a href="#">
                <img class="top-place-two" src="./img/clubing02.jpg" alt="">
                <h2>모집모임1</h2>
                <p>모집 중인 모임 1의 정보</p>
              </a>
            </div>
            <div class="grid_box">
              <a href="#">
                <img class="top-place-two" src="./img/clubing03.jpg" alt="">
                <h2>모집모임1</h2>
                <p>지루했던 일상에서 벗어나 대화와 추억을 공유할 수 있는 사람들의 모임</p>
              </a>
            </div>
            <div class="grid_box">
              <a href="#">
                <img class="top-place-two" src="./img/clubing04.jpg" alt="">
                <h2>모집모임1</h2>
                <p>여기는 모집중인 모임의 정보입니다.</p>
              </a>
            </div>
            <div class="grid_box">
              <a href="#">
                <img class="top-place-two" src="./img/clubing05.jpg" alt="">
                <h2>모집모임1</h2>
                <p>정신없이 지나가는 우리의 시간. 우리는 스스로에게 관심을 가질 시간이 필요합니다. 그래서 통하는 사람들과 함께 나를 돌아보는 글쓰기 모임을 준비했습니다. 사소한 일상이나 감정을 글로 옮기다 보면, 어느새 나에게 집중하게 됩니다. 또, 취미나 좋아하는 것들을 담은 글로 나를 소개하며 내가 몰랐던 나를 발견하기도 합니다. 내 마음에 쉴 틈을 열어주는 시간, 긴 하루의 끝에 작은 쉼표를 찍어 봅니다.  </p>
              </a>
            </div>
            <div class="grid_box">
              <a href="#">
                <img class="top-place-two" src="./img/clubing06.jpg" alt="">
                <h2>모집모임1</h2>
                <p>음식과 식재료, 그리고 요리를 둘러싼 재미있는 이야기들, 그리고 음식이 우리 삶에 어떤 영향을 주고, 어떤 의미가 있는지 함께 이야기를 나누는 즐거운 식탁에 초대합니다. 정기모임에서 평소 혼자선 엄두도 내기 어려웠던 요리를 직접 만들고 다양한 주제로 얘기를 나눕니다. 행아웃에서 철학과 이야기가 있는 레스토랑을 방문하거나, 한강으로 피크닉을 가고, 바베큐 파티를 열어보며 우리만의 특별한 하루를 만들어 봅니다. </p>
              </a>
            </div>
            <div class="grid_box">
              <a href="#">
                <img class="top-place-two" src="./img/clubing07.jpg" alt="">
                <h2>모집모임1</h2>
                <p>모집 중인 모임 1의 정보</p>
              </a>
            </div>
            <div class="grid_box">
              <a href="#">
                <img class="top-place-two" src="./img/clubing08.jpg" alt="">
                <h2>모집모임1</h2>
                <p>모집 중인 모임 1의 정보</p>
              </a>
            </div>
            <div class="grid_box">
              <a href="#">
                <img class="top-place-two" src="./img/clubing09.jpg" alt="">
                <h2>모집모임1</h2>
                <p>어쩌면 좋은 일이 생길 것만 같은 나른한 퇴근길과 주말 오후. 취향이 통하는 사람들과 즐거운 모임을 가져봅니다. 분위기 좋은 재즈바, 음악을 즐기는 클럽 나들이, 한강에서의 바베큐 파티까지. 매일 만나던 사람들이 아닌 새로운 사람들과 새로운 경험에 도전합니다. 취향이 맞는 멤버들로 모임을 구성하여 다양한 활동들을 함께 합니다. 서로 배우고 즐기는 경험을 하고 나면, 휴가 보다 모임이 더 기다려질지 모릅니다. 우리 삶에 활력이 되는 특별한 모임에 초대합니다.</p>
              </a>
            </div> -->
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
        </div>
        <div class="footer_bottom">
          &copy;www.moim.com | Designed by WebApp 5 class YoungMinTeam
        </div>
      </div>
    </footer>
    <a href="#" class="gotobtn"><i class="fas fa-arrow-up"></i></a>
  </body>
</html>
