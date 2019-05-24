<?php
session_start();
include $_SERVER['DOCUMENT_ROOT']."./moim/lib/db_connector.php";

$mode="";
$kind="";
if(isset($_GET['mode']) && $_GET['mode']=="search"){
  $search_value = $_POST['search_value'];
  $kind = $_POST['kind'];
}
if(empty($search_value)){ //검색을 하지 않는경우 전체 리스트를 보여준다.
  $sql="SELECT * from `agit` order by agit_num desc";
}else if($kind=="agit_name"){ //아지트 이름으로 검색하는 경우
  $sql="SELECT * from `agit` where `agit_name` like '%$search_value%' ";
}else if($kind=="agit_addr"){ //아지트 주소로 검색하는 경우
  $sql="SELECT * from `agit` where `agit_address` like '%$search_value%' ";
}


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
  <link rel="stylesheet" href="../css/admin_agit_list.css">
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
  <div id="head">
    <h2 id="hr"><big><strong>Agit LIST</strong></big></h2>
        <div class="search">
          <form action="./admin_agit_list.php?mode=search" method="post" id="form1">
            <select name="kind" class="kind_sel">
              <option value="agit_name">아지트이름</option>
              <option value="agit_addr">주소</option>
            </select>
            <input type="text" name="search_value">
            <input type="submit" value="search" id="form1">
          </form>
        </div>
      </div>
    <hr class="memberlist_hr">
  <table id="accept_table">
    <thead>
      <tr>
        <td>NO</td>
        <td>아지트이름</td>
        <td>주소</td>
        <td>비고</td>
      </tr>
    </thead>
    <?php
    mysqli_data_seek($result,$start_row); // 레코드셋의 위치를 가리킨다. result set 에서 원하는 순번의 데이터를 선택하는데 쓰인다
      for($i=$start_row;$i< $start_row+$rows_scale && $i<$total_record; $i++){
        $row=mysqli_fetch_array($result);
        $agit_num = $row['agit_num'];
        $agit_name = $row['agit_name'];
        $agit_address = $row['agit_address'];
     ?>
     <tr>
       <td> <?=$number?> </td>
       <td> <?=$agit_name?> </td>
       <td> <?=$agit_address?> </td>
       <td>
          <a href="./admin_agit_view.php?agit_num=<?=$agit_num?>"><button type="button" name="button" id="view">내용</button></a>
          <a href="./admin_agit_view.php?agit_num=<?=$agit_num?>"><button type="button" name="button" id="view">삭제</button></a>
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
         echo "<a id='before_page'  href='admin_agit_list.php?mode=$mode&page=$pre_page'> < </a>";
      }
      #--------------바로이동하는 페이지를 나열---------------#
      for($dest_page=$start_page;$dest_page <= $end_page;$dest_page++){
             if($dest_page == $page){
                  echo( "&nbsp;<b id='present_page'>$dest_page</b>&nbsp" );
              }else{
                  echo "<a id='move_page' href='admin_agit_list.php?mode=$mode&page=$dest_page'>$dest_page</a>";
              }
           }
      #----------------다음페이지 존재시 링크------------------#
      if($next_page){
          echo "<a id='next_page'  href='admin_agit_list.php?mode=$mode&page=$next_page'> > </a>";
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
