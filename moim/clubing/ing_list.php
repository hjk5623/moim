<!DOCTYPE html>
<html lang="ko" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title></title>
    <link rel="stylesheet" href="./css/club.css">
    <link href="https://fonts.googleapis.com/css?family=Noto+Sans+KR" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
    <script>
      var startHeightMin=788; //트리거 시작 스크롤 위치
      var itemHeight=100; // 아이템별 높이
      var itemMax=0; //현재 표시 아이템수
      var itemLimit=0; // 모든 아이템 수
      jQuery(window).scroll(function() {
      itemLimit=jQuery('.btm2_item').length; // 모든 아이템수 btm2_item css class 가 표시될 객채 li
      if(itemMax > itemLimit){ //표시 아이템 수가 모든 아이템수보다 높으면 작동 하지 말아야..
          return;
      }
      cehcksc();
      });

      function cehcksc(){
      //#startdiv 는 해당 객채를 지나가면 작동을 한다 알맞게 변경 (트리거)
          if (jQuery(window).scrollTop() >= ((jQuery(document).height() - jQuery(window).height()) - jQuery('#startdiv').innerHeight())-100) {
                //console.log(jQuery(window).scrollTop()); // startHeightMin 찾기
              var docHeight=jQuery(window).scrollTop() - startHeightMin;
              var itemLength=Math.floor(docHeight/itemHeight); // 스크롤 위치에서 시작 스크롤 위치를 -,출력할 아이템수를 설정
              if(itemMax<itemLength){ // 수가 낮아 졌을때는 표시 안함
                  itemMax=itemLength; // itemMax 갱신
                  jQuery('.btm2_item').each(function(index,item){ //btm2_item
                      if((itemMax-1) >= index){
                          if(jQuery(this).css("display") == "none"){
                              jQuery(this).fadeIn(2000);
                          }
                      }
                  });
              }
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
        <li><a href="../mainpage.php">HOME</a></li>
        <li><a href="#">LOG OUT</a></li>
        <li><a href="#">CLUB LIST</a></li>
        <li><a href="#">INTRO</a></li>
        <li><a href="#">MY PAGE</a></li>
        <li><a href="#">HOME</a></li>
        <li><a href="#">HOME</a></li>
      </ul>
    </nav>
  <section class="sec10"></section>
    <!--***************************************************************************************************-->

  <div id="intd_warp">
    <div class="sline"></div>
    <br>
    <br>
    <br>
    <br>
    <div class="titles">
      <p class="title_large">사용자가 고른 모임1</p>
      <img src="./img/clubing01.jpg" alt="" class="title-img">
    </div>
    <section id="sec1" class="bmt-section bmt-section--no-border">
    <div class="pt2 ">
    <ul class="btm_list">
          <li class="btm_item">
            <h4 class="btm_head">모임 특징</h4>
            <p class="btm_desc">모임특징샘플입니다. 이 모임은 여행을 하는 모임입니다.</p>
          </li>
          <li class="btm_item">
            <h4 class="btm_head">모집 기간</h4>
            <p class="btm_desc">2019-05-16 ~ 2019-12-16</p>
          </li>
          <li class="btm_item">
            <h4 class="btm_head">가격</h4>
            <p class="btm_desc">120,000원</p>
          </li>
        </ul>
    </div>
    </section>

    <section class="bmt-section ">
      <div class="pt1">
      <p class="title_large">상세 정보</p>
      </div>
      <div class="pt2">
      <p class="p2_desc_text">모임1의 상세 정보입니다.</p>
      </div>

      <div class="ss_left"  id="startdiv">
        <p class="ss_title">모임1의 첫번째 특징</p>
        <p class="ss_desc">모임1의 첫번째 특징은 남녀노소 모집을 하고 있고 일상에서 벗어나 각자의 취미와 장점을 드러내어
        사람들과 공유할 수 있습니다.</p>

        <p class="ss_title mgt30">모임1의 두번째 특징</p>
        <p class="ss_desc">모임1의 두번째 특징은 자유로운 시간에 즐길 수 있고 퇴근 시간 및 주말에도 함께 즐길 수 있습니다.</p>
      </div>
    </section>

    <section class="bmt-section" id="sec4">
      <div class="pt1">
      <p class="title_large">모든 모임 보기</p>
      </div>
      <div class="pt2 btm20">
      <p class="p2_desc_text">진행 중인 모든 모임을 보여줍니다.</p>
      </div>
    </section>


    <section class="scroll-sec">
      <div class="img-table">
        <ul id="ullist">
          <li class="btm2_item noshow">
            <div class="container">
              <div class="box">
                <img src="./img/clubing02.jpg" class="btm2_image">
              </div>
                <a href="#" class="club_info">
                <div class="inner">
                  <h4 class="btm2_head">다양한 스킨</h4>
                </div>
                <p class="btm2_desc">모임이름</p>
                <!-- <div class="details">
                  <div class="content">
                  <h2>모임1의 이름</h2>
                  <p>모임1의 정보입니다.간단한 정보와 이름, 특징을 나타내는 곳입니다.</p>
                  </div>
                </div> -->
              </a>
            </div>
          </li>

          <li class="btm2_item noshow">
            <div class="container">
              <div class="box">
                <img src="./img/clubing03.jpg" class="btm2_image">
              </div>
                <a href="#" class="club_info">
                <div class="inner">
                  <h4 class="btm2_head">다양한 스킨</h4>
                </div>
                <p class="btm2_desc">모임이름</p>
                <!-- <div class="details">
                  <div class="content">
                  <h2>모임1의 이름</h2>
                  <p>모임1의 정보입니다.간단한 정보와 이름, 특징을 나타내는 곳입니다.</p>
                  </div>
                </div> -->
              </a>
            </div>
          </li>

          <li class="btm2_item noshow">
            <div class="container">
              <div class="box">
                <img src="./img/clubing04.jpg" class="btm2_image">
              </div>
                <a href="#" class="club_info">
                <div class="inner">
                  <h4 class="btm2_head">다양한 스킨</h4>
                </div>
                <p class="btm2_desc">모임이름</p>
                <!-- <div class="details">
                  <div class="content">
                  <h2>모임1의 이름</h2>
                  <p>모임1의 정보입니다.간단한 정보와 이름, 특징을 나타내는 곳입니다.</p>
                  </div>
                </div> -->
              </a>
            </div>
          </li>

          <li class="btm2_item noshow">
            <div class="container">
              <div class="box">
                <img src="./img/clubing05.jpg" class="btm2_image">
              </div>
                <a href="#" class="club_info">
                <div class="inner">
                  <h4 class="btm2_head">다양한 스킨</h4>
                </div>
                <p class="btm2_desc">모임이름</p>
                <!-- <div class="details">
                  <div class="content">
                  <h2>모임1의 이름</h2>
                  <p>모임1의 정보입니다.간단한 정보와 이름, 특징을 나타내는 곳입니다.</p>
                  </div>
                </div> -->
              </a>
            </div>
          </li>

          <li class="btm2_item noshow">
            <div class="container">
              <div class="box">
                <img src="./img/clubing06.jpg" class="btm2_image">
              </div>
                <a href="#" class="club_info">
                <div class="inner">
                  <h4 class="btm2_head">다양한 스킨</h4>
                </div>
                <p class="btm2_desc">모임이름</p>
                <!-- <div class="details">
                  <div class="content">
                  <h2>모임1의 이름</h2>
                  <p>모임1의 정보입니다.간단한 정보와 이름, 특징을 나타내는 곳입니다.</p>
                  </div>
                </div> -->
              </a>
            </div>
          </li>

          <li class="btm2_item noshow">
            <div class="container">
              <div class="box">
                <img src="./img/clubing07.jpg" class="btm2_image">
              </div>
                <a href="#" class="club_info">
                <div class="inner">
                  <h4 class="btm2_head">다양한 스킨</h4>
                </div>
                <p class="btm2_desc">모임이름</p>
                <!-- <div class="details">
                  <div class="content">
                  <h2>모임1의 이름</h2>
                  <p>모임1의 정보입니다.간단한 정보와 이름, 특징을 나타내는 곳입니다.</p>
                  </div>
                </div> -->
              </a>
            </div>
          </li>

          <li class="btm2_item noshow">
            <div class="container">
              <div class="box">
                <img src="./img/clubing08.jpg" class="btm2_image">
              </div>
                <a href="#" class="club_info">
                <div class="inner">
                  <h4 class="btm2_head">다양한 스킨</h4>
                </div>
                <p class="btm2_desc">모임이름</p>
                <!-- <div class="details">
                  <div class="content">
                  <h2>모임1의 이름</h2>
                  <p>모임1의 정보입니다.간단한 정보와 이름, 특징을 나타내는 곳입니다.</p>
                  </div>
                </div> -->
              </a>
            </div>
          </li>

          <li class="btm2_item noshow">
            <div class="container">
              <div class="box">
                <img src="./img/clubing09.jpg" class="btm2_image">
              </div>
                <a href="#" class="club_info">
                <div class="inner">
                  <h4 class="btm2_head">다양한 스킨</h4>
                </div>
                <p class="btm2_desc">모임이름</p>
                <!-- <div class="details">
                  <div class="content">
                  <h2>모임1의 이름</h2>
                  <p>모임1의 정보입니다.간단한 정보와 이름, 특징을 나타내는 곳입니다.</p>
                  </div>
                </div> -->
              </a>
            </div>
          </li>

          <li class="btm2_item noshow">
            <div class="container">
              <div class="box">
                <img src="./img/clubing10.jpg" class="btm2_image">
              </div>
                <a href="#" class="club_info">
                <div class="inner">
                  <h4 class="btm2_head">다양한 스킨</h4>
                </div>
                <p class="btm2_desc">모임이름</p>
                <!-- <div class="details">
                  <div class="content">
                  <h2>모임1의 이름</h2>
                  <p>모임1의 정보입니다.간단한 정보와 이름, 특징을 나타내는 곳입니다.</p>
                  </div>
                </div> -->
              </a>
            </div>
          </li>

          <li class="btm2_item noshow">
            <div class="container">
              <div class="box">
                <img src="./img/clubing11.jpg" class="btm2_image">
              </div>
                <a href="#" class="club_info">
                <div class="inner">
                  <h4 class="btm2_head">다양한 스킨</h4>
                </div>
                <p class="btm2_desc">모임이름</p>
                <!-- <div class="details">
                  <div class="content">
                  <h2>모임1의 이름</h2>
                  <p>모임1의 정보입니다.간단한 정보와 이름, 특징을 나타내는 곳입니다.</p>
                  </div>
                </div> -->
              </a>
            </div>
          </li>


          <li class="btm2_item noshow">
            <div class="container">
              <div class="box">
                <img src="./img/clubing12.jpg" class="btm2_image">
              </div>
                <a href="#" class="club_info">
                <div class="inner">
                  <h4 class="btm2_head">다양한 스킨</h4>
                </div>
                <p class="btm2_desc">모임이름</p>
                <!-- <div class="details">
                  <div class="content">
                  <h2>모임1의 이름</h2>
                  <p>모임1의 정보입니다.간단한 정보와 이름, 특징을 나타내는 곳입니다.</p>
                  </div>
                </div> -->
              </a>
            </div>
          </li>

          <li class="btm2_item noshow">
            <div class="container">
              <div class="box">
                <img src="./img/clubing13.jpg" class="btm2_image">
              </div>
                <a href="#" class="club_info">
                <div class="inner">
                  <h4 class="btm2_head">다양한 스킨</h4>
                </div>
                <p class="btm2_desc">모임이름</p>
                <!-- <div class="details">
                  <div class="content">
                  <h2>모임1의 이름</h2>
                  <p>모임1의 정보입니다.간단한 정보와 이름, 특징을 나타내는 곳입니다.</p>
                  </div>
                </div> -->
              </a>
            </div>
          </li>

          <li class="btm2_item noshow">
            <div class="container">
              <div class="box">
                <img src="./img/clubing14.jpg" class="btm2_image">
              </div>
                <a href="#" class="club_info">
                <div class="inner">
                  <h4 class="btm2_head">다양한 스킨</h4>
                </div>
                <p class="btm2_desc">모임이름</p>
                <!-- <div class="details">
                  <div class="content">
                  <h2>모임1의 이름</h2>
                  <p>모임1의 정보입니다.간단한 정보와 이름, 특징을 나타내는 곳입니다.</p>
                  </div>
                </div> -->
              </a>
            </div>
          </li>

          <li class="btm2_item noshow">
            <div class="container">
              <div class="box">
                <img src="./img/clubing15.jpg" class="btm2_image">
              </div>
                <a href="#" class="club_info">
                <div class="inner">
                  <h4 class="btm2_head">다양한 스킨</h4>
                </div>
                <p class="btm2_desc">모임이름</p>
                <!-- <div class="details">
                  <div class="content">
                  <h2>모임1의 이름</h2>
                  <p>모임1의 정보입니다.간단한 정보와 이름, 특징을 나타내는 곳입니다.</p>
                  </div>
                </div> -->
              </a>
            </div>
          </li>


          <li class="btm2_item noshow">
            <div class="container">
              <div class="box">
                <img src="./img/clubing02.jpg" class="btm2_image">
              </div>
                <a href="#" class="club_info">
                <div class="inner">
                  <h4 class="btm2_head">다양한 스킨</h4>
                </div>
                <p class="btm2_desc">모임이름</p>
                <!-- <div class="details">
                  <div class="content">
                  <h2>모임1의 이름</h2>
                  <p>모임1의 정보입니다.간단한 정보와 이름, 특징을 나타내는 곳입니다.</p>
                  </div>
                </div> -->
              </a>
            </div>
          </li>
          </ul>
        </div>
      </section>
  </div>
<!-- >>>>>>> f09fa3bab3457d58d4f790b8ab800c435318f5ae -->
  </body>
</html>
