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


if(empty($_GET['page'])){
  $page=1;
} else{
  $page = $_GET['page'];
}
//***************************************
if(isset($_GET["notice_num"])&&!empty($_GET["notice_num"])){
      $notice_num = test_input($_GET["notice_num"]);
      $notice_hit = test_input($_GET["notice_hit"]);
      $q_num = mysqli_real_escape_string($conn, $notice_num);

      $sql="UPDATE `notice` SET `notice_hit` = $notice_hit WHERE `notice_num`=$q_num;";

      $result = mysqli_query($conn,$sql);
      if (!$result) {
        die('Error: ' . mysqli_error($conn));
      }

      $sql = "SELECT * from `notice` where `notice_num` = '$q_num';";

      $result = mysqli_query($conn,$sql);
      if (!$result) {
        die('Error: ' . mysqli_error($conn));
      }
      $row=mysqli_fetch_array($result);
      $notice_num=$row['notice_num'];
      $notice_id=$row['notice_id'];
      $notice_hit=$row['notice_hit'];
      $notice_subject=htmlspecialchars($row['notice_subject']);//스크립트 오류를 방어하기 위해서
      $notice_content= htmlspecialchars($row['notice_content']);
      // $subject=str_replace("\n", "<br>",$subject);
      // $subject=str_replace(" ", "&nbsp;",$subject);
      // $content=str_replace("\n", "<br>",$content);
      // $content=str_replace(" ", "&nbsp;",$content);
      $notice_file_name=$row['notice_file_name'];
      $notice_file_copyied=$row['notice_file_copyied'];

      $notice_date=$row['notice_date'];

      //숫자 0, "", '0', null $a = array() 다 비어있음
      if(!empty($notice_file_copyied)){
        //이미지 정보를 가져오기 위한 함수(width, height, type)
        $image_info = getimagesize("../data/".$notice_file_copyied);
        $image_width = $image_info[0];
        $image_height = $image_info[1];
        $image_type = $image_info[2];
        if($image_width>400)$image_width=400;
      }else{
        $image_info = "";
        $image_width = 0;
        $image_height = 0;
        $image_type = "";
      }
      mysqli_close($conn);

  //end of if rowcount

}
//***************************************
?>
<!DOCTYPE html>
<html lang="ko" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="Cache-Control" content="no-cache">
    <meta http-equiv="Pragma" content="no-cache">
    <script type="text/javascript" src="../lib/member_form.js"></script>
    <title></title>
  </head>
  <body>

<table border="1px">

  <tr>
    <td>아이디</td>
    <td><?=$notice_id?></td>
    <td>조회 : <?=$notice_hit?></td>
    <td>날짜 : <?=$notice_date?></td>
  </tr>
  <tr>
    <td>제목</td>
    <td colspan="3"><?=$notice_subject?></td>
  </tr>
  <tr>
    <td>내용</td>
    <td colspan="3"><?php
    if(!empty($notice_file_copyied)){
      $file_path = "../data/".$notice_file_copyied;
      $file_size = filesize($file_path);

      //2. 업로드된 이름을 보여주고 [저장] 할것인지 선택하게한다.
        echo ("
          ▷첨부파일 : $notice_file_name &nbsp; ($file_size Byte)
          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
          <a href='notice_query.php?mode=download&notice_num=$q_num'>저장</a><br><br><br>
        ");
        ?>
        <?=$notice_content?>
        <?php
      }else{
        ?>
        <?=$notice_content?>
        <?php
      }
    ?></td>
  </tr>
</table>

           <div id="write_button">
             <a href="./notice_list.php?page=<?=$page?>"> 목록 </a>
             <?php
             //관리자이거나 작성자일경우 수정과 삭제가 가능하도록 설정
                // if($_SESSION['userid']=="admin" || $_SESSION['userid']==$id){

                // }아직 세션이 없음

                //로그인한 유저에게 글쓰기 기능을 부여함
                // if (!empty($_SESSION['userid'])&&$_SESSION['userid']=='admin') {
                echo "<a href='notice_write.php?mode=update&notice_num=$notice_num'>수정</a>&nbsp";
                echo "<a href='notice_query.php?mode=delete&notice_num=$notice_num'>삭제</a>";
                // }
              ?>
           </div><!--end of write_button  -->
  </body>
</html>
 <!-- fieldset -->
