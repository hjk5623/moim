<?php
session_start();
header("Cache-Control: no-store, no-cache, must-revalidate");
include $_SERVER['DOCUMENT_ROOT']."./moim/lib/db_connector.php";


// $userid=$_SESSION['userid'];
//   if(empty($userid)&&$userid!='admin'){
//     echo "<script>alert('로그인해주세요');history.go(-1);</script>";
//     exit;
//   }
    if (isset($_GET["mode"]) && $_GET["mode"]== "insert") {
      $notice_content=trim($_POST["notice_content"]);
      $notice_subject=trim($_POST["notice_subject"]);
      if(empty($notice_content) || empty($notice_subject)){
      echo "<script>alert('제목, 내용을 입력하세요');history.go(-1);</script>";
      exit;
      }
      $userid='admin';
    $q_userid = mysqli_real_escape_string($conn, $userid);

    if(false){//!$_SESSION['userid']=="admin"
      echo "<script>alert('권한이 없습니다');history.go(-1);</script>";
      exit;
    }else{
      $notice_subject = test_input($_POST["notice_subject"]);
      $notice_content = test_input($_POST["notice_content"]);
      $notice_id= test_input($userid);
      $notice_hit= 0;
      }
      $q_subject = mysqli_real_escape_string($conn, $notice_subject);
      $q_content = mysqli_real_escape_string($conn, $notice_content);
      $q_userid = mysqli_real_escape_string($conn, $notice_id);
      $notice_date = date("Y-m-d (H:i)");

      include "../lib/file_upload.php";

      $sql="INSERT INTO `notice` VALUES (null,'$q_userid','$q_subject','$q_content','$notice_date',0,'$upfile_name','$copied_file_name','$upfile_type');";
      $result = mysqli_query($conn,$sql);
    if (!$result) {
      die('Error: ' . mysqli_error($conn));
    }
    $sql = "SELECT notice_num from `notice` where notice_id = '$userid' order by notice_num desc limit 1;";
    $result = mysqli_query($conn,$sql);
    if (!$result) {
      die('Error: ' . mysqli_error($conn));
    }
    $row = mysqli_fetch_array($result);
    $notice_num=$row['notice_num'];
    var_export($notice_num);
    mysqli_close($conn);
    echo "<script>location.href='./notice_view.php?notice_num=$notice_num&notice_hit=$notice_hit';</script>";
  }else if (isset($_GET["mode"]) && $_GET["mode"] == "delete") {//
    $notice_num = test_input($_GET["notice_num"]);
    $q_num = mysqli_real_escape_string($conn,$notice_num);

    $sql="SELECT `notice_file_copied` from `notice` where notice_num = '$q_num';";
    $result = mysqli_query($conn,$sql);
    if (!$result) {

      die('Error: ' . mysqli_error($conn));
      echo "<script>history.go(-1);</script>";
    }
    $row=mysqli_fetch_array($result);
    $notice_file_copied=$row['notice_file_copied'];

    if(!empty($notice_file_copied)){
      unlink("../data/".$notice_file_copied);
    }

    $sql = "DELETE FROM `notice` WHERE notice_num = $q_num";

    $result = mysqli_query($conn,$sql);
    if (!$result) {
      die('Error: ' . mysqli_error($conn));
    }
        mysqli_close($conn);
    echo "<script>location.href='./notice_list.php?page=1';</script>";
  }else if(isset($_GET["mode"]) && $_GET["mode"] == "update"){

    $userid='admin';
  $notice_content=trim($_POST["notice_content"]);
  $notice_subject=trim($_POST["notice_subject"]);
  if(empty($notice_content) || empty($notice_subject)){
  echo "<script>alert('제목, 내용을 입력하세요');history.go(-1);</script>";
  exit;
  }
  $notice_subject = test_input($_POST["notice_subject"]);
  $notice_content = test_input($_POST["notice_content"]);
  $notice_userid= $userid;
  $notice_num= test_input($_POST["notice_num"]);
  $notice_hit= test_input($_POST["notice_hit"]);

  $q_subject = mysqli_real_escape_string($conn, $notice_subject);
  $q_content = mysqli_real_escape_string($conn, $notice_content);
  $q_userid = mysqli_real_escape_string($conn, $notice_userid);
  $q_num = mysqli_real_escape_string($conn, $notice_num);
  $notice_date = date("Y-m-d (H:i)");

  if(isset($_POST['check_image']) && $_POST['check_image'] == '1'){
      $sql = "SELECT `notice_file_copied` from `notice` where notice_num = '$q_num' order by notice_num desc limit 1;";
      $result = mysqli_query($conn,$sql);
      if (!$result) {
        alert_back('Error: ' . mysqli_error($conn));
        // die('Error: ' . mysqli_error($conn));
      }
      $row = mysqli_fetch_array($result);
      $notice_file_copied=$row['notice_file_copied'];

      if(!empty($notice_file_copied)){
        //이미지 정보를 가져오기 위한 함수(width, height, type)
        unlink("../data/".$notice_file_copied);
      }

      $sql="UPDATE `notice`SET `notice_file_name`='',`notice_file_copied`='' WHERE `notice_num` = '$q_num';";
      $result = mysqli_query($conn,$sql);
      if (!$result) {
        die('Error: ' . mysqli_error($conn));
      }
    }

  if(!empty($_FILES['upfile']['name']) && isset($_FILES['upfile']['name'])){
      //include 파일 업로드 기능
      include "../lib/file_upload.php";
      $sql="UPDATE `notice` SET `notice_subject` = '$q_subject', `notice_content` = '$q_content', `notice_date` = '$notice_date', `notice_file_copied` = '$copied_file_name',
       `notice_file_type` = '$upfile_type', `notice_file_name` = '$upfile_name' WHERE `notice_num` = '$q_num';";      $result = mysqli_query($conn,$sql);
      if (!$result) {
        die('Error: ' . mysqli_error($conn));
      }
    }

  //뭐하나 추가

  $result = mysqli_query($conn,$sql);
  if (!$result) {
    die('Error: ' . mysqli_error($conn));
  }
  echo "<script> location.href = './notice_view.php?notice_num=$notice_num&notice_hit=$notice_hit'; </script>";
}else if(isset($_GET["mode"])&&$_GET["mode"]=="download"){
    $notice_num = test_input($_GET["notice_num"]);
    $q_num = mysqli_real_escape_string($conn, $notice_num);
    //등록된사용자가 최근 입력한 다운로드게시판을 보여주기 위하여 num 찾아서 전달하기 위함이다.
    $sql="SELECT * from `notice` where notice_num ='$q_num';";
    $result = mysqli_query($conn,$sql);

    if (!$result) {
      alert_back('Error: 1' . mysqli_error($conn));
      // die('Error: ' . mysqli_error($conn));
    }
    $row=mysqli_fetch_array($result);
    $notice_file_name=$row['notice_file_name'];
    $notice_file_copied=$row['notice_file_copied'];
    $notice_file_type=$row['notice_file_type'];
    mysqli_close($conn);
}
//1. 테이블에서 파일명이 있는지 점검
if(empty($notice_file_copied)){
  alert_back('테이블에 파일명이 존재하지 않습니다');
}
$file_path = "../data/$notice_file_copied";
//2. 서버에 data영역에 실제파일이 있는지 점검
if(file_exists($file_path)){
  $fp = fopen($file_path, "rb"); //$fp 파일핸들값
  //지정된 파일타입일경우
  if($notice_file_type){
    Header("Content-Type: application/x-msdownload");
    Header("Content-Length: ".filesize($file_path));
    Header("Content-Disposition: attachment; filename=$notice_file_name");
    Header("Content-Transfer-Encoding: binary");
    Header("Content-Discription: File Transfer");
    Header("Expirse: 0");
  }else {//지정된파일타입이 아닌경우
    //타입이 알려지지 않았을때 explorer 프로토콜 통신방법
  if(eregi("(MSIE 5.0 | MSIE 5.1 | MSIE 5.5 | MSIE 6.0)",$_SERVER['$HTTP_USER_AGENT'])){
    Header("Content-Type: application/octet-stream");
    Header("Content-Length: ".filesize($file_path));
    Header("Content-Disposition: attachment; filename=$notice_file_name");
    Header("Content-Transfer-Encoding: binary");
    Header("Expirse: 0");
    }else{
      Header("Content-Type: file/unknown");
      Header("Content-Length: ".filesize($file_path));
      Header("Content-Disposition: attachment; filename=$notice_file_name");
      Header("Content-Description: PHP3 Generated Data");
      Header("Expirse: 0");
    }

  }
  fpassthru($fp);
  fclose($fp);
}else{
  alert_back('서버에 실제 파일이 존재하지 않습니다');
}

  // header("Location:p260_score_list.php");

 ?>
