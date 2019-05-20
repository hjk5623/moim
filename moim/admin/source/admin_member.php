<?php
// 회원리스트작업 아직 미정
session_start();
include $_SERVER['DOCUMENT_ROOT']."./moim/lib/db_connector.php";

$kind="";
if(isset($_GET['mode']) && $_GET['mode']=="search"){
  $search_value = $_POST['search_value'];
  $kind = $_POST['kind'];
}
if(empty($search_value)){ //검색을 하지 않는경우 전체 리스트를 보여준다.
    $sql = "SELECT * from `membership`";
}else if($kind=="id1"){ //아이디로 검색하는경우
    $sql="SELECT * from `membership` where id like '%$search_value%' ";
}else if($kind=="name1"){ //이름으로 검색하는 경우
    $sql="SELECT * from `membership` where name like '%$search_value%' ";
}
    $result = mysqli_query($conn, $sql) or die(mysqli_error($conn));
    $total_record = mysqli_num_rows($result); //전체 레코드 수

  //
  // $sql="SELECT * from membership";
  // $result=mysqli_query($conn, $sql) or die("실패원인1 :".mysqli_error($conn));
  // if(!mysqli_num_rows($result)){
  //   $total_record=0;
  // }else{
  //   $total_record=mysqli_num_rows($result) or die("실패원인2 : ".mysqli_error($conn));
  // }
  //

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
    <script src="https://ajax.aspnetcdn.com/ajax/jQuery/jquery-3.4.0.min.js"></script>
    <link rel="stylesheet" type="text/css" href="../css/admin_member.css">
    <script type="text/javascript">

      function check_delete(id){
        console.log(id);
        var result1=confirm("한번 삭제한 자료는 복구할 수 없습니다.?\n정말 삭제하시겠습니까?");
        if(result1){
        $.ajax({
          url: './admin_query.php?mode=memberdel',
          type: 'POST',
          data: {
            user_id: id
          }
        }) .done(function(result) {
          console.log(result);
          location.href='admin_member.php';
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
    <div class="memberlist">
      <!-- <b>회원리스트</b> -->
      <hr>
      <div id="head">
      <h1 id="hr">Member List</h1>
        <div id="search">
          <form action="./admin_member.php?mode=search" method="post" id="form1">
            <select name="kind">
              <option value="id1">아이디</option>
              <option value="name1">이름</option>
            </select>
              <input type="text" name="search_value">
              <input type="submit" value="검색" id="form1">
          </form>
        </div>
    </div>
    <hr>
   <table id="memberlist_table" border="1">
  <?php
  echo "<tr>
        <td>아이디</td>
        <td>이름</td>
        <td>전화번호</td>
        <td>주소</td>
        <td>이메일</td>
        <td>탈퇴</td>
        </tr>";
  //↓가져올 레코드 위치 이동 즉, 레코드셋의 위치. 원하는 순번의 데이터를 선택할때 쓴다.
  mysqli_data_seek($result, $start_row);
  for($i=$start_row; ($i<$start_row+$rows_scale) && ($i< $total_record); $i++){
    //하나 레코드 가져오기
    $row=mysqli_fetch_array($result);
    $item_num=$row["num"];
    $item_id=$row["id"];
    $item_name=$row["name"];
    $item_phone=$row["phone"];
    $item_address=$row["address"];
    $address=explode("/", $item_address);
    $address=$address[1];
    $item_email=$row["email"];

  ?>

    <tr class="memberlist_tr2" style="text-align:center;">
        <input type="hidden" name="id" class="hidden_id" value="<?=$item_id?>">
        <td><?=$item_id?></td>
        <td><?=$item_name?></td>
        <td><?=$item_phone?></td>
        <td><?=$address?></td>
        <td><?=$item_email?></td>
        <td>&nbsp;&nbsp;<button type="button" class="button" onclick="check_delete('<?=$item_id?>');">삭제</button></td>
      </tr>
    <?php

  }
    ?>

</table>
<hr>

  <div id='page_box' style="text-align: center;">
<?PHP
    #----------------이전블럭 존재시 링크------------------#
    if($start_page > $pages_scale){
       $go_page= $start_page - $pages_scale;
       echo "<a id='before_block' href='admin_member.php?mode=$mode&page=$go_page'> << </a>";
    }
    #----------------이전페이지 존재시 링크------------------#
    if($pre_page){
        echo "<a id='before_page' href='admin_member.php?mode=$mode&page=$pre_page'> < </a>";
    }
     #--------------바로이동하는 페이지를 나열---------------#
    for($dest_page=$start_page;$dest_page <= $end_page;$dest_page++){
       if($dest_page == $page){
            echo( "&nbsp;<b id='present_page'>$dest_page</b>&nbsp" );
        }else{
            echo "<a id='move_page' href='admin_member.php?mode=$mode&page=$dest_page'>$dest_page</a>";
        }
     }
     #----------------이전페이지 존재시 링크------------------#
     if($next_page){
         echo "<a id='next_page' href='admin_member.php?mode=$mode&page=$next_page'> > </a>";
     }
     #---------------다음페이지를 링크------------------#
    if($total_pages >= $start_page+ $pages_scale){
      $go_page= $start_page+ $pages_scale;
      echo "<a id='next_block' href='admin_member.php?mode=$mode&page=$go_page'> >> </a>";
     }
   ?>
  </div>

    </div>


  </body>
</html>
