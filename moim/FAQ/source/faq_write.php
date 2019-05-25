<?php
session_start();
header("Cache-Control: no-store, no-cache, must-revalidate");
include $_SERVER['DOCUMENT_ROOT']."/moim/lib/db_connector.php";
create_table($conn, 'faq');
if(!isset($_SESSION['userid'])){
  echo "<script>alert('권한이 없습니다1');history.go(-1);</script>";
  exit;
}
// $id=$_SESSION['userid'];
$checked="";
$faq_num=$faq_question=$faq_answer=$faq_cetegory="";
$mode="insert";
if(isset($_GET["mode"]) && $_GET["mode"] =='update'){
  $mode="update";
      $faq_num = test_input($_GET["faq_num"]);
      $q_num = mysqli_real_escape_string($conn, $faq_num);

      $sql = "SELECT * from `faq` where faq_num = '$q_num';";
      $result = mysqli_query($conn,$sql);
      if (!$result) {
        alert_back('Error: ' . mysqli_error($conn));
        // die('Error: ' . mysqli_error($conn));
      }
      $row=mysqli_fetch_array($result);
      $faq_num=$row['faq_num'];
      $faq_question=htmlspecialchars($row['faq_question']);//스크립트 공격을 방어하기 위해서
      $faq_answer= htmlspecialchars($row['faq_answer']);
      $faq_cetegory=$row['faq_cetegory'];
      // $subject=str_replace("\n", "<br>",$subject);
      // $subject=str_replace(" ", "&nbsp;",$subject);
      // $content=str_replace("\n", "<br>",$content);
      // $content=str_replace(" ", "&nbsp;",$content);
      // $qna_date=$row['qna_date'];
      mysqli_close($conn);
}
?>
 <!DOCTYPE html>
 <html lang="ko" dir="ltr">
   <head>
     <meta charset="utf-8">
     <title>글쓰기</title>
   </head>
   <body>
<form name="faq_form" action="faq_query.php?mode=<?=$mode?>" method="post">
  <input type="hidden" name="faq_num" value="<?=$faq_num?>">
  <table border="1">
    <tr>
      <td><?=$faq_num?></td>
      <td><input type="text" name="faq_cetegory" placeholder="카테고리" autocomplete="off"></td>
      <td><input type="text" name="faq_question" placeholder="질문입력" autocomplete="off"></td>
    </tr>

    <tr>
      <td colspan="3"><input type="text" name="faq_answer" placeholder="답변입력" autocomplete="off"></td>
    </tr>

    <tr>
      <td colspan="4">
        <input type="submit" value="글쓰기">&nbsp;
        <a href="./faq_list.php">목록</a>
      </td>
    </tr>
  </table>
</form>
   </body>
 </html>
