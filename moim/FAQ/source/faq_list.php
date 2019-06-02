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
     <link rel="stylesheet" href="../css/write.css">
     <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
     <script src="//cdn.ckeditor.com/4.11.4/standard/ckeditor.js"></script>
     <script type="text/javascript">
     $(document).ready(function() {
       var modal = document.getElementById('myModal2');
       $("#modal_write").click(function() {
         $(".modal-content2").html("<h2>FAQ 작성</h2>");
         $(".modal-content2").append("<hr>");
         $(".modal-content2").append(" <div id='faq_div'>");
         $("#faq_div").append("<form name='faq_form' id='faq_form' action='faq_query.php?mode=insert' method='post'>");
         $("#faq_form").append("<table id='table1'>");
         $("#table1").append("<tr id='tr1'>");
         $("#tr1").append("<td colspan='2'><input type='text' id='faq_cetegory' name='faq_cetegory' placeholder='카테고리' autocomplete='off'></td>");
         $("#table1").append("</tr>");
         $("#table1").append("<tr id='tr2'>");
         $("#tr2").append("<td colspan='2'><input type='text' name='faq_question' placeholder='제목입력' autocomplete='off'></td>");
         $("#table1").append("</tr>");
         $("#table1").append("<tr id='tr3'>");
         $("#tr3").append("<td colspan='2'><p>아래 내용을 입력해주세요.</p><textarea name='faq_answer' rows='15' placeholder='답변입력'></textarea></td>");
         $("#table1").append("</tr>");
         $("#faq_form").append("<hr>");
         $("#faq_form").append("</table>");
         $("#faq_form").append("<input type='submit' class='button-8' value='Submit'>&nbsp;<button type='button' class='button-8' name'button'>Close</button></td>");
         $("#faq_div").append("</form>");
         $(".modal-content2").append("</div>");

         // $(".faq_td").css("width","100");
         // $("#faq_cetegory").css("width","900");
         // $("#faq_cetegory").css("height","30");

         CKEDITOR.replace('faq_answer');

         modal.style.display="block";
       });

       $(".modal_modify").click(function() {
         var n = $('.modal_modify').index(this);
         var faq_hidden_num = $(".faq_hidden_num:eq("+n+")").val();
         var faq_hidden_question = $(".faq_hidden_question:eq("+n+")").val();
         var faq_hidden_answer = $(".faq_hidden_answer:eq("+n+")").val();
         var faq_hidden_cetegory = $(".faq_hidden_cetegory:eq("+n+")").val();

         $(".modal-content2").html("<h2>FAQ 수정</h2>");
         $(".modal-content2").append("<hr>");
         $(".modal-content2").append(" <div id='faq_div'>");
         $("#faq_div").append("<form name='faq_form' id='faq_form' action='faq_query.php?mode=update' method='post'>");
         $("#faq_form").append("<input type='hidden' name='faq_num' value=\""+faq_hidden_num+"\" >");
         $("#faq_form").append("<table id='table1'>");
         $("#table1").append("<tr id='tr1'>");
         $("#tr1").append("<td colspan='2'><input type='text' id='faq_cetegory' name='faq_cetegory' placeholder='카테고리' value=\""+faq_hidden_cetegory+"\" autocomplete='off'></td>");
         $("#table1").append("</tr>");
         $("#table1").append("<tr id='tr2'>");
         // $("#tr2").append("<td colspan='2'><textarea name='faq_question' rows='2' placeholder='질문입력' cols='140'>"+faq_hidden_question+"</textarea></td>");
         $("#tr2").append("<td colspan='2'><input type='text' name='faq_question' placeholder='제목입력' autocomplete='off' value=\""+faq_hidden_question+"\"></td>");
         $("#table1").append("</tr>");
         $("#table1").append("<tr id='tr3'>");
         $("#tr3").append("<td><textarea name='faq_answer' rows='15' placeholder='답변입력' cols='140'>"+faq_hidden_answer+"</textarea></td>");
         $("#table1").append("</tr>");
         $("#faq_form").append("<hr>");
         $("#faq_form").append("</table>");
         $("#faq_form").append("<input type='submit' class='button-8' value='Submit'>&nbsp;<button type='button' class='button-8' name'button'>Close</button></td>");
         $("#faq_div").append("</form>");
         $(".modal-content2").append("</div>");

         // $(".faq_td").css("width","100");
         // $("#faq_cetegory").css("width","900");
         // $("#faq_cetegory").css("height","30");

         CKEDITOR.replace('faq_answer');

         modal.style.display="block";
       });
       // Get the <span> element that closes the modal

       $(document).on('click', '.button-8', function(){
         modal.style.display = "none";
       });


       // When the user clicks anywhere outside of the modal, close it
       
     });

     </script>
     <script type="text/javascript">
      $(document).ready(function() {
          $(".faq_answer").hide();//맨처음 답변탭은 다 숨겨놓는다
          $('.faq_click').click(function(){//답질문을 클릭하면
            var n = $('.faq_click').index(this);//클릭한 질문의 탭을 n에 저장
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
   <div id="myModal2" class="modal2">
    <div class="modal-content2">

      <span class="close">&times;</span>
    </div>
  </div>
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
     $faq_answer= htmlspecialchars_decode($faq_answer);
     $faq_cetegory=$row['faq_cetegory'];
     ?>

       <tr class="faq_question">
         <td><?=$number?></td>
         <td><?=$faq_cetegory?></td>
         <td class="faq_click"><?=$faq_question?></td>
         <input type="hidden" class="faq_hidden_num" value="<?=$faq_num?>">
         <input type="hidden" class="faq_hidden_question" value="<?=$faq_question?>">
         <input type="hidden" class="faq_hidden_answer" value="<?=$faq_answer?>">
         <input type="hidden" class="faq_hidden_cetegory" value="<?=$faq_cetegory?>">
         <td>
           <?php
          if(!empty($_SESSION['userid'])&&$_SESSION['userid']=='admin'){
             ?>
           <a class="modal_modify">수정</a>
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
          // echo '<a href="faq_write.php">'."글쓰기".'</a>';
          echo '<a id="modal_write">'."글쓰기".'</a>';
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
