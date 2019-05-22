<?php
session_start();
include $_SERVER['DOCUMENT_ROOT']."./moim/lib/db_connector.php";
$userid=$_SESSION['userid'];
?>
<!DOCTYPE html>
<html>
<head>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script type="text/javascript" src="./user.js"></script>
<link rel="stylesheet" type="text/css" href="../css/user_refund.css">
<meta charset="UTF-8">
<?php
  $sql="SELECT * FROM club inner join buy on club.club_num = buy.buy_club_num and buy.buy_id='$userid' and club.club_open='no' and buy.buy_refund='yes' order by buy_num desc;";

  $result = mysqli_query($conn, $sql) or die(mysqli_error($conn));
  $total_record = mysqli_num_rows($result); //전체 레코드 수

// 페이지 당 글수, 블럭당 페이지 수
$rows_scale=3;
$pages_scale=5;

// 전체 페이지 수 ($total_page) 계산
$total_pages= ceil($total_record/$rows_scale);

if(empty($_GET['page'])){
    $page=1;
}else{
    $page = $_GET['page'];
}

// 현재 페이지 시작 위치 = (페이지 당 글 수 * (현재페이지 -1))  [[ EX) 현재 페이지 2일 때 => 3*(2-1) = 3 ]]
$start_row= $rows_scale * ($page -1) ;

// 이전 페이지 = 현재 페이지가 1일 경우. null값.
$pre_page= $page>1 ? $page-1 : NULL;

// 다음 페이지 = 현재페이지가 전체페이지 수와 같을 때  null값.
$next_page= $page < $total_pages ? $page+1 : NULL;

// 현재 블럭의 시작 페이지 = (ceil(현재페이지/블럭당 페이지 제한 수)-1) * 블럭당 페이지 제한 수 +1  [[  EX) 현재 페이지 5일 때 => ceil(5/3)-1 * 3  +1 =  (2-1)*3 +1 = 4 ]]
$start_page= (ceil($page / $pages_scale ) -1 ) * $pages_scale +1 ;

// 현재 블럭 마지막 페이지
$end_page= ($total_pages >= ($start_page + $pages_scale)) ? $start_page + $pages_scale-1 : $total_pages;

$number=$total_record- $start_row;

?>
 <script></script>
</head>
<body>
  <?php
  include $_SERVER['DOCUMENT_ROOT']."/moim/mypage/lib/user_menu.php";
  ?>
   <h1 class="h1_refund">환불내역</h1>
	 <table id="table_refund" class="" border="1">
     <tr>
       <td>순서</td>
       <td>환불번호</td>
       <td>이름</td>
       <td>모임명</td>
       <td>가격</td>
       <td>환불일</td>
       <td>비고</td>
     </tr>
  <?php
    for($i=$start_row; ($i<$start_row+$rows_scale) && ($i< $total_record); $i++){
      //가져올 레코드 위치 이동
      mysqli_data_seek($result, $i);

      //하나 레코드 가져오기
      $row=mysqli_fetch_array($result);
      $club_num=$row["club_num"];
      $buy_id=$row["buy_id"];
      $refund_num=$club_num."_".$buy_id;
      $club_name=$row["club_name"];
      $club_price=$row["club_price"];
      $buy_process_date=$row["buy_process_date"];

      ?>
      <tr>
        <td><?=$number?></td>
        <td><?=$refund_num?></td>
        <td><?=$_SESSION['username']?></td>
        <td><?=$club_name?></td>
        <td><?=$club_price?></td>
        <td><?=$buy_process_date?></td>
        <td></td>
      </tr>
      <?php
      $number--;
    }
       ?>
 </table>
 <hr>
 <div id='page_box' style="text-align: center;">
	<?PHP
    #----------------이전블럭 존재시 링크------------------#
    if($start_page > $pages_scale){
       $go_page= $start_page - $pages_scale;
       echo "<a id='before_block' href='user_club_list.php?page=$go_page'> << </a>";
    }
    #----------------이전페이지 존재시 링크------------------#
    if($pre_page){
        echo "<a id='before_page' href='user_club_list.php?page=$pre_page'> < </a>";
    }
     #--------------바로이동하는 페이지를 나열---------------#
    for($dest_page=$start_page;$dest_page <= $end_page;$dest_page++){
       if($dest_page == $page){
            echo( "&nbsp;<b id='present_page'>$dest_page</b>&nbsp" );
        }else{
            echo "<a id='move_page' href='user_club_list.php?page=$dest_page'>$dest_page</a>";
        }
     }
     #----------------이전페이지 존재시 링크------------------#
     if($next_page){
         echo "<a id='next_page' href='user_club_list.php?page=$next_page'> > </a>";
     }
     #---------------다음페이지를 링크------------------#
    if($total_pages >= $start_page+ $pages_scale){
      $go_page= $start_page+ $pages_scale;
      echo "<a id='next_block' href='user_club_list.php?page=$go_page'> >> </a>";
     }
   ?>
 </div>
</body>
</html>
