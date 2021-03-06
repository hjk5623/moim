<?php
session_start();
include $_SERVER['DOCUMENT_ROOT']."./moim/lib/db_connector.php";

$mode="";
$present_day=date("Y-m-d");

//모집기간마감안된모임
$sql="SELECT * from `club` where club_end < '$present_day' and club_open='no' order by club_end asc;";
$result = mysqli_query($conn,$sql);
if (!mysqli_num_rows($result)){
  $total_record = 0;
}else{
  $total_record = mysqli_num_rows($result) or die('Error: ' . mysqli_error($conn));
}

//개설이 완료된 모임
$sql2="SELECT * from `club` where club_open='yes' order by club_end asc;";
$result2 = mysqli_query($conn,$sql2);
if (!mysqli_num_rows($result2)){
  $total_record2 = 0;
}else{
  $flag="open";
  $total_record2 = mysqli_num_rows($result2) or die('Error: ' . mysqli_error($conn));
}


// 페이지 당 글수, 블럭당 페이지 수
$rows_scale=5;
$pages_scale=5;
// 전체 페이지 수 ($total_page) 계산
$total_pages= ceil($total_record/$rows_scale);
if(empty($_GET['page'])){
    $page=1;
}else{
    $page = $_GET['page'];
}
$start_row = $rows_scale * ($page -1) ;
$pre_page = $page>1 ? $page-1 : NULL;
$next_page = $page < $total_pages ? $page+1 : NULL;
$start_page = (ceil($page / $pages_scale ) -1 ) * $pages_scale +1 ;
$end_page= ($total_pages >= ($start_page + $pages_scale)) ? $start_page + $pages_scale-1 : $total_pages;
$number=$total_record - $start_row;


// 전체 페이지 수 ($total_page) 계산
$total_pages2= ceil($total_record2/$rows_scale);
if(empty($_GET['page2'])){
    $page2=1;
}else{
    $page2 = $_GET['page2'];
}
$start_row2 = $rows_scale * ($page2 -1) ;
$pre_page2 = $page2>1 ? $page2-1 : NULL;
$next_page2 = $page < $total_pages2 ? $page+1 : NULL;
$start_page2 = (ceil($page / $pages_scale ) -1 ) * $pages_scale +1 ;
$end_page2= ($total_pages2 >= ($start_page2 + $pages_scale)) ? $start_page2 + $pages_scale2-1 : $total_pages2;
$number2=$total_record2 - $start_row2;

?>
<!DOCTYPE html>
<html lang="ko" dir="ltr">
<head>
  <meta charset="utf-8">
  <title></title>
  <link rel="stylesheet" href="../css/admin_club_accept.css">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css" integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">
  <script src="https://ajax.aspnetcdn.com/ajax/jQuery/jquery-3.4.0.min.js"></script>
  <link rel="stylesheet" href="../../css/modal_alert.css">
  <script type="text/javascript" src="../../js/modal_alert.js"></script>
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css" integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">

  <script type="text/javascript">
    function check_club_accept(to,apply,club_num,club_name){
      modal_alert_cancle("알림","모임명 : "+club_name+" <br>개설하시겠습니까?","open",to,apply,club_num,club_name);
    }
    function club_accept(to,apply,club_num,club_name){
      var club_to=to;
      var club_apply=apply;
      if(club_to/2 > apply){
        modal_alert("알림","신청인원이 부족합니다. <br>모집정원의 1/2 의 신청이 있어야만 개설이 가능합니다.");
      }else{
          $.ajax({
            url: '../../PHPmailer/email.php?mode=open',
            type: 'POST',
            data: {
              club_num: club_num
            }
          }) .done(function(result) {
            console.log(result);
            window.location.href='./admin_query.php?mode=clubaccept&club_num='+club_num;
          })
          .fail(function() {
            console.log("error");
          })
          .always(function() {
            console.log("complete");
          });
        }
    }

    function check_club_delete(club_end, num, club_name){
      modal_alert_cancle("알림","모임명 : "+club_name+" <br>삭제 하시겠습니까?","delete",club_end,num);
    }

    function check_delete(club_end, num, club_name) {
        $.ajax({
          url: '../../PHPmailer/email.php?mode=club_del',
          type: 'POST',
          data: {
            club_num: num
          }
        })
        .done(function(result) {
          console.log(result);
          window.location.href='./admin_query.php?mode=clubdelete&club_num='+num;
        })
        .fail(function() {
          console.log("error");
        })
        .always(function() {
          console.log("complete");
        });
    }
  </script>
