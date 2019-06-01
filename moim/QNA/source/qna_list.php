<?php
session_start();
$id = $_SESSION['userid'];
header("Cache-Control: no-store, no-cache, must-revalidate");
include $_SERVER['DOCUMENT_ROOT']."./moim/lib/db_connector.php";
include $_SERVER['DOCUMENT_ROOT']."/moim/lib/create_table.php";
create_table($conn, 'qna');
create_table($conn, 'ripple');
if(!isset($_SESSION['userid'])){  //로그인페이지로 보내기
  echo "<script>alert('권한이 없습니다');
  window.location.href = '../../login/source/login.php';
  </script>";
  exit;
}
?>

 <!DOCTYPE html>
 <html lang="ko" dir="ltr">
   <head>
     <meta charset="utf-8">
     <link rel="stylesheet" href="../css/qna_list.css">
     <link rel="stylesheet" href="../css/write.css">
     <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
     <script src="//cdn.ckeditor.com/4.11.4/standard/ckeditor.js"></script>
     <script type="text/javascript">
      $(document).ready(function() {

        });
     </script>
     <script type="text/javascript">
     var qna_hidden_num = "";
     var qna_hidden_id = "";
     var qna_hidden_subject = "";
     var qna_hidden_content = "";
     var qna_hidden_date = "";
     $(document).ready(function() {

       var modal = document.getElementById('myModal2');
       $("#modal_write").click(function() {
         $(".modal-content2").html("<h2>QNA 작성</h2>");
         $(".modal-content2").append("<hr>");
         $(".modal-content2").append(" <div id='qna_div'>");
         $("#qna_div").append("<form name='qna_form' id='qna_form' action='qna_query.php?mode=insert' method='post'>");
         $("#qna_form").append("<table id='table1'>");
         $("#table1").append("<tr id='tr1'>");
         $("#tr1").append("<td colspan='2' class='qna_td'>작성자 : "+'<?=$id?>'+"</td>");
         $("#table1").append("</tr>");
         $("#table1").append("<tr id='tr2'>");
         $("#tr2").append("<td colspan='2' class='qna_td'><input type='text' name='qna_subject' id='qna_subjec' placeholder='제목을 입력하세요.'></td>");
         $("#table1").append("</tr>");
         $("#table1").append("<tr id='tr3'>");
         $("#tr3").append("<td colspan='2' class='qna_td'><textarea name='qna_content' rows='15' cols='79'></textarea></td>");
         $("#table1").append("</tr>");
         $("#qna_form").append("<hr>");
         $("#qna_form").append("</table>");
         $("#qna_form").append("<input type='submit' class='button-8' value='Submit'>&nbsp;");
         $("#qna_form").append("<button type='button' class='button-8' name'button'>Close</button>");

         $("#qna_div").append("</form>");
         $(".modal-content2").append("</div>");
         // $("#qna_subjec").css("width","938");


         CKEDITOR.replace('qna_content');

         modal.style.display="block";
       });

       $(document).on('click', '#modal_modify', function() {
         $.ajax({
           url: 'qna_query.php?mode=select_modify',
           type: 'POST',
           data: {qna_num: qna_hidden_num}
         })
         .done(function(result) {
           console.log("success");
           var json_obj = $.parseJSON(result);
           $(".modal-content2").html("<h2>QNA 작성</h2>");
           $(".modal-content2").append("<hr>");
           $(".modal-content2").append(" <div id='qna_div'>");
           $("#qna_div").append("<form name='qna_form' id='qna_form' action='qna_query.php?mode=update' method='post'>");
           $("#qna_form").append("<input type='hidden' name='qna_num' value='"+qna_hidden_num+"'>");
           $("#qna_form").append("<table id='table1'>");
           $("#table1").append("<tr id='tr1'>");
           $("#tr1").append("<td class='qna_td'>작성자</td>");
           $("#tr1").append("<td>"+json_obj[0].qna_id+"</td>");
           $("#table1").append("</tr>");
           $("#table1").append("<tr id='tr2'>");
           $("#tr2").append("<td class='qna_td'>제목</td>");
           $("#tr2").append("<td colspan='3'><input type='text' name='qna_subject' value='"+json_obj[1].qna_subject+"' id='qna_subjec'></td>");
           $("#table1").append("</tr>");
           $("#table1").append("<tr id='tr3'>");
           $("#tr3").append("<td class='qna_td'>내용</td>");
           $("#tr3").append("<td colspan='3'><textarea name='qna_content' rows='15' cols='79'>"+json_obj[2].qna_content+"</textarea></td>");
           $("#table1").append("</tr>");
           $("#qna_form").append("<hr>");
           $("#qna_form").append("</table>");
           $("#qna_form").append("<input type='submit' class='button-8' value='Submit'>&nbsp;");
           $("#qna_form").append("<button type='button' class='button-8' name'button'>Close</button>");

           $("#qna_div").append("</form>");
           $(".modal-content2").append("</div>");
           $("#qna_subjec").css("width","938");


           CKEDITOR.replace('qna_content');

           modal.style.display="block";
         })
         .fail(function() {
           console.log("error");
         })
         .always(function() {
           console.log("complete");
         });

       });

       $(".modal_view").click(function() {
         var ripple_array = new Array();
         var ripple_value = new Array();
         var n = $('.modal_view').index(this);

         qna_hidden_num = $(".qna_hidden_num:eq("+n+")").val();
         qna_hidden_id = $(".qna_hidden_id:eq("+n+")").val();
         qna_hidden_subject = $(".qna_hidden_subject:eq("+n+")").val();
         qna_hidden_content = $(".qna_hidden_content:eq("+n+")").val();
         qna_hidden_date = $(".qna_hidden_date:eq("+n+")").val();

         $.ajax({
           url: './qna_query.php?mode=select_qna',
           type: 'POST',
           data: {qna_hidden_num: qna_hidden_num}
         })
         .done(function(result) {
           console.log("success");
            if(result!=""){
              ripple_array = result.split(",");
              result_length=ripple_array.length;
            }else{
              result_length=0;
            }

            $(".modal-content2").html("<h2>QNA</h2>");
            $(".modal-content2").append("<hr>");
            $(".modal-content2").append(" <div id='notice_div'>");
            $("#notice_div").append("<table id='table1' >");
            $("#table1").append("<tr id='tr1'>");
            $("#tr1").append("<td class='notice_td'>작성자</td>");
            $("#tr1").append("<td>"+qna_hidden_id+"</td>");
            $("#table1").append("</tr>");
            $("#table1").append("<tr id='tr2'>");
            $("#tr2").append("<td class='notice_td'>작성일</td>");
            $("#tr2").append("<td>"+qna_hidden_date+"</td>");
            $("#table1").append("</tr>");
            $("#table1").append("<tr id='tr3'>");
            $("#tr3").append("<td class='notice_td'>제목</td>");
            $("#tr3").append("<td>"+qna_hidden_subject+"</td>");
            $("#table1").append("</tr>");
            $("#table1").append("<tr id='tr4'>");
            $("#tr4").append("<td>내용</td>");
            $("#tr4").append("<td>"+qna_hidden_content+"</td>");
            $("#table1").append("</tr>");
            $("#notice_div").append("</table>");

            $("#notice_div").append("<h3>RIPPLE</h3>");
            $("#notice_div").append("<textarea id='ripple_content' rows='6' cols='140'></textarea>");
            $("#notice_div").append("<input type='button' id='ripple_insert' value='글쓰기'>");
            for(i=0;i<result_length;i++){
              ripple_value = ripple_array[i].split("/");
              var space="";
              for(j=0;j<ripple_value[1];j++){
                  space+="[re]";
              }

              $("#notice_div").append("<table class='ripple_table' id='table1"+i+"'>");

              $("#table1"+i+"").append("<tr id='tr1_"+i+"'>");
              $("#tr1_"+i+"").append("<td class='qna_first_td'>"+space+"작성자 : "+ripple_value[0]+"&nbsp&nbsp&nbsp&nbsp"+ripple_value[2]+"</td>");
              $("#tr1_"+i+"").append("<td >작성일 : "+ripple_value[4]+"</td>");
              $("#tr1_"+i+"").append("<td ><a href='#' class='reply'>답글 |</a><a href='#' onclick='ripple_delete("+ripple_value[1]+","+ripple_value[3]+","+ripple_value[5]+","+ripple_value[6]+");'>삭제</a></td>");
              $("#table1"+i+"").append("</tr>");

              $("#table1"+i+"").append("<tr id='tr2_"+i+"'>");
              $("#tr2_"+i+"").append("<input type='hidden' class='hidden_ripple_num' value='"+ripple_value[3]+"'>");
              $("#tr2_"+i+"").append("<input type='hidden' class='hidden_ripple_parent' value='"+ripple_value[5]+"'>");
              $("#tr2_"+i+"").append("<td colspan='2'><input type='text' name='ripple_content' class='answer' placeholder='댓글'></td>");
              $("#tr2_"+i+"").append("<td><input type='submit' class='answer1' value='글쓰기'></td>");
              $("#table1"+i+"").append("</tr>");
              $("#notice_div").append("</table>");

            }


            if ("<?=$id?>"=="admin" || "<?=$id?>"== qna_hidden_id){
              $("#notice_div").append("<button type='button' class='button-7' id='modal_modify'>수정</button>");
              $("#notice_div").append("<a href='./qna_query.php?mode=delete&qna_num="+qna_hidden_num+"'><button type='button' class='button-8' name'button'>삭제</button></a>");
            }
            $("#notice_div").append("<button type='button' class='button-8' name'button'>닫기</button>");
            $(".modal-content2").append("</div>");

            $("#table1 tr").css("height","60px");
            $("#table1 tr td").css("border-bottom","1px solid black");
            $(".notice_td").css("width","100px");
            $("#notice_div .button-8, .button-7").css("margin-bottom","3%");

            $(".answer").hide();
            $(".answer1").hide();
            $('.reply').click(function(){
              var n = $('.reply').index(this);
              $(".answer:eq("+n+")").val("");
              if($(".answer:eq("+n+")").css('display')=="none"){
                $(".answer").hide();
                 $(".answer1").hide();
                $(".answer:eq("+n+")").show();
                 $(".answer1:eq("+n+")").show();
              }else{
                $(".answer:eq("+n+")").hide();
                $(".answer1:eq("+n+")").hide();
              }
            });
            modal.style.display="block";
         })
         .fail(function() {
           console.log("error");
         })
         .always(function() {
           console.log("complete");
         });

       });

       $(document).on('click', '#ripple_insert', function() {
         var ripple_content = $("#ripple_content").val();

         $.ajax({
           url: './qna_query.php?mode=ripple_insert&qna_num='+qna_hidden_num,
           type: 'POST',
           data: {
             ripple_content: ripple_content
           }
         })
         .done(function(result) {
           console.log("success");

           if(result!=""){
             ripple_array = result.split(",");
             result_length=ripple_array.length;
           }else{
             result_length=0;
           }

           $(".modal-content2").html("<h2>QNA</h2>");
           $(".modal-content2").append("<hr>");
           $(".modal-content2").append(" <div id='notice_div'>");
           $("#notice_div").append("<table id='table1' >");
           $("#table1").append("<tr id='tr1'>");
           $("#tr1").append("<td class='notice_td'>작성자</td>");
           $("#tr1").append("<td>"+qna_hidden_id+"</td>");
           $("#table1").append("</tr>");
           $("#table1").append("<tr id='tr2'>");
           $("#tr2").append("<td class='notice_td'>작성일</td>");
           $("#tr2").append("<td>"+qna_hidden_date+"</td>");
           $("#table1").append("</tr>");
           $("#table1").append("<tr id='tr3'>");
           $("#tr3").append("<td class='notice_td'>제목</td>");
           $("#tr3").append("<td>"+qna_hidden_subject+"</td>");
           $("#table1").append("</tr>");
           $("#table1").append("<tr id='tr4'>");
           $("#tr4").append("<td>내용</td>");
           $("#tr4").append("<td>"+qna_hidden_content+"</td>");
           $("#table1").append("</tr>");
           $("#notice_div").append("<hr>");
           $("#notice_div").append("</table>");

           $("#notice_div").append("<h3>RIPPLE</h3>");
           $("#notice_div").append("<textarea id='ripple_content' rows='6' cols='140'></textarea>");
           $("#notice_div").append("<input type='button' id='ripple_insert' value='글쓰기'>");
           for(i=0;i<result_length;i++){
             ripple_value = ripple_array[i].split("/");
             var space="";
             for(j=0;j<ripple_value[1];j++){
                 space+="[re]";
             }

             $("#notice_div").append("<table class='ripple_table' id='table1"+i+"'>");

             $("#table1"+i+"").append("<tr id='tr1_"+i+"'>");
             $("#tr1_"+i+"").append("<td class='qna_first_td'>"+space+"작성자 : "+ripple_value[0]+"&nbsp&nbsp&nbsp&nbsp"+ripple_value[2]+"</td>");
             $("#tr1_"+i+"").append("<td >작성일 : "+ripple_value[4]+"</td>");
             $("#tr1_"+i+"").append("<td ><a href='#' class='reply'>답글 |</a><a href='#' onclick='ripple_delete("+ripple_value[1]+","+ripple_value[3]+","+ripple_value[5]+","+ripple_value[6]+");'>삭제</a></td>");
             $("#table1"+i+"").append("</tr>");

             $("#table1"+i+"").append("<tr id='tr2_"+i+"'>");
             $("#tr2_"+i+"").append("<input type='hidden' class='hidden_ripple_num' value='"+ripple_value[3]+"'>");
             $("#tr2_"+i+"").append("<input type='hidden' class='hidden_ripple_parent' value='"+ripple_value[5]+"'>");
             $("#tr2_"+i+"").append("<td colspan='2'><input type='text' name='ripple_content' class='answer' placeholder='댓글'></td>");
             $("#tr2_"+i+"").append("<td><input type='submit' class='answer1' value='글쓰기'></td>");
             $("#table1"+i+"").append("</tr>");
             $("#table1"+i+"").append("</tr>");
             $("#notice_div").append("</table>");

           }


           if ("<?=$id?>"=="admin" || "<?=$id?>"== qna_hidden_id){
             $("#notice_div").append("<button type='button' class='button-7' id='modal_modify'>수정</button>");
             $("#notice_div").append("<a href='./qna_query.php?mode=delete&qna_num="+qna_hidden_num+"'><button type='button' class='button-8' name'button'>삭제</button></a>");
           }
           $("#notice_div").append("<button type='button' class='button-8' name'button'>닫기</button>");
           $(".modal-content2").append("</div>");

           $("#table1 tr").css("height","60px");
           $(".notice_td").css("width","100px");

           $(".answer").hide();
           $(".answer1").hide();
           $('.reply').click(function(){
             var n = $('.reply').index(this);
             $(".answer:eq("+n+")").val("");
             if($(".answer:eq("+n+")").css('display')=="none"){
               $(".answer").hide();
                $(".answer1").hide();
               $(".answer:eq("+n+")").show();
                $(".answer1:eq("+n+")").show();
             }else{
               $(".answer:eq("+n+")").hide();
               $(".answer1:eq("+n+")").hide();
             }
           });
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
       window.onclick = function(event) {
         if (event.target == modal) {
           modal.style.display = "none";
         }
       }
     });

     function ripple_delete(depth,num,parent,gno){

       $.ajax({
         url: './qna_query.php?mode=ripple_delete',
         type: 'POST',
         data: {
           ripple_num: num,
           ripple_parent:parent,
           ripple_depth:depth,
           ripple_gno:gno
         }
       })
       .done(function(result) {
         console.log("success");
         if(result!=""){
           ripple_array = result.split(",");
           result_length=ripple_array.length;
         }else{
           result_length=0;
         }

         $(".modal-content2").html("<h2>QNA</h2>");
         $(".modal-content2").append("<hr>");
         $(".modal-content2").append(" <div id='notice_div'>");
         $("#notice_div").append("<table id='table1' >");
         $("#table1").append("<tr id='tr1'>");
         $("#tr1").append("<td class='notice_td'>작성자</td>");
         $("#tr1").append("<td>"+qna_hidden_id+"</td>");
         $("#table1").append("</tr>");
         $("#table1").append("<tr id='tr2'>");
         $("#tr2").append("<td class='notice_td'>작성일</td>");
         $("#tr2").append("<td>"+qna_hidden_date+"</td>");
         $("#table1").append("</tr>");
         $("#table1").append("<tr id='tr3'>");
         $("#tr3").append("<td class='notice_td'>제목</td>");
         $("#tr3").append("<td>"+qna_hidden_subject+"</td>");
         $("#table1").append("</tr>");
         $("#table1").append("<tr id='tr4'>");
         $("#tr4").append("<td>내용</td>");
         $("#tr4").append("<td>"+qna_hidden_content+"</td>");
         $("#table1").append("</tr>");
         $("#notice_div").append("<hr>");
         $("#notice_div").append("</table>");

         $("#notice_div").append("<h3>RIPPLE</h3>");
         $("#notice_div").append("<textarea id='ripple_content' rows='6' cols='140'></textarea>");
         $("#notice_div").append("<input type='button' id='ripple_insert' value='글쓰기'>");
         for(i=0;i<result_length;i++){
           ripple_value = ripple_array[i].split("/");
           var space="";
           for(j=0;j<ripple_value[1];j++){
               space+="[re]";
           }

           $("#notice_div").append("<table class='ripple_table' id='table1"+i+"'>");

           $("#table1"+i+"").append("<tr id='tr1_"+i+"'>");
           $("#tr1_"+i+"").append("<td class='qna_first_td'>"+space+"작성자 : "+ripple_value[0]+"&nbsp&nbsp&nbsp&nbsp"+ripple_value[2]+"</td>");
           $("#tr1_"+i+"").append("<td >작성일 : "+ripple_value[4]+"</td>");
           $("#tr1_"+i+"").append("<td ><a href='#' class='reply'>답글 |</a><a href='#' onclick='ripple_delete("+ripple_value[1]+","+ripple_value[3]+","+ripple_value[5]+","+ripple_value[6]+");'>삭제</a></td>");
           $("#table1"+i+"").append("</tr>");

           $("#table1"+i+"").append("<tr id='tr2_"+i+"'>");
           $("#tr2_"+i+"").append("<input type='hidden' class='hidden_ripple_num' value='"+ripple_value[3]+"'>");
           $("#tr2_"+i+"").append("<input type='hidden' class='hidden_ripple_parent' value='"+ripple_value[5]+"'>");
           $("#tr2_"+i+"").append("<td colspan='2'><input type='text' name='ripplye_content' class='answer' placeholder='댓글'></td>");
           $("#tr2_"+i+"").append("<td><input type='submit' class='answer1' value='글쓰기'></td>");
           $("#table1"+i+"").append("</tr>");

           $("#notice_div").append("</table>");

         }

         if ("<?=$id?>"=="admin" || "<?=$id?>"== qna_hidden_id){
           $("#notice_div").append("<button type='button' class='button-7' id='modal_modify'>수정</button>");
           $("#notice_div").append("<a href='./qna_query.php?mode=delete&qna_num="+qna_hidden_num+"'><button type='button' class='button-8' name'button'>삭제</button></a>");
         }
         $("#notice_div").append("<button type='button' class='button-8' name'button'>닫기</button>");
         $(".modal-content2").append("</div>");

         $("#table1 tr").css("height","60px");
         $(".notice_td").css("width","100px");

         $(".answer").hide();
         $(".answer1").hide();
         $('.reply').click(function(){
           var n = $('.reply').index(this);
           $(".answer:eq("+n+")").val("");
           if($(".answer:eq("+n+")").css('display')=="none"){
             $(".answer").hide();
             $(".answer1").hide();
             $(".answer:eq("+n+")").show();
             $(".answer1:eq("+n+")").show();
           }else{
             $(".answer:eq("+n+")").hide();
             $(".answer1:eq("+n+")").hide();
           }
         });

       })
       .fail(function() {
         console.log("error");
       })
       .always(function() {
         console.log("complete");
       });

     }

     $(document).on('click', '.answer1', function() {
       var n = $('.answer1').index(this);
       insert_ripple_num = $(".hidden_ripple_num:eq("+n+")").val();
       insert_ripple_parent = $(".hidden_ripple_parent:eq("+n+")").val();
       insert_ripple_content = $(".answer:eq("+n+")").val();
       insert_qna_id = '<?=$_SESSION['userid']?>';

       $.ajax({
         url: './qna_query.php?mode=ripple_response',
         type: 'POST',
         data: {
           ripple_content: insert_ripple_content,
           ripple_num:insert_ripple_num,
           ripple_parent:insert_ripple_parent,
           qna_num:qna_hidden_num,
           qna_id:insert_qna_id
         }
       })
       .done(function(result) {
         console.log("success");
         if(result!=""){
           ripple_array = result.split(",");
           result_length=ripple_array.length;
         }else{
           result_length=0;
         }

         $(".modal-content2").html("<h2>QNA</h2>");
         $(".modal-content2").append("<hr>");
         $(".modal-content2").append(" <div id='notice_div'>");
         $("#notice_div").append("<table id='table1' >");
         $("#table1").append("<tr id='tr1'>");
         $("#tr1").append("<td class='notice_td'>작성자</td>");
         $("#tr1").append("<td>"+qna_hidden_id+"</td>");
         $("#table1").append("</tr>");
         $("#table1").append("<tr id='tr2'>");
         $("#tr2").append("<td class='notice_td'>작성일</td>");
         $("#tr2").append("<td>"+qna_hidden_date+"</td>");
         $("#table1").append("</tr>");
         $("#table1").append("<tr id='tr3'>");
         $("#tr3").append("<td class='notice_td'>제목</td>");
         $("#tr3").append("<td>"+qna_hidden_subject+"</td>");
         $("#table1").append("</tr>");
         $("#table1").append("<tr id='tr4'>");
         $("#tr4").append("<td>내용</td>");
         $("#tr4").append("<td>"+qna_hidden_content+"</td>");
         $("#table1").append("</tr>");
         $("#notice_div").append("<hr>");
         $("#notice_div").append("</table>");

         $("#notice_div").append("<h3>RIPPLE</h3>");
         $("#notice_div").append("<textarea id='ripple_content' rows='6' cols='140'></textarea>");
         $("#notice_div").append("<input type='button' id='ripple_insert' value='글쓰기'>");
         for(i=0;i<result_length;i++){
           ripple_value = ripple_array[i].split("/");
           var space="";
           for(j=0;j<ripple_value[1];j++){
               space+="[re]";
           }

           $("#notice_div").append("<table class='ripple_table' id='table1"+i+"'>");

           $("#table1"+i+"").append("<tr id='tr1_"+i+"'>");
           $("#tr1_"+i+"").append("<td class='qna_first_td'>"+space+"작성자 : "+ripple_value[0]+"&nbsp&nbsp&nbsp&nbsp"+ripple_value[2]+"</td>");
           $("#tr1_"+i+"").append("<td >작성일 : "+ripple_value[4]+"</td>");
           $("#tr1_"+i+"").append("<td ><a href='#' class='reply'>답글 |</a><a href='#' onclick='ripple_delete("+ripple_value[1]+","+ripple_value[3]+","+ripple_value[5]+","+ripple_value[6]+");'>삭제</a></td>");
           $("#table1"+i+"").append("</tr>");

           $("#table1"+i+"").append("<tr id='tr2_"+i+"'>");
           $("#tr2_"+i+"").append("<input type='hidden' class='hidden_ripple_num' value='"+ripple_value[3]+"'>");
           $("#tr2_"+i+"").append("<input type='hidden' class='hidden_ripple_parent' value='"+ripple_value[5]+"'>");
           $("#tr2_"+i+"").append("<td colspan='2'><input type='text' name='ripplye_content' class='answer' placeholder='댓글'></td>");
           $("#tr2_"+i+"").append("<td><input type='submit' class='answer1' value='글쓰기'></td>");
           $("#table1"+i+"").append("</tr>");

           $("#notice_div").append("</table>");

         }

         if ("<?=$id?>"=="admin" || "<?=$id?>"== qna_hidden_id){
           $("#notice_div").append("<button type='button' class='button-7' id='modal_modify'>수정</button>");
           $("#notice_div").append("<a href='./qna_query.php?mode=delete&qna_num="+qna_hidden_num+"'><button type='button' class='button-8' name'button'>삭제</button></a>");
         }
         $("#notice_div").append("<button type='button' class='button-8' name'button'>닫기</button>");
         $(".modal-content2").append("</div>");

         $("#table1 tr").css("height","60px");
         $(".notice_td").css("width","100px");

         $(".answer").hide();
         $(".answer1").hide();
         $('.reply').click(function(){
           var n = $('.reply').index(this);
           $(".answer:eq("+n+")").val("");
           if($(".answer:eq("+n+")").css('display')=="none"){
             $(".answer").hide();
             $(".answer1").hide();
             $(".answer:eq("+n+")").show();
             $(".answer1:eq("+n+")").show();
           }else{
             $(".answer:eq("+n+")").hide();
             $(".answer1:eq("+n+")").hide();
           }
         });
       })
       .fail(function() {
         console.log("error");
       })
       .always(function() {
         console.log("complete");
       });


     });
     </script>
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
               $sql="SELECT * from `qna` where $find like '%$q_search%';";
             }else{
               $sql="SELECT * from `qna` order by qna_num desc";
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
     <div id="myModal2" class="modal2">
      <div class="modal-content2">
        <div class="modal-content3">

        </div>
      </div>
    </div>
        <?php include "../lib/menu.php"; ?>
        <div class="qna_list">
          <h1 class="qna_list_h1">QnA</h1>
          <div class="search">
            <form name="qna" action="qna_list.php?mode=search" method="post">
             <!-- ▷ 총 <?=$total_record?>개의 게시물이 있습니다. -->
             <select name="find">
               <option value="qna_subject">제목</option>
               <option value="qna_content">내용</option>
               <option value="qna_id">아이디</option>
             </select>
             <input type="text" name="search">
             <input type="submit" value="검색">
           </form>
         </div>

      <table class="qna_list_table">
        <thead>
          <tr>
             <td id="list_title1" >번호 &nbsp;</td>
             <td id="list_title2" >제목 &nbsp;</td>
             <td id="list_title3" >글쓴이 &nbsp;</td>
             <td id="list_title4" >등록일 &nbsp;</td>
          </tr>
        </thead>


     <?php
     for($i=$start_row; ($i<$start_row+$rows_scale) && ($i< $total_record); $i++){
       mysqli_data_seek($result,$i);
       $row = mysqli_fetch_array($result);
       $qna_num=$row['qna_num'];
       $qna_id=$row['qna_id'];
       $qna_subject=$row['qna_subject'];
       $qna_content=$row['qna_content'];
       $qna_date=substr($row['qna_date'], 0,10);
       ?>
       <input type="hidden" class="qna_hidden_num" value="<?=$qna_num?>">
       <input type="hidden" class="qna_hidden_id" value="<?=$qna_id?>">
       <input type="hidden" class="qna_hidden_subject" value="<?=$qna_subject?>">
       <input type="hidden" class="qna_hidden_content" value="<?=$qna_content?>">
       <input type="hidden" class="qna_hidden_date" value="<?=$qna_date?>">
        <tbody>
        <tr>
           <td id="list_item1"><?=$number?></td>
             <td id="list_item2">
               <?php
               if($_SESSION['userid']==$qna_id||$_SESSION['userid']=='admin') {
                 ?>
               <a class="modal_view"><?=$qna_subject?></a>
               <?php
             }else{
               ?>
               비밀글입니다
               <?php
             }
             ?>
             </td>
           <td id="list_item3"><?=$qna_id?></td>
           <td id="list_item4"><?=$qna_date?></td>

         </tr><!-- end of list_item -->
         </tbody>

         <?php
        $number--;
        }//end of for
          ?>
        </table>
        <div id="button">
          <a href="qna_list.php?page=<?=$page?>">목록</a>

          <?php
              echo '<a id="modal_write">'."글쓰기".'</a>';
            ?>
        </div><!-- end of button -->

            <div class="page_box"><!-- 페이지 표시하는곳 -->
              <!-- 페이지 표시하는 곳 표기 -->
              <?PHP
                #----------------이전블럭 존재시 링크------------------#
                if($start_page > $pages_scale){
                   $go_page= $start_page - $pages_scale;
                   echo "<a id='before_block' href='qna_list.php?page=$go_page'> ◀◀ </a>";
                }
                #----------------이전페이지 존재시 링크------------------#
                if($pre_page){
                    echo "<a id='before_page' href='qna_list.php?page=$pre_page'> ◁ </a>";
                }
                 #--------------바로이동하는 페이지를 나열---------------#
                for($dest_page=$start_page;$dest_page <= $end_page;$dest_page++){
                   if($dest_page == $page){
                        echo( "&nbsp;<b id='present_page'>$dest_page</b>&nbsp" );
                    }else{
                        echo "<a id='move_page' href='qna_list.php?page=$dest_page'>$dest_page</a>";
                    }
                 }
                 #----------------이전페이지 존재시 링크------------------#
                 if($next_page){
                     echo "<a id='next_page' href='qna_list.php?page=$next_page'> ▷ </a>";
                 }
                 #---------------다음페이지를 링크------------------#
                if($total_pages >= $start_page+ $pages_scale){
                  $go_page= $start_page+ $pages_scale;
                  echo "<a id='next_block' href='qna_list.php?page=$go_page'> ▶▶ </a>";
                 }
               ?>
            </div>
       </div>
   </body>
 </html>
