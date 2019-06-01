<?php
session_start();
if(!isset($_SESSION['userid'])){
  echo "<script>alert('권한이 없습니다');
  window.close();
  </script>";
  exit;
}
header("Cache-Control: no-store, no-cache, must-revalidate");
include $_SERVER['DOCUMENT_ROOT']."./moim/lib/db_connector.php";
include $_SERVER['DOCUMENT_ROOT']."/moim/lib/create_table.php";
include "../lib/memo_func.php";
$qna_num = test_input($_GET["qna_num"]);
define('SCALE', 5);
$sql=$result=$total_record=$total_page=$start=$row=$memo_id=$memo_num=$memo_date=$memo_nick=$memo_content=$ripple_depth="";

$sql="SELECT * from `ripple` where ripple_parent = '$qna_num' order by ripple_gno desc, ripple_ord asc";
$result1 = mysqli_query($conn,$sql);
$total_record = mysqli_num_rows($result1);   //총 레코드 수
$total_page=($total_record % SCALE == 0)?(floor($total_record/SCALE)):(floor($total_record/SCALE)+1);//(ceil($total_record/SCALE));도 가능
if(empty($_GET['page'])){
  $page=1;
}else{
  $page=$_GET['page'];
}
$start=($page-1)*SCALE;
$number=$total_record-$start;

//***************************************
if(isset($_GET["qna_num"])&&!empty($_GET["qna_num"])){
      $qna_num = test_input($_GET["qna_num"]);
      // $hit = test_input($_GET["hit"]);
      $q_num = mysqli_real_escape_string($conn, $qna_num);

      // $sql="UPDATE `concert_board`SET `hit` = $hit WHERE `num`=$q_num;";
      $result = mysqli_query($conn,$sql);
      if (!$result) {
        die('Error: ' . mysqli_error($conn));
      }

      $sql = "SELECT * from `qna` where qna_num = '$q_num';";
      $result = mysqli_query($conn,$sql);
      if (!$result) {
        die('Error: ' . mysqli_error($conn));
      }
      $row=mysqli_fetch_array($result);
      $qna_num=$row['qna_num'];
      $qna_id=$row['qna_id'];
      $qna_subject=htmlspecialchars($row['qna_subject']);//스크립트 오류를 방어하기 위해서
      $qna_content= htmlspecialchars($row['qna_content']);
      // $subject=str_replace("\n", "<br>",$subject);
      // $subject=str_replace(" ", "&nbsp;",$subject);
      // $content=str_replace("\n", "<br>",$content);
      // $content=str_replace(" ", "&nbsp;",$content);

      $qna_date=$row['qna_date'];

  //end of if rowcount

}
//***************************************

