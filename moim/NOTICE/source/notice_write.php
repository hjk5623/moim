<?php
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
$notice_num=$notice_id=$notice_subject=$notice_content=$notice_date=$notice_hit=$notice_file_name=$notice_file_copyied=$notice_file_type="";

if(isset($_GET["mode"])=='update'){
  $mode="update";
      $notice_num = test_input($_GET["notice_num"]);
      $q_num = mysqli_real_escape_string($conn, $notice_num);

      $sql = "SELECT * from `notice` where notice_num = '$q_num';";
      $result = mysqli_query($conn,$sql);
      if (!$result) {
        alert_back('Error: ' . mysqli_error($conn));
        // die('Error: ' . mysqli_error($conn));
      }
      $row=mysqli_fetch_array($result);
      $notice_id=$row['notice_id'];
      $notice_subject=htmlspecialchars($row['notice_subject']);//스크립트 공격을 방어하기 위해서
      $notice_content= htmlspecialchars($row['notice_content']);
      // $subject=str_replace("\n", "<br>",$subject);
      // $subject=str_replace(" ", "&nbsp;",$subject);
      // $content=str_replace("\n", "<br>",$content);
      // $content=str_replace(" ", "&nbsp;",$content);
      $notice_date=$row['notice_date'];
      $notice_hit=$row['notice_hit'];
      $notice_file_name=$row['notice_file_name'];
      $notice_file_copyied=$row['notice_file_copyied'];
      $notice_file_type=$row['notice_file_type'];
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
<form name="notice_form" action="notice_query.php?mode=<?=$mode?>" method="post" enctype="multipart/form-data">
  <input type="hidden" name="notice_num" value="<?=$notice_num?>">
  <input type="hidden" name="notice_hit" value="<?=$notice_hit?>">
  <table border="1">
    <tr>
      <td>아이디</td>
      <td><?=$notice_id?></td>
      <td>조회 : <?=$notice_hit?></td>
      <td>날짜 : <?=$notice_date?></td>
    </tr>

    <tr>
      <td>제목</td>
      <td colspan="3"><input type="text" name="notice_subject" value="<?=$notice_subject?>"></td>
    </tr>

    <tr>
      <td>내용</td>
      <td colspan="3"><textarea style="resize: none" name="notice_content" rows="15" cols="79"><?=$notice_content?></textarea> </td>
    </tr>
    <tr>
      <td>첨부파일</td>
      <td colspan="2">
        <?php
          if ($mode=="insert") {
            echo '<input type="file" name="upfile">';
          }else{
        ?>
            <input type="file" name="upfile" onclick='document.getElementById("check_image").checked=true;
              document.getElementById("check_image").disabled=true'>
        <?php
        }
        ?>
      </td>
      <td>
        <?php
        if($mode=="update" && !empty($notice_file_name)){
          echo "$notice_file_name 파일이 등록되어 있습니다";
          echo '<input type="checkbox" id="check_image" name="check_image" value="1">삭제</div>';
        }
        ?>
      </td>
    </tr>
    <tr>
      <td colspan="4">
        <input type="submit" onclick="document.getElementById('check_image').disabled=false">&nbsp;
        <a href="./notice_list.php">목록</a>
      </td>
    </tr>
  </table>
</form>
   </body>
 </html>
