<?php
session_start();
header("Cache-Control: no-store, no-cache, must-revalidate");
include $_SERVER['DOCUMENT_ROOT']."./moim/lib/db_connector.php";
include $_SERVER['DOCUMENT_ROOT']."/moim/lib/create_table.php";
create_table($conn, 'notice');
if(!isset($_SESSION['userid'])){
  echo "<script>alert('권한이 없습니다');
  window.close();
  </script>";
  exit;
}
?>

 <!DOCTYPE html>
 <html lang="ko" dir="ltr">
   <head>
     <meta charset="utf-8">
     <meta http-equiv="Cache-Control" content="no-cache">
     <meta http-equiv="Pragma" content="no-cache">
     <title></title>
     <?php
     if(isset($_GET["mode"])&&($_GET["mode"]=="search")){
       //제목, 내용, 아이
       $mode = $_GET['mode'];
       $find = $_POST["find"];
       $search = $_POST["search"];
       $q_search = mysqli_real_escape_string($conn, $search);
       if(empty($search)){
         echo ("<script>
                 window.alert('검색할 단어를 입력해 주세요')
                 history.go(-1)
                 </script>");
                 exit;
               }
               $sql="SELECT * from `notice` where $find like '%$q_search%';";
             }else{
               $sql="SELECT * from `notice` order by notice_num desc";
             }
             $result = mysqli_query($conn,$sql);
             $total_record = mysqli_num_rows($result);   //총 레코드 수

             $rows_scale=10;
             $pages_scale=5;
             $total_pages= ceil($total_record/$rows_scale);
             //2.현재페이지 시작번호  페이지가 없으면 디폴트 페이지=1페이지
             if(empty($_GET['page'])){
               $page=1;
             }else{
               $page=$_GET['page'];
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

             //리스트에 보여줄 번호
             $number=$total_record- $start_row;
             ?>
   </head>
   <body>
     <nav>
       <?php include "../lib/menu.php"; ?>
     </nav>
      <table border="1">
       <tr>
         <form name="notice" action="notice_list.php?mode=search" method="post">
         <td>▷ 총 <?=$total_record?>개의 게시물이 있습니다.</td>
         <td>찾기</td>
         <td><select name="find">
           <option value="notice_subject">제목</option>
           <option value="notice_content">내용</option>
           <option value="notice_id">아이디</option>
         </select></td>
         <td><input type="text" name="search"></td>
         <td><input type="submit" value="검색"></td>
       </form>
       </tr>


       <tr>
         <td id="list_title1" >번호 &nbsp;</td>
         <td id="list_title2" >제목 &nbsp;</td>
         <td id="list_title3" >글쓴이 &nbsp;</td>
         <td id="list_title4" >등록일 &nbsp;</td>
         <td id="list_title5" >조회 &nbsp;</td>
       </tr>


      <?php
      for($i=$start_row; ($i<$start_row+$rows_scale) && ($i< $total_record); $i++){
      mysqli_data_seek($result,$i);
      $row = mysqli_fetch_array($result);
      $notice_num=$row['notice_num'];
      $notice_id=$row['notice_id'];
      $notice_subject=$row['notice_subject'];
      $notice_content=$row['notice_content'];
      $notice_date=substr($row['notice_date'], 0,10);
      $notice_hit=$row['notice_hit'];
      $notice_file_name=$row['notice_file_name'];
      $notice_file_copied=$row['notice_file_copied'];
      $notice_file_type=$row['notice_file_type'];
      // $subject = str_replace("\n", "<br>", $subject);
      // $subject = str_replace(" ", "&nbsp;", $subject);
      // $content = str_replace("\n", "<br>", $content);
      // $content = str_replace(" ", "&nbsp;", $content);
      ?>

       <tr>
         <td id="list_item1"><?=$number?></td>
         <td id="list_item2"><a href="./notice_view.php?notice_num=<?=$notice_num?>&page=<?=$page?>&notice_hit=<?=$notice_hit+1?>"><?=$notice_subject?></a></td>
         <td id="list_item3"><?=$notice_id?></td>
         <td id="list_item4"><?=$notice_date?></td>
         <td id="list_item5"><?=$notice_hit?></td>
       </tr><!-- end of list_item -->

       <?php
      $number--;
      }//end of for
        ?>
      </table>

      <div class="page_box"><!-- 페이지 표시하는곳 -->
        <!-- 페이지 표시하는 곳 표기 -->
        <?PHP
          #----------------이전블럭 존재시 링크------------------#
          if($start_page > $pages_scale){
             $go_page= $start_page - $pages_scale;
             echo "<a id='before_block' href='notice_list.php?page=$go_page'> ◀◀ </a>";
          }
          #----------------이전페이지 존재시 링크------------------#
          if($pre_page){
              echo "<a id='before_page' href='notice_list.php?page=$pre_page'> ◁ </a>";
          }
           #--------------바로이동하는 페이지를 나열---------------#
          for($dest_page=$start_page;$dest_page <= $end_page;$dest_page++){
             if($dest_page == $page){
                  echo( "&nbsp;<b id='present_page'>$dest_page</b>&nbsp" );
              }else{
                  echo "<a id='move_page' href='notice_list.php?page=$dest_page'>$dest_page</a>";
              }
           }
           #----------------이전페이지 존재시 링크------------------#
           if($next_page){
               echo "<a id='next_page' href='notice_list.php?page=$next_page'> ▷ </a>";
           }
           #---------------다음페이지를 링크------------------#
          if($total_pages >= $start_page+ $pages_scale){
            $go_page= $start_page+ $pages_scale;
            echo "<a id='next_block' href='notice_list.php?page=$go_page'> ▶▶ </a>";
           }
         ?>
      </div>
    <div id="button">
      <a href="notice_list.php?page=<?=$page?>">목록</a>

      <?php
        // if(!empty($_SESSION['userid'])&&$_SESSION['userid']=='admin') {
          echo '<a href="notice_write.php">'."글쓰기".'</a>';
        // }
        ?>
    </div><!-- end of button -->
  </body>
</html>
