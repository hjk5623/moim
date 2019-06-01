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
    a{color:#000;}

    .modal {
        display: none; /* Hidden by default */
        position: fixed; /* Stay in place */
        z-index: 10; /* Sit on top */
        left: 0;
        top: 0;
        width: 100%; /* Full width */
        height: 100%; /* Full height */
        overflow: auto; /* Enable scroll if needed */
        background-color: rgb(0,0,0); /* Fallback color */
        background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
      }

    /* Modal Content/Box */
    .modal-content {

        background-color: #fefefe;
        margin: 15% auto; /* 15% from the top and centered */
        padding: 20px;
        border: 1px solid #888;
        width: 50%; /* Could be more or less, depending on screen size */
    }
    /* The Close Button */
    .close {
        color: #aaa;
        float: right;
        font-size: 28px;
        font-weight: bold;
    }
    .close:hover,
    .close:focus {
        color: black;
        text-decoration: none;
        cursor: pointer;
    }
  </style>
  <script src="https://ajax.aspnetcdn.com/ajax/jQuery/jquery-3.4.0.min.js"></script>
  <script type="text/javascript">
    function agit_delete(num,name){
      var agit_num= num;
      var agit_name= name;
      // console.log(agit_name);
      var result = confirm("✔" + name + "를 삭제하시겠습니까?\n 정말 삭제하시겠습니까?");
      if (result) {
        $.ajax({
            url: './admin_query.php?mode=agit_delete',
            type: 'POST',
            data: {
              agit_num: agit_num
            }
          }).done(function(result) {
            console.log(result);
            location.href = 'admin_agit_list.php';
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
  <!--modal test  -->
  <div id="myModal" class="modal">
    <!-- Modal content -->
    <div class="modal-content">
      <span class="close">&times;</span>
      <table class="create_view_table">
        <tr>
        <td>이름</td>
          <td colspan="2" id="modal_name"></td>
        </tr>
        <tr>
          <td id="write_td">주소</td>
          <td id="modal_address"></td>
        </tr>
        <tr>
          <!-- <td>아지트대표이미지</td> -->
          <td colspan="3">
            <img src="" width="" id="modal_img0">
            <img src="" width="" id="modal_img1">
            <img src="" width="" id="modal_img2">
            <img src="" width="" id="modal_img3">
          </td>
        </tr>
        <!-- <tr>
          <td colspan="3">내용</td>
        </tr> -->
        <tr>
          <td colspan="3" id="modal_content">

          </td>
        </tr>
        </table>
    </div>
</div>
<!-- ↑↑↑↑↑↑ end of modal test  -->

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
          <!-- <a href="./admin_agit_view.php?agit_num=   "> -->
            <button type="button" name="button" id="myBtn" class="myBtn">내용</button>
            <input type="hidden" class="hidden_agit" value="<?=$agit_num?>">
          <!-- </a> -->
          <button type="button" name="button" id="view" onclick="agit_delete(<?=$agit_num?>,'<?=$agit_name?>')">삭제</button></a>
       </td>
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
                  echo( "&nbsp;<b id='present_page'>$dest_page&nbsp&nbsp</b>&nbsp" );
              }else{
                  echo "<a id='move_page' href='admin_agit_list.php?mode=$mode&page=$dest_page'>$dest_page&nbsp&nbsp</a>";
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
<!--modal script  주의: modal div 의 아이디 , 버튼의 아이디 맞춰줄것 -->
<script type="text/javascript">

  var modal = document.getElementById('myModal');

  $('.myBtn').click(function(event) {
    var n = $('.myBtn').index(this);
    var hidden_agit = $(".hidden_agit:eq("+n+")").val();
    $.ajax({
      url: './admin_query.php?mode=agit_modal',
      type: 'POST',
      data: {hidden_agit: hidden_agit}
    })
    .done(function(result) {
      console.log(result);
      var json_obj = $.parseJSON(result);
      console.log("success");
      $("#modal_name").html(json_obj[0].agit_name);
      $("#modal_address").html(json_obj[2].agit_address);
      modal_content = json_obj[1].agit_content.replace(/\*\*\*/gi, " ");
      $("#modal_content").html(modal_content);
      modal.style.display = "block";
      $("#modal_img0").prop('src', '../data/'+json_obj[3].agit_image_copied0);
      $("#modal_img1").prop('src', '../data/'+json_obj[4].agit_image_copied1);
      $("#modal_img2").prop('src', '../data/'+json_obj[5].agit_image_copied2);
      $("#modal_img3").prop('src', '../data/'+json_obj[6].agit_image_copied3);

      $("#modal_img0").prop('width', '600');
      $("#modal_img1").prop('width', '600');
      $("#modal_img2").prop('width', '600');
      $("#modal_img3").prop('width', '600');


    })

    .fail(function() {
      console.log("error");
    })
    .always(function() {
      console.log("complete");
    });


  });

    // Get the <span> element that closes the modal
    var span = document.getElementsByClassName("close")[0];

    // When the user clicks on <span> (x), close the modal
    span.onclick = function() {
        modal.style.display = "none";
    }

    // When the user clicks anywhere outside of the modal, close it
    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }

</script>
