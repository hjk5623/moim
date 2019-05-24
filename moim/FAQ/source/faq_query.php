<?php
// session_start();
 ?>

<meta charset="utf-8">
<?php
header("Cache-Control: no-store, no-cache, must-revalidate");
include $_SERVER['DOCUMENT_ROOT']."./moim/lib/db_connector.php";
$faq_num = $faq_question = $faq_answer = $faq_cetegory = "";
$mode="insert";
// $userid=$_SESSION['userid'];
//   if(empty($userid)&&$userid!='admin'){
//     echo "<script>alert('로그인해주세요');history.go(-1);</script>";
//     exit;
//   }
    if (isset($_GET["mode"]) && $_GET["mode"]== "insert") {
      $faq_question=trim($_POST["faq_question"]);
      $faq_answer=trim($_POST["faq_answer"]);
      if(empty($faq_question) || empty($faq_answer)){
      echo "<script>alert('제목, 내용을 입력하세요');history.go(-1);</script>";
      exit;
      }
      $userid='admin';
    $q_userid = mysqli_real_escape_string($conn, $userid);

    if(false){//!$_SESSION['userid']=="admin"
      echo "<script>alert('권한이 없습니다');history.go(-1);</script>";
      exit;
    }else{

      $faq_num = test_input($_POST["faq_num"]);
      $faq_question = test_input($_POST["faq_question"]);
      $faq_answer = test_input($_POST["faq_answer"]);
      $faq_cetegory= test_input($_POST["faq_cetegory"]);
      }
      $q_question = mysqli_real_escape_string($conn, $faq_question);
      $q_answer = mysqli_real_escape_string($conn, $faq_answer);
      $q_cetegory = mysqli_real_escape_string($conn, $faq_cetegory);


      $sql="INSERT INTO `faq` VALUES (null,'$q_question','$q_answer','$q_cetegory');";
      $result = mysqli_query($conn,$sql);
    if (!$result) {
      die('Error: ' . mysqli_error($conn));
    }
    $sql = "SELECT faq_num from `faq` where faq_num = 'faq_num' order by faq_num desc limit 1;";
    $result = mysqli_query($conn,$sql);
    if (!$result) {
      die('Error: ' . mysqli_error($conn));
    }
    $row = mysqli_fetch_array($result);
    $faq_num=$row['faq_num'];
    var_export($faq_num);
    mysqli_close($conn);
    echo "<script>location.href='./faq_list.php?faq_num=$faq_num';</script>";
  }else if (isset($_GET["mode"]) && $_GET["mode"]== "delete") {//
    $faq_num = test_input($_GET["faq_num"]);
    $q_num = mysqli_real_escape_string($conn,$faq_num);

    $sql = "DELETE FROM `faq` WHERE faq_num = $q_num";

    $result = mysqli_query($conn,$sql);
    if (!$result) {
      die('Error: ' . mysqli_error($conn));
    }
        mysqli_close($conn);
    echo "<script>location.href='./faq_list.php?page=1';</script>";
  }else if(isset($_GET["mode"]) && $_GET["mode"] == "update"){
    $faq_question=trim($_POST["faq_question"]);
    $faq_answer=trim($_POST["faq_answer"]);
  if(empty($faq_question) || empty($faq_answer)){
  echo "<script>alert('제목, 내용을 입력하세요');history.go(-1);</script>";
  exit;
  }
  $faq_num = test_input($_POST["faq_num"]);
  $faq_question = test_input($_POST["faq_question"]);
  $faq_answer = test_input($_POST["faq_answer"]);
  $faq_cetegory= test_input($_POST["faq_cetegory"]);

  $q_question = mysqli_real_escape_string($conn, $faq_question);
  $q_answer = mysqli_real_escape_string($conn, $faq_answer);
  $q_cetegory = mysqli_real_escape_string($conn, $faq_cetegory);
  $q_num = mysqli_real_escape_string($conn, $faq_num);


  $sql="UPDATE `faq` SET `faq_question` = '$q_question', `faq_answer` = '$q_answer', `faq_cetegory` = '$q_cetegory' WHERE `faq_num` = '$q_num';";
  //뭐하나 추가

  $result = mysqli_query($conn,$sql);
  if (!$result) {
    die('Error: ' . mysqli_error($conn));
  }
  echo "<script> location.href = './faq_list.php?page=1'; </script>";
}
  // header("Location:p260_score_list.php");

 ?>
