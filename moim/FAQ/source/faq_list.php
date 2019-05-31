<?php
session_start();
header("Cache-Control: no-store, no-cache, must-revalidate");
include $_SERVER['DOCUMENT_ROOT']."./moim/lib/db_connector.php";
include $_SERVER['DOCUMENT_ROOT']."./moim/lib/create_table.php";
?>

 <!DOCTYPE html>
 <html lang="ko" dir="ltr">
   <head>
     <meta charset="utf-8">
     <title></title>
     <link rel="stylesheet" href="../css/faq_list.css">
     <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
     <script type="text/javascript">
      $(document).ready(function() {
          $(".faq_answer").hide();//맨처음 답변탭은 다 숨겨놓는다
          $('.faq_question').click(function(){//답질문을 클릭하면
            var n = $('.faq_question').index(this);//클릭한 질문의 탭을 n에 저장
            if($(".faq_answer:eq("+n+")").css('display')=="none"){//만약 그 질문의 탭이 숨겨져 있지 않다면
              $(".faq_answer").hide();//나머지 질문들은 다 숨기고
              $(".faq_answer:eq("+n+")").show();//클릭한 질문과 같은 n값을 가진 답변은 보여준다
            }else{
              $(".faq_answer:eq("+n+")").hide();//else 그 질문의 탭이 숨겨져 있지 않다면 숨긴다
            }
        	});
        });
     </script>
     <?php
     if(isset($_GET["mode"])&&($_GET["mode"]=="search")){ //검색기능
       $mode = $_GET['mode'];
       $search = $_POST["search"];
       $q_search = mysqli_real_escape_string($conn, $search);
       if(empty($search)){
         echo ("<script>
                 window.alert('검색할 단어를 입력해 주세요')
                 history.go(-1)
                 </script>");
                 exit;
               }
               $sql="SELECT * from `faq` where faq_question like '%$q_search%';";
             }else{
               $sql="SELECT * from `faq` order by faq_num desc";
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
   <?php
    include "../lib/menu.php";
   ?>
   <div class="faq_list">
     <h1 class="faq_list_h1">FaQ</h1>
     <div class="search">
       <form name="faq" action="faq_list.php?mode=search" method="post">
         <!-- ▷ 총 <?=$total_record?>개의 게시물이 있습니다. -->
         <input type="text" name="search" placeholder="질문검색">
         <input type="submit" value="search">
       </form>
     </div>
     <p><i class="fas fa-check fa-fw"></i>원하시는 질문 제목을 클릭하시면 답변이 나옵니다.</p>
     <!-- <hr class="faq_list_hr"> -->

     <table class="faq_list_table">
      <tr>
         <th class="faq_number">번호</th>
         <th class="faq_cate">카테고리</th>
         <th>제목</th>
         <th class="faq_edit_del">비고</th>
       </tr>

   <?php
   for($i=$start_row; ($i<$start_row+$rows_scale) && ($i< $total_record); $i++){
     mysqli_data_seek($result,$i);
     $row = mysqli_fetch_array($result);
     $faq_num=$row['faq_num'];
     $faq_question=$row['faq_question'];
     $faq_answer=$row['faq_answer'];
     $faq_cetegory=$row['faq_cetegory'];
     ?>

       <tr class="faq_question">
         <td><?=$number?></td>
         <td><?=$faq_cetegory?></td>
         <td><?=$faq_question?></td>
         <td>
           <?php
          if(!empty($_SESSION['userid'])&&$_SESSION['userid']=='admin'){
             ?>
           <a href="./faq_write.php?mode=update&faq_num=<?=$faq_num?>">수정</a>
           <a href="./faq_query.php?mode=delete&faq_num=<?=$faq_num?>">삭제</a>
           <?php
          }
           ?>
         </td>
       </tr>
       <tr>
         <td colspan="4" class="faq_answer">답변 : <?=$faq_answer?></td>
       </tr>

       <?php
      $number--;
      }//end of for
        ?>
      </table>
      <div id="button">
        <!-- <a href="faq_list.php?page=?=$page?>">목록</a> -->
        <?php
        if(!empty($_SESSION['userid'])&&$_SESSION['userid']=='admin') {
          echo '<a href="faq_write.php">'."글쓰기".'</a>';
        }
        ?>
      </div><!-- end of button -->
          <div class="page_box"><!-- 페이지 표시하는곳 -->
            <!-- 페이지 표시하는 곳 표기 -->
            <?PHP
              #----------------이전블럭 존재시 링크------------------#
              if($start_page > $pages_scale){
                 $go_page= $start_page - $pages_scale;
                 echo "<a id='before_block' href='faq_list.php?page=$go_page'> ◀◀ </a>";
              }
              #----------------이전페이지 존재시 링크------------------#
              if($pre_page){
                  echo "<a id='before_page' href='faq_list.php?page=$pre_page'> ◁ </a>";
              }
               #--------------바로이동하는 페이지를 나열---------------#
              for($dest_page=$start_page;$dest_page <= $end_page;$dest_page++){
                 if($dest_page == $page){
                      echo( "&nbsp;<b id='present_page'>$dest_page</b>&nbsp" );
                  }else{
                      echo "<a id='move_page' href='faq_list.php?page=$dest_page'>$dest_page</a>";
                  }
               }
               #----------------이전페이지 존재시 링크------------------#
               if($next_page){
                   echo "<a id='next_page' href='faq_list.php?page=$next_page'> ▷ </a>";
               }
               #---------------다음페이지를 링크------------------#
              if($total_pages >= $start_page+ $pages_scale){
                $go_page= $start_page+ $pages_scale;
                echo "<a id='next_block' href='faq_list.php?page=$go_page'> ▶▶ </a>";
               }
             ?>
          </div>
     </div>
 </body>
 </html>
