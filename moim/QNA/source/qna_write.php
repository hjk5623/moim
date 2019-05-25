<?php
session_start();
header("Cache-Control: no-store, no-cache, must-revalidate");
include $_SERVER['DOCUMENT_ROOT']."./moim/lib/db_connector.php";
include $_SERVER['DOCUMENT_ROOT']."/moim/lib/create_table.php";
if(!isset($_SESSION['userid'])){
  echo "<script>alert('권한이 없습니다');
  window.close();
  </script>";
  exit;
}
$mode="insert";
// $id=$_SESSION['userid'];
$checked="";
$qna_num=$qna_id=$qna_subject=$qna_content=$qna_date="";

if(isset($_GET["mode"])=='update'){
  $mode="update";
      $qna_num = test_input($_GET["qna_num"]);
      $q_num = mysqli_real_escape_string($conn, $qna_num);

      $sql = "SELECT * from `qna` where qna_num = '$q_num';";
      $result = mysqli_query($conn,$sql);
      if (!$result) {
        alert_back('Error: ' . mysqli_error($conn));
        // die('Error: ' . mysqli_error($conn));
      }
      $row=mysqli_fetch_array($result);
      $qna_id=$row['qna_id'];
      $qna_subject=htmlspecialchars($row['qna_subject']);//스크립트 공격을 방어하기 위해서
      $qna_content= htmlspecialchars($row['qna_content']);
      // $subject=str_replace("\n", "<br>",$subject);
      // $subject=str_replace(" ", "&nbsp;",$subject);
      // $content=str_replace("\n", "<br>",$content);
      // $content=str_replace(" ", "&nbsp;",$content);
      $qna_date=$row['qna_date'];
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
<form name="qna_form" action="qna_query.php?mode=<?=$mode?>" method="post">
  <input type="hidden" name="qna_num" value="<?=$qna_num?>">
  <table border="1">
    <tr>
      <td>아이디</td>
      <td><?=$qna_id?></td>
      <td>날짜 : <?=$qna_date?></td>
    </tr>

    <tr>
      <td>제목</td>
      <td colspan="3"><input type="text" name="qna_subject" value="<?=$qna_subject?>"></td>
    </tr>

    <tr>
      <td>내용</td>
      <td colspan="3"><textarea style="resize: none" name="qna_content" rows="15" cols="79"><?=$qna_content?></textarea> </td>
    </tr>

    <tr>
      <td colspan="4">
        <input type="submit" value="글쓰기">&nbsp;
        <a href="./qna_list.php">목록</a>
      </td>
    </tr>
  </table>
</form>
   </body>
 </html>