?>
<!DOCTYPE html>
<html lang="ko" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
    <script type="text/javascript">
     $(document).ready(function() {
         $(".answer").hide();
         $(".answer1").hide();
         $('.reply').click(function(){
           var n = $('.reply').index(this);
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
       });
    </script>
  </head>
  <body>

<table border="1px">

  <tr>
    <td>아이디</td>
    <td><?=$qna_id?></td>
    <td>날짜 : <?=$qna_date?></td>
  </tr>
  <tr>
    <td>제목</td>
    <td colspan="3"><?=$qna_subject?></td>
  </tr>
  <tr>
    <td>내용</td>
    <td colspan="3">
        <?=$qna_content?>

        </td>
  </tr>
</table>

           <div id="write_button">

             <a href="./qna_list.php?page=<?=$page?>"> 목록 </a>

             <?php
             //관리자이거나 작성자일경우 수정과 삭제가 가능하도록 설정
                // if($_SESSION['userid']=="admin" || $_SESSION['userid']==$id){
                  echo '<a href="./qna_write.php?mode=update&qna_num='.$qna_num.'">수정&nbsp;</a>';
                  echo '<a href="./qna_query.php?mode=delete&qna_num='.$qna_num.'">삭제&nbsp;</a>';
                // }아직 세션이 없음

                //로그인한 유저에게 글쓰기 기능을 부여함
                // if (!empty($_SESSION['userid'])&&$_SESSION['userid']=='admin') {
                // echo "<a href='qna_write.php?mode=update&qna_num=$qna_num'>수정</a>";
                // }
              ?>
           </div><!--end of write_button  -->


           <!-- 댓글 텍스트필드 -->
           <!-- <table id="memo_text" style="border:1">
             <form name="memo_form" action="qna_query.php?mode=memo" method="post">
               <tr id="memo_writer">
                 <td>▷ ?=$_SESSION['userid']?> </td>
               </tr>
               <tr>
                 <td><textarea name="ripple_content" rows="6" cols="95"></textarea></td>
                 <td><input type="submit" name="" value="등록"> </td>
               </tr>
               </form>
           </table> -->
<!-- ㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡ -->
            <table action="qna_query.php?mode=memo" method="post">
              <form class="" action="qna_query.php?mode=ripple_insert&qna_num=<?=$qna_num?>" method="post">
                <tr>
                  <td>▷<?=$_SESSION['userid']?> </td>
                </tr>
                <tr>
                  <td><textarea name="ripple_content" rows="6" cols="95"></textarea></td>
                  <td><input type="submit" name="" value="글쓰기"> </td>
                </tr>
              </form>
            </table>
           <?php
           for($i = $start; $i < $start+SCALE && $i < $total_record;$i++){
             mysqli_data_seek($result1,$i);
             $ripple_row = mysqli_fetch_array($result1);
             ?>
             <table border="1"><!-- 테이블 칸맞추기 -->
               <tr>
                 <!-- <form name="ripple_form" action="qna_query.php?mode=ripple_insert" method="post">
                    <input type="hidden" name="gno" value="?=$qna_num?>">
                    <input type="hidden" name="page" value="?=$page?>">
                    <td><textarea name="ripple_content" rows="3" cols="80"></textarea></td>
                    <td><input type="submit" name="" value="등록"></td> -->
                 </form>
               </tr>
               <?php
                   $ripple_num = $ripple_row['ripple_num'];
                   $ripple_id = $ripple_row['ripple_id'];
                   $ripple_parent=$ripple_row['ripple_parent'];
                   $ripple_date=$ripple_row['ripple_date'];
                   $ripple_content = $ripple_row['ripple_content'];
                   $ripple_content = str_replace("\n", "<br>", $ripple_content);
                   $ripple_content = str_replace(" ", "&nbsp;", $ripple_content);
                   $ripple_gno = $ripple_row['ripple_gno'];
                   $ripple_ord = $ripple_row['ripple_ord'];
                   $ripple_depth=$ripple_row['ripple_depth'];
                   $ripple_gno=$ripple_row['ripple_gno'];
                   $space="";//depth의 앞 공간을 띄워주는 역할
                    for ($j=0; $j <$ripple_depth ; $j++) {
                      $space="[re]".$space;
                    }
                  ?>
                <tr>
                  <th><?=$number?></th>
                  <th><?=$ripple_id?></th><!-- 세션아이디...아마도 -->
                  <th><?=$qna_date?></th>
                </tr>
                <tr>
                  <td colspan="1"><?=$space.$ripple_content?></td>
                  <td><a href="./qna_query.php?mode=ripple_delete&ripple_num=<?=$ripple_num?>&ripple_parent=<?=$ripple_parent?>&ripple_depth=<?=$ripple_depth?>&ripple_gno=<?=$ripple_gno?>">삭제</a></td>
                  <td><a href="#" class="reply">답글</a><tr>
                    <form class="" action="./qna_query.php?mode=ripple_response&ripple_num=<?=$ripple_num?>&ripple_parent=<?=$ripple_parent?>" method="post">
                      <input type="hidden" name="qna_id" value="<?=$qna_id?>">
                      <input type="hidden" name="qna_num" value="<?=$qna_num?>">
                      <input type="hidden" name="qna_date" value="<?=$qna_date?>">
                      <td colspan="2"><input type="text" name="ripple_content" class="answer" placeholder="댓글"></td>
                      <td><input type="submit" class="answer1" value="글쓰기"> </td>
                    </form>
                  </tr> </td>
                </tr>
                <?php
              $number--;
            }
                 ?>
             </table>

             <div id="page_num">◀ 이전 &nbsp;&nbsp;&nbsp;&nbsp;
                    <?php
                    for($i=1;$i<=$total_page;$i++){
                      if($page==$i){
                        echo "<b>&nbsp;$i&nbsp;</b>";
                      }else{
                        echo "<a href='./qna_view.php?page=$i&qna_num=$q_num'>&nbsp;$i&nbsp;</a>";
                      }
                    }
                     ?>
                        &nbsp;&nbsp;&nbsp;&nbsp; 다음 ▶
                        <br><br><br><br><br><br><br><br>
                  </div>



  </body>
</html>
 <!-- fieldset -->
