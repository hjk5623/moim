<?php
include $_SERVER['DOCUMENT_ROOT']."./moim/lib/db_connector.php";
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<link rel="stylesheet" href="../css/request_list.css">
<script src="https://ajax.aspnetcdn.com/ajax/jQuery/jquery-3.4.0.min.js"></script>
<?php
  $sql="SELECT * from user_club where user_check='no' order by user_num desc;";
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
 <script>
   function request_disapprove(num){
     console.log(num);
     var result1=confirm("해당 신청모임의 등록을 취소하시겠습니까?");
     if(result1){
     $.ajax({
       url: './admin_query.php?mode=request_disapprove',
       type: 'POST',
       data: {
         user_num: num
       }
     }) .done(function(result) {
       console.log(result);

     })
     .fail(function() {
       console.log("error");
     })
     .always(function() {
       console.log("complete");
     });
     }
   }
 </script>
</head>
<body>
  <?php
  include $_SERVER['DOCUMENT_ROOT']."/moim/admin/source/admin.php";
  ?>
  <article class="main">
    <h2 id="h2"><big><strong>신청모임관리</strong></big></h2>
      <table id="memberlist" border="1">
        <thead>
         <tr>
           <td>NO</td>
           <td>신청인</td>
           <td>모집명</td>
           <td>분야</td>
           <td>모집시작</td>
           <td>모집마감</td>
           <td>마감인원</td>
           <td>모임일정</td>
           <td>가격</td>
           <td>장소</td>
           <td>비고</td>
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
        $user_schedule=$row["user_schedule"];
        $user_price=$row["user_price"];
        $user_rent_info=$row["user_rent_info"];

        ?>
        <tr>
          <td><?=$number?></td>
          <td><?=$user_id?></td>
          <td><?=$user_name?></td>
          <td><?=$user_category?></td>
          <td><?=$user_start?></td>
          <td><?=$user_end?></td>
          <td><?=$user_to?></td>
          <td><?=$user_schedule?></td>
          <td><?=$user_price?></td>
          <td><?=$user_rent_info?></td>
          <td>
            <a href="./admin_request_view.php?user_num=<?=$user_num?>&page=<?=$page?>"><button type="button" name="button" id="view">내용</button></a>
            <!--1. 등록 버튼은 submit으로 하고 등록화면에서 받아서 값 셋팅-->
            <!--2. 등록화면에서 진짜 등록했을때 user_club에서 user_check를 yes로 업데이트할 것-->
            <a href="./admin_club_create2.php?mode=request_create&user_num=<?=$user_num?>"><button type="button" name="button" id="view">등록</button></a>
            <!--1. 취소 버튼을 누르면 user_club에서 user_check를 yes로 업데이트-->
            <!--  처리했느냐 여부.. -->
            <!--파일,이미지 삭제는 마이페이지에서 삭제시킬것-->
            <button type="button" name="button" id="view" onclick="request_disapprove(<?=$user_num?>);">취소</button>
          </td>
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
           echo "<a id='before_block' href='admin_request_list.php?page=$go_page'> << </a>";
        }
        #----------------이전페이지 존재시 링크------------------#
        if($pre_page){
            echo "<a id='before_page' href='admin_request_list.php?page=$pre_page'> < </a>";
        }
         #--------------바로이동하는 페이지를 나열---------------#
        for($dest_page=$start_page;$dest_page <= $end_page;$dest_page++){
           if($dest_page == $page){
                echo( "&nbsp;<b id='present_page'>$dest_page</b>&nbsp" );
            }else{
                echo "<a id='move_page' href='admin_request_list.php?page=$dest_page'>$dest_page</a>";
            }
         }
         #----------------이전페이지 존재시 링크------------------#
         if($next_page){
             echo "<a id='next_page' href='admin_request_list.php?page=$next_page'> > </a>";
         }
         #---------------다음페이지를 링크------------------#
        if($total_pages >= $start_page+ $pages_scale){
          $go_page= $start_page+ $pages_scale;
          echo "<a id='next_block' href='admin_request_list.php?page=$go_page'> >> </a>";
         }
       ?>
    </div>
  </article>
</body>
</html>
