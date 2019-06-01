<?php
include $_SERVER['DOCUMENT_ROOT']."./moim/lib/db_connector.php";

$sql="SELECT * from buy inner join club on buy_club_num = club_num where buy_cancle='yes' and buy_refund='no' ;"; //환불신청 yes, 아직 환불처리 no 리스트
$result = mysqli_query($conn, $sql) or die(mysqli_error($conn));
$total_record= mysqli_num_rows($result);
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
<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8">
  <link rel="stylesheet" href="../css/request_list.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script type="text/javascript">
    function refund_submit(num,id){
      // console.log(num);
      // console.log(id);
      var result1=confirm(id+"회원의 환불을 처리하시겠습니까?");
      if(result1){
        $.ajax({
          url: './admin_query.php?mode=refund_update',
          type: 'POST',
          data: {
            buy_id: id,
            buy_club_num: num
          }
        }) .done(function(result) {
          console.log(result);
          location.href='./admin_refund.php';
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
    <h2 id="h2"><big><strong>환불관리</strong></big></h2>
    <form name="refund" class="" action="admin_query.php?mode=refund_update" method="post">
      <table id="memberlist">
        <thead>
          <tr>
            <td>ORDER NO</td>
            <td>id</td>
            <td>모임이름</td>
            <td>환불취소신청날짜</td>
            <td>환불</td>
          </tr>
        </thead>
        <?php
      for($i=$start_row; ($i<$start_row+$rows_scale) && ($i< $total_record); $i++){
        //가져올 레코드 위치 이동
        mysqli_data_seek($result, $i);
        //하나 레코드 가져오기
        $row=mysqli_fetch_array($result);
        $buy_club_num=$row["buy_club_num"];
        $buy_id=$row["buy_id"];
        $refund_code = $buy_club_num."_".$buy_id;
        $buy_process_date=$row["buy_process_date"];
        $club_name=$row["club_name"];
        $club_name=$row["club_name"];

        ?>
        <tr>
          <td><?=$refund_code?> </td>
          <td><?=$buy_id?></td>
          <td><?=$club_name?></td>
          <td><?=$buy_process_date?> </td>
          <td>
            <button type="button" name="button" id="view" onclick="window.open('https://admin.iamport.kr/payments','_blank', 'width=550 height=500');">거래내역조회</button></a>
            <button type="button" name="button" id="view" onclick="refund_submit(<?=$buy_club_num?>,'<?=$buy_id?>');">환불처리</button></a>
          </td>
        </tr>
        <?php
        $number--;
      }
         ?>
      </table>
    </form>
    <hr>
    <div id='page_box' style="text-align: center;">
      <?PHP
        #----------------이전블럭 존재시 링크------------------#
        if($start_page > $pages_scale){
           $go_page= $start_page - $pages_scale;
           echo "<a id='before_block' href='admin_refund.php?page=$go_page'> << </a>";
        }
        #----------------이전페이지 존재시 링크------------------#
        if($pre_page){
            echo "<a id='before_page' href='admin_refund.php?page=$pre_page'> < </a>";
        }
         #--------------바로이동하는 페이지를 나열---------------#
        for($dest_page=$start_page;$dest_page <= $end_page;$dest_page++){
           if($dest_page == $page){
                echo( "&nbsp;<b id='present_page'>$dest_page</b>&nbsp" );
            }else{
                echo "<a id='move_page' href='admin_refund.php?page=$dest_page'>$dest_page</a>";
            }
         }
         #----------------이전페이지 존재시 링크------------------#
         if($next_page){
             echo "<a id='next_page' href='admin_refund.php?page=$next_page'> > </a>";
         }
         #---------------다음페이지를 링크------------------#
        if($total_pages >= $start_page+ $pages_scale){
          $go_page= $start_page+ $pages_scale;
          echo "<a id='next_block' href='admin_refund.php?page=$go_page'> >> </a>";
         }
       ?>
    </div>

  </article>

</body>

</html>
