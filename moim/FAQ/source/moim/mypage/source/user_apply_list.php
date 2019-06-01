<?php
include $_SERVER['DOCUMENT_ROOT']."/moim/lib/session_call.php";
include $_SERVER['DOCUMENT_ROOT']."./moim/lib/db_connector.php";
?>
<!DOCTYPE html>
<html>
<head>
  <link rel="stylesheet" type="text/css" href="../css/user_apply_list.css">
<meta charset="UTF-8">

<?php
  if(isset($_SESSION['userid'])){
    $userid=$_SESSION['userid'];
  }else{
    $userid="";
  }

  $sql="SELECT * from user_club where user_id='$userid' order by user_num desc;";

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
  <div class="user_apply_list_div">
    <h1 class="h1_apply_list">모임신청내역</h1>
       <hr>
  		 <table id="memberlist" class="memberlist">
         <thead>
            <tr>
               <td>순서</td>
               <td>신청인</td>
               <td>모임명</td>
               <td>분야</td>
               <td>모집시작</td>
               <td>모집마감</td>
               <td>모집인원</td>
               <td>가격</td>
               <td>장소</td>
               <td>확인</td>
               <td>처리상태</td>
             </tr>
          </thead>
      <?php


      for($i=$start_row; ($i<$start_row+$rows_scale) && ($i< $total_record); $i++){
        //가져올 레코드 위치 이동
        mysqli_data_seek($result, $i);

        //하나 레코드 가져오기
        $row=mysqli_fetch_array($result);
        $user_num=$row["user_num"];
        $user_id=$row["user_id"];
        $user_name=$row["user_name"];
        $user_category=$row["user_category"];
        $user_start=$row["user_start"];
        $user_end=$row["user_end"];
        $user_to=$row["user_to"];
        $user_price=$row["user_price"];
        $user_rent_info=$row["user_rent_info"];
        $user_check=$row["user_check"];
        ?>
        <tr>
          <td><?=$number?></td>
          <td><?=$user_id?></td>
          <td><?=$user_name?></td>
          <td><?=$user_category?></td>
          <td><?=$user_start?></td>
          <td><?=$user_end?></td>
          <td><?=$user_to?></td>
          <td><?=$user_price?></td>
          <td><?=$user_rent_info?></td>
          <td>
          <?php
            if($user_check=="no"){
           ?>
            <a href="./user_apply_view.php?user_num=<?=$user_num?>&page=<?=$page?>"><button type="button" name="button" id="view">내용</button></a>
           <?php
            }else{
            ?>
            <a href="./user_apply_view.php?user_num=<?=$user_num?>&page=<?=$page?>"><button type="button" name="button" id="view">내용</button></a>
            <?php
            }
             ?>

          </td>
          <td>
            <?php
              if($user_check=="no"){
            ?>
              심사중
            <?php
              }else{
            ?>
              심사완료(이메일 확인 요망)
            <?php
              }
             ?>
          </td>
        </tr>
        <?php
        $number--;
      }
         ?>
   </table>


     	<div id='page_box' style="text-align: center;">
		<?PHP
                #----------------이전블럭 존재시 링크------------------#
                if($start_page > $pages_scale){
                   $go_page= $start_page - $pages_scale;
                   echo "<a id='before_block' href='user_apply_list.php?page=$go_page'> << </a>";
                }
                #----------------이전페이지 존재시 링크------------------#
                if($pre_page){
                    echo "<a id='before_page' href='user_apply_list.php?page=$pre_page'> < </a>";
                }
                 #--------------바로이동하는 페이지를 나열---------------#
                for($dest_page=$start_page;$dest_page <= $end_page;$dest_page++){
                   if($dest_page == $page){
                        echo( "&nbsp;<b id='present_page'>$dest_page</b>&nbsp" );
                    }else{
                        echo "<a id='move_page' href='user_apply_list.php?page=$dest_page'>$dest_page</a>";
                    }
                 }
                 #----------------이전페이지 존재시 링크------------------#
                 if($next_page){
                     echo "<a id='next_page' href='user_apply_list.php?page=$next_page'> > </a>";
                 }
                 #---------------다음페이지를 링크------------------#
                if($total_pages >= $start_page+ $pages_scale){
                  $go_page= $start_page+ $pages_scale;
                  echo "<a id='next_block' href='user_apply_list.php?page=$go_page'> >> </a>";
                 }
       ?>
   </div>
      </div>
</body>
</html>
