<?php
session_start();
include $_SERVER['DOCUMENT_ROOT']."/moim/lib/db_connector.php";

if(isset($_GET["club_num"])){
    $club_num =$_GET['club_num'];
    // 삭제할 게물의 이미지파일명을 가져와 삭제한다.
    $sql="select club_image_copied from club where club_num = $club_num order by club_num desc limit 1;";
    $result = mysqli_query($conn, $sql) or die(mysqli_error($conn));
    $row=mysqli_fetch_array($result);
    $club_image_copied=$row['club_image_copyied'];

    if (!empty($club_image_copied)) {
      $del_file=unlink("../../img/".$club_image_copied);
    }

    $sql="DELETE FROM club WHERE club_num=$club_num";
    $result = mysqli_query($conn, $sql) or die(mysqli_error($conn));

    mysqli_close($conn);
    echo "<script>
      location.href='./list.php';
    </script>";
  }
 ?>