</head>
<body>
  <div id="myModal" class="modal">
  <div class="modal-content" id="modal-content">

   </div>
 </div>

  <?php
  include $_SERVER['DOCUMENT_ROOT']."/moim/admin/source/admin.php";
  ?>
  <div class="admin_club_accept">
    <div class="condition_club" >
      <p><i class="fas fa-check fa-fw" style="font-size:20px"></i>모임개설조건 - 모집정원의 1/2 이상의 인원이 신청된 경우 </p>
      <p><i class="fas fa-check fa-fw" style="font-size:20px"></i>모임삭제조건 - 모집종료일이 지나고, 모집정원이 모임개설 조건에 충족하지 못할 경우</p>
    </div>
  <h2><big><strong>모집이 마감된 모임</strong></big></h2>
  <hr class="memberlist_hr">
  <table id="accept_table" class="accept_table">
    <thead>
      <tr>
        <td>모임명</td>
        <td>카테고리</td>
        <td>모집시작일</td>
        <td>모집종료일</td>
        <td>모집정원</td>
        <td>신청인원</td>
        <td>개설 | 삭제</td>
      </tr>
    </thead>
    <?php
    mysqli_data_seek($result,$start_row); // 레코드셋의 위치를 가리킨다. result set 에서 원하는 순번의 데이터를 선택하는데 쓰인다
      for($i=$start_row;$i< $start_row+$rows_scale && $i<$total_record; $i++){
        $row=mysqli_fetch_array($result);
        $club_num = $row['club_num'];
        $club_name = $row['club_name'];
        $club_category = $row['club_category'];
        $club_start = $row['club_start'];
        $club_end = $row['club_end'];
        $club_to = $row['club_to'];
        $club_apply=$row['club_apply'];
     ?>
     <tbody>
       <tr>
         <td> <?=$club_name?> </td>
         <td> <?=$club_category?> </td>
         <td> <?=$club_start?> </td>
         <td> <?=$club_end?> </td>
         <td> <?=$club_to?> </td>
         <td> <?=$club_apply?> </td>
         <td>
           <input type="hidden" name="present_day" id="present_day" value="<?=$present_day?>">
           <input type="button" name="" onclick="check_club_accept(<?=$club_to?>,<?=$club_apply?>,<?=$club_num?>,'<?=$club_name?>');" value="개설">
           <input type="button" name="" onclick="check_club_delete('<?=$club_end?>',<?=$club_num?>,'<?=$club_name?>');" value="삭제">
         </td>
       </tr>
     </tbody>
   <?php
    } // end of for
    ?>

  </table>
<!-- <hr> -->
  <div id='page_box'>
    <?PHP
      #----------------이전블럭 존재시 링크------------------#
      if($start_page > $pages_scale){
         $go_page= $start_page - $pages_scale;
         echo "<a id='before_block' href='#'> << </a>";
      }
      #----------------이전페이지 존재시 링크------------------#
      if($pre_page){
         echo "<a id='before_page'  href='admin_club_accept.php?mode=$mode&page=$pre_page'> < </a>";
      }
      #--------------바로이동하는 페이지를 나열---------------#
      for($dest_page=$start_page;$dest_page <= $end_page;$dest_page++){
             if($dest_page == $page){
                  echo( "&nbsp;<b id='present_page'>$dest_page</b>&nbsp" );
              }else{
                  echo "<a id='move_page' href='admin_club_accept.php?mode=$mode&page=$dest_page'>$dest_page</a>";
              }
           }
      #----------------다음페이지 존재시 링크------------------#
      if($next_page){
          echo "<a id='next_page'  href='admin_club_accept.php?mode=$mode&page=$next_page'> > </a>";
      }
      #---------------다음페이지를 링크------------------#
      if($total_pages >= $start_page+ $pages_scale){
          $go_page= $start_page+ $pages_scale;
          echo "<a id='next_block' href='#'> >> </a>";
      }
   ?>
  </div>


  <!-- 개설이 완료된 모임 리스트 -->
  <h2><big><strong>개설완료된모임</strong></big></h2>
  <hr class="memberlist_hr">
  <table id="accept_table" class="accept_table">
    <thead>
      <tr>
        <td>모임명</td>
        <td>카테고리</td>
        <td>모집시작일</td>
        <td>모집종료일</td>
        <td>모집정원</td>
        <td>신청인원</td>
      </tr>
    </thead>
    <?php
    mysqli_data_seek($result2,$start_row2); // 레코드셋의 위치를 가리킨다. result set 에서 원하는 순번의 데이터를 선택하는데 쓰인다
      for($i=$start_row2;$i< $start_row2+$rows_scale && $i<$total_record2; $i++){
        $row=mysqli_fetch_array($result2);
        $club_num = $row['club_num'];
        $club_name = $row['club_name'];
        $club_category = $row['club_category'];
        $club_start = $row['club_start'];
        $club_end = $row['club_end'];
        $club_to = $row['club_to'];
        $club_apply=$row['club_apply'];
     ?>
     <tbody>
       <tr>
         <td> <?=$club_name?> </td>
         <td> <?=$club_category?> </td>
         <td> <?=$club_start?> </td>
         <td> <?=$club_end?> </td>
         <td> <?=$club_to?> </td>
         <td> <?=$club_apply?> </td>
       </tr>
     </tbody>
   <?php
    } // end of for
    ?>

  </table>
  </form>
  <!-- <hr> -->
  <div id='page_box'>
    <?PHP
      #----------------이전블럭 존재시 링크------------------#
      if($start_page2 > $pages_scale){
         $go_page= $start_page2 - $pages_scale;
         echo "<a id='before_block' href='#'> << </a>";
      }
      #----------------이전페이지 존재시 링크------------------#
      if($pre_page2){
         echo "<a id='before_page'  href='admin_club_accept.php?mode=$mode&page2=$pre_page2'> < </a>";
      }
      #--------------바로이동하는 페이지를 나열---------------#
      for($dest_page2=$start_page2;$dest_page2 <= $end_page2;$dest_page2++){
         if($dest_page2 == $page2){
              echo( "&nbsp;<b id='present_page'>$dest_page2</b>&nbsp" );
          }else{
              echo "<a id='move_page' href='admin_club_accept.php?mode=$mode&page2=$dest_page2'>$dest_page2</a>";
          }
       }
      #----------------다음페이지 존재시 링크------------------#
      if($next_page2){
        echo "<a id='next_page'  href='admin_club_accept.php?mode=$mode&page2=$next_page2'> > </a>";
      }
      #---------------다음페이지를 링크------------------#
      if($total_pages2 >= $start_page2+ $pages_scale){
          $go_page2= $start_page2+ $pages_scale;
          echo "<a id='next_block' href='#'> >> </a>";
      }
    ?>
  </div>
</div><!--admin_club_accept-->
</body>

</html>
