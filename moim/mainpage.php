<?php session_start(); ?>
<!DOCTYPE html>
<html lang="ko" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, user-scalable=no">
    <title>TEAM PROJECT</title>
    <link rel="stylesheet" href="./css/reset.css">
    <link rel="stylesheet" href="./css/header.css">
    <link rel="stylesheet" href="./css/slider.css">
    <link rel="stylesheet" href="./css/promotion.css">
    <link rel="stylesheet" href="./css/promotion_two.css">
  </head>
  <body>
    <div id="wrap">
      <header class="header cfixed">
        <h1 class="head_logo"><a href="#">Mo,im</a></h1>
        <nav>
          <ul class="head_menu">
            <li><a href="#">MENU</a></li>
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
            <li><a href="./member/source/member_form.php">MEMBERSHIP</a></li>
            <li>
              <?php
                  if(isset($_GET['profile'])){
                    echo "<img style='width:50px; height:50px' src=".$_GET['profile'].">";
                  }
               ?>
            </li>
          </ul>

        </nav>
        <span class="menu-toggle-btn">
          <span></span>
          <span></span>
          <span></span>
        </span>
      </header>
      <article class="slider">
        <img src="./img/main03.jpg" alt="">
      </article>
      <section class="content">
        <section class="display-section">
          <div class="container">
            <h2 class="sec-tit">Social CLUB</h2>
            <p class="desc">취향과 취미가 통하는 곳, 사람과 사람을 통하는 곳, 다양한 분야의 사람들과 <br>
              삶과 경험, 생각을 나누고 그 여정을 떠날 수 있는 곳.
            </p>
          </div>
        </section>
        <br>
        <br>
        <br>
        <section class="promotion-section">
          <div class="about-area">
            <h2>인기 클럽 모임 <b>TOP3</b></h2>
            <div class="about-box">
              <ul class="place-list">
                <li><a href="#"><img class="top-place" src="./img/club01.jpg" alt="">
                  <h3>잠시, 벗어나기</h3>
                  <p class="txt">sns와 인터넷에서 벗어나 이야기와 취미생활을 이끌어 주는 모임</p>
                  <span class="view">미리보기</span></a>
                </li>
                <li><a href="#"><img class="top-place" src="./img/club02.jpg" alt="">
                  <h3>새로운 생각, 새로운 상상</h3>
                  <p class="txt">또다른 나의 잠재력을 이끌어 줄 수 있는 두뇌 모임</p>
                  <span class="view">미리보기</span></a>
                </li>
                <li><a href="#"><img class="top-place" src="./img/club05.jpg" alt="">
                  <h3>길었던 하루, 행복한 사람</h3>
                  <p class="txt">지루했던 일상에서 벗어나 대화와 추억을 공유할 수 있는 사람들의 모임</p>
                  <span class="view">미리보기</span></a>
                </li>
              </ul>
            </div>
          </div>
        </section>
        <hr class="divider">
        <section class="promotion-section-two">
          <div class="about-area-two">
            <h2>모집 중인 모임</h2>
            <div class="about-box-two">
              <ul class="place-list-two">
                <li><a href="./clubing/source/ing_view.php"><img class="top-place-two" src="./img/clubing01.jpg" alt="">
                  <h3>모집모임1</h3>
                  <p class="txt-two">모집 중인 모임 1입니다.</p>
                  <span class="view-two">미리보기</span>
                </a></li>
                <li><a href="#"><img class="top-place-two" src="./img/clubing02.jpg" alt="">
                  <h3>모집모임2</h3>
                  <p class="txt-two">모집 중인 모임 2입니다.</p>
                  <span class="view-two">미리보기</span>
                </a></li>
                <li><a href="#"><img class="top-place-two" src="./img/clubing03.jpg" alt="">
                  <h3>모집모임3</h3>
                  <p class="txt-two">모집 중인 모임 3입니다.</p>
                  <span class="view-two">미리보기</span>
                </a></li>
                <li><a href="#"><img class="top-place-two" src="./img/clubing04.jpg" alt="">
                  <h3>모집모임4</h3>
                  <p class="txt-two">모집 중인 모임 4입니다.</p>
                  <span class="view-two">미리보기</span>
                </a></li>
                <li><a href="#"><img class="top-place-two" src="./img/clubing05.jpg" alt="">
                  <h3>모집모임5</h3>
                  <p class="txt-two">모집 중인 모임 5입니다.</p>
                  <span class="view-two">미리보기</span>
                </a></li>
                <li><a href="#"><img class="top-place-two" src="./img/clubing06.jpg" alt="">
                  <h3>모집모임6</h3>
                  <p class="txt-two">모집 중인 모임 6입니다.</p>
                  <span class="view-two">미리보기</span>
                </a></li>
                <li><a href="#"><img class="top-place-two" src="./img/clubing07.jpg" alt="">
                  <h3>모집모임7</h3>
                  <p class="txt-two">모집 중인 모임 7입니다.</p>
                  <span class="view-two">미리보기</span>
                </a></li>
                <li><a href="#"><img class="top-place-two" src="./img/clubing08.jpg" alt="">
                  <h3>모집모임8</h3>
                  <p class="txt-two">모집 중인 모임 8입니다.</p>
                  <span class="view-two">미리보기</span>
                </a></li>
                <li><a href="#"><img class="top-place-two" src="./img/clubing09.jpg" alt="">
                  <h3>모집모임9</h3>
                  <p class="txt-two">모집 중인 모임 9입니다.</p>
                  <span class="view-two">미리보기</span>
                </a></li>
              </ul>
            </div>
          </div>
        </section>
       <hr class="divider">
      </section>
    </div>
  </body>
</html>
