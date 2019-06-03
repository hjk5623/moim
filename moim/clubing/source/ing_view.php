<?php
session_start();
include $_SERVER['DOCUMENT_ROOT']."/moim/lib/db_connector.php";
include $_SERVER['DOCUMENT_ROOT']."/moim/lib/create_table.php";
create_table($conn, 'club');
create_table($conn, 'club_ripple');

$userid= (isset($_SESSION['userid'])) ? $_SESSION['userid'] : "";
$club_num= (isset($_GET["club_num"])) ? $_GET["club_num"] : "";
$mode= (isset($_GET["mode"])) ? $_GET["mode"] : "";

 if(!empty($club_num) && isset($club_num)){
   $sql = "select * from club where club_num='$club_num'";
 }
 $result = mysqli_query($conn, $sql) or die(mysqli_error($conn));
 $row= mysqli_fetch_array($result);

 $club_num= $row['club_num'];
 $club_name= $row['club_name'];
 $club_content= $row['club_content'];
 $club_content= htmlspecialchars_decode($club_content);
 $club_category= $row['club_category'];
 $club_price= $row['club_price'];
 $club_to= $row['club_to'];
 $club_rent_info= $row['club_rent_info'];
 $club_start= $row['club_start'];
 $club_end= $row['club_end'];
 $club_apply= $row['club_apply'];
 $club_schedule= $row['club_schedule'];
 $club_hit= $row['club_hit']+1;
 $club_open= $row['club_open'];
 $club_image_copied= $row['club_image_copied'];
 $club_file_copied= $row['club_file_copied'];
 $club_file_name= $row['club_file_name'];
 $club_intro= $row['club_intro'];

 $sql= "UPDATE club SET `club_hit`='$club_hit' WHERE `club_num`='$club_num'";
 mysqli_query($conn, $sql) or die(mysqli_error($conn));

