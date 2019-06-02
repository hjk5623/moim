<?php
session_start();
if(isset($_SESSION['userid'])){
  $id = $_SESSION['userid'];
}else{
  $id="";
}
header("Cache-Control: no-store, no-cache, must-revalidate");
include $_SERVER['DOCUMENT_ROOT']."./moim/lib/db_connector.php";
include $_SERVER['DOCUMENT_ROOT']."/moim/lib/create_table.php";
create_table($conn, 'notice');
?>

 <!DOCTYPE html>
 <html lang="ko" dir="ltr">
   <head>
     <meta charset="utf-8">
     <meta http-equiv="Cache-Control" content="no-cache">
     <meta http-equiv="Pragma" content="no-cache">
     <link rel="stylesheet" href="../css/write.css">
     <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
     <script src="//cdn.ckeditor.com/4.11.4/standard/ckeditor.js"></script>
     <link rel="stylesheet" href="../css/notice_list.css">
     <script type="text/javascript">
     $(document).ready(function() {
       var modal = document.getElementById('myModal2');
       $("#modal_write").click(function() {
         $(".modal-content2").html("<h2>NOTICE 작성</h2>");
         $(".modal-content2").append("<hr>");
         $(".modal-content2").append(" <div id='faq_div'>");
         $("#faq_div").append("<form name='notice_form' id='notice_form' action='notice_query.php?mode=insert' method='post' enctype='multipart/form-data'>");
         $("#notice_form").append("<table id='table1'>");
         $("#table1").append("<tr id='tr1'>");
         $("#tr1").append("<td colspan='2' class='faq_td'>작성자 - 관리자</td>");
         $("#table1").append("</tr>");
         $("#table1").append("<tr id='tr2'>");
         $("#tr2").append("<td colspan='2'><input type='text' id='notice_subject' name='notice_subject' placeholder='제목' autocomplete='off'><br></td>");
         $("#table1").append("</tr>");
         $("#table1").append("<tr id='tr3'>");
         $("#tr3").append("<td colspan='2'><textarea name='notice_content' rows='2' placeholder='내용' cols='140'></textarea></td>");
         $("#table1").append("</tr>");
         $("#table1").append("<tr id='tr4'>");
         $("#tr4").append("<td class='faq_td'>첨부파일</td>");
         $("#tr4").append("<input type='file' name='upfile'>");
         $("#table1").append("</tr>");

         $("#notice_form").append("<hr>");
         $("#notice_form").append("</table>");
         $("#notice_form").append("<input type='submit' class='button-8' value='Submit'>&nbsp;");
         $("#notice_form").append("<button type='button' class='button-8' name'button'>Close</button>");


         $("#faq_div").append("</form>");
         $(".modal-content2").append("</div>");

         CKEDITOR.replace('notice_content');

         modal.style.display="block";
       });

       $(".modal_view").click(function() {

         var n = $('.modal_view').index(this);

         var notice_hidden_num = $(".notice_hidden_num:eq("+n+")").val();
         var notice_hidden_subject = $(".notice_hidden_subject:eq("+n+")").val();
         var notice_hidden_date = $(".notice_hidden_date:eq("+n+")").val();
         var notice_hidden_content = $(".notice_hidden_content:eq("+n+")").val();
         var notice_hidden_file = $(".notice_hidden_file:eq("+n+")").val();
         var notice_hidden_size = $(".notice_hidden_size:eq("+n+")").val();
         var notice_hidden_hit = $(".notice_hidden_hit:eq("+n+")").val()*1+1;
         var notice_hidden_id = $(".notice_hidden_id:eq("+n+")").val();
         var notice_hidden_copied = $(".notice_hidden_copied:eq("+n+")").val();

         $.ajax({
           url: './notice_query.php?mode=hit_update',
           type: 'POST',
           data: {
             notice_hit: notice_hidden_hit,
             notice_num: notice_hidden_num
           }
         })
         .done(function(result) {
           console.log("success");
           $(".modal-content2").html("<h2>NOTICE</h2>");
           $(".modal-content2").append("<hr>");
           $(".modal-content2").append(" <div id='notice_div'>");
           $("#notice_div").append("<table id='table1' >");
           $("#table1").append("<tr id='tr11'>");
           $("#tr11").append("<td class='notice_td'>작성자</td>");
           $("#tr11").append("<td>"+notice_hidden_id+"</td>");
           $("#table1").append("</tr>");
           $("#table1").append("<tr id='tr22'>");
           $("#tr22").append("<td class='notice_td'>조회</td>");
           $("#tr22").append("<td>"+notice_hidden_hit+"</td>");
           $("#table1").append("</tr>");
           $("#table1").append("<tr id='tr33'>");
           $("#tr33").append("<td class='notice_td'>작성일</td>");
           $("#tr33").append("<td>"+notice_hidden_date+"</td>");
           $("#table1").append("</tr>");
           $("#table1").append("<tr id='tr44'>");
           $("#tr44").append("<td class='notice_td'>제목</td>");
           $("#tr44").append("<td>"+notice_hidden_subject+"</td>");
           $("#table1").append("</tr>");
           $("#table1").append("<tr id='tr55'>");
           $("#tr55").append("<td class='notice_td'>첨부파일</td>");
           if(notice_hidden_copied!=""){
             $("#tr55").append("<td>▷첨부파일 : "+notice_hidden_file+" &nbsp; ("+notice_hidden_size+")<a href='notice_query.php?mode=download&notice_num="+notice_hidden_num+"'>저장</a></td>");
           }
           $("#table1").append("</tr>");
           $("#table1").append("<tr id='tr6'>");
           $("#tr6").append("<td>내용</td>");
           $("#tr6").append("<td>"+notice_hidden_content+"</td>");
           $("#table1").append("</tr>");
           $("#notice_div").append("<hr>");
           $("#notice_div").append("</table>");
            if ("<?=$id?>"=="admin"){
              $("#notice_div").append("<button type='button' class='button-7' onclick='modal_modify("+notice_hidden_num+")'>수정</button>");
              $("#notice_div").append("<a href='notice_query.php?mode=delete&notice_num="+notice_hidden_num+"'><button type='button' class='button-8' name'button'>삭제</button></a>");
            }
           $("#notice_div").append("<button type='button' class='button-8' name'button'>닫기</button>");
           $(".modal-content2").append("</div>");
           $(".hit_span:eq("+n+")").text(notice_hidden_hit);
           $(".notice_hidden_hit:eq("+n+")").val(notice_hidden_hit);
           $("#table1 tr").css("height","60px");
           // $(".notice_td").css("width","100px");
           modal.style.display="block";
         })
         .fail(function() {
           console.log("error");
         })
         .always(function() {
           console.log("complete");
         });

       });

       // Get the <span> element that closes the modal

       $(document).on('click', '.button-8', function(){
         modal.style.display = "none";
       });


       // When the user clicks anywhere outside of the modal, close it
      
     });

       function modal_modify(notice_num){
         $.ajax({
           url: './notice_query.php?mode=select_modify',
           type: 'POST',
           data: {
             notice_num:notice_num
           }
         })
         .done(function(result) {
           console.log("success");
           var json_obj = $.parseJSON(result);
           $(".modal-content2").html("<h2>NOTICE 수정</h2>");
           $(".modal-content2").append("<hr>");
           $(".modal-content2").append("<div id='faq_div'>");
           $("#faq_div").append("<form name='notice_form' id='notice_form' action='notice_query.php?mode=update' method='post' enctype='multipart/form-data'>");
           $("#notice_form").append("<input type='hidden' name='notice_num' value='"+notice_num+"'>");
           $("#notice_form").append("<table id='table1'>");
           $("#table1").append("<tr id='tr1'>");
           $("#tr1").append("<td class='notice_td'>작성자</td>");
           $("#tr1").append("<td>관리자</td>");
           $("#table1").append("</tr>");
           $("#table1").append("<tr id='tr2'>");
           $("#tr2").append("<td class='notice_td'>제목</td>");
           $("#tr2").append("<td><input type='text' id='notice_subject' name='notice_subject' value='"+json_obj[0].subject+"' autocomplete='off'></td>");
           $("#table1").append("</tr>");
           $("#table1").append("<tr id='tr3'>");
           $("#tr3").append("<td class='notice_td'>내용</td>");
           $("#tr3").append("<td><textarea name='notice_content' rows='2' placeholder='내용' cols='140'>"+json_obj[1].content+"</textarea></td>");
           $("#table1").append("</tr>");
           $("#table1").append("<tr id='tr4'>");
           $("#tr4").append("<td class='notice_td' rowspan='2'>첨부파일</td>");
           $("#tr4").append("<td><input type='file' name='upfile' onclick='checkbox()'</td>");
           $("#table1").append("</tr>");
           $("#table1").append("<tr id='tr5'>");
           if(json_obj[2].filename!=""){
             $("#tr5").append("<td>"+json_obj[2].filename+"파일이 등록되어 있습니다.<input type='checkbox' id='check_image' name='check_image' value='1'>삭제</td>");
           }
           $("#table1").append("</tr>");
           $("#notice_form").append("<hr>");
           $("#notice_form").append("</table>");
           $("#notice_form").append("<input type='submit' class='button-8' onclick='document.getElementById('check_image').disabled=false'>");
           $("#notice_form").append("<button type='button' class='button-8' name'button'>Close</button>");
           $("#notice_form .button-8").css("margin-bottom","3%");

           $("#faq_div").append("</form>");
           $(".modal-content2").append("</div>");
           $(".notice_td").css("width","100px");
           CKEDITOR.replace('notice_content');
         })
         .fail(function() {
           console.log("error");
         })
         .always(function() {
           console.log("complete");
         });

       }

       function checkbox(){
         document.getElementById('check_image').checked=true;
         document.getElementById('check_image').disabled=true;
       }
     </script>
     <title></title>
     <?php
     if(isset($_GET["mode"])&&($_GET["mode"]=="search")){
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
     <input type="hidden" id="session_id" value="<?=$id?>">
     <div id="myModal2" class="modal2">
      <div class="modal-content2">

        <span class="close">&times;</span>
      </div>
    </div>
      <?php include "../lib/menu.php"; ?>
      <div class="notice_list">
        <h1 class="notice_list_h1">Notice</h1>
        <div class="search">
          <form name="notice" action="notice_list.php?mode=search" method="post">
           <!-- ▷ 총 <?=$total_record?>개의 게시물이 있습니다. -->
           <select name="find">
             <option value="notice_subject">제목</option>
             <option value="notice_content">내용</option>
           </select>
           <input type="text" name="search">
           <input type="submit" value="검색">
         </form>
       </div>

       <table class="notice_list_table">
         <thead>
          <tr >
             <td id="list_title1" >번호 &nbsp;</td>
             <td id="list_title2" >제목 &nbsp;</td>
             <td id="list_title3" >글쓴이 &nbsp;</td>
             <td id="list_title4" >등록일 &nbsp;</td>
             <td id="list_title5" >조회 &nbsp;</td>
           </tr>
         </thead>


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
      $file_path = "../data/".$notice_file_copied;
      $file_size = filesize($file_path);
      ?>
      <tbody>
        <tr>
           <td id="list_item1"><?=$number?></td>
           <td id="list_item2"><a class="modal_view"><?=$notice_subject?></a></td>
           <td id="list_item3"><?=$notice_id?></td>
           <td id="list_item4"><?=$notice_date?></td>
           <td id="list_item5"><span class="hit_span"><?=$notice_hit?></span></td>
           <input type="hidden" class="notice_hidden_num" value="<?=$notice_num?>">
           <input type="hidden" class="notice_hidden_id" value="<?=$notice_id?>">
           <input type="hidden" class="notice_hidden_subject" value="<?=$notice_subject?>">
           <input type="hidden" class="notice_hidden_date" value="<?=$notice_date?>">
           <input type="hidden" class="notice_hidden_hit" value="<?=$notice_hit?>">
           <input type="hidden" class="notice_hidden_content" value="<?=$notice_content?>">
           <input type="hidden" class="notice_hidden_file" value="<?=$notice_file_name?>">
           <input type="hidden" class="notice_hidden_size" value="<?=$file_size?>">
           <input type="hidden" class="notice_hidden_copied" value="<?=$notice_file_copied?>">

        </tr><!-- end of list_item -->
      </tbody>

       <?php
      $number--;
      }//end of for
        ?>
      </table>
      <div id="button">
        <a href="notice_list.php?page=<?=$page?>">목록</a>

        <?php
          if(!empty($_SESSION['userid'])&&$_SESSION['userid']=='admin') {
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

    </div>
  </body>
</html>
