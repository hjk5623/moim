<?php
session_start();
include $_SERVER['DOCUMENT_ROOT']."./moim/lib/db_connector.php";

$mode="";
$present_day=date("Y-m-d");

//모임 전체 리스트
$sql="SELECT * from `club` order by club_num desc";
$result = mysqli_query($conn,$sql);
if (!mysqli_num_rows($result)){
  $total_record = 0;
}else{
  $total_record = mysqli_num_rows($result) or die('Error: ' . mysqli_error($conn));
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
$end_page = ($total_pages >= ($start_page + $pages_scale)) ? $start_page + $pages_scale-1 : $total_pages;
$number = $total_record - $start_row;

?>
<!DOCTYPE html>
<html lang="ko" dir="ltr">
<head>
  <meta charset="utf-8">
  <title></title>
  <link rel="stylesheet" href="../css/admin_club_list.css">
  <style media="screen">
    #accept_table{
      text-align: center;
    }
    a {
      text-decoration: none
    }
    #h2{
      margin-top:100px;
    }
  </style>
  <script src="https://ajax.aspnetcdn.com/ajax/jQuery/jquery-3.4.0.min.js"></script>
  <script type="text/javascript">

  </script>
</head>
<body>
  <?php
  include $_SERVER['DOCUMENT_ROOT']."/moim/admin/source/admin.php";
  ?>
  <div class="admin_club_list">
  <h2 id="h2"><big><strong>CLUB LIST</strong></big></h2>
  <hr class="memberlist_hr">
  <table id="accept_table">
    <thead>
      <tr>
        <td>NO</td>
        <td>모임명</td>
        <td>카테고리</td>
        <td>모집시작일</td>
        <td>모집종료일</td>
        <td>모집정원</td>
        <td>신청인원</td>
        <td>비고</td>
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
     <tr>
       <td> <?=$number?> </td>
       <td> <?=$club_name?> </td>
       <td> <?=$club_category?> </td>
       <td> <?=$club_start?> </td>
       <td> <?=$club_end?> </td>
       <td> <?=$club_to?> </td>
       <td> <?=$club_apply?> </td>
       <td>
          <a href="./admin_club_create_view.php?club_num=<?=$club_num?>"><button type="button" name="button" id="view">내용</button></a>
       </td>
         <input type="hidden" name="present_day" id="present_day" value="<?=$present_day?>">
     </tr>
   <?php
     $number--;
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
         echo "<a id='before_page'  href='admin_club_list.php?mode=$mode&page=$pre_page'> < </a>";
      }
      #--------------바로이동하는 페이지를 나열---------------#
      for($dest_page=$start_page;$dest_page <= $end_page;$dest_page++){
             if($dest_page == $page){
                  echo( "&nbsp;<b id='present_page'>$dest_page</b>&nbsp" );
              }else{
                  echo "<a id='move_page' href='admin_club_list.php?mode=$mode&page=$dest_page'>$dest_page</a>";
              }
           }
      #----------------다음페이지 존재시 링크------------------#
      if($next_page){
          echo "<a id='next_page'  href='admin_club_list.php?mode=$mode&page=$next_page'> > </a>";
      }
      #---------------다음페이지를 링크------------------#
      if($total_pages >= $start_page+ $pages_scale){
          $go_page= $start_page+ $pages_scale;
          echo "<a id='next_block' href='#'> >> </a>";
      }
   ?>
  </div>
</div><!--admin_club_list-->
</body>

</html>
