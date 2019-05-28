<?php
session_start();
include $_SERVER['DOCUMENT_ROOT']."/moim/lib/db_connector.php";

if(isset($_GET["club_num"])){
  $club_num= $_GET["club_num"];
}else{
  $club_num= "";
}

$mode= (isset($_GET["mode"])) ? $_GET["mode"] : "";
$name= (isset($_GET["name"]))? $_GET["name"] : "";
$c_ripple_num= (isset($_GET["c_ripple_num"]))? $_GET["c_ripple_num"] : "";
?>
<meta charset="utf-8">
<?php

$content= $q_content = $sql= $result = $userid="";
$userid = $_SESSION['userid'];
if(isset($_GET["mode"]) && $_GET["mode"] == "c_delete"){ // club_open= yes인 모임을 지운다
  //삭제할 게시물의 이미지명,파일명을 가져와서 삭제한다.
  $sql="SELECT `club_file_copied`,`club_image_copied` FROM `club` WHERE club_num ='$club_num';";
  $result= mysqli_query($conn,$sql);
  if (!$result) {
    die('Error: ' . mysqli_error($conn));
  }
  $row= mysqli_fetch_array($result);
  $club_file_copied= $row['club_file_copied'];
  $club_image_copied= $row['club_image_copied'];

  if(!empty($club_file_copied)&&!empty($club_image_copied)){
    unlink("../../admin/data/".$club_file_copied);
    unlink("../../admin/data/".$club_image_copied);
  }

  $sql = "DELETE FROM `club` WHERE club_num='$club_num'";
  $result = mysqli_query($conn,$sql);
  if (!$result) {
    die('Error: ' . mysqli_error($conn));
  }

  $sql = "DELETE FROM `club_ripple` WHERE c_parent_num='$club_num'";
  $result = mysqli_query($conn,$sql);
  if (!$result) {
    die('Error: ' . mysqli_error($conn));
  }

  mysqli_close($conn);
  echo "<script>location.href='ing_list.php';</script>";

}else if(isset($_GET["mode"]) && $_GET["mode"] == "c_insert_ripple"){ //후기 등록하기
  $c_ripple_content = test_input($_POST["c_ripple_content"]);
  if(empty($_POST["c_ripple_content"])){
    echo "<script>alert('내용입력요망!');history.go(-1);</script>";
    exit;
  }
  //해당 페이지의 모임을 구매한 사람만 덧글 달기를 할 수 있음
  $q_userid = mysqli_real_escape_string($conn, $userid);
  $sql="SELECT * FROM buy WHERE buy_club_num='$club_num' AND buy_id='$userid'";
  $result = mysqli_query($conn,$sql);
  if (!$result) {
    die('Error: ' . mysqli_error($conn));
  }
    $row= mysqli_fetch_array($result);
    $buy_id= $row['buy_id'];
    $rowcount = mysqli_num_rows($result);

    if(!$rowcount){
      echo "<script>alert('모임를 구매자만 후기작성이 가능합니다.');history.go(-1);</script>";
      exit;
    }else{
      $sql= "SELECT name FROM membership WHERE id='$buy_id'";
      $result = mysqli_query($conn,$sql);
      $row= mysqli_fetch_array($result);
      $name= $row['name']; //모임 구매자의 이름

      $c_parent_num= test_input($club_num); //후기를 남기려는 모임의 club_num
      $c_ripple_id= test_input($_SESSION["userid"]);
      $c_ripple_name= test_input($name); //모임 구매자의 이름을 $c_ripple_name에 넣어줌
      $c_ripple_content= test_input($_POST["c_ripple_content"]);
      $q_c_ripple_content= mysqli_real_escape_string($conn, $c_ripple_content);
      $c_ripple_date= date("Y-m-d (H:i)");

      //후기를 등록한다.
      $sql="INSERT INTO `club_ripple` VALUES (null,'$c_parent_num','$c_ripple_id','$c_ripple_name','$q_c_ripple_content','$c_ripple_date')";
      $result = mysqli_query($conn,$sql);
      if (!$result) {
        die('Error: ' . mysqli_error($conn));
      }
      mysqli_close($conn);

    }//end of if rowcount
}else if(isset($_GET["mode"]) && $_GET["mode"] == "c_delete_ripple"){ //후기 지우기
  $c_ripple_num = test_input($_GET["c_ripple_num"]);

  $sql = "DELETE FROM `club_ripple` WHERE c_ripple_num='$c_ripple_num'";
  $result = mysqli_query($conn,$sql);
  if (!$result) {
    die('Error: ' . mysqli_error($conn));
  }
}
 ?>