?>
<!DOCTYPE html>
<html lang="ko" dir="ltr">
 <head>
   <meta charset="utf-8">
   <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, user-scalable=no">
   <link rel="stylesheet" href="../css/club.css">
   <link rel="stylesheet" href="../css/clubing_view.css">
   <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css" integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">
   <link href="https://fonts.googleapis.com/css?family=Noto+Sans+KR" rel="stylesheet">
   <title></title>
   <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
  <link rel="stylesheet" href="../../css/modal_alert.css">
  <link rel="stylesheet" href="../../css/message_modal.css">
  <script type="text/javascript" src="../../js/modal_alert.js"></script>
  <script type="text/javascript" src="../../js/message.js"></script>
  <script type="text/javascript">
  function message_form(){
   var popupX = (window.screen.width/2)-(600/2);
   var popupY = (window.screen.height/2)-(600/2);
   window.open('../../message/source/msg.php','','left='+popupX+',top='+popupY+', width=550, height=600, status=no, scrollbars=no');
 }
 window.onclick = function(event) {
   var modal = document.getElementById('myModal');
     if (event.target == modal) {
         modal.style.display = "none";
     }
 };
 </script>
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
               // console.log(jQuery(window).scrollTop()); // startHeightMin 찾기
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

     function check_delete_alert(num){
       modal_alert_cancle("알림","모임을 삭제하시겠습니까?","ing_query.php?mode=c_delete&club_num="+num);
     }
   </script>
   <style media="screen">
     #way li{
       list-style: none;
       display: inline-block;
       text-align: right;
       font-size: 13px;
       color: gray;
     }
     ul#way{
       padding: 0;
       margin-block-end: 5px;
     }
     #way li a{
       color: gray;
       text-decoration:none;
     }

   </style>
 </head>
 <body>
   <form name="msg_form" action="../../message/source/msg_query.php?mode=send" method="post">
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
<div id="myModal" class="modal">
  <div class="modal-content" id="modal-content">

   </div>
 </div>
   <nav>
     <div class="brand">
       <a href="../../mainpage.php">
       <h2>Mo,im</h2>
       </a>
     </div>
     <ul>
       <li><a href="../../club_list/source/list.php">CLUB LIST</a></li>
       <li><a href="../../faq/source/faq_list.php">BOARD</a></li>
       <?php
         if($_SESSION['userid']=="admin"){
           echo ('<li><a href="#" onclick="message_form();">MESSAGE</a></li>');
         }else{
           echo ('<li><a href="#" onclick="open_modal();">MESSAGE</a></li>');
         }
        ?>
       <li><a href="../../mypage/source/user_check.php">MY PAGE</a></li>
       <?php
       if(!isset($_SESSION['userid'])){
         echo ('<li><a href="../../login/source/login.php">LOG IN</a></li>');
       }else{
         echo ('<li><a href="../../login/source/logout.php">LOG OUT</a></li>');
       }
       ?>
     </ul>
   </nav>
   <section class="sec1"></section>
   <section class="club_view_sec">
     <div class="club_view">
       <div class="club_info">
         <div class="club_img">
           <ul id=way>
             <li><a href="./ing_list.php">진행중 모임</a> > </li>
             <li><a href="./ing_list.php?mode=<?=$mode?>"><?=$mode?></a></li>
           </ul>
           <div class="club_view_name"><b><?=$club_name?></b></div>

           <img src="../../admin/data/<?=$club_image_copied?>" width="500px" height="400px">
         </div>
         <div class="club_div">
            <div class="club_view_apply"><b>신청인원</b> |&nbsp;&nbsp;<?=$club_apply?>/<?=$club_to?>명</div>
            <div class=""><b>신청기간</b> |&nbsp;&nbsp;<?=$club_start?>~<?=$club_end?></div>
            <div class=""><b>모임날짜</b> |&nbsp;&nbsp;<?=$club_schedule?></div>
            <div class=""><b>모임장소</b> |&nbsp;&nbsp;<?=$club_rent_info?></div>
            <div class="club_view_intro"><b><?=$club_intro?></b></div>
            <div class="club_view_price"><b><?=number_format($club_price)?>원</b></div>
            <?php
            //관리자만 수정/삭제 버튼이 보임
            if(!empty($userid) && $userid==="admin"){ ?>
              <!-- <button type="button" name="button">수정</button> -->
              <div class="club_div_btn">
                <button type="button" name="button" onclick="check_delete_alert(<?=$club_num?>)">삭제</button>
                <button type="button" name="button" onclick="location.href='../../admin/source/admin_club_create.php?mode=update&club_num=<?=$club_num?>'">수정</button>
              </div>
            <?php } ?>
          </div>
       </div><!--club_info-->
       <hr class="divider">

       <div class="club_view_content"><b><?=$club_content?></b></div>
       <div class="club_view_copied">
         <b>세부사항:
       <?php
         //1. 해당된 가입자이고, 파일이 있으면 파일명,사이즈,실제위치 정보확인
         if(!empty($userid)&&!empty($club_file_copied)){
           $mode="download";
           $file_path= "../../admin/data/$club_file_copied";
           $file_size= filesize($file_path);

           //2. 업로드된 이름을 보여주고 [저장] 할것인지 선택
           echo ("
           $club_file_name ($file_size Byte)
           <a href='query.php?mode=$mode&club_num=$club_num'>저장</a>
           ");
         }//end of if
       ?>
         </b><!--end of 세부사항-->
       </div> <!--end of club_view_copied-->
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
      </div><!--club_view-->
    </section> <!--end of club_view_sec-->

       <section class="ripple_section"> <!--후기-->
         <hr class="divider">
         <div class="ripple"> <!--임시 클래스명임. 바꿀겁니다-->
           <h3 class="ss_title">후기</h3>
           <div id="ripple_insert">
             <div id="ripple_textarea">
               <textarea name="c_ripple_content" id="c_ripple_content" placeholder="후기를 작성해주세요."></textarea>
               <button type="button" name="button" id="ripple_btn">후기 등록</button>
               <p id="test_p"></p>
             </div>
           </div><!--end of ripple_insert  -->
           <div> <!-- 작성된 후기를 보여주는 부분 -->
             <ul>
               <li class="col-md-6 col-md-offset-3 results"></li>
             </ul>
             <div class="ripple_back_btn">
               <button type="button" class="btn btn-default" id="loadmorebtn" name="button"><i class="far fa-arrow-alt-circle-down"></i>&nbsp;&nbsp;이전 댓글보기</button>
             </div>
           </div><!--end of div 후기 리스트-->
           <input type="hidden" id="hidden_num" value="<?=$club_num?>">
           <input type="hidden" id="hidden_id" value="<?=$userid?>">

           <script type="text/javascript" src="../js/ing_ripple.js"></script> <!--후기-->

         </div> <!-- end of ripple -->
       </section><!--end of ripple_section 후기-->

       <hr class="divider" id="startdiv">

       <section class="gallery" id="gallery_id">
        <?php
        $today= substr(date("Y-m-d"),2); //오늘날짜를 19-05-27 형태로 만든다.

        //전체보기
        $sql = "SELECT * FROM club WHERE club_open='yes' and SUBSTRING(`club_schedule`,-8,8) > '$today' ORDER BY club_hit desc";
        $result= mysqli_query($conn, $sql) or die(mysqli_error($conn));
        $row_count= mysqli_num_rows($result);
        for($i=1; $i<=$row_count; $i++){
          $row= mysqli_fetch_array($result);
          $club_num= $row['club_num'];
          $club_name= $row['club_name'];
          $club_category= $row['club_category'];
          $club_image_copied=$row['club_image_copied'];
          $club_intro=$row['club_intro'];

          $row_length= 150;

          if (strlen($club_intro) > $row_length) {
            $club_intro = substr($club_intro, 0 , $row_length).'<br>.....';
         }
         ?>
         <figure class="gallery_item noshow btm2_item">
           <a href="./ing_view.php?club_num=<?=$club_num?>&mode=<?=$club_category?>" id="">
             <img src="../../admin/data/<?=$club_image_copied?>" alt="" class="gallery_image">
             <h3><?=$club_name?></h3>
             <figcaption class="gallery_image_caprion"><?=$club_intro?></figcaption>
           </a>
         </figure>
         <?php
       } //end of for
         ?>
      </section><!--end of gallery-->
 </body>
</html>
