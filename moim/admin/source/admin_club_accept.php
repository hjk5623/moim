<?php
session_start();
include $_SERVER['DOCUMENT_ROOT']."./moim/lib/db_connector.php";


$mode="";
$present_day=date("Y-m-d");

$sql="SELECT * from `club` where club_end >'$present_day' and club_open='no';";
$result = mysqli_query($conn,$sql);
if (!mysqli_num_rows($result)){
  $total_record = 0;
}else{
  $total_record = mysqli_num_rows($result) or die('Error: ' . mysqli_error($conn));
}

// var_export($total_record);
$row=mysqli_fetch_array($result);



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
$number=$total_record- $start_row;

?>
<!DOCTYPE html>
<html lang="ko" dir="ltr">

<head>
  <meta charset="utf-8">
  <title></title>
  <style media="screen">
    /* #accept_table{
      margin: 0 auto;
    } */
  </style>
</head>

<body>
  <?php
  include $_SERVER['DOCUMENT_ROOT']."/moim/admin/source/admin.php";
  ?>
  <form name="board_form" action="admin_club_accept.php?mode=search" method="post">
    <div class="search_club" style="margin-top:100px;">
        <select name="club_category" id="club_category">
           <option>선택</option>
           <option value="글쓰기">글쓰기</option>
           <option value="요리">요리</option>
           <option value="영화">영화</option>
           <option value="미술">미술</option>
           <option value="사진">사진</option>
           <option value="디자인">디자인</option>
      </select>
    </div>
  <p>전체모임</p>
  <table border="1" id="accept_table">
    <tr>
      <td>모임명</td>
      <td>카테고리</td>
      <td>모집시작일</td>
      <td>모집종료일</td>
      <td>모집정원</td>
      <td>신청인원</td>
      <td>개설여부</td>
    </tr>
    <?php
    mysqli_data_seek($result,$start_row); // 레코드셋의 위치를 가리킨다. result set 에서 원하는 순번의 데이터를 선택하는데 쓰인다
      for($i=$start_row;$i< $start_row+$rows_scale && $i<$total_record; $i++){
        $row=mysqli_fetch_array($result);
        $club_name = $row['club_name'];
        $club_category = $row['club_category'];
        $club_start = $row['club_start'];
        $club_end = $row['club_end'];
        $club_to = $row['club_to'];
        $club_apply=$row['club_apply'];

     ?>
     <tr>
       <td> <?=$club_name?> </td>
       <td> <?=$club_category?> </td>
       <td> <?=$club_start?> </td>
       <td> <?=$club_end?> </td>
       <td> <?=$club_to?> </td>
       <td> <?=$club_apply?> </td>
       <td>
         <input type="button" name="" value="개설">
         <input type="button" name="" value="삭제">
       </td>
     </tr>
   <?php
    } // end of for
    ?>
  </table>
</form>
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
                  echo "<a id='move_page' href='#'>$dest_page</a>";
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

</body>

</html>
