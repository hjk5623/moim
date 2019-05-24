<?php
session_start();
header("Cache-Control: no-store, no-cache, must-revalidate");
 ?>

<meta charset="utf-8">
<?php

include $_SERVER['DOCUMENT_ROOT']."./moim/lib/db_connector.php";
include $_SERVER['DOCUMENT_ROOT']."/moim/lib/create_table.php";
$qna_subject = $qna_content = $qna_id = $qna_date = "";
$mode="insert";
// $userid=$_SESSION['userid'];
//   if(empty($userid)&&$userid!='admin'){
//     echo "<script>alert('로그인해주세요');history.go(-1);</script>";
//     exit;
//   }
    if (isset($_GET["mode"]) && $_GET["mode"]== "insert") {
      $qna_content=trim($_POST["qna_content"]);
      $qna_subject=trim($_POST["qna_subject"]);
      if(empty($qna_content) || empty($qna_subject)){
      echo "<script>alert('제목, 내용을 입력하세요');history.go(-1);</script>";
      exit;
      }
      $userid='admin';
    $q_userid = mysqli_real_escape_string($conn, $userid);

    if(false){//!$_SESSION['userid']=="admin"
      echo "<script>alert('권한이 없습니다');history.go(-1);</script>";
      exit;
    }else{

      $qna_subject = test_input($_POST["qna_subject"]);
      $qna_content = test_input($_POST["qna_content"]);
      $qna_id= test_input($userid);
      }
      $q_subject = mysqli_real_escape_string($conn, $qna_subject);
      $q_content = mysqli_real_escape_string($conn, $qna_content);
      $q_userid = mysqli_real_escape_string($conn, $qna_id);
      $qna_date = date("Y-m-d (H:i)");

      include "./lib/file_upload.php";

      $sql="INSERT INTO `qna` VALUES (null,'$q_userid','$q_subject','$q_content','$qna_date');";
      $result = mysqli_query($conn,$sql);
    if (!$result) {
      die('Error: ' . mysqli_error($conn));
    }
    $sql = "SELECT qna_num from `qna` where qna_id = '$userid' order by qna_num desc limit 1;";
    $result = mysqli_query($conn,$sql);
    if (!$result) {
      die('Error: ' . mysqli_error($conn));
    }
    $row = mysqli_fetch_array($result);
    $qna_num=$row['qna_num'];
    var_export($qna_num);
    mysqli_close($conn);
    echo "<script>location.href='./qna_view.php?qna_num=$qna_num';</script>";
  }else if (isset($_GET["mode"]) && $_GET["mode"]== "delete") {
    $qna_num = test_input($_GET["qna_num"]);
    $q_num = mysqli_real_escape_string($conn,$qna_num);

    $sql = "DELETE FROM `qna` WHERE qna_num = $q_num";

    $result = mysqli_query($conn,$sql);
    if (!$result) {
      die('Error: ' . mysqli_error($conn));
    }
        mysqli_close($conn);
    echo "<script>location.href='./qna_list.php?page=1';</script>";
  }else if(isset($_GET["mode"]) && $_GET["mode"] == "update"){
    $userid='admin';
  $qna_content=trim($_POST["qna_content"]);
  $qna_subject=trim($_POST["qna_subject"]);
  if(empty($qna_content) || empty($qna_subject)){
  echo "<script>alert('제목, 내용을 입력하세요');history.go(-1);</script>";
  exit;
  }
  $qna_subject = test_input($_POST["qna_subject"]);
  $qna_content = test_input($_POST["qna_content"]);
  $qna_userid= $userid;
  $qna_num= test_input($_POST["qna_num"]);

  $q_subject = mysqli_real_escape_string($conn, $qna_subject);
  $q_content = mysqli_real_escape_string($conn, $qna_content);
  $q_userid = mysqli_real_escape_string($conn, $qna_userid);
  $q_num = mysqli_real_escape_string($conn, $qna_num);
  $qna_date = date("Y-m-d (H:i)");

        include "./lib/file_upload.php";

  $sql="UPDATE `qna` SET `qna_subject` = '$q_subject', `qna_content` = '$q_content', `qna_date` = '$qna_date' WHERE `qna_num` = '$q_num';";
  //뭐하나 추가

  $result = mysqli_query($conn,$sql);
  if (!$result) {
    die('Error: ' . mysqli_error($conn));
  }
  echo "<script> location.href = './qna_view.php?qna_num=$qna_num'; </script>";
}
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
else if(isset($_GET["mode"])&&$_GET["mode"]=="ripple_insert"){
    $ripple_content = trim($_POST["ripple_content"]);
    if(empty($ripple_content)){
      echo "<script>alert('내용입력요망!');history.go(-1);</script>";
      exit;
    }

      $qna_num = test_input($_GET["qna_num"]);
      $ripple_content = test_input($_POST["ripple_content"]);
      $ripple_id = $_SESSION['userid'];
      $ripple_parent=$qna_num;
      $q_content = mysqli_real_escape_string($conn, $ripple_content);
      $q_ripple_id = mysqli_real_escape_string($conn, $ripple_id);
      $ripple_date=date("Y-m-d (H:i)");

      $ripple_depth=0;
      $ripple_ord=0;


      $sql = "INSERT INTO `ripple` VALUES(null,'$q_ripple_id','$ripple_parent',0,'$ripple_depth','$ripple_ord','$q_content','$ripple_date');";

      $result = mysqli_query($conn,$sql);
      if (!$result) {
        die('Error: ' . mysqli_error($conn));
      }

      $sql = "SELECT max(ripple_num) from ripple;";
      $result = mysqli_query($conn,$sql);
      if (!$result) {
        die('Error: ' . mysqli_error($conn));
      }
      $row=mysqli_fetch_array($result);
      $max_num=$row['max(ripple_num)'];

      $sql = "UPDATE `ripple` SET `ripple_gno` = $max_num WHERE `ripple_num` = $max_num;";
      $result = mysqli_query($conn,$sql);
      if (!$result) {
        die('Error: ' . mysqli_error($conn));
      }



      mysqli_close($conn);
      echo "<script>location.href='./qna_view.php?qna_num=$qna_num';</script>";
  //end of if rowcount

}else if(isset($_GET["mode"])&&$_GET["mode"]=="ripple_delete"){

    $ripple_num = test_input($_GET["ripple_num"]);
    $ripple_parent = test_input($_GET["ripple_parent"]);
    $q_num = mysqli_real_escape_string($conn, $num);

    $sql ="DELETE FROM `ripple` WHERE ripple_num=$ripple_num";
    $result = mysqli_query($conn,$sql);
    if (!$result) {
      die('Error: ' . mysqli_error($conn));
    }



    mysqli_close($conn);
    echo "<script>location.href='./qna_view.php?qna_num=$ripple_parent';</script>";


}
//////////////////////////////////////////////////////////////수정없으니까
else if(isset($_GET["mode"])&&$_GET["mode"]=="update"){
  $num = $_POST["num"];
  $content = trim($_POST["content"]);
  if(empty($content) || empty($subject)){
    echo "<script>alert('내용입력요망!');history.go(-1);</script>";
    exit;
  }
    $subject = test_input($_POST["subject"]);
    $content = test_input($_POST["content"]);
    $userid = test_input($userid);
    $is_html = test_input($_POST['is_html']);
    $num = test_input($num);
    $q_content = mysqli_real_escape_string($conn, $content);
    $q_userid = mysqli_real_escape_string($conn, $userid);
    $q_num = mysqli_real_escape_string($conn, $num);
    $regist_day=date("Y-m-d (H:i)");

    $sql = "UPDATE `qna_board` SET `subject` = '$q_subject', `content` = '$content', `regist_day` = '$regist_day', `is_html` = '$is_html' WHERE `num` = '$q_num';";
    $result = mysqli_query($conn,$sql);
    if (!$result) {
      die('Error: ' . mysqli_error($conn));
    }

    echo "<script>location.href='./view.php?num=$num&hit=$hit';</script>";
}/////////////////////////////////////////////////////////////////////////////
else if(isset($_GET["mode"])&&$_GET["mode"]=="ripple_response"){
  $ripple_content = trim($_POST["ripple_content"]);
  if(empty($ripple_content)){
    echo "<script>alert('내용입력요망!');history.go(-1);</script>";
    exit;
  }
    $ripple_num = test_input($_GET["ripple_num"]);
    $ripple_parent = test_input($_GET["ripple_parent"]);
    $qna_num = test_input($_POST["qna_num"]);
    $qna_id = test_input($_POST["qna_id"]);  //
    $ripple_content = test_input($_POST["ripple_content"]);
    $qna_date = test_input($_POST["qna_date"]); //
    // $ripple_id = test_input($ripple_id);
    $ripple_parent=$qna_num;
    // $ripple_num = test_input($_POST['ripple_num']);
    //$is_html = test_input($_POST['is_html']);
    $q_content = mysqli_real_escape_string($conn, $ripple_content);
    $q_userid = mysqli_real_escape_string($conn, $qna_id);
    $q_num = mysqli_real_escape_string($conn, $ripple_parent);
    $ripple_date=date("Y-m-d (H:i)");

    $sql = "SELECT * from `ripple` where ripple_num = $ripple_num;";
    $result = mysqli_query($conn,$sql);
    if (!$result) {
      die('Error: ' . mysqli_error($conn));
    }
    $row=mysqli_fetch_array($result);
    $ripple_gno = (int)$row['ripple_gno'];
    $ripple_depth = (int)$row['ripple_depth'] +1;
    $ripple_ord = (int)$row['ripple_ord'] +1;

    $sql = "UPDATE `ripple` SET `ripple_ord`=`ripple_ord`+1 WHERE `ripple_gno` = $ripple_gno && `ripple_ord` >= $ripple_ord;";
    $result = mysqli_query($conn,$sql);
    if (!$result) {
      die('Error: ' . mysqli_error($conn));
    }

    $sql = "INSERT INTO `ripple` VALUES(null,'$q_userid','$q_num','$ripple_gno','$ripple_depth','$ripple_ord','$q_content','$ripple_date');";
    $result = mysqli_query($conn,$sql);
    if (!$result) {
      die('Error: ' . mysqli_error($conn));
    }

    $sql = "SELECT max(ripple_num) from ripple;";
    $result = mysqli_query($conn,$sql);
    if (!$result) {
      die('Error: ' . mysqli_error($conn));
    }
    $row=mysqli_fetch_array($result);
    $max_num=$row['max(ripple_num)'];

    echo "<script>location.href='./qna_view.php?qna_num=$qna_num';</script>";
}

mysqli_close($conn);

?>
