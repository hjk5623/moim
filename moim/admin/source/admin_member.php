<?php

// 회원리스트작업 아직 미정
session_start();
include $_SERVER['DOCUMENT_ROOT']."./moim/lib/db_connector.php";

// if(){
//   $sql="SELECT * from membership where id='$search_id'";
//   $result=mysqli_query($con, $sql) or die("실패원인1 :".mysqli_error($con));
//   if(!mysqli_num_rows($result)){
//     $total_record=0;
//   }else{
//     $total_record=mysqli_num_rows($result) or die("실패원인2 : ".mysqli_error($con));
//   }
//
// }


// 페이지 당 글수, 블럭당 페이지 수
$rows_scale=10;
$pages_scale=10;

// 전체 페이지 수 ($total_page) 계산
$total_pages= ceil($total_record/$rows_scale);

if(empty($_GET['page'])){
    $page=1;
}else{
    $page = $_GET['page'];
}
$start_row= $rows_scale * ($page -1) ;
$pre_page= $page>1 ? $page-1 : NULL;
$next_page= $page < $total_pages ? $page+1 : NULL;
$start_page= (ceil($page / $pages_scale ) -1 ) * $pages_scale +1 ;
$end_page= ($total_pages >= ($start_page + $pages_scale)) ? $start_page + $pages_scale-1 : $total_pages;
$number=$start_row+1;




?>
<!DOCTYPE html>
<html lang="ko" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
  </head>
  <body>
    <?php
    include $_SERVER['DOCUMENT_ROOT']."/moim/admin/source/admin.php";
    ?>
    <b>회원리스트</b>
    <hr>


  </body>
</html>
